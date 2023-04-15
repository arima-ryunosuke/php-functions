<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/array_keys_exist.php';
require_once __DIR__ . '/../array/array_unset.php';
require_once __DIR__ . '/../strings/quoteexplode.php';
// @codeCoverageIgnoreEnd

/**
 * コマンドライン引数をパースして引数とオプションを返す
 *
 * 少しリッチな {@link http://php.net/manual/function.getopt.php getopt} として使える（shell 由来のオプション構文(a:b::)はどうも馴染みにくい）。
 * ただし「値が必須なオプション」はサポートしない。
 * もっとも、オプションとして空文字が来ることはほぼ無いのでデフォルト値を空文字にすることで対応可能。
 *
 * $rule に従って `--noval filename --opt optval` のような文字列・配列をパースする。
 * $rule 配列の仕様は下記。
 *
 * - キーは「オプション名」を指定する。ただし・・・
 *     - 数値キーは「引数」を意味する
 *     - スペースの後に「ショート名」を与えられる
 * - 値は「デフォルト値」を指定する。ただし・・・
 *     - `[]` は「複数値オプション」を意味する（配列にしない限り同オプションの多重指定は許されない）
 *     - `null` は「値なしオプション」を意味する（スイッチングオプション）
 * - 空文字キーは解釈自体のオプションを与える
 *     - 今のところ throw のみの実装。配列ではなく bool を与えられる
 *
 * 上記の仕様でパースして「引数は数値連番、オプションはオプション名をキーとした配列」を返す。
 * なお、いわゆる「引数」はどこに来ても良い（前オプション、後オプションの区別がない）。
 *
 * $argv には配列や文字列が与えられるが、ほとんどテスト用に近く、普通は未指定で $argv を使うはず。
 *
 * Example:
 * ```php
 * // いくつか織り交ぜたスタンダードな例
 * $rule = [
 *     'opt'       => 'def',    // 基本的には「デフォルト値」を表す
 *     'longopt l' => '',       // スペース区切りで「ショート名」を意味する
 *     1           => 'defarg', // 数値キーは「引数」を意味する
 * ];
 * that(arguments($rule, '--opt optval arg1 -l longval'))->isSame([
 *     'opt'     => 'optval',  // optval と指定している
 *     'longopt' => 'longval', // ショート名指定でも本来の名前で返ってくる
 *     'arg1',   // いわゆるコマンドライン引数（optval は opt に飲まれるので含まれない）
 *     'defarg', // いわゆるコマンドライン引数（与えられていないが、ルールの 1 => 'defarg' が活きている）
 * ]);
 *
 * // 「値なしオプション」と「複数値オプション」の例
 * $rule = [
 *     'noval1 l'  => null, // null は「値なしオプション」を意味する（指定されていれば true されていなければ false を返す）
 *     'noval2 m'  => null, // 同上
 *     'noval3 n'  => null, // 同上
 *     'opts o' => [],      // 配列を与えると「複数値オプション」を表す
 * ];
 * that(arguments($rule, '--opts o1 -ln arg1 -o o2 arg2 --opts o3'))->isSame([
 *     'noval1' => true,  // -ln で同時指定されているので true
 *     'noval2' => false, // -ln で同時指定されてないので false
 *     'noval3' => true,  // -ln の同時指定されているので true
 *     'opts'   => ['o1', 'o2', 'o3'], // ロング、ショート混在でも OK
 *     'arg1', // 一見 -ln のオプション値に見えるが、 noval は値なしなので引数として得られる
 *     'arg2', // 前オプション、後オプションの区別はないのでどこに居ようと引数として得られる
 * ]);
 *
 * // 空文字で解釈自体のオプションを与える
 * $rule = [
 *     ''  => false, // 定義されていないオプションが来ても例外を投げずに引数として処理する
 * ];
 * that(arguments($rule, '--long A -short B'))->isSame([
 *     '--long', // 明らかにオプション指定に見えるが、 long というオプションは定義されていないので引数として解釈される
 *     'A',      // 同上。long のオプション値に見えるが、ただの引数
 *     '-short', // 同上。short というオプションは定義されていない
 *     'B',      // 同上。short のオプション値に見えるが、ただの引数
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\info
 *
 * @param array $rule オプションルール
 * @param array|string|null $argv パースするコマンドライン引数。未指定時は $argv が使用される
 * @return array コマンドライン引数＋オプション
 */
function arguments($rule, $argv = null)
{
    $opt = array_unset($rule, '', []);
    if (is_bool($opt)) {
        $opt = ['thrown' => $opt];
    }
    $opt += [
        'thrown' => true,
    ];

    if ($argv === null) {
        $argv = array_slice($_SERVER['argv'], 1); // @codeCoverageIgnore
    }
    if (is_string($argv)) {
        $argv = quoteexplode([" ", "\t"], $argv);
        $argv = array_filter($argv, 'strlen');
    }
    $argv = array_values($argv);

    $shortmap = [];
    $argsdefaults = [];
    $optsdefaults = [];
    foreach ($rule as $name => $default) {
        if (is_int($name)) {
            $argsdefaults[$name] = $default;
            continue;
        }
        [$longname, $shortname] = preg_split('#\s+#u', $name, -1, PREG_SPLIT_NO_EMPTY) + [1 => ''];
        if (strlen($shortname)) {
            if (array_key_exists($shortname, $shortmap)) {
                throw new \InvalidArgumentException("duplicated short option name '$shortname'");
            }
            $shortmap[$shortname] = $longname;
        }
        if (array_key_exists($longname, $optsdefaults)) {
            throw new \InvalidArgumentException("duplicated option name '$shortname'");
        }
        $optsdefaults[$longname] = $default;
    }

    $n = 0;
    $already = [];
    $result = array_map(fn($v) => $v === null ? false : $v, $optsdefaults);
    while (($token = array_shift($argv)) !== null) {
        if (strlen($token) >= 2 && $token[0] === '-') {
            if ($token[1] === '-') {
                $optname = substr($token, 2);
                if (!$opt['thrown'] && !array_key_exists($optname, $optsdefaults)) {
                    $result[$n++] = $token;
                    continue;
                }
            }
            else {
                $shortname = substr($token, 1);
                if (!$opt['thrown'] && !array_keys_exist(str_split($shortname, 1), $shortmap)) {
                    $result[$n++] = $token;
                    continue;
                }
                if (strlen($shortname) > 1) {
                    array_unshift($argv, '-' . substr($shortname, 1));
                    $shortname = substr($shortname, 0, 1);
                }
                if (!isset($shortmap[$shortname])) {
                    throw new \InvalidArgumentException("undefined short option name '$shortname'.");
                }
                $optname = $shortmap[$shortname];
            }

            if (!array_key_exists($optname, $optsdefaults)) {
                throw new \InvalidArgumentException("undefined option name '$optname'.");
            }
            if (isset($already[$optname]) && !is_array($result[$optname])) {
                throw new \InvalidArgumentException("'$optname' is specified already.");
            }
            $already[$optname] = true;

            if ($optsdefaults[$optname] === null) {
                $result[$optname] = true;
            }
            else {
                if (!isset($argv[0]) || strpos($argv[0], '-') === 0) {
                    throw new \InvalidArgumentException("'$optname' requires value.");
                }
                if (is_array($result[$optname])) {
                    $result[$optname][] = array_shift($argv);
                }
                else {
                    $result[$optname] = array_shift($argv);
                }
            }
        }
        else {
            $result[$n++] = $token;
        }
    }

    array_walk_recursive($result, function (&$v) {
        if (is_string($v)) {
            $v = trim(str_replace('\\"', '"', $v), '"');
        }
    });
    return $result + $argsdefaults;
}

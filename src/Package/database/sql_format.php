<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../pcre/preg_replaces.php';
require_once __DIR__ . '/../random/unique_string.php';
require_once __DIR__ . '/../syntax/throws.php';
require_once __DIR__ . '/../constants.php';
// @codeCoverageIgnoreEnd

/**
 * ものすごく雑に SQL を整形する
 *
 * 非常に荒くアドホックに実装しているのでこの関数で得られた SQL を**実際に実行してはならない**。
 * あくまでログ出力やデバッグ用途で視認性を高める目的である。
 *
 * JOIN 句は FROM 句とみなさず、別句として処理する。
 * AND と && は微妙に処理が異なる。 AND は改行されるが && は改行されない（OR と || も同様）。
 *
 * @package ryunosuke\Functions\Package\database
 *
 * @param string $sql 整形する SQL
 * @param array $options 整形オプション
 * @return string 整形された SQL
 */
function sql_format($sql, $options = [])
{
    static $keywords;
    $keywords ??= array_flip(KEYWORDS);

    $options += [
        // インデント文字
        'indent'    => "  ",
        // インラインレベル
        'inline'    => 999,
        // 括弧の展開レベル
        'nestlevel' => 1,
        // キーワードの大文字/小文字可変換（true だと大文字化。false だと小文字化。あるいは 'ucfirst' 等の文字列関数を直接指定する。クロージャでも良い）
        'case'      => null,
        // シンタックス装飾（true だと SAPI に基づいてよしなに。"html", "cli" だと SAPI を明示的に指定。クロージャだと直接コール）
        'highlight' => null,
        // 最大折返し文字数（未実装）
        'wrapsize'  => false,
    ];

    if ($options['case'] === true) {
        $options['case'] = 'strtoupper';
    }
    elseif ($options['case'] === false) {
        $options['case'] = 'strtolower';
    }

    if ($options['highlight'] === true) {
        $options['highlight'] = php_sapi_name() === 'cli' ? 'cli' : 'html';
    }
    if (is_string($options['highlight'])) {
        $rules = [
            'cli'  => [
                'KEYWORD' => fn($token) => "\e[1m" . $token . "\e[m",
                'COMMENT' => fn($token) => "\e[33m" . $token . "\e[m",
                'STRING'  => fn($token) => "\e[31m" . $token . "\e[m",
                'NUMBER'  => fn($token) => "\e[36m" . $token . "\e[m",
            ],
            'html' => [
                'KEYWORD' => fn($token) => "<span style='font-weight:bold;'>" . htmlspecialchars($token, ENT_QUOTES) . "</span>",
                'COMMENT' => fn($token) => "<span style='color:#FF8000;'>" . htmlspecialchars($token, ENT_QUOTES) . "</span>",
                'STRING'  => fn($token) => "<span style='color:#DD0000;'>" . htmlspecialchars($token, ENT_QUOTES) . "</span>",
                'NUMBER'  => fn($token) => "<span style='color:#0000BB;'>" . htmlspecialchars($token, ENT_QUOTES) . "</span>",
            ],
        ];
        $rule = $rules[$options['highlight']] ?? throws(new \InvalidArgumentException('highlight must be "cli" or "html".'));
        $options['highlight'] = function ($token, $ttype) use ($keywords, $rule) {
            switch (true) {
                case isset($keywords[strtoupper($token)]):
                    return $rule['KEYWORD']($token);
                case in_array($ttype, [T_COMMENT, T_DOC_COMMENT]):
                    return $rule['COMMENT']($token);
                case in_array($ttype, [T_CONSTANT_ENCAPSED_STRING, T_ENCAPSED_AND_WHITESPACE]):
                    return $rule['STRING']($token);
                case in_array($ttype, [T_LNUMBER, T_DNUMBER]):
                    return $rule['NUMBER']($token);
            }
            return $token;
        };
    }
    $options['syntaxer'] = function ($token, $ttype) use ($options, $keywords) {
        if (in_array($ttype, [T_COMMENT, T_DOC_COMMENT, T_CONSTANT_ENCAPSED_STRING], true)) {
            $tokens = [$token];
        }
        else {
            $tokens = explode(' ', $token);
        }

        $result = [];
        foreach ($tokens as $token) {
            if ($options['case'] && isset($keywords[strtoupper($token)])) {
                $token = $options['case']($token);
            }
            if ($options['highlight']) {
                $token = $options['highlight']($token, $ttype);
            }
            $result[] = $token;
        }
        return implode(' ', $result);
    };

    // 構文解析も先読みもない素朴な実装なので、特定文字列をあとから置換するための目印文字列
    $MARK = unique_string($sql, 8);
    $MARK_BR = "{$MARK}_BR:}"; // 改行マーク
    $MARK_CS = "{$MARK}_CS:}"; // コメント開始マーク
    $MARK_CE = "{$MARK}_CE:}"; // コメント終了マーク
    $MARK_NT = "{$MARK}_NT:}"; // インデントマーク
    $MARK_SP = "{$MARK}_SP:}"; // スペースマーク
    $MARK_PT = "{$MARK}_PT:}"; // 括弧ネストマーク

    // 字句にバラす（シンタックスが php に似ているので token_get_all で大幅にサボることができる）
    $tokens = [];
    $comment = '';
    $last = [];
    foreach (token_get_all("<?php $sql") as $token) {
        // トークンは配列だったり文字列だったりするので -1 トークンとして配列に正規化
        if (is_string($token)) {
            $token = [-1, $token];
        }

        // パースのために無理やり <?php を付けているので無視
        if ($token[0] === T_OPEN_TAG) {
            continue;
        }

        // '--' は php ではデクリメントだが sql ではコメントなので特別扱いする
        if ($token[0] === T_DEC) {
            $comment = $token[1];
        }
        // 改行は '--' コメントの終わり
        elseif ($comment && in_array($token[0], [T_WHITESPACE, T_COMMENT], true) && strpos($token[1], "\n") !== false) {
            $tokens[] = [T_COMMENT, $comment . $token[1]];
            $comment = '';
        }
        // コメント中はコメントに格納する
        elseif ($comment) {
            $comment .= $token[1];
        }
        // END IF, END LOOP などは一つのトークンとする
        elseif (strtoupper($last[1] ?? '') === 'END' && in_array(strtoupper($token[1]), ['CASE', 'IF', 'LOOP', 'REPEAT', 'WHILE'], true)) {
            $tokens[array_key_last($tokens)][1] .= " " . $token[1];
        }
        // 上記以外はただのトークンとして格納する
        else {
            // `string` のような文字列は T_ENCAPSED_AND_WHITESPACE として得られる（ただし ` がついていないので付与）
            if ($token[0] === T_ENCAPSED_AND_WHITESPACE) {
                $tokens[] = [$token[0], "`{$token[1]}`"];
            }
            elseif ($token[0] !== T_WHITESPACE && $token[1] !== '`') {
                $tokens[] = [$token[0], $token[1]];
            }
        }

        if ($token[0] !== T_WHITESPACE) {
            $last = $token;
        }
    }

    // コメント以外の前後のトークンを返すクロージャ
    $seek = function ($start, $step) use ($tokens) {
        $comments = [];
        for ($n = 1; ; $n++) {
            $index = $start + $n * $step;
            if (!isset($tokens[$index])) {
                break;
            }
            $token = $tokens[$index];
            if ($token[0] === T_COMMENT || $token[0] === T_DOC_COMMENT) {
                $comments[] = trim($token[1]);
            }
            else {
                return [$index, trim($token[1]), $comments];
            }
        }
        return [$start, '', $comments];
    };

    $interpret = function (&$index = -1, $context = '', $breaker = '', $nest = 0) use (&$interpret, $MARK_BR, $MARK_CS, $MARK_CE, $MARK_NT, $MARK_SP, $MARK_PT, $tokens, $options, $seek) {
        $index++;
        $beginning = true; // クエリの冒頭か
        $subcontext = '';  // SET, VALUES などのサブ分類
        $modifier = '';    // RIGHT などのキーワード修飾語
        $firstcol = null;  // SELECT における最初の列か

        $result = [];
        for ($token_length = count($tokens); $index < $token_length; $index++) {
            $token = $tokens[$index];
            $ttype = $token[0];

            $rawtoken = trim($token[1]);
            $virttoken = $options['syntaxer']($rawtoken, $ttype);
            $uppertoken = strtoupper($rawtoken);

            // SELECT の直後には DISTINCT などのオプションが来ることがあるので特別扱い
            if ($context === 'SELECT' && $firstcol) {
                if (!in_array($uppertoken, ['DISTINCT', 'DISTINCTROW', 'STRAIGHT_JOIN'], true) && !preg_match('#^SQL_#i', $uppertoken)) {
                    $firstcol = false;
                    $result[] = $MARK_BR;
                }
            }

            // コメントは特別扱いでただ付け足すだけ
            if ($ttype === T_COMMENT || $ttype === T_DOC_COMMENT) {
                $result[] = ($beginning ? '' : $MARK_CS) . $virttoken . $MARK_CE . $MARK_BR;
                continue;
            }

            $prev = $seek($index, -1);
            $next = $seek($index, +1);

            switch ($uppertoken) {
                default:
                    _DEFAULT:
                    // "tablename. columnname" になってしまう
                    // "@ var" になってしまう
                    // ": holder" になってしまう
                    if (!in_array($prev[1], ['.', '@', ':', ';'])) {
                        $result[] = $MARK_SP;
                    }

                    $result[] = $virttoken;

                    // "tablename .columnname" になってしまう
                    // "columnname ," になってしまう
                    // mysql において関数呼び出し括弧の前に空白は許されない
                    // ただし、関数呼び出しではなく記号の場合はスペースを入れたい（ colname = (SELECT ～) など）
                    if (!in_array($next[1], ['.', ',', '(', ';']) || ($next[1] === '(' && !preg_match('#^[a-z0-9_"\'`]+$#i', $rawtoken))) {
                        $result[] = $MARK_SP;
                    }
                    break;
                case "@":
                case ":":
                    $result[] = $MARK_SP . $virttoken;
                    break;
                case ".":
                    $result[] = $virttoken;
                    break;
                case ",":
                    if ($subcontext === 'LIMIT') {
                        $result[] = $virttoken . $MARK_SP;
                        break;
                    }
                    $result[] = $virttoken . $MARK_BR;
                    break;
                case ";":
                    $result[] = $virttoken . $MARK_BR;
                    break;
                case "WITH":
                    $result[] = $virttoken;
                    $result[] = $MARK_BR;
                    break;
                /** @noinspection PhpMissingBreakStatementInspection */
                case "BETWEEN":
                    $subcontext = $uppertoken;
                    goto _DEFAULT;
                case "CREATE":
                case "ALTER":
                case "DROP":
                    $result[] = $MARK_SP . $virttoken . $MARK_SP;
                    $context = $uppertoken;
                    break;
                case "TABLE":
                    // CREATE TABLE tablename は括弧があるので何もしなくて済むが、
                    // ALTER TABLE tablename は括弧がなく ADD などで始まるので特別分岐
                    $index = $next[0];
                    $result[] = $MARK_SP . $virttoken . $MARK_SP . ($MARK_SP . implode('', $next[2]) . $MARK_CE) . $next[1] . $MARK_SP;
                    if ($context !== 'CREATE' && $context !== 'DROP') {
                        $result[] = $MARK_BR;
                    }
                    break;
                /** @noinspection PhpMissingBreakStatementInspection */
                case "AND":
                    // BETWEEN A AND B と論理演算子の AND が競合するので分岐後にフォールスルー
                    if ($subcontext === 'BETWEEN') {
                        $subcontext = '';
                        $result[] = $MARK_SP . $virttoken . $MARK_SP;
                        break;
                    }
                    goto _BINARY_OPERATOR_;
                /** @noinspection PhpMissingBreakStatementInspection */
                case "OR":
                    // CREATE OR REPLACE
                    if ($context === 'CREATE') {
                        $result[] = $MARK_SP . $virttoken . $MARK_SP;
                        break;
                    }
                    goto _BINARY_OPERATOR_;
                case "XOR":
                    _BINARY_OPERATOR_:
                    // WHEN の条件はカッコがない限り改行しない
                    if ($subcontext === 'WHEN') {
                        $result[] = $MARK_SP . $virttoken . $MARK_SP;
                        break;
                    }
                    $result[] = $MARK_SP . $MARK_BR . $MARK_NT . $virttoken . $MARK_SP;
                    break;
                case "UNION":
                case "EXCEPT":
                case "INTERSECT":
                    $result[] = $MARK_BR . $virttoken . $MARK_SP;
                    $result[] = $MARK_BR;
                    break;
                case "BY":
                case "ALL":
                case "RECURSIVE":
                    $result[] = $MARK_SP . $virttoken . $MARK_SP . array_pop($result);
                    break;
                case "SELECT":
                    if (!$beginning) {
                        $result[] = $MARK_BR;
                    }
                    $result[] = $virttoken;
                    $context = $uppertoken;
                    $firstcol = true;
                    break;
                case "LEFT":
                    /** @noinspection PhpMissingBreakStatementInspection */
                case "RIGHT":
                    // 例えば LEFT や RIGHT は関数呼び出しの場合もあるので分岐後にフォールスルー
                    if ($next[1] === '(') {
                        goto _DEFAULT;
                    }
                case "CROSS":
                case "INNER":
                case "OUTER":
                    $modifier .= $virttoken . $MARK_SP;
                    break;
                case "FROM":
                case "JOIN":
                case "WHERE":
                case "HAVING":
                case "GROUP":
                case "ORDER":
                case "LIMIT":
                case "OFFSET":
                    $subcontext = $uppertoken;
                    $result[] = $MARK_BR . $modifier . $virttoken;
                    $result[] = $MARK_BR; // のちの BY のために結合はせず後ろに入れるだけにする
                    $modifier = '';
                    break;
                case "FOR":
                case "LOCK":
                    $result[] = $MARK_BR . $virttoken . $MARK_SP;
                    break;
                case "ON":
                    // ON は ON でも mysql の ON DUPLICATED かもしれない（pgsql の ON CONFLICT も似たようなコンテキスト）
                    if (in_array(strtoupper($next[1]), ['DUPLICATE', 'CONFLICT'], true)) {
                        $result[] = $MARK_BR;
                    }
                    else {
                        $result[] = $MARK_SP;
                    }
                    $result[] = $virttoken . $MARK_SP;
                    break;
                case "SET":
                    if ($context === "INSERT" || $context === "UPDATE") {
                        $subcontext = $uppertoken;
                        $result[] = $MARK_BR . $virttoken . $MARK_BR;
                    }
                    elseif ($context === "ALTER" || $subcontext === "REFERENCES") {
                        $result[] = $MARK_SP . $virttoken;
                    }
                    else {
                        $result[] = $virttoken;
                    }
                    break;
                case "INSERT":
                case "REPLACE":
                    $result[] = $virttoken . $MARK_SP;
                    $context = "INSERT"; // 構文的には INSERT と同じ
                    break;
                case "INTO":
                    if ($context === "SELECT") {
                        $result[] = $MARK_BR;
                    }
                    $result[] = $virttoken;
                    if ($context === "INSERT") {
                        $result[] = $MARK_BR;
                    }
                    break;
                case "VALUES":
                    if ($context === "UPDATE") {
                        $result[] = $MARK_SP . $virttoken;
                    }
                    else {
                        $result[] = $MARK_BR . $virttoken . $MARK_BR;
                    }
                    break;
                case "REFERENCES":
                    $result[] = $MARK_SP . $virttoken . $MARK_SP;
                    $subcontext = $uppertoken;
                    break;
                case "UPDATE":
                case "DELETE":
                    $result[] = $virttoken;
                    if ($context !== 'CREATE' && $subcontext !== 'REFERENCES') {
                        $result[] = $MARK_BR;
                        $context = $uppertoken;
                    }
                    break;
                case "IF":
                    $subcontext = $uppertoken;
                    $result[] = $virttoken;
                    break;
                /** @noinspection PhpMissingBreakStatementInspection */
                case "WHEN":
                    $subcontext = $uppertoken;
                    $result[] = $MARK_BR . $MARK_NT . $virttoken . $MARK_SP;
                    break;
                case "ELSE":
                    if ($context === 'CASE') {
                        $result[] = $MARK_BR . $MARK_NT . $virttoken . $MARK_SP;
                        break;
                    }
                    $result[] = $virttoken . $MARK_SP;
                    break;
                case "CASE":
                    $parts = $interpret($index, $uppertoken, 'END', $nest + 1);
                    $parts = str_replace($MARK_BR, $MARK_BR . $MARK_NT, $parts);
                    $result[] = $MARK_NT . $virttoken . $MARK_SP . $parts;
                    break;
                case "BEGIN":
                    if ($next[1] === ';') {
                        $result[] = $virttoken;
                    }
                    else {
                        $parts = $interpret($index, $uppertoken, 'END', $nest + 1);
                        $parts = preg_replace("#^($MARK_SP)+#u", "", $parts);
                        $parts = preg_replace("#$MARK_BR#u", $MARK_BR . $MARK_NT, $parts, substr_count($parts, $MARK_BR) - 1);
                        $result[] = $MARK_BR . $virttoken . $MARK_BR . $MARK_NT . $parts;
                    }
                    break;
                case "END":
                    if ($context === 'CASE') {
                        $result[] = $MARK_BR;
                    }
                    $result[] = $virttoken;
                    break;
                case "(":
                    if ($next[1] === ')') {
                        $result[] = $virttoken . implode('', $next[2]) . ')';
                        $index = $next[0];
                        break;
                    }

                    $parts = $uppertoken . $MARK_BR . $interpret($index, $uppertoken, ')', $nest + 1);

                    // コメントを含まない指定ネストレベルなら改行とインデントを吹き飛ばす
                    if (strpos($parts, $MARK_CE) === false && ($nest >= $options['inline'] || substr_count($parts, $MARK_PT) < $options['nestlevel'])) {
                        $parts = strtr($parts, [
                            $MARK_BR => "",
                            $MARK_NT => "",
                        ]);
                        $parts = preg_replace("#\\(($MARK_SP)+#u", '(', $parts);
                        $parts = preg_replace("#($MARK_SP)+\\)#u", ')', $parts);
                    }
                    elseif ($context === 'CREATE') {
                        // ???
                        assert($context === 'CREATE');
                    }
                    else {
                        $lastnt = $MARK_NT;
                        $brnt = $MARK_BR . $MARK_NT;
                        if (strtoupper($next[1]) === 'SELECT') {
                            $brnt .= $lastnt;
                        }
                        $parts = preg_replace("#($MARK_BR(?!\\)))+#u", $brnt, $parts) . $lastnt;
                        $parts = preg_replace("#($MARK_BR(\\)))+#u", "$MARK_BR$MARK_NT)", $parts) . $lastnt;
                        $parts = preg_replace("#$MARK_CS#u", "", $parts);
                    }

                    // IN や数式はネストとみなさない
                    $suffix = $MARK_PT;
                    if (strtoupper($prev[1]) === 'IN' || !preg_match('#^[a-z0-9_]+$#i', $prev[1])) {
                        $suffix = '';
                    }

                    $result[] = $MARK_NT . $parts . $suffix;
                    break;
                case ")":
                    $result[] = $MARK_BR . $virttoken;
                    break;
            }

            $beginning = false;

            if ($uppertoken === $breaker) {
                break;
            }
        }
        return implode('', $result);
    };

    $result = $interpret();
    $result = preg_replaces("#" . implode('|', [
            // 改行文字＋インデント文字をインデントとみなす（改行＋連続スペースもついでに）
            "(?<indent>$MARK_BR(($MARK_NT|$MARK_SP)+))",
            // 末尾スペースは除去
            "(?<spbr>($MARK_SP)+(?=$MARK_BR))",
            // 行末コメントと単一コメント
            "(?<cs1>$MARK_BR$MARK_CS)",
            "(?<cs2>$MARK_CS)",
            // 連続改行は1つに集約
            "(?<br>$MARK_BR(($MARK_NT|$MARK_SP)*)($MARK_BR)*)",
            // 連続スペースは1つに集約
            "(?<sp>($MARK_SP)+)",
            // 下記はマーカ文字が現れないように単純置換
            "(?<ce>$MARK_CE)",
            "(?<nt>$MARK_NT)",
            "(?<pt>$MARK_PT)",
        ]) . "#u", [
        'indent' => fn($str) => "\n" . str_repeat($options['indent'], (substr_count($str, $MARK_NT) + substr_count($str, $MARK_SP))),
        'spbr'   => "",
        'cs1'    => "\n" . $options['indent'],
        'cs2'    => "",
        'br'     => "\n",
        'sp'     => ' ',
        'ce'     => "",
        'nt'     => "",
        'pt'     => "",
    ], $result);

    return trim($result);
}

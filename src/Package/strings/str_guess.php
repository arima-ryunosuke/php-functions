<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../strings/damerau_levenshtein.php';
require_once __DIR__ . '/../strings/ngram.php';
require_once __DIR__ . '/../var/arrayval.php';
// @codeCoverageIgnoreEnd

/**
 * $string に最も近い文字列を返す
 *
 * N-gram 化して類似度の高い結果を返す。
 * $percent で一致度を受けられる。
 * 予め値が入った変数を渡すとその一致度以上の候補を高い順で配列で返す。
 *
 * この関数の結果（内部実装）は互換性を考慮しない。
 *
 * Example:
 * ```php
 * // 「あいうえお」と最も近い文字列は「あいゆえに」である
 * that(str_guess("あいうえお", [
 *     'かきくけこ', // マッチ度 0%（1文字もかすらない）
 *     'ぎぼあいこ', // マッチ度約 13.1%（"あい"はあるが位置が異なる）
 *     'あいしてる', // マッチ度約 13.8%（"あい"がマッチ）
 *     'かとうあい', // マッチ度約 16.7%（"あい"があり"う"の位置が等しい）
 *     'あいゆえに', // マッチ度約 17.4%（"あい", "え"がマッチ）
 * ]))->isSame('あいゆえに');
 *
 * // マッチ度30%以上を高い順に配列で返す
 * $percent = 30;
 * that(str_guess("destory", [
 *     'describe',
 *     'destroy',
 *     'destruct',
 *     'destiny',
 *     'destinate',
 * ], $percent))->isSame([
 *     'destroy',
 *     'destiny',
 *     'destruct',
 * ]);
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param string $string 調べる文字列
 * @param array $candidates 候補文字列配列
 * @param ?float $percent マッチ度（％）を受ける変数
 * @return string|array 候補の中で最も近い文字列
 */
function str_guess($string, $candidates, &$percent = null)
{
    $candidates = array_filter(arrayval($candidates, false), 'strlen');
    if (!$candidates) {
        throw new \InvalidArgumentException('$candidates is empty.');
    }

    // uni, bi, tri して配列で返すクロージャ
    $ngramer = static function ($string) {
        $result = [];
        foreach ([1, 2, 3] as $n) {
            $result[$n] = ngram($string, $n);
        }
        return $result;
    };

    $sngram = $ngramer($string);

    $result = array_fill_keys($candidates, null);
    foreach ($candidates as $candidate) {
        $cngram = $ngramer($candidate);

        // uni, bi, tri で重み付けスコア（var_dump したいことが多いので配列に入れる）
        $scores = [];
        foreach ($sngram as $n => $_) {
            $scores[$n] = count(array_intersect($sngram[$n], $cngram[$n])) / max(count($sngram[$n]), count($cngram[$n])) * $n;
        }
        $score = array_sum($scores) * 10 + 1;

        // ↑のスコアが同じだった場合を考慮してレーベンシュタイン距離で下駄を履かせる
        $score -= damerau_levenshtein($sngram[1], $cngram[1]) / max(count($sngram[1]), count($cngram[1]));

        // 10(uni) + 20(bi) + 30(tri) + 1(levenshtein) で最大は 61
        $score = $score / 61 * 100;

        $result[$candidate] = $score;
    }

    arsort($result);
    if ($percent === null) {
        $percent = reset($result);
    }
    else {
        return array_map('strval', array_keys(array_filter($result, fn($score) => $score >= $percent)));
    }

    return (string) key($result);
}

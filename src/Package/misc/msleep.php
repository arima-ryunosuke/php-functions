<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * float でのミリ秒も指定できる sleep
 *
 * ついでに、いくつかある php の sleep 系関数の動作を統一してある。
 * - sleep: 秒単位で精度が低いが、残り秒数を返してくれる
 * - usleep: 精度は高いが、返り値がない
 * - time_nanosleep: 精度が高く（高すぎる）残り秒数も返せるが、シグナルを無視できない
 * - time_sleep_until: 精度も高くシグナルを無視できるが、逆に言えばシグナルで打ち切れない
 *
 * float でのミリ秒で実用上は十分だろうし、上記のような細かな動作差異など覚えていられないので、シグナル無視を引数化し常に「残りミリ秒数」を返すようにした。
 *
 * $seconds は DateTime を受け入れ、DateTime の場合は指定日時まで待機という動作になる。
 * この時、過去日時を指定してもエラーにはならず 0 を返す（用途から考えてスケジューリングの都合で過去になることは多々ある）。
 * また、$cancel_signal 未指定の場合 false に設定される（time_sleep_until の思想を模した）。
 * 一方、float 指定の場合は 0 未満だとエラーになる（実装は assert）。
 *
 * ちなみに pcntl_signal で php レベルでシグナルをハンドリングしていない場合は $cancel_signal の指定は無意味。
 * 実際のところ「ミリ秒対応の sleep」という雑な認識で問題ない。
 *
 * @package ryunosuke\Functions\Package\misc
 */
function msleep(
    /** 待機するミリ秒|待機するまでの日時 */ float|\DateTimeInterface $seconds,
    /** シグナルでキャンセルされるか */ ?bool $cancel_signal = null,
): /** 残りミリ秒数 */ float
{
    $now = microtime(true);

    if ($seconds instanceof \DateTimeInterface) {
        $cancel_signal ??= false;
        $seconds = (float) ($seconds->format('U.u') - $now);
    }
    else {
        $cancel_signal ??= true;
        assert($seconds >= 0);
    }

    if ($seconds > 0) {
        if ($cancel_signal) {
            usleep((int) ($seconds * 1000000));
        }
        else {
            time_sleep_until($now + $seconds);
        }
    }
    return max(0.0, $seconds - (microtime(true) - $now));
}

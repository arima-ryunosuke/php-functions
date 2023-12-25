<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
// @codeCoverageIgnoreEnd

/**
 * mb_系の全体設定を一括設定する
 *
 * 返り値として「コールすると元に戻す callable」を返す。
 * あるいはその返り値はスコープが外れると自動で元に戻す処理が行われる。
 *
 * 余計なことはしない素直な実装だが、'encoding' というキーは mb_internal_encoding と regex_encoding の両方に適用される。
 *
 * Example:
 * ```php
 * $recover = mb_ereg_options([
 *     'internal_encoding' => 'SJIS', // 今だけは internal_encoding を SJIS にする
 *     'regex_options'     => 'ir',   // 今だけは regex_options を ir にする
 * ]);
 * that($recover)->isCallable();             // 返り値は callable
 * that(mb_internal_encoding())->is('SJIS'); // 今だけは SJIS
 * that(mb_regex_set_options())->is('ir');   // 今だけは ir
 *
 * $recover();
 * that(mb_internal_encoding())->is('UTF-8'); // $recover をコールすると戻る
 * that(mb_regex_set_options())->is('pr');    // $recover をコールすると戻る
 * ```
 *
 * @package ryunosuke\Functions\Package\strings
 *
 * @param array $options オプション配列
 * @return callable 元に戻す callable
 */
function mb_ereg_options($options)
{
    return new class($options) {
        private $options, $backup;

        private $settled = false;

        public function __construct($options)
        {
            $this->options = [
                'internal_encoding'    => $options['internal_encoding'] ?? $options['encoding'] ?? null,
                'substitute_character' => $options['substitute_character'] ?? null,
                'regex_encoding'       => $options['regex_encoding'] ?? $options['encoding'] ?? null,
                'regex_options'        => $options['regex_options'] ?? null,
            ];
            $this->backup = [
                'internal_encoding'    => mb_internal_encoding(),
                'substitute_character' => mb_substitute_character(),
                'regex_encoding'       => mb_regex_encoding(),
                'regex_options'        => mb_regex_set_options(),
            ];

            $this->set($this->options, true);
        }

        public function __destruct()
        {
            $this();
        }

        public function __invoke()
        {
            if ($this->settled) {
                $this->set($this->backup, false);
            }
        }

        private function set($setting, $settled)
        {
            if (strlen((string) $setting['internal_encoding'])) {
                mb_internal_encoding($setting['internal_encoding']);
            }
            if (strlen((string) $setting['substitute_character'])) {
                mb_substitute_character($setting['substitute_character']);
            }
            if (strlen((string) $setting['regex_encoding'])) {
                mb_regex_encoding($setting['regex_encoding']);
            }
            if (strlen((string) $setting['regex_options'])) {
                mb_regex_set_options($setting['regex_options']);
            }

            $this->settled = $settled;
        }
    };
}

<?php
namespace ryunosuke\Functions\Package;

/** 自分自身を表す定数 */
const IS_OWNSELF = 2;

/** public を表す定数 */
const IS_PUBLIC = 4;

/** protected を表す定数 */
const IS_PROTECTED = 8;

/** private を表す定数 */
const IS_PRIVATE = 16;

/** 和暦 */
const JP_ERA = [
    [
        "name"  => "令和",
        "abbr"  => "R",
        "since" => 1556636400,
    ],
    [
        "name"  => "平成",
        "abbr"  => "H",
        "since" => 600188400,
    ],
    [
        "name"  => "昭和",
        "abbr"  => "S",
        "since" => -1357635600,
    ],
    [
        "name"  => "大正",
        "abbr"  => "T",
        "since" => -1812186000,
    ],
    [
        "name"  => "明治",
        "abbr"  => "M",
        "since" => -3216790800,
    ],
];

/** glob 系関数で ** を有効にするか */
const GLOB_RECURSIVE = 1 << 16;

/** json_*** 関数で $depth 引数を表す定数 */
const JSON_MAX_DEPTH = -1;

/** json_*** 関数でインデント数・文字を指定する定数 */
const JSON_INDENT = -71;

/** json_*** 関数でクロージャをサポートするかの定数 */
const JSON_CLOSURE = -72;

/** json_*** 関数で初期ネストレベルを指定する定数 */
const JSON_NEST_LEVEL = -73;

/** json_*** 関数で一定以上の階層をインライン化するかの定数 */
const JSON_INLINE_LEVEL = -74;

/** json_*** 関数でスカラーのみのリストをインライン化するかの定数 */
const JSON_INLINE_SCALARLIST = -75;

/** json_*** 関数で json5 を取り扱うかの定数 */
const JSON_ES5 = -100;

/** json_*** 関数で整数を常に文字列で返すかの定数 */
const JSON_INT_AS_STRING = -101;

/** json_*** 関数で小数を常に文字列で返すかの定数 */
const JSON_FLOAT_AS_STRING = -102;

/** json_*** 関数で強制ケツカンマを振るかの定数 */
const JSON_TRAILING_COMMA = -103;

/** json_*** 関数でコメントを判定するプレフィックス定数 */
const JSON_COMMENT_PREFIX = -104;

/** json_*** 関数でテンプレートリテラルを有効にするかの定数 */
const JSON_TEMPLATE_LITERAL = -105;

/** json_*** 関数で bare string を文字列として扱うか */
const JSON_BARE_AS_STRING = -106;

/** parse_php 関数でトークン名変換をするか */
const TOKEN_NAME = 2;

const SI_UNITS = [
    -8 => ["y"],
    -7 => ["z"],
    -6 => ["a"],
    -5 => ["f"],
    -4 => ["p"],
    -3 => ["n"],
    -2 => ["u", "μ", "µ"],
    -1 => ["m"],
    0  => [],
    +1 => ["k", "K"],
    +2 => ["M"],
    +3 => ["G"],
    +4 => ["T"],
    +5 => ["P"],
    +6 => ["E"],
    +7 => ["Z"],
    +8 => ["Y"],
];

/** SORT_XXX 定数の厳密版 */
const SORT_STRICT = 256;

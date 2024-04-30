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

/** 月名（省略） */
const EN_MONTH_SHORT = [
    1  => 'jan',
    2  => 'feb',
    3  => 'mar',
    4  => 'apr',
    5  => 'may',
    6  => 'jun',
    7  => 'jul',
    8  => 'aug',
    9  => 'sep',
    10 => 'oct',
    11 => 'nov',
    12 => 'dec',
];

/** 月名（フル） */
const EN_MONTH_LONG = [
    1  => 'january',
    2  => 'february',
    3  => 'march',
    4  => 'april',
    5  => 'may',
    6  => 'june',
    7  => 'july',
    8  => 'august',
    9  => 'september',
    10 => 'october',
    11 => 'november',
    12 => 'december',
];

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

/** 一般的な mimetype */
const GENERAL_MIMETYPE = [
    'csv'   => 'text/csv',
    'dcm'   => 'application/dicom',
    'dvc'   => 'application/dvcs',
    'finf'  => 'application/fastinfoset',
    'stk'   => 'application/hyperstudio',
    'ipfix' => 'application/ipfix',
    'json'  => 'application/json',
    'mrc'   => 'application/marc',
    'nb'    => 'application/mathematica',
    'ma'    => 'application/mathematica',
    'mb'    => 'application/mathematica',
    'mbox'  => 'application/mbox',
    'm21'   => 'application/mp21',
    'mp21'  => 'application/mp21',
    'xls'   => 'application/vnd.ms-excel',
    'doc'   => 'application/vnd.ms-word',
    'mxf'   => 'application/mxf',
    'oda'   => 'application/oda',
    'ogx'   => 'application/ogg',
    'pdf'   => 'application/pdf',
    'p10'   => 'application/pkcs10',
    'ai'    => 'application/postscript',
    'eps'   => 'application/postscript',
    'ps'    => 'application/postscript',
    'rtf'   => 'application/rtf',
    'sdp'   => 'application/sdp',
    'siv'   => 'application/sieve',
    'sieve' => 'application/sieve',
    'smil'  => 'application/smil',
    'smi'   => 'application/smil',
    'sml'   => 'application/smil',
    'gram'  => 'application/srgs',
    'xml'   => 'text/xml',
    'zip'   => 'application/x-zip-compressed',
    'xlsx'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'docx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    '726'   => 'audio/32kadpcm',
    'amr'   => 'audio/AMR',
    'at3'   => 'audio/ATRAC3',
    'aa3'   => 'audio/ATRAC3',
    'omg'   => 'audio/ATRAC3',
    'evc'   => 'audio/EVRC',
    'evb'   => 'audio/EVRCB',
    'evw'   => 'audio/EVRCWB',
    'l16'   => 'audio/L16',
    'smv'   => 'audio/SMV',
    'ac3'   => 'audio/ac3',
    'au'    => 'audio/basic',
    'snd'   => 'audio/basic',
    'dls'   => 'audio/dls',
    'lbc'   => 'audio/iLBC',
    'mid'   => 'audio/midi',
    'midi'  => 'audio/midi',
    'kar'   => 'audio/midi',
    'mpga'  => 'audio/mpeg',
    'mp1'   => 'audio/mpeg',
    'mp2'   => 'audio/mpeg',
    'mp3'   => 'audio/mpeg',
    'oga'   => 'audio/ogg',
    'ogg'   => 'audio/ogg',
    'spx'   => 'audio/ogg',
    'qcp'   => 'audio/qcelp',
    'bmp'   => 'image/bmp',
    'fits'  => 'image/fits',
    'fit'   => 'image/fits',
    'fts'   => 'image/fits',
    'gif'   => 'image/gif',
    'ief'   => 'image/ief',
    'jp2'   => 'image/jp2',
    'jpg2'  => 'image/jp2',
    'jpeg'  => 'image/jpeg',
    'jpg'   => 'image/jpeg',
    'jpe'   => 'image/jpeg',
    'jfif'  => 'image/jpeg',
    'jpm'   => 'image/jpm',
    'jpgm'  => 'image/jpm',
    'jpx'   => 'image/jpx',
    'jpf'   => 'image/jpx',
    'svg'   => 'image/svg+xml',
    'png'   => 'image/png',
    't38'   => 'image/t38',
    'tiff'  => 'image/tiff',
    'tif'   => 'image/tiff',
    'u8msg' => 'message/global',
    'eml'   => 'message/rfc822',
    'mail'  => 'message/rfc822',
    'art'   => 'message/rfc822',
    'igs'   => 'model/iges',
    'iges'  => 'model/iges',
    'msh'   => 'model/mesh',
    'mesh'  => 'model/mesh',
    'silo'  => 'model/mesh',
    'wrl'   => 'model/vrml',
    'vrml'  => 'model/vrml',
    'ics'   => 'text/calendar',
    'ifb'   => 'text/calendar',
    'css'   => 'text/css',
    'soa'   => 'text/dns',
    'zone'  => 'text/dns',
    'html'  => 'text/html',
    'htm'   => 'text/html',
    'js'    => 'text/javascript',
    'asc'   => 'text/plain',
    'txt'   => 'text/plain',
    'text'  => 'text/plain',
    'pm'    => 'text/plain',
    'el'    => 'text/plain',
    'c'     => 'text/plain',
    'h'     => 'text/plain',
    'cc'    => 'text/plain',
    'hh'    => 'text/plain',
    'cxx'   => 'text/plain',
    'hxx'   => 'text/plain',
    'f90'   => 'text/plain',
    'rtx'   => 'text/richtext',
    'sgml'  => 'text/sgml',
    'sgm'   => 'text/sgml',
    '3gp'   => 'video/3gpp',
    '3gpp'  => 'video/3gpp',
    '3g2'   => 'video/3gpp2',
    '3gpp2' => 'video/3gpp2',
    'mj2'   => 'video/mj2',
    'mjp2'  => 'video/mj2',
    'mp4'   => 'video/mp4',
    'mpg4'  => 'video/mp4',
    'mpeg'  => 'video/mpeg',
    'mpg'   => 'video/mpeg',
    'mpe'   => 'video/mpeg',
    'ogv'   => 'video/ogg',
    'qt'    => 'video/quicktime',
    'mov'   => 'video/quicktime',
    'webm'  => 'video/webm',
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

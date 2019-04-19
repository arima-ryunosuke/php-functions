<?php

# Don't touch this code. This is auto generated.


# constants
/** SQL キーワード（全 RDBMS ごちゃまぜ） */
const KEYWORDS = [
    ""  => "",
    0   => "ACCESSIBLE",
    1   => "ACTION",
    2   => "ADD",
    3   => "AFTER",
    4   => "AGAINST",
    5   => "AGGREGATE",
    6   => "ALGORITHM",
    7   => "ALL",
    8   => "ALTER",
    9   => "ALTER TABLE",
    10  => "ANALYSE",
    11  => "ANALYZE",
    12  => "AND",
    13  => "AS",
    14  => "ASC",
    15  => "AUTOCOMMIT",
    16  => "AUTO_INCREMENT",
    17  => "BACKUP",
    18  => "BEGIN",
    19  => "BETWEEN",
    20  => "BINLOG",
    21  => "BOTH",
    22  => "CASCADE",
    23  => "CASE",
    24  => "CHANGE",
    25  => "CHANGED",
    26  => "CHARACTER SET",
    27  => "CHARSET",
    28  => "CHECK",
    29  => "CHECKSUM",
    30  => "COLLATE",
    31  => "COLLATION",
    32  => "COLUMN",
    33  => "COLUMNS",
    34  => "COMMENT",
    35  => "COMMIT",
    36  => "COMMITTED",
    37  => "COMPRESSED",
    38  => "CONCURRENT",
    39  => "CONSTRAINT",
    40  => "CONTAINS",
    41  => "CONVERT",
    42  => "CREATE",
    43  => "CROSS",
    44  => "CURRENT_TIMESTAMP",
    45  => "DATABASE",
    46  => "DATABASES",
    47  => "DAY",
    48  => "DAY_HOUR",
    49  => "DAY_MINUTE",
    50  => "DAY_SECOND",
    51  => "DEFAULT",
    52  => "DEFINER",
    53  => "DELAYED",
    54  => "DELETE",
    55  => "DELETE FROM",
    56  => "DESC",
    57  => "DESCRIBE",
    58  => "DETERMINISTIC",
    59  => "DISTINCT",
    60  => "DISTINCTROW",
    61  => "DIV",
    62  => "DO",
    63  => "DROP",
    64  => "DUMPFILE",
    65  => "DUPLICATE",
    66  => "DYNAMIC",
    67  => "ELSE",
    68  => "ENCLOSED",
    69  => "END",
    70  => "ENGINE",
    71  => "ENGINES",
    72  => "ENGINE_TYPE",
    73  => "ESCAPE",
    74  => "ESCAPED",
    75  => "EVENTS",
    76  => "EXCEPT",
    77  => "EXECUTE",
    78  => "EXISTS",
    79  => "EXPLAIN",
    80  => "EXTENDED",
    81  => "FAST",
    82  => "FIELDS",
    83  => "FILE",
    84  => "FIRST",
    85  => "FIXED",
    86  => "FLUSH",
    87  => "FOR",
    88  => "FORCE",
    89  => "FOREIGN",
    90  => "FROM",
    91  => "FULL",
    92  => "FULLTEXT",
    93  => "FUNCTION",
    94  => "GLOBAL",
    95  => "GRANT",
    96  => "GRANTS",
    97  => "GROUP BY",
    98  => "GROUP_CONCAT",
    99  => "HAVING",
    100 => "HEAP",
    101 => "HIGH_PRIORITY",
    102 => "HOSTS",
    103 => "HOUR",
    104 => "HOUR_MINUTE",
    105 => "HOUR_SECOND",
    106 => "IDENTIFIED",
    107 => "IF",
    108 => "IFNULL",
    109 => "IGNORE",
    110 => "IN",
    111 => "INDEX",
    112 => "INDEXES",
    113 => "INFILE",
    114 => "INNER",
    115 => "INSERT",
    116 => "INSERT_ID",
    117 => "INSERT_METHOD",
    118 => "INTERSECT",
    119 => "INTERVAL",
    120 => "INTO",
    121 => "INVOKER",
    122 => "IS",
    123 => "ISOLATION",
    124 => "JOIN",
    125 => "KEY",
    126 => "KEYS",
    127 => "KILL",
    128 => "LAST_INSERT_ID",
    129 => "LEADING",
    130 => "LEFT",
    131 => "LEVEL",
    132 => "LIKE",
    133 => "LIMIT",
    134 => "LINEAR",
    135 => "LINES",
    136 => "LOAD",
    137 => "LOCAL",
    138 => "LOCK",
    139 => "LOCKS",
    140 => "LOGS",
    141 => "LOW_PRIORITY",
    142 => "MARIA",
    143 => "MASTER",
    144 => "MASTER_CONNECT_RETRY",
    145 => "MASTER_HOST",
    146 => "MASTER_LOG_FILE",
    147 => "MATCH",
    148 => "MAX_CONNECTIONS_PER_HOUR",
    149 => "MAX_QUERIES_PER_HOUR",
    150 => "MAX_ROWS",
    151 => "MAX_UPDATES_PER_HOUR",
    152 => "MAX_USER_CONNECTIONS",
    153 => "MEDIUM",
    154 => "MERGE",
    155 => "MINUTE",
    156 => "MINUTE_SECOND",
    157 => "MIN_ROWS",
    158 => "MODE",
    159 => "MODIFY",
    160 => "MONTH",
    161 => "MRG_MYISAM",
    162 => "MYISAM",
    163 => "NAMES",
    164 => "NATURAL",
    165 => "NOT",
    166 => "NOW()",
    167 => "NULL",
    168 => "OFFSET",
    169 => "ON",
    170 => "ON DELETE",
    171 => "ON UPDATE",
    172 => "OPEN",
    173 => "OPTIMIZE",
    174 => "OPTION",
    175 => "OPTIONALLY",
    176 => "OR",
    177 => "ORDER BY",
    178 => "OUTER",
    179 => "OUTFILE",
    180 => "PACK_KEYS",
    181 => "PAGE",
    182 => "PARTIAL",
    183 => "PARTITION",
    184 => "PARTITIONS",
    185 => "PASSWORD",
    186 => "PRIMARY",
    187 => "PRIVILEGES",
    188 => "PROCEDURE",
    189 => "PROCESS",
    190 => "PROCESSLIST",
    191 => "PURGE",
    192 => "QUICK",
    193 => "RAID0",
    194 => "RAID_CHUNKS",
    195 => "RAID_CHUNKSIZE",
    196 => "RAID_TYPE",
    197 => "RANGE",
    198 => "READ",
    199 => "READ_ONLY",
    200 => "READ_WRITE",
    201 => "REFERENCES",
    202 => "REGEXP",
    203 => "RELOAD",
    204 => "RENAME",
    205 => "REPAIR",
    206 => "REPEATABLE",
    207 => "REPLACE",
    208 => "REPLICATION",
    209 => "RESET",
    210 => "RESTORE",
    211 => "RESTRICT",
    212 => "RETURN",
    213 => "RETURNS",
    214 => "REVOKE",
    215 => "RIGHT",
    216 => "RLIKE",
    217 => "ROLLBACK",
    218 => "ROW",
    219 => "ROWS",
    220 => "ROW_FORMAT",
    221 => "SECOND",
    222 => "SECURITY",
    223 => "SELECT",
    224 => "SEPARATOR",
    225 => "SERIALIZABLE",
    226 => "SESSION",
    227 => "SET",
    228 => "SHARE",
    229 => "SHOW",
    230 => "SHUTDOWN",
    231 => "SLAVE",
    232 => "SONAME",
    233 => "SOUNDS",
    234 => "SQL",
    235 => "SQL_AUTO_IS_NULL",
    236 => "SQL_BIG_RESULT",
    237 => "SQL_BIG_SELECTS",
    238 => "SQL_BIG_TABLES",
    239 => "SQL_BUFFER_RESULT",
    240 => "SQL_CACHE",
    241 => "SQL_CALC_FOUND_ROWS",
    242 => "SQL_LOG_BIN",
    243 => "SQL_LOG_OFF",
    244 => "SQL_LOG_UPDATE",
    245 => "SQL_LOW_PRIORITY_UPDATES",
    246 => "SQL_MAX_JOIN_SIZE",
    247 => "SQL_NO_CACHE",
    248 => "SQL_QUOTE_SHOW_CREATE",
    249 => "SQL_SAFE_UPDATES",
    250 => "SQL_SELECT_LIMIT",
    251 => "SQL_SLAVE_SKIP_COUNTER",
    252 => "SQL_SMALL_RESULT",
    253 => "SQL_WARNINGS",
    254 => "START",
    255 => "STARTING",
    256 => "STATUS",
    257 => "STOP",
    258 => "STORAGE",
    259 => "STRAIGHT_JOIN",
    260 => "STRING",
    261 => "STRIPED",
    262 => "SUPER",
    263 => "TABLE",
    264 => "TABLES",
    265 => "TEMPORARY",
    266 => "TERMINATED",
    267 => "THEN",
    268 => "TO",
    269 => "TRAILING",
    270 => "TRANSACTIONAL",
    271 => "TRUE",
    272 => "TRUNCATE",
    273 => "TYPE",
    274 => "TYPES",
    275 => "UNCOMMITTED",
    276 => "UNION",
    277 => "UNION ALL",
    278 => "UNIQUE",
    279 => "UNLOCK",
    280 => "UNSIGNED",
    281 => "UPDATE",
    282 => "USAGE",
    283 => "USE",
    284 => "USING",
    285 => "VALUES",
    286 => "VARIABLES",
    287 => "VIEW",
    288 => "WHEN",
    289 => "WHERE",
    290 => "WITH",
    291 => "WORK",
    292 => "WRITE",
    293 => "XOR",
    294 => "YEAR_MONTH",
    295 => "ABS",
    296 => "ACOS",
    297 => "ADDDATE",
    298 => "ADDTIME",
    299 => "AES_DECRYPT",
    300 => "AES_ENCRYPT",
    301 => "AREA",
    302 => "ASBINARY",
    303 => "ASCII",
    304 => "ASIN",
    305 => "ASTEXT",
    306 => "ATAN",
    307 => "ATAN2",
    308 => "AVG",
    309 => "BDMPOLYFROMTEXT",
    310 => "BDMPOLYFROMWKB",
    311 => "BDPOLYFROMTEXT",
    312 => "BDPOLYFROMWKB",
    313 => "BENCHMARK",
    314 => "BIN",
    315 => "BIT_AND",
    316 => "BIT_COUNT",
    317 => "BIT_LENGTH",
    318 => "BIT_OR",
    319 => "BIT_XOR",
    320 => "BOUNDARY",
    321 => "BUFFER",
    322 => "CAST",
    323 => "CEIL",
    324 => "CEILING",
    325 => "CENTROID",
    326 => "CHAR",
    327 => "CHARACTER_LENGTH",
    328 => "CHARSET",
    329 => "CHAR_LENGTH",
    330 => "COALESCE",
    331 => "COERCIBILITY",
    332 => "COLLATION",
    333 => "COMPRESS",
    334 => "CONCAT",
    335 => "CONCAT_WS",
    336 => "CONNECTION_ID",
    337 => "CONTAINS",
    338 => "CONV",
    339 => "CONVERT",
    340 => "CONVERT_TZ",
    341 => "CONVEXHULL",
    342 => "COS",
    343 => "COT",
    344 => "COUNT",
    345 => "CRC32",
    346 => "CROSSES",
    347 => "CURDATE",
    348 => "CURRENT_DATE",
    349 => "CURRENT_TIME",
    350 => "CURRENT_TIMESTAMP",
    351 => "CURRENT_USER",
    352 => "CURTIME",
    353 => "DATABASE",
    354 => "DATE",
    355 => "DATEDIFF",
    356 => "DATE_ADD",
    357 => "DATE_DIFF",
    358 => "DATE_FORMAT",
    359 => "DATE_SUB",
    360 => "DAY",
    361 => "DAYNAME",
    362 => "DAYOFMONTH",
    363 => "DAYOFWEEK",
    364 => "DAYOFYEAR",
    365 => "DECODE",
    366 => "DEFAULT",
    367 => "DEGREES",
    368 => "DES_DECRYPT",
    369 => "DES_ENCRYPT",
    370 => "DIFFERENCE",
    371 => "DIMENSION",
    372 => "DISJOINT",
    373 => "DISTANCE",
    374 => "ELT",
    375 => "ENCODE",
    376 => "ENCRYPT",
    377 => "ENDPOINT",
    378 => "ENVELOPE",
    379 => "EQUALS",
    380 => "EXP",
    381 => "EXPORT_SET",
    382 => "EXTERIORRING",
    383 => "EXTRACT",
    384 => "EXTRACTVALUE",
    385 => "FIELD",
    386 => "FIND_IN_SET",
    387 => "FLOOR",
    388 => "FORMAT",
    389 => "FOUND_ROWS",
    390 => "FROM_DAYS",
    391 => "FROM_UNIXTIME",
    392 => "GEOMCOLLFROMTEXT",
    393 => "GEOMCOLLFROMWKB",
    394 => "GEOMETRYCOLLECTION",
    395 => "GEOMETRYCOLLECTIONFROMTEXT",
    396 => "GEOMETRYCOLLECTIONFROMWKB",
    397 => "GEOMETRYFROMTEXT",
    398 => "GEOMETRYFROMWKB",
    399 => "GEOMETRYN",
    400 => "GEOMETRYTYPE",
    401 => "GEOMFROMTEXT",
    402 => "GEOMFROMWKB",
    403 => "GET_FORMAT",
    404 => "GET_LOCK",
    405 => "GLENGTH",
    406 => "GREATEST",
    407 => "GROUP_CONCAT",
    408 => "GROUP_UNIQUE_USERS",
    409 => "HEX",
    410 => "HOUR",
    411 => "IF",
    412 => "IFNULL",
    413 => "INET_ATON",
    414 => "INET_NTOA",
    415 => "INSERT",
    416 => "INSTR",
    417 => "INTERIORRINGN",
    418 => "INTERSECTION",
    419 => "INTERSECTS",
    420 => "INTERVAL",
    421 => "ISCLOSED",
    422 => "ISEMPTY",
    423 => "ISNULL",
    424 => "ISRING",
    425 => "ISSIMPLE",
    426 => "IS_FREE_LOCK",
    427 => "IS_USED_LOCK",
    428 => "LAST_DAY",
    429 => "LAST_INSERT_ID",
    430 => "LCASE",
    431 => "LEAST",
    432 => "LEFT",
    433 => "LENGTH",
    434 => "LINEFROMTEXT",
    435 => "LINEFROMWKB",
    436 => "LINESTRING",
    437 => "LINESTRINGFROMTEXT",
    438 => "LINESTRINGFROMWKB",
    439 => "LN",
    440 => "LOAD_FILE",
    441 => "LOCALTIME",
    442 => "LOCALTIMESTAMP",
    443 => "LOCATE",
    444 => "LOG",
    445 => "LOG10",
    446 => "LOG2",
    447 => "LOWER",
    448 => "LPAD",
    449 => "LTRIM",
    450 => "MAKEDATE",
    451 => "MAKETIME",
    452 => "MAKE_SET",
    453 => "MASTER_POS_WAIT",
    454 => "MAX",
    455 => "MBRCONTAINS",
    456 => "MBRDISJOINT",
    457 => "MBREQUAL",
    458 => "MBRINTERSECTS",
    459 => "MBROVERLAPS",
    460 => "MBRTOUCHES",
    461 => "MBRWITHIN",
    462 => "MD5",
    463 => "MICROSECOND",
    464 => "MID",
    465 => "MIN",
    466 => "MINUTE",
    467 => "MLINEFROMTEXT",
    468 => "MLINEFROMWKB",
    469 => "MOD",
    470 => "MONTH",
    471 => "MONTHNAME",
    472 => "MPOINTFROMTEXT",
    473 => "MPOINTFROMWKB",
    474 => "MPOLYFROMTEXT",
    475 => "MPOLYFROMWKB",
    476 => "MULTILINESTRING",
    477 => "MULTILINESTRINGFROMTEXT",
    478 => "MULTILINESTRINGFROMWKB",
    479 => "MULTIPOINT",
    480 => "MULTIPOINTFROMTEXT",
    481 => "MULTIPOINTFROMWKB",
    482 => "MULTIPOLYGON",
    483 => "MULTIPOLYGONFROMTEXT",
    484 => "MULTIPOLYGONFROMWKB",
    485 => "NAME_CONST",
    486 => "NULLIF",
    487 => "NUMGEOMETRIES",
    488 => "NUMINTERIORRINGS",
    489 => "NUMPOINTS",
    490 => "OCT",
    491 => "OCTET_LENGTH",
    492 => "OLD_PASSWORD",
    493 => "ORD",
    494 => "OVERLAPS",
    495 => "PASSWORD",
    496 => "PERIOD_ADD",
    497 => "PERIOD_DIFF",
    498 => "PI",
    499 => "POINT",
    500 => "POINTFROMTEXT",
    501 => "POINTFROMWKB",
    502 => "POINTN",
    503 => "POINTONSURFACE",
    504 => "POLYFROMTEXT",
    505 => "POLYFROMWKB",
    506 => "POLYGON",
    507 => "POLYGONFROMTEXT",
    508 => "POLYGONFROMWKB",
    509 => "POSITION",
    510 => "POW",
    511 => "POWER",
    512 => "QUARTER",
    513 => "QUOTE",
    514 => "RADIANS",
    515 => "RAND",
    516 => "RELATED",
    517 => "RELEASE_LOCK",
    518 => "REPEAT",
    519 => "REPLACE",
    520 => "REVERSE",
    521 => "RIGHT",
    522 => "ROUND",
    523 => "ROW_COUNT",
    524 => "RPAD",
    525 => "RTRIM",
    526 => "SCHEMA",
    527 => "SECOND",
    528 => "SEC_TO_TIME",
    529 => "SESSION_USER",
    530 => "SHA",
    531 => "SHA1",
    532 => "SIGN",
    533 => "SIN",
    534 => "SLEEP",
    535 => "SOUNDEX",
    536 => "SPACE",
    537 => "SQRT",
    538 => "SRID",
    539 => "STARTPOINT",
    540 => "STD",
    541 => "STDDEV",
    542 => "STDDEV_POP",
    543 => "STDDEV_SAMP",
    544 => "STRCMP",
    545 => "STR_TO_DATE",
    546 => "SUBDATE",
    547 => "SUBSTR",
    548 => "SUBSTRING",
    549 => "SUBSTRING_INDEX",
    550 => "SUBTIME",
    551 => "SUM",
    552 => "SYMDIFFERENCE",
    553 => "SYSDATE",
    554 => "SYSTEM_USER",
    555 => "TAN",
    556 => "TIME",
    557 => "TIMEDIFF",
    558 => "TIMESTAMP",
    559 => "TIMESTAMPADD",
    560 => "TIMESTAMPDIFF",
    561 => "TIME_FORMAT",
    562 => "TIME_TO_SEC",
    563 => "TOUCHES",
    564 => "TO_DAYS",
    565 => "TRIM",
    566 => "TRUNCATE",
    567 => "UCASE",
    568 => "UNCOMPRESS",
    569 => "UNCOMPRESSED_LENGTH",
    570 => "UNHEX",
    571 => "UNIQUE_USERS",
    572 => "UNIX_TIMESTAMP",
    573 => "UPDATEXML",
    574 => "UPPER",
    575 => "USER",
    576 => "UTC_DATE",
    577 => "UTC_TIME",
    578 => "UTC_TIMESTAMP",
    579 => "UUID",
    580 => "VARIANCE",
    581 => "VAR_POP",
    582 => "VAR_SAMP",
    583 => "VERSION",
    584 => "WEEK",
    585 => "WEEKDAY",
    586 => "WEEKOFYEAR",
    587 => "WITHIN",
    588 => "X",
    589 => "Y",
    590 => "YEAR",
    591 => "YEARWEEK",
];

/** json_*** 関数で $depth 引数を表す定数 */
const JSON_MAX_DEPTH = -1;

/** parse_php 関数でトークン名変換をするか */
const TOKEN_NAME = 2;


# functions
const arrays = "arrays";
if (!isset($excluded_functions["arrays"]) && (!function_exists("arrays") || (!false && (new \ReflectionFunction("arrays"))->isInternal()))) {
    /**
     * 配列をシーケンシャルに走査するジェネレータを返す
     *
     * 「シーケンシャルに」とは要するに数値連番が得られるように走査するということ。
     * 0ベースの連番を作ってインクリメントしながら foreach するのと全く変わらない。
     *
     * キーは連番、値は [$key, $value] で返す。
     * つまり、 Example のように foreach の list 構文を使えば「連番、キー、値」でループを回すことが可能になる。
     * 「foreach で回したいんだけど連番も欲しい」という状況はまれによくあるはず。
     *
     * Example:
     * ```php
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * $nkv = [];
     * foreach (arrays($array) as $n => list($k, $v)) { // php7.1 以降なら list ではなく [] でも行ける
     *     $nkv[] = "$n,$k,$v";
     * }
     * assertSame($nkv, ['0,a,A', '1,b,B', '2,c,C']);
     * ```
     *
     * @param iterable $array 対象配列
     * @return \Generator [$seq => [$key, $value]] を返すジェネレータ
     */
    function arrays($array)
    {
        $n = 0;
        foreach ($array as $k => $v) {
            yield $n++ => [$k, $v];
        }
    }
}

const arrayize = "arrayize";
if (!isset($excluded_functions["arrayize"]) && (!function_exists("arrayize") || (!false && (new \ReflectionFunction("arrayize"))->isInternal()))) {
    /**
     * 引数の配列を生成する。
     *
     * 配列以外を渡すと配列化されて追加される。
     * 連想配列は未対応。あくまで普通の配列化のみ。
     * iterable や Traversable は考慮せずあくまで「配列」としてチェックする。
     *
     * Example:
     * ```php
     * assertSame(arrayize(1, 2, 3), [1, 2, 3]);
     * assertSame(arrayize([1], [2], [3]), [1, 2, 3]);
     * $object = new \stdClass();
     * assertSame(arrayize($object, false, [1, 2, 3]), [$object, false, 1, 2, 3]);
     * ```
     *
     * @param mixed $variadic 生成する要素（可変引数）
     * @return array 引数を配列化したもの
     */
    function arrayize(...$variadic)
    {
        $result = [];
        foreach ($variadic as $arg) {
            if (!is_array($arg)) {
                $arg = [$arg];
            }
            $result = array_merge($result, $arg);
        }
        return $result;
    }
}

const is_hasharray = "is_hasharray";
if (!isset($excluded_functions["is_hasharray"]) && (!function_exists("is_hasharray") || (!false && (new \ReflectionFunction("is_hasharray"))->isInternal()))) {
    /**
     * 配列が連想配列か調べる
     *
     * 空の配列は普通の配列とみなす。
     *
     * Example:
     * ```php
     * assertFalse(is_hasharray([]));
     * assertFalse(is_hasharray([1, 2, 3]));
     * assertTrue(is_hasharray(['x' => 'X']));
     * ```
     *
     * @param array $array 調べる配列
     * @return bool 連想配列なら true
     */
    function is_hasharray(array $array)
    {
        $i = 0;
        foreach ($array as $k => $dummy) {
            if ($k !== $i++) {
                return true;
            }
        }
        return false;
    }
}

const first_key = "first_key";
if (!isset($excluded_functions["first_key"]) && (!function_exists("first_key") || (!false && (new \ReflectionFunction("first_key"))->isInternal()))) {
    /**
     * 配列の最初のキーを返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * assertSame(first_key(['a', 'b', 'c']), 0);
     * assertSame(first_key([], 999), 999);
     * ```
     *
     * @param iterable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 最初のキー
     */
    function first_key($array, $default = null)
    {
        if (is_empty($array)) {
            return $default;
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        list($k, $v) = first_keyvalue($array);
        return $k;
    }
}

const first_value = "first_value";
if (!isset($excluded_functions["first_value"]) && (!function_exists("first_value") || (!false && (new \ReflectionFunction("first_value"))->isInternal()))) {
    /**
     * 配列の最初の値を返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * assertSame(first_value(['a', 'b', 'c']), 'a');
     * assertSame(first_value([], 999), 999);
     * ```
     *
     * @param iterable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 最初の値
     */
    function first_value($array, $default = null)
    {
        if (is_empty($array)) {
            return $default;
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        list($k, $v) = first_keyvalue($array);
        return $v;
    }
}

const first_keyvalue = "first_keyvalue";
if (!isset($excluded_functions["first_keyvalue"]) && (!function_exists("first_keyvalue") || (!false && (new \ReflectionFunction("first_keyvalue"))->isInternal()))) {
    /**
     * 配列の最初のキー/値ペアをタプルで返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * assertSame(first_keyvalue(['a', 'b', 'c']), [0, 'a']);
     * assertSame(first_keyvalue([], 999), 999);
     * ```
     *
     * @param iterable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return array [最初のキー, 最初の値]
     */
    function first_keyvalue($array, $default = null)
    {
        foreach ($array as $k => $v) {
            return [$k, $v];
        }
        return $default;
    }
}

const last_key = "last_key";
if (!isset($excluded_functions["last_key"]) && (!function_exists("last_key") || (!false && (new \ReflectionFunction("last_key"))->isInternal()))) {
    /**
     * 配列の最後のキーを返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * assertSame(last_key(['a', 'b', 'c']), 2);
     * assertSame(last_key([], 999), 999);
     * ```
     *
     * @param iterable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 最後のキー
     */
    function last_key($array, $default = null)
    {
        if (is_empty($array)) {
            return $default;
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        list($k, $v) = last_keyvalue($array);
        return $k;
    }
}

const last_value = "last_value";
if (!isset($excluded_functions["last_value"]) && (!function_exists("last_value") || (!false && (new \ReflectionFunction("last_value"))->isInternal()))) {
    /**
     * 配列の最後の値を返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * assertSame(last_value(['a', 'b', 'c']), 'c');
     * assertSame(last_value([], 999), 999);
     * ```
     *
     * @param iterable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 最後の値
     */
    function last_value($array, $default = null)
    {
        if (is_empty($array)) {
            return $default;
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        list($k, $v) = last_keyvalue($array);
        return $v;
    }
}

const last_keyvalue = "last_keyvalue";
if (!isset($excluded_functions["last_keyvalue"]) && (!function_exists("last_keyvalue") || (!false && (new \ReflectionFunction("last_keyvalue"))->isInternal()))) {
    /**
     * 配列の最後のキー/値ペアをタプルで返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * assertSame(last_keyvalue(['a', 'b', 'c']), [2, 'c']);
     * assertSame(last_keyvalue([], 999), 999);
     * ```
     *
     * @param iterable $array 対象配列
     * @param mixed $default 無かった場合のデフォルト値
     * @return array [最後のキー, 最後の値]
     */
    function last_keyvalue($array, $default = null)
    {
        if (is_empty($array)) {
            return $default;
        }
        if (is_array($array)) {
            $v = end($array);
            $k = key($array);
            return [$k, $v];
        }
        /** @noinspection PhpStatementHasEmptyBodyInspection */
        foreach ($array as $k => $v) {
            // dummy
        }
        // $k がセットされてるなら「ループが最低でも1度回った（≠空）」とみなせる
        if (isset($k)) {
            /** @noinspection PhpUndefinedVariableInspection */
            return [$k, $v];
        }
        return $default;
    }
}

const prev_key = "prev_key";
if (!isset($excluded_functions["prev_key"]) && (!function_exists("prev_key") || (!false && (new \ReflectionFunction("prev_key"))->isInternal()))) {
    /**
     * 配列の指定キーの前のキーを返す
     *
     * $key が最初のキーだった場合は null を返す。
     * $key が存在しない場合は false を返す。
     *
     * Example:
     * ```php
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // 'b' キーの前は 'a'
     * assertSame(prev_key($array, 'b'), 'a');
     * // 'a' キーの前は無いので null
     * assertSame(prev_key($array, 'a'), null);
     * // 'x' キーはそもそも存在しないので false
     * assertSame(prev_key($array, 'x'), false);
     * ```
     *
     * @param array $array 対象配列
     * @param string|int $key 調べるキー
     * @return string|int|bool|null $key の前のキー
     */
    function prev_key($array, $key)
    {
        $key = (string) $key;
        $current = null;
        foreach ($array as $k => $v) {
            if ($key === (string) $k) {
                return $current;
            }
            $current = $k;
        }
        return false;
    }
}

const next_key = "next_key";
if (!isset($excluded_functions["next_key"]) && (!function_exists("next_key") || (!false && (new \ReflectionFunction("next_key"))->isInternal()))) {
    /**
     * 配列の指定キーの次のキーを返す
     *
     * $key が最後のキーだった場合は null を返す。
     * $key が存在しない場合は false を返す。
     * $key が未指定だと「次に生成されるキー」（$array[]='hoge' で生成されるキー）を返す。
     *
     * $array[] = 'hoge' で作成されるキーには完全準拠しない（標準は unset すると結構乱れる）。公式マニュアルを参照。
     *
     * Example:
     * ```php
     * $array = [9 => 9, 'a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // 'b' キーの次は 'c'
     * assertSame(next_key($array, 'b'), 'c');
     * // 'c' キーの次は無いので null
     * assertSame(next_key($array, 'c'), null);
     * // 'x' キーはそもそも存在しないので false
     * assertSame(next_key($array, 'x'), false);
     * // 次に生成されるキーは 10
     * assertSame(next_key($array, null), 10);
     * ```
     *
     * @param array $array 対象配列
     * @param string|int|null $key 調べるキー
     * @return string|int|bool|null $key の次のキー
     */
    function next_key($array, $key = null)
    {
        $keynull = $key === null;
        $key = (string) $key;
        $current = false;
        $max = -1;
        foreach ($array as $k => $v) {
            if ($current !== false) {
                return $k;
            }
            if ($key === (string) $k) {
                $current = null;
            }
            if ($keynull && is_int($k) && $k > $max) {
                $max = $k;
            }
        }
        if ($keynull) {
            // PHP 4.3.0 以降は0以下にはならない
            return max(0, $max + 1);
        }
        else {
            return $current;
        }
    }
}

const in_array_and = "in_array_and";
if (!isset($excluded_functions["in_array_and"]) && (!function_exists("in_array_and") || (!false && (new \ReflectionFunction("in_array_and"))->isInternal()))) {
    /**
     * in_array の複数版（AND）
     *
     * 配列 $haystack が $needle の「すべてを含む」ときに true を返す。
     *
     * $needle が非配列の場合は配列化される。
     * $needle が空の場合は常に false を返す。
     *
     * Example:
     * ```php
     * assertTrue(in_array_and([1], [1, 2, 3]));
     * assertFalse(in_array_and([9], [1, 2, 3]));
     * assertFalse(in_array_and([1, 9], [1, 2, 3]));
     * ```
     *
     * @param array|mixed $needle 調べる値
     * @param array $haystack 調べる配列
     * @param bool $strict 厳密フラグ
     * @return bool $needle のすべてが含まれているなら true
     */
    function in_array_and($needle, $haystack, $strict = false)
    {
        $needle = is_iterable($needle) ? $needle : [$needle];
        if (is_empty($needle)) {
            return false;
        }

        foreach ($needle as $v) {
            if (!in_array($v, $haystack, $strict)) {
                return false;
            }
        }
        return true;
    }
}

const in_array_or = "in_array_or";
if (!isset($excluded_functions["in_array_or"]) && (!function_exists("in_array_or") || (!false && (new \ReflectionFunction("in_array_or"))->isInternal()))) {
    /**
     * in_array の複数版（OR）
     *
     * 配列 $haystack が $needle の「どれかを含む」ときに true を返す。
     *
     * $needle が非配列の場合は配列化される。
     * $needle が空の場合は常に false を返す。
     *
     * Example:
     * ```php
     * assertTrue(in_array_or([1], [1, 2, 3]), true);
     * assertFalse(in_array_or([9], [1, 2, 3]), false);
     * assertTrue(in_array_or([1, 9], [1, 2, 3]), true);
     * ```
     *
     * @param array|mixed $needle 調べる値
     * @param array $haystack 調べる配列
     * @param bool $strict 厳密フラグ
     * @return bool $needle のどれかが含まれているなら true
     */
    function in_array_or($needle, $haystack, $strict = false)
    {
        $needle = is_iterable($needle) ? $needle : [$needle];
        if (is_empty($needle)) {
            return false;
        }

        foreach ($needle as $v) {
            if (in_array($v, $haystack, $strict)) {
                return true;
            }
        }
        return false;
    }
}

const kvsort = "kvsort";
if (!isset($excluded_functions["kvsort"]) && (!function_exists("kvsort") || (!false && (new \ReflectionFunction("kvsort"))->isInternal()))) {
    /**
     * 比較関数にキーも渡ってくる安定ソート
     *
     * 比較関数は ($avalue, $bvalue, $akey, $bkey) という引数を取る。
     * 「値で比較して同値だったらキーも見たい」という状況はまれによくあるはず。
     * さらに安定ソートであり、同値だとしても元の並び順は維持される。
     *
     * $comparator は省略できる。省略した場合、型に基づいてよしなにソートする。
     * （が、比較のたびに型チェックが入るので指定したほうが高速に動く）。
     *
     * ただし、標準のソート関数とは異なり、参照渡しではなくソートして返り値で返す。
     * また、いわゆる asort であり、キー・値は常に維持される。
     *
     * Example:
     * ```php
     * $array = [
     *     'a'  => 3,
     *     'b'  => 1,
     *     'c'  => 2,
     *     'x1' => 9,
     *     'x2' => 9,
     *     'x3' => 9,
     * ];
     * // 普通のソート
     * assertSame(kvsort($array), [
     *     'b'  => 1,
     *     'c'  => 2,
     *     'a'  => 3,
     *     'x1' => 9,
     *     'x2' => 9,
     *     'x3' => 9,
     * ]);
     * // キーを使用したソート
     * assertSame(kvsort($array, function($av, $bv, $ak, $bk){return strcmp($bk, $ak);}), [
     *     'x3' => 9,
     *     'x2' => 9,
     *     'x1' => 9,
     *     'c'  => 2,
     *     'b'  => 1,
     *     'a'  => 3,
     * ]);
     * ```
     *
     * @param iterable|string $array 対象配列
     * @param callable|int $comparator 比較関数。SORT_XXX も使える
     * @return array ソートされた配列
     */
    function kvsort($array, $comparator = null)
    {
        if ($comparator === null || is_int($comparator)) {
            $sort_flg = $comparator;
            $comparator = function ($av, $bv, $ak, $bk) use ($sort_flg) {
                return varcmp($av, $bv, $sort_flg);
            };
        }

        $n = 0;
        $tmp = [];
        foreach ($array as $k => $v) {
            $tmp[$k] = [$n++, $k, $v];
        }

        uasort($tmp, function ($a, $b) use ($comparator) {
            return $comparator($a[2], $b[2], $a[1], $b[1]) ?: ($a[0] - $b[0]);
        });

        foreach ($tmp as $k => $v) {
            $tmp[$k] = $v[2];
        }

        return $tmp;
    }
}

const array_add = "array_add";
if (!isset($excluded_functions["array_add"]) && (!function_exists("array_add") || (!false && (new \ReflectionFunction("array_add"))->isInternal()))) {
    /**
     * 配列の+演算子の関数版
     *
     * Example:
     * ```php
     * // ただの加算の関数版なので同じキーは上書きされない
     * assertSame(array_add(['a', 'b', 'c'], ['X']), ['a', 'b', 'c']);
     * // 異なるキーは生える
     * assertSame(array_add(['a', 'b', 'c'], ['x' => 'X']), ['a', 'b', 'c', 'x' => 'X']);
     * ```
     *
     * @param array $array 対象配列
     * @param array $variadic 足す配列
     * @return array 足された配列
     */
    function array_add($array, ...$variadic)
    {
        foreach ($variadic as $arg) {
            $array += $arg;
        }
        return $array;
    }
}

const array_mix = "array_mix";
if (!isset($excluded_functions["array_mix"]) && (!function_exists("array_mix") || (!false && (new \ReflectionFunction("array_mix"))->isInternal()))) {
    /**
     * 配列を交互に追加する
     *
     * 引数の配列を横断的に追加して返す。
     * 数値キーは振り直される。文字キーはそのまま追加される（同じキーは後方上書き）。
     *
     * 配列の長さが異なる場合、短い方に対しては何もしない。そのまま追加される。
     *
     * Example:
     * ```php
     * // 奇数配列と偶数配列をミックスして自然数配列を生成
     * assertSame(array_mix([1, 3, 5], [2, 4, 6]), [1, 2, 3, 4, 5, 6]);
     * // 長さが異なる場合はそのまま追加される（短い方の足りない分は無視される）
     * assertSame(array_mix([1], [2, 3, 4]), [1, 2, 3, 4]);
     * assertSame(array_mix([1, 3, 4], [2]), [1, 2, 3, 4]);
     * // 可変引数なので3配列以上も可
     * assertSame(array_mix([1], [2, 4], [3, 5, 6]), [1, 2, 3, 4, 5, 6]);
     * assertSame(array_mix([1, 4, 6], [2, 5], [3]), [1, 2, 3, 4, 5, 6]);
     * // 文字キーは維持される
     * assertSame(array_mix(['a' => 'A', 1, 3], ['b' => 'B', 2]), ['a' => 'A', 'b' => 'B', 1, 2, 3]);
     * ```
     *
     * @param array $variadic 対象配列（可変引数）
     * @return array 引数配列が交互に追加された配列
     */
    function array_mix(...$variadic)
    {
        assert(count(array_filter($variadic, function ($v) { return !is_array($v); })) === 0);

        if (!$variadic) {
            return [];
        }

        $keyses = array_map('array_keys', $variadic);
        $limit = max(array_map('count', $keyses));

        $result = [];
        for ($i = 0; $i < $limit; $i++) {
            foreach ($keyses as $n => $keys) {
                if (isset($keys[$i])) {
                    $key = $keys[$i];
                    $val = $variadic[$n][$key];
                    if (is_int($key)) {
                        $result[] = $val;
                    }
                    else {
                        $result[$key] = $val;
                    }
                }
            }
        }
        return $result;
    }
}

const array_zip = "array_zip";
if (!isset($excluded_functions["array_zip"]) && (!function_exists("array_zip") || (!false && (new \ReflectionFunction("array_zip"))->isInternal()))) {
    /**
     * 配列の各要素値で順番に配列を作る
     *
     * `array_map(null, ...$arrays)` とほぼ同義。ただし
     *
     * - 文字キーは保存される（数値キーは再割り振りされる）
     * - 一つだけ配列を与えても構造は壊れない（array_map(null) は壊れる）
     *
     * Example:
     * ```php
     * // 普通の zip
     * assertEquals(array_zip(
     *     [1, 2, 3],
     *     ['hoge', 'fuga', 'piyo']
     * ), [[1, 'hoge'], [2, 'fuga'], [3, 'piyo']]);
     * // キーが維持される
     * assertEquals(array_zip(
     *     ['a' => 1, 2, 3],
     *     ['hoge', 'b' => 'fuga', 'piyo']
     * ), [['a' => 1, 'hoge'], [2, 'b' => 'fuga'], [3, 'piyo']]);
     * ```
     *
     * @param array $arrays 対象配列（可変引数）
     * @return array 各要素値の配列
     */
    function array_zip(...$arrays)
    {
        $count = count($arrays);
        if ($count === 0) {
            throw new \InvalidArgumentException('$arrays is empty.');
        }

        // キー保持処理がかなり遅いので純粋な配列しかないのなら array_map(null) の方が（チェックを加味しても）速くなる
        foreach ($arrays as $a) {
            if (is_hasharray($a)) {
                /** @var \Generator[] $yielders */
                $yielders = array_map(function ($array) { yield from $array; }, $arrays);

                $result = [];
                for ($i = 0, $limit = max(array_map('count', $arrays)); $i < $limit; $i++) {
                    $e = [];
                    foreach ($yielders as $yielder) {
                        array_put($e, $yielder->current(), $yielder->key());
                        $yielder->next();
                    }
                    $result[] = $e;
                }
                return $result;
            }
        }

        // array_map(null) は1つだけ与えると構造がぶっ壊れる
        if ($count === 1) {
            return array_map(function ($v) { return [$v]; }, $arrays[0]);
        }
        return array_map(null, ...$arrays);

        /* MultipleIterator を使った実装。かなり遅かったので採用しなかったが、一応コメントとして残す
        $mi = new \MultipleIterator(\MultipleIterator::MIT_NEED_ANY | \MultipleIterator::MIT_KEYS_NUMERIC);
        foreach ($arrays as $array) {
            $mi->attachIterator((function ($array) { yield from $array; })($array));
        }

        $result = [];
        foreach ($mi as $k => $v) {
            $e = [];
            for ($i = 0; $i < $count; $i++) {
                (array_put)($e, $v[$i], $k[$i]);
            }
            $result[] = $e;
        }
        return $result;
        */
    }
}

const array_cross = "array_cross";
if (!isset($excluded_functions["array_cross"]) && (!function_exists("array_cross") || (!false && (new \ReflectionFunction("array_cross"))->isInternal()))) {
    /**
     * 配列の直積を返す
     *
     * 文字キーは保存されるが数値キーは再割り振りされる。
     * ただし、文字キーが重複すると例外を投げる。
     *
     * Example:
     * ```php
     * // 普通の直積
     * assertSame(array_cross(
     *     [1, 2],
     *     [3, 4]
     * ), [[1, 3], [1, 4], [2, 3], [2, 4]]);
     * // キーが維持される
     * assertSame(array_cross(
     *     ['a' => 1, 2],
     *     ['b' => 3, 4]
     * ), [['a' => 1, 'b' => 3], ['a' => 1, 4], [2, 'b' => 3], [2, 4]]);
     * ```
     *
     * @param array $arrays 対象配列（可変引数）
     * @return array 各配列値の直積
     */
    function array_cross(...$arrays)
    {
        if (!$arrays) {
            return [];
        }

        $result = [[]];
        foreach ($arrays as $array) {
            $tmp = [];
            foreach ($result as $x) {
                foreach ($array as $k => $v) {
                    if (is_string($k) && array_key_exists($k, $x)) {
                        throw new \InvalidArgumentException("duplicated key '$k'.");
                    }
                    $tmp[] = array_merge($x, [$k => $v]);
                }
            }
            $result = $tmp;
        }
        return $result;
    }
}

const array_implode = "array_implode";
if (!isset($excluded_functions["array_implode"]) && (!function_exists("array_implode") || (!false && (new \ReflectionFunction("array_implode"))->isInternal()))) {
    /**
     * 配列の各要素の間に要素を差し込む
     *
     * 歴史的な理由はないが、引数をどちらの順番でも受けつけることが可能。
     * ただし、$glue を先に渡すパターンの場合は配列指定が可変引数渡しになる。
     *
     * 文字キーは保存されるが数値キーは再割り振りされる。
     *
     * Example:
     * ```php
     * // (配列, 要素) の呼び出し
     * assertSame(array_implode(['a', 'b', 'c'], 'X'), ['a', 'X', 'b', 'X', 'c']);
     * // (要素, ...配列) の呼び出し
     * assertSame(array_implode('X', 'a', 'b', 'c'), ['a', 'X', 'b', 'X', 'c']);
     * ```
     *
     * @param iterable|string $array 対象配列
     * @param string $glue 差し込む要素
     * @return array 差し込まれた配列
     */
    function array_implode($array, $glue)
    {
        // 第1引数が回せない場合は引数を入れ替えて可変引数パターン
        if (!is_array($array) && !$array instanceof \Traversable) {
            return array_implode(array_slice(func_get_args(), 1), $array);
        }

        $result = [];
        foreach ($array as $k => $v) {
            if (is_int($k)) {
                $result[] = $v;
            }
            else {
                $result[$k] = $v;
            }
            $result[] = $glue;
        }
        array_pop($result);
        return $result;
    }
}

const array_sprintf = "array_sprintf";
if (!isset($excluded_functions["array_sprintf"]) && (!function_exists("array_sprintf") || (!false && (new \ReflectionFunction("array_sprintf"))->isInternal()))) {
    /**
     * キーと値で sprintf する
     *
     * 配列の各要素を文字列化して返すイメージ。
     * $glue を与えるとさらに implode して返す（返り値が文字列になる）。
     *
     * $format は書式文字列（$v, $k）。
     * callable を与えると sprintf ではなくコールバック処理になる（$v, $k）。
     * 省略（null）するとキーを format 文字列、値を引数として **vsprintf** する。
     *
     * Example:
     * ```php
     * $array = ['key1' => 'val1', 'key2' => 'val2'];
     * // key, value を利用した sprintf
     * assertSame(array_sprintf($array, '%2$s=%1$s'), ['key1=val1', 'key2=val2']);
     * // 第3引数を与えるとさらに implode される
     * assertSame(array_sprintf($array, '%2$s=%1$s', ' '), 'key1=val1 key2=val2');
     * // クロージャを与えるとコールバック動作になる
     * $closure = function($v, $k){return "$k=" . strtoupper($v);};
     * assertSame(array_sprintf($array, $closure, ' '), 'key1=VAL1 key2=VAL2');
     * // 省略すると vsprintf になる
     * assertSame(array_sprintf([
     *     'str:%s,int:%d' => ['sss', '3.14'],
     *     'single:%s'     => 'str',
     * ], null, '|'), 'str:sss,int:3|single:str');
     * ```
     *
     * @param iterable $array 対象配列
     * @param string|callable $format 書式文字列あるいはクロージャ
     * @param string $glue 結合文字列。未指定時は implode しない
     * @return array|string sprintf された配列
     */
    function array_sprintf($array, $format = null, $glue = null)
    {
        if (is_callable($format)) {
            $callback = func_user_func_array($format);
        }
        elseif ($format === null) {
            $callback = function ($v, $k) { return vsprintf($k, is_array($v) ? $v : [$v]); };
        }
        else {
            $callback = function ($v, $k) use ($format) { return sprintf($format, $v, $k); };
        }

        $result = [];
        foreach ($array as $k => $v) {
            $result[] = $callback($v, $k);
        }

        if ($glue !== null) {
            return implode($glue, $result);
        }

        return $result;
    }
}

const array_strpad = "array_strpad";
if (!isset($excluded_functions["array_strpad"]) && (!function_exists("array_strpad") || (!false && (new \ReflectionFunction("array_strpad"))->isInternal()))) {
    /**
     * 配列のキー・要素に文字列を付加する
     *
     * $key_prefix, $val_prefix でそれぞれ「キーに付与する文字列」「値に付与する文字列」が指定できる。
     * 配列を与えると [サフィックス, プレフィックス] という意味になる。
     * デフォルト（ただの文字列）はプレフィックス（値だけに付与したいなら array_map で十分なので）。
     *
     * Example:
     * ```php
     * $array = ['key1' => 'val1', 'key2' => 'val2'];
     * // キーにプレフィックス付与
     * assertSame(array_strpad($array, 'prefix-'), ['prefix-key1' => 'val1', 'prefix-key2' => 'val2']);
     * // 値にサフィックス付与
     * assertSame(array_strpad($array, '', ['-suffix']), ['key1' => 'val1-suffix', 'key2' => 'val2-suffix']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string|array $key_prefix キー側の付加文字列
     * @param string|array $val_prefix 値側の付加文字列
     * @return array 文字列付与された配列
     */
    function array_strpad($array, $key_prefix, $val_prefix = '')
    {
        $key_suffix = '';
        if (is_array($key_prefix)) {
            list($key_suffix, $key_prefix) = $key_prefix + [1 => ''];
        }
        $val_suffix = '';
        if (is_array($val_prefix)) {
            list($val_suffix, $val_prefix) = $val_prefix + [1 => ''];
        }

        $result = [];
        foreach ($array as $key => $val) {
            $key = $key_prefix . $key . $key_suffix;
            $val = $val_prefix . $val . $val_suffix;
            $result[$key] = $val;
        }
        return $result;
    }
}

const array_pos = "array_pos";
if (!isset($excluded_functions["array_pos"]) && (!function_exists("array_pos") || (!false && (new \ReflectionFunction("array_pos"))->isInternal()))) {
    /**
     * 配列・連想配列を問わず「N番目(0ベース)」の要素を返す
     *
     * 負数を与えると逆から N 番目となる。
     *
     * Example:
     * ```php
     * assertSame(array_pos([1, 2, 3], 1), 2);
     * assertSame(array_pos([1, 2, 3], -1), 3);
     * assertSame(array_pos(['a' => 'A', 'b' => 'B', 'c' => 'C'], 1), 'B');
     * assertSame(array_pos(['a' => 'A', 'b' => 'B', 'c' => 'C'], 1, true), 'b');
     * ```
     *
     * @param array $array 対象配列
     * @param int $position 取得する位置
     * @param bool $return_key true にすると値ではなくキーを返す
     * @return mixed 指定位置の値
     */
    function array_pos($array, $position, $return_key = false)
    {
        $position = (int) $position;
        $keys = array_keys($array);

        if ($position < 0) {
            $position = abs($position + 1);
            $keys = array_reverse($keys);
        }

        $count = count($keys);
        for ($i = 0; $i < $count; $i++) {
            if ($i === $position) {
                $key = $keys[$i];
                if ($return_key) {
                    return $key;
                }
                return $array[$key];
            }
        }

        throw new \OutOfBoundsException("$position is not found.");
    }
}

const array_pos_key = "array_pos_key";
if (!isset($excluded_functions["array_pos_key"]) && (!function_exists("array_pos_key") || (!false && (new \ReflectionFunction("array_pos_key"))->isInternal()))) {
    /**
     * 配列の指定キーの位置を返す
     *
     * Example:
     * ```php
     * assertSame(array_pos_key(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'c'), 2);
     * assertSame(array_pos_key(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'x', -1), -1);
     * ```
     *
     * @param array $array 対象配列
     * @param string|int $key 取得する位置
     * @param mixed $default 見つからなかったときのデフォルト値。指定しないと例外
     * @return mixed 指定キーの位置
     */
    function array_pos_key($array, $key, $default = null)
    {
        // very slow
        // return array_flip(array_keys($array))[$key];

        $n = 0;
        foreach ($array as $k => $v) {
            if ($k === $key) {
                return $n;
            }
            $n++;
        }

        if (func_num_args() === 2) {
            throw new \OutOfBoundsException("$key is not found.");
        }
        return $default;
    }
}

const array_of = "array_of";
if (!isset($excluded_functions["array_of"]) && (!function_exists("array_of") || (!false && (new \ReflectionFunction("array_of"))->isInternal()))) {
    /**
     * 配列を与えると指定キーの値を返すクロージャを返す
     *
     * 存在しない場合は $default を返す。
     *
     * $key に配列を与えるとそれらの値の配列を返す（lookup 的な動作）。
     * その場合、$default が活きるのは「全て無かった場合」となる。
     * さらに $key が配列の場合に限り、 $default を省略すると空配列として動作する。
     *
     * Example:
     * ```php
     * $fuga_of_array = array_of('fuga');
     * assertSame($fuga_of_array(['hoge' => 'HOGE', 'fuga' => 'FUGA']), 'FUGA');
     * ```
     *
     * @param string|int|array $key 取得したいキー
     * @param mixed $default デフォルト値
     * @return \Closure $key の値を返すクロージャ
     */
    function array_of($key, $default = null)
    {
        $nodefault = func_num_args() === 1;
        return function (array $array) use ($key, $default, $nodefault) {
            if ($nodefault) {
                return array_get($array, $key);
            }
            else {
                return array_get($array, $key, $default);
            }
        };
    }
}

const array_get = "array_get";
if (!isset($excluded_functions["array_get"]) && (!function_exists("array_get") || (!false && (new \ReflectionFunction("array_get"))->isInternal()))) {
    /**
     * デフォルト値付きの配列値取得
     *
     * 存在しない場合は $default を返す。
     *
     * $key に配列を与えるとそれらの値の配列を返す（lookup 的な動作）。
     * その場合、$default が活きるのは「全て無かった場合」となる。
     *
     * さらに $key が配列の場合に限り、 $default を省略すると空配列として動作する。
     *
     * 同様に、$key にクロージャを与えると、その返り値が true 相当のものを返す。
     * その際、 $default が配列なら一致するものを配列で返し、配列でないなら単値で返す。
     *
     * Example:
     * ```php
     * // 単純取得
     * assertSame(array_get(['a', 'b', 'c'], 1), 'b');
     * // 単純デフォルト
     * assertSame(array_get(['a', 'b', 'c'], 9, 999), 999);
     * // 配列取得
     * assertSame(array_get(['a', 'b', 'c'], [0, 2]), [0 => 'a', 2 => 'c']);
     * // 配列部分取得
     * assertSame(array_get(['a', 'b', 'c'], [0, 9]), [0 => 'a']);
     * // 配列デフォルト（null ではなく [] を返す）
     * assertSame(array_get(['a', 'b', 'c'], [9]), []);
     * // クロージャ指定＆単値（コールバックが true を返す最初の要素）
     * assertSame(array_get(['a', 'b', 'c'], function($v){return in_array($v, ['b', 'c']);}), 'b');
     * // クロージャ指定＆配列（コールバックが true を返すもの）
     * assertSame(array_get(['a', 'b', 'c'], function($v){return in_array($v, ['b', 'c']);}, []), [1 => 'b', 2 => 'c']);
     * ```
     *
     * @param array $array 配列
     * @param string|int|array $key 取得したいキー。配列を与えると全て返す。クロージャの場合は true 相当を返す
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 指定したキーの値
     */
    function array_get($array, $key, $default = null)
    {
        if (is_array($key)) {
            $result = [];
            foreach ($key as $k) {
                // 深遠な事情で少しでも高速化したかったので isset || array_keys_exist にしてある
                if (isset($array[$k]) || array_keys_exist($k, $array)) {
                    $result[$k] = $array[$k];
                }
            }
            if (!$result) {
                // 明示的に与えられていないなら [] を使用する
                if (func_num_args() === 2) {
                    $default = [];
                }
                return $default;
            }
            return $result;
        }

        if ($key instanceof \Closure) {
            $result = [];
            foreach ($array as $k => $v) {
                if ($key($v, $k)) {
                    if (func_num_args() === 2) {
                        return $v;
                    }
                    $result[$k] = $v;
                }
            }
            if (!$result) {
                return $default;
            }
            return $result;
        }

        if (array_keys_exist($key, $array)) {
            return $array[$key];
        }
        return $default;
    }
}

const array_set = "array_set";
if (!isset($excluded_functions["array_set"]) && (!function_exists("array_set") || (!false && (new \ReflectionFunction("array_set"))->isInternal()))) {
    /**
     * キー指定の配列値設定
     *
     * 第3引数を省略すると（null を与えると）言語機構を使用して配列の最後に設定する（$array[] = $value）。
     * 第3引数に配列を指定すると潜って設定する。
     *
     * Example:
     * ```php
     * $array = ['a' => 'A', 'B'];
     * // 第3引数省略（最後に連番キーで設定）
     * assertSame(array_set($array, 'Z'), 1);
     * assertSame($array, ['a' => 'A', 'B', 'Z']);
     * // 第3引数でキーを指定
     * assertSame(array_set($array, 'Z', 'z'), 'z');
     * assertSame($array, ['a' => 'A', 'B', 'Z', 'z' => 'Z']);
     * assertSame(array_set($array, 'Z', 'z'), 'z');
     * // 第3引数で配列を指定
     * assertSame(array_set($array, 'Z', ['x', 'y', 'z']), 'z');
     * assertSame($array, ['a' => 'A', 'B', 'Z', 'z' => 'Z', 'x' => ['y' => ['z' => 'Z']]]);
     * ```
     *
     * @param array $array 配列
     * @param mixed $value 設定する値
     * @param array|string|int|null $key 設定するキー
     * @param bool $require_return 返り値が不要なら false を渡す
     * @return string|int 設定したキー
     */
    function array_set(&$array, $value, $key = null, $require_return = true)
    {
        if (is_array($key)) {
            $k = array_shift($key);
            if ($key) {
                if (is_array($array) && array_key_exists($k, $array) && !is_array($array[$k])) {
                    throw new \InvalidArgumentException('$array[$k] is not array.');
                }
                return array_set(...[&$array[$k], $value, $key, $require_return]);
            }
            else {
                return array_set(...[&$array, $value, $k, $require_return]);
            }
        }

        if ($key === null) {
            $array[] = $value;
            if ($require_return === true) {
                $key = last_key($array);
            }
        }
        else {
            $array[$key] = $value;
        }
        return $key;
    }
}

const array_put = "array_put";
if (!isset($excluded_functions["array_put"]) && (!function_exists("array_put") || (!false && (new \ReflectionFunction("array_put"))->isInternal()))) {
    /**
     * キー指定の配列値設定
     *
     * array_set とほとんど同じ。
     * 第3引数を省略すると（null を与えると）言語機構を使用して配列の最後に設定する（$array[] = $value）。
     * また、**int を与えても同様の動作**となる。
     * 第3引数に配列を指定すると潜って設定する。
     *
     * array_set における $require_return は廃止している。
     * これはもともと end や last_key が遅かったのでオプショナルにしていたが、もう改善しているし、7.3 から array_key_last があるので、呼び元で適宜使えば良い。
     *
     * Example:
     * ```php
     * $array = ['a' => 'A', 'B'];
     * // 第3引数 int
     * assertSame(array_put($array, 'Z', 999), 1);
     * assertSame($array, ['a' => 'A', 'B', 'Z']);
     * // 第3引数省略（最後に連番キーで設定）
     * assertSame(array_put($array, 'Z'), 2);
     * assertSame($array, ['a' => 'A', 'B', 'Z', 'Z']);
     * // 第3引数でキーを指定
     * assertSame(array_put($array, 'Z', 'z'), 'z');
     * assertSame($array, ['a' => 'A', 'B', 'Z', 'Z', 'z' => 'Z']);
     * assertSame(array_put($array, 'Z', 'z'), 'z');
     * // 第3引数で配列を指定
     * assertSame(array_put($array, 'Z', ['x', 'y', 'z']), 'z');
     * assertSame($array, ['a' => 'A', 'B', 'Z', 'Z', 'z' => 'Z', 'x' => ['y' => ['z' => 'Z']]]);
     * ```
     *
     * @param array $array 配列
     * @param mixed $value 設定する値
     * @param array|string|int|null $key 設定するキー
     * @return string|int 設定したキー
     */
    function array_put(&$array, $value, $key = null)
    {
        if (is_array($key)) {
            $k = array_shift($key);
            if ($key) {
                if (is_array($array) && array_key_exists($k, $array) && !is_array($array[$k])) {
                    throw new \InvalidArgumentException('$array[$k] is not array.');
                }
                return array_put(...[&$array[$k], $value, $key]);
            }
            else {
                return array_put(...[&$array, $value, $k]);
            }
        }

        if ($key === null || is_int($key)) {
            $array[] = $value;
            // compatible array_key_last under 7.3
            end($array);
            $key = key($array);
        }
        else {
            $array[$key] = $value;
        }
        return $key;
    }
}

const array_unset = "array_unset";
if (!isset($excluded_functions["array_unset"]) && (!function_exists("array_unset") || (!false && (new \ReflectionFunction("array_unset"))->isInternal()))) {
    /**
     * 伏せると同時にその値を返す
     *
     * $key に配列を与えると全て伏せて配列で返す。
     * その場合、$default が活きるのは「全て無かった場合」となる。
     *
     * さらに $key が配列の場合に限り、 $default を省略すると空配列として動作する。
     *
     * 配列を与えた場合の返り値は与えた配列の順番・キーが活きる。
     * これを利用すると list の展開の利便性が上がったり、連想配列で返すことができる。
     *
     * 同様に、$key にクロージャを与えると、その返り値が true 相当のものを伏せて配列で返す。
     * callable ではなくクロージャのみ対応する。
     *
     * Example:
     * ```php
     * $array = ['a' => 'A', 'b' => 'B'];
     * // ない場合は $default を返す
     * assertSame(array_unset($array, 'x', 'X'), 'X');
     * // 指定したキーを返す。そのキーは伏せられている
     * assertSame(array_unset($array, 'a'), 'A');
     * assertSame($array, ['b' => 'B']);
     *
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // 配列を与えるとそれらを返す。そのキーは全て伏せられている
     * assertSame(array_unset($array, ['a', 'b', 'x']), ['A', 'B']);
     * assertSame($array, ['c' => 'C']);
     *
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // 配列のキーは返されるキーを表す。順番も維持される
     * assertSame(array_unset($array, ['x2' => 'b', 'x1' => 'a']), ['x2' => 'B', 'x1' => 'A']);
     *
     * $array = ['hoge' => 'HOGE', 'fuga' => 'FUGA', 'piyo' => 'PIYO'];
     * // 値に "G" を含むものを返す。その要素は伏せられている
     * assertSame(array_unset($array, function($v){return strpos($v, 'G') !== false;}), ['hoge' => 'HOGE', 'fuga' => 'FUGA']);
     * assertSame($array, ['piyo' => 'PIYO']);
     * ```
     *
     * @param array $array 配列
     * @param string|int|array|callable $key 伏せたいキー。配列を与えると全て伏せる。クロージャの場合は true 相当を伏せる
     * @param mixed $default 無かった場合のデフォルト値
     * @return mixed 指定したキーの値
     */
    function array_unset(&$array, $key, $default = null)
    {
        if (is_array($key)) {
            $result = [];
            foreach ($key as $rk => $ak) {
                if (array_keys_exist($ak, $array)) {
                    $result[$rk] = $array[$ak];
                    unset($array[$ak]);
                }
            }
            if (!$result) {
                // 明示的に与えられていないなら [] を使用する
                if (func_num_args() === 2) {
                    $default = [];
                }
                return $default;
            }
            return $result;
        }

        if ($key instanceof \Closure) {
            $result = [];
            foreach ($array as $k => $v) {
                if ($key($v, $k)) {
                    $result[$k] = $v;
                    unset($array[$k]);
                }
            }
            if (!$result) {
                return $default;
            }
            return $result;
        }

        if (array_keys_exist($key, $array)) {
            $result = $array[$key];
            unset($array[$key]);
            return $result;
        }
        return $default;
    }
}

const array_dive = "array_dive";
if (!isset($excluded_functions["array_dive"]) && (!function_exists("array_dive") || (!false && (new \ReflectionFunction("array_dive"))->isInternal()))) {
    /**
     * パス形式で配列値を取得
     *
     * 存在しない場合は $default を返す。
     *
     * Example:
     * ```php
     * $array = [
     *     'a' => [
     *         'b' => [
     *             'c' => 'vvv'
     *         ]
     *     ]
     * ];
     * assertSame(array_dive($array, 'a.b.c'), 'vvv');
     * assertSame(array_dive($array, 'a.b.x', 9), 9);
     * // 配列を与えても良い。その場合 $delimiter 引数は意味をなさない
     * assertSame(array_dive($array, ['a', 'b', 'c']), 'vvv');
     * ```
     *
     * @param array $array 調べる配列
     * @param string|array $path パス文字列。配列も与えられる
     * @param mixed $default 無かった場合のデフォルト値
     * @param string $delimiter パスの区切り文字。大抵は '.' か '/'
     * @return mixed パスが示す配列の値
     */
    function array_dive($array, $path, $default = null, $delimiter = '.')
    {
        $keys = is_array($path) ? $path : explode($delimiter, $path);
        foreach ($keys as $key) {
            if (!is_arrayable($array)) {
                return $default;
            }
            if (!array_keys_exist($key, $array)) {
                return $default;
            }
            $array = $array[$key];
        }
        return $array;
    }
}

const array_keys_exist = "array_keys_exist";
if (!isset($excluded_functions["array_keys_exist"]) && (!function_exists("array_keys_exist") || (!false && (new \ReflectionFunction("array_keys_exist"))->isInternal()))) {
    /**
     * array_key_exists の複数版
     *
     * 指定キーが全て存在するなら true を返す。
     * 配列ではなく単一文字列を与えても動作する（array_key_exists と全く同じ動作になる）。
     *
     * $keys に空を与えると例外を投げる。
     * $keys に配列を与えるとキーで潜ってチェックする（Example 参照）。
     *
     * Example:
     * ```php
     * // すべて含むので true
     * assertTrue(array_keys_exist(['a', 'b', 'c'], ['a' => 'A', 'b' => 'B', 'c' => 'C']));
     * // N は含まないので false
     * assertFalse(array_keys_exist(['a', 'b', 'N'], ['a' => 'A', 'b' => 'B', 'c' => 'C']));
     * // 配列を与えると潜る（日本語で言えば「a というキーと、x というキーとその中に x1, x2 というキーがあるか？」）
     * assertTrue(array_keys_exist(['a', 'x' => ['x1', 'x2']], ['a' => 'A', 'x' => ['x1' => 'X1', 'x2' => 'X2']]));
     * ```
     *
     * @param array|string $keys 調べるキー
     * @param array|\ArrayAccess $array 調べる配列
     * @return bool 指定キーが全て存在するなら true
     */
    function array_keys_exist($keys, $array)
    {
        $keys = is_iterable($keys) ? $keys : [$keys];
        if (is_empty($keys)) {
            throw new \InvalidArgumentException('$keys is empty.');
        }

        $is_arrayaccess = $array instanceof \ArrayAccess;

        foreach ($keys as $k => $key) {
            if (is_array($key)) {
                // まずそのキーをチェックして
                if (!array_keys_exist($k, $array)) {
                    return false;
                }
                // あるなら再帰する
                if (!array_keys_exist($key, $array[$k])) {
                    return false;
                }
            }
            elseif ($is_arrayaccess) {
                if (!$array->offsetExists($key)) {
                    return false;
                }
            }
            elseif (!array_key_exists($key, $array)) {
                return false;
            }
        }
        return true;
    }
}

const array_find = "array_find";
if (!isset($excluded_functions["array_find"]) && (!function_exists("array_find") || (!false && (new \ReflectionFunction("array_find"))->isInternal()))) {
    /**
     * array_search のクロージャ版のようなもの
     *
     * コールバックの返り値が true 相当のものを返す。
     * $is_key に true を与えるとそのキーを返す（デフォルトの動作）。
     * $is_key に false を与えるとコールバックの結果を返す。
     *
     * この関数は論理値 FALSE を返す可能性がありますが、FALSE として評価される値を返す可能性もあります。
     *
     * Example:
     * ```php
     * // 最初に見つかったキーを返す
     * assertSame(array_find(['a', 'b', '9'], 'ctype_digit'), 2);
     * assertSame(array_find(['a', 'b', '9'], function($v){return $v === 'b';}), 1);
     * // 最初に見つかったコールバック結果を返す（最初の数字の2乗を返す）
     * $ifnumeric2power = function($v){return ctype_digit($v) ? $v * $v : false;};
     * assertSame(array_find(['a', 'b', '9'], $ifnumeric2power, false), 81);
     * ```
     *
     * @param iterable $array 調べる配列
     * @param callable $callback 評価コールバック
     * @param bool $is_key キーを返すか否か
     * @return mixed コールバックが true を返した最初のキー。存在しなかったら false
     */
    function array_find($array, $callback, $is_key = true)
    {
        $callback = func_user_func_array($callback);

        foreach ($array as $k => $v) {
            $result = $callback($v, $k);
            if ($result) {
                if ($is_key) {
                    return $k;
                }
                return $result;
            }
        }
        return false;
    }
}

const array_grep_key = "array_grep_key";
if (!isset($excluded_functions["array_grep_key"]) && (!function_exists("array_grep_key") || (!false && (new \ReflectionFunction("array_grep_key"))->isInternal()))) {
    /**
     * キーを正規表現でフィルタする
     *
     * Example:
     * ```php
     * assertSame(array_grep_key(['a' => 'A', 'aa' => 'AA', 'b' => 'B'], '#^a#'), ['a' => 'A', 'aa' => 'AA']);
     * assertSame(array_grep_key(['a' => 'A', 'aa' => 'AA', 'b' => 'B'], '#^a#', true), ['b' => 'B']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string $regex 正規表現
     * @param bool $not true にすると「マッチしない」でフィルタする
     * @return array 正規表現でフィルタされた配列
     */
    function array_grep_key($array, $regex, $not = false)
    {
        $result = [];
        foreach ($array as $k => $v) {
            $match = preg_match($regex, $k);
            if ((!$not && $match) || ($not && !$match)) {
                $result[$k] = $v;
            }
        }
        return $result;
    }
}

const array_map_recursive = "array_map_recursive";
if (!isset($excluded_functions["array_map_recursive"]) && (!function_exists("array_map_recursive") || (!false && (new \ReflectionFunction("array_map_recursive"))->isInternal()))) {
    /**
     * array_map の再帰版
     *
     * 下記の点で少し array_map とは挙動が異なる。
     *
     * - 配列だけでなく iterable も対象になる（引数で指定可能。デフォルト true）
     *     - つまりオブジェクト構造は維持されず、結果はすべて配列になる
     * - 値だけでなくキーも渡ってくる
     *
     * Example:
     * ```php
     * // array_walk 等と同様に葉のみが渡ってくる（iterable も対象になる）
     * assertSame(array_map_recursive([
     *     'k' => 'v',
     *     'c' => new \ArrayObject([
     *         'k1' => 'v1',
     *         'k2' => 'v2',
     *     ]),
     * ], 'strtoupper'), [
     *     'k' => 'V',
     *     'c' => [
     *         'k1' => 'V1',
     *         'k2' => 'V2',
     *     ],
     * ]);
     *
     * // ただし、その挙動は引数で変更可能
     * assertSame(array_map_recursive([
     *     'k' => 'v',
     *     'c' => new \ArrayObject([
     *         'k1' => 'v1',
     *         'k2' => 'v2',
     *     ]),
     * ], 'gettype', false), [
     *     'k' => 'string',
     *     'c' => 'object',
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param bool $iterable is_iterable で判定するか
     * @return array map された新しい配列
     */
    function array_map_recursive($array, $callback, $iterable = true)
    {
        $callback = func_user_func_array($callback);

        // ↑の変換を再帰ごとにやるのは現実的ではないのでクロージャに閉じ込めて再帰する
        $main = static function ($array) use (&$main, $callback, $iterable) {
            $result = [];
            foreach ($array as $k => $v) {
                if (($iterable && is_iterable($v)) || (!$iterable && is_array($v))) {
                    $result[$k] = $main($v);
                }
                else {
                    $result[$k] = $callback($v, $k);
                }
            }
            return $result;
        };

        return $main($array);
    }
}

const array_map_key = "array_map_key";
if (!isset($excluded_functions["array_map_key"]) && (!function_exists("array_map_key") || (!false && (new \ReflectionFunction("array_map_key"))->isInternal()))) {
    /**
     * キーをマップして変換する
     *
     * $callback が null を返すとその要素は取り除かれる。
     *
     * Example:
     * ```php
     * assertSame(array_map_key(['a' => 'A', 'b' => 'B'], 'strtoupper'), ['A' => 'A', 'B' => 'B']);
     * assertSame(array_map_key(['a' => 'A', 'b' => 'B'], function(){}), []);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @return array キーが変換された新しい配列
     */
    function array_map_key($array, $callback)
    {
        $result = [];
        foreach ($array as $k => $v) {
            $k2 = $callback($k);
            if ($k2 !== null) {
                $result[$k2] = $v;
            }
        }
        return $result;
    }
}

const array_filter_not = "array_filter_not";
if (!isset($excluded_functions["array_filter_not"]) && (!function_exists("array_filter_not") || (!false && (new \ReflectionFunction("array_filter_not"))->isInternal()))) {
    /**
     * array_filter の否定版
     *
     * 単に否定するだけなのにクロージャを書きたくないことはまれによくあるはず。
     *
     * Example:
     * ```php
     * assertSame(array_filter_not(['a', '', 'c'], 'strlen'), [1 => '']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価 callable
     * @return array $callback が false を返した新しい配列
     */
    function array_filter_not($array, $callback)
    {
        return array_filter(arrayval($array, false), not_func($callback));
    }
}

const array_filter_key = "array_filter_key";
if (!isset($excluded_functions["array_filter_key"]) && (!function_exists("array_filter_key") || (!false && (new \ReflectionFunction("array_filter_key"))->isInternal()))) {
    /**
     * キーを主軸とした array_filter
     *
     * $callback が要求するなら値も渡ってくる。 php 5.6 の array_filter の ARRAY_FILTER_USE_BOTH と思えばよい。
     * ただし、完全な互換ではなく、引数順は ($k, $v) なので注意。
     *
     * Example:
     * ```php
     * assertSame(array_filter_key(['a', 'b', 'c'], function ($k, $v) { return $k !== 1; }), [0 => 'a', 2 => 'c']);
     * assertSame(array_filter_key(['a', 'b', 'c'], function ($k, $v) { return $v !== 'b'; }), [0 => 'a', 2 => 'c']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @return array $callback が true を返した新しい配列
     */
    function array_filter_key($array, $callback)
    {
        $result = [];
        foreach ($array as $k => $v) {
            if ($callback($k, $v)) {
                $result[$k] = $v;
            }
        }
        return $result;
    }
}

const array_filter_eval = "array_filter_eval";
if (!isset($excluded_functions["array_filter_eval"]) && (!function_exists("array_filter_eval") || (!false && (new \ReflectionFunction("array_filter_eval"))->isInternal()))) {
    /**
     * eval で評価して array_filter する
     *
     * キーは $k, 値は $v で宣言される。
     *
     * Example:
     * ```php
     * assertSame(array_filter_eval(['a', 'b', 'c'], '$k !== 1'), [0 => 'a', 2 => 'c']);
     * assertSame(array_filter_eval(['a', 'b', 'c'], '$v !== "b"'), [0 => 'a', 2 => 'c']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string $expression eval コード
     * @return array $expression が true を返した新しい配列
     */
    function array_filter_eval($array, $expression)
    {
        return array_filter_key($array, eval_func($expression, 'k', 'v'));
    }
}

const array_where = "array_where";
if (!isset($excluded_functions["array_where"]) && (!function_exists("array_where") || (!false && (new \ReflectionFunction("array_where"))->isInternal()))) {
    /**
     * 指定キーの要素で array_filter する
     *
     * array_column があるなら array_where があってもいいはず。
     *
     * $column はコールバックに渡ってくる配列のキー名を渡す。null を与えると行全体が渡ってくる。
     * $callback は絞り込み条件を渡す。null を与えると true 相当の値でフィルタする。
     * つまり $column も $callback も省略した場合、実質的に array_filter と同じ動作になる。
     *
     * $column は配列を受け入れる。配列を渡した場合その値の共通項がコールバックに渡る。
     * 連想配列の場合は「キーのカラム == 値」で filter する（それぞれで AND。厳密かどうかは $callback で指定。説明が難しいので Example を参照）。
     *
     * $callback が要求するならキーも渡ってくる。
     *
     * Example:
     * ```php
     * $array = [
     *     0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
     *     1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
     *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
     * ];
     * // 'flag' が true 相当のものだけ返す
     * assertSame(array_where($array, 'flag'), [
     *     1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
     * ]);
     * // 'name' に 'h' を含むものだけ返す
     * $contain_h = function($name){return strpos($name, 'h') !== false;};
     * assertSame(array_where($array, 'name', $contain_h), [
     *     0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
     * ]);
     * // $callback が引数2つならキーも渡ってくる（キーが 2 のものだけ返す）
     * $equal_2 = function($row, $key){return $key === 2;};
     * assertSame(array_where($array, null, $equal_2), [
     *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
     * ]);
     * // $column に配列を渡すと共通項が渡ってくる
     * $idname_is_2fuga = function($idname){return ($idname['id'] . $idname['name']) === '2fuga';};
     * assertSame(array_where($array, ['id', 'name'], $idname_is_2fuga), [
     *     1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
     * ]);
     * // $column に連想配列を渡すと「キーのカラム == 値」で filter する（要するに「name が piyo かつ flag が false」で filter）
     * assertSame(array_where($array, ['name' => 'piyo', 'flag' => false]), [
     *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
     * ]);
     * // $column の連想配列の値にはコールバックが渡せる（それぞれで AND）
     * assertSame(array_where($array, [
     *     'id'   => function($id){return $id >= 3;},                       // id が 3 以上
     *     'name' => function($name){return strpos($name, 'o') !== false;}, // name に o を含む
     * ]), [
     *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string|array|null $column キー名
     * @param callable $callback 評価クロージャ
     * @return array $where が真を返した新しい配列
     */
    function array_where($array, $column = null, $callback = null)
    {
        $is_array = is_array($column);
        if ($is_array) {
            if (is_hasharray($column)) {
                if ($callback !== null && !is_bool($callback)) {
                    throw new \InvalidArgumentException('if hash array $column, $callback must be bool.');
                }
                $callbacks = array_map(function ($c) use ($callback) {
                    if ($c instanceof \Closure) {
                        return $c;
                    }
                    return $callback ? function ($v) use ($c) { return $v === $c; } : function ($v) use ($c) { return $v == $c; };
                }, $column);
                $callback = function ($vv, $k) use ($callbacks) {
                    foreach ($callbacks as $c => $callback) {
                        if (!$callback($vv[$c], $k)) {
                            return false;
                        }
                    }
                    return true;
                };
            }
            else {
                $column = array_flip($column);
            }
        }

        $callback = func_user_func_array($callback);

        $result = [];
        foreach ($array as $k => $v) {
            if ($column === null) {
                $vv = $v;
            }
            elseif ($is_array) {
                $vv = array_intersect_key($v, $column);
            }
            else {
                $vv = $v[$column];
            }

            if ($callback($vv, $k)) {
                $result[$k] = $v;
            }
        }
        return $result;
    }
}

const array_map_filter = "array_map_filter";
if (!isset($excluded_functions["array_map_filter"]) && (!function_exists("array_map_filter") || (!false && (new \ReflectionFunction("array_map_filter"))->isInternal()))) {
    /**
     * array_map + array_filter する
     *
     * コールバックを適用して、結果が true 相当の要素のみ取り出す。
     * $strict に true を与えると「null でない」要素のみ返される。
     *
     * $callback が要求するならキーも渡ってくる。
     *
     * Example:
     * ```php
     * assertSame(array_map_filter([' a ', ' b ', ''], 'trim'), ['a', 'b']);
     * assertSame(array_map_filter([' a ', ' b ', ''], 'trim', true), ['a', 'b', '']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param bool $strict 厳密比較フラグ。 true だと null のみが偽とみなされる
     * @return array $callback が真を返した新しい配列
     */
    function array_map_filter($array, $callback, $strict = false)
    {
        $callback = func_user_func_array($callback);
        $result = [];
        foreach ($array as $k => $v) {
            $vv = $callback($v, $k);
            if (($strict && $vv !== null) || (!$strict && $vv)) {
                $result[$k] = $vv;
            }
        }
        return $result;
    }
}

const array_map_method = "array_map_method";
if (!isset($excluded_functions["array_map_method"]) && (!function_exists("array_map_method") || (!false && (new \ReflectionFunction("array_map_method"))->isInternal()))) {
    /**
     * メソッドを指定できるようにした array_map
     *
     * 配列内の要素は全て同一（少なくともシグネチャが同じ $method が存在する）オブジェクトでなければならない。
     * スルーする場合は $ignore=true とする。スルーした場合 map ではなく filter される（結果配列に含まれない）。
     * $ignore=null とすると 何もせずそのまま要素を返す。
     *
     * Example:
     * ```php
     * $exa = new \Exception('a');
     * $exb = new \Exception('b');
     * $std = new \stdClass();
     * // getMessage で map される
     * assertSame(array_map_method([$exa, $exb], 'getMessage'), ['a', 'b']);
     * // getMessage で map されるが、メソッドが存在しない場合は取り除かれる
     * assertSame(array_map_method([$exa, $exb, $std, null], 'getMessage', [], true), ['a', 'b']);
     * // getMessage で map されるが、メソッドが存在しない場合はそのまま返す
     * assertSame(array_map_method([$exa, $exb, $std, null], 'getMessage', [], null), ['a', 'b', $std, null]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string $method メソッド
     * @param array $args メソッドに渡る引数
     * @param bool|null $ignore メソッドが存在しない場合にスルーするか。null を渡すと要素そのものを返す
     * @return array $method が true を返した新しい配列
     */
    function array_map_method($array, $method, $args = [], $ignore = false)
    {
        if ($ignore === true) {
            $array = array_filter(arrayval($array, false), function ($object) use ($method) {
                return is_callable([$object, $method]);
            });
        }
        return array_map(function ($object) use ($method, $args, $ignore) {
            if ($ignore === null && !is_callable([$object, $method])) {
                return $object;
            }
            return ([$object, $method])(...$args);
        }, arrayval($array, false));
    }
}

const array_maps = "array_maps";
if (!isset($excluded_functions["array_maps"]) && (!function_exists("array_maps") || (!false && (new \ReflectionFunction("array_maps"))->isInternal()))) {
    /**
     * 複数コールバックを指定できる array_map
     *
     * 指定したコールバックで複数回回してマップする。
     * `array_maps($array, $f, $g)` は `array_map($g, array_map($f, $array))` とほぼ等しい。
     * ただし、引数は順番が違う（可変引数のため）し、コールバックが要求するならキーも渡ってくる。
     *
     * 少し変わった仕様として、コールバックに [$method => $args] を付けるとそれはメソッド呼び出しになる。
     * つまり各要素 $v に対して `$v->$method(...$args)` がマップ結果になる。
     * さらに引数が不要なら `@method` とするだけで良い。
     *
     * Example:
     * ```php
     * // 値を3乗したあと16進表記にして大文字化する
     * assertSame(array_maps([1, 2, 3, 4, 5], rbind('pow', 3), 'dechex', 'strtoupper'), ['1', '8', '1B', '40', '7D']);
     * // キーも渡ってくる
     * assertSame(array_maps(['a' => 'A', 'b' => 'B'], function($v, $k){return "$k:$v";}), ['a' => 'a:A', 'b' => 'b:B']);
     * // メソッドコールもできる（引数不要なら `@method` でも同じ）
     * assertSame(array_maps([new \Exception('a'), new \Exception('b')], ['getMessage' => []]), ['a', 'b']);
     * assertSame(array_maps([new \Exception('a'), new \Exception('b')], '@getMessage'), ['a', 'b']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable[] $callbacks 評価クロージャ配列
     * @return array 評価クロージャを通した新しい配列
     */
    function array_maps($array, ...$callbacks)
    {
        $result = arrayval($array, false);
        foreach ($callbacks as $callback) {
            if (is_string($callback) && $callback[0] === '@') {
                $margs = [];
                $callback = substr($callback, 1);
            }
            elseif (is_array($callback) && count($callback) === 1) {
                $margs = reset($callback);
                $callback = key($callback);
            }
            else {
                $margs = null;
                $callback = func_user_func_array($callback);
            }
            foreach ($result as $k => $v) {
                if (isset($margs)) {
                    $result[$k] = ([$v, $callback])(...$margs);
                }
                else {
                    $result[$k] = $callback($v, $k);
                }
            }
        }
        return $result;
    }
}

const array_kmap = "array_kmap";
if (!isset($excluded_functions["array_kmap"]) && (!function_exists("array_kmap") || (!false && (new \ReflectionFunction("array_kmap"))->isInternal()))) {
    /**
     * キーも渡ってくる array_map
     *
     * `array_map($callback, $array, array_keys($array))` とほとんど変わりはない。
     * 違いは下記。
     *
     * - 引数の順番が異なる（$array が先）
     * - キーが死なない（array_map は複数配列を与えるとキーが死ぬ）
     * - 配列だけでなく Traversable も受け入れる
     * - callback の第3引数に 0 からの連番が渡ってくる
     *
     * Example:
     * ```php
     * // キー・値をくっつけるシンプルな例
     * assertSame(array_kmap([
     *     'k1' => 'v1',
     *     'k2' => 'v2',
     *     'k3' => 'v3',
     * ], function($v, $k){return "$k:$v";}), [
     *     'k1' => 'k1:v1',
     *     'k2' => 'k2:v2',
     *     'k3' => 'k3:v3',
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @return array $callback を通した新しい配列
     */
    function array_kmap($array, $callback)
    {
        $callback = func_user_func_array($callback);

        $n = 0;
        $result = [];
        foreach ($array as $k => $v) {
            $result[$k] = $callback($v, $k, $n++);
        }
        return $result;
    }
}

const array_nmap = "array_nmap";
if (!isset($excluded_functions["array_nmap"]) && (!function_exists("array_nmap") || (!false && (new \ReflectionFunction("array_nmap"))->isInternal()))) {
    /**
     * 要素値を $callback の n 番目(0ベース)に適用して array_map する
     *
     * 引数 $n に配列を与えると [キー番目 => 値番目] とみなしてキー・値も渡される（Example 参照）。
     * その際、「挿入後の番目」ではなく、単純に「元の引数の番目」であることに留意。キー・値が同じ位置を指定している場合はキーが先にくる。
     *
     * Example:
     * ```php
     * // 1番目に値を渡して map
     * $sprintf = function(){return vsprintf('%s%s%s', func_get_args());};
     * assertSame(array_nmap(['a', 'b'], $sprintf, 1, 'prefix-', '-suffix'), ['prefix-a-suffix', 'prefix-b-suffix']);
     * // 1番目にキー、2番目に値を渡して map
     * $sprintf = function(){return vsprintf('%s %s %s %s %s', func_get_args());};
     * assertSame(array_nmap(['k' => 'v'], $sprintf, [1 => 2], 'a', 'b', 'c'), ['k' => 'a k b v c']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param int|array $n 要素値を入れる引数番目。配列を渡すとキー・値の両方を指定でき、両方が渡ってくる
     * @param mixed $variadic $callback に渡され、改変される引数（可変引数）
     * @return array 評価クロージャを通した新しい配列
     */
    function array_nmap($array, $callback, $n, ...$variadic)
    {
        /** @var $kn */
        /** @var $vn */

        $is_array = is_array($n);
        $args = $variadic;

        // 配列が来たら [キー番目 => 値番目] とみなす
        if ($is_array) {
            if (empty($n)) {
                throw new \InvalidArgumentException('array $n is empty.');
            }
            list($kn, $vn) = first_keyvalue($n);

            // array_insert は負数も受け入れられるが、それを考慮しだすともう収拾がつかない
            if ($kn < 0 || $vn < 0) {
                throw new \InvalidArgumentException('$kn, $vn must be positive.');
            }

            // どちらが大きいかで順番がズレるので分岐しなければならない
            if ($kn <= $vn) {
                $args = array_insert($args, null, $kn);
                $args = array_insert($args, null, ++$vn);// ↑で挿入してるので+1
            }
            else {
                $args = array_insert($args, null, $vn);
                $args = array_insert($args, null, ++$kn);// ↑で挿入してるので+1
            }
        }
        else {
            $args = array_insert($args, null, $n);
        }

        $result = [];
        foreach ($array as $k => $v) {
            // キー値モードなら両方埋める
            if ($is_array) {
                $args[$kn] = $k;
                $args[$vn] = $v;
            }
            // 値のみなら値だけ
            else {
                $args[$n] = $v;
            }
            $result[$k] = $callback(...$args);
        }
        return $result;
    }
}

const array_lmap = "array_lmap";
if (!isset($excluded_functions["array_lmap"]) && (!function_exists("array_lmap") || (!false && (new \ReflectionFunction("array_lmap"))->isInternal()))) {
    /**
     * 要素値を $callback の最左に適用して array_map する
     *
     * Example:
     * ```php
     * $sprintf = function(){return vsprintf('%s%s', func_get_args());};
     * assertSame(array_lmap(['a', 'b'], $sprintf, '-suffix'), ['a-suffix', 'b-suffix']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param mixed $variadic $callback に渡され、改変される引数（可変引数）
     * @return array 評価クロージャを通した新しい配列
     */
    function array_lmap($array, $callback, ...$variadic)
    {
        return array_nmap(...array_insert(func_get_args(), 0, 2));
    }
}

const array_rmap = "array_rmap";
if (!isset($excluded_functions["array_rmap"]) && (!function_exists("array_rmap") || (!false && (new \ReflectionFunction("array_rmap"))->isInternal()))) {
    /**
     * 要素値を $callback の最右に適用して array_map する
     *
     * Example:
     * ```php
     * $sprintf = function(){return vsprintf('%s%s', func_get_args());};
     * assertSame(array_rmap(['a', 'b'], $sprintf, 'prefix-'), ['prefix-a', 'prefix-b']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param mixed $variadic $callback に渡され、改変される引数（可変引数）
     * @return array 評価クロージャを通した新しい配列
     */
    function array_rmap($array, $callback, ...$variadic)
    {
        return array_nmap(...array_insert(func_get_args(), func_num_args() - 2, 2));
    }
}

const array_each = "array_each";
if (!isset($excluded_functions["array_each"]) && (!function_exists("array_each") || (!false && (new \ReflectionFunction("array_each"))->isInternal()))) {
    /**
     * array_reduce の参照版（のようなもの）
     *
     * 配列をループで回し、その途中経過、値、キー、連番をコールバック引数で渡して最終的な結果を返り値として返す。
     * array_reduce と少し似てるが、下記の点が異なる。
     *
     * - いわゆる $carry は返り値で表すのではなく、参照引数で表す
     * - 値だけでなくキー、連番も渡ってくる
     * - 巨大配列の場合でも速度劣化が少ない（array_reduce に巨大配列を渡すと実用にならないレベルで遅くなる）
     *
     * $callback の引数は `($value, $key, $n)` （$n はキーとは関係がない 0 ～ 要素数-1 の通し連番）。
     *
     * 返り値ではなく参照引数なので return する必要はない（ワンライナーが書きやすくなる）。
     * 返り値が空くのでループ制御に用いる。
     * 今のところ $callback が false を返すとそこで break するのみ。
     *
     * 第3引数を省略した場合、**クロージャの第1引数のデフォルト値が使われる**。
     * これは特筆すべき動作で、不格好な第3引数を完全に省略することができる（サンプルコードを参照）。
     * ただし「php の文法違反（今のところエラーにはならないし、全てにデフォルト値をつければ一応回避可能）」「リフレクションを使う（ほんの少し遅くなる）」などの弊害が有るので推奨はしない。
     * （ただ、「意図していることをコードで表す」といった観点ではこの記法の方が正しいとも思う）。
     *
     * Example:
     * ```php
     * // 全要素を文字列的に足し合わせる
     * assertSame(array_each([1, 2, 3, 4, 5], function(&$carry, $v){$carry .= $v;}, ''), '12345');
     * // 値をキーにして要素を2乗値にする
     * assertSame(array_each([1, 2, 3, 4, 5], function(&$carry, $v){$carry[$v] = $v * $v;}, []), [
     *     1 => 1,
     *     2 => 4,
     *     3 => 9,
     *     4 => 16,
     *     5 => 25,
     * ]);
     * // 上記と同じ。ただし、3 で break する
     * assertSame(array_each([1, 2, 3, 4, 5], function(&$carry, $v, $k){
     *     if ($k === 3) return false;
     *     $carry[$v] = $v * $v;
     * }, []), [
     *     1 => 1,
     *     2 => 4,
     *     3 => 9,
     * ]);
     *
     * // 下記は完全に同じ（第3引数の代わりにデフォルト引数を使っている）
     * assertSame(
     *     array_each([1, 2, 3], function(&$carry = [], $v) {
     *         $carry[$v] = $v * $v;
     *     }),
     *     array_each([1, 2, 3], function(&$carry, $v) {
     *         $carry[$v] = $v * $v;
     *     }, [])
     *     // 個人的に↑のようなぶら下がり引数があまり好きではない（クロージャを最後の引数にしたい）
     * );
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ。(&$carry, $key, $value) を受ける
     * @param mixed $default ループの最初や空の場合に適用される値
     * @return mixed each した結果
     */
    function array_each($array, $callback, $default = null)
    {
        if (func_num_args() === 2) {
            /** @var \ReflectionFunction $ref */
            $ref = reflect_callable($callback);
            $params = $ref->getParameters();
            if ($params[0]->isDefaultValueAvailable()) {
                $default = $params[0]->getDefaultValue();
            }
        }

        $n = 0;
        foreach ($array as $k => $v) {
            $return = $callback($default, $v, $k, $n++);
            if ($return === false) {
                break;
            }
        }
        return $default;
    }
}

const array_depth = "array_depth";
if (!isset($excluded_functions["array_depth"]) && (!function_exists("array_depth") || (!false && (new \ReflectionFunction("array_depth"))->isInternal()))) {
    /**
     * 配列の次元数を返す
     *
     * フラット配列は 1 と定義する。
     * つまり、配列を与える限りは 0 以下を返すことはない。
     *
     * 第2引数 $max_depth を与えるとその階層になった時点で走査を打ち切る。
     * 「1階層のみか？」などを調べるときは指定したほうが高速に動作する。
     *
     * Example:
     * ```php
     * assertSame(array_depth([]), 1);
     * assertSame(array_depth(['hoge']), 1);
     * assertSame(array_depth([['nest1' => ['nest2']]]), 3);
     * ```
     *
     * @param array $array 調べる配列
     * @param int|null $max_depth 最大階層数
     * @return int 次元数。素のフラット配列は 1
     */
    function array_depth($array, $max_depth = null)
    {
        assert((is_null($max_depth)) || $max_depth > 0);

        $main = function ($array, $depth) use (&$main, $max_depth) {
            // $max_depth を超えているなら打ち切る
            if ($max_depth !== null && $depth >= $max_depth) {
                return 1;
            }

            // 配列以外に興味はない
            $arrays = array_filter($array, 'is_array');

            // ネストしない配列は 1 と定義
            if (!$arrays) {
                return 1;
            }

            // 配下の内で最大を返す
            return 1 + max(array_map(function ($v) use ($main, $depth) { return $main($v, $depth + 1); }, $arrays));
        };

        return $main($array, 1);
    }
}

const array_insert = "array_insert";
if (!isset($excluded_functions["array_insert"]) && (!function_exists("array_insert") || (!false && (new \ReflectionFunction("array_insert"))->isInternal()))) {
    /**
     * 配列・連想配列を問わず任意の位置に値を挿入する
     *
     * $position を省略すると最後に挿入される（≒ array_push）。
     * $position に負数を与えると後ろから数えられる。
     * $value には配列も与えられるが、その場合数値キーは振り直される
     *
     * Example:
     * ```php
     * assertSame(array_insert([1, 2, 3], 'x'), [1, 2, 3, 'x']);
     * assertSame(array_insert([1, 2, 3], 'x', 1), [1, 'x', 2, 3]);
     * assertSame(array_insert([1, 2, 3], 'x', -1), [1, 2, 'x', 3]);
     * assertSame(array_insert([1, 2, 3], ['a' => 'A', 'b' => 'B'], 1), [1, 'a' => 'A', 'b' => 'B', 2, 3]);
     * ```
     *
     * @param array $array 対象配列
     * @param mixed $value 挿入値
     * @param int|null $position 挿入位置
     * @return array 挿入された新しい配列
     */
    function array_insert($array, $value, $position = null)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        $position = is_null($position) ? count($array) : intval($position);

        $sarray = array_splice($array, 0, $position);
        return array_merge($sarray, $value, $array);
    }
}

const array_assort = "array_assort";
if (!isset($excluded_functions["array_assort"]) && (!function_exists("array_assort") || (!false && (new \ReflectionFunction("array_assort"))->isInternal()))) {
    /**
     * 配列をコールバックに従って分類する
     *
     * コールバックは配列で複数与える。そのキーが結果配列のキーになるが、一切マッチしなくてもキー自体は作られる。
     * 複数のコールバックにマッチしたらその分代入されるし、どれにもマッチしなければ代入されない。
     * つまり5個の配列を分類したからと言って、全要素数が5個になるとは限らない（多い場合も少ない場合もある）。
     *
     * $rule が要求するならキーも渡ってくる。
     *
     * Example:
     * ```php
     * // lt2(2より小さい)で分類
     * $lt2 = function($v){return $v < 2;};
     * assertSame(array_assort([1, 2, 3], [
     *     'lt2' => $lt2,
     * ]), [
     *     'lt2' => [1],
     * ]);
     * // lt3(3より小さい)、ctd(ctype_digit)で分類（両方に属する要素が存在する）
     * $lt3 = function($v){return $v < 3;};
     * assertSame(array_assort(['1', '2', '3'], [
     *     'lt3' => $lt3,
     *     'ctd' => 'ctype_digit',
     * ]), [
     *     'lt3' => ['1', '2'],
     *     'ctd' => ['1', '2', '3'],
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable[] $rules 分類ルール。[key => callable] 形式
     * @return array 分類された新しい配列
     */
    function array_assort($array, $rules)
    {
        $result = array_fill_keys(array_keys($rules), []);
        foreach ($rules as $name => $rule) {
            $rule = func_user_func_array($rule);
            foreach ($array as $k => $v) {
                if ($rule($v, $k)) {
                    $result[$name][$k] = $v;
                }
            }
        }
        return $result;
    }
}

const array_count = "array_count";
if (!isset($excluded_functions["array_count"]) && (!function_exists("array_count") || (!false && (new \ReflectionFunction("array_count"))->isInternal()))) {
    /**
     * 配列をコールバックに従ってカウントする
     *
     * コールバックが true 相当を返した要素をカウントして返す。
     * 普通に使う分には `count(array_filter($array, $callback))` とほとんど同じだが、下記の点が微妙に異なる。
     *
     * - $callback が要求するならキーも渡ってくる
     * - $callback には配列が渡せる。配列を渡した場合は件数を配列で返す（Example 参照）
     *
     * Example:
     * ```php
     * $array = ['hoge', 'fuga', 'piyo'];
     * // 'o' を含むものの数（2個）
     * assertSame(array_count($array, function($s){return strpos($s, 'o') !== false;}), 2);
     * // 'a' と 'o' を含むものをそれぞれ（1個と2個）
     * assertSame(array_count($array, [
     *     'a' => function($s){return strpos($s, 'a') !== false;},
     *     'o' => function($s){return strpos($s, 'o') !== false;},
     * ]), [
     *     'a' => 1,
     *     'o' => 2,
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback カウントルール。配列も渡せる
     * @return int|array 条件一致した件数
     */
    function array_count($array, $callback)
    {
        // 配列が来た場合はまるで動作が異なる（再帰でもいいがそれだと旨味がない。複数欲しいなら呼び出し元で複数回呼べば良い。ワンループに閉じ込めるからこそメリットがある））
        if (is_array($callback) && !is_callable($callback)) {
            $result = array_fill_keys(array_keys($callback), 0);
            foreach ($callback as $name => $rule) {
                $rule = func_user_func_array($rule);
                foreach ($array as $k => $v) {
                    if ($rule($v, $k)) {
                        $result[$name]++;
                    }
                }
            }
            return $result;
        }

        $callback = func_user_func_array($callback);
        $result = 0;
        foreach ($array as $k => $v) {
            if ($callback($v, $k)) {
                $result++;
            }
        }
        return $result;
    }
}

const array_group = "array_group";
if (!isset($excluded_functions["array_group"]) && (!function_exists("array_group") || (!false && (new \ReflectionFunction("array_group"))->isInternal()))) {
    /**
     * 配列をコールバックの返り値でグループ化する
     *
     * コールバックを省略すると値そのもので評価する。
     * コールバックが配列を返すと入れ子としてグループ化する。
     *
     * Example:
     * ```php
     * assertSame(array_group([1, 1, 1]), [
     *     1 => [1, 1, 1],
     * ]);
     * assertSame(array_group([1, 2, 3], function($v){return $v % 2;}), [
     *     1 => [1, 3],
     *     0 => [2],
     * ]);
     * // group -> id で入れ子グループにする
     * $row1 = ['id' => 1, 'group' => 'hoge'];
     * $row2 = ['id' => 2, 'group' => 'fuga'];
     * $row3 = ['id' => 3, 'group' => 'hoge'];
     * assertSame(array_group([$row1, $row2, $row3], function($row){return [$row['group'], $row['id']];}), [
     *     'hoge' => [
     *         1 => $row1,
     *         3 => $row3,
     *     ],
     *     'fuga' => [
     *         2 => $row2,
     *     ],
     * ]);
     * ```
     *
     * @param iterable 対象配列
     * @param callable $callback 評価クロージャ。 null なら値そのもので評価
     * @param bool $preserve_keys キーを保存するか。 false の場合数値キーは振り直される
     * @return array グルーピングされた配列
     */
    function array_group($array, $callback = null, $preserve_keys = false)
    {
        $callback = func_user_func_array($callback);

        $result = [];
        foreach ($array as $k => $v) {
            $vv = $callback($v, $k);
            // 配列は潜る
            if (is_array($vv)) {
                $tmp = &$result;
                foreach ($vv as $vvv) {
                    $tmp = &$tmp[$vvv];
                }
                $tmp = $v;
                unset($tmp);
            }
            elseif (!$preserve_keys && is_int($k)) {
                $result[$vv][] = $v;
            }
            else {
                $result[$vv][$k] = $v;
            }
        }
        return $result;
    }
}

const array_all = "array_all";
if (!isset($excluded_functions["array_all"]) && (!function_exists("array_all") || (!false && (new \ReflectionFunction("array_all"))->isInternal()))) {
    /**
     * 全要素が true になるなら true を返す（1つでも false なら false を返す）
     *
     * $callback が要求するならキーも渡ってくる。
     *
     * Example:
     * ```php
     * assertTrue(array_all([true, true]));
     * assertFalse(array_all([true, false]));
     * assertFalse(array_all([false, false]));
     * ```
     *
     * @param iterable 対象配列
     * @param callable $callback 評価クロージャ。 null なら値そのもので評価
     * @param bool|mixed $default 空配列の場合のデフォルト値
     * @return bool 全要素が true なら true
     */
    function array_all($array, $callback = null, $default = true)
    {
        if (is_empty($array)) {
            return $default;
        }

        $callback = func_user_func_array($callback);

        foreach ($array as $k => $v) {
            if (!$callback($v, $k)) {
                return false;
            }
        }
        return true;
    }
}

const array_any = "array_any";
if (!isset($excluded_functions["array_any"]) && (!function_exists("array_any") || (!false && (new \ReflectionFunction("array_any"))->isInternal()))) {
    /**
     * 全要素が false になるなら false を返す（1つでも true なら true を返す）
     *
     * $callback が要求するならキーも渡ってくる。
     *
     * Example:
     * ```php
     * assertTrue(array_any([true, true]));
     * assertTrue(array_any([true, false]));
     * assertFalse(array_any([false, false]));
     * ```
     *
     * @param iterable 対象配列
     * @param callable $callback 評価クロージャ。 null なら値そのもので評価
     * @param bool|mixed $default 空配列の場合のデフォルト値
     * @return bool 全要素が false なら false
     */
    function array_any($array, $callback = null, $default = false)
    {
        if (is_empty($array)) {
            return $default;
        }

        $callback = func_user_func_array($callback);

        foreach ($array as $k => $v) {
            if ($callback($v, $k)) {
                return true;
            }
        }
        return false;
    }
}

const array_order = "array_order";
if (!isset($excluded_functions["array_order"]) && (!function_exists("array_order") || (!false && (new \ReflectionFunction("array_order"))->isInternal()))) {
    /**
     * 配列を $orders に従って並べ替える
     *
     * データベースからフェッチしたような連想配列の配列を想定しているが、スカラー配列(['key' => 'value'])にも対応している。
     * その場合 $orders に配列ではなく直値を渡せば良い。
     *
     * $orders には下記のような配列を渡す。
     *
     * ```php
     * $orders = [
     *     'col1' => true,                               // true: 昇順, false: 降順。照合は型に依存
     *     'col2' => SORT_NATURAL,                       // SORT_NATURAL, SORT_REGULAR などで照合。正数で昇順、負数で降順
     *     'col3' => ['sort', 'this', 'order'],          // 指定した配列順で昇順
     *     'col4' => function($v) {return $v;},          // クロージャを通した値で昇順。照合は返り値の型に依存
     *     'col5' => function($a, $b) {return $a - $b;}, // クロージャで比較して昇順（いわゆる比較関数を渡す）
     * ];
     * ```
     *
     * Example:
     * ```php
     * $v1 = ['id' => '1', 'no' => 'a03', 'name' => 'yyy'];
     * $v2 = ['id' => '2', 'no' => 'a4',  'name' => 'yyy'];
     * $v3 = ['id' => '3', 'no' => 'a12', 'name' => 'xxx'];
     * // name 昇順, no 自然降順
     * assertSame(array_order([$v1, $v2, $v3], ['name' => true, 'no' => -SORT_NATURAL]), [$v3, $v2, $v1]);
     * ```
     *
     * @param array $array 対象配列
     * @param mixed $orders ソート順
     * @param bool $preserve_keys キーを保存するか。 false の場合数値キーは振り直される
     * @return array 並び替えられた配列
     */
    function array_order(array $array, $orders, $preserve_keys = false)
    {
        if (count($array) <= 1) {
            return $array;
        }

        if (!is_array($orders) || !is_hasharray($orders)) {
            $orders = [$orders];
        }

        // 配列内の位置をマップして返すクロージャ
        $position = function ($columns, $order) {
            return array_map(function ($v) use ($order) {
                $ndx = array_search($v, $order, true);
                return $ndx === false ? count($order) : $ndx;
            }, $columns);
        };

        // 全要素は舐めてられないので最初の要素を代表選手としてピックアップ
        $first = reset($array);
        $is_scalar = is_scalar($first) || is_null($first);

        // array_multisort 用の配列を生成
        $args = [];
        foreach ($orders as $key => $order) {
            if ($is_scalar) {
                $firstval = reset($array);
                $columns = $array;
            }
            else {
                if ($key !== '' && !array_key_exists($key, $first)) {
                    throw new \InvalidArgumentException("$key is undefined.");
                }
                if ($key === '') {
                    $columns = array_keys($array);
                    $firstval = reset($columns);
                }
                else {
                    $firstval = $first[$key];
                    $columns = array_column($array, $key);
                }
            }

            // bool は ASC, DESC
            if (is_bool($order)) {
                $args[] = $columns;
                $args[] = $order ? SORT_ASC : SORT_DESC;
                $args[] = is_string($firstval) ? SORT_STRING : SORT_NUMERIC;
            }
            // int は SORT_*****
            elseif (is_int($order)) {
                $args[] = $columns;
                $args[] = $order > 0 ? SORT_ASC : SORT_DESC;
                $args[] = abs($order);
            }
            // 配列はその並び
            elseif (is_array($order)) {
                $args[] = $position($columns, $order);
                $args[] = SORT_ASC;
                $args[] = SORT_NUMERIC;
            }
            // クロージャは色々
            elseif ($order instanceof \Closure) {
                $ref = new \ReflectionFunction($order);
                // 引数2個なら比較関数
                if ($ref->getNumberOfRequiredParameters() === 2) {
                    $map = $columns;
                    usort($map, $order);
                    $args[] = $position($columns, $map);
                    $args[] = SORT_ASC;
                    $args[] = SORT_NUMERIC;
                }
                // でないなら通した値で比較
                else {
                    $arg = array_map($order, $columns);
                    $type = $ref->hasReturnType() ? (string) $ref->getReturnType() : gettype(reset($arg));
                    $args[] = $arg;
                    $args[] = SORT_ASC;
                    $args[] = $type === 'string' ? SORT_STRING : SORT_NUMERIC;
                }
            }
            else {
                throw new \DomainException('$order is invalid.');
            }
        }

        // array_multisort はキーを保持しないので、ソートされる配列にキー配列を加えて後で combine する
        if ($preserve_keys) {
            $keys = array_keys($array);
            $args[] = &$array;
            $args[] = &$keys;
            array_multisort(...$args);
            return array_combine($keys, $array);
        }
        // キーを保持しないなら単純呼び出しで OK
        else {
            $args[] = &$array;
            array_multisort(...$args);
            return $array;
        }
    }
}

const array_shuffle = "array_shuffle";
if (!isset($excluded_functions["array_shuffle"]) && (!function_exists("array_shuffle") || (!false && (new \ReflectionFunction("array_shuffle"))->isInternal()))) {
    /**
     * shuffle のキーが保存される＋参照渡しではない版
     *
     * Example:
     * ```php
     * assertEquals(array_shuffle(['a' => 'A', 'b' => 'B', 'c' => 'C']), ['b' => 'B', 'a' => 'A', 'c' => 'C']);
     * ```
     *
     * @param array $array 対象配列
     * @return array shuffle された配列
     */
    function array_shuffle($array)
    {
        $keys = array_keys($array);
        shuffle($keys);

        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $array[$key];
        }
        return $result;
    }
}

const array_shrink_key = "array_shrink_key";
if (!isset($excluded_functions["array_shrink_key"]) && (!function_exists("array_shrink_key") || (!false && (new \ReflectionFunction("array_shrink_key"))->isInternal()))) {
    /**
     * 値の優先順位を逆にした array_intersect_key
     *
     * array_intersect_key は「左優先で共通項を取る」という動作だが、この関数は「右優先で共通項を取る」という動作になる。
     * 「配列の並び順はそのままで値だけ変えたい/削ぎ落としたい」という状況はまれによくあるはず。
     *
     * Example:
     * ```php
     * $array1 = ['a' => 'A1', 'b' => 'B1', 'c' => 'C1'];
     * $array2 = ['c' => 'C2', 'b' => 'B2', 'a' => 'A2'];
     * $array3 = ['c' => 'C3', 'dummy' => 'DUMMY'];
     * // 全共通項である 'c' キーのみが生き残り、その値は最後の 'C3' になる
     * assertSame(array_shrink_key($array1, $array2, $array3), ['c' => 'C3']);
     * ```
     *
     * @param iterable[] $variadic 共通項を取る配列（可変引数）
     * @return array 新しい配列
     */
    function array_shrink_key(...$variadic)
    {
        $result = [];
        foreach ($variadic as $n => $array) {
            if (!is_array($array)) {
                $variadic[$n] = arrayval($array, false);
            }
            $result = array_replace($result, $variadic[$n]);
        }
        return array_intersect_key($result, ...$variadic);
    }
}

const array_fill_callback = "array_fill_callback";
if (!isset($excluded_functions["array_fill_callback"]) && (!function_exists("array_fill_callback") || (!false && (new \ReflectionFunction("array_fill_callback"))->isInternal()))) {
    /**
     * array_fill_keys のコールバック版のようなもの
     *
     * 指定したキー配列をそれらのマップしたもので配列を生成する。
     * `array_combine($keys, array_map($callback, $keys))` とほぼ等価。
     *
     * Example:
     * ```php
     * $abc = ['a', 'b', 'c'];
     * // [a, b, c] から [a => A, b => B, c => C] を作る
     * assertSame(array_fill_callback($abc, 'strtoupper'), [
     *     'a' => 'A',
     *     'b' => 'B',
     *     'c' => 'C',
     * ]);
     * // [a, b, c] からその sha1 配列を作って大文字化する
     * assertSame(array_fill_callback($abc, function ($v){ return strtoupper(sha1($v)); }), [
     *     'a' => '86F7E437FAA5A7FCE15D1DDCB9EAEAEA377667B8',
     *     'b' => 'E9D71F5EE7C92D6DC9E92FFDAD17B8BD49418F98',
     *     'c' => '84A516841BA77A5B4648DE2CD0DFCB30EA46DBB4',
     * ]);
     * ```
     *
     * @param iterable $keys キーとなる配列
     * @param callable $callback 要素のコールバック（引数でキーが渡ってくる）
     * @return array 新しい配列
     */
    function array_fill_callback($keys, $callback)
    {
        $keys = arrayval($keys, false);
        return array_combine($keys, array_map(func_user_func_array($callback), $keys));
    }
}

const array_pickup = "array_pickup";
if (!isset($excluded_functions["array_pickup"]) && (!function_exists("array_pickup") || (!false && (new \ReflectionFunction("array_pickup"))->isInternal()))) {
    /**
     * キーを指定してそれだけの配列にする
     *
     * `array_intersect_key($array, array_flip($keys))` とほぼ同義。
     * 違いは Traversable を渡せることと、結果配列の順番が $keys に従うこと。
     *
     * $keys に連想配列を渡すとキーを読み替えて動作する（Example を参照）。
     *
     * Example:
     * ```php
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // a と c を取り出す
     * assertSame(array_pickup($array, ['a', 'c']), ['a' => 'A', 'c' => 'C']);
     * // 順番は $keys 基準になる
     * assertSame(array_pickup($array, ['c', 'a']), ['c' => 'C', 'a' => 'A']);
     * // 連想配列を渡すと読み替えて返す
     * assertSame(array_pickup($array, ['c' => 'cX', 'a' => 'aX']), ['cX' => 'C', 'aX' => 'A']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param array $keys 取り出すキー（可変引数）
     * @return array 新しい配列
     */
    function array_pickup($array, $keys)
    {
        if (!is_array($array)) {
            $array = arrayval($array, false);
        }

        $result = [];
        foreach ($keys as $k => $key) {
            if (is_int($k)) {
                if (array_key_exists($key, $array)) {
                    $result[$key] = $array[$key];
                }
            }
            else {
                if (array_key_exists($k, $array)) {
                    $result[$key] = $array[$k];
                }
            }
        }
        return $result;
    }
}

const array_lookup = "array_lookup";
if (!isset($excluded_functions["array_lookup"]) && (!function_exists("array_lookup") || (!false && (new \ReflectionFunction("array_lookup"))->isInternal()))) {
    /**
     * キー保存可能な array_column
     *
     * array_column は キーを保存することが出来ないが、この関数は引数を2つだけ与えるとキーはそのままで array_column 相当の配列を返す。
     *
     * Example:
     * ```php
     * $array = [
     *     11 => ['id' => 1, 'name' => 'name1'],
     *     12 => ['id' => 2, 'name' => 'name2'],
     *     13 => ['id' => 3, 'name' => 'name3'],
     * ];
     * // 第3引数を渡せば array_column と全く同じ
     * assertSame(array_lookup($array, 'name', 'id'), array_column($array, 'name', 'id'));
     * assertSame(array_lookup($array, 'name', null), array_column($array, 'name', null));
     * // 省略すればキーが保存される
     * assertSame(array_lookup($array, 'name'), [
     *     11 => 'name1',
     *     12 => 'name2',
     *     13 => 'name3',
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string|null $column_key 値となるキー
     * @param string|null $index_key キーとなるキー
     * @return array 新しい配列
     */
    function array_lookup($array, $column_key = null, $index_key = null)
    {
        if (func_num_args() === 3) {
            return array_column(arrayval($array, false), $column_key, $index_key);
        }

        // null 対応できないし、php7 からオブジェクトに対応してるらしいので止め。ベタにやる
        // return array_map(array_of($column_keys), $array);

        // 実質的にはこれで良いはずだが、オブジェクト対応が救えないので止め。ベタにやる
        // return array_combine(array_keys($array), array_column($array, $column_key));

        $result = [];
        foreach ($array as $k => $v) {
            if ($column_key === null) {
                $result[$k] = $v;
            }
            elseif (is_array($v) && array_key_exists($column_key, $v)) {
                $result[$k] = $v[$column_key];
            }
            elseif (is_object($v) && (isset($v->$column_key) || property_exists($v, $column_key))) {
                $result[$k] = $v->$column_key;
            }
        }
        return $result;
    }
}

const array_columns = "array_columns";
if (!isset($excluded_functions["array_columns"]) && (!function_exists("array_columns") || (!false && (new \ReflectionFunction("array_columns"))->isInternal()))) {
    /**
     * 全要素に対して array_column する
     *
     * 行列が逆転するイメージ。
     *
     * Example:
     * ```php
     * $row1 = ['id' => 1, 'name' => 'A'];
     * $row2 = ['id' => 2, 'name' => 'B'];
     * $rows = [$row1, $row2];
     * assertSame(array_columns($rows), ['id' => [1, 2], 'name' => ['A', 'B']]);
     * assertSame(array_columns($rows, 'id'), ['id' => [1, 2]]);
     * assertSame(array_columns($rows, 'name', 'id'), ['name' => [1 => 'A', 2 => 'B']]);
     * ```
     *
     * @param array $array 対象配列
     * @param string|array $column_keys 引っ張ってくるキー名
     * @param mixed $index_key 新しい配列のキーとなるキー名
     * @return array 新しい配列
     */
    function array_columns($array, $column_keys = null, $index_key = null)
    {
        if (count($array) === 0 && $column_keys === null) {
            throw new \InvalidArgumentException("can't auto detect keys.");
        }

        if ($column_keys === null) {
            $column_keys = array_keys(reset($array));
        }

        $result = [];
        foreach ((array) $column_keys as $key) {
            $result[$key] = array_column($array, $key, $index_key);
        }
        return $result;
    }
}

const array_uncolumns = "array_uncolumns";
if (!isset($excluded_functions["array_uncolumns"]) && (!function_exists("array_uncolumns") || (!false && (new \ReflectionFunction("array_uncolumns"))->isInternal()))) {
    /**
     * array_columns のほぼ逆で [キー => [要素]] 配列から連想配列の配列を生成する
     *
     * $template を指定すると「それに含まれる配列かつ値がデフォルト」になる（要するに $default みたいなもの）。
     * キーがバラバラな配列を指定する場合は指定したほうが良い。が、null を指定すると最初の要素が使われるので大抵の場合は null で良い。
     *
     * Example:
     * ```php
     * assertSame(array_uncolumns([
     *     'id'   => [1, 2],
     *     'name' => ['A', 'B'],
     * ]), [
     *     ['id' => 1, 'name' => 'A'],
     *     ['id' => 2, 'name' => 'B'],
     * ]);
     * ```
     *
     * @param array $array 対象配列
     * @param array $template 抽出要素とそのデフォルト値
     * @return array 新しい配列
     */
    function array_uncolumns($array, $template = null)
    {
        // 指定されていないなら生のまま
        if (func_num_args() === 1) {
            $template = false;
        }
        // null なら最初の要素のキー・null
        if ($template === null) {
            $template = array_fill_keys(array_keys(first_value($array)), null);
        }

        $result = [];
        foreach ($array as $key => $vals) {
            if ($template !== false) {
                $vals = array_intersect_key($vals + $template, $template);
            }
            foreach ($vals as $n => $val) {
                $result[$n][$key] = $val;
            }
        }
        return $result;
    }
}

const array_convert = "array_convert";
if (!isset($excluded_functions["array_convert"]) && (!function_exists("array_convert") || (!false && (new \ReflectionFunction("array_convert"))->isInternal()))) {
    /**
     * 配列の各要素に再帰的にコールバックを適用して変換する
     *
     * $callback は下記の仕様。
     *
     * 引数は (キー, 値, 今まで処理したキー配列) で渡ってくる。
     * 返り値は新しいキーを返す。
     *
     * - 文字列や数値を返すとそれがキーとして使われる
     * - null を返すと元のキーがそのまま使われる
     * - true を返すと数値連番が振られる
     * - false を返すとその要素は無かったことになる
     * - 配列を返すとその配列で完全に置換される
     *
     * $apply_array=false で要素が配列の場合は再帰され、コールバックが適用されない（array_walk_recursive と同じ仕様）。
     *
     * $apply_array=true だと配列かは問わず全ての要素にコールバックが適用される。
     * 配列も渡ってきてしまうのでコールバック内部で is_array 判定が必要になる場合がある。
     *
     * 「map も filter も可能でキー変更可能かつ再帰的」というとてもマッチョな関数。
     * 複雑だが実質的には「キーも設定できる array_walk_recursive」のように振る舞う（そしてそのような使い方を想定している）。
     *
     * Example:
     * ```php
     * $array = [
     *    'k1' => 'v1',
     *    'k2' => [
     *        'k21' => 'v21',
     *        'k22' => [
     *            'k221' => 'v221',
     *            'k222' => 'v222',
     *        ],
     *        'k23' => 'v23',
     *    ],
     * ];
     * // 全要素に 'prefix-' を付与する。キーには '_' をつける。ただし 'k21' はそのままとする。さらに 'k22' はまるごと伏せる。 'k23' は数値キーになる
     * $callback = function($k, &$v){
     *     if ($k === 'k21') return null;
     *     if ($k === 'k22') return false;
     *     if ($k === 'k23') return true;
     *     if (!is_array($v)) $v = "prefix-$v";
     *     return "_$k";
     * };
     * assertSame(array_convert($array, $callback, true), [
     *     '_k1' => 'prefix-v1',
     *     '_k2' => [
     *         'k21' => 'v21',
     *         0     => 'v23',
     *     ],
     * ]);
     * ```
     *
     * @param array $array 対象配列
     * @param callable $callback 適用するコールバック
     * @param bool $apply_array 配列要素にもコールバックを適用するか
     * @return array 変換された配列
     */
    function array_convert($array, $callback, $apply_array = false)
    {
        $recursive = function (&$result, $array, $history, $callback) use (&$recursive, $apply_array) {
            $sequences = [];
            foreach ($array as $key => $value) {
                $is_array = is_array($value);
                $newkey = $key;
                // 配列で $apply_array あるいは非配列の場合にコールバック適用
                if (($is_array && $apply_array) || !$is_array) {
                    $newkey = $callback($key, $value, $history);
                }
                // 配列は置換
                if (is_array($newkey)) {
                    foreach ($newkey as $k => $v) {
                        $result[$k] = $v;
                    }
                    continue;
                }
                // false はスルー
                if ($newkey === false) {
                    continue;
                }
                // true は数値連番
                if ($newkey === true) {
                    if ($is_array) {
                        $sequences["_$key"] = $value;
                    }
                    else {
                        $sequences[] = $value;
                    }
                    continue;
                }
                // null は元のキー
                if ($newkey === null) {
                    $newkey = $key;
                }
                // 配列と非配列で代入の仕方が異なる
                if ($is_array) {
                    $history[] = $key;
                    $result[$newkey] = [];
                    $recursive($result[$newkey], $value, $history, $callback);
                    array_pop($history);
                }
                else {
                    $result[$newkey] = $value;
                }
            }
            // 数値連番は上書きを防ぐためにあとでやる
            foreach ($sequences as $key => $value) {
                if (is_string($key)) {
                    $history[] = substr($key, 1);
                    $v = [];
                    $result[] = &$v;
                    $recursive($v, $value, $history, $callback);
                    array_pop($history);
                    unset($v);
                }
                else {
                    $result[] = $value;
                }
            }
        };

        $result = [];
        $recursive($result, $array, [], $callback);
        return $result;
    }
}

const array_flatten = "array_flatten";
if (!isset($excluded_functions["array_flatten"]) && (!function_exists("array_flatten") || (!false && (new \ReflectionFunction("array_flatten"))->isInternal()))) {
    /**
     * 多階層配列をフラットに展開する
     *
     * 巷にあふれている実装と違って、 ["$pkey.$ckey" => $value] 形式の配列でも返せる。
     * $delimiter で区切り文字を指定した場合にそのようになる。
     * $delimiter = null の場合に本当の配列で返す（巷の実装と同じ）。
     *
     * Example:
     * ```php
     * $array = [
     *    'k1' => 'v1',
     *    'k2' => [
     *        'k21' => 'v21',
     *        'k22' => [
     *            'k221' => 'v221',
     *            'k222' => 'v222',
     *            'k223' => [1, 2, 3],
     *        ],
     *    ],
     * ];
     * // 区切り文字指定なし
     * assertSame(array_flatten($array), [
     *    0 => 'v1',
     *    1 => 'v21',
     *    2 => 'v221',
     *    3 => 'v222',
     *    4 => 1,
     *    5 => 2,
     *    6 => 3,
     * ]);
     * // 区切り文字指定
     * assertSame(array_flatten($array, '.'), [
     *    'k1'            => 'v1',
     *    'k2.k21'        => 'v21',
     *    'k2.k22.k221'   => 'v221',
     *    'k2.k22.k222'   => 'v222',
     *    'k2.k22.k223.0' => 1,
     *    'k2.k22.k223.1' => 2,
     *    'k2.k22.k223.2' => 3,
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string|null $delimiter キーの区切り文字。 null を与えると連番になる
     * @return array フラット化された配列
     */
    function array_flatten($array, $delimiter = null)
    {
        // 要素追加について、 array_set だと目に見えて速度低下したのでベタに if else で分岐する
        $core = function ($array, $delimiter) use (&$core) {
            $result = [];
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($core($v, $delimiter) as $ik => $iv) {
                        if ($delimiter === null) {
                            $result[] = $iv;
                        }
                        else {
                            $result[$k . $delimiter . $ik] = $iv;
                        }
                    }
                }
                else {
                    if ($delimiter === null) {
                        $result[] = $v;
                    }
                    else {
                        $result[$k] = $v;
                    }
                }
            }
            return $result;
        };

        return $core($array, $delimiter);
    }
}

const array_nest = "array_nest";
if (!isset($excluded_functions["array_nest"]) && (!function_exists("array_nest") || (!false && (new \ReflectionFunction("array_nest"))->isInternal()))) {
    /**
     * シンプルな [キー => 値] な配列から階層配列を生成する
     *
     * 定義的に array_flatten の逆関数のような扱いになる。
     * $delimiter で階層を表現する。
     *
     * 同名とみなされるキーは上書きされるか例外が飛ぶ。具体的には Example を参照。
     *
     * Example:
     * ```php
     * // 単純な階層展開
     * $array = [
     *    'k1'            => 'v1',
     *    'k2.k21'        => 'v21',
     *    'k2.k22.k221'   => 'v221',
     *    'k2.k22.k222'   => 'v222',
     *    'k2.k22.k223.0' => 1,
     *    'k2.k22.k223.1' => 2,
     *    'k2.k22.k223.2' => 3,
     * ];
     * assertSame(array_nest($array), [
     *    'k1' => 'v1',
     *    'k2' => [
     *        'k21' => 'v21',
     *        'k22' => [
     *            'k221' => 'v221',
     *            'k222' => 'v222',
     *            'k223' => [1, 2, 3],
     *        ],
     *    ],
     * ]);
     * // 同名になるようなキーは上書きされる
     * $array = [
     *    'k1.k2' => 'v1', // この時点で 'k1' は配列になるが・・・
     *    'k1'    => 'v2', // この時点で 'k1' は文字列として上書きされる
     * ];
     * assertSame(array_nest($array), [
     *    'k1' => 'v2',
     * ]);
     * // 上書きすら出来ない場合は例外が飛ぶ
     * $array = [
     *    'k1'    => 'v1', // この時点で 'k1' は文字列になるが・・・
     *    'k1.k2' => 'v2', // この時点で 'k1' にインデックスアクセスすることになるので例外が飛ぶ
     * ];
     * try {
     *     array_nest($array);
     * }
     * catch (\Exception $e) {
     *     assertInstanceof(\InvalidArgumentException::class, $e);
     * }
     * ```
     *
     * @param iterable $array 対象配列
     * @param string $delimiter キーの区切り文字
     * @return array 階層化された配列
     */
    function array_nest($array, $delimiter = '.')
    {
        $result = [];
        foreach ($array as $k => $v) {
            $keys = explode($delimiter, $k);
            $rkeys = [];
            $tmp = &$result;
            foreach ($keys as $key) {
                $rkeys[] = $key;
                if (isset($tmp[$key]) && !is_array($tmp[$key])) {
                    throw new \InvalidArgumentException("'" . implode($delimiter, $rkeys) . "' of '$k' is already exists.");
                }
                $tmp = &$tmp[$key];
            }
            $tmp = $v;
            unset($tmp);
        }
        return $result;
    }
}

const array_difference = "array_difference";
if (!isset($excluded_functions["array_difference"]) && (!function_exists("array_difference") || (!false && (new \ReflectionFunction("array_difference"))->isInternal()))) {
    /**
     * 配列の差分を取り配列で返す
     *
     * 返り値の配列は構造化されたデータではない。
     * 主に文字列化して出力することを想定している。
     *
     * ユースケースとしては「スキーマデータ」「各環境の設定ファイル」などの差分。
     *
     * - '+' はキーが追加されたことを表す
     * - '-' はキーが削除されたことを表す
     * - 両方が含まれている場合、値の変更を表す
     *
     * 数値キーはキーの比較は行われない。値の差分のみ返す。
     *
     * Example:
     * ```php
     * // common は 中身に差分がある。 1 に key1 はあるが、 2 にはない。2 に key2 はあるが、 1 にはない。
     * assertSame(array_difference([
     *     'common' => [
     *         'sub' => [
     *             'x' => 'val',
     *         ]
     *     ],
     *     'key1'   => 'hoge',
     * ], [
     *     'common' => [
     *         'sub' => [
     *             'x' => 'VAL',
     *         ]
     *     ],
     *     'key2'   => 'fuga',
     * ]), [
     *     'common.sub.x' => ['-' => 'val', '+' => 'VAL'],
     *     'key1'         => ['-' => 'hoge'],
     *     'key2'         => ['+' => 'fuga'],
     * ]);
     * ```
     *
     * @param iterable $array1 対象配列1
     * @param iterable $array2 対象配列2
     * @param string $delimiter 差分配列のキー区切り文字
     * @return array 差分を表す配列
     */
    function array_difference($array1, $array2, $delimiter = '.')
    {
        $rule = [
            'list' => static function ($v, $k) { return is_int($k); },
            'hash' => static function ($v, $k) { return !is_int($k); },
        ];

        $udiff = static function ($a, $b) { return $a <=> $b; };

        return call_user_func($f = static function ($array1, $array2, $key = null) use (&$f, $rule, $udiff, $delimiter) {
            $result = [];

            $array1 = array_assort($array1, $rule);
            $array2 = array_assort($array2, $rule);

            $list1 = array_values(array_udiff($array1['list'], $array2['list'], $udiff));
            $list2 = array_values(array_udiff($array2['list'], $array1['list'], $udiff));
            for ($k = 0, $l = max(count($list1), count($list2)); $k < $l; $k++) {
                $exists1 = array_key_exists($k, $list1);
                $exists2 = array_key_exists($k, $list2);

                $v1 = $exists1 ? $list1[$k] : null;
                $v2 = $exists2 ? $list2[$k] : null;

                $prefix = $key === null ? count($result) : $key;
                if ($exists1) {
                    $result[$prefix]['-'][] = $v1;
                }
                if ($exists2) {
                    $result[$prefix]['+'][] = $v2;
                }
            }

            $hash1 = array_udiff_assoc($array1['hash'], $array2['hash'], $udiff);
            $hash2 = array_udiff_assoc($array2['hash'], $array1['hash'], $udiff);
            foreach (array_keys($hash1 + $hash2) as $k) {
                $exists1 = array_key_exists($k, $hash1);
                $exists2 = array_key_exists($k, $hash2);

                $v1 = $exists1 ? $hash1[$k] : null;
                $v2 = $exists2 ? $hash2[$k] : null;

                $prefix = $key === null ? $k : $key . $delimiter . $k;
                if (is_array($v1) && is_array($v2)) {
                    $result += $f($v1, $v2, $prefix);
                    continue;
                }
                if ($exists1) {
                    $result[$prefix]['-'] = $v1;
                }
                if ($exists2) {
                    $result[$prefix]['+'] = $v2;
                }
            }

            return $result;
        }, $array1, $array2);
    }
}

const stdclass = "stdclass";
if (!isset($excluded_functions["stdclass"]) && (!function_exists("stdclass") || (!false && (new \ReflectionFunction("stdclass"))->isInternal()))) {
    /**
     * 初期フィールド値を与えて stdClass を生成する
     *
     * 手元にある配列でサクッと stdClass を作りたいことがまれによくあるはず。
     *
     * object キャストでもいいんだが、 Iterator/Traversable とかも stdClass 化したいかもしれない。
     * それにキャストだとコールバックで呼べなかったり、数値キーが死んだりして微妙に使いづらいところがある。
     *
     * Example:
     * ```php
     * // 基本的には object キャストと同じ
     * $fields = ['a' => 'A', 'b' => 'B'];
     * assertEquals(stdclass($fields), (object) $fields);
     * // ただしこういうことはキャストでは出来ない
     * assertEquals(array_map('stdclass', [$fields]), [(object) $fields]); // コールバックとして利用する
     * assertTrue(property_exists(stdclass(['a', 'b']), '0')); // 数値キー付きオブジェクトにする
     * ```
     *
     * @param iterable $fields フィールド配列
     * @return \stdClass 生成した stdClass インスタンス
     */
    function stdclass(iterable $fields = [])
    {
        $stdclass = new \stdClass();
        foreach ($fields as $key => $value) {
            $stdclass->$key = $value;
        }
        return $stdclass;
    }
}

const detect_namespace = "detect_namespace";
if (!isset($excluded_functions["detect_namespace"]) && (!function_exists("detect_namespace") || (!false && (new \ReflectionFunction("detect_namespace"))->isInternal()))) {
    /**
     * ディレクトリ構造から名前空間を推測して返す
     *
     * 指定パスに名前空間を持つような php ファイルが有るならその名前空間を返す。
     * 指定パスに名前空間を持つような php ファイルが無いなら親をたどる。
     * 親に名前空間を持つような php ファイルが有るならその名前空間＋ローカルパスを返す。
     *
     * 言葉で表すとややこしいが、「そのパスに配置しても違和感の無い名前空間」を返してくれるはず。
     *
     * @param string $location 配置パス。ファイル名を与えるとそのファイルを配置すべきクラス名を返す
     * @return string 名前空間
     */
    function detect_namespace($location)
    {
        // php をパースして名前空間部分を得るクロージャ
        $detectNS = function ($phpfile) {
            $tokens = token_get_all(file_get_contents($phpfile));
            $count = count($tokens);

            $namespace = [];
            foreach ($tokens as $n => $token) {
                if (is_array($token) && $token[0] === T_NAMESPACE) {
                    // T_NAMESPACE と T_WHITESPACE で最低でも2つは読み飛ばしてよい
                    for ($m = $n + 2; $m < $count; $m++) {
                        // よほどのことがないと T_NAMESPACE の次の T_STRING は名前空間の一部
                        if (is_array($tokens[$m]) && $tokens[$m][0] === T_STRING) {
                            $namespace[] = $tokens[$m][1];
                        }
                        // 終わりが来たら結合して返す
                        if ($tokens[$m] === ';') {
                            return implode('\\', $namespace);
                        }
                    }
                }
            }
            return null;
        };

        // 指定パスの兄弟ファイルを調べた後、親ディレクトリを辿っていく
        $basenames = [];
        return dirname_r($location, function ($directory) use ($detectNS, &$basenames) {
            foreach (array_filter(glob("$directory/*.php"), 'is_file') as $file) {
                $namespace = $detectNS($file);
                if ($namespace !== null) {
                    $localspace = implode('\\', array_reverse($basenames));
                    return rtrim($namespace . '\\' . $localspace, '\\');
                }
            }
            $basenames[] = pathinfo($directory, PATHINFO_FILENAME);
        }) ?: throws(new \InvalidArgumentException('can not detect namespace. invalid output path or not specify namespace.'));
    }
}

const class_loader = "class_loader";
if (!isset($excluded_functions["class_loader"]) && (!function_exists("class_loader") || (!false && (new \ReflectionFunction("class_loader"))->isInternal()))) {
    /**
     * composer のクラスローダを返す
     *
     * かなり局所的な実装で vendor ディレクトリを変更していたりするとそれだけで例外になる。
     *
     * Example:
     * ```php
     * assertInstanceof(\Composer\Autoload\ClassLoader::class, class_loader());
     * ```
     *
     * @param string $startdir 高速化用の検索開始ディレクトリを指定するが、どちらかと言えばテスト用
     * @return \Composer\Autoload\ClassLoader クラスローダ
     */
    function class_loader($startdir = null)
    {
        $file = cache('path', function () use ($startdir) {
            $dir = $startdir ?: __DIR__;
            while ($dir !== ($pdir = dirname($dir))) {
                $dir = $pdir;
                if (file_exists($file = "$dir/autoload.php") || file_exists($file = "$dir/vendor/autoload.php")) {
                    $cache = $file;
                    break;
                }
            }
            if (!isset($cache)) {
                throw new \DomainException('autoloader is not found.');
            }
            return $cache;
        }, __FUNCTION__);
        return require $file;
    }
}

const class_namespace = "class_namespace";
if (!isset($excluded_functions["class_namespace"]) && (!function_exists("class_namespace") || (!false && (new \ReflectionFunction("class_namespace"))->isInternal()))) {
    /**
     * クラスの名前空間部分を取得する
     *
     * Example:
     * ```php
     * assertSame(class_namespace('vendor\\namespace\\ClassName'), 'vendor\\namespace');
     * ```
     *
     * @param string|object $class 対象クラス・オブジェクト
     * @return string クラスの名前空間
     */
    function class_namespace($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $parts = explode('\\', $class);
        array_pop($parts);
        return ltrim(implode('\\', $parts), '\\');
    }
}

const class_shorten = "class_shorten";
if (!isset($excluded_functions["class_shorten"]) && (!function_exists("class_shorten") || (!false && (new \ReflectionFunction("class_shorten"))->isInternal()))) {
    /**
     * クラスの名前空間部分を除いた短い名前を取得する
     *
     * Example:
     * ```php
     * assertSame(class_shorten('vendor\\namespace\\ClassName'), 'ClassName');
     * ```
     *
     * @param string|object $class 対象クラス・オブジェクト
     * @return string クラスの短い名前
     */
    function class_shorten($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $parts = explode('\\', $class);
        return array_pop($parts);
    }
}

const class_replace = "class_replace";
if (!isset($excluded_functions["class_replace"]) && (!function_exists("class_replace") || (!false && (new \ReflectionFunction("class_replace"))->isInternal()))) {
    /**
     * 既存（未読み込みに限る）クラスを強制的に置換する
     *
     * 例えば継承ツリーが下記の場合を考える。
     *
     * classA <- classB <- classC
     *
     * この場合、「classC は classB に」「classB は classA に」それぞれ依存している、と考えることができる。
     * これは静的に決定的であり、この依存を壊したり注入したりする手段は存在しない。
     * 例えば classA の実装を差し替えたいときに、いかに classA を継承した classAA を定義したとしても classB の親は classA で決して変わらない。
     *
     * この関数を使うと本当に classA そのものを弄るので、継承ツリーを下記のように変えることができる。
     *
     * classA <- classAA <- classB <- classC
     *
     * つまり、classA を継承した classAA を定義してそれを classA とみなすことが可能になる。
     * ただし、内部的には class_alias を使用して実現しているので厳密には異なるクラスとなる。
     *
     * 実際のところかなり強力な機能だが、同時にかなり黒魔術的なので乱用は控えたほうがいい。
     *
     * Example:
     * ```php
     * // Y1 extends X1 だとしてクラス定義でオーバーライドする
     * class_replace('\\ryunosuke\\Test\\Package\\Classobj\\X1', function() {
     *     // アンスコがついたクラスが定義されるのでそれを継承して定義する
     *     class X1d extends \ryunosuke\Test\Package\Classobj\X1_
     *     {
     *         function method(){return 'this is X1d';}
     *         function newmethod(){return 'this is newmethod';}
     *     }
     *     // このように匿名クラスを返しても良い。ただし、混在せずにどちらか一方にすること
     *     return new class() extends \ryunosuke\Test\Package\Classobj\X1_
     *     {
     *         function method(){return 'this is X1d';}
     *         function newmethod(){return 'this is newmethod';}
     *     };
     * });
     * // X1 を継承している Y1 にまで影響が出ている（X1 を完全に置換できたということ）
     * assertSame((new \ryunosuke\Test\Package\Classobj\Y1())->method(), 'this is X1d');
     * assertSame((new \ryunosuke\Test\Package\Classobj\Y1())->newmethod(), 'this is newmethod');
     *
     * // Y2 extends X2 だとしてクロージャ配列でオーバーライドする
     * class_replace('\\ryunosuke\\Test\\Package\\Classobj\\X2', function() {
     *     return [
     *         'method'    => function(){return 'this is X2d';},
     *         'newmethod' => function(){return 'this is newmethod';},
     *     ];
     * });
     * // X2 を継承している Y2 にまで影響が出ている（X2 を完全に置換できたということ）
     * assertSame((new \ryunosuke\Test\Package\Classobj\Y2())->method(), 'this is X2d');
     * assertSame((new \ryunosuke\Test\Package\Classobj\Y2())->newmethod(), 'this is newmethod');
     * ```
     *
     * @param string $class 対象クラス名
     * @param \Closure $register 置換クラスを定義 or 返すクロージャ or 定義メソッド配列
     */
    function class_replace($class, $register)
    {
        $class = ltrim($class, '\\');

        // 読み込み済みクラスは置換できない（php はクラスのアンロード機能が存在しない）
        if (class_exists($class, false)) {
            throw new \DomainException("'$class' is already declared.");
        }

        // 対象クラス名をちょっとだけ変えたクラスを用意して読み込む
        $classfile = class_loader()->findFile($class);
        $fname = cachedir() . '/' . rawurlencode(__FUNCTION__ . '-' . $class) . '.php';
        if (func_num_args() === 2 || !file_exists($fname)) {
            $content = file_get_contents($classfile);
            $content = preg_replace("#class\\s+[a-z0-9_]+#ui", '$0_', $content);
            file_set_contents($fname, $content);
        }
        require_once $fname;

        $classess = get_declared_classes();
        $newclass = $register();

        // クロージャ内部でクラス定義した場合（増えたクラスでエイリアスする）
        if ($newclass === null) {
            $classes = array_diff(get_declared_classes(), $classess);
            if (count($classes) !== 1) {
                throw new \DomainException('declared multi classes.' . implode(',', $classes));
            }
            $newclass = reset($classes);
        }
        // php7.0 から無名クラスが使えるのでそのクラス名でエイリアスする
        if (is_object($newclass)) {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $newclass = get_class($newclass);
        }
        // 配列はメソッド定義のクロージャ配列とする
        if (is_array($newclass)) {
            $content = file_get_contents($fname);
            $origspace = parse_php($content, [
                'begin' => T_NAMESPACE,
                'end'   => ';',
            ]);
            array_shift($origspace);
            array_pop($origspace);

            $origclass = parse_php($content, [
                'begin'  => T_CLASS,
                'end'    => T_STRING,
                'offset' => count($origspace),
            ]);
            array_shift($origclass);

            $origspace = trim(implode('', array_column($origspace, 1)));
            $origclass = trim(implode('', array_column($origclass, 1)));

            $methods = '';
            foreach ($newclass as $name => $func) {
                $codes = callable_code($func);
                $mname = preg_replaces('#function(\\s*)\\(#u', " $name", $codes[0]);
                $methods .= "public $mname {$codes[1]}";
            }

            $newclass = "\\$origspace\\{$origclass}_";
            eval("namespace $origspace;class {$origclass}_ extends {$origclass}{ $methods }");
        }

        class_alias($newclass, $class);
    }
}

const object_dive = "object_dive";
if (!isset($excluded_functions["object_dive"]) && (!function_exists("object_dive") || (!false && (new \ReflectionFunction("object_dive"))->isInternal()))) {
    /**
     * パス形式でプロパティ値を取得
     *
     * 存在しない場合は $default を返す。
     *
     * Example:
     * ```php
     * $class = stdclass([
     *     'a' => stdclass([
     *         'b' => stdclass([
     *             'c' => 'vvv'
     *         ])
     *     ])
     * ]);
     * assertSame(object_dive($class, 'a.b.c'), 'vvv');
     * assertSame(object_dive($class, 'a.b.x', 9), 9);
     * // 配列を与えても良い。その場合 $delimiter 引数は意味をなさない
     * assertSame(object_dive($class, ['a', 'b', 'c']), 'vvv');
     * ```
     *
     * @param object $object 調べるオブジェクト
     * @param string|array $path パス文字列。配列も与えられる
     * @param mixed $default 無かった場合のデフォルト値
     * @param string $delimiter パスの区切り文字。大抵は '.' か '/'
     * @return mixed パスが示すプロパティ値
     */
    function object_dive($object, $path, $default = null, $delimiter = '.')
    {
        $keys = is_array($path) ? $path : explode($delimiter, $path);
        foreach ($keys as $key) {
            if (!isset($object->$key)) {
                return $default;
            }
            $object = $object->$key;
        }
        return $object;
    }
}

const get_object_properties = "get_object_properties";
if (!isset($excluded_functions["get_object_properties"]) && (!function_exists("get_object_properties") || (!false && (new \ReflectionFunction("get_object_properties"))->isInternal()))) {
    /**
     * オブジェクトのプロパティを可視・不可視を問わず取得する
     *
     * get_object_vars + no public プロパティを返すイメージ。
     *
     * Example:
     * ```php
     * $object = new \Exception('something', 42);
     * $object->oreore = 'oreore';
     *
     * // get_object_vars はそのスコープから見えないプロパティを取得できない
     * // var_dump(get_object_vars($object));
     *
     * // array キャストは全て得られるが null 文字を含むので扱いにくい
     * // var_dump((array) $object);
     *
     * // この関数を使えば不可視プロパティも取得できる
     * assertArraySubset([
     *     'message' => 'something',
     *     'code'    => 42,
     *     'oreore'  => 'oreore',
     * ], get_object_properties($object));
     * ```
     *
     * @param object $object オブジェクト
     * @return array 全プロパティの配列
     */
    function get_object_properties($object)
    {
        static $refs = [];
        $class = get_class($object);
        if (!isset($refs[$class])) {
            $props = (new \ReflectionClass($class))->getProperties();
            $refs[$class] = array_each($props, function (&$carry, \ReflectionProperty $rp) {
                if (!$rp->isStatic()) {
                    $rp->setAccessible(true);
                    $carry[$rp->getName()] = $rp;
                }
            }, []);
        }

        // 配列キャストだと private で ヌル文字が出たり static が含まれたりするのでリフレクションで取得して勝手プロパティで埋める
        $vars = array_map_method($refs[$class], 'getValue', [$object]);
        $vars += get_object_vars($object);

        return $vars;
    }
}

const file_list = "file_list";
if (!isset($excluded_functions["file_list"]) && (!function_exists("file_list") || (!false && (new \ReflectionFunction("file_list"))->isInternal()))) {
    /**
     * ファイル一覧を配列で返す
     *
     * Example:
     * ```php
     * // 適当にファイルを用意
     * $DS = DIRECTORY_SEPARATOR;
     * $tmp = sys_get_temp_dir() . "{$DS}file_list";
     * rm_rf($tmp, false);
     * file_set_contents("$tmp/a.txt", 'a');
     * file_set_contents("$tmp/dir/b.txt", 'b');
     * file_set_contents("$tmp/dir/dir/c.txt", 'c');
     * // ファイル一覧が取得できる
     * assertEquals(file_list($tmp), [
     *     "$tmp{$DS}a.txt",
     *     "$tmp{$DS}dir{$DS}b.txt",
     *     "$tmp{$DS}dir{$DS}dir{$DS}c.txt",
     * ]);
     * ```
     *
     * @param string $dirname 調べるディレクトリ名
     * @param \Closure|array $filter_condition フィルタ条件
     * @return array|false ファイルの配列
     */
    function file_list($dirname, $filter_condition = null)
    {
        $dirname = realpath($dirname);
        if (!file_exists($dirname)) {
            return false;
        }

        $rdi = new \RecursiveDirectoryIterator($dirname, \FilesystemIterator::SKIP_DOTS);
        $rii = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::CHILD_FIRST);

        $result = [];
        foreach ($rii as $it) {
            if (!$it->isDir()) {
                if ($filter_condition === null || $filter_condition($it->getPathname())) {
                    $result[] = $it->getPathname();
                }
            }
        }
        return $result;
    }
}

const file_tree = "file_tree";
if (!isset($excluded_functions["file_tree"]) && (!function_exists("file_tree") || (!false && (new \ReflectionFunction("file_tree"))->isInternal()))) {
    /**
     * ディレクトリ階層をツリー構造で返す
     *
     * Example:
     * ```php
     * // 適当にファイルを用意
     * $DS = DIRECTORY_SEPARATOR;
     * $tmp = sys_get_temp_dir() . "{$DS}file_tree";
     * rm_rf($tmp, false);
     * file_set_contents("$tmp/a.txt", 'a');
     * file_set_contents("$tmp/dir/b.txt", 'b');
     * file_set_contents("$tmp/dir/dir/c.txt", 'c');
     * // ファイルツリーが取得できる
     * assertEquals(file_tree($tmp), [
     *     'file_tree' => [
     *         'a.txt' => "$tmp{$DS}a.txt",
     *         'dir'   => [
     *             'b.txt' => "$tmp{$DS}dir{$DS}b.txt",
     *             'dir'   => [
     *                 'c.txt' => "$tmp{$DS}dir{$DS}dir{$DS}c.txt",
     *             ],
     *         ],
     *     ],
     * ]);
     * ```
     *
     * @param string $dirname 調べるディレクトリ名
     * @param \Closure|array $filter_condition フィルタ条件
     * @return array|false ツリー構造の配列
     */
    function file_tree($dirname, $filter_condition = null)
    {
        $dirname = realpath($dirname);
        if (!file_exists($dirname)) {
            return false;
        }

        $basedir = basename($dirname);

        $result = [];
        $items = iterator_to_array(new \FilesystemIterator($dirname, \FilesystemIterator::SKIP_DOTS));
        usort($items, function (\SplFileInfo $a, \SplFileInfo $b) {
            if ($a->isDir() xor $b->isDir()) {
                return $a->isDir() - $b->isDir();
            }
            return strcmp($a->getPathname(), $b->getPathname());
        });
        foreach ($items as $item) {
            if (!isset($result[$basedir])) {
                $result[$basedir] = [];
            }
            if ($item->isDir()) {
                $result[$basedir] += file_tree($item->getPathname(), $filter_condition);
            }
            else {
                if ($filter_condition === null || $filter_condition($item->getPathname())) {
                    $result[$basedir][$item->getBasename()] = $item->getPathname();
                }
            }
        }
        // フィルタで全除去されると空エントリになるので明示的に削除
        if (!$result[$basedir]) {
            unset($result[$basedir]);
        }
        return $result;
    }
}

const file_suffix = "file_suffix";
if (!isset($excluded_functions["file_suffix"]) && (!function_exists("file_suffix") || (!false && (new \ReflectionFunction("file_suffix"))->isInternal()))) {
    /**
     * ファイル名にサフィックスを付与する
     *
     * pathinfoに非準拠。例えば「filename.hoge.fuga」のような形式は「filename」が変換対象になる。
     *
     * Example:
     * ```php
     * assertSame(file_suffix('filename.ext', '-min'), 'filename-min.ext');
     * assertSame(file_suffix('filename.ext1.ext2', '-min'), 'filename-min.ext1.ext2');
     * ```
     *
     * @param string $filename パス・ファイル名
     * @param string $suffix 付与するサフィックス
     * @return string サフィックスが付与されたパス名
     */
    function file_suffix($filename, $suffix)
    {
        $pathinfo = pathinfo($filename);
        $dirname = $pathinfo['dirname'];

        $exts = [];
        while (isset($pathinfo['extension'])) {
            $exts[] = '.' . $pathinfo['extension'];
            $pathinfo = pathinfo($pathinfo['filename']);
        }

        $basename = $pathinfo['filename'] . $suffix . implode('', array_reverse($exts));

        if ($dirname === '.') {
            return $basename;
        }

        return $dirname . DIRECTORY_SEPARATOR . $basename;
    }
}

const file_extension = "file_extension";
if (!isset($excluded_functions["file_extension"]) && (!function_exists("file_extension") || (!false && (new \ReflectionFunction("file_extension"))->isInternal()))) {
    /**
     * ファイルの拡張子を変更する。引数を省略すると拡張子を返す
     *
     * pathinfo に準拠。例えば「filename.hoge.fuga」のような形式は「fuga」が変換対象になる。
     *
     * Example:
     * ```php
     * assertSame(file_extension('filename.ext'), 'ext');
     * assertSame(file_extension('filename.ext', 'txt'), 'filename.txt');
     * assertSame(file_extension('filename.ext', ''), 'filename');
     * ```
     *
     * @param string $filename 調べるファイル名
     * @param string $extension 拡張子。nullや空文字なら拡張子削除
     * @return string 拡張子変換後のファイル名 or 拡張子
     */
    function file_extension($filename, $extension = '')
    {
        $pathinfo = pathinfo($filename);

        if (func_num_args() === 1) {
            return isset($pathinfo['extension']) ? $pathinfo['extension'] : null;
        }

        if (strlen($extension)) {
            $extension = '.' . ltrim($extension, '.');
        }
        $basename = $pathinfo['filename'] . $extension;

        if ($pathinfo['dirname'] === '.') {
            return $basename;
        }

        return $pathinfo['dirname'] . DIRECTORY_SEPARATOR . $basename;
    }
}

const file_set_contents = "file_set_contents";
if (!isset($excluded_functions["file_set_contents"]) && (!function_exists("file_set_contents") || (!false && (new \ReflectionFunction("file_set_contents"))->isInternal()))) {
    /**
     * ディレクトリも掘る file_put_contents
     *
     * Example:
     * ```php
     * file_set_contents(sys_get_temp_dir() . '/not/filename.ext', 'hoge');
     * assertSame(file_get_contents(sys_get_temp_dir() . '/not/filename.ext'), 'hoge');
     * ```
     *
     * @param string $filename 書き込むファイル名
     * @param string $data 書き込む内容
     * @param int $umask ディレクトリを掘る際の umask
     * @return int 書き込まれたバイト数
     */
    function file_set_contents($filename, $data, $umask = 0002)
    {
        if (func_num_args() === 2) {
            $umask = umask();
        }

        if (!is_dir($dirname = dirname($filename))) {
            if (!@mkdir_p($dirname, $umask)) {
                throw new \RuntimeException("failed to mkdir($dirname)");
            }
        }
        return file_put_contents($filename, $data);
    }
}

const file_rewrite_contents = "file_rewrite_contents";
if (!isset($excluded_functions["file_rewrite_contents"]) && (!function_exists("file_rewrite_contents") || (!false && (new \ReflectionFunction("file_rewrite_contents"))->isInternal()))) {
    /**
     * ファイルを読み込んで内容をコールバックに渡して書き込む
     *
     * Example:
     * ```php
     * // 適当にファイルを用意
     * $testpath = sys_get_temp_dir() . '/rewrite.txt';
     * file_put_contents($testpath, 'hoge');
     * // 前後に 'pre-', '-fix' を付与する
     * file_rewrite_contents($testpath, function($contents, $fp){ return "pre-$contents-fix"; });
     * assertStringEqualsFile($testpath, 'pre-hoge-fix');
     * ```
     *
     * @param string $filename 読み書きするファイル名
     * @param callable $callback 書き込む内容。引数で $contents, $fp が渡ってくる
     * @param int $operation ロック定数（LOCL_SH, LOCK_EX, LOCK_NB）
     * @return int 書き込まれたバイト数
     */
    function file_rewrite_contents($filename, $callback, $operation = 0)
    {
        try {
            // 開いて
            $fp = fopen($filename, 'c+b') ?: throws(new \UnexpectedValueException('failed to fopen.'));
            if ($operation) {
                flock($fp, $operation) ?: throws(new \UnexpectedValueException('failed to flock.'));
            }

            // 読み込んで
            rewind($fp) ?: throws(new \UnexpectedValueException('failed to rewind.'));
            $contents = false !== ($t = stream_get_contents($fp)) ? $t : throws(new \UnexpectedValueException('failed to stream_get_contents.'));

            // 変更して
            rewind($fp) ?: throws(new \UnexpectedValueException('failed to rewind.'));
            ftruncate($fp, 0) ?: throws(new \UnexpectedValueException('failed to ftruncate.'));
            $contents = $callback($contents, $fp);

            // 書き込んで
            $return = ($r = fwrite($fp, $contents)) !== false ? $r : throws(new \UnexpectedValueException('failed to fwrite.'));
            fflush($fp) ?: throws(new \UnexpectedValueException('failed to fflush.'));

            // 閉じて
            if ($operation) {
                flock($fp, LOCK_UN) ?: throws(new \UnexpectedValueException('failed to flock.'));
            }
            fclose($fp) ?: throws(new \UnexpectedValueException('failed to fclose.'));

            // 返す
            return $return;
        }
        catch (\Exception $ex) {
            if (isset($fp)) {
                if ($operation) {
                    flock($fp, LOCK_UN);
                }
                fclose($fp);
            }
            throw $ex;
        }
    }
}

const mkdir_p = "mkdir_p";
if (!isset($excluded_functions["mkdir_p"]) && (!function_exists("mkdir_p") || (!false && (new \ReflectionFunction("mkdir_p"))->isInternal()))) {
    /**
     * ディレクトリを再帰的に掘る
     *
     * 既に存在する場合は何もしない（エラーも出さない）。
     *
     * @param string $dirname ディレクトリ名
     * @param int $umask ディレクトリを掘る際の umask
     * @return bool 作成したら true
     */
    function mkdir_p($dirname, $umask = 0002)
    {
        if (func_num_args() === 1) {
            $umask = umask();
        }

        if (file_exists($dirname)) {
            return false;
        }

        return mkdir($dirname, 0777 & (~$umask), true);
    }
}

const dirname_r = "dirname_r";
if (!isset($excluded_functions["dirname_r"]) && (!function_exists("dirname_r") || (!false && (new \ReflectionFunction("dirname_r"))->isInternal()))) {
    /**
     * コールバックが true 相当を返すまで親ディレクトリを辿り続ける
     *
     * コールバックには親ディレクトリが引数として渡ってくる。
     *
     * Example:
     * ```php
     * // //tmp/a/b/file.txt を作っておく
     * $tmp = sys_get_temp_dir();
     * file_set_contents("$tmp/a/b/file.txt", 'hoge');
     * // /a/b/c/d/e/f から開始して「どこかの階層の file.txt を探したい」という状況を想定
     * $callback = function($path){return realpath("$path/file.txt");};
     * assertSame(dirname_r("$tmp/a/b/c/d/e/f", $callback), realpath("$tmp/a/b/file.txt"));
     * ```
     *
     * @param string $path パス名
     * @param callable $callback コールバック
     * @return mixed $callback の返り値。頂上まで辿ったら false
     */
    function dirname_r($path, $callback)
    {
        $return = $callback($path);
        if ($return) {
            return $return;
        }

        $dirname = dirname($path);
        if ($dirname === $path) {
            return false;
        }
        return dirname_r($dirname, $callback);
    }
}

const fnmatch_and = "fnmatch_and";
if (!isset($excluded_functions["fnmatch_and"]) && (!function_exists("fnmatch_and") || (!false && (new \ReflectionFunction("fnmatch_and"))->isInternal()))) {
    /**
     * fnmatch の AND 版
     *
     * $patterns のうちどれか一つでもマッチしなかったら false を返す。
     * $patterns が空だと例外を投げる。
     *
     * Example:
     * ```php
     * // すべてにマッチするので true
     * assertTrue(fnmatch_and(['*aaa*', '*bbb*'], 'aaaXbbbX'));
     * // aaa にはマッチするが bbb にはマッチしないので false
     * assertFalse(fnmatch_and(['*aaa*', '*bbb*'], 'aaaX'));
     * ```
     *
     * @param array|string $patterns パターン配列（単一文字列可）
     * @param string $string 調べる文字列
     * @param int $flags FNM_***
     * @return bool すべてにマッチしたら true
     */
    function fnmatch_and($patterns, $string, $flags = 0)
    {
        $patterns = is_iterable($patterns) ? $patterns : [$patterns];
        if (is_empty($patterns)) {
            throw new \InvalidArgumentException('$patterns must be not empty.');
        }

        foreach ($patterns as $pattern) {
            if (!fnmatch($pattern, $string, $flags)) {
                return false;
            }
        }
        return true;
    }
}

const fnmatch_or = "fnmatch_or";
if (!isset($excluded_functions["fnmatch_or"]) && (!function_exists("fnmatch_or") || (!false && (new \ReflectionFunction("fnmatch_or"))->isInternal()))) {
    /**
     * fnmatch の OR 版
     *
     * $patterns のうちどれか一つでもマッチしたら true を返す。
     * $patterns が空だと例外を投げる。
     *
     * Example:
     * ```php
     * // aaa にマッチするので true
     * assertTrue(fnmatch_or(['*aaa*', '*bbb*'], 'aaaX'));
     * // どれともマッチしないので false
     * assertFalse(fnmatch_or(['*aaa*', '*bbb*'], 'cccX'));
     * ```
     *
     * @param array|string $patterns パターン配列（単一文字列可）
     * @param string $string 調べる文字列
     * @param int $flags FNM_***
     * @return bool どれかにマッチしたら true
     */
    function fnmatch_or($patterns, $string, $flags = 0)
    {
        $patterns = is_iterable($patterns) ? $patterns : [$patterns];
        if (is_empty($patterns)) {
            throw new \InvalidArgumentException('$patterns must be not empty.');
        }

        foreach ($patterns as $pattern) {
            if (fnmatch($pattern, $string, $flags)) {
                return true;
            }
        }
        return false;
    }
}

const path_is_absolute = "path_is_absolute";
if (!isset($excluded_functions["path_is_absolute"]) && (!function_exists("path_is_absolute") || (!false && (new \ReflectionFunction("path_is_absolute"))->isInternal()))) {
    /**
     * パスが絶対パスか判定する
     *
     * Example:
     * ```php
     * assertTrue(path_is_absolute('/absolute/path'));
     * assertFalse(path_is_absolute('relative/path'));
     * // Windows 環境では下記も true になる
     * if (DIRECTORY_SEPARATOR === '\\') {
     *     assertTrue(path_is_absolute('\\absolute\\path'));
     *     assertTrue(path_is_absolute('C:\\absolute\\path'));
     * }
     * ```
     *
     * @param string $path パス文字列
     * @return bool 絶対パスなら true
     */
    function path_is_absolute($path)
    {
        if (substr($path, 0, 1) == '/') {
            return true;
        }

        if (DIRECTORY_SEPARATOR === '\\') {
            if (preg_match('#^([a-z]+:(\\\\|\\/|$)|\\\\)#i', $path) !== 0) {
                return true;
            }
        }

        return false;
    }
}

const path_resolve = "path_resolve";
if (!isset($excluded_functions["path_resolve"]) && (!function_exists("path_resolve") || (!false && (new \ReflectionFunction("path_resolve"))->isInternal()))) {
    /**
     * パスを絶対パスに変換して正規化する
     *
     * 可変引数で与えられた文字列群を結合して絶対パス化して返す。
     * 出来上がったパスが絶対パスでない場合はカレントディレクトリを結合して返す。
     *
     * Example:
     * ```php
     * $DS = DIRECTORY_SEPARATOR;
     * assertSame(path_resolve('/absolute/path'), "{$DS}absolute{$DS}path");
     * assertSame(path_resolve('absolute/path'), getcwd() . "{$DS}absolute{$DS}path");
     * assertSame(path_resolve('/absolute/path/through', '../current/./path'), "{$DS}absolute{$DS}path{$DS}current{$DS}path");
     * ```
     *
     * @param array $paths パス文字列（可変引数）
     * @return string 絶対パス
     */
    function path_resolve(...$paths)
    {
        $DS = DIRECTORY_SEPARATOR;

        $path = implode($DS, $paths);

        if (!path_is_absolute($path)) {
            $path = getcwd() . $DS . $path;
        }

        return path_normalize($path);
    }
}

const path_normalize = "path_normalize";
if (!isset($excluded_functions["path_normalize"]) && (!function_exists("path_normalize") || (!false && (new \ReflectionFunction("path_normalize"))->isInternal()))) {
    /**
     * パスを正規化する
     *
     * 具体的には ./ や ../ を取り除いたり連続したディレクトリ区切りをまとめたりする。
     * realpath ではない。のでシンボリックリンクの解決などはしない。その代わりファイルが存在しなくても使用することができる。
     *
     * Example:
     * ```php
     * $DS = DIRECTORY_SEPARATOR;
     * assertSame(path_normalize('/path/to/something'), "{$DS}path{$DS}to{$DS}something");
     * assertSame(path_normalize('/path/through/../something'), "{$DS}path{$DS}something");
     * assertSame(path_normalize('./path/current/./through/../something'), "path{$DS}current{$DS}something");
     * ```
     *
     * @param string $path パス文字列
     * @return string 正規化されたパス
     */
    function path_normalize($path)
    {
        $ds = '/';
        if (DIRECTORY_SEPARATOR === '\\') {
            $ds .= '\\\\';
        }

        $result = [];
        foreach (preg_split("#[$ds]#u", $path) as $n => $part) {
            if ($n > 0 && $part === '') {
                continue;
            }
            if ($part === '.') {
                continue;
            }
            if ($part === '..') {
                if (empty($result)) {
                    throw new \InvalidArgumentException("'$path' is invalid as path string.");
                }
                array_pop($result);
                continue;
            }
            $result[] = $part;
        }
        return implode(DIRECTORY_SEPARATOR, $result);
    }
}

const cp_rf = "cp_rf";
if (!isset($excluded_functions["cp_rf"]) && (!function_exists("cp_rf") || (!false && (new \ReflectionFunction("cp_rf"))->isInternal()))) {
    /**
     * ディレクトリのコピー
     *
     * $dst に / を付けると「$dst に自身をコピー」する。付けないと「$dst に中身をコピー」するという動作になる。
     *
     * ディレクトリではなくファイルを与えても動作する（copy とほぼ同じ動作になるが、対象にディレクトリを指定できる点が異なる）。
     *
     * Example:
     * ```php
     * // /tmp/src/hoge.txt, /tmp/src/dir/fuga.txt を作っておく
     * $tmp = sys_get_temp_dir();
     * file_set_contents("$tmp/src/hoge.txt", 'hoge');
     * file_set_contents("$tmp/src/dir/fuga.txt", 'fuga');
     *
     * // "/" を付けないと中身コピー
     * cp_rf("$tmp/src", "$tmp/dst1");
     * assertStringEqualsFile("$tmp/dst1/hoge.txt", 'hoge');
     * assertStringEqualsFile("$tmp/dst1/dir/fuga.txt", 'fuga');
     * // "/" を付けると自身コピー
     * cp_rf("$tmp/src", "$tmp/dst2/");
     * assertStringEqualsFile("$tmp/dst2/src/hoge.txt", 'hoge');
     * assertStringEqualsFile("$tmp/dst2/src/dir/fuga.txt", 'fuga');
     *
     * // $src はファイルでもいい（$dst に "/" を付けるとそのディレクトリにコピーする）
     * cp_rf("$tmp/src/hoge.txt", "$tmp/dst3/");
     * assertStringEqualsFile("$tmp/dst3/hoge.txt", 'hoge');
     * // $dst に "/" を付けないとそのパスとしてコピー（copy と完全に同じ）
     * cp_rf("$tmp/src/hoge.txt", "$tmp/dst4");
     * assertStringEqualsFile("$tmp/dst4", 'hoge');
     * ```
     *
     * @param string $src コピー元パス
     * @param string $dst コピー先パス。末尾/でディレクトリであることを明示できる
     * @return bool 成功した場合に TRUE を、失敗した場合に FALSE を返します
     */
    function cp_rf($src, $dst)
    {
        $dss = '/' . (DIRECTORY_SEPARATOR === '\\' ? '\\\\' : '');
        $dirmode = preg_match("#[$dss]$#u", $dst);

        // ディレクトリでないなら copy へ移譲
        if (!is_dir($src)) {
            if ($dirmode) {
                mkdir_p($dst);
                return copy($src, $dst . basename($src));
            }
            else {
                mkdir_p(dirname($dst));
                return copy($src, $dst);
            }
        }

        if ($dirmode) {
            return cp_rf($src, $dst . basename($src));
        }

        mkdir_p($dst);

        foreach (glob("$src/*") as $file) {
            if (is_dir($file)) {
                cp_rf($file, "$dst/" . basename($file));
            }
            else {
                copy($file, "$dst/" . basename($file));
            }
        }
        return file_exists($dst);
    }
}

const rm_rf = "rm_rf";
if (!isset($excluded_functions["rm_rf"]) && (!function_exists("rm_rf") || (!false && (new \ReflectionFunction("rm_rf"))->isInternal()))) {
    /**
     * 中身があっても消せる rmdir
     *
     * Example:
     * ```php
     * mkdir(sys_get_temp_dir() . '/new/make/dir', 0777, true);
     * rm_rf(sys_get_temp_dir() . '/new');
     * assertSame(file_exists(sys_get_temp_dir() . '/new'), false);
     * ```
     *
     * @param string $dirname 削除するディレクトリ名
     * @param bool $self 自分自身も含めるか。false を与えると中身だけを消す
     * @return bool 成功した場合に TRUE を、失敗した場合に FALSE を返します
     */
    function rm_rf($dirname, $self = true)
    {
        if (!file_exists($dirname)) {
            return false;
        }

        $rdi = new \RecursiveDirectoryIterator($dirname, \FilesystemIterator::SKIP_DOTS);
        $rii = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($rii as $it) {
            if ($it->isDir()) {
                rmdir($it->getPathname());
            }
            else {
                unlink($it->getPathname());
            }
        }

        if ($self) {
            return rmdir($dirname);
        }
    }
}

const tmpname = "tmpname";
if (!isset($excluded_functions["tmpname"]) && (!function_exists("tmpname") || (!false && (new \ReflectionFunction("tmpname"))->isInternal()))) {
    /**
     * 終了時に削除される一時ファイル名を生成する
     *
     * tempnam とほぼ同じで違いは下記。
     *
     * - 引数が逆
     * - 終了時に削除される
     * - 失敗時に false を返すのではなく例外を投げる
     *
     * @param string $prefix ファイル名プレフィックス
     * @param string $dir 生成ディレクトリ。省略時は sys_get_temp_dir()
     * @return string 一時ファイル名
     */
    function tmpname($prefix = 'rft', $dir = null)
    {
        // デフォルト付きで tempnam を呼ぶ
        $dir = $dir ?: cachedir();
        $tempfile = tempnam($dir, $prefix);

        // tempnam が何をしても false を返してくれないんだがどうしたら返してくれるんだろうか？
        if ($tempfile === false) {
            throw new \UnexpectedValueException("tmpname($dir, $prefix) failed.");// @codeCoverageIgnore
        }

        // 生成したファイルを覚えておいて最後に消す
        static $files = [];
        $files[$tempfile] = new class($tempfile)
        {
            private $tempfile;

            public function __construct($tempfile) { $this->tempfile = $tempfile; }

            public function __destruct() { return $this(); }

            public function __invoke()
            {
                // 明示的に消されたかもしれないので file_exists してから消す
                if (file_exists($this->tempfile)) {
                    // レースコンディションのため @ を付ける
                    @unlink($this->tempfile);
                }
            }
        };

        return $tempfile;
    }
}

const memory_path = "memory_path";
if (!isset($excluded_functions["memory_path"]) && (!function_exists("memory_path") || (!false && (new \ReflectionFunction("memory_path"))->isInternal()))) {
    /**
     * ファイルのように扱えるメモリ上のパスを返す
     *
     * 劣化 vfsStream のようなもの。
     * stream wrapper を用いて実装しており、そのプロトコルは初回呼び出し時に1度だけ登録される。
     * プロトコル名は決め打ちだが、 php.ini に "rfunc.memory_stream" というキーで文字列を指定するとそれが使用される。
     *
     * ファイル操作はある程度できるが、ディレクトリ操作は未対応（そこまでしたいなら vfsStream とか /dev/shm とかを使えば良い）。
     *
     * Example:
     * ```php
     * // ファイル名のように読み書きができるパスを返す（一時ファイルを使用するよりかなり高速に動作する）
     * $memory_path = memory_path('filename.txt');
     * // 呼んだだけでは何もしないので存在しない
     * assertSame(file_exists($memory_path), false);
     * // file_put_contents が使える
     * assertSame(file_put_contents($memory_path, 'Hello, World'), 12);
     * // file_get_contents が使える
     * assertSame(file_get_contents($memory_path), 'Hello, World');
     * // 上記の操作で実体が存在している
     * assertSame(file_exists($memory_path), true);
     * // unlink が使える
     * assertSame(unlink($memory_path), true);
     * // unlink したので存在しない
     * assertSame(file_exists($memory_path), false);
     * ```
     *
     * @param string $path パス名（実質的に一意なファイル名）
     * @return string メモリ上のパス
     */
    function memory_path($path)
    {
        static $STREAM_NAME, $registered = false;
        if (!$registered) {
            $STREAM_NAME = $STREAM_NAME ?: get_cfg_var('rfunc.memory_stream') ?: 'MemoryStreamV010000';
            if (in_array($STREAM_NAME, stream_get_wrappers())) {
                throw new \DomainException("$STREAM_NAME is registered already.");
            }

            $registered = true;
            stream_wrapper_register($STREAM_NAME, get_class(new class()
            {
                private static $entries = [];

                private $entry;
                private $id;
                private $position;
                private $readable;
                private $writable;
                private $appendable;

                public $context;

                private static function create()
                {
                    // @todo time 系は一応用意しているだけでほとんど未実装（read/write のたびに更新する？）
                    $now = time();
                    return (object) [
                        'permission' => 0777 & ~umask(),
                        'owner'      => function_exists('posix_getuid') ? posix_getuid() : 0,
                        'group'      => function_exists('posix_getgid') ? posix_getgid() : 0,
                        'atime'      => $now,
                        'mtime'      => $now,
                        'ctime'      => $now,
                        'content'    => '',
                    ];
                }

                private static function stat($id)
                {
                    $that = self::$entries[$id];
                    return [
                        'dev'     => 0,
                        'ino'     => 0,
                        'mode'    => $that->permission,
                        'nlink'   => 0,
                        'uid'     => $that->owner,
                        'gid'     => $that->group,
                        'rdev'    => 0,
                        'size'    => strlen($that->content),
                        'atime'   => $that->atime,
                        'mtime'   => $that->mtime,
                        'ctime'   => $that->ctime,
                        'blksize' => -1,
                        'blocks'  => -1,
                    ];
                }

                public function __call($name, $arguments)
                {
                    // 対応して無くても標準では警告止まりなので例外に変える
                    throw new \DomainException("$name is not supported.");
                }

                public function stream_open(string $path, string $mode, int $options, &$opened_path): bool
                {
                    assert(is_int($options));
                    assert(!strlen($opened_path));
                    $this->id = parse_url($path, PHP_URL_HOST);

                    // t フラグはクソなので実装しない（デフォルトで b フラグとする）
                    if (strpos($mode, 'r') !== false) {
                        // 普通の fopen でファイルが存在しないとエラーになるので模倣する
                        if (!isset(self::$entries[$this->id])) {
                            throw new \InvalidArgumentException("'$path' is not exist.");
                        }
                        $this->position = 0;
                        $this->readable = true;
                        $this->writable = strpos($mode, '+') !== false;
                        $this->appendable = false;
                    }
                    elseif (strpos($mode, 'w') !== false) {
                        // ファイルポインタをファイルの先頭に置き、ファイルサイズをゼロにします。
                        // ファイルが存在しない場合には、作成を試みます。
                        self::$entries[$this->id] = self::create();
                        $this->position = 0;
                        $this->readable = strpos($mode, '+') !== false;
                        $this->writable = true;
                        $this->appendable = false;
                    }
                    elseif (strpos($mode, 'a') !== false) {
                        // ファイルポインタをファイルの終端に置きます。
                        // ファイルが存在しない場合には、作成を試みます。
                        if (!isset(self::$entries[$this->id])) {
                            self::$entries[$this->id] = self::create();
                        }
                        $this->position = 0;
                        $this->readable = strpos($mode, '+') !== false;
                        $this->writable = true;
                        $this->appendable = true;
                    }
                    elseif (strpos($mode, 'x') !== false) {
                        // ファイルポインタをファイルの先頭に置きます。
                        // ファイルが既に存在する場合には fopen() は失敗し、 E_WARNING レベルのエラーを発行します。
                        // ファイルが存在しない場合には新規作成を試みます。
                        if (isset(self::$entries[$this->id])) {
                            throw new \InvalidArgumentException("'$path' is exist already.");
                        }
                        self::$entries[$this->id] = self::create();
                        $this->position = 0;
                        $this->readable = strpos($mode, '+') !== false;
                        $this->writable = true;
                        $this->appendable = false;
                    }
                    elseif (strpos($mode, 'c') !== false) {
                        // ファイルが存在しない場合には新規作成を試みます。
                        // ファイルが既に存在する場合でもそれを ('w' のように) 切り詰めたりせず、 また ('x' のように) 関数のコールが失敗することもありません。
                        // ファイルポインタをファイルの先頭に置きます。
                        if (!isset(self::$entries[$this->id])) {
                            self::$entries[$this->id] = self::create();
                        }
                        $this->position = 0;
                        $this->readable = strpos($mode, '+') !== false;
                        $this->writable = true;
                        $this->appendable = false;
                    }

                    $this->entry = self::$entries[$this->id];

                    return true;
                }

                public function stream_close()
                {
                }

                public function stream_lock(int $operation): bool
                {
                    assert(is_int($operation));
                    // メモリアクセスは競合しないので常に true を返す
                    return true;
                }

                public function stream_flush(): bool
                {
                    // バッファしないので常に true を返す
                    return true;
                }

                public function stream_eof(): bool
                {
                    return $this->position >= strlen($this->entry->content);
                }

                public function stream_read(int $count): string
                {
                    if (!$this->readable) {
                        return '';
                    }
                    $result = substr($this->entry->content, $this->position, $count);
                    $this->position += strlen($result);
                    return $result;
                }

                public function stream_write(string $data): int
                {
                    if (!$this->writable) {
                        return 0;
                    }
                    $datalen = strlen($data);
                    $posision = $this->position;
                    // このモードは、fseek() では何の効果もありません。書き込みは、常に追記となります。
                    if ($this->appendable) {
                        $posision = strlen($this->entry->content);
                    }
                    // 一般的に、ファイルの終端より先の位置に移動することも許されています。
                    // そこにデータを書き込んだ場合、ファイルの終端からシーク位置までの範囲を読み込むと 値 0 が埋められたバイトを返します。
                    $current = str_pad($this->entry->content, $posision, "\0", STR_PAD_RIGHT);
                    $this->entry->content = substr_replace($current, $data, $posision, $datalen);
                    $this->position += $datalen;
                    return $datalen;
                }

                public function stream_truncate(int $new_size): bool
                {
                    if (!$this->writable) {
                        return false;
                    }
                    $current = substr($this->entry->content, 0, $new_size);
                    $this->entry->content = str_pad($current, $new_size, "\0", STR_PAD_RIGHT);
                    return true;
                }

                public function stream_tell(): int
                {
                    return $this->position;
                }

                public function stream_seek(int $offset, int $whence = SEEK_SET): bool
                {
                    $strlen = strlen($this->entry->content);
                    switch ($whence) {
                        case SEEK_SET:
                            if ($offset < 0) {
                                return false;
                            }
                            $this->position = $offset;
                            break;

                        // stream_tell を定義していると SEEK_CUR が呼ばれない？（計算されて SEEK_SET に移譲されているような気がする）
                        // @codeCoverageIgnoreStart
                        case SEEK_CUR:
                            $this->position += $offset;
                            break;
                        // @codeCoverageIgnoreEnd

                        case SEEK_END:
                            $this->position = $strlen + $offset;
                            break;
                    }
                    // ファイルの終端から数えた位置に移動するには、負の値を offset に渡して whence を SEEK_END に設定しなければなりません。
                    if ($this->position < 0) {
                        $this->position = $strlen + $this->position;
                        if ($this->position < 0) {
                            $this->position = 0;
                            return false;
                        }
                    }
                    return true;
                }

                public function stream_stat()
                {
                    return self::stat($this->id);
                }

                public function stream_metadata($path, $option, $var)
                {
                    $id = parse_url($path, PHP_URL_HOST);
                    switch ($option) {
                        case STREAM_META_TOUCH:
                            if (!isset(self::$entries[$id])) {
                                self::$entries[$id] = self::create();
                            }
                            $mtime = $var[0] ?? time();
                            $atime = $var[1] ?? $mtime;
                            self::$entries[$id]->mtime = $mtime;
                            self::$entries[$id]->atime = $atime;
                            break;

                        case STREAM_META_ACCESS:
                            if (!isset(self::$entries[$id])) {
                                return false;
                            }
                            self::$entries[$id]->permission = $var;
                            self::$entries[$id]->ctime = time();
                            break;

                        /** @noinspection PhpMissingBreakStatementInspection */
                        case STREAM_META_OWNER_NAME:
                            $var = function_exists('posix_getpwnam') ? posix_getpwnam($var)['uid'] : 0;
                        case STREAM_META_OWNER:
                            if (!isset(self::$entries[$id])) {
                                return false;
                            }
                            self::$entries[$id]->owner = $var;
                            self::$entries[$id]->ctime = time();
                            break;

                        /** @noinspection PhpMissingBreakStatementInspection */
                        case STREAM_META_GROUP_NAME:
                            $var = function_exists('posix_getgrnam') ? posix_getgrnam($var)['gid'] : 0;
                        case STREAM_META_GROUP:
                            if (!isset(self::$entries[$id])) {
                                return false;
                            }
                            self::$entries[$id]->group = $var;
                            self::$entries[$id]->ctime = time();
                            break;
                    }
                    // https://qiita.com/hnw/items/3af76d3d7ec2cf52fff8
                    clearstatcache(true, $path);
                    return true;
                }

                public function url_stat(string $path, int $flags)
                {
                    assert(is_int($flags));
                    $id = parse_url($path, PHP_URL_HOST);
                    if (!isset(self::$entries[$id])) {
                        return false;
                    }
                    return self::stat($id);
                }

                public function rename(string $path_from, string $path_to): bool
                {
                    // rename は同じプロトコルじゃないと使えない制約があるのでプロトコルは見ないで OK
                    $id_from = parse_url($path_from, PHP_URL_HOST);
                    if (!isset(self::$entries[$id_from])) {
                        return false;
                    }
                    $id_to = parse_url($path_to, PHP_URL_HOST);
                    self::$entries[$id_to] = self::$entries[$id_from];
                    unset(self::$entries[$id_from]);
                    // https://qiita.com/hnw/items/3af76d3d7ec2cf52fff8
                    clearstatcache(true, $path_from);
                    return true;
                }

                public function unlink(string $path): bool
                {
                    $id = parse_url($path, PHP_URL_HOST);
                    if (!isset(self::$entries[$id])) {
                        return false;
                    }
                    unset(self::$entries[$id]);
                    // もしファイルを作成した場合、 たとえファイルを削除したとしても TRUE を返します。しかし、unlink() はキャッシュを自動的にクリアします。
                    clearstatcache(true, $path);
                    return true;
                }
            }));
        }

        return "$STREAM_NAME://$path";
    }
}

const delegate = "delegate";
if (!isset($excluded_functions["delegate"]) && (!function_exists("delegate") || (!false && (new \ReflectionFunction("delegate"))->isInternal()))) {
    /**
     * 指定 callable を指定クロージャで実行するクロージャを返す
     *
     * ほぼ内部向けで外から呼ぶことはあまり想定していない。
     *
     * @param \Closure $invoker クロージャを実行するためのクロージャ（実処理）
     * @param callable $callable 最終的に実行したいクロージャ
     * @param int $arity 引数の数
     * @return \Closure $callable を実行するクロージャ
     */
    function delegate($invoker, $callable, $arity = null)
    {
        // 「delegate 経由で作成されたクロージャ」であることをマーキングするための use 変数
        $__rfunc_delegate_marker = true;

        if ($arity === null) {
            $arity = parameter_length($callable, true, true);
        }

        if (is_infinite($arity)) {
            return eval('return function (...$_) use ($__rfunc_delegate_marker, $invoker, $callable) {
                return $invoker($callable, func_get_args());
            };');
        }

        $arity = abs($arity);
        switch ($arity) {
            case 0:
                return function () use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 1:
                return function ($_1) use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 2:
                return function ($_1, $_2) use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 3:
                return function ($_1, $_2, $_3) use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 4:
                return function ($_1, $_2, $_3, $_4) use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            case 5:
                return function ($_1, $_2, $_3, $_4, $_5) use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };
            default:
                $argstring = array_rmap(range(1, $arity), strcat, '$_');
                return eval('return function (' . implode(', ', $argstring) . ') use ($__rfunc_delegate_marker, $invoker, $callable) {
                    return $invoker($callable, func_get_args());
                };');
        }
    }
}

const nbind = "nbind";
if (!isset($excluded_functions["nbind"]) && (!function_exists("nbind") || (!false && (new \ReflectionFunction("nbind"))->isInternal()))) {
    /**
     * $callable の指定位置に引数を束縛したクロージャを返す
     *
     * Example:
     * ```php
     * $bind = nbind('sprintf', 2, 'X');
     * assertSame($bind('%s%s%s', 'N', 'N'), 'NXN');
     * ```
     *
     * @param callable $callable 対象 callable
     * @param int $n 挿入する引数位置
     * @param mixed $variadic 本来の引数（可変引数）
     * @return \Closure 束縛したクロージャ
     */
    function nbind($callable, $n, ...$variadic)
    {
        return delegate(function ($callable, $args) use ($variadic, $n) {
            return $callable(...array_insert($args, $variadic, $n));
        }, $callable, parameter_length($callable, true) - count($variadic));
    }
}

const lbind = "lbind";
if (!isset($excluded_functions["lbind"]) && (!function_exists("lbind") || (!false && (new \ReflectionFunction("lbind"))->isInternal()))) {
    /**
     * $callable の最左に引数を束縛した callable を返す
     *
     * Example:
     * ```php
     * $bind = lbind('sprintf', '%s%s');
     * assertSame($bind('N', 'M'), 'NM');
     * ```
     *
     * @param callable $callable 対象 callable
     * @param mixed $variadic 本来の引数（可変引数）
     * @return \Closure 束縛したクロージャ
     */
    function lbind($callable, ...$variadic)
    {
        return nbind(...array_insert(func_get_args(), 0, 1));
    }
}

const rbind = "rbind";
if (!isset($excluded_functions["rbind"]) && (!function_exists("rbind") || (!false && (new \ReflectionFunction("rbind"))->isInternal()))) {
    /**
     * $callable の最右に引数を束縛した callable を返す
     *
     * Example:
     * ```php
     * $bind = rbind('sprintf', 'X');
     * assertSame($bind('%s%s', 'N'), 'NX');
     * ```
     *
     * @param callable $callable 対象 callable
     * @param mixed $variadic 本来の引数（可変引数）
     * @return \Closure 束縛したクロージャ
     */
    function rbind($callable, ...$variadic)
    {
        return nbind(...array_insert(func_get_args(), null, 1));
    }
}

const composite = "composite";
if (!isset($excluded_functions["composite"]) && (!function_exists("composite") || (!false && (new \ReflectionFunction("composite"))->isInternal()))) {
    /**
     * 合成関数を返す
     *
     * 基本的には callable を可変引数で呼び出せばそれらの合成関数を返す。
     * ただし $arrayalbe=true のときは若干挙動が異なり、連鎖のときに「前の返り値を**配列として**次の引数へ渡す」動作になる。
     * つまり、前の関数が `[1, 2, 3]` を返せば次の関数へは `f(1, 2, 3)` が渡る（ただしただの配列の場合のみ。連想配列は単値で渡る）。
     * $arrayalbe=false のときは渡る引数は常に単値（単値というか素直に渡すだけ）。
     * 上の例で言えば、前の関数が `[1, 2, 3]` を返せば次の関数へは `f($array=[1, 2, 3])` が渡る。
     *
     * $arrayalbe=true の方が利便性は高い。が、「本当にただの配列を渡したいとき」が判断できないので誤動作の原因にもなる。
     * e.g. `[1, 2, 3]` を配列として渡したいが $arrayalbe=true だと3つの引数として渡ってしまう
     *
     * いずれにせよ $arrayalbe は必須ではなく、第1引数が bool ならオプションだと判断し、そうでないなら true とみなす。
     *
     * Example:
     * ```php
     * $add5 = function ($v) { return $v + 5; };            // 来た値を +5 するクロージャ
     * $mul3 = function ($v) { return $v * 3; };            // 来た値を *3 するクロージャ
     * $split = function ($v) { return str_split($v); };    // 文字列的に桁分割するクロージャ
     * $union = function ($v) { return $v[0] + $v[1]; };    // 来た配列を足すクロージャ
     * $composite = composite(false, $add5, $mul3, $split, $union);// 上記を合成したクロージャ
     * // false を渡すと配列を考慮しない（つまり、単一の引数しか受け取れず、単一の返り値しか返せない）
     * // 7 + 5 -> 12 |> 12 * 3 -> 36 |> 36 -> [3, 6] |> 3 + 6 |> 9
     * assertSame($composite(7), 9);
     *
     * $upper = function ($s) { return [$s, strtoupper($s)]; };   // 来た値と大文字化したものを配列で返すクロージャ
     * $prefix = function ($s, $S) { return 'pre-' . $s . $S; };  // 来た値を結合して'pre-'を付けるクロージャ
     * $hash = function ($sS) { return ['sS' => $sS]; };          // 来た値を連想配列にするクロージャ
     * $key = function ($sSsS) { return strrev(reset($sSsS));};   // 来た配列の値をstrrevして返すクロージャ
     * $composite = composite(true, $upper, $prefix, $hash, $key);// 上記を合成したクロージャ
     * // true を渡すとただの配列は引数として、連想配列は単値として渡ってくる
     * // ['hoge', 'HOGE'] |> 'pre-hogeHOGE' |> ['sS' => 'pre-hogeHOGE'] |> 'EGOHegoh-erp'
     * assertSame($composite('hoge'), 'EGOHegoh-erp');
     * ```
     *
     * @param bool $arrayalbe 呼び出しチェーンを配列として扱うか
     * @param callable[] $variadic 合成する関数（可変引数）
     * @return \Closure 合成関数
     */
    function composite($arrayalbe = true, ...$variadic)
    {
        $callables = func_get_args();

        // モード引数が来てるなら捨てる
        if (!is_callable($arrayalbe)) {
            array_shift($callables);
        }
        // 来てないなら前方省略なのでデフォルト値を代入
        else {
            $arrayalbe = true;
        }

        if (empty($callables)) {
            throw new \InvalidArgumentException('too few arguments.');
        }

        $first = array_shift($callables);
        return delegate(function ($first, $args) use ($callables, $arrayalbe) {
            $result = $first(...$args);
            foreach ($callables as $callable) {
                // 「配列モードでただの配列」でないなら配列化
                if (!($arrayalbe && is_array($result) && !is_hasharray($result))) {
                    $result = [$result];
                }
                $result = $callable(...$result);
            }
            return $result;
        }, $first);
    }
}

const return_arg = "return_arg";
if (!isset($excluded_functions["return_arg"]) && (!function_exists("return_arg") || (!false && (new \ReflectionFunction("return_arg"))->isInternal()))) {
    /**
     * $n 番目の引数（0 ベース）をそのまま返すクロージャを返す
     *
     * Example:
     * ```php
     * $arg0 = return_arg(0);
     * assertSame($arg0('hoge'), 'hoge');
     * $arg1 = return_arg(1);
     * assertSame($arg1('dummy', 'hoge'), 'hoge');
     * ```
     *
     * @param int $n $n 番目の引数
     * @return \Closure $n 番目の引数をそのまま返すクロージャ
     */
    function return_arg($n)
    {
        static $cache = [];
        if (!isset($cache[$n])) {
            $cache[$n] = function () use ($n) {
                return func_get_arg($n);
            };
        }
        return $cache[$n];
    }
}

const ope_func = "ope_func";
if (!isset($excluded_functions["ope_func"]) && (!function_exists("ope_func") || (!false && (new \ReflectionFunction("ope_func"))->isInternal()))) {
    /**
     * 演算子のクロージャを返す
     *
     * 関数ベースなので `??` のような言語組み込みの特殊な演算子は若干希望通りにならない（Notice が出る）。
     *
     * Example:
     * ```php
     * $not = ope_func('!');    // 否定演算子クロージャ
     * assertSame(false, $not(true));
     *
     * $minus = ope_func('-'); // マイナス演算子クロージャ
     * assertSame(-2, $minus(2));       // 引数1つで呼ぶと1項演算子
     * assertSame(3 - 2, $minus(3, 2)); // 引数2つで呼ぶと2項演算子
     *
     * $cond = ope_func('?:'); // 条件演算子クロージャ
     * assertSame('OK' ?: 'NG', $cond('OK', 'NG'));               // 引数2つで呼ぶと2項演算子
     * assertSame(false ? 'OK' : 'NG', $cond(false, 'OK', 'NG')); // 引数3つで呼ぶと3項演算子
     * ```
     *
     * @param string $operator 演算子
     * @return \Closure 演算子のクロージャ
     */
    function ope_func($operator)
    {
        static $operators = null;
        $operators = $operators ?: [
            ''           => static function ($v1) { return $v1; }, // こんな演算子はないが、「if ($value) {}」として使えることがある
            '!'          => static function ($v1) { return !$v1; },
            '+'          => static function ($v1, $v2 = null) { return func_num_args() === 1 ? (+$v1) : ($v1 + $v2); },
            '-'          => static function ($v1, $v2 = null) { return func_num_args() === 1 ? (-$v1) : ($v1 - $v2); },
            '~'          => static function ($v1) { return ~$v1; },
            '++'         => static function (&$v1) { return ++$v1; },
            '--'         => static function (&$v1) { return --$v1; },
            '?:'         => static function ($v1, $v2, $v3 = null) { return func_num_args() === 2 ? ($v1 ?: $v2) : ($v1 ? $v2 : $v3); },
            '??'         => static function ($v1, $v2) { return $v1 ?? $v2; },
            '=='         => static function ($v1, $v2) { return $v1 == $v2; },
            '==='        => static function ($v1, $v2) { return $v1 === $v2; },
            '!='         => static function ($v1, $v2) { return $v1 != $v2; },
            '<>'         => static function ($v1, $v2) { return $v1 <> $v2; },
            '!=='        => static function ($v1, $v2) { return $v1 !== $v2; },
            '<'          => static function ($v1, $v2) { return $v1 < $v2; },
            '<='         => static function ($v1, $v2) { return $v1 <= $v2; },
            '>'          => static function ($v1, $v2) { return $v1 > $v2; },
            '>='         => static function ($v1, $v2) { return $v1 >= $v2; },
            '<=>'        => static function ($v1, $v2) { return $v1 <=> $v2; },
            '.'          => static function ($v1, $v2) { return $v1 . $v2; },
            '*'          => static function ($v1, $v2) { return $v1 * $v2; },
            '/'          => static function ($v1, $v2) { return $v1 / $v2; },
            '%'          => static function ($v1, $v2) { return $v1 % $v2; },
            '**'         => static function ($v1, $v2) { return $v1 ** $v2; },
            '^'          => static function ($v1, $v2) { return $v1 ^ $v2; },
            '&'          => static function ($v1, $v2) { return $v1 & $v2; },
            '|'          => static function ($v1, $v2) { return $v1 | $v2; },
            '<<'         => static function ($v1, $v2) { return $v1 << $v2; },
            '>>'         => static function ($v1, $v2) { return $v1 >> $v2; },
            '&&'         => static function ($v1, $v2) { return $v1 && $v2; },
            '||'         => static function ($v1, $v2) { return $v1 || $v2; },
            'or'         => static function ($v1, $v2) { return $v1 or $v2; },
            'and'        => static function ($v1, $v2) { return $v1 and $v2; },
            'xor'        => static function ($v1, $v2) { return $v1 xor $v2; },
            'instanceof' => static function ($v1, $v2) { return $v1 instanceof $v2; },
        ];

        return $operators[trim($operator)] ?? throws(new \InvalidArgumentException("$operator is not defined Operator."));
    }
}

const not_func = "not_func";
if (!isset($excluded_functions["not_func"]) && (!function_exists("not_func") || (!false && (new \ReflectionFunction("not_func"))->isInternal()))) {
    /**
     * 返り値の真偽値を逆転した新しいクロージャを返す
     *
     * Example:
     * ```php
     * $not_strlen = not_func('strlen');
     * assertFalse($not_strlen('hoge'));
     * assertTrue($not_strlen(''));
     * ```
     *
     * @param callable $callable 対象 callable
     * @return \Closure 新しいクロージャ
     */
    function not_func($callable)
    {
        return delegate(function ($callable, $args) {
            return !$callable(...$args);
        }, $callable);
    }
}

const eval_func = "eval_func";
if (!isset($excluded_functions["eval_func"]) && (!function_exists("eval_func") || (!false && (new \ReflectionFunction("eval_func"))->isInternal()))) {
    /**
     * 指定コードで eval するクロージャを返す
     *
     * create_function のクロージャ版みたいなもの。
     * 参照渡しは未対応。
     *
     * Example:
     * ```php
     * $evalfunc = eval_func('$a + $b + $c', 'a', 'b', 'c');
     * assertSame($evalfunc(1, 2, 3), 6);
     * ```
     *
     * @param string $expression eval コード
     * @param mixed $variadic 引数名（可変引数）
     * @return \Closure 新しいクロージャ
     */
    function eval_func($expression, ...$variadic)
    {
        static $cache = [];
        $args = array_sprintf($variadic, '$%s', ',');
        $declare = "return function($args) { return $expression; };";
        if (!isset($cache[$declare])) {
            $cache[$declare] = eval($declare);
        }
        return $cache[$declare];
    }
}

const reflect_callable = "reflect_callable";
if (!isset($excluded_functions["reflect_callable"]) && (!function_exists("reflect_callable") || (!false && (new \ReflectionFunction("reflect_callable"))->isInternal()))) {
    /**
     * callable から ReflectionFunctionAbstract を生成する
     *
     * Example:
     * ```php
     * assertInstanceof(\ReflectionFunction::class, reflect_callable('sprintf'));
     * assertInstanceof(\ReflectionMethod::class, reflect_callable('\Closure::bind'));
     * ```
     *
     * @param callable $callable 対象 callable
     * @return \ReflectionFunction|\ReflectionMethod リフレクションインスタンス
     */
    function reflect_callable($callable)
    {
        // callable チェック兼 $call_name 取得
        if (!is_callable($callable, true, $call_name)) {
            throw new \InvalidArgumentException("'$call_name' is not callable");
        }

        if ($callable instanceof \Closure || strpos($call_name, '::') === false) {
            return new \ReflectionFunction($callable);
        }
        else {
            list($class, $method) = explode('::', $call_name, 2);
            // for タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)
            if (strpos($method, 'parent::') === 0) {
                list(, $method) = explode('::', $method);
                return (new \ReflectionClass($class))->getParentClass()->getMethod($method);
            }
            return new \ReflectionMethod($class, $method);
        }
    }
}

const closurize = "closurize";
if (!isset($excluded_functions["closurize"]) && (!function_exists("closurize") || (!false && (new \ReflectionFunction("closurize"))->isInternal()))) {
    /**
     * callable を Closure に変換する
     *
     * Example:
     * ```php
     * $sprintf = closurize('sprintf');
     * assertInstanceof(\Closure::class, $sprintf);
     * assertSame($sprintf('%s %s', 'hello', 'world'), 'hello world');
     * ```
     *
     * @param callable $callable 変換する callable
     * @return \Closure 変換したクロージャ
     */
    function closurize($callable)
    {
        return \Closure::fromCallable($callable);
    }
}

const callable_code = "callable_code";
if (!isset($excluded_functions["callable_code"]) && (!function_exists("callable_code") || (!false && (new \ReflectionFunction("callable_code"))->isInternal()))) {
    /**
     * callable のコードブロックを返す
     *
     * 返り値は2値の配列。0番目の要素が定義部、1番目の要素が処理部を表す。
     *
     * Example:
     * ```php
     * list($meta, $body) = callable_code(function(...$args){return true;});
     * assertSame($meta, 'function(...$args)');
     * assertSame($body, '{return true;}');
     * ```
     *
     * @param callable $callable コードを取得する callable
     * @return array ['定義部分', '{処理コード}']
     */
    function callable_code($callable)
    {
        /** @var \ReflectionFunctionAbstract $ref */
        $ref = reflect_callable($callable);
        $contents = file($ref->getFileName());
        $start = $ref->getStartLine();
        $end = $ref->getEndLine();
        $codeblock = implode('', array_slice($contents, $start - 1, $end - $start + 1));

        $meta = parse_php("<?php $codeblock", [
            'begin' => T_FUNCTION,
            'end'   => '{',
        ]);
        array_pop($meta);

        $body = parse_php("<?php $codeblock", [
            'begin'  => '{',
            'end'    => '}',
            'offset' => count($meta),
        ]);

        return [trim(implode('', array_column($meta, 1))), trim(implode('', array_column($body, 1)))];
    }
}

const call_safely = "call_safely";
if (!isset($excluded_functions["call_safely"]) && (!function_exists("call_safely") || (!false && (new \ReflectionFunction("call_safely"))->isInternal()))) {
    /**
     * エラーを例外に変換するブロックでコールバックを実行する
     *
     * Example:
     * ```php
     * try {
     *     call_safely(function(){return $v;});
     * }
     * catch (\Exception $ex) {
     *     assertSame($ex->getMessage(), 'Undefined variable: v');
     * }
     * ```
     *
     * @param callable $callback 実行するコールバック
     * @param mixed $variadic $callback に渡される引数（可変引数）
     * @return mixed $callback の返り値
     */
    function call_safely($callback, ...$variadic)
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            if (error_reporting() === 0) {
                return false;
            }
            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        });

        try {
            return $callback(...$variadic);
        }
        finally {
            restore_error_handler();
        }
    }
}

const ob_capture = "ob_capture";
if (!isset($excluded_functions["ob_capture"]) && (!function_exists("ob_capture") || (!false && (new \ReflectionFunction("ob_capture"))->isInternal()))) {
    /**
     * ob_start ～ ob_get_clean のブロックでコールバックを実行する
     *
     * Example:
     * ```php
     * // コールバック内のテキストが得られる
     * assertSame(ob_capture(function(){echo 123;}), '123');
     * // こういう事もできる
     * assertSame(ob_capture(function () {
     * ?>
     * bare string1
     * bare string2
     * <?php
     * }), "bare string1\nbare string2\n");
     * ```
     *
     * @param callable $callback 実行するコールバック
     * @param mixed $variadic $callback に渡される引数（可変引数）
     * @return string オフスリーンバッファの文字列
     */
    function ob_capture($callback, ...$variadic)
    {
        ob_start();
        try {
            $callback(...$variadic);
            return ob_get_contents();
        }
        finally {
            ob_end_clean();
        }
    }
}

const is_bindable_closure = "is_bindable_closure";
if (!isset($excluded_functions["is_bindable_closure"]) && (!function_exists("is_bindable_closure") || (!false && (new \ReflectionFunction("is_bindable_closure"))->isInternal()))) {
    /**
     * $this を bind 可能なクロージャか調べる
     *
     * Example:
     * ```php
     * assertTrue(is_bindable_closure(function(){}));
     * assertFalse(is_bindable_closure(static function(){}));
     * ```
     *
     * @param \Closure $closure 調べるクロージャ
     * @return bool $this を bind 可能なクロージャなら true
     */
    function is_bindable_closure(\Closure $closure)
    {
        return !!@$closure->bindTo(new \stdClass());
    }
}

const by_builtin = "by_builtin";
if (!isset($excluded_functions["by_builtin"]) && (!function_exists("by_builtin") || (!false && (new \ReflectionFunction("by_builtin"))->isInternal()))) {
    /**
     * Countable#count, Serializable#serialize などの「ネイティブ由来かメソッド由来か」を判定して返す
     *
     * Countable#count, Serializable#serialize のように「インターフェースのメソッド名」と「ネイティブ関数名」が一致している必要がある。
     *
     * Example:
     * ```php
     * class CountClass implements \Countable
     * {
     *     public function count() {
     *         // count 経由なら 1 を、メソッド経由なら 0 を返す
     *         return (int) by_builtin($this, 'count');
     *     }
     * }
     * $counter = new CountClass();
     * assertSame(count($counter), 1);
     * assertSame($counter->count(), 0);
     * ```
     *
     * のように判定できる。
     *
     * @param object|string $class
     * @param string $function
     * @return bool ネイティブなら true
     */
    function by_builtin($class, $function)
    {
        $class = is_object($class) ? get_class($class) : $class;

        // 特殊な方法でコールされる名前達(コールスタックの大文字小文字は正規化されるので気にする必要はない)
        $invoker = [
            'call_user_func'       => true,
            'call_user_func_array' => true,
            'invoke'               => true,
            'invokeArgs'           => true,
        ];

        $traces = array_reverse(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3));
        foreach ($traces as $trace) {
            if (isset($trace['class'], $trace['function']) && $trace['class'] === $class && $trace['function'] === $function) {
                // for $object->func()
                if (isset($trace['file'], $trace['line'])) {
                    return false;
                }
                // for call_user_func([$object, 'func']), (new ReflectionMethod($object, 'func'))->invoke($object)
                elseif (isset($last) && isset($last['function']) && isset($invoker[$last['function']])) {
                    return false;
                }
                // for func($object)
                elseif (isset($last) && isset($last['function']) && $last['function'] === $function) {
                    return true;
                }
            }
            $last = $trace;
        }
        throw new \RuntimeException('failed to search backtrace.');
    }
}

const namedcallize = "namedcallize";
if (!isset($excluded_functions["namedcallize"]) && (!function_exists("namedcallize") || (!false && (new \ReflectionFunction("namedcallize"))->isInternal()))) {
    /**
     * callable を名前付き引数で呼べるようにしたクロージャを返す
     *
     * callable のデフォルト引数は適用されるが、それ以外にも $default でデフォルト値を与えることができる（部分適用のようなものだと思えば良い）。
     * 最終的な優先順位は下記。上に行くほど優先。
     *
     * 1. 呼び出し時の引数
     * 2. この関数の $default 引数
     * 3. callable のデフォルト引数
     *
     * 引数は n 番目でも引数名でもどちらでも良い。
     * n 番目の場合は引数名に依存しないが、順番に依存してしまう。
     * 引数名の場合は順番に依存しないが、引数名に依存してしまう。
     *
     * 可変引数の場合は 1 と 2 がマージされる。
     * 必須引数が渡されていない or 定義されていない引数が渡された場合は例外を投げる。
     *
     * Example:
     * ```php
     * // ベースとなる関数（引数をそのまま連想配列で返す）
     * $f = function ($x, $a = 1, $b = 2, ...$other){return get_defined_vars();};
     *
     * // x に 'X', a に 9 を与えて名前付きで呼べるクロージャ
     * $f1 = namedcallize($f, [
     *     'x' => 'X',
     *     'a' => 9,
     * ]);
     * // 引数無しで呼ぶと↑で与えた引数が使用される（b は渡されていないのでデフォルト引数の 2 が使用される）
     * assertSame($f1(), [
     *     'x'     => 'X',
     *     'a'     => 9,
     *     'b'     => 2,
     *     'other' => [],
     * ]);
     * // 引数付きで呼ぶとそれが優先される
     * assertSame($f1([
     *     'x'     => 'XXX',
     *     'a'     => 99,
     *     'b'     => 999,
     *     'other' => [1, 2, 3],
     * ]), [
     *     'x'     => 'XXX',
     *     'a'     => 99,
     *     'b'     => 999,
     *     'other' => [1, 2, 3],
     * ]);
     * // 引数名ではなく、 n 番目指定でも同じ
     * assertSame($f1([
     *     'x' => 'XXX',
     *     1   => 99,
     *     2   => 999,
     *     3   => [1, 2, 3],
     * ]), [
     *     'x'     => 'XXX',
     *     'a'     => 99,
     *     'b'     => 999,
     *     'other' => [1, 2, 3],
     * ]);
     *
     * // x に 'X', other に [1, 2, 3] を与えて名前付きで呼べるクロージャ
     * $f2 = namedcallize($f, [
     *     'x'     => 'X',
     *     'other' => [1, 2, 3],
     * ]);
     * // other は可変引数なのでマージされる
     * assertSame($f2(['other' => [4, 5, 6]]), [
     *     'x'     => 'X',
     *     'a'     => 1,
     *     'b'     => 2,
     *     'other' => [1, 2, 3, 4, 5, 6],
     * ]);
     * ```
     *
     * @param callable $callable
     * @param array $defaults デフォルト引数
     * @return \Closure 名前付き引数で呼べるようにしたクロージャ
     */
    function namedcallize($callable, $defaults = [])
    {
        // @formatter:off
        static $dummy_arg;
        $dummy_arg = $dummy_arg ?? new class{};
        $dummy_class = get_class($dummy_arg);
        // @formatter:on

        /** @var \ReflectionParameter[] $refparams */
        $refparams = reflect_callable($callable)->getParameters();

        $defargs = [];
        $argnames = [];
        $variadicname = null;
        foreach ($refparams as $n => $param) {
            $pname = $param->getName();

            $argnames[$n] = $pname;

            // 可変引数は貯めておく
            if ($param->isVariadic()) {
                $variadicname = $pname;
            }

            // ユーザ指定は最優先
            if (array_key_exists($pname, $defaults)) {
                $defargs[$pname] = $defaults[$pname];
            }
            elseif (array_key_exists($n, $defaults)) {
                $defargs[$pname] = $defaults[$n];
            }
            // デフォルト引数があるならそれを
            elseif ($param->isDefaultValueAvailable()) {
                $defargs[$pname] = $param->getDefaultValue();
            }
            // それ以外なら「指定されていない」ことを表すダミー引数を入れておく（あとでチェックに使う）
            else {
                $defargs[$pname] = $param->isVariadic() ? [] : $dummy_arg;
            }
        }

        return function ($params = []) use ($callable, $defargs, $argnames, $variadicname, $dummy_class) {
            $params = array_map_key($params, function ($k) use ($argnames) { return is_int($k) ? $argnames[$k] : $k; });
            $params = array_replace($defargs, $params);

            // 勝手に突っ込んだ $dummy_class がいるのはおかしい。指定されていないと思われる
            if ($dummyargs = array_filter($params, function ($v) use ($dummy_class) { return $v instanceof $dummy_class; })) {
                throw new \InvalidArgumentException('missing required arguments(' . implode(', ', array_keys($dummyargs)) . ').');
            }
            // diff って余りが出るのはおかしい。余計なものがあると思われる
            if ($diffargs = array_diff_key($params, $defargs)) {
                throw new \InvalidArgumentException('specified undefined arguments(' . implode(', ', array_keys($diffargs)) . ').');
            }

            // 可変引数はマージする
            if ($variadicname) {
                $params = array_merge($params, $defargs[$variadicname], $params[$variadicname]);
                unset($params[$variadicname]);
            }

            return $callable(...array_values($params));
        };
    }
}

const parameter_length = "parameter_length";
if (!isset($excluded_functions["parameter_length"]) && (!function_exists("parameter_length") || (!false && (new \ReflectionFunction("parameter_length"))->isInternal()))) {
    /**
     * callable の引数の数を返す
     *
     * クロージャはキャッシュされない。毎回リフレクションを生成し、引数の数を調べてそれを返す。
     * （クロージャには一意性がないので key-value なキャッシュが適用できない）。
     * ので、ループ内で使ったりすると目に見えてパフォーマンスが低下するので注意。
     *
     * Example:
     * ```php
     * // trim の引数は2つ
     * assertSame(parameter_length('trim'), 2);
     * // trim の必須引数は1つ
     * assertSame(parameter_length('trim', true), 1);
     * ```
     *
     * @param callable $callable 対象 callable
     * @param bool $require_only true を渡すと必須パラメータの数を返す
     * @param bool $thought_variadic 可変引数を考慮するか。 true を渡すと可変引数の場合に無限長を返す
     * @return int 引数の数
     */
    function parameter_length($callable, $require_only = false, $thought_variadic = false)
    {
        // クロージャの $call_name には一意性がないのでキャッシュできない（spl_object_hash でもいいが、かなり重複するので完全ではない）
        if ($callable instanceof \Closure) {
            /** @var \ReflectionFunctionAbstract $ref */
            $ref = reflect_callable($callable);
            if ($thought_variadic && $ref->isVariadic()) {
                return INF;
            }
            elseif ($require_only) {
                return $ref->getNumberOfRequiredParameters();
            }
            else {
                return $ref->getNumberOfParameters();
            }
        }

        // $call_name 取得
        is_callable($callable, false, $call_name);

        $cache = cache($call_name, function () use ($callable) {
            /** @var \ReflectionFunctionAbstract $ref */
            $ref = reflect_callable($callable);
            return [
                '00' => $ref->getNumberOfParameters(),
                '01' => $ref->isVariadic() ? INF : $ref->getNumberOfParameters(),
                '10' => $ref->getNumberOfRequiredParameters(),
                '11' => $ref->isVariadic() ? INF : $ref->getNumberOfRequiredParameters(),
            ];
        }, __FUNCTION__);
        return $cache[(int) $require_only . (int) $thought_variadic];
    }
}

const function_shorten = "function_shorten";
if (!isset($excluded_functions["function_shorten"]) && (!function_exists("function_shorten") || (!false && (new \ReflectionFunction("function_shorten"))->isInternal()))) {
    /**
     * 関数の名前空間部分を除いた短い名前を取得する
     *
     * @param string $function 短くする関数名
     * @return string 短い関数名
     */
    function function_shorten($function)
    {
        $parts = explode('\\', $function);
        return array_pop($parts);
    }
}

const func_user_func_array = "func_user_func_array";
if (!isset($excluded_functions["func_user_func_array"]) && (!function_exists("func_user_func_array") || (!false && (new \ReflectionFunction("func_user_func_array"))->isInternal()))) {
    /**
     * パラメータ定義数に応じて呼び出し引数を可変にしてコールする
     *
     * デフォルト引数はカウントされない。必須パラメータの数で呼び出す。
     * もちろん可変引数は未対応。
     *
     * $callback に null を与えると例外的に「第1引数を返すクロージャ」を返す。
     *
     * php の標準関数は定義数より多い引数を投げるとエラーを出すのでそれを抑制したい場合に使う。
     *
     * Example:
     * ```php
     * // strlen に2つの引数を渡してもエラーにならない
     * $strlen = func_user_func_array('strlen');
     * assertSame($strlen('abc', null), 3);
     * ```
     *
     * @param callable $callback 呼び出すクロージャ
     * @return \Closure 引数ぴったりで呼び出すクロージャ
     */
    function func_user_func_array($callback)
    {
        // null は第1引数を返す特殊仕様
        if ($callback === null) {
            return function ($v) { return $v; };
        }
        // クロージャはユーザ定義しかありえないので調べる必要がない
        if ($callback instanceof \Closure) {
            // が、組み込みをバイパスする delegate はクロージャなのでそれだけは除外
            $uses = reflect_callable($callback)->getStaticVariables();
            if (!isset($uses['__rfunc_delegate_marker'])) {
                return $callback;
            }
        }

        // 上記以外は「引数ぴったりで削ぎ落としてコールするクロージャ」を返す
        $plength = parameter_length($callback, true, true);
        return delegate(function ($callback, $args) use ($plength) {
            if (is_infinite($plength)) {
                return $callback(...$args);
            }
            return $callback(...array_slice($args, 0, $plength));
        }, $callback, $plength);
    }
}

const func_method = "func_method";
if (!isset($excluded_functions["func_method"]) && (!function_exists("func_method") || (!false && (new \ReflectionFunction("func_method"))->isInternal()))) {
    /**
     * 指定メソッドを呼び出すクロージャを返す
     *
     * この関数を呼ぶとメソッドのクロージャを返す。
     * そのクロージャにオブジェクトを与えて呼び出すとそれはメソッド呼び出しとなる。
     *
     * オプションでデフォルト引数を設定できる（Example を参照）。
     *
     * Example:
     * ```php
     * // 与えられた引数を結合して返すメソッド hoge を持つクラス
     * $object = new class()
     * {
     *     function hoge(...$args) { return implode(',', $args); }
     * };
     * // hoge を呼び出すクロージャ
     * $hoge = func_method('hoge');
     * // ↑を使用して $object の hoge を呼び出す
     * assertSame($hoge($object, 1, 2, 3), '1,2,3');
     *
     * // デフォルト値付きで hoge を呼び出すクロージャ
     * $hoge789 = func_method('hoge', 7, 8, 9);
     * // ↑を使用して $object の hoge を呼び出す（引数指定してるので結果は同じ）
     * assertSame($hoge789($object, 1, 2, 3), '1,2,3');
     * // 同上（一部デフォルト値）
     * assertSame($hoge789($object, 1, 2), '1,2,9');
     * // 同上（全部デフォルト値）
     * assertSame($hoge789($object), '7,8,9');
     * ```
     *
     * @param string $methodname メソッド名
     * @param array $defaultargs メソッドのデフォルト引数
     * @return \Closure メソッドを呼び出すクロージャ
     */
    function func_method($methodname, ...$defaultargs)
    {
        return function ($object, ...$args) use ($methodname, $defaultargs) {
            return ([$object, $methodname])(...$args + $defaultargs);
        };
    }
}

const function_alias = "function_alias";
if (!isset($excluded_functions["function_alias"]) && (!function_exists("function_alias") || (!false && (new \ReflectionFunction("function_alias"))->isInternal()))) {
    /**
     * 関数のエイリアスを作成する
     *
     * 単に移譲するだけではなく、参照渡し・参照返しも模倣される。
     * その代わり、単純なエイリアスではなく別定義で吐き出すので「エイリアス」ではなく「処理が同じな別関数」と思ったほうがよい。
     *
     * 静的であればクラスメソッドも呼べる。
     *
     * Example:
     * ```php
     * // trim のエイリアス
     * function_alias('trim', 'trim_alias');
     * assertSame(trim_alias(' abc '), 'abc');
     * ```
     *
     * @param callable $original 元となる関数
     * @param string $alias 関数のエイリアス名
     */
    function function_alias($original, $alias)
    {
        // クロージャとか __invoke とかは無理なので例外を投げる
        if (is_object($original)) {
            throw new \InvalidArgumentException('$original must not be object.');
        }
        // callname の取得と非静的のチェック
        is_callable($original, true, $calllname);
        $calllname = ltrim($calllname, '\\');
        $ref = reflect_callable($original);
        if ($ref instanceof \ReflectionMethod && !$ref->isStatic()) {
            throw new \InvalidArgumentException("$calllname is non-static method.");
        }
        // エイリアスが既に存在している
        if (function_exists($alias)) {
            throw new \InvalidArgumentException("$alias is already declared.");
        }

        // キャッシュ指定有りなら読み込むだけで eval しない
        $cachefile = cachedir() . '/' . rawurlencode(__FUNCTION__ . '-' . $calllname . '-' . $alias) . '.php';
        if (file_exists($cachefile)) {
            require $cachefile;
            return;
        }

        // 仮引数と実引数の構築
        $params = [];
        $args = [];
        foreach ($ref->getParameters() as $param) {
            $default = '';
            if ($param->isOptional()) {
                // 組み込み関数のデフォルト値を取得することは出来ない（isDefaultValueAvailable も false を返す）
                if ($param->isDefaultValueAvailable()) {
                    $defval = var_export($param->getDefaultValue(), true);
                }
                // 「オプショナルだけどデフォルト値がないって有り得るのか？」と思ったが、上記の通り組み込み関数だと普通に有り得るようだ
                // notice が出るので記述せざるを得ないがその値を得る術がない。が、どうせ与えられないので null でいい
                else {
                    $defval = 'null';
                }
                $default = ' = ' . $defval;
            }
            $varname = ($param->isPassedByReference() ? '&' : '') . '$' . $param->getName();
            $params[] = $varname . $default;
            $args[] = $varname;
        }

        $parts = explode('\\', ltrim($alias, '\\'));
        $reference = $ref->returnsReference() ? '&' : '';
        $funcname = $reference . array_pop($parts);
        $namespace = implode('\\', $parts);

        $params = implode(', ', $params);
        $args = implode(', ', $args);

        $code = <<<CODE
namespace $namespace {
    function $funcname($params) {
        \$return = $reference \\$calllname(...array_slice([$args] + func_get_args(), 0, func_num_args()));
        return \$return;
    }
}
CODE;

        eval($code);
        file_put_contents($cachefile, "<?php\n" . $code);
    }
}

const minimum = "minimum";
if (!isset($excluded_functions["minimum"]) && (!function_exists("minimum") || (!false && (new \ReflectionFunction("minimum"))->isInternal()))) {
    /**
     * 引数の最小値を返す
     *
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * assertSame(minimum(-1, 0, 1), -1);
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 最小値
     */
    function minimum(...$variadic)
    {
        $args = array_flatten($variadic) or throws(new \LengthException("argument's length is 0."));
        return min($args);
    }
}

const maximum = "maximum";
if (!isset($excluded_functions["maximum"]) && (!function_exists("maximum") || (!false && (new \ReflectionFunction("maximum"))->isInternal()))) {
    /**
     * 引数の最大値を返す
     *
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * assertSame(maximum(-1, 0, 1), 1);
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 最大値
     */
    function maximum(...$variadic)
    {
        $args = array_flatten($variadic) or throws(new \LengthException("argument's length is 0."));
        return max($args);
    }
}

const mode = "mode";
if (!isset($excluded_functions["mode"]) && (!function_exists("mode") || (!false && (new \ReflectionFunction("mode"))->isInternal()))) {
    /**
     * 引数の最頻値を返す
     *
     * - 等価比較は文字列で行う。小数時は注意。おそらく php.ini の precision に従うはず
     * - 等価値が複数ある場合の返り値は不定
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * assertSame(mode(0, 1, 2, 2, 3, 3, 3), 3);
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 最頻値
     */
    function mode(...$variadic)
    {
        $args = array_flatten($variadic) or throws(new \LengthException("argument's length is 0."));
        $vals = array_map(function ($v) {
            if (is_object($v)) {
                // ここに特別扱いのオブジェクトを列挙していく
                if ($v instanceof \DateTimeInterface) {
                    return $v->getTimestamp();
                }
                // それ以外は stringify へ移譲（__toString もここに含まれている）
                return stringify($v);
            }
            return (string) $v;
        }, $args);
        $args = array_combine($vals, $args);
        $counts = array_count_values($vals);
        arsort($counts);
        reset($counts);
        return $args[key($counts)];
    }
}

const mean = "mean";
if (!isset($excluded_functions["mean"]) && (!function_exists("mean") || (!false && (new \ReflectionFunction("mean"))->isInternal()))) {
    /**
     * 引数の相加平均値を返す
     *
     * - is_numeric でない値は除外される（計算結果に影響しない）
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * assertSame(mean(1, 2, 3, 4, 5, 6), 3.5);
     * assertSame(mean(1, '2', 3, 'noize', 4, 5, 'noize', 6), 3.5);
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return int|float 相加平均値
     */
    function mean(...$variadic)
    {
        $args = array_flatten($variadic) or throws(new \LengthException("argument's length is 0."));
        $args = array_filter($args, 'is_numeric') or throws(new \LengthException("argument's must be contain munber."));
        return array_sum($args) / count($args);
    }
}

const median = "median";
if (!isset($excluded_functions["median"]) && (!function_exists("median") || (!false && (new \ReflectionFunction("median"))->isInternal()))) {
    /**
     * 引数の中央値を返す
     *
     * - 要素数が奇数の場合は完全な中央値/偶数の場合は中2つの平均。「平均」という概念が存在しない値なら中2つの後の値
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * // 偶数個なので中2つの平均
     * assertSame(median(1, 2, 3, 4, 5, 6), 3.5);
     * // 奇数個なのでど真ん中
     * assertSame(median(1, 2, 3, 4, 5), 3);
     * // 偶数個だが文字列なので中2つの後
     * assertSame(median('a', 'b', 'c', 'd'), 'c');
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 中央値
     */
    function median(...$variadic)
    {
        $args = array_flatten($variadic) or throws(new \LengthException("argument's length is 0."));
        $count = count($args);
        $center = (int) ($count / 2);
        sort($args);
        // 偶数で共に数値なら平均値
        if ($count % 2 === 0 && (is_numeric($args[$center - 1]) && is_numeric($args[$center]))) {
            return ($args[$center - 1] + $args[$center]) / 2;
        }
        // 奇数なら単純に中央値
        else {
            return $args[$center];
        }
    }
}

const average = "average";
if (!isset($excluded_functions["average"]) && (!function_exists("average") || (!false && (new \ReflectionFunction("average"))->isInternal()))) {
    /**
     * 引数の意味平均値を返す
     *
     * - 3座標の重心座標とか日付の平均とかそういうもの
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 意味平均値
     */
    function average(...$variadic)
    {
        // 用意したはいいが統一的なうまい実装が思いつかない（関数ベースじゃ無理だと思う）
        // average は意味平均、mean は相加平均を明示するために定義は残しておく
        assert(is_array($variadic));
        throw new \DomainException('not implement yet.');
    }
}

const sum = "sum";
if (!isset($excluded_functions["sum"]) && (!function_exists("sum") || (!false && (new \ReflectionFunction("sum"))->isInternal()))) {
    /**
     * 引数の合計値を返す
     *
     * - is_numeric でない値は除外される（計算結果に影響しない）
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * assertSame(sum(1, 2, 3, 4, 5, 6), 21);
     * ```
     *
     * @param mixed $variadic 対象の変数・配列・リスト
     * @return mixed 合計値
     */
    function sum(...$variadic)
    {
        $args = array_flatten($variadic) or throws(new \LengthException("argument's length is 0."));
        $args = array_filter($args, 'is_numeric') or throws(new \LengthException("argument's must be contain munber."));
        return array_sum($args);
    }
}

const random_at = "random_at";
if (!isset($excluded_functions["random_at"]) && (!function_exists("random_at") || (!false && (new \ReflectionFunction("random_at"))->isInternal()))) {
    /**
     * 引数をランダムで返す
     *
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * // 1 ～ 6 のどれかを返す
     * assertContains(random_at(1, 2, 3, 4, 5, 6), [1, 2, 3, 4, 5, 6]);
     * ```
     *
     * @param array $args 候補
     * @return mixed 引数のうちどれか
     */
    function random_at(...$args)
    {
        return $args[mt_rand(0, count($args) - 1)];
    }
}

const probability = "probability";
if (!isset($excluded_functions["probability"]) && (!function_exists("probability") || (!false && (new \ReflectionFunction("probability"))->isInternal()))) {
    /**
     * 一定確率で true を返す
     *
     * 具体的には $probability / $divisor の確率で true を返す。
     * $divisor のデフォルトは 100 にしてあるので、 $probability だけ与えれば $probability パーセントで true を返すことになる。
     *
     * Example:
     * ```php
     * // 50% の確率で "hello" を出す
     * if (probability(50)) {
     *     echo "hello";
     * }
     * ```
     *
     * @param int $probability 分子
     * @param int $divisor 分母
     * @return bool true or false
     */
    function probability($probability, $divisor = 100)
    {
        $probability = (int) $probability;
        if ($probability < 0) {
            throw new \InvalidArgumentException('$probability must be positive number.');
        }
        $divisor = (int) $divisor;
        if ($divisor < 0) {
            throw new \InvalidArgumentException('$divisor must be positive number.');
        }
        // 不等号の向きや=の有無が怪しかったのでメモ
        // 1. $divisor に 100 が与えられたとすると、取り得る範囲は 0 ～ 99（100個）
        // 2. $probability が 1 だとするとこの式を満たす数は 0 の1個のみ
        // 3. 100 個中1個なので 1%
        return $probability > mt_rand(0, $divisor - 1);
    }
}

const getipaddress = "getipaddress";
if (!isset($excluded_functions["getipaddress"]) && (!function_exists("getipaddress") || (!false && (new \ReflectionFunction("getipaddress"))->isInternal()))) {
    /**
     * 接続元となる IP を返す
     *
     * 要するに自分の IP を返す。
     *
     * Example:
     * ```php
     * // 何らかの IP アドレスが返ってくる
     * assertRegExp('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#', getipaddress());
     * // 自分への接続元は自分なので 127.0.0.1 を返す
     * assertSame(getipaddress('127.0.0.9'), '127.0.0.1');
     * ```
     *
     * @param string $target 接続先。基本的に指定することはない
     * @return string IP アドレス
     */
    function getipaddress($target = '128.0.0.0')
    {
        $socket = stream_socket_client("udp://$target:7", $errno, $errstr);
        if ($socket === false) {
            throw new \InvalidArgumentException($errstr, $errno);
        }
        $sname = stream_socket_get_name($socket, false);
        $ipaddr = parse_url($sname, PHP_URL_HOST);

        fclose($socket);

        return $ipaddr;
    }
}

const incidr = "incidr";
if (!isset($excluded_functions["incidr"]) && (!function_exists("incidr") || (!false && (new \ReflectionFunction("incidr"))->isInternal()))) {
    /**
     * ipv4 の cidr チェック
     *
     * $ipaddr が $cidr のレンジ内なら true を返す。
     * $cidr は複数与えることができ、どれかに合致したら true を返す。
     *
     * ipv6 は今のところ未対応。
     *
     * Example:
     * ```php
     * // 範囲内なので true
     * assertTrue(incidr('192.168.1.1', '192.168.1.0/24'));
     * // 範囲外なので false
     * assertFalse(incidr('192.168.1.1', '192.168.2.0/24'));
     * // 1つでも範囲内なら true
     * assertTrue(incidr('192.168.1.1', ['192.168.1.0/24', '192.168.2.0/24']));
     * // 全部範囲外なら false
     * assertFalse(incidr('192.168.1.1', ['192.168.2.0/24', '192.168.3.0/24']));
     * ```
     *
     * @param string $ipaddr 調べられる IP アドレス
     * @param string|array $cidr 調べる cidr アドレス
     * @return bool $ipaddr が $cidr 内なら true
     */
    function incidr($ipaddr, $cidr)
    {
        if (!filter_var($ipaddr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            throw new \InvalidArgumentException("ipaddr '$ipaddr' is invalid.");
        }
        $iplong = ip2long($ipaddr);

        foreach (arrayize($cidr) as $cidr) {
            list($subnet, $length) = explode('/', $cidr, 2) + [1 => '32'];

            if (!filter_var($subnet, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                throw new \InvalidArgumentException("subnet addr '$subnet' is invalid.");
            }
            if (!(ctype_digit($length) && (0 <= $length && $length <= 32))) {
                throw new \InvalidArgumentException("subnet mask '$length' is invalid.");
            }

            if (substr_compare(sprintf('%032b', $iplong), sprintf('%032b', ip2long($subnet)), 0, $length) === 0) {
                return true;
            }
        }
        return false;
    }
}

const http_requests = "http_requests";
if (!isset($excluded_functions["http_requests"]) && (!function_exists("http_requests") || (!false && (new \ReflectionFunction("http_requests"))->isInternal()))) {
    /**
     * http リクエストを並列で投げる
     *
     * $urls で複数の curl を渡し、並列で実行して複数の結果をまとめて返す。
     * $urls の要素は単一の文字列か curl のオプションである必要がある。
     *
     * 返り値は $urls のキーを保持したまま、レスポンスが返ってきた順に格納して配列で返す。
     * 構造は下記のサンプルを参照。
     *
     * Example:
     * ```php
     * $responses = http_requests([
     *     // このように [キー => CURL オプション] 形式が正しい使い方
     *     'fuga' => [
     *         CURLOPT_URL     => 'http://unknown-host',
     *         CURLOPT_TIMEOUT => 5,
     *     ],
     *     // ただし、このように [キー => URL] 形式でもいい（オプションはデフォルトが使用される）
     *     'hoge' => 'http://127.0.0.1',
     * ]);
     * [
     *     // キーが維持されるので hoge キー
     *     'hoge' => [
     *         // 0 番目の要素は body 文字列
     *         'response body',
     *         // 1 番目の要素は header 配列
     *         [
     *             // ・・・・・
     *             'Content-Type' => 'text/plain',
     *             // ・・・・・
     *         ],
     *         // 2 番目の要素は curl のメタ配列
     *         [
     *             // ・・・・・
     *         ],
     *     ],
     *     // curl のエラーが出た場合は int になる（CURLE_*** の値）
     *     'fuga' => 6,
     * ];
     * ```
     *
     * @param array $urls 実行する curl オプション
     * @param array $default_options 全 $urls に適用されるデフォルトオプション
     * @return array レスポンス配列。取得した順番でキーを保持しつつ追加される
     */
    function http_requests($urls, $default_options = [])
    {
        // 固定オプション（必ずこの値が使用される）
        $default1 = [
            CURLOPT_RETURNTRANSFER => true, // 戻り値として返す
            CURLOPT_HEADER         => true, // ヘッダを含める
            CURLOPT_SAFE_UPLOAD    => true, // @付きフィールドをファイルと見なさない
        ];

        // 可変オプション（指定がない場合のみ使用される）
        $default_options += [
            CURLOPT_FOLLOWLOCATION => true, // リダイレクトをたどる
            CURLOPT_MAXREDIRS      => 16,   // リダイレクトをたどる回数
        ];

        $resultmap = [];
        $mh = curl_multi_init();
        foreach ($urls as $key => $opt) {
            // 文字列は URL 指定とみなす
            if (is_string($opt)) {
                $opt = [
                    CURLOPT_URL => $opt,
                ];
            }

            $ch = curl_init();
            curl_setopt_array($ch, $default1 + $opt + $default_options);
            curl_multi_add_handle($mh, $ch);

            // スクリプトの実行中 (ウェブのリクエストや CLI プロセスの処理中) は、指定したリソースに対してこの文字列が一意に割り当てられることが保証されます
            $resultmap["$ch"] = $key;
        }

        $responses = [];
        do {
            do {
                $mrc = curl_multi_exec($mh, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);

            // see http://php.net/manual/ja/function.curl-multi-select.php#115381
            if (curl_multi_select($mh) == -1) {
                usleep(1); // @codeCoverageIgnore
            }

            do {
                if (($minfo = curl_multi_info_read($mh, $remains)) === false) {
                    continue;
                }

                $handle = $minfo['handle'];

                if ($minfo['result'] !== CURLE_OK) {
                    $responses[$resultmap["$handle"]] = $minfo['result'];
                }
                else {
                    $info = curl_getinfo($handle);
                    $response = curl_multi_getcontent($handle);
                    $headers = str_array(substr($response, 0, $info['header_size']), ':', true);
                    $body = substr($response, $info['header_size']);
                    $responses[$resultmap["$handle"]] = [$body, $headers, $info];
                }

                curl_multi_remove_handle($mh, $handle);
                curl_close($handle);
            } while ($remains);
        } while ($active && $mrc == CURLM_OK);

        curl_multi_close($mh);

        return $responses;
    }
}

const sql_quote = "sql_quote";
if (!isset($excluded_functions["sql_quote"]) && (!function_exists("sql_quote") || (!false && (new \ReflectionFunction("sql_quote"))->isInternal()))) {
    /**
     * ものすごく雑に値をクオートする
     *
     * 非常に荒くアドホックに実装しているのでこの関数で得られた値で**実際に実行してはならない**。
     * あくまでログ出力やデバッグ用途で視認性を高める目的である。
     *
     * - null は NULL になる
     * - 数字はそのまま数字になる
     * - bool は 0 or 1 になる
     * - それ以外は addslashes される
     *
     * Example:
     * ```php
     * assertSame(sql_quote(null), 'NULL');
     * assertSame(sql_quote(123), 123);
     * assertSame(sql_quote(true), 1);
     * assertSame(sql_quote("hoge"), "'hoge'");
     * ```
     *
     * @param mixed $value クオートする値
     * @return mixed クオートされた値
     */
    function sql_quote($value)
    {
        if ($value === null) {
            return 'NULL';
        }
        if (is_numeric($value)) {
            return $value;
        }
        if (is_bool($value)) {
            return (int) $value;
        }
        return "'" . addslashes("$value") . "'";
    }
}

const sql_bind = "sql_bind";
if (!isset($excluded_functions["sql_bind"]) && (!function_exists("sql_bind") || (!false && (new \ReflectionFunction("sql_bind"))->isInternal()))) {
    /**
     * ものすごく雑に SQL に値を埋め込む
     *
     * 非常に荒くアドホックに実装しているのでこの関数で得られた SQL を**実際に実行してはならない**。
     * あくまでログ出力やデバッグ用途で視認性を高める目的である。
     *
     * プレースホルダは ? か :alnum で混在していても良い。
     *
     * Example:
     * ```php
     * assertSame(sql_bind('select ?', 1), "select 1");
     * assertSame(sql_bind('select :hoge', ['hoge' => 'hoge']), "select 'hoge'");
     * assertSame(sql_bind('select ?, :hoge', [1, 'hoge' => 'hoge']), "select 1, 'hoge'");
     * ```
     *
     * @param string $sql 値を埋め込む SQL
     * @param array|mixed $values 埋め込む値
     * @return mixed 値が埋め込まれた SQL
     */
    function sql_bind($sql, $values)
    {
        $values = arrayize($values);
        $n = 0;
        return preg_replace_callback('#(\?)|(:([a-z_][a-z_0-9]*))#ui', function ($m) use ($values, &$n) {
            $name = $m[1] === '?' ? $n++ : $m[3];
            if (!array_key_exists($name, $values)) {
                return $m[0];
            }
            return sql_quote($values[$name]);
        }, $sql);
    }
}

const sql_format = "sql_format";
if (!isset($excluded_functions["sql_format"]) && (!function_exists("sql_format") || (!false && (new \ReflectionFunction("sql_format"))->isInternal()))) {
    /**
     * ものすごく雑に SQL を整形する
     *
     * 非常に荒くアドホックに実装しているのでこの関数で得られた SQL を**実際に実行してはならない**。
     * あくまでログ出力やデバッグ用途で視認性を高める目的である。
     *
     * JOIN 句は FROM 句とみなさず、別句として処理する。
     * AND と && は微妙に処理が異なる。 AND は改行されるが && は改行されない（OR と || も同様）。
     *
     * @param string $sql 整形する SQL
     * @param array $options 整形オプション
     * @return string 整形された SQL
     */
    function sql_format($sql, $options = [])
    {
        static $keywords;
        $keywords = $keywords ?? array_flip(KEYWORDS);

        $options += [
            // インデント文字
            'indent'    => "  ",
            // 括弧の展開レベル
            'nestlevel' => 1,
            // キーワードの大文字/小文字可変換（true だと大文字化。false だと小文字化。あるいは 'strtoupper' 等の文字列関数を直接指定する。クロージャでも良い）
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
                    'KEYWORD' => function ($token) { return "\e[1m" . $token . "\e[m"; },
                    'COMMENT' => function ($token) { return "\e[33m" . $token . "\e[m"; },
                    'STRING'  => function ($token) { return "\e[31m" . $token . "\e[m"; },
                    'NUMBER'  => function ($token) { return "\e[36m" . $token . "\e[m"; },
                ],
                'html' => [
                    'KEYWORD' => function ($token) { return "<span style='font-weight:bold;'>" . htmlspecialchars($token) . "</span>"; },
                    'COMMENT' => function ($token) { return "<span style='color:#FF8000;'>" . htmlspecialchars($token) . "</span>"; },
                    'STRING'  => function ($token) { return "<span style='color:#DD0000;'>" . htmlspecialchars($token) . "</span>"; },
                    'NUMBER'  => function ($token) { return "<span style='color:#0000BB;'>" . htmlspecialchars($token) . "</span>"; },
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
            if ($options['case'] && isset($keywords[strtoupper($token)])) {
                $token = $options['case']($token);
            }
            if ($options['highlight']) {
                $token = $options['highlight']($token, $ttype);
            }
            return $token;
        };

        // 構文解析も先読みもない素朴な実装なので、特定文字列をあとから置換するための目印文字列
        $MARK = "{:RM";
        while (strpos($sql, $MARK) !== false) {
            $MARK .= rand(1000, 9999);
        }
        $MARK_R = "{$MARK}_R:}";   // \r マーク
        $MARK_N = "{$MARK}_N:}";   // \n マーク
        $MARK_BR = "{$MARK}_BR:}"; // 改行マーク
        $MARK_NT = "{$MARK}_NT:}"; // インデントマーク
        $MARK_SP = "{$MARK}_SP:}"; // スペースマーク
        $MARK_PT = "{$MARK}_PT:}"; // 括弧ネストマーク

        // 字句にバラす（シンタックスが php に似ているので token_get_all で大幅にサボることができる）
        $tokens = [];
        $comment = '';
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
            elseif ($token[0] === T_DEC) {
                $comment = $token[1];
            }
            // 改行は '--' コメントの終わり
            elseif ($comment && $token[0] === T_WHITESPACE && strpos($token[1], "\n") !== false) {
                $tokens[] = [T_COMMENT, $comment];
                $comment = '';
            }
            // コメント中はコメントに格納する
            elseif ($comment) {
                $comment .= $token[1];
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
        }

        // コメント以外の前後のトークンを返すクロージャ
        $seek = function ($start, $step) use ($tokens) {
            for ($n = 1; ; $n++) {
                $token = $tokens[$start + $n * $step] ?? [null, null];
                if ($token[0] !== T_COMMENT && $token[0] !== T_DOC_COMMENT) {
                    return $token[1];
                }
            }
        };

        $interpret = function (&$index = -1) use (&$interpret, $MARK_R, $MARK_N, $MARK_BR, $MARK_NT, $MARK_SP, $MARK_PT, $tokens, $options, $seek) {
            $index++;
            $context = '';    // SELECT, INSERT などの大分類
            $subcontext = ''; // SET, VALUES などのサブ分類
            $modifier = '';   // RIGHT などのキーワード修飾語

            $result = [];
            for ($token_length = count($tokens); $index < $token_length; $index++) {
                $ttype = $tokens[$index][0];
                $token = trim($tokens[$index][1]);

                $virttoken = $options['syntaxer']($token, $ttype);
                $uppertoken = strtoupper($token);

                // 最終的なインデントは「改行＋スペース」で行うのでリテラル内に改行があるとそれもインデントされてしまうので置換して逃がす
                $token = strtr($token, [
                    "\r" => $MARK_R,
                    "\n" => $MARK_N,
                ]);

                // コメントは特別扱いでただ付け足すだけ
                if ($ttype === T_COMMENT || $ttype === T_DOC_COMMENT) {
                    $result[] = $MARK_SP . $virttoken . $MARK_BR;
                    continue;
                }

                switch ($uppertoken) {
                    default:
                        _DEFAULT:
                        $prev = $seek($index, -1);
                        $next = $seek($index, +1);

                        // "tablename. columnname" になってしまう
                        if ($prev !== '.') {
                            $result[] = $MARK_SP;
                        }

                        $result[] = $virttoken;

                        // "tablename .columnname" になってしまう
                        // "columnname ," になってしまう
                        // mysql において関数呼び出し括弧の前に空白は許されない
                        // ただし、関数呼び出しではなく記号の場合はスペースを入れたい（ colname = (SELECT ～) など）
                        if (($next !== '.' && $next !== ',' && $next !== '(') || ($next === '(' && !preg_match('#^[a-z0-9_"\'`]+$#i', $token))) {
                            $result[] = $MARK_SP;
                        }
                        break;
                    case ";":
                        $result[] = $MARK_BR . $virttoken . $MARK_BR;
                        break;
                    case ".":
                        $result[] = $virttoken;
                        break;
                    case ",":
                        $result[] = $virttoken . $MARK_BR;
                        break;
                    case "WITH":
                        $result[] = $MARK_BR . $virttoken . $MARK_SP;
                        $subcontext = $uppertoken;
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
                        $name = $seek($index++, +1);
                        $result[] = $MARK_SP . $virttoken . $MARK_SP . $name . $MARK_SP;
                        if ($context !== 'CREATE' && $context !== 'DROP') {
                            $result[] = $MARK_BR;
                        }
                        break;
                    /** @noinspection PhpMissingBreakStatementInspection */
                    case "AND":
                        // BETWEEN A AND B と論理演算子の AND が競合するので分岐後にフォールスルー
                        if ($subcontext === 'BETWEEN') {
                            $result[] = $MARK_SP . $virttoken . $MARK_SP;
                            $subcontext = '';
                            break;
                        }
                    case "OR":
                    case "XOR":
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
                        $result[] = $MARK_SP . $virttoken . array_pop($result);
                        break;
                    case "SELECT":
                        if ($context === 'INSERT') {
                            $result[] = $MARK_BR;
                        }
                        $result[] = $virttoken . $MARK_BR;
                        $context = $uppertoken;
                        break;
                    case "LEFT":
                        /** @noinspection PhpMissingBreakStatementInspection */
                    case "RIGHT":
                        // 例えば LEFT や RIGHT は関数呼び出しの場合もあるので分岐後にフォールスルー
                        if ($seek($index, +1) === '(') {
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
                        $name = $seek($index, +1);
                        if (in_array(strtoupper($name), ['DUPLICATE', 'CONFLICT'], true)) {
                            $result[] = $MARK_BR;
                            $subcontext = '';
                        }
                        else {
                            $result[] = $MARK_SP;
                        }
                        $result[] = $virttoken . $MARK_SP;
                        break;
                    case "SET":
                        $result[] = $MARK_BR . $virttoken . $MARK_BR;
                        $subcontext = $uppertoken;
                        break;
                    case "INSERT":
                    case "REPLACE":
                        $result[] = $virttoken . $MARK_SP;
                        $context = "INSERT"; // 構文的には INSERT と同じ
                        break;
                    case "INTO":
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
                        $result[] = $MARK_SP . $virttoken;
                        if ($subcontext !== 'REFERENCES') {
                            $result[] = $MARK_BR;
                            $context = $uppertoken;
                        }
                        break;
                    case "WHEN":
                    case "ELSE":
                        $result[] = $MARK_BR . $MARK_NT . $virttoken . $MARK_SP;
                        break;
                    case "CASE":
                        $parts = $interpret($index);
                        $parts = str_replace($MARK_BR, $MARK_BR . $MARK_NT, $parts);
                        $result[] = $MARK_NT . $virttoken . $MARK_SP . $parts;
                        break;
                    case "END":
                        $result[] = $MARK_BR . $virttoken;
                        break 2;
                    case "(":
                        $current = $index;
                        $parts = $MARK_BR . $interpret($index);

                        // 指定ネストレベル以下なら改行とインデントを吹き飛ばす
                        if (substr_count($parts, $MARK_PT) < $options['nestlevel']) {
                            $parts = strtr($parts, [
                                $MARK_BR => "",
                                $MARK_NT => "",
                            ]);
                            $parts = preg_replace("#^($MARK_SP)|($MARK_SP)+$#u", '', $parts);
                        }
                        elseif ($context === 'CREATE') {
                            $parts = $parts . $MARK_BR;
                        }
                        else {
                            $brnt = $MARK_BR . $MARK_NT;
                            if ($subcontext !== 'WITH' && strtoupper($seek($current, +1)) === 'SELECT') {
                                $brnt .= $MARK_NT;
                            }
                            $parts = str_replace($MARK_BR, $brnt, $parts) . $MARK_BR . $MARK_NT;
                        }

                        // IN はネストとみなさない
                        $suffix = $MARK_PT;
                        if (strtoupper($seek($current, -1)) === 'IN') {
                            $suffix = '';
                        }
                        if ($subcontext === 'WITH') {
                            $suffix .= $MARK_BR;
                        }

                        $result[] = $MARK_NT . "($parts)" . $suffix;
                        break;
                    case ")":
                        break 2;
                }
            }
            return implode('', $result);
        };

        $result = $interpret();
        $result = preg_replaces("#" . implode('|', [
                // 改行文字＋インデント文字をインデントとみなす（改行＋連続スペースもついでに）
                "(?<indent>$MARK_BR(($MARK_NT|$MARK_SP)+))",
                // 連続改行は1つに集約
                "(?<br>$MARK_BR(($MARK_NT|$MARK_SP)*)($MARK_BR)*)",
                // 連続スペースは1つに集約
                "(?<sp>($MARK_SP)+)",
                // 下記はマーカ文字が現れないように単純置換
                "(?<nt>$MARK_NT)",
                "(?<pt>$MARK_PT)",
                "(?<R>$MARK_R)",
                "(?<N>$MARK_N)",
            ]) . "#u", [
            'indent' => function ($str) use ($options, $MARK_NT, $MARK_SP) {
                return "\n" . str_repeat($options['indent'], (substr_count($str, $MARK_NT) + substr_count($str, $MARK_SP)));
            },
            'br'     => "\n",
            'sp'     => ' ',
            'nt'     => "",
            'pt'     => "",
            'R'      => "\r",
            'N'      => "\n",
        ], $result);

        return trim($result);
    }
}

const strcat = "strcat";
if (!isset($excluded_functions["strcat"]) && (!function_exists("strcat") || (!false && (new \ReflectionFunction("strcat"))->isInternal()))) {
    /**
     * 文字列結合の関数版
     *
     * Example:
     * ```php
     * assertSame(strcat('a', 'b', 'c'), 'abc');
     * ```
     *
     * @param mixed $variadic 結合する文字列（可変引数）
     * @return string 結合した文字列
     */
    function strcat(...$variadic)
    {
        return implode('', $variadic);
    }
}

const concat = "concat";
if (!isset($excluded_functions["concat"]) && (!function_exists("concat") || (!false && (new \ReflectionFunction("concat"))->isInternal()))) {
    /**
     * strcat の空文字回避版
     *
     * 基本は strcat と同じ。ただし、**引数の内1つでも空文字を含むなら空文字を返す**。
     *
     * 「プレフィックスやサフィックスを付けたいんだけど、空文字の場合はそのままで居て欲しい」という状況はまれによくあるはず。
     * コードで言えば `strlen($string) ? 'prefix-' . $string : '';` のようなもの。
     * 可変引数なので 端的に言えば mysql の CONCAT みたいな動作になる（あっちは NULL だが）。
     *
     * ```php
     * assertSame(concat('prefix-', 'middle', '-suffix'), 'prefix-middle-suffix');
     * assertSame(concat('prefix-', '', '-suffix'), '');
     * ```
     *
     * @param mixed $variadic 結合する文字列（可変引数）
     * @return string 結合した文字列
     */
    function concat(...$variadic)
    {
        $result = '';
        foreach ($variadic as $s) {
            if (strlen($s) === 0) {
                return '';
            }
            $result .= $s;
        }
        return $result;
    }
}

const split_noempty = "split_noempty";
if (!isset($excluded_functions["split_noempty"]) && (!function_exists("split_noempty") || (!false && (new \ReflectionFunction("split_noempty"))->isInternal()))) {
    /**
     * 空文字を除外する文字列分割
     *
     * - 空文字を任意の区切り文字で分割しても常に空配列
     * - キーは連番で返す（歯抜けがないただの配列）
     *
     * $triming を指定した場合、結果配列にも影響する。
     * つまり「除外は trim したいが結果配列にはしたくない」はできない。
     *
     * Example:
     * ```php
     * assertSame(split_noempty(',', 'a, b, c'), ['a', 'b', 'c']);
     * assertSame(split_noempty(',', 'a, , , b, c'), ['a', 'b', 'c']);
     * assertSame(split_noempty(',', 'a, , , b, c', false), ['a', ' ', ' ', ' b', ' c']);
     * ```
     *
     * @param string $delimiter 区切り文字
     * @param string $string 対象文字
     * @param string|bool $trimchars 指定した文字を trim する。true を指定すると trim する
     * @return array 指定文字で分割して空文字を除いた配列
     */
    function split_noempty($delimiter, $string, $trimchars = true)
    {
        // trim しないなら preg_split(PREG_SPLIT_NO_EMPTY) で十分
        if (strlen($trimchars) === 0) {
            return preg_split('#' . preg_quote($delimiter, '#') . '#u', $string, -1, PREG_SPLIT_NO_EMPTY);
        }

        // trim するなら preg_split だと無駄にややこしくなるのでベタにやる
        $trim = ($trimchars === true) ? 'trim' : rbind('trim', $trimchars);
        $parts = explode($delimiter, $string);
        $parts = array_map($trim, $parts);
        $parts = array_filter($parts, 'strlen');
        $parts = array_values($parts);
        return $parts;
    }
}

const multiexplode = "multiexplode";
if (!isset($excluded_functions["multiexplode"]) && (!function_exists("multiexplode") || (!false && (new \ReflectionFunction("multiexplode"))->isInternal()))) {
    /**
     * explode の配列対応と $limit の挙動を変えたもの
     *
     * $delimiter には配列が使える。いわゆる「複数文字列での分割」の動作になる。
     *
     * $limit に負数を与えると「その絶対値-1までを結合したものと残り」を返す。
     * 端的に言えば「正数を与えると後詰めでその個数で返す」「負数を与えると前詰めでその（絶対値）個数で返す」という動作になる。
     *
     * Example:
     * ```php
     * // 配列を与えると複数文字列での分割
     * assertSame(multiexplode([',', ' ', '|'], 'a,b c|d'), ['a', 'b', 'c', 'd']);
     * // 負数を与えると前詰め
     * assertSame(multiexplode(',', 'a,b,c,d', -2), ['a,b,c', 'd']);
     * // もちろん上記2つは共存できる
     * assertSame(multiexplode([',', ' ', '|'], 'a,b c|d', -2), ['a,b c', 'd']);
     * ```
     *
     * @param string|array $delimiter 分割文字列。配列可
     * @param string $string 対象文字列
     * @param int $limit 分割数
     * @return array 分割された配列
     */
    function multiexplode($delimiter, $string, $limit = \PHP_INT_MAX)
    {
        $limit = (int) $limit;
        if ($limit < 0) {
            // 下手に php で小細工するよりこうやって富豪的にやるのが一番速かった
            return array_reverse(array_map('strrev', multiexplode($delimiter, strrev($string), -$limit)));
        }
        // explode において 0 は 1 と等しい
        if ($limit === 0) {
            $limit = 1;
        }
        $delimiter = array_map(function ($v) { return preg_quote($v, '#'); }, arrayize($delimiter));
        return preg_split('#' . implode('|', $delimiter) . '#', $string, $limit);
    }
}

const quoteexplode = "quoteexplode";
if (!isset($excluded_functions["quoteexplode"]) && (!function_exists("quoteexplode") || (!false && (new \ReflectionFunction("quoteexplode"))->isInternal()))) {
    /**
     * エスケープやクオートに対応した explode
     *
     * $enclosures は配列で開始・終了文字が別々に指定できるが、実装上の都合で今のところ1文字ずつのみ。
     *
     * Example:
     * ```php
     * // シンプルな例
     * assertSame(quoteexplode(',', 'a,b,c\\,d,"e,f"'), [
     *     'a', // 普通に分割される
     *     'b', // 普通に分割される
     *     'c\\,d', // \\ でエスケープしているので区切り文字とみなされない
     *     '"e,f"', // "" でクオートされているので区切り文字とみなされない
     * ]);
     *
     * // $enclosures で囲い文字の開始・終了文字を明示できる
     * assertSame(quoteexplode(',', 'a,b,{e,f}', ['{' => '}']), [
     *     'a', // 普通に分割される
     *     'b', // 普通に分割される
     *     '{e,f}', // { } で囲まれているので区切り文字とみなされない
     * ]);
     * ```
     *
     * @param string|array $delimiter 分割文字列
     * @param string $string 対象文字列
     * @param array|string $enclosures 囲い文字。 ["start" => "end"] で開始・終了が指定できる
     * @param string $escape エスケープ文字
     * @return array 分割された配列
     */
    function quoteexplode($delimiter, $string, $enclosures = "'\"", $escape = '\\')
    {
        if (is_string($enclosures)) {
            $chars = str_split($enclosures);
            $enclosures = array_combine($chars, $chars);
        }

        $delimiters = arrayize($delimiter);
        $starts = implode('', array_keys($enclosures));
        $ends = implode('', $enclosures);
        $enclosing = [];
        $current = 0;
        $result = [];
        for ($i = 0, $l = strlen($string); $i < $l; $i++) {
            if ($i !== 0 && $string[$i - 1] === $escape) {
                continue;
            }
            if (strpos($ends, $string[$i]) !== false) {
                if ($enclosing && $enclosures[$enclosing[count($enclosing) - 1]] === $string[$i]) {
                    array_pop($enclosing);
                    continue;
                }
            }
            if (strpos($starts, $string[$i]) !== false) {
                $enclosing[] = $string[$i];
                continue;
            }
            if (empty($enclosing)) {
                foreach ($delimiters as $delimiter) {
                    $delimiterlen = strlen($delimiter);
                    if (substr_compare($string, $delimiter, $i, $delimiterlen) === 0) {
                        $result[] = substr($string, $current, $i - $current);
                        $current = $i + $delimiterlen;
                        break;
                    }
                }
            }
        }
        $result[] = substr($string, $current, $i);
        return $result;
    }
}

const str_equals = "str_equals";
if (!isset($excluded_functions["str_equals"]) && (!function_exists("str_equals") || (!false && (new \ReflectionFunction("str_equals"))->isInternal()))) {
    /**
     * 文字列比較の関数版
     *
     * 文字列以外が与えられた場合は常に false を返す。ただし __toString を実装したオブジェクトは別。
     *
     * Example:
     * ```php
     * assertTrue(str_equals('abc', 'abc'));
     * assertTrue(str_equals('abc', 'ABC', true));
     * assertTrue(str_equals('\0abc', '\0abc'));
     * ```
     *
     * @param string $str1 文字列1
     * @param string $str2 文字列2
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return bool 同じ文字列なら true
     */
    function str_equals($str1, $str2, $case_insensitivity = false)
    {
        // __toString 実装のオブジェクトは文字列化する（strcmp がそうなっているから）
        if (is_object($str1) && method_exists($str1, '__toString')) {
            $str1 = (string) $str1;
        }
        if (is_object($str2) && method_exists($str2, '__toString')) {
            $str2 = (string) $str2;
        }

        // この関数は === の関数版という位置づけなので例外は投げないで不一致とみなす
        if (!is_string($str1) || !is_string($str2)) {
            return false;
        }

        if ($case_insensitivity) {
            return strcasecmp($str1, $str2) === 0;
        }

        return $str1 === $str2;
    }
}

const str_contains = "str_contains";
if (!isset($excluded_functions["str_contains"]) && (!function_exists("str_contains") || (!false && (new \ReflectionFunction("str_contains"))->isInternal()))) {
    /**
     * 指定文字列を含むか返す
     *
     * Example:
     * ```php
     * assertTrue(str_contains('abc', 'b'));
     * assertTrue(str_contains('abc', 'B', true));
     * assertTrue(str_contains('abc', ['b', 'x'], false, false));
     * assertFalse(str_contains('abc', ['b', 'x'], false, true));
     * ```
     *
     * @param string $haystack 対象文字列
     * @param string|array $needle 調べる文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @param bool $and_flag すべて含む場合に true を返すか
     * @return bool $needle を含むなら true
     */
    function str_contains($haystack, $needle, $case_insensitivity = false, $and_flag = false)
    {
        if (!is_array($needle)) {
            $needle = [$needle];
        }

        // あくまで文字列としての判定に徹する（strpos の第2引数は闇が深い気がする）
        $haystack = (string) $haystack;
        $needle = array_map('strval', $needle);

        foreach ($needle as $str) {
            if ($str === '') {
                continue;
            }
            $pos = $case_insensitivity ? stripos($haystack, $str) : strpos($haystack, $str);
            if ($and_flag && $pos === false) {
                return false;
            }
            if (!$and_flag && $pos !== false) {
                return true;
            }
        }
        return !!$and_flag;
    }
}

const str_chop = "str_chop";
if (!isset($excluded_functions["str_chop"]) && (!function_exists("str_chop") || (!false && (new \ReflectionFunction("str_chop"))->isInternal()))) {
    /**
     * 先頭・末尾の指定文字列を削ぎ落とす
     *
     * Example:
     * ```php
     * // 文字列からパス文字列と拡張子を削ぎ落とす
     * $PATH = '/path/to/something';
     * assertSame(str_chop("$PATH/hoge.php", "$PATH/", '.php'), 'hoge');
     * ```
     *
     * @param string $string 対象文字列
     * @param string $prefix 削ぎ落とす先頭文字列
     * @param string $suffix 削ぎ落とす末尾文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return string 削ぎ落とした文字列
     */
    function str_chop($string, $prefix = null, $suffix = null, $case_insensitivity = false)
    {
        $pattern = [];
        if (strlen($prefix)) {
            $pattern[] = '(\A' . preg_quote($prefix, '#') . ')';
        }
        if (strlen($suffix)) {
            $pattern[] = '(' . preg_quote($suffix, '#') . '\z)';
        }
        $flag = 'u' . ($case_insensitivity ? 'i' : '');
        return preg_replace('#' . implode('|', $pattern) . '#' . $flag, '', $string);
    }
}

const str_lchop = "str_lchop";
if (!isset($excluded_functions["str_lchop"]) && (!function_exists("str_lchop") || (!false && (new \ReflectionFunction("str_lchop"))->isInternal()))) {
    /**
     * 先頭の指定文字列を削ぎ落とす
     *
     * Example:
     * ```php
     * // 文字列からパス文字列を削ぎ落とす
     * $PATH = '/path/to/something';
     * assertSame(str_lchop("$PATH/hoge.php", "$PATH/"), 'hoge.php');
     * ```
     *
     * @param string $string 対象文字列
     * @param string $prefix 削ぎ落とす先頭文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return string 削ぎ落とした文字列
     */
    function str_lchop($string, $prefix, $case_insensitivity = false)
    {
        return str_chop($string, $prefix, null, $case_insensitivity);
    }
}

const str_rchop = "str_rchop";
if (!isset($excluded_functions["str_rchop"]) && (!function_exists("str_rchop") || (!false && (new \ReflectionFunction("str_rchop"))->isInternal()))) {
    /**
     * 末尾の指定文字列を削ぎ落とす
     *
     * Example:
     * ```php
     * // 文字列から .php を削ぎ落とす
     * $PATH = '/path/to/something';
     * assertSame(str_rchop("$PATH/hoge.php", ".php"), "$PATH/hoge");
     * ```
     *
     * @param string $string 対象文字列
     * @param string $suffix 削ぎ落とす末尾文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return string 削ぎ落とした文字列
     */
    function str_rchop($string, $suffix = null, $case_insensitivity = false)
    {
        return str_chop($string, null, $suffix, $case_insensitivity);
    }
}

const str_putcsv = "str_putcsv";
if (!isset($excluded_functions["str_putcsv"]) && (!function_exists("str_putcsv") || (!false && (new \ReflectionFunction("str_putcsv"))->isInternal()))) {
    /**
     * fputcsv の文字列版（str_getcsv の put 版）
     *
     * エラーは例外に変換される。
     *
     * 普通の配列を与えるとシンプルに "a,b,c" のような1行を返す。
     * 多次元配列（2次元のみを想定）や Traversable を与えるとループして "a,b,c\nd,e,f" のような複数行を返す。
     *
     * Example:
     * ```php
     * // シンプルな1行を返す
     * assertSame(str_putcsv(['a', 'b', 'c']), "a,b,c");
     * assertSame(str_putcsv(['a', 'b', 'c'], "\t"), "a\tb\tc");
     * assertSame(str_putcsv(['a', ' b ', 'c'], " ", "'"), "a ' b ' c");
     *
     * // 複数行を返す
     * assertSame(str_putcsv([['a', 'b', 'c'], ['d', 'e', 'f']]), "a,b,c\nd,e,f");
     * assertSame(str_putcsv((function() {
     *     yield ['a', 'b', 'c'];
     *     yield ['d', 'e', 'f'];
     * })()), "a,b,c\nd,e,f");
     * ```
     *
     * @param iterable $array 値の配列 or 値の配列の配列
     * @param string $delimiter フィールド区切り文字
     * @param string $enclosure フィールドを囲む文字
     * @param string $escape エスケープ文字
     * @return string CSV 文字列
     */
    function str_putcsv($array, $delimiter = ',', $enclosure = '"', $escape = "\\")
    {
        $fp = fopen('php://memory', 'rw+');
        try {
            if (is_array($array) && array_depth($array) === 1) {
                $array = [$array];
            }
            return call_safely(function ($fp, $array, $delimiter, $enclosure, $escape) {
                foreach ($array as $line) {
                    fputcsv($fp, $line, $delimiter, $enclosure, $escape);
                }
                rewind($fp);
                return rtrim(stream_get_contents($fp), "\n");
            }, $fp, $array, $delimiter, $enclosure, $escape);
        }
        finally {
            fclose($fp);
        }
    }
}

const str_subreplace = "str_subreplace";
if (!isset($excluded_functions["str_subreplace"]) && (!function_exists("str_subreplace") || (!false && (new \ReflectionFunction("str_subreplace"))->isInternal()))) {
    /**
     * 指定文字列を置換する
     *
     * $subject 内の $search を $replaces に置換する。
     * str_replace とは「N 番目のみ置換できる」点で異なる。
     * つまり、$search='hoge', $replace=[2 => 'fuga'] とすると「2 番目の 'hoge' が 'fuga' に置換される」という動作になる（0 ベース）。
     *
     * $replace に 非配列を与えた場合は配列化される。
     * つまり `$replaces = 'hoge'` は `$replaces = [0 => 'hoge']` と同じ（最初のマッチを置換する）。
     *
     * $replace に空配列を与えると何もしない。
     * 負数キーは後ろから数える動作となる。
     * また、置換後の文字列は置換対象にはならない。
     *
     * N 番目の検索文字列が見つからない場合は例外を投げる。
     * ただし、文字自体が見つからない場合は投げない。
     *
     * Example:
     * ```php
     * // 1番目（0ベースなので2番目）の x を X に置換
     * assertSame(str_subreplace('xxx', 'x', [1 => 'X']), 'xXx');
     * // 0番目（最前列）の x を Xa に、-1番目（最後尾）の x を Xz に置換
     * assertSame(str_subreplace('!xxx!', 'x', [0 => 'Xa', -1 => 'Xz']), '!XaxXz!');
     * // 置換結果は置換対象にならない
     * assertSame(str_subreplace('xxx', 'x', [0 => 'xxx', 1 => 'X']), 'xxxXx');
     * ```
     *
     * @param string $subject 対象文字列
     * @param string $search 検索文字列
     * @param array|string $replaces 置換文字列配列（単一指定は配列化される）
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return string 置換された文字列
     */
    function str_subreplace($subject, $search, $replaces, $case_insensitivity = false)
    {
        $replaces = is_iterable($replaces) ? $replaces : [$replaces];

        // 空はそのまま返す
        if (is_empty($replaces)) {
            return $subject;
        }

        // 負数対応のために逆数計算（ついでに整数チェック）
        $subcount = $case_insensitivity ? substr_count(strtolower($subject), strtolower($search)) : substr_count($subject, $search);
        if ($subcount === 0) {
            return $subject;
        }
        $mapping = [];
        foreach ($replaces as $n => $replace) {
            $origN = $n;
            if (!is_int($n)) {
                throw new \InvalidArgumentException('$replaces key must be integer.');
            }
            if ($n < 0) {
                $n += $subcount;
            }
            if (!(0 <= $n && $n < $subcount)) {
                throw new \InvalidArgumentException("notfound search string '$search' of {$origN}th.");
            }
            $mapping[$n] = $replace;
        }
        $maxseq = max(array_keys($mapping));
        $offset = 0;
        for ($n = 0; $n <= $maxseq; $n++) {
            $pos = $case_insensitivity ? stripos($subject, $search, $offset) : strpos($subject, $search, $offset);
            if (isset($mapping[$n])) {
                $subject = substr_replace($subject, $mapping[$n], $pos, strlen($search));
                $offset = $pos + strlen($mapping[$n]);
            }
            else {
                $offset = $pos + strlen($search);
            }
        }
        return $subject;
    }
}

const str_submap = "str_submap";
if (!isset($excluded_functions["str_submap"]) && (!function_exists("str_submap") || (!false && (new \ReflectionFunction("str_submap"))->isInternal()))) {
    /**
     * 指定文字列を置換する
     *
     * $subject を $replaces に従って置換する。
     * 具体的には「$replaces を 複数指定できる str_subreplace」に近い。
     *
     * strtr とは「N 番目のみ置換できる」点で異なる。
     * つまり、$replaces=['hoge' => [2 => 'fuga']] とすると「2 番目の 'hoge' が 'fuga' に置換される」という動作になる（0 ベース）。
     *
     * $replaces の要素に非配列を与えた場合は配列化される。
     * つまり `$replaces = ['hoge' => 'fuga']` は `$replaces = ['hoge' => ['fuga']]` と同じ（最初のマッチを置換する）。
     *
     * $replace に空配列を与えると何もしない。
     * 負数キーは後ろから数える動作となる。
     * また、置換後の文字列は置換対象にはならない。
     *
     * N 番目の検索文字列が見つからない場合は例外を投げる。
     * ただし、文字自体が見つからない場合は投げない。
     *
     * Example:
     * ```php
     * // "hello, world" の l と o を置換
     * assertSame(str_submap('hello, world', [
     *     // l は0番目と2番目のみを置換（1番目は何も行われない）
     *     'l' => [
     *         0 => 'L1',
     *         2 => 'L3',
     *     ],
     *     // o は後ろから数えて1番目を置換
     *     'o' => [
     *         -1 => 'O',
     *     ],
     * ]), 'heL1lo, wOrL3d');
     * ```
     *
     * @param string $subject 対象文字列
     * @param array $replaces 読み換え配列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return string 置換された文字列
     */
    function str_submap($subject, $replaces, $case_insensitivity = false)
    {
        assert(is_iterable($replaces));

        $isubject = $subject;
        if ($case_insensitivity) {
            $isubject = strtolower($isubject);
        }

        // 負数対応のために逆数計算（ついでに整数チェック）
        $mapping = [];
        foreach ($replaces as $from => $map) {
            $ifrom = $from;
            if ($case_insensitivity) {
                $ifrom = strtolower($ifrom);
            }
            $subcount = substr_count($isubject, $ifrom);
            if ($subcount === 0) {
                continue;
            }
            $mapping[$ifrom] = [];
            $map = is_iterable($map) ? $map : [$map];
            foreach ($map as $n => $to) {
                $origN = $n;
                if (!is_int($n)) {
                    throw new \InvalidArgumentException('$replaces key must be integer.');
                }
                if ($n < 0) {
                    $n += $subcount;
                }
                if (!(0 <= $n && $n < $subcount)) {
                    throw new \InvalidArgumentException("notfound search string '$from' of {$origN}th.");
                }
                $mapping[$ifrom][$n] = $to;
            }
        }

        // 空はそのまま返す
        if (is_empty($mapping)) {
            return $subject;
        }

        // いろいろ試した感じ正規表現が最もシンプルかつ高速だった

        $repkeys = array_keys($mapping);
        $counter = array_fill_keys($repkeys, 0);
        $patterns = array_map(function ($k) { return preg_quote($k, '#'); }, $repkeys);

        $i_flag = $case_insensitivity ? 'i' : '';
        return preg_replace_callback("#" . implode('|', $patterns) . "#u$i_flag", function ($matches) use (&$counter, $mapping, $case_insensitivity) {
            $imatch = $matches[0];
            if ($case_insensitivity) {
                $imatch = strtolower($imatch);
            }
            $index = $counter[$imatch]++;
            if (array_key_exists($index, $mapping[$imatch])) {
                return $mapping[$imatch][$index];
            }
            return $matches[0];
        }, $subject);
    }
}

const str_between = "str_between";
if (!isset($excluded_functions["str_between"]) && (!function_exists("str_between") || (!false && (new \ReflectionFunction("str_between"))->isInternal()))) {
    /**
     * 指定文字で囲まれた文字列を取得する
     *
     * $from, $to で指定した文字間を取得する（$from, $to 自体は結果に含まれない）。
     * ネストしている場合、一番外側の文字間を返す。
     *
     * $enclosure で「特定文字に囲まれている」場合を無視することができる。
     * $escape で「特定文字が前にある」場合を無視することができる。
     *
     * $position を与えた場合、その場所から走査を開始する。
     * さらに結果があった場合、 $position には「次の走査開始位置」が代入される。
     * これを使用すると連続で「次の文字, 次の文字, ...」と言った動作が可能になる。
     *
     * Example:
     * ```php
     * // $position を利用して "first", "second", "third" を得る（"で囲まれた "blank" は返ってこない）。
     * assertSame(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n), 'first');
     * assertSame(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n), 'second');
     * assertSame(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n), 'third');
     * // ネストしている場合は最も外側を返す
     * assertSame(str_between('{nest1{nest2{nest3}}}', '{', '}'), 'nest1{nest2{nest3}}');
     * ```
     *
     * @param string $string 対象文字列
     * @param string $from 開始文字列
     * @param string $to 終了文字列
     * @param int $position 開始位置。渡した場合次の開始位置が設定される
     * @param string $enclosure 囲い文字。この文字中にいる $from, $to 文字は走査外になる
     * @param string $escape エスケープ文字。この文字が前にある $from, $to 文字は走査外になる
     * @return string|bool $from, $to で囲まれた文字。見つからなかった場合は false
     */
    function str_between($string, $from, $to, &$position = 0, $enclosure = '\'"', $escape = '\\')
    {
        $strlen = strlen($string);
        $fromlen = strlen($from);
        $tolen = strlen($to);
        $position = intval($position);
        $enclosing = null;
        $nesting = 0;
        $start = null;
        for ($i = $position; $i < $strlen; $i++) {
            if ($i !== 0 && $string[$i - 1] === $escape) {
                continue;
            }
            if (strpos($enclosure, $string[$i]) !== false) {
                if ($enclosing === null) {
                    $enclosing = $string[$i];
                }
                elseif ($enclosing === $string[$i]) {
                    $enclosing = null;
                }
                continue;
            }

            // 開始文字と終了文字が重複している可能性があるので $to からチェックする
            if ($enclosing === null && substr_compare($string, $to, $i, $tolen) === 0) {
                if (--$nesting === 0) {
                    $position = $i + $tolen;
                    return substr($string, $start, $i - $start);
                }
                // いきなり終了文字が来た場合は無視する
                if ($nesting < 0) {
                    $nesting = 0;
                }
            }
            if ($enclosing === null && substr_compare($string, $from, $i, $fromlen) === 0) {
                if ($nesting++ === 0) {
                    $start = $i + $fromlen;
                }
            }
        }
        return false;
    }
}

const str_ellipsis = "str_ellipsis";
if (!isset($excluded_functions["str_ellipsis"]) && (!function_exists("str_ellipsis") || (!false && (new \ReflectionFunction("str_ellipsis"))->isInternal()))) {
    /**
     * 文字列を指定幅に丸める
     *
     * mb_strimwidth と機能的には同じだが、省略文字の差し込み位置を $pos で指定できる。
     * $pos は負数が指定できる。負数の場合後ろから数えられる。
     * 省略した場合は真ん中となる。
     *
     * Example:
     * ```php
     * // 8文字に丸める（$pos 省略なので真ん中が省略される）
     * assertSame(str_ellipsis('1234567890', 8, '...'), '12...890');
     * // 8文字に丸める（$pos=1 なので1文字目から省略される）
     * assertSame(str_ellipsis('1234567890', 8, '...', 1), '1...7890');
     * // 8文字に丸める（$pos=-1 なので後ろから1文字目から省略される）
     * assertSame(str_ellipsis('1234567890', 8, '...', -1), '1234...0');
     * ```
     *
     * @param string $string 対象文字列
     * @param int $width 丸める幅
     * @param string $trimmarker 省略文字列
     * @param int|null $pos 省略記号の差し込み位置
     * @return string 丸められた文字列
     */
    function str_ellipsis($string, $width, $trimmarker = '...', $pos = null)
    {
        $string = (string) $string;

        $strlen = mb_strlen($string);
        if ($strlen <= $width) {
            return $string;
        }

        $markerlen = mb_strlen($trimmarker);
        if ($markerlen >= $width) {
            return $trimmarker;
        }

        $length = $width - $markerlen;
        $pos = $pos ?? $length / 2;
        if ($pos < 0) {
            $pos += $length;
        }
        $pos = max(0, min($pos, $length));

        return mb_substr_replace($string, $trimmarker, $pos, $strlen - $length);
    }
}

const starts_with = "starts_with";
if (!isset($excluded_functions["starts_with"]) && (!function_exists("starts_with") || (!false && (new \ReflectionFunction("starts_with"))->isInternal()))) {
    /**
     * 指定文字列で始まるか調べる
     *
     * $with に配列を渡すといずれかで始まるときに true を返す。
     *
     * Example:
     * ```php
     * assertTrue(starts_with('abcdef', 'abc'));
     * assertTrue(starts_with('abcdef', 'ABC', true));
     * assertFalse(starts_with('abcdef', 'xyz'));
     * assertTrue(starts_with('abcdef', ['a', 'b', 'c']));
     * assertFalse(starts_with('abcdef', ['x', 'y', 'z']));
     * ```
     *
     * @param string $string 探される文字列
     * @param string|array $with 探す文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return bool 指定文字列で始まるなら true を返す
     */
    function starts_with($string, $with, $case_insensitivity = false)
    {
        assert(is_string($string));

        foreach ((array) $with as $w) {
            assert(is_string($w));
            assert(strlen($w));

            if (str_equals(substr($string, 0, strlen($w)), $w, $case_insensitivity)) {
                return true;
            }
        }
        return false;
    }
}

const ends_with = "ends_with";
if (!isset($excluded_functions["ends_with"]) && (!function_exists("ends_with") || (!false && (new \ReflectionFunction("ends_with"))->isInternal()))) {
    /**
     * 指定文字列で終わるか調べる
     *
     * $with に配列を渡すといずれかで終わるときに true を返す。
     *
     * Example:
     * ```php
     * assertTrue(ends_with('abcdef', 'def'));
     * assertTrue(ends_with('abcdef', 'DEF', true));
     * assertFalse(ends_with('abcdef', 'xyz'));
     * assertTrue(ends_with('abcdef', ['d', 'e', 'f']));
     * assertFalse(ends_with('abcdef', ['x', 'y', 'z']));
     * ```
     *
     * @param string $string 探される文字列
     * @param string $with 探す文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return bool 対象文字列で終わるなら true
     */
    function ends_with($string, $with, $case_insensitivity = false)
    {
        assert(is_string($string));

        foreach ((array) $with as $w) {
            assert(is_string($w));
            assert(strlen($w));

            if (str_equals(substr($string, -strlen($w)), $w, $case_insensitivity)) {
                return true;
            }
        }
        return false;
    }
}

const camel_case = "camel_case";
if (!isset($excluded_functions["camel_case"]) && (!function_exists("camel_case") || (!false && (new \ReflectionFunction("camel_case"))->isInternal()))) {
    /**
     * camelCase に変換する
     *
     * Example:
     * ```php
     * assertSame(camel_case('this_is_a_pen'), 'thisIsAPen');
     * ```
     *
     * @param string $string 対象文字列
     * @param string $delimiter デリミタ
     * @return string 変換した文字列
     */
    function camel_case($string, $delimiter = '_')
    {
        return lcfirst(pascal_case($string, $delimiter));
    }
}

const pascal_case = "pascal_case";
if (!isset($excluded_functions["pascal_case"]) && (!function_exists("pascal_case") || (!false && (new \ReflectionFunction("pascal_case"))->isInternal()))) {
    /**
     * PascalCase に変換する
     *
     * Example:
     * ```php
     * assertSame(pascal_case('this_is_a_pen'), 'ThisIsAPen');
     * ```
     *
     * @param string $string 対象文字列
     * @param string $delimiter デリミタ
     * @return string 変換した文字列
     */
    function pascal_case($string, $delimiter = '_')
    {
        return strtr(ucwords(strtr($string, [$delimiter => ' '])), [' ' => '']);
    }
}

const snake_case = "snake_case";
if (!isset($excluded_functions["snake_case"]) && (!function_exists("snake_case") || (!false && (new \ReflectionFunction("snake_case"))->isInternal()))) {
    /**
     * snake_case に変換する
     *
     * Example:
     * ```php
     * assertSame(snake_case('ThisIsAPen'), 'this_is_a_pen');
     * ```
     *
     * @param string $string 対象文字列
     * @param string $delimiter デリミタ
     * @return string 変換した文字列
     */
    function snake_case($string, $delimiter = '_')
    {
        return ltrim(strtolower(preg_replace('/[A-Z]/', $delimiter . '\0', $string)), $delimiter);
    }
}

const chain_case = "chain_case";
if (!isset($excluded_functions["chain_case"]) && (!function_exists("chain_case") || (!false && (new \ReflectionFunction("chain_case"))->isInternal()))) {
    /**
     * chain-case に変換する
     *
     * Example:
     * ```php
     * assertSame(chain_case('ThisIsAPen'), 'this-is-a-pen');
     * ```
     *
     * @param string $string 対象文字列
     * @param string $delimiter デリミタ
     * @return string 変換した文字列
     */
    function chain_case($string, $delimiter = '-')
    {
        return snake_case($string, $delimiter);
    }
}

const namespace_split = "namespace_split";
if (!isset($excluded_functions["namespace_split"]) && (!function_exists("namespace_split") || (!false && (new \ReflectionFunction("namespace_split"))->isInternal()))) {
    /**
     * 文字列を名前空間とローカル名に区切ってタプルで返す
     *
     * class_namespace/class_shorten や function_shorten とほぼ同じだが下記の違いがある。
     *
     * - あくまで文字列として処理する
     *     - 例えば class_namespace は get_class されるが、この関数は（いうなれば） strval される
     * - \\ を trim しないし、特別扱いもしない
     *     - `ns\\hoge` と `\\ns\\hoge` で返り値が微妙に異なる
     *     - `ns\\` のような場合は名前空間だけを返す
     *
     * Example:
     * ```php
     * assertSame(namespace_split('ns\\hoge'), ['ns', 'hoge']);
     * assertSame(namespace_split('hoge'), ['', 'hoge']);
     * assertSame(namespace_split('ns\\'), ['ns', '']);
     * assertSame(namespace_split('\\hoge'), ['', 'hoge']);
     * ```
     *
     * @param string $string 対象文字列
     * @return array [namespace, localname]
     */
    function namespace_split($string)
    {
        $pos = strrpos($string, '\\');
        if ($pos === false) {
            return ['', $string];
        }
        return [substr($string, 0, $pos), substr($string, $pos + 1)];
    }
}

const htmltag = "htmltag";
if (!isset($excluded_functions["htmltag"]) && (!function_exists("htmltag") || (!false && (new \ReflectionFunction("htmltag"))->isInternal()))) {
    /**
     * css セレクタから html 文字列を生成する
     *
     * `tag#id.class[attr=value]` のような css セレクタから `<tag id="id" class="class" attr="value"></tag>` のような html 文字列を返す。
     * 配列を与えるとキーがセレクタ、値がコンテント文字列になる。
     * さらに値が配列だと再帰して生成する。
     *
     * 値や属性は適切に htmlspecialchars される。
     *
     * Example:
     * ```php
     * // 単純文字列はただのタグを生成する
     * assertSame(
     *     htmltag('a#hoge.c1.c2[name=hoge\[\]][href="http://hoge"][hidden]'),
     *     '<a id="hoge" class="c1 c2" name="hoge[]" href="http://hoge" hidden></a>'
     * );
     * // ペア配列を与えるとコンテント文字列になる
     * assertSame(
     *     htmltag(['a.c1#hoge.c2[name=hoge\[\]][href="http://hoge"][hidden]' => "this is text's content"]),
     *     '<a id="hoge" class="c1 c2" name="hoge[]" href="http://hoge" hidden>this is text&#039;s content</a>'
     * );
     * // ネストした配列を与えると再帰される
     * assertSame(
     *     htmltag([
     *         'div#wrapper' => [
     *             'b.class1' => [
     *                 '<plain>',
     *             ],
     *             'b.class2' => [
     *                 '<plain1>',
     *                 's' => '<strike>',
     *                 '<plain2>',
     *             ],
     *         ],
     *     ]),
     *     '<div id="wrapper"><b class="class1">&lt;plain&gt;</b><b class="class2">&lt;plain1&gt;<s>&lt;strike&gt;</s>&lt;plain2&gt;</b></div>'
     * );
     * ```
     *
     * @param string|array $selector
     * @return string html 文字列
     */
    function htmltag($selector)
    {
        if (!is_iterable($selector)) {
            $selector = [$selector => ''];
        }

        $html = static function ($string) {
            return htmlspecialchars($string, ENT_QUOTES);
        };

        $build = static function ($selector, $content, $escape) use ($html) {
            $tag = '';
            $id = '';
            $classes = [];
            $attrs = [];

            $context = null;
            $escaping = null;
            $chars = preg_split('##u', $selector, -1, PREG_SPLIT_NO_EMPTY);
            for ($i = 0, $l = count($chars); $i < $l; $i++) {
                $char = $chars[$i];
                if ($char === '"' || $char === "'") {
                    $escaping = $escaping === $char ? null : $char;
                }

                if (!$escaping && $char === '#') {
                    if (strlen($id)) {
                        throw new \InvalidArgumentException('#id is multiple.');
                    }
                    $context = $char;
                    continue;
                }
                if (!$escaping && $char === '.') {
                    $context = $char;
                    $classes[] = '';
                    continue;
                }
                if (!$escaping && $char === '[') {
                    $context = $char;
                    $attrs[] = '';
                    continue;
                }
                if (!$escaping && $char === ']') {
                    $context = null;
                    continue;
                }

                if ($char === '\\') {
                    $char = $chars[++$i];
                }

                if ($context === null) {
                    $tag .= $char;
                    continue;
                }
                if ($context === '#') {
                    $id .= $char;
                    continue;
                }
                if ($context === '.') {
                    $classes[count($classes) - 1] .= $char;
                    continue;
                }
                if ($context === '[') {
                    $attrs[count($attrs) - 1] .= $char;
                    continue;
                }
            }

            if (!strlen($tag)) {
                throw new \InvalidArgumentException('tagname is empty.');
            }

            $attrkv = [];
            if (strlen($id)) {
                $attrkv['id'] = $id;
            }
            if ($classes) {
                $attrkv['class'] = implode(' ', $classes);
            }
            foreach ($attrs as $attr) {
                list($k, $v) = explode('=', $attr, 2) + [1 => null];
                if (array_key_exists($k, $attrkv)) {
                    throw new \InvalidArgumentException("[$k] is dumplicated.");
                }
                $attrkv[$k] = $v;
            }
            $attrs = [];
            foreach ($attrkv as $k => $v) {
                $attrs[] = $v === null
                    ? $html($k)
                    : sprintf('%s="%s"', $html($k), $html(preg_replace('#^([\"\'])|([^\\\\])([\"\'])$#u', '$2', $v)));
            }

            preg_match('#(\s*)(.+)(\s*)#u', $tag, $m);
            list(, $prefix, $tag, $suffix) = $m;
            $tag_attr = $html($tag) . concat(' ', implode(' ', $attrs));
            $content = ($escape ? $html($content) : $content);

            return "$prefix<$tag_attr>$content</$tag>$suffix";
        };

        $result = '';
        foreach ($selector as $key => $value) {
            if (is_int($key)) {
                $result .= $html($value);
            }
            elseif (is_iterable($value)) {
                $result .= $build($key, htmltag($value), false);
            }
            else {
                $result .= $build($key, $value, true);
            }
        }
        return $result;
    }
}

const build_uri = "build_uri";
if (!isset($excluded_functions["build_uri"]) && (!function_exists("build_uri") || (!false && (new \ReflectionFunction("build_uri"))->isInternal()))) {
    /**
     * parse_uri の逆
     *
     * URI のパーツを与えると URI として構築する。
     * パーツは不完全でも良い。例えば scheme を省略すると "://" すら付かない URI が生成される。
     *
     * "query" パートだけは配列が許容される。その場合クエリ文字列に変換される。
     *
     * Example:
     * ```php
     * // 完全指定
     * assertSame(build_uri([
     *     'scheme'   => 'http',
     *     'user'     => 'user',
     *     'pass'     => 'pass',
     *     'host'     => 'localhost',
     *     'port'     => '80',
     *     'path'     => '/path/to/file',
     *     'query'    => ['id' => 1],
     *     'fragment' => 'hash',
     * ]), 'http://user:pass@localhost:80/path/to/file?id=1#hash');
     * // 一部だけ指定
     * assertSame(build_uri([
     *     'scheme'   => 'http',
     *     'host'     => 'localhost',
     *     'path'     => '/path/to/file',
     *     'fragment' => 'hash',
     * ]), 'http://localhost/path/to/file#hash');
     * ```
     *
     * @param array $parts URI の各パーツ配列
     * @return string URI 文字列
     */
    function build_uri($parts)
    {
        $parts += [
            'scheme'   => '',
            'user'     => '',
            'pass'     => '',
            'host'     => '',
            'port'     => '',
            'path'     => '',
            'query'    => '',
            'fragment' => '',
        ];
        $parts['host'] = filter_var($parts['host'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? "[{$parts['host']}]" : $parts['host'];
        $parts['path'] = ltrim($parts['path'], '/');
        $parts['query'] = is_array($parts['query']) ? http_build_query($parts['query'], '', '&') : $parts['query'];

        $uri = '';
        $uri .= concat($parts['scheme'], '://');
        $uri .= concat($parts['user'] . concat(':', $parts['pass']), '@');
        $uri .= concat($parts['host']);
        $uri .= concat(':', $parts['port']);
        $uri .= concat('/', $parts['path']);
        $uri .= concat('?', $parts['query']);
        $uri .= concat('#', $parts['fragment']);
        return $uri;
    }
}

const parse_uri = "parse_uri";
if (!isset($excluded_functions["parse_uri"]) && (!function_exists("parse_uri") || (!false && (new \ReflectionFunction("parse_uri"))->isInternal()))) {
    /**
     * parse_url の仕様を少しいじったもの
     *
     * parse_url とは下記が異なる。
     *
     * - "単一文字列" はホスト名とみなされる（parse_url はパスとみなされる）
     * - パートがなくてもキー自体は生成される（そしてその値は $default で指定したもの）
     * - query は配列で返す（parse_str される）
     * - パート値をスカラー値で返すことはできない（必ず8要素の配列を返す）
     *
     * Example:
     * ```php
     * // 完全指定
     * assertEquals(parse_uri('http://user:pass@localhost:80/path/to/file?id=1#hash'), [
     *     'scheme'   => 'http',
     *     'user'     => 'user',
     *     'pass'     => 'pass',
     *     'host'     => 'localhost',
     *     'port'     => '80',
     *     'path'     => '/path/to/file',
     *     'query'    => ['id' => 1],
     *     'fragment' => 'hash',
     * ]);
     * // デフォルト値つき
     * assertEquals(parse_uri('localhost/path/to/file', [
     *     'scheme'   => 'http', // scheme のデフォルト値
     *     'user'     => 'user', // user のデフォルト値
     *     'port'     => '8080', // port のデフォルト値
     *     'host'     => 'hoge', // host のデフォルト値
     * ]), [
     *     'scheme'   => 'http',      // scheme はないのでデフォルト値が使われている
     *     'user'     => 'user',      // user はないのでデフォルト値が使われている
     *     'pass'     => '',
     *     'host'     => 'localhost', // host はあるのでデフォルト値が使われていない
     *     'port'     => '8080',      // port はないのでデフォルト値が使われている
     *     'path'     => '/path/to/file',
     *     'query'    => [],
     *     'fragment' => '',
     * ]);
     * ```
     *
     * @param string $uri パースする URI
     * @param array|string $default $uri に足りないパーツがあった場合のデフォルト値。文字列を与えた場合はそのパース結果がデフォルト値になる
     * @return array URI の各パーツ配列
     */
    function parse_uri($uri, $default = [])
    {
        /** @noinspection RequiredAttributes */
        $regex = "
            (?:(?<scheme>[a-z][-+.0-9a-z]*)://)?
            (?:
              (?: (?<user>(?:[-.~\\w]|%[0-9a-f][0-9a-f]|[!$&-,;=])*)?
              (?::(?<pass>(?:[-.~\\w]|%[0-9a-f][0-9a-f]|[!$&-,;=])*))?@)?
            )?
            (?<host>((?:\\[[0-9a-f:]+\\]) | (?:[-.~\\w]|%[0-9a-f][0-9a-f]|[!$&-,;=]))*)
            (?::(?<port>\d{0,5}))?
            (?<path>(?:/(?: [-.~\\w!$&'()*+,;=:@] | %[0-9a-f]{2} )* )*)?
            (?:\\?(?<query>   (?:[-.~\\w]|%[0-9a-f][0-9a-f]|[!$&-,;=/:?@])*))?
            (?:\\#(?<fragment>(?:[-.~\\w]|%[0-9a-f][0-9a-f]|[!$&-,;=/:?@])*))?
        ";

        $default_default = [
            'scheme'   => '',
            'user'     => '',
            'pass'     => '',
            'host'     => '',
            'port'     => '',
            'path'     => '',
            'query'    => '',
            'fragment' => '',
        ];

        // 配列以外はパースしてそれをデフォルトとする
        if (!is_array($default)) {
            $default = preg_capture("#^$regex\$#ix", (string) $default, $default_default);
        }

        // パース。先頭の // はスキーム省略とみなすので除去する
        $uri = preg_splice('#^//#', '', $uri);
        $parts = preg_capture("#^$regex\$#ix", $uri, $default + $default_default);

        // 諸々調整（IPv6、パス / の正規化、クエリ配列化）
        $parts['host'] = preg_splice('#^\\[(.+)\\]$#', '$1', $parts['host']);
        $parts['path'] = concat('/', ltrim($parts['path'], '/'));
        if (is_string($parts['query'])) {
            parse_str($parts['query'], $parts['query']);
        }

        return $parts;
    }
}

const ini_export = "ini_export";
if (!isset($excluded_functions["ini_export"]) && (!function_exists("ini_export") || (!false && (new \ReflectionFunction("ini_export"))->isInternal()))) {
    /**
     * 連想配列を INI 的文字列に変換する
     *
     * Example:
     * ```php
     * assertEquals(ini_export(['a' => 1, 'b' => 'B', 'c' => PHP_SAPI]), 'a = 1
     * b = "B"
     * c = "cli"
     * ');
     * ```
     *
     * @param array $iniarray ini 化する配列
     * @param array $options オプション配列
     * @return string ini 文字列
     */
    function ini_export($iniarray, $options = [])
    {
        $options += [
            'process_sections' => false,
            'alignment'        => true,
        ];

        $generate = function ($array, $key = null) use (&$generate, $options) {
            $ishasharray = is_array($array) && is_hasharray($array);
            return array_sprintf($array, function ($v, $k) use ($generate, $key, $ishasharray) {
                if (is_iterable($v)) {
                    return $generate($v, $k);
                }

                if ($key === null) {
                    return $k . ' = ' . var_export2($v, true);
                }
                return ($ishasharray ? "{$key}[$k]" : "{$key}[]") . ' = ' . var_export2($v, true);
            }, "\n");
        };

        if ($options['process_sections']) {
            return array_sprintf($iniarray, function ($v, $k) use ($generate) {
                return "[$k]\n{$generate($v)}\n";
            }, "\n");
        }

        return $generate($iniarray) . "\n";
    }
}

const ini_import = "ini_import";
if (!isset($excluded_functions["ini_import"]) && (!function_exists("ini_import") || (!false && (new \ReflectionFunction("ini_import"))->isInternal()))) {
    /**
     * INI 的文字列を連想配列に変換する
     *
     * Example:
     * ```php
     * assertEquals(ini_import("
     * a = 1
     * b = 'B'
     * c = PHP_VERSION
     * "), ['a' => 1, 'b' => 'B', 'c' => PHP_VERSION]);
     * ```
     *
     * @param string $inistring ini 文字列
     * @param array $options オプション配列
     * @return array 配列
     */
    function ini_import($inistring, $options = [])
    {
        $options += [
            'process_sections' => false,
            'scanner_mode'     => INI_SCANNER_TYPED,
        ];

        return parse_ini_string($inistring, $options['process_sections'], $options['scanner_mode']);
    }
}

const csv_export = "csv_export";
if (!isset($excluded_functions["csv_export"]) && (!function_exists("csv_export") || (!false && (new \ReflectionFunction("csv_export"))->isInternal()))) {
    /**
     * 連想配列の配列を CSV 的文字列に変換する
     *
     * CSV ヘッダ行は全連想配列のキーの共通項となる。
     * 順番には依存しないが、余計な要素があってもそのキーはヘッダには追加されないし、データ行にも含まれない。
     * ただし、オプションで headers が与えられた場合はそれを使用する。
     * この headers オプションはヘッダ文字列変換も兼ねる（[key => header] で「key を header で吐き出し」となる）。
     *
     * callback オプションが渡された場合は「あらゆる処理の最初」にコールされる。
     * つまりヘッダの読み換えや文字エンコーディングの変換が行われる前の状態でコールされる。
     * また、 false を返すとその要素はスルーされる。
     *
     * output オプションにリソースを渡すとそこに対して書き込みが行われる（fclose はされない）。
     *
     * Example:
     * ```php
     * // シンプルな実行例
     * $csvarrays = [
     *     ['a' => 'A1', 'b' => 'B1', 'c' => 'C1'],             // 普通の行
     *     ['c' => 'C2', 'a' => 'A2', 'b' => 'B2'],             // 順番が入れ替わっている行
     *     ['c' => 'C3', 'a' => 'A3', 'b' => 'B3', 'x' => 'X'], // 余計な要素が入っている行
     * ];
     * assertEquals(csv_export($csvarrays), "a,b,c
     * A1,B1,C1
     * A2,B2,C2
     * A3,B3,C3
     * ");
     *
     * // ヘッダを指定できる
     * assertEquals(csv_export($csvarrays, [
     *     'headers' => ['a' => 'A', 'c' => 'C'], // a と c だけを出力＋ヘッダ文字変更
     * ]), "A,C
     * A1,C1
     * A2,C2
     * A3,C3
     * ");
     * ```
     *
     * @param array $csvarrays 連想配列の配列
     * @param array $options オプション配列。fputcsv の第3引数以降もここで指定する
     * @return array|int CSV 的文字列。output オプションを渡した場合は書き込みバイト数
     */
    function csv_export($csvarrays, $options = [])
    {
        $options += [
            'delimiter' => ',',
            'enclosure' => '"',
            'escape'    => '\\',
            'encoding'  => mb_internal_encoding(),
            'headers'   => [],
            'callback'  => null, // map + filter 用コールバック（1行が参照で渡ってくるので書き換えられる&&false を返すと結果から除かれる）
            'output'    => null,
        ];

        $output = $options['output'];

        if ($output) {
            $fp = $options['output'];
        }
        else {
            $fp = fopen('php://temp', 'rw+');
        }
        try {
            $size = call_safely(function ($fp, $csvarrays, $delimiter, $enclosure, $escape, $encoding, $headers, $callback) {
                $size = 0;
                $mb_internal_encoding = mb_internal_encoding();
                if (!$headers) {
                    foreach ($csvarrays as $array) {
                        $headers = $headers ? array_intersect_key($headers, $array) : $array;
                    }
                    $headers = array_keys($headers);
                }
                if (!is_hasharray($headers)) {
                    $headers = array_combine($headers, $headers);
                }
                if ($encoding !== $mb_internal_encoding) {
                    mb_convert_variables($encoding, $mb_internal_encoding, $headers);
                }
                $size += fputcsv($fp, $headers, $delimiter, $enclosure, $escape);
                $default = array_fill_keys(array_keys($headers), '');

                foreach ($csvarrays as $n => $array) {
                    if ($callback) {
                        if ($callback($array, $n) === false) {
                            continue;
                        }
                    }
                    $row = array_intersect_key(array_replace($default, $array), $default);
                    if ($encoding !== $mb_internal_encoding) {
                        mb_convert_variables($encoding, $mb_internal_encoding, $row);
                    }
                    $size += fputcsv($fp, $row, $delimiter, $enclosure, $escape);
                }
                return $size;
            }, $fp, $csvarrays, $options['delimiter'], $options['enclosure'], $options['escape'], $options['encoding'], $options['headers'], $options['callback']);
            if ($output) {
                return $size;
            }
            rewind($fp);
            return stream_get_contents($fp);
        }
        finally {
            if (!$output) {
                fclose($fp);
            }
        }
    }
}

const csv_import = "csv_import";
if (!isset($excluded_functions["csv_import"]) && (!function_exists("csv_import") || (!false && (new \ReflectionFunction("csv_import"))->isInternal()))) {
    /**
     * CSV 的文字列を連想配列の配列に変換する
     *
     * 1行目をヘッダ文字列とみなしてそれをキーとした連想配列の配列を返す。
     * ただし、オプションで headers が与えられた場合はそれを使用する。
     * この headers オプションはヘッダフィルタも兼ねる（[n => header] で「n 番目フィールドを header で取り込み」となる）。
     * 入力にヘッダがありかつ headers に連想配列が渡された場合はフィルタ兼読み換えとなる（Example を参照）。
     *
     * callback オプションが渡された場合は「あらゆる処理の最後」にコールされる。
     * つまりヘッダの読み換えや文字エンコーディングの変換が行われた後の状態でコールされる。
     * また、 false を返すとその要素はスルーされる。
     *
     * メモリ効率は意識しない（どうせ配列を返すので意識しても無駄）。
     *
     * Example:
     * ```php
     * // シンプルな実行例
     * assertEquals(csv_import("
     * a,b,c
     * A1,B1,C1
     * A2,B2,C2
     * A3,B3,C3
     * "), [
     *     ['a' => 'A1', 'b' => 'B1', 'c' => 'C1'],
     *     ['a' => 'A2', 'b' => 'B2', 'c' => 'C2'],
     *     ['a' => 'A3', 'b' => 'B3', 'c' => 'C3'],
     * ]);
     *
     * // ヘッダを指定できる
     * assertEquals(csv_import("
     * A1,B1,C1
     * A2,B2,C2
     * A3,B3,C3
     * ", [
     *     'headers' => [0 => 'a', 2 => 'c'], // 1がないので1番目のフィールドを読み飛ばしつつ、0, 2 は "a", "c" として取り込む
     * ]), [
     *     ['a' => 'A1', 'c' => 'C1'],
     *     ['a' => 'A2', 'c' => 'C2'],
     *     ['a' => 'A3', 'c' => 'C3'],
     * ]);
     *
     * // ヘッダありで連想配列で指定するとキーの読み換えとなる（指定しなければ読み飛ばしも行える）
     * assertEquals(csv_import("
     * a,b,c
     * A1,B1,C1
     * A2,B2,C2
     * A3,B3,C3
     * ", [
     *     'headers' => ['a' => 'hoge', 'c' => 'piyo'], // a は hoge, c は piyo で読み込む。 b は指定がないので飛ばされる
     * ]), [
     *     ['hoge' => 'A1', 'piyo' => 'C1'],
     *     ['hoge' => 'A2', 'piyo' => 'C2'],
     *     ['hoge' => 'A3', 'piyo' => 'C3'],
     * ]);
     * ```
     *
     * @param string|resource $csvstring CSV 的文字列。ファイルポインタでも良いが終了後に必ず閉じられる
     * @param array $options オプション配列。fgetcsv の第3引数以降もここで指定する
     * @return array 連想配列の配列
     */
    function csv_import($csvstring, $options = [])
    {
        $options += [
            'delimiter' => ',',
            'enclosure' => '"',
            'escape'    => '\\',
            'encoding'  => mb_internal_encoding(),
            'headers'   => [],
            'headermap' => null,
            'callback'  => null, // map + filter 用コールバック（1行が参照で渡ってくるので書き換えられる&&false を返すと結果から除かれる）
        ];

        // 文字キーを含む場合はヘッダーありの読み換えとなる
        if (is_array($options['headers']) && count(array_filter(array_keys($options['headers']), 'is_string')) > 0) {
            $options['headermap'] = $options['headers'];
            $options['headers'] = null;
        }

        if (is_resource($csvstring)) {
            $fp = $csvstring;
        }
        else {
            $fp = fopen('php://temp', 'r+b');
            fwrite($fp, $csvstring);
            rewind($fp);
        }

        try {
            return call_safely(function ($fp, $delimiter, $enclosure, $escape, $encoding, $headers, $headermap, $callback) {
                $mb_internal_encoding = mb_internal_encoding();
                $result = [];
                $n = -1;
                while ($row = fgetcsv($fp, 0, $delimiter, $enclosure, $escape)) {
                    if ($row === [null]) {
                        continue;
                    }
                    if ($mb_internal_encoding !== $encoding) {
                        mb_convert_variables($mb_internal_encoding, $encoding, $row);
                    }
                    if (!$headers) {
                        $headers = $row;
                        continue;
                    }

                    $n++;
                    $row = array_combine($headers, array_intersect_key($row, $headers));
                    if ($headermap) {
                        $row = array_pickup($row, $headermap);
                    }
                    if ($callback) {
                        if ($callback($row, $n) === false) {
                            continue;
                        }
                    }
                    $result[] = $row;
                }
                return $result;
            }, $fp, $options['delimiter'], $options['enclosure'], $options['escape'], $options['encoding'], $options['headers'], $options['headermap'], $options['callback']);
        }
        finally {
            fclose($fp);
        }
    }
}

const json_export = "json_export";
if (!isset($excluded_functions["json_export"]) && (!function_exists("json_export") || (!false && (new \ReflectionFunction("json_export"))->isInternal()))) {
    /**
     * json_encode のプロキシ関数
     *
     * 引数体系とデフォルト値を変更してある。また、エラー時に例外が飛ぶ。
     *
     * Example:
     * ```php
     * // オプションはこのように [定数 => bool] で渡す。false は指定されていないとみなされる（JSON_MAX_DEPTH 以外）
     * assertEquals(json_export(['a' => 'A', 'b' => 'B'], [
     *    JSON_PRETTY_PRINT => false,
     * ]), '{"a":"A","b":"B"}');
     * ```
     *
     * @param mixed $value encode する値
     * @param array $options JSON_*** をキーにした連想配列。 値が false は指定されていないとみなされる
     * @return string JSON 文字列
     */
    function json_export($value, $options = [])
    {
        $options += [
            JSON_UNESCAPED_UNICODE      => true, // エスケープなしで特にデメリットはない
            JSON_PRESERVE_ZERO_FRACTION => true, // 勝手に変換はできるだけ避けたい
        ];
        $depth = array_unset($options, JSON_MAX_DEPTH, 512);
        $option = array_sum(array_keys(array_filter($options)));

        // エラークリア関数が存在しないので null エンコードしてエラーを消しておく（分岐は不要かもしれない。ただ呼んだほうが速い？）
        if (json_last_error()) {
            json_encode(null);
        }

        $result = json_encode($value, $option, $depth);

        // エラーが出ていたら例外に変換
        if (json_last_error()) {
            throw new \ErrorException(json_last_error_msg(), json_last_error());
        }

        return $result;
    }
}

const json_import = "json_import";
if (!isset($excluded_functions["json_import"]) && (!function_exists("json_import") || (!false && (new \ReflectionFunction("json_import"))->isInternal()))) {
    /**
     * json_decode のプロキシ関数
     *
     * 引数体系とデフォルト値を変更してある。また、エラー時に例外が飛ぶ。
     *
     * Example:
     * ```php
     * // オプションはこのように [定数 => bool] で渡す。false は指定されていないとみなされる（JSON_MAX_DEPTH 以外）
     * assertEquals(json_import('{"a":"A","b":"B"}', [
     *    JSON_OBJECT_AS_ARRAY => true,
     * ]), ['a' => 'A', 'b' => 'B']);
     * ```
     *
     * @param string $value JSON 文字列
     * @param array $options JSON_*** をキーにした連想配列。 値が false は指定されていないとみなされる
     * @return mixed decode された値
     */
    function json_import($value, $options = [])
    {
        $options += [
            JSON_OBJECT_AS_ARRAY => true, // 個人的嗜好だが連想配列のほうが扱いやすい
        ];
        $depth = array_unset($options, JSON_MAX_DEPTH, 512);
        $option = array_sum(array_keys(array_filter($options)));

        // エラークリア関数が存在しないので null エンコードしてエラーを消しておく（分岐は不要かもしれない。ただ呼んだほうが速い？）
        if (json_last_error()) {
            json_encode(null);
        }

        $result = json_decode($value, $options[JSON_OBJECT_AS_ARRAY], $depth, $option);

        // エラーが出ていたら例外に変換
        if (json_last_error()) {
            throw new \ErrorException(json_last_error_msg(), json_last_error());
        }

        return $result;
    }
}

const markdown_table = "markdown_table";
if (!isset($excluded_functions["markdown_table"]) && (!function_exists("markdown_table") || (!false && (new \ReflectionFunction("markdown_table"))->isInternal()))) {
    /**
     * 連想配列の配列を markdown テーブル文字列にする
     *
     * 見出しはキーの和集合で生成され、改行は `<br>` に置換される。
     * 要素が全て数値の場合は右寄せになる。
     *
     * Example:
     * ```php
     * // 最初の "\n" に意味はない（ズレると見づらいので冒頭に足しているだけ）
     * assertEquals("\n" . markdown_table([
     *    ['a' => 'a1', 'b' => 'b1'],
     *    ['b' => 'b2', 'c' => '2'],
     *    ['a' => 'a3', 'c' => '3'],
     * ]), "
     * | a   | b   |   c |
     * | --- | --- | --: |
     * | a1  | b1  |     |
     * |     | b2  |   2 |
     * | a3  |     |   3 |
     * ");
     * ```
     *
     * @param array $array 連想配列の配列
     * @return string markdown テーブル文字列
     */
    function markdown_table($array)
    {
        if (!is_array($array) || is_empty($array)) {
            throw new \InvalidArgumentException('$array must be array of hasharray.');
        }

        $defaults = [];
        $numerics = [];
        $lengths = [];
        foreach ($array as $n => $fields) {
            assert(is_array($fields), '$array must be array of hasharray.');
            foreach ($fields as $k => $v) {
                $v = str_replace(["\r\n", "\r", "\n"], '<br>', $v);
                $array[$n][$k] = $v;
                $defaults[$k] = '';
                $numerics[$k] = ($numerics[$k] ?? true) && is_numeric($v);
                $lengths[$k] = max($lengths[$k] ?? 3, strlen($k), strlen($v)); // 3 は markdown の最低見出し長
            }
        }

        $linebuilder = function ($array, $padstr) use ($numerics, $lengths) {
            $line = [];
            foreach ($array as $k => $v) {
                $pad = str_pad($v, strlen($v) - mb_strwidth($v) + $lengths[$k], $padstr, $numerics[$k] ? STR_PAD_LEFT : STR_PAD_RIGHT);
                if ($padstr === '-' && $numerics[$k]) {
                    $pad[strlen($pad) - 1] = ':';
                }
                $line[] = $pad;
            }
            return '| ' . implode(' | ', $line) . ' |';
        };

        $result = [];

        $result[] = $linebuilder(array_combine($keys = array_keys($defaults), $keys), ' ');
        $result[] = $linebuilder($defaults, '-');
        foreach ($array as $fields) {
            $result[] = $linebuilder(array_replace($defaults, $fields), ' ');
        }

        return implode("\n", $result) . "\n";
    }
}

const markdown_list = "markdown_list";
if (!isset($excluded_functions["markdown_list"]) && (!function_exists("markdown_list") || (!false && (new \ReflectionFunction("markdown_list"))->isInternal()))) {
    /**
     * 配列を markdown リスト文字列にする
     *
     * Example:
     * ```php
     * // 最初の "\n" に意味はない（ズレると見づらいので冒頭に足しているだけ）
     * assertEquals("\n" . markdown_list([
     *     'dict'        => [
     *         'Key1' => 'Value1',
     *         'Key2' => 'Value2',
     *     ],
     *     'list'        => ['Item1', 'Item2', 'Item3'],
     *     'dict & list' => [
     *         'Key' => 'Value',
     *         ['Item1', 'Item2', 'Item3'],
     *     ],
     * ], ['separator' => ':']), "
     * - dict:
     *     - Key1:Value1
     *     - Key2:Value2
     * - list:
     *     - Item1
     *     - Item2
     *     - Item3
     * - dict & list:
     *     - Key:Value
     *         - Item1
     *         - Item2
     *         - Item3
     * ");
     * ```
     *
     * @param array $array 配列
     * @param array $option オプション配列
     * @return string markdown リスト文字列
     */
    function markdown_list($array, $option = [])
    {
        $option += [
            'indent'    => '    ',
            'separator' => ': ',
            'liststyle' => '-',
            'ordered'   => false,
        ];

        $f = function ($array, $nest) use (&$f, $option) {
            $spacer = str_repeat($option['indent'], $nest);
            $result = [];
            foreach (arrays($array) as $n => list($k, $v)) {
                if (is_iterable($v)) {
                    if (!is_int($k)) {
                        $result[] = $spacer . $option['liststyle'] . ' ' . $k . $option['separator'];
                    }
                    $result = array_merge($result, $f($v, $nest + 1));
                }
                else {
                    if (!is_int($k)) {
                        $result[] = $spacer . $option['liststyle'] . ' ' . $k . $option['separator'] . $v;
                    }
                    elseif (!$option['ordered']) {
                        $result[] = $spacer . $option['liststyle'] . ' ' . $v;
                    }
                    else {
                        $result[] = $spacer . ($n + 1) . '. ' . $v;
                    }
                }
            }
            return $result;
        };
        return implode("\n", $f($array, 0)) . "\n";
    }
}

const random_string = "random_string";
if (!isset($excluded_functions["random_string"]) && (!function_exists("random_string") || (!false && (new \ReflectionFunction("random_string"))->isInternal()))) {
    /**
     * 安全な乱数文字列を生成する
     *
     * @param int $length 生成文字列長
     * @param string $charlist 使用する文字セット
     * @return string 乱数文字列
     */
    function random_string($length = 8, $charlist = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        if ($length <= 0) {
            throw new \InvalidArgumentException('$length must be positive number.');
        }

        $charlength = strlen($charlist);
        if ($charlength === 0) {
            throw new \InvalidArgumentException('charlist is empty.');
        }

        $bytes = random_bytes($length);

        // 1文字1バイト使う。文字種によっては出現率に差が出るがう～ん
        $string = '';
        foreach (str_split($bytes) as $byte) {
            $string .= $charlist[ord($byte) % $charlength];
        }
        return $string;
    }
}

const kvsprintf = "kvsprintf";
if (!isset($excluded_functions["kvsprintf"]) && (!function_exists("kvsprintf") || (!false && (new \ReflectionFunction("kvsprintf"))->isInternal()))) {
    /**
     * 連想配列を指定できるようにした vsprintf
     *
     * sprintf の順序指定構文('%1$d')にキーを指定できる。
     *
     * Example:
     * ```php
     * assertSame(kvsprintf('%hoge$s %fuga$d', ['hoge' => 'ThisIs', 'fuga' => '3.14']), 'ThisIs 3');
     * ```
     *
     * @param string $format フォーマット文字列
     * @param array $array フォーマット引数
     * @return string フォーマットされた文字列
     */
    function kvsprintf($format, array $array)
    {
        $keys = array_flip(array_keys($array));
        $vals = array_values($array);

        $format = preg_replace_callback('#%%|%(.*?)\$#u', function ($m) use ($keys) {
            if (!isset($m[1])) {
                return $m[0];
            }

            $w = $m[1];
            if (!isset($keys[$w])) {
                throw new \OutOfBoundsException("kvsprintf(): Undefined index: $w");
            }

            return '%' . ($keys[$w] + 1) . '$';

        }, $format);

        return vsprintf($format, $vals);
    }
}

const preg_capture = "preg_capture";
if (!isset($excluded_functions["preg_capture"]) && (!function_exists("preg_capture") || (!false && (new \ReflectionFunction("preg_capture"))->isInternal()))) {
    /**
     * キャプチャを主軸においた preg_match
     *
     * $pattern で $subject をマッチングして $default で埋めて返す。$default はフィルタも兼ねる。
     * 空文字マッチは「マッチしていない」とみなすので注意（$default が使用される）。
     *
     * キャプチャを主軸においているので「マッチしなかった」は検出不可能。
     * $default がそのまま返ってくる。
     *
     * Example:
     * ```php
     * $pattern = '#(\d{4})/(\d{1,2})(/(\d{1,2}))?#';
     * $default = [1 => '2000', 2 => '1', 4 => '1'];
     * // 完全にマッチするのでそれぞれ返ってくる
     * assertSame(preg_capture($pattern, '2014/12/24', $default), [1 => '2014', 2 => '12', 4 => '24']);
     * // 最後の \d{1,2} はマッチしないのでデフォルト値が使われる
     * assertSame(preg_capture($pattern, '2014/12', $default), [1 => '2014', 2 => '12', 4 => '1']);
     * // 一切マッチしないので全てデフォルト値が使われる
     * assertSame(preg_capture($pattern, 'hoge', $default), [1 => '2000', 2 => '1', 4 => '1']);
     * ```
     *
     * @param string $pattern 正規表現
     * @param string $subject 対象文字列
     * @param array $default デフォルト値
     * @return array キャプチャした配列
     */
    function preg_capture($pattern, $subject, $default)
    {
        preg_match($pattern, $subject, $matches);

        foreach ($matches as $n => $match) {
            if (array_key_exists($n, $default) && strlen($match)) {
                $default[$n] = $match;
            }
        }

        return $default;
    }
}

const preg_splice = "preg_splice";
if (!isset($excluded_functions["preg_splice"]) && (!function_exists("preg_splice") || (!false && (new \ReflectionFunction("preg_splice"))->isInternal()))) {
    /**
     * キャプチャも行える preg_replace
     *
     * 「置換を行いつつ、キャプチャ文字列が欲しい」状況はまれによくあるはず。
     *
     * $replacement に callable を渡すと preg_replace_callback がコールされる。
     * callable とはいっても単純文字列 callble （"strtoupper" など）は callable とはみなされない。
     * 配列形式の callable や クロージャのみ preg_replace_callback になる。
     *
     * Example:
     * ```php
     * // 数字を除去しつつその除去された数字を得る
     * assertSame(preg_splice('#\\d+#', '', 'abc123', $m), 'abc');
     * assertSame($m, ['123']);
     *
     * // callable だと preg_replace_callback が呼ばれる
     * assertSame(preg_splice('#[a-z]+#', function($m){return strtoupper($m[0]);}, 'abc123', $m), 'ABC123');
     * assertSame($m, ['abc']);
     *
     * // ただし、 文字列 callable は文字列として扱う
     * assertSame(preg_splice('#[a-z]+#', 'strtoupper', 'abc123', $m), 'strtoupper123');
     * assertSame($m, ['abc']);
     * ```
     *
     * @param string $pattern 正規表現
     * @param string|callable $replacement 置換文字列
     * @param string $subject 対象文字列
     * @param array $matches キャプチャ配列が格納される
     * @return string 置換された文字列
     */
    function preg_splice($pattern, $replacement, $subject, &$matches = [])
    {
        if (preg_match($pattern, $subject, $matches)) {
            if (!is_string($replacement) && is_callable($replacement)) {
                $subject = preg_replace_callback($pattern, $replacement, $subject);
            }
            else {
                $subject = preg_replace($pattern, $replacement, $subject);
            }
        }
        return $subject;
    }
}

const preg_replaces = "preg_replaces";
if (!isset($excluded_functions["preg_replaces"]) && (!function_exists("preg_replaces") || (!false && (new \ReflectionFunction("preg_replaces"))->isInternal()))) {
    /**
     * パターン番号を指定して preg_replace する
     *
     * パターン番号を指定してそれのみを置換する。
     * 名前付きキャプチャを使用している場合はキーに文字列も使える。
     * 値にクロージャを渡した場合はコールバックされて置換される。
     *
     * $replacements に単一文字列を渡した場合、 `[1 => $replacements]` と等しくなる（第1キャプチャを置換）。
     *
     * Example:
     * ```php
     * // a と z に囲まれた数字を XXX に置換する
     * assertSame(preg_replaces('#a(\d+)z#', [1 => 'XXX'], 'a123z'), 'aXXXz');
     * // 名前付きキャプチャも指定できる
     * assertSame(preg_replaces('#a(?<digit>\d+)z#', ['digit' => 'XXX'], 'a123z'), 'aXXXz');
     * // クロージャを渡すと元文字列を引数としてコールバックされる
     * assertSame(preg_replaces('#a(?<digit>\d+)z#', ['digit' => function($src){return $src * 2;}], 'a123z'), 'a246z');
     * // 複合的なサンプル（a タグの href と target 属性を書き換える）
     * assertSame(preg_replaces('#<a\s+href="(?<href>.*)"\s+target="(?<target>.*)">#', [
     *     'href'   => function($href){return strtoupper($href);},
     *     'target' => function($target){return strtoupper($target);},
     * ], '<a href="hoge" target="fuga">inner text</a>'), '<a href="HOGE" target="FUGA">inner text</a>');
     * ```
     *
     * @param string $pattern 正規表現
     * @param array|string $replacements 置換文字列
     * @param string $subject 対象文字列
     * @param int $limit 置換回数
     * @param null $count 置換回数格納変数
     * @return string 置換された文字列
     */
    function preg_replaces($pattern, $replacements, $subject, $limit = -1, &$count = null)
    {
        $offset = 0;
        $count = 0;
        if (!is_arrayable($replacements)) {
            $replacements = [1 => $replacements];
        }

        preg_match_all($pattern, $subject, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
        foreach ($matches as $match) {
            if ($limit-- === 0) {
                break;
            }
            $count++;

            foreach ($match as $index => $m) {
                if ($m[1] >= 0 && $index !== 0 && isset($replacements[$index])) {
                    $src = $m[0];
                    $dst = $replacements[$index];
                    if ($dst instanceof \Closure) {
                        $dst = $dst($src);
                    }

                    $srclen = strlen($src);
                    $dstlen = strlen($dst);

                    $subject = substr_replace($subject, $dst, $offset + $m[1], $srclen);
                    $offset += $dstlen - $srclen;
                }
            }
        }
        return $subject;
    }
}

const damerau_levenshtein = "damerau_levenshtein";
if (!isset($excluded_functions["damerau_levenshtein"]) && (!function_exists("damerau_levenshtein") || (!false && (new \ReflectionFunction("damerau_levenshtein"))->isInternal()))) {
    /**
     * Damerau–Levenshtein 距離を返す
     *
     * 簡単に言えば「転置（入れ替え）を考慮したレーベンシュタイン」である。
     * 例えば "destroy" と "destory" は 「1挿入1削除=2」であるが、Damerau 版だと「1転置=1」となる。
     *
     * また、マルチバイト（UTF-8 のみ）にも対応している。
     *
     * Example:
     * ```php
     * // destroy と destory は普通にレーベンシュタイン距離を取ると 2 になるが・・・
     * assertSame(levenshtein("destroy", "destory"), 2);
     * // damerau_levenshtein だと1である
     * assertSame(damerau_levenshtein("destroy", "destory"), 1);
     * // UTF-8 でも大丈夫
     * assertSame(damerau_levenshtein("あいうえお", "あいえうお"), 1);
     * ```
     *
     * @param string $s1 対象文字列1
     * @param string $s2 対象文字列2
     * @param int $cost_ins 挿入のコスト
     * @param int $cost_rep 置換のコスト
     * @param int $cost_del 削除のコスト
     * @param int $cost_swp 転置のコスト
     * @return int Damerau–Levenshtein 距離
     */
    function damerau_levenshtein($s1, $s2, $cost_ins = 1, $cost_rep = 1, $cost_del = 1, $cost_swp = 1)
    {
        $s1 = is_array($s1) ? $s1 : preg_split('//u', $s1, -1, PREG_SPLIT_NO_EMPTY);
        $s2 = is_array($s2) ? $s2 : preg_split('//u', $s2, -1, PREG_SPLIT_NO_EMPTY);
        $l1 = count($s1);
        $l2 = count($s2);
        if (!$l1) {
            return $l2 * $cost_ins;
        }
        if (!$l2) {
            return $l1 * $cost_del;
        }
        $p1 = array_fill(0, $l2 + 1, 0);
        $p2 = array_fill(0, $l2 + 1, 0);
        for ($i2 = 0; $i2 <= $l2; $i2++) {
            $p1[$i2] = $i2 * $cost_ins;
        }
        for ($i1 = 0; $i1 < $l1; $i1++) {
            $p2[0] = $p1[0] + $cost_del;
            for ($i2 = 0; $i2 < $l2; $i2++) {
                $c0 = $p1[$i2];
                if ($s1[$i1] !== $s2[$i2]) {
                    if (
                        $cost_swp && (
                            ($s1[$i1] === ($s2[$i2 - 1] ?? '') && ($s1[$i1 - 1] ?? '') === $s2[$i2]) ||
                            ($s1[$i1] === ($s2[$i2 + 1] ?? '') && ($s1[$i1 + 1] ?? '') === $s2[$i2])
                        )
                    ) {
                        $c0 += $cost_swp / 2;
                    }
                    else {
                        $c0 += $cost_rep;
                    }
                }
                $c1 = $p1[$i2 + 1] + $cost_del;
                if ($c1 < $c0) {
                    $c0 = $c1;
                }
                $c2 = $p2[$i2] + $cost_ins;
                if ($c2 < $c0) {
                    $c0 = $c2;
                }
                $p2[$i2 + 1] = $c0;
            }
            $tmp = $p1;
            $p1 = $p2;
            $p2 = $tmp;
        }
        return (int) $p1[$l2];
    }
}

const str_guess = "str_guess";
if (!isset($excluded_functions["str_guess"]) && (!function_exists("str_guess") || (!false && (new \ReflectionFunction("str_guess"))->isInternal()))) {
    /**
     * $string に最も近い文字列を返す
     *
     * レーベンシュタイン比の最も小さい要素を返す。
     *
     * この関数の結果（内部実装）は互換性を考慮しない。
     * 例えば現在は damerau_levenshtein で実装されているが、 similar_text になる可能性もある。
     *
     * Example:
     * ```php
     * // 「あいうえお」と最も距離の近い文字列は「あいゆえに」である
     * assertSame(str_guess("あいうえお", [
     *     'かきくけこ', // マッチ度 0%（1文字もかすらない）
     *     'ぎぼあいこ', // マッチ度 0%（"あい"はあるが位置が異なる）
     *     'かとうあい', // マッチ度 20%（"う"の位置が等しい）
     *     'あいしてる', // マッチ度 40&（"あい"がマッチ）
     *     'あいゆえに', // マッチ度 60&（"あい", "え"がマッチ）
     * ]), 'あいゆえに');
     * ```
     *
     * @param string $string 調べる文字列
     * @param array $candidates 候補文字列配列
     * @param int $percent マッチ度（％）を受ける変数
     * @return string 最も近い文字列
     */
    function str_guess($string, $candidates, &$percent = null)
    {
        $candidates = array_filter(arrayval($candidates, false), 'strlen');
        if (!$candidates) {
            throw new \InvalidArgumentException('$candidates is empty.');
        }

        $sarray = preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);
        $closest = null;
        $shortest = PHP_INT_MAX;
        foreach ($candidates as $candidate) {
            $carray = preg_split('//u', $candidate, -1, PREG_SPLIT_NO_EMPTY);
            $delta = damerau_levenshtein($sarray, $carray) / max(count($sarray), count($carray));

            if ($delta < $shortest) {
                $closest = $candidate;
                $shortest = $delta;
            }

            if ($delta === 0) {
                break;
            }
        }

        $percent = intval(100 - $shortest * 100);

        return $closest;
    }
}

const str_array = "str_array";
if (!isset($excluded_functions["str_array"]) && (!function_exists("str_array") || (!false && (new \ReflectionFunction("str_array"))->isInternal()))) {
    /**
     * 文字列を区切り文字で区切って配列に変換する
     *
     * 典型的には http ヘッダとか sar の結果とかを配列にする。
     *
     * Example:
     * ```php
     * // http response header  を ":" 区切りで連想配列にする
     * assertSame(str_array("
     * HTTP/1.1 200 OK
     * Content-Type: text/html; charset=utf-8
     * Connection: Keep-Alive
     * ", ':', true), [
     *     'HTTP/1.1 200 OK',
     *     'Content-Type' => 'text/html; charset=utf-8',
     *     'Connection'   => 'Keep-Alive',
     * ]);
     *
     * // sar の結果を " " 区切りで連想配列の配列にする
     * assertSame(str_array("
     * 13:00:01        CPU     %user     %nice   %system   %iowait    %steal     %idle
     * 13:10:01        all      0.99      0.10      0.71      0.00      0.00     98.19
     * 13:20:01        all      0.60      0.10      0.56      0.00      0.00     98.74
     * ", ' ', false), [
     *     1 => [
     *         '13:00:01' => '13:10:01',
     *         'CPU'      => 'all',
     *         '%user'    => '0.99',
     *         '%nice'    => '0.10',
     *         '%system'  => '0.71',
     *         '%iowait'  => '0.00',
     *         '%steal'   => '0.00',
     *         '%idle'    => '98.19',
     *     ],
     *     2 => [
     *         '13:00:01' => '13:20:01',
     *         'CPU'      => 'all',
     *         '%user'    => '0.60',
     *         '%nice'    => '0.10',
     *         '%system'  => '0.56',
     *         '%iowait'  => '0.00',
     *         '%steal'   => '0.00',
     *         '%idle'    => '98.74',
     *     ],
     * ]);
     * ```
     *
     * @param string|array $string 対象文字列。配列を与えても動作する
     * @param string $delimiter 区切り文字
     * @param bool $hashmode 連想配列モードか
     * @return array 配列
     */
    function str_array($string, $delimiter, $hashmode)
    {
        $array = $string;
        if (is_stringable($string)) {
            $array = preg_split('#\R#u', $string, -1, PREG_SPLIT_NO_EMPTY);
        }
        $delimiter = preg_quote($delimiter, '#');

        $result = [];
        if ($hashmode) {
            foreach ($array as $n => $line) {
                $parts = preg_split("#$delimiter#u", $line, 2, PREG_SPLIT_NO_EMPTY);
                $key = isset($parts[1]) ? array_shift($parts) : $n;
                $result[trim($key)] = trim($parts[0]);
            }
        }
        else {
            foreach ($array as $n => $line) {
                $parts = preg_split("#$delimiter#u", $line, -1, PREG_SPLIT_NO_EMPTY);
                if (!isset($keys)) {
                    $keys = $parts;
                    continue;
                }
                $result[$n] = count($keys) === count($parts) ? array_combine($keys, $parts) : null;
            }
        }
        return $result;
    }
}

const mb_substr_replace = "mb_substr_replace";
if (!isset($excluded_functions["mb_substr_replace"]) && (!function_exists("mb_substr_replace") || (!false && (new \ReflectionFunction("mb_substr_replace"))->isInternal()))) {
    /**
     * マルチバイト対応 substr_replace
     *
     * 本家は配列を与えたりできるが、ややこしいし使う気がしないので未対応。
     *
     * Example:
     * ```php
     * // 2文字目から5文字を「あいうえお」に置換する
     * assertSame(mb_substr_replace('０１２３４５６７８９', 'あいうえお', 2, 5), '０１あいうえお７８９');
     * ```
     *
     * @param string $string 対象文字列
     * @param string $replacement 置換文字列
     * @param int $start 開始位置
     * @param int $length 置換長
     * @return string 置換した文字列
     */
    function mb_substr_replace($string, $replacement, $start, $length = null)
    {
        $string = (string) $string;

        $strlen = mb_strlen($string);
        if ($start < 0) {
            $start += $strlen;
        }
        if ($length < 0) {
            $length += $strlen - $start;
        }

        return mb_substr($string, 0, $start) . $replacement . mb_substr($string, $start + $length, null);
    }
}

const render_string = "render_string";
if (!isset($excluded_functions["render_string"]) && (!function_exists("render_string") || (!false && (new \ReflectionFunction("render_string"))->isInternal()))) {
    /**
     * "hoge {$hoge}" 形式のレンダリング
     *
     * 文字列を eval して "hoge {$hoge}" 形式の文字列に変数を埋め込む。
     * 基本処理は `eval("return '" . addslashes($template) . "';");` と考えて良いが、下記が異なる。
     *
     * - 数値キーが参照できる
     * - クロージャは呼び出し結果が埋め込まれる。引数は (変数配列, 自身のキー文字列)
     * - 引数をそのまま返すだけの特殊な変数 $_ が宣言される
     * - シングルクォートのエスケープは外される
     *
     * $_ が宣言されるのは変数配列に '_' を含んでいないときのみ（上書きを防止するため）。
     * この $_ は php の埋め込み変数の闇を利用するととんでもないことが出来たりする（サンプルやテストコードを参照）。
     *
     * ダブルクオートはエスケープされるので文字列からの脱出はできない。
     * また、 `{$_(syntax(""))}` のように {$_()} 構文で " も使えなくなるので \' を使用しなければならない。
     *
     * Example:
     * ```php
     * // 数値キーが参照できる
     * assertSame(render_string('${0}', ['number']), 'number');
     * // クロージャは呼び出し結果が埋め込まれる
     * assertSame(render_string('$c', ['c' => function($vars, $k){return $k . '-closure';}]), 'c-closure');
     * // 引数をそのまま返すだけの特殊な変数 $_ が宣言される
     * assertSame(render_string('{$_(123 + 456)}', []), '579');
     * // 要するに '$_()' の中に php の式が書けるようになる
     * assertSame(render_string('{$_(implode(\',\', $strs))}', ['strs' => ['a', 'n', 'z']]), 'a,n,z');
     * assertSame(render_string('{$_(max($nums))}', ['nums' => [1, 9, 3]]), '9');
     * ```
     *
     * @param string $template レンダリング文字列
     * @param array $array レンダリング変数
     * @return string レンダリングされた文字列
     */
    function render_string($template, $array)
    {
        // eval 可能な形式に変換
        $evalcode = 'return "' . addcslashes($template, "\"\\\0") . '";';

        // 利便性を高めるために変数配列を少しいじる
        $vars = [];
        foreach ($array as $k => $v) {
            // クロージャはその実行結果を埋め込む仕様
            if ($v instanceof \Closure) {
                $v = $v($array, $k);
            }
            $vars[$k] = $v;
        }
        // '_' はそのまま返すクロージャとする（キーがないときのみ）
        if (!array_key_exists('_', $vars)) {
            $vars['_'] = function ($v) { return $v; };
        }

        try {
            return (function () {
                // extract は数値キーを展開してくれないので自前ループで展開
                foreach (func_get_arg(1) as $k => $v) {
                    $$k = $v;
                }
                // 現スコープで宣言してしまっているので伏せなければならない
                unset($k, $v);
                // かと言って変数配列に k, v キーがあると使えなくなるので更に extract で補完
                extract(func_get_arg(1));
                // そして eval. ↑は要するに数値キーのみを展開している
                return eval(func_get_arg(0));
            })($evalcode, $vars);
        }
        catch (\ParseError $ex) {
            throw new \RuntimeException('failed to eval code.' . $evalcode, 0, $ex);
        }
    }
}

const render_file = "render_file";
if (!isset($excluded_functions["render_file"]) && (!function_exists("render_file") || (!false && (new \ReflectionFunction("render_file"))->isInternal()))) {
    /**
     * "hoge {$hoge}" 形式のレンダリングのファイル版
     *
     * @see render_string()
     *
     * @param string $template_file レンダリングするファイル名
     * @param array $array レンダリング変数
     * @return string レンダリングされた文字列
     */
    function render_file($template_file, $array)
    {
        return render_string(file_get_contents($template_file), $array);
    }
}

const ob_include = "ob_include";
if (!isset($excluded_functions["ob_include"]) && (!function_exists("ob_include") || (!false && (new \ReflectionFunction("ob_include"))->isInternal()))) {
    /**
     * 変数を extract して include する
     *
     * Example:
     * ```php
     * // このようなテンプレートファイルを用意すると
     * file_put_contents(sys_get_temp_dir() . '/template.php', '
     * This is plain text.
     * This is <?= $var ?>.
     * This is <?php echo strtoupper($var) ?>.
     * ');
     * // このようにレンダリングできる
     * assertSame(ob_include(sys_get_temp_dir() . '/template.php', ['var' => 'hoge']), '
     * This is plain text.
     * This is hoge.
     * This is HOGE.
     * ');
     * ```
     *
     * @param string $include_file include するファイル名
     * @param array $array extract される連想変数
     * @return string レンダリングされた文字列
     */
    function ob_include($include_file, $array = [])
    {
        return (static function () {
            ob_start();
            extract(func_get_arg(1));
            include func_get_arg(0);
            return ob_get_clean();
        })($include_file, $array);
    }
}

const include_string = "include_string";
if (!isset($excluded_functions["include_string"]) && (!function_exists("include_string") || (!false && (new \ReflectionFunction("include_string"))->isInternal()))) {
    /**
     * 変数を extract して include する（文字列指定）
     *
     * @see ob_include()
     *
     * @param string $template テンプレート文字列
     * @param array $array extract される連想変数
     * @return string レンダリングされた文字列
     */
    function include_string($template, $array = [])
    {
        // opcache が効かない気がする
        $path = memory_path(__FUNCTION__);
        file_put_contents($path, $template);
        $result = ob_include($path, $array);
        unlink($path);
        return $result;
    }
}

const parse_php = "parse_php";
if (!isset($excluded_functions["parse_php"]) && (!function_exists("parse_php") || (!false && (new \ReflectionFunction("parse_php"))->isInternal()))) {
    /**
     * php のコード断片をパースする
     *
     * 結果配列は token_get_all したものだが、「字句の場合に文字列で返す」仕様は適用されずすべて配列で返す。
     * つまり必ず `[TOKENID, TOKEN, LINE]` で返す。
     *
     * Example:
     * ```php
     * $phpcode = 'namespace Hogera;
     * class Example
     * {
     *     // something
     * }';
     *
     * // namespace ～ ; を取得
     * $part = parse_php($phpcode, [
     *     'begin' => T_NAMESPACE,
     *     'end'   => ';',
     * ]);
     * assertSame(implode('', array_column($part, 1)), 'namespace Hogera;');
     *
     * // class ～ { を取得
     * $part = parse_php($phpcode, [
     *     'begin' => T_CLASS,
     *     'end'   => '{',
     * ]);
     * assertSame(implode('', array_column($part, 1)), "class Example\n{");
     * ```
     *
     * @param string $phpcode パースする php コード
     * @param array|int $option パースオプション
     * @return array トークン配列
     */
    function parse_php($phpcode, $option = [])
    {
        if (is_int($option)) {
            $option = ['flags' => $option];
        }

        $default = [
            'begin'      => [],   // 開始トークン
            'end'        => [],   // 終了トークン
            'offset'     => 0,    // 開始トークン位置
            'flags'      => 0,    // token_get_all の $flags. TOKEN_PARSE を与えると ParseError が出ることがあるのでデフォルト 0
            'cache'      => true, // キャッシュするか否か
            'nest_token' => [
                ')' => '(',
                '}' => '{',
                ']' => '[',
            ],
        ];
        $option += $default;

        static $cache = [];
        if (!$option['cache'] || !isset($cache[$phpcode])) {
            // token_get_all の結果は微妙に扱いづらいので少し調整する（string/array だったり、名前変換の必要があったり）
            $cache[$phpcode] = array_map(function ($token) use ($option) {
                if (is_array($token)) {
                    // for debug
                    if ($option['flags'] & TOKEN_NAME) {
                        $token[] = token_name($token[0]);
                    }
                    return $token;
                }
                else {
                    // string -> [TOKEN, CHAR, LINE]
                    return [null, $token, 0];
                }
            }, token_get_all("<?php $phpcode", $option['flags']));
        }
        $tokens = $cache[$phpcode];

        $begin_tokens = (array) $option['begin'];
        $end_tokens = (array) $option['end'];
        $nest_tokens = $option['nest_token'];

        $result = [];
        $starting = !$begin_tokens;
        $nesting = 0;
        for ($i = $option['offset'], $l = count($tokens); $i < $l; $i++) {
            $token = $tokens[$i];

            foreach ($begin_tokens as $t) {
                if ($t === $token[0] || $t === $token[1]) {
                    $starting = true;
                    break;
                }
            }
            if (!$starting) {
                continue;
            }

            $result[] = $token;

            foreach ($end_tokens as $t) {
                if (isset($nest_tokens[$t])) {
                    $nest_token = $nest_tokens[$t];
                    if ($token[0] === $nest_token || $token[1] === $nest_token) {
                        $nesting++;
                    }
                }
                if ($t === $token[0] || $t === $token[1]) {
                    $nesting--;
                    if ($nesting <= 0) {
                        break 2;
                    }
                    break;
                }
            }
        }
        return $result;
    }
}

const returns = "returns";
if (!isset($excluded_functions["returns"]) && (!function_exists("returns") || (!false && (new \ReflectionFunction("returns"))->isInternal()))) {
    /**
     * 引数をそのまま返す
     *
     * clone などでそのまま返す関数が欲しいことがまれによくあるはず。
     *
     * Example:
     * ```php
     * $object = new \stdClass();
     * assertSame(returns($object), $object);
     * ```
     *
     * @param mixed $v return する値
     * @return mixed $v を返す
     */
    function returns($v)
    {
        return $v;
    }
}

const optional = "optional";
if (!isset($excluded_functions["optional"]) && (!function_exists("optional") || (!false && (new \ReflectionFunction("optional"))->isInternal()))) {
    /**
     * オブジェクトならそれを、オブジェクトでないなら NullObject を返す
     *
     * null を返すかもしれないステートメントを一時変数を介さずワンステートメントで呼ぶことが可能になる。
     *
     * NullObject は 基本的に null を返すが、return type が規約されている場合は null 以外を返すこともある。
     * 取得系呼び出しを想定しているので、設定系呼び出しは行うべきではない。
     * __set のような明らかに設定が意図されているものは例外が飛ぶ。
     *
     * Example:
     * ```php
     * // null を返すかもしれないステートメント
     * $getobject = function () {return null;};
     * // メソッド呼び出しは null を返す
     * assertSame(optional($getobject())->method(), null);
     * // プロパティアクセスは null を返す
     * assertSame(optional($getobject())->property, null);
     * // empty は true を返す
     * assertSame(empty(optional($getobject())->nothing), true);
     * // __isset は false を返す
     * assertSame(isset(optional($getobject())->nothing), false);
     * // __toString は '' を返す
     * assertSame(strval(optional($getobject())), '');
     * // __invoke は null を返す
     * assertSame(call_user_func(optional($getobject())), null);
     * // 配列アクセスは null を返す
     * assertSame($getobject()['hoge'], null);
     * // 空イテレータを返す
     * assertSame(iterator_to_array(optional($getobject())), []);
     *
     * // $expected を与えるとその型以外は NullObject を返す（\ArrayObject はオブジェクトだが stdClass ではない）
     * assertSame(optional(new \ArrayObject([1]), 'stdClass')->count(), null);
     * ```
     *
     * @param object|null $object オブジェクト
     * @param string $expected 期待するクラス名。指定した場合は is_a される
     * @return mixed $object がオブジェクトならそのまま返し、違うなら NullObject を返す
     */
    function optional($object, $expected = null)
    {
        if (is_object($object)) {
            if ($expected === null || is_a($object, $expected)) {
                return $object;
            }
        }

        static $nullobject = null;
        if ($nullobject === null) {
            $nullobject = new class implements \ArrayAccess, \IteratorAggregate
            {
                // @formatter:off
                public function __isset($name) { return false; }
                public function __get($name) { return null; }
                public function __set($name, $value) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function __unset($name) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function __call($name, $arguments) { return null; }
                public function __invoke() { return null; }
                public function __toString() { return ''; }
                public function offsetExists($offset) { return false; }
                public function offsetGet($offset) { return null; }
                public function offsetSet($offset, $value) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function offsetUnset($offset) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function getIterator() { return new \ArrayIterator([]); }
                // @formatter:on
            };
        }
        return $nullobject;
    }
}

const chain = "chain";
if (!isset($excluded_functions["chain"]) && (!function_exists("chain") || (!false && (new \ReflectionFunction("chain"))->isInternal()))) {
    /**
     * 関数をメソッドチェーンできるオブジェクトを返す
     *
     * ChainObject という関数をチェーンできるオブジェクトを返す。
     * ChainObject は大抵のグローバル関数がアノテーションされており、コード補完することが出来る（利便性のためであり、IDE がエラーなどを出しても呼び出し自体は可能）。
     * 呼び出しは「第1引数に現在の値が適用」されて実行される（下記の func1 コールで任意の位置に適用されることもできる）。
     *
     * 下記の特殊ルールにより、特殊な呼び出し方ができる。
     *
     * - array_XXX, str_XXX は省略して XXX で呼び出せる
     *   - 省略した結果、他の関数と被るようであれば短縮呼び出しは出来ない
     * - funcE で eval される文字列のクロージャを呼べる
     *   - 変数名は `$_` 固定だが、 `$_` が無いときに限り 最左に自動付与される
     * - funcP で配列指定オペレータのクロージャを呼べる
     *   - 複数指定した場合は順次呼ばれる。つまり map はともかく filter 用途では使えない
     * - func1 で「引数1（0 ベースなので要は2番目）に適用して func を呼び出す」ことができる
     *   - func2, func3 等も呼び出し可能
     * - 引数が1つの呼び出しは () を省略できる
     *
     * この特殊ルールは普通に使う分にはそこまで気にしなくて良い。
     * map や filter を駆使しようとすると必要になるが、イテレーション目的ではなく文字列のチェインなどが目的であればほぼ使うことはない。
     *
     * 特殊なメソッドとして下記がある。
     *
     * - apply($callback, ...$cbargs): 任意のコールバックを現在の値に適用する
     *
     * 上記を含むメソッド呼び出しはすべて自分自身を返すので、最終結果を得たい場合は `invoke` を実行する必要がある。
     * ただし、 IteratorAggregate が実装されているので、配列の場合に限り foreach で直接回すことができる。
     * さらに、 __toString も実装されているので、文字列的値の場合に限り自動で文字列化される。
     *
     * 用途は配列のイテレーションを想定しているが、あくまで「チェイン可能にする」が目的なので、ソースが文字列だろうとオブジェクトだろうと何でも呼び出しが可能。
     * ただし、遅延評価も最適化も何もしていないので、 chain するだけでも動作は相当遅くなることに注意。
     *
     * Example:
     * ```php
     * # 1～9 のうち「5以下を抽出」して「値を2倍」して「合計」を出すシチュエーション
     * $n1_9 = range(1, 9);
     * // 素の php で処理したもの。パッと見で何してるか分からないし、処理の順番が思考と逆なので混乱する
     * assertSame(array_sum(array_map(function ($v) { return $v * 2; }, array_filter($n1_9, function ($v) { return $v <= 5; }))), 30);
     * // chain でクロージャを渡したもの。処理の順番が思考どおりだが、 function(){} が微妙にうざい（array_ は省略できるので filter, map, sum のような呼び出しができている）
     * assertSame(chain($n1_9)->filter(function ($v) { return $v <= 5; })->map(function ($v) { return $v * 2; })->sum()(), 30);
     * // funcP を介して function(){} をなくしたもの。ここまで来ると若干読みやすい
     * assertSame(chain($n1_9)->filterP(['<=' => 5])->mapP(['*' => 2])->sum()(), 30);
     * // funcE を介したもの。かなり直感的だが eval なので少し不安
     * assertSame(chain($n1_9)->filterE('<= 5')->mapE('* 2')->sum()(), 30);
     *
     * # "hello   world" を「" " で分解」して「空文字を除去」してそれぞれに「ucfirst」して「"/" で結合」して「rot13」して「md5」して「大文字化」するシチュエーション
     * $string = 'hello   world';
     * // 素の php で処理したもの。もはやなにがなんだか分からない
     * assertSame(strtoupper(md5(str_rot13(implode('/', array_map('ucfirst', array_filter(explode(' ', $string))))))), '10AF4DAF67D0D666FCEA0A8C6EF57EE7');
     * // chain だとかなりそれっぽくできる。 explode/implode の第1引数は区切り文字なので func1 構文を使用している。また、 rot13 以降は引数がないので () を省略している
     * assertSame(chain($string)->explode1(' ')->filter()->map('ucfirst')->implode1('/')->rot13->md5->strtoupper()(), '10AF4DAF67D0D666FCEA0A8C6EF57EE7');
     *
     *  # よくある DB レコードをあれこれするシチュエーション
     * $co = chain([
     *     ['id' => 1, 'name' => 'hoge', 'sex' => 'F', 'age' => 17, 'salary' => 230000],
     *     ['id' => 3, 'name' => 'fuga', 'sex' => 'M', 'age' => 43, 'salary' => 480000],
     *     ['id' => 7, 'name' => 'piyo', 'sex' => 'M', 'age' => 21, 'salary' => 270000],
     *     ['id' => 9, 'name' => 'hage', 'sex' => 'F', 'age' => 30, 'salary' => 320000],
     * ]);
     * // e.g. 男性の平均給料
     * assertSame((clone $co)->whereP('sex', ['===' => 'M'])->column('salary')->mean()(), 375000);
     * // e.g. 女性の平均年齢
     * assertSame((clone $co)->whereE('sex', '=== "F"')->column('age')->mean()(), 23.5);
     * // e.g. 30歳以上の平均給料
     * assertSame((clone $co)->whereP('age', ['>=' => 30])->column('salary')->mean()(), 400000);
     * // e.g. 20～30歳の平均給料
     * assertSame((clone $co)->whereP('age', ['>=' => 20])->whereE('age', '<= 30')->column('salary')->mean()(), 295000);
     * // e.g. 男性の最小年齢
     * assertSame((clone $co)->whereP('sex', ['===' => 'M'])->column('age')->min()(), 21);
     * // e.g. 女性の最大給料
     * assertSame((clone $co)->whereE('sex', '=== "F"')->column('salary')->max()(), 320000);
     * ```
     *
     * @param mixed $source 元データ
     * @return \ChainObject
     */
    function chain($source)
    {
        return new class($source) implements \IteratorAggregate
        {
            private $data;

            public function __construct($source)
            {
                $this->data = $source;
            }

            public function __invoke()
            {
                return $this->data;
            }

            public function __get($name)
            {
                return $this->_apply($name, []);
            }

            public function __call($name, $arguments)
            {
                return $this->_apply($name, $arguments);
            }

            public function __toString()
            {
                return (string) $this->data;
            }

            public function getIterator()
            {
                foreach ($this->data as $k => $v) {
                    yield $k => $v;
                }
            }

            public function apply($callback, ...$args)
            {
                $this->data = $callback($this->data, ...$args);
                return $this;
            }

            private function _resolve($name)
            {
                if (false
                    || function_exists($fname = $name)
                    || function_exists($fname = "array_$name")
                    || function_exists($fname = "str_$name")
                    || (defined($cname = $name) && is_callable($fname = constant($cname)))
                    || (defined($cname = "array_$name") && is_callable($fname = constant($cname)))
                    || (defined($cname = "str_$name") && is_callable($fname = constant($cname)))
                    || (defined($cname = __NAMESPACE__ . "\\$name") && is_callable($fname = constant($cname)))
                    || (defined($cname = __NAMESPACE__ . "\\array_$name") && is_callable($fname = constant($cname)))
                    || (defined($cname = __NAMESPACE__ . "\\str_$name") && is_callable($fname = constant($cname)))
                ) {
                    /** @noinspection PhpUndefinedVariableInspection */
                    return $fname;
                }
            }

            private function _apply($name, $arguments)
            {
                // 特別扱い1: map は非常によく呼ぶので引数を補正する
                if ($name === 'map') {
                    /** @noinspection PhpUndefinedMethodInspection */
                    return $this->array_map1(...$arguments);
                }

                // 実際の呼び出し1: 存在する関数はそのまま移譲する
                if ($fname = $this->_resolve($name)) {
                    $this->data = $fname($this->data, ...$arguments);
                    return $this;
                }
                // 実際の呼び出し2: 数値で終わる呼び出しは引数埋め込み位置を指定して移譲する
                if (preg_match('#(.+?)(\d+)$#', $name, $match) && $fname = $this->_resolve($match[1])) {
                    $this->data = $fname(...array_insert($arguments, [$this->data], $match[2]));
                    return $this;
                }

                // 接尾呼び出し1: E で終わる呼び出しは文字列を eval した callback とする
                if (preg_match('#(.+?)E$#', $name, $match)) {
                    $expr = array_pop($arguments);
                    $expr = strpos($expr, '$_') === false ? '$_ ' . $expr : $expr;
                    $arguments[] = eval_func($expr, '_');
                    return $this->{$match[1]}(...$arguments);
                }
                // 接尾呼び出し2: P で終わる呼び出しは演算子を callback とする
                if (preg_match('#(.+?)P$#', $name, $match)) {
                    $ops = array_reverse((array) array_pop($arguments));
                    $arguments[] = function ($v) use ($ops) {
                        foreach ($ops as $ope => $rand) {
                            if (is_int($ope)) {
                                $ope = $rand;
                                $rand = [];
                            }
                            if (!is_array($rand)) {
                                $rand = [$rand];
                            }
                            $v = ope_func($ope)($v, ...$rand);
                        }
                        return $v;
                    };
                    return $this->{$match[1]}(...$arguments);
                }

                throw new \BadFunctionCallException("$name is not defined.");
            }
        };
    }
}

const throws = "throws";
if (!isset($excluded_functions["throws"]) && (!function_exists("throws") || (!false && (new \ReflectionFunction("throws"))->isInternal()))) {
    /**
     * throw の関数版
     *
     * hoge() or throw などしたいことがまれによくあるはず。
     *
     * Example:
     * ```php
     * try {
     *     throws(new \Exception('throws'));
     * }
     * catch (\Exception $ex) {
     *     assertSame($ex->getMessage(), 'throws');
     * }
     * ```
     *
     * @param \Exception $ex 投げる例外
     */
    function throws($ex)
    {
        throw $ex;
    }
}

const throw_if = "throw_if";
if (!isset($excluded_functions["throw_if"]) && (!function_exists("throw_if") || (!false && (new \ReflectionFunction("throw_if"))->isInternal()))) {
    /**
     * 条件付き throw
     *
     * 第1引数が true 相当のときに例外を投げる。
     *
     * Example:
     * ```php
     * // 投げない
     * throw_if(false, new \Exception());
     * // 投げる
     * try{throw_if(true, new \Exception());}catch(\Exception $ex){}
     * // クラス指定で投げる
     * try{throw_if(true, \Exception::class, 'message', 123);}catch(\Exception $ex){}
     * ```
     *
     * @param bool|mixed $flag true 相当値を与えると例外を投げる
     * @param \Exception|string $ex 投げる例外。クラス名の場合は中で new する
     * @param array $ex_args $ex にクラス名を与えたときの引数（可変引数）
     */
    function throw_if($flag, $ex, ...$ex_args)
    {
        if ($flag) {
            if (is_string($ex)) {
                $ex = new $ex(...$ex_args);
            }
            throw $ex;
        }
    }
}

const ifelse = "ifelse";
if (!isset($excluded_functions["ifelse"]) && (!function_exists("ifelse") || (!false && (new \ReflectionFunction("ifelse"))->isInternal()))) {
    /**
     * if ～ else 構文の関数版
     *
     * 一言で言えば `$actual === $expected ? $then : $else` という動作になる。
     * ただし、 $expected が callable の場合は呼び出した結果を緩い bool 判定する。
     * つまり `ifelse('hoge', 'is_string', true, false)` は常に true を返すので注意。
     *
     * ?? 演算子があれば大抵の状況で不要だが、=== null 限定ではなく 他の値で判定したい場合などには使える。
     *
     * Example:
     * ```php
     * // とても処理が遅い関数。これの返り値が「false ならばデフォルト値、でなければ自身値」という処理が下記のように書ける（一時変数が不要）
     * $heavyfunc = function($v){return $v;};
     * // $heavyfunc(1) ?? 'default' とほぼ同義
     * assertSame(ifelse($heavyfunc(1), false, 'default'), 1);
     * // $heavyfunc(null) ?? 'default' とほぼ同義…ではない。厳密な比較で false ではないので第1引数を返す
     * assertSame(ifelse($heavyfunc(null), false, 'default'), null);
     * // $heavyfunc(false) ?? 'default' とほぼ同義…ではない。厳密な比較で false なので 'default' を返す
     * assertSame(ifelse($heavyfunc(false), false, 'default'), 'default');
     * ```
     *
     * @param mixed $actual 調べる値（左辺値）
     * @param mixed $expected 比較する値（右辺値）
     * @param mixed $then 真の場合の値
     * @param mixed $else 偽の場合の値。省略時は $actual
     * @return mixed $then or $else
     */
    function ifelse($actual, $expected, $then, $else = null)
    {
        // $else 省略時は $actual を返す
        if (func_num_args() === 3) {
            $else = $actual;
        }

        if (is_callable($expected)) {
            return $expected($actual) ? $then : $else;
        }
        return $expected === $actual ? $then : $else;
    }
}

const switchs = "switchs";
if (!isset($excluded_functions["switchs"]) && (!function_exists("switchs") || (!false && (new \ReflectionFunction("switchs"))->isInternal()))) {
    /**
     * switch 構文の関数版
     *
     * case にクロージャを与えると実行して返す。
     * つまり、クロージャを返すことは出来ないので注意。
     *
     * $default を与えないとマッチしなかったときに例外を投げる。
     *
     * Example:
     * ```php
     * $cases = [
     *     1 => 'value is 1',
     *     2 => function(){return 'value is 2';},
     * ];
     * assertSame(switchs(1, $cases), 'value is 1');
     * assertSame(switchs(2, $cases), 'value is 2');
     * assertSame(switchs(3, $cases, 'undefined'), 'undefined');
     * ```
     *
     * @param mixed $value 調べる値
     * @param array $cases case 配列
     * @param null $default マッチしなかったときのデフォルト値。指定しないと例外
     * @return mixed
     */
    function switchs($value, $cases, $default = null)
    {
        if (!array_key_exists($value, $cases)) {
            if (func_num_args() === 2) {
                throw new \OutOfBoundsException("value $value is not defined in " . json_encode(array_keys($cases)));
            }
            return $default;
        }

        $case = $cases[$value];
        if ($case instanceof \Closure) {
            return $case($value);
        }
        return $case;
    }
}

const try_catch = "try_catch";
if (!isset($excluded_functions["try_catch"]) && (!function_exists("try_catch") || (!false && (new \ReflectionFunction("try_catch"))->isInternal()))) {
    /**
     * try ～ catch 構文の関数版
     *
     * 例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * // 例外が飛ばない場合は平和極まりない
     * $try = function($a, $b, $c){return [$a, $b, $c];};
     * assertSame(try_catch($try, null, 1, 2, 3), [1, 2, 3]);
     * // 例外が飛ぶ場合は特殊なことをしなければ例外オブジェクトが返ってくる
     * $try = function(){throw new \Exception('tried');};
     * assertSame(try_catch($try)->getMessage(), 'tried');
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param callable $catch catch ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    function try_catch($try, $catch = null, ...$variadic)
    {
        return try_catch_finally($try, $catch, null, ...$variadic);
    }
}

const try_finally = "try_finally";
if (!isset($excluded_functions["try_finally"]) && (!function_exists("try_finally") || (!false && (new \ReflectionFunction("try_finally"))->isInternal()))) {
    /**
     * try ～ finally 構文の関数版
     *
     * 例外は投げっぱなす。例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * $finally_count = 0;
     * $finally = function()use(&$finally_count){$finally_count++;};
     * // 例外が飛ぼうと飛ぶまいと $finally は実行される
     * $try = function($a, $b, $c){return [$a, $b, $c];};
     * assertSame(try_finally($try, $finally, 1, 2, 3), [1, 2, 3]);
     * assertSame($finally_count, 1); // 呼ばれている
     * // 例外は投げっぱなすが、 $finally は実行される
     * $try = function(){throw new \Exception('tried');};
     * try {try_finally($try, $finally, 1, 2, 3);} catch(\Exception $e){};
     * assertSame($finally_count, 2); // 呼ばれている
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param callable $finally finally ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    function try_finally($try, $finally = null, ...$variadic)
    {
        return try_catch_finally($try, throws, $finally, ...$variadic);
    }
}

const try_catch_finally = "try_catch_finally";
if (!isset($excluded_functions["try_catch_finally"]) && (!function_exists("try_catch_finally") || (!false && (new \ReflectionFunction("try_catch_finally"))->isInternal()))) {
    /**
     * try ～ catch ～ finally 構文の関数版
     *
     * 例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * $finally_count = 0;
     * $finally = function()use(&$finally_count){$finally_count++;};
     * // 例外が飛ぼうと飛ぶまいと $finally は実行される
     * $try = function($a, $b, $c){return [$a, $b, $c];};
     * assertSame(try_catch_finally($try, null, $finally, 1, 2, 3), [1, 2, 3]);
     * assertSame($finally_count, 1); // 呼ばれている
     * // 例外を投げるが、 $catch で握りつぶす
     * $try = function(){throw new \Exception('tried');};
     * assertSame(try_catch_finally($try, null, $finally, 1, 2, 3)->getMessage(), 'tried');
     * assertSame($finally_count, 2); // 呼ばれている
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param callable $catch catch ブロッククロージャ
     * @param callable $finally finally ブロッククロージャ
     * @param array $variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    function try_catch_finally($try, $catch = null, $finally = null, ...$variadic)
    {
        if ($catch === null) {
            $catch = function ($v) { return $v; };
        }

        try {
            return $try(...$variadic);
        }
        catch (\Exception $tried_ex) {
            try {
                return $catch($tried_ex);
            }
            catch (\Exception $catched_ex) {
                throw $catched_ex;
            }
        }
        finally {
            if ($finally !== null) {
                $finally();
            }
        }
    }
}

const date_interval = "date_interval";
if (!isset($excluded_functions["date_interval"]) && (!function_exists("date_interval") || (!false && (new \ReflectionFunction("date_interval"))->isInternal()))) {
    /**
     * 秒を世紀・年・月・日・時間・分・秒・ミリ秒の各要素に分解する
     *
     * 例えば `60 * 60 * 24 * 900 + 12345.678` （約900日12345秒）は・・・
     *
     * - 2 年（約900日なので）
     * - 5 ヶ月（約(900 - 365 * 2 = 170)日なので）
     * - 18 日（約(170 - 30.416 * 5 = 18)日なので）
     * - 3 時間（約12345秒なので）
     * - 25 分（約(12345 - 3600 * 3 = 1545)秒なので）
     * - 45 秒（約(1545 - 60 * 25 = 45)秒なので）
     * - 678 ミリ秒（.678 部分そのまま）
     *
     * となる（年はうるう年未考慮で365日、月は30.41666666日で換算）。
     *
     * $format を与えると DateInterval::format して文字列で返す。与えないと DateInterval をそのまま返す。
     * $format はクロージャを与えることができる。クロージャを与えた場合、各要素を引数としてコールバックされる。
     * $format は配列で与えることができる。配列で与えた場合、 0 になる要素は省かれる。
     * セパレータを与えたり、pre/suffix を与えたりできるが、難解なので省略する。
     *
     * $limit_type で換算のリミットを指定できる。例えば 'y' を指定すると「2年5ヶ月」となるが、 'm' を指定すると「29ヶ月」となる。
     * 数値を与えるとその範囲でオートスケールする。例えば 3 を指定すると値が大きいとき `ymd` の表示になり、年が 0 になると `mdh` の表示に切り替わるようになる。
     *
     * Example:
     * ```php
     * // 書式文字列指定（%vはミリ秒）
     * assertSame(date_interval(60 * 60 * 24 * 900 + 12345.678, '%Y/%M/%D %H:%I:%S.%v'), '02/05/18 03:25:45.678');
     *
     * // 書式にクロージャを与えるとコールバックされる（引数はスケールの小さい方から）
     * assertSame(date_interval(60 * 60 * 24 * 900 + 12345.678, function(){return implode(',', func_get_args());}), '678,45,25,3,18,5,2,0');
     *
     * // リミットを指定（month までしか計算しないので year は 0 になり month は 29になる）
     * assertSame(date_interval(60 * 60 * 24 * 900 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'm'), '00/29/18 03:25:45.678');
     *
     * // 書式に配列を与えてリミットに数値を与えるとその範囲でオートスケールする
     * $format = [
     *     'y' => '%y年',
     *     'm' => '%mヶ月',
     *     'd' => '%d日',
     *     ' ',
     *     'h' => '%h時間',
     *     'i' => '%i分',
     *     's' => '%s秒',
     * ];
     * // 数が大きいので年・月・日の3要素のみ
     * assertSame(date_interval(60 * 60 * 24 * 900 + 12345, $format, 3), '2年5ヶ月18日');
     * // 数がそこそこだと日・時間・分の3要素に切り替わる
     * assertSame(date_interval(60 * 60 * 24 * 20 + 12345, $format, 3), '20日 3時間25分');
     * // どんなに数が小さくても3要素以下にはならない
     * assertSame(date_interval(1234, $format, 3), '0時間20分34秒');
     *
     * // 書式指定なし（DateInterval を返す）
     * assertInstanceOf(\DateInterval::class, date_interval(123.456));
     * ```
     *
     * @param int|float $sec タイムスタンプ
     * @param string|array $format 時刻フォーマット
     * @param string|int $limit_type どこまで換算するか（[c|y|m|d|h|i|s]）
     * @return string|\DateInterval 時間差文字列 or DateInterval オブジェクト
     */
    function date_interval($sec, $format = null, $limit_type = 'y')
    {
        $ymdhisv = ['c', 'y', 'm', 'd', 'h', 'i', 's', 'v'];
        $map = ['c' => 7, 'y' => 6, 'm' => 5, 'd' => 4, 'h' => 3, 'i' => 2, 's' => 1];
        if (ctype_digit("$limit_type")) {
            $limit = $map['c'];
            $limit_type = (int) $limit_type;
            if (!is_array($format) && !is_null($format)) {
                throw new \UnexpectedValueException('$format must be array if $limit_type is digit.');
            }
        }
        else {
            $limit = $map[$limit_type] ?? throws(new \InvalidArgumentException("limit_type:$limit_type is undefined."));
        }

        // 各単位を導出
        $mills = $sec * 1000;
        $seconds = $sec;
        $minutes = $seconds / 60;
        $hours = $minutes / 60;
        $days = $hours / 24;
        $months = $days / (365 / 12);
        $years = $days / 365;
        $centurys = $years / 100;

        // $limit に従って値を切り捨てて DateInterval を作成
        /** @noinspection PhpUndefinedFieldInspection */
        {
            $interval = new \DateInterval('PT1S');
            $interval->c = $limit < $map['c'] ? 0 : $centurys % 1000;
            $interval->y = $limit < $map['y'] ? 0 : ($limit === $map['y'] ? $years : $years % 100);
            $interval->m = $limit < $map['m'] ? 0 : ($limit === $map['m'] ? $months : $months % 12);
            $interval->d = $limit < $map['d'] ? 0 : ($limit === $map['d'] ? $days : intval(($days * 100000000) % (365 / 12 * 100000000) / 100000000));
            $interval->h = $limit < $map['h'] ? 0 : ($limit === $map['h'] ? $hours : $hours % 24);
            $interval->i = $limit < $map['i'] ? 0 : ($limit === $map['i'] ? $minutes : $minutes % 60);
            $interval->s = $limit < $map['s'] ? 0 : ($limit === $map['s'] ? $seconds : $seconds % 60);
            $interval->v = $mills % 1000;
        }

        // null は DateInterval をそのまま返す
        if ($format === null) {
            return $interval;
        }

        // クロージャはコールバックする
        if ($format instanceof \Closure) {
            /** @noinspection PhpUndefinedFieldInspection */
            return $format($interval->v, $interval->s, $interval->i, $interval->h, $interval->d, $interval->m, $interval->y, $interval->c);
        }

        // 配列はいろいろとフィルタする
        if (is_array($format)) {
            // 数値ならその範囲でオートスケール
            if (is_int($limit_type)) {
                // 配列を回して値があるやつ + $limit_type の範囲とする
                foreach ($ymdhisv as $n => $key) {
                    // 最低 $limit_type は保持するために isset する
                    if ($interval->$key > 0 || !isset($ymdhisv[$n + $limit_type + 1])) {
                        $pos = [];
                        for ($i = 0; $i < $limit_type; $i++) {
                            if (isset($ymdhisv[$n + $i])) {
                                if (($p = array_pos_key($format, $ymdhisv[$n + $i], -1)) >= 0) {
                                    $pos[] = $p;
                                }
                            }
                        }
                        if (!$pos) {
                            throw new \UnexpectedValueException('$format is empty.');
                        }
                        // 順不同なので min/max から slice しなければならない
                        $min = min($pos);
                        $max = max($pos);
                        $format = array_slice($format, $min, $max - $min + 1);
                        break;
                    }
                }
            }

            // 来ている $format を正規化（日時文字列は配列にするかつ値がないならフィルタ）
            $tmp = [];
            foreach ($format as $key => $fmt) {
                if (isset($interval->$key)) {
                    if (!is_int($limit_type) && $interval->$key === 0) {
                        $tmp[] = ['', '', ''];
                        continue;
                    }
                    $fmt = arrayize($fmt);
                    $fmt = switchs(count($fmt), [
                        1 => static function () use ($fmt) { return ['', $fmt[0], '']; },
                        2 => static function () use ($fmt) { return ['', $fmt[0], $fmt[1]]; },
                        3 => static function () use ($fmt) { return array_values($fmt); },
                    ]);
                }
                $tmp[] = $fmt;
            }
            // さらに前後の値がないならフィルタ
            $tmp2 = [];
            foreach ($tmp as $n => $fmt) {
                $prevempty = true;
                for ($i = $n - 1; $i >= 0; $i--) {
                    if (!is_array($tmp[$i])) {
                        break;
                    }
                    if (strlen($tmp[$i][1])) {
                        $prevempty = false;
                        break;
                    }
                }
                $nextempty = true;
                for ($i = $n + 1, $l = count($tmp); $i < $l; $i++) {
                    if (!is_array($tmp[$i])) {
                        break;
                    }
                    if (strlen($tmp[$i][1])) {
                        $nextempty = false;
                        break;
                    }
                }

                if (is_array($fmt)) {
                    if ($prevempty) {
                        $fmt[0] = '';
                    }
                    if ($nextempty) {
                        $fmt[2] = '';
                    }
                }
                elseif ($prevempty || $nextempty) {
                    $fmt = '';
                }
                $tmp2 = array_merge($tmp2, arrayize($fmt));
            }
            $format = implode('', $tmp2);
        }

        /** @noinspection PhpUndefinedFieldInspection */
        {
            $format = preg_replace('#(^|[^%])%c#u', '${1}' . $interval->c, $format);
            $format = preg_replace('#(^|[^%])%v#u', '${1}' . $interval->v, $format);
        }
        return $interval->format($format);
    }
}

const get_uploaded_files = "get_uploaded_files";
if (!isset($excluded_functions["get_uploaded_files"]) && (!function_exists("get_uploaded_files") || (!false && (new \ReflectionFunction("get_uploaded_files"))->isInternal()))) {
    /**
     * $_FILES の構造を組み替えて $_POST などと同じにする
     *
     * $_FILES の配列構造はバグとしか思えないのでそれを是正する関数。
     * 第1引数 $files は指定可能だが、大抵は $_FILES であり、指定するのはテスト用。
     *
     * サンプルを書くと長くなるので例は{@source \ryunosuke\Test\Package\UtilityTest::test_get_uploaded_files() テストファイル}を参照。
     *
     * @param array $files $_FILES の同じ構造の配列。省略時は $_FILES
     * @return array $_FILES を $_POST などと同じ構造にした配列
     */
    function get_uploaded_files($files = null)
    {
        $result = [];
        foreach (($files ?: $_FILES) as $name => $file) {
            if (is_array($file['name'])) {
                $file = get_uploaded_files(array_each($file['name'], function (&$carry, $dummy, $subkey) use ($file) {
                    $carry[$subkey] = array_lookup($file, $subkey);
                }, []));
            }
            $result[$name] = $file;
        }
        return $result;
    }
}

const cachedir = "cachedir";
if (!isset($excluded_functions["cachedir"]) && (!function_exists("cachedir") || (!false && (new \ReflectionFunction("cachedir"))->isInternal()))) {
    /**
     * 本ライブラリで使用するキャッシュディレクトリを設定する
     *
     * @param string|null $dirname キャッシュディレクトリ。省略時は返すのみ
     * @return string 設定前のキャッシュディレクトリ
     */
    function cachedir($dirname = null)
    {
        static $cachedir;
        if ($dirname === null) {
            return $cachedir = $cachedir ?? sys_get_temp_dir();
        }

        if (!file_exists($dirname)) {
            @mkdir($dirname, 0777 & (~umask()), true);
        }
        $result = $cachedir;
        $cachedir = realpath($dirname);
        return $result;
    }
}

const cache = "cache";
if (!isset($excluded_functions["cache"]) && (!function_exists("cache") || (!false && (new \ReflectionFunction("cache"))->isInternal()))) {
    /**
     * シンプルにキャッシュする
     *
     * この関数は get/set/delete を兼ねる。
     * キャッシュがある場合はそれを返し、ない場合は $provider を呼び出してその結果をキャッシュしつつそれを返す。
     *
     * $provider に null を与えるとキャッシュの削除となる。
     *
     * Example:
     * ```php
     * $provider = function(){return rand();};
     * // 乱数を返す処理だが、キャッシュされるので同じ値になる
     * $rand1 = cache('rand', $provider);
     * $rand2 = cache('rand', $provider);
     * assertSame($rand1, $rand2);
     * // $provider に null を与えると削除される
     * cache('rand', null);
     * $rand3 = cache('rand', $provider);
     * assertNotSame($rand1, $rand3);
     * ```
     *
     * @param string $key キャッシュのキー
     * @param callable $provider キャッシュがない場合にコールされる callable
     * @param string $namespace 名前空間
     * @return mixed キャッシュ
     */
    function cache($key, $provider, $namespace = null)
    {
        static $cacheobject;
        $cacheobject = $cacheobject ?? new class(cachedir())
            {
                const CACHE_EXT = '.php-cache';

                /** @var string キャッシュディレクトリ */
                private $cachedir;

                /** @var array 内部キャッシュ */
                private $cache;

                /** @var array 変更感知配列 */
                private $changed;

                public function __construct($cachedir)
                {
                    $this->cachedir = $cachedir;
                    $this->cache = [];
                    $this->changed = [];
                }

                public function __destruct()
                {
                    // 変更されているもののみ保存
                    foreach ($this->changed as $namespace => $dummy) {
                        $filepath = $this->cachedir . '/' . rawurlencode($namespace) . self::CACHE_EXT;
                        $content = "<?php\nreturn " . var_export($this->cache[$namespace], true) . ";\n";

                        $temppath = tempnam(sys_get_temp_dir(), 'cache');
                        if (file_put_contents($temppath, $content) !== false) {
                            @chmod($temppath, 0644);
                            if (!@rename($temppath, $filepath)) {
                                @unlink($temppath);
                            }
                        }
                    }
                }

                public function has($namespace, $key)
                {
                    // ファイルから読み込む必要があるので get しておく
                    $this->get($namespace, $key);
                    return array_key_exists($key, $this->cache[$namespace]);
                }

                public function get($namespace, $key)
                {
                    // 名前空間自体がないなら作る or 読む
                    if (!isset($this->cache[$namespace])) {
                        $nsarray = [];
                        $cachpath = $this->cachedir . '/' . rawurldecode($namespace) . self::CACHE_EXT;
                        if (file_exists($cachpath)) {
                            $nsarray = require $cachpath;
                        }
                        $this->cache[$namespace] = $nsarray;
                    }

                    return $this->cache[$namespace][$key] ?? null;
                }

                public function set($namespace, $key, $value)
                {
                    // 新しい値が来たら変更フラグを立てる
                    if (!isset($this->cache[$namespace]) || !array_key_exists($key, $this->cache[$namespace]) || $this->cache[$namespace][$key] !== $value) {
                        $this->changed[$namespace] = true;
                    }

                    $this->cache[$namespace][$key] = $value;
                }

                public function delete($namespace, $key)
                {
                    $this->changed[$namespace] = true;
                    unset($this->cache[$namespace][$key]);
                }

                public function clear()
                {
                    // インメモリ情報をクリアして・・・
                    $this->cache = [];
                    $this->changed = [];

                    // ファイルも消す
                    if ($this->cachedir !== null) {
                        foreach (glob($this->cachedir . '/*' . self::CACHE_EXT) as $file) {
                            unlink($file);
                        }
                    }
                }
            };

        // flush (for test)
        if ($key === null) {
            $cacheobject = null;
            return;
        }

        $namespace = $namespace ?? __FILE__;

        $exist = $cacheobject->has($namespace, $key);
        if ($provider === null) {
            $cacheobject->delete($namespace, $key);
            return $exist;
        }
        if (!$exist) {
            $cacheobject->set($namespace, $key, $provider());
        }
        return $cacheobject->get($namespace, $key);
    }
}

const process = "process";
if (!isset($excluded_functions["process"]) && (!function_exists("process") || (!false && (new \ReflectionFunction("process"))->isInternal()))) {
    /**
     * proc_open ～ proc_close の一連の処理を行う
     *
     * 標準入出力は受け渡しできるが、決め打ち実装なのでいわゆる対話型なプロセスは起動できない。
     *
     * Example:
     * ```php
     * // サンプル実行用ファイルを用意
     * $phpfile = sys_get_temp_dir() . '/rf-sample.php';
     * file_put_contents($phpfile, "<?php
     *     fwrite(STDOUT, fgets(STDIN));
     *     fwrite(STDERR, 'err');
     *     exit((int) ini_get('max_file_uploads'));
     * ");
     * // 引数と標準入出力エラーを使った単純な例
     * $rc = process(PHP_BINARY, [
     *     '-d' => 'max_file_uploads=123',
     *     $phpfile,
     * ], 'out', $stdout, $stderr);
     * assertSame($rc, 123); // -d で与えた max_file_uploads で exit してるので 123
     * assertSame($stdout, 'out'); // 標準出力に標準入力を書き込んでいるので "out" が格納される
     * assertSame($stderr, 'err'); // 標準エラーに書き込んでいるので "err" が格納される
     * ```
     *
     * @param string $command 実行コマンド。escapeshellcmd される
     * @param array|string $args コマンドライン引数。文字列はそのまま結合される。配列は escapeshellarg された上でキーと結合される
     * @param string $stdin 標準入力
     * @param string $stdout 標準出力（参照渡しで格納される）
     * @param string $stderr 標準エラー（参照渡しで格納される）
     * @param string $cwd 作業ディレクトリ
     * @param array $env 環境変数
     * @return int リターンコード
     */
    function process($command, $args = [], $stdin = '', &$stdout = '', &$stderr = '', $cwd = null, array $env = null)
    {
        $ecommand = escapeshellcmd($command);

        if (is_array($args)) {
            $args = array_sprintf($args, function ($v, $k) {
                $ev = escapeshellarg($v);
                return is_int($k) ? $ev : "$k $ev";
            }, ' ');
        }

        $proc = proc_open("$ecommand $args", [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ], $pipes, $cwd, $env);

        if ($proc === false) {
            // どうしたら失敗するのかわからない
            throw new \RuntimeException("$command start failed."); // @codeCoverageIgnore
        }

        fwrite($pipes[0], $stdin);
        fclose($pipes[0]);

        stream_set_blocking($pipes[1], false);
        stream_set_blocking($pipes[2], false);

        $stdout = $stderr = '';
        while (feof($pipes[1]) === false || feof($pipes[2]) === false) {
            $read = [$pipes[1], $pipes[2]];
            $write = $except = null;
            if (stream_select($read, $write, $except, 1) === false) {
                // （システムコールが別のシグナルによって中断された場合などに起こりえます）
                // @codeCoverageIgnoreStart
                fclose($pipes[1]);
                fclose($pipes[2]);
                proc_close($proc);
                throw new \RuntimeException('stream_select failed.');
                // @codeCoverageIgnoreEnd
            }
            foreach ($read as $fp) {
                if ($fp === $pipes[1]) {
                    $stdout .= fread($fp, 1024);
                }
                elseif ($fp === $pipes[2]) {
                    $stderr .= fread($fp, 1024);
                }
            }
        }

        fclose($pipes[1]);
        fclose($pipes[2]);
        $rc = proc_close($proc);
        if ($rc === -1) {
            // どうしたら失敗するのかわからない
            throw new \RuntimeException("$command exit failed."); // @codeCoverageIgnore
        }
        return $rc;
    }
}

const arguments = "arguments";
if (!isset($excluded_functions["arguments"]) && (!function_exists("arguments") || (!false && (new \ReflectionFunction("arguments"))->isInternal()))) {
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
     * assertSame(arguments($rule, '--opt optval arg1 -l longval'), [
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
     * assertSame(arguments($rule, '--opts o1 -ln arg1 -o o2 arg2 --opts o3'), [
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
     * assertSame(arguments($rule, '--long A -short B'), [
     *     '--long', // 明らかにオプション指定に見えるが、 long というオプションは定義されていないので引数として解釈される
     *     'A',      // 同上。long のオプション値に見えるが、ただの引数
     *     '-short', // 同上。short というオプションは定義されていない
     *     'B',      // 同上。short のオプション値に見えるが、ただの引数
     * ]);
     * ```
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
            list($longname, $shortname) = preg_split('#\s+#u', $name, -1, PREG_SPLIT_NO_EMPTY) + [1 => null];
            if ($shortname !== null) {
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
        $result = array_map(function ($v) { return $v === null ? false : $v; }, $optsdefaults);
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
                    if (!$opt['thrown'] && !isset($shortmap[$shortname])) {
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
}

const stacktrace = "stacktrace";
if (!isset($excluded_functions["stacktrace"]) && (!function_exists("stacktrace") || (!false && (new \ReflectionFunction("stacktrace"))->isInternal()))) {
    /**
     * スタックトレースを文字列で返す
     *
     * `(new \Exception())->getTraceAsString()` と実質的な役割は同じ。
     * ただし、 getTraceAsString は引数が Array になったりクラス名しか取れなかったり微妙に使い勝手が悪いのでもうちょっと情報量を増やしたもの。
     *
     * 第1引数 $traces はトレース的配列を受け取る（`(new \Exception())->getTrace()` とか）。
     * 未指定時は debug_backtrace() で採取する。
     *
     * 第2引数 $option は文字列化する際の設定を指定するが、あまり指定することはないはず。
     * 今のところ limit と format のみであり、かつこれらは比較的指定頻度が高いので配列オプションではなく直に渡すことが可能になっている。
     *
     * @param array $traces debug_backtrace 的な配列
     * @param int|string|array $option オプション
     * @return string トレース文字列
     */
    function stacktrace($traces = null, $option = ['format' => '%s:%s %s', 'limit' => 16])
    {
        if (is_int($option)) {
            $limit = $option;
            $format = '%s:%s %s';
        }
        elseif (is_string($option)) {
            $limit = 16;
            $format = $option;
        }
        else {
            $limit = $option['limit'] ?? 16;
            $format = $option['format'] ?? '%s:%s %s';
        }

        $stringify = function ($value) use ($limit) {
            // 再帰用クロージャ
            $export = function ($value, $nest = 0, $parents = []) use (&$export, $limit) {
                // 再帰を検出したら *RECURSION* とする（処理に関しては is_recursive のコメント参照）
                foreach ($parents as $parent) {
                    if ($parent === $value) {
                        return var_export('*RECURSION*', true);
                    }
                }
                // 配列は連想判定したり再帰したり色々
                if (is_array($value)) {
                    $parents[] = $value;
                    $flat = $value === array_values($value);
                    $kvl = [];
                    foreach ($value as $k => $v) {
                        if (count($kvl) >= $limit) {
                            $kvl[] = sprintf('...(more %d length)', count($value) - $limit);
                            break;
                        }
                        $kvl[] = ($flat ? '' : $k . ':') . $export($v, $nest + 1, $parents);
                    }
                    return ($flat ? '[' : '{') . implode(', ', $kvl) . ($flat ? ']' : '}');
                }
                // オブジェクトは単にプロパティを __set_state する文字列を出力する
                elseif (is_object($value)) {
                    $parents[] = $value;
                    return get_class($value) . $export(get_object_properties($value), $nest, $parents);
                }
                // 文字列は改行削除
                elseif (is_string($value)) {
                    $value = str_replace(["\r\n", "\r", "\n"], '\n', $value);
                    if (($strlen = strlen($value)) > $limit) {
                        $value = substr($value, 0, $limit) . sprintf('...(more %d length)', $strlen - $limit);
                    }
                    return '"' . addcslashes($value, "\"\0\\") . '"';
                }
                // それ以外は stringify
                else {
                    return stringify($value);
                }
            };

            return $export($value);
        };

        $traces = $traces ?? array_slice(debug_backtrace(), 1);
        $result = [];
        foreach ($traces as $i => $trace) {
            // メソッド内で関数定義して呼び出したりすると file が無いことがある（かなりレアケースなので無視する）
            if (!isset($trace['file'])) {
                continue;
            }

            $file = $trace['file'];
            $line = $trace['line'];
            if (strpos($trace['file'], "eval()'d code") !== false && ($traces[$i + 1]['function'] ?? '') === 'eval') {
                $file = $traces[$i + 1]['file'];
                $line = $traces[$i + 1]['line'] . "." . $trace['line'];
            }

            $callee = $trace['function'];
            if (isset($trace['type'])) {
                $callee = $trace['class'] . $trace['type'] . $callee;
            }
            $callee .= '(' . implode(', ', array_map($stringify, $trace['args'] ?? [])) . ')';

            $result[] = sprintf($format, $file, $line, $callee);
        }
        return implode("\n", $result);
    }
}

const backtrace = "backtrace";
if (!isset($excluded_functions["backtrace"]) && (!function_exists("backtrace") || (!false && (new \ReflectionFunction("backtrace"))->isInternal()))) {
    /**
     * 特定条件までのバックトレースを取得する
     *
     * 第2引数 $options を満たすトレース以降を返す。
     * $options は ['$trace の key' => "条件"] を渡す。
     * 条件は文字列かクロージャで、文字列の場合は緩い一致、クロージャの場合は true を返した場合にそれ以降を返す。
     *
     * Example:
     * ```php
     * function f001 () {return backtrace(0, ['function' => __NAMESPACE__ . '\\f002', 'limit' => 2]);}
     * function f002 () {return f001();}
     * function f003 () {return f002();}
     * $traces = f003();
     * // limit 指定してるので2個
     * assertCount(2, $traces);
     * // 「function が f002 以降」を返す
     * assertArraySubset([
     *     'function' => __NAMESPACE__ . '\\f002'
     * ], $traces[0]);
     * assertArraySubset([
     *     'function' => __NAMESPACE__ . '\\f003'
     * ], $traces[1]);
     * ```
     *
     * @param int $flags debug_backtrace の引数
     * @param array $options フィルタ条件
     * @return array バックトレース
     */
    function backtrace($flags = \DEBUG_BACKTRACE_PROVIDE_OBJECT, $options = [])
    {
        $result = [];
        $traces = debug_backtrace($flags);
        foreach ($traces as $n => $trace) {
            foreach ($options as $key => $val) {
                if (!isset($trace[$key])) {
                    continue;
                }

                if ($val instanceof \Closure) {
                    $break = $val($trace[$key]);
                }
                else {
                    $break = $trace[$key] == $val;
                }
                if ($break) {
                    $result = array_slice($traces, $n);
                    break 2;
                }
            }
        }

        // limit は特別扱いで千切り指定
        if (isset($options['limit'])) {
            $result = array_slice($result, 0, $options['limit']);
        }

        return $result;
    }
}

const error = "error";
if (!isset($excluded_functions["error"]) && (!function_exists("error") || (!false && (new \ReflectionFunction("error"))->isInternal()))) {
    /**
     * エラー出力する
     *
     * 第1引数 $message はそれらしく文字列化されて出力される。基本的にはあらゆる型を与えて良い。
     *
     * 第2引数 $destination で出力対象を指定する。省略すると error_log 設定に従う。
     * 文字列を与えるとファイル名とみなし、ファイルに追記される。
     * ファイルを開くが、**ファイルは閉じない**。閉じ処理は php の終了処理に身を任せる。
     * したがって閉じる必要がある場合はファイルポインタを渡す必要がある。
     *
     * @param string|mixed $message 出力メッセージ
     * @param resource|string|mixed $destination 出力先
     * @return int 書き込んだバイト数
     */
    function error($message, $destination = null)
    {
        static $persistences = [];

        $time = date('d-M-Y H:i:s e');
        $content = stringify($message);
        $location = '';
        if (!($message instanceof \Exception || $message instanceof \Throwable)) {
            foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) as $trace) {
                if (isset($trace['file'], $trace['line'])) {
                    $location = " in {$trace['file']} on line {$trace['line']}";
                    break;
                }
            }
        }
        $line = "[$time] PHP Log:  $content$location\n";

        if ($destination === null) {
            $destination = ini_get('error_log');
        }

        if ($destination === 'syslog') {
            syslog(LOG_INFO, $message);
            return strlen($line);
        }

        if (is_resource($destination)) {
            $fp = $destination;
        }
        elseif (is_string($destination)) {
            if (!isset($persistences[$destination])) {
                $persistences[$destination] = fopen($destination, 'a');
            }
            $fp = $persistences[$destination];
        }

        if (empty($fp)) {
            throw new \InvalidArgumentException('$destination must be resource or string.');
        }

        flock($fp, LOCK_EX);
        fwrite($fp, $line);
        flock($fp, LOCK_UN);

        return strlen($line);
    }
}

const timer = "timer";
if (!isset($excluded_functions["timer"]) && (!function_exists("timer") || (!false && (new \ReflectionFunction("timer"))->isInternal()))) {
    /**
     * 処理時間を計測する
     *
     * 第1引数 $callable を $count 回回してその処理時間を返す。
     *
     * Example:
     * ```php
     * // 0.01 秒を 10 回回すので 0.1 秒は超える
     * assertGreaterThan(0.1, timer(function(){usleep(10 * 1000);}, 10));
     * ```
     *
     * @param callable $callable 処理クロージャ
     * @param int $count ループ回数
     * @return float 処理時間
     */
    function timer(callable $callable, $count = 1)
    {
        $count = (int) $count;
        if ($count < 1) {
            throw new \InvalidArgumentException("\$count must be greater than 0 (specified $count).");
        }

        $t = microtime(true);
        for ($i = 0; $i < $count; $i++) {
            $callable();
        }
        return microtime(true) - $t;
    }
}

const benchmark = "benchmark";
if (!isset($excluded_functions["benchmark"]) && (!function_exists("benchmark") || (!false && (new \ReflectionFunction("benchmark"))->isInternal()))) {
    /**
     * 簡易ベンチマークを取る
     *
     * 「指定ミリ秒内で何回コールできるか？」でベンチする。
     *
     * $suite は ['表示名' => $callable] 形式の配列。
     * 表示名が与えられていない場合、それらしい名前で表示する。
     *
     * Example:
     * ```php
     * // intval と int キャストはどちらが早いか調べる
     * benchmark([
     *     'intval',
     *     'intcast' => function($v){return (int)$v;},
     * ], ['12345'], 10);
     * ```
     *
     * @param array|callable $suite ベンチ対象処理
     * @param array $args 各ケースに与えられる引数
     * @param int $millisec 呼び出しミリ秒
     * @param bool $output true だと標準出力に出力される
     * @return array ベンチ結果の配列
     */
    function benchmark($suite, $args = [], $millisec = 1000, $output = true)
    {
        $benchset = [];
        foreach (arrayize($suite) as $name => $caller) {
            if (!is_callable($caller, false, $callname)) {
                throw new \InvalidArgumentException('caller is not callable.');
            }

            if (is_int($name)) {
                // クロージャは "Closure::__invoke" になるので "ファイル#開始行-終了行" にする
                if ($caller instanceof \Closure) {
                    $ref = new \ReflectionFunction($caller);
                    $callname = $ref->getFileName() . '#' . $ref->getStartLine() . '-' . $ref->getEndLine();
                }
                $name = $callname;
            }

            if (isset($benchset[$name])) {
                throw new \InvalidArgumentException('duplicated benchname.');
            }

            $benchset[$name] = closurize($caller);
        }

        if (!$benchset) {
            throw new \InvalidArgumentException('benchset is empty.');
        }

        // ウォームアップ兼検証（大量に実行してエラーの嵐になる可能性があるのでウォームアップの時点でエラーがないかチェックする）
        $assertions = call_safely(function ($benchset, $args) {
            $result = [];
            $args2 = $args;
            foreach ($benchset as $name => $caller) {
                $result[$name] = $caller(...$args2);
            }
            return $result;
        }, $benchset, $args);

        // 返り値の検証（ベンチマークという性質上、基本的に戻り値が一致しないのはおかしい）
        // rand/mt_rand, md5/sha1 のような例外はあるが、そんなのベンチしないし、クロージャでラップすればいいし、それでも邪魔なら @ で黙らせればいい
        foreach ($assertions as $name1 => $return1) {
            foreach ($assertions as $name2 => $return2) {
                if ($return1 !== null && $return2 !== null && $return1 !== $return2) {
                    $returns1 = stringify($return1);
                    $returns2 = stringify($return2);
                    trigger_error("Results of $name1 and $name2 are different. ($returns1, $returns2)");
                }
            }
        }

        // ベンチ
        $counts = [];
        foreach ($benchset as $name => $caller) {
            $end = microtime(true) + $millisec / 1000;
            $args2 = $args;
            for ($n = 0; microtime(true) <= $end; $n++) {
                $caller(...$args2);
            }
            $counts[$name] = $n;
        }

        // 結果配列
        $result = [];
        $maxcount = max($counts);
        arsort($counts);
        foreach ($counts as $name => $count) {
            $result[] = [
                'name'   => $name,
                'called' => $count,
                'mills'  => $millisec / $count,
                'ratio'  => $maxcount / $count,
            ];
        }

        // 出力するなら出力
        if ($output) {
            printf("Running %s cases (between %s ms):\n", count($benchset), number_format($millisec));
            echo markdown_table(array_map(function ($v) {
                return [
                    'name'       => $v['name'],
                    'called'     => number_format($v['called'], 0),
                    '1 call(ms)' => number_format($v['mills'], 6),
                    'ratio'      => number_format($v['ratio'], 3),
                ];
            }, $result));
        }

        return $result;
    }
}

const stringify = "stringify";
if (!isset($excluded_functions["stringify"]) && (!function_exists("stringify") || (!false && (new \ReflectionFunction("stringify"))->isInternal()))) {
    /**
     * 値を何とかして文字列化する
     *
     * この関数の出力は互換性を考慮しない。頻繁に変更される可能性がある。
     *
     * @param mixed $var 文字列化する値
     * @return string $var を文字列化したもの
     */
    function stringify($var)
    {
        $type = gettype($var);
        switch ($type) {
            case 'NULL':
                return 'null';
            case 'boolean':
                return $var ? 'true' : 'false';
            case 'array':
                return var_export2($var, true);
            case 'object':
                if (method_exists($var, '__toString')) {
                    return (string) $var;
                }
                if ($var instanceof \Serializable) {
                    return serialize($var);
                }
                if ($var instanceof \JsonSerializable) {
                    return get_class($var) . ':' . json_encode($var, JSON_UNESCAPED_UNICODE);
                }
                return get_class($var);

            default:
                return (string) $var;
        }
    }
}

const numberify = "numberify";
if (!isset($excluded_functions["numberify"]) && (!function_exists("numberify") || (!false && (new \ReflectionFunction("numberify"))->isInternal()))) {
    /**
     * 値を何とかして数値化する
     *
     * - 配列は要素数
     * - int/float はそのまま（ただし $decimal に応じた型にキャストされる）
     * - resource はリソースID（php 標準の int キャスト）
     * - null/bool はその int 値（php 標準の int キャストだが $decimal を見る）
     * - それ以外（文字列・オブジェクト）は文字列表現から数値以外を取り除いたもの
     *
     * 文字列・オブジェクト以外の変換は互換性を考慮しない。頻繁に変更される可能性がある（特に配列）。
     *
     * -記号は受け入れるが+記号は受け入れない。
     *
     * Example:
     * ```php
     * // 配列は要素数となる
     * assertSame(numberify([1, 2, 3]), 3);
     * // int/float は基本的にそのまま
     * assertSame(numberify(123), 123);
     * assertSame(numberify(123.45), 123);
     * assertSame(numberify(123.45, true), 123.45);
     * // 文字列は数値抽出
     * assertSame(numberify('a1b2c3'), 123);
     * assertSame(numberify('a1b2.c3', true), 12.3);
     * ```
     *
     * @param string $var 対象の値
     * @param bool $decimal 小数として扱うか
     * @return int|float 数値化した値
     */
    function numberify($var, $decimal = false)
    {
        // resource はその int 値を返す
        if (is_resource($var)) {
            return (int) $var;
        }

        // 配列は要素数を返す・・・が、$decimal を見るので後段へフォールスルー
        if (is_array($var)) {
            $var = count($var);
        }
        // null/bool はその int 値を返す・・・が、$decimal を見るので後段へフォールスルー
        if ($var === null || $var === false || $var === true) {
            $var = (int) $var;
        }

        // int はそのまま返す・・・と言いたいところだが $decimal をみてキャストして返す
        if (is_int($var)) {
            if ($decimal) {
                $var = (float) $var;
            }
            return $var;
        }
        // float はそのまま返す・・・と言いたいところだが $decimal をみてキャストして返す
        if (is_float($var)) {
            if (!$decimal) {
                $var = (int) $var;
            }
            return $var;
        }

        // 上記以外は文字列として扱い、数値のみでフィルタする（__toString 未実装は標準に任せる。多分 fatal error）
        $number = preg_replace("#[^-.0-9]#u", '', $var);

        // 正規表現レベルでチェックもできそうだけど大変な匂いがするので is_numeric に日和る
        if (!is_numeric($number)) {
            throw new \UnexpectedValueException("$var to $number, this is not numeric.");
        }

        if ($decimal) {
            return (float) $number;
        }
        return (int) $number;
    }
}

const numval = "numval";
if (!isset($excluded_functions["numval"]) && (!function_exists("numval") || (!false && (new \ReflectionFunction("numval"))->isInternal()))) {
    /**
     * 値を数値化する
     *
     * int か float ならそのまま返す。
     * 文字列の場合、一言で言えば「.を含むなら float、含まないなら int」を返す。
     * int でも float でも stringable でもない場合は実装依存（ただの int キャスト）。
     *
     * Example:
     * ```php
     * assertSame(numval(3.14), 3.14);   // int や float はそのまま返す
     * assertSame(numval('3.14'), 3.14); // . を含む文字列は float を返す
     * assertSame(numval('11', 8), 9);   // 基数が指定できる
     * ```
     *
     * @param mixed $var 数値化する値
     * @param int $base 基数。int 的な値のときしか意味をなさない
     * @return int|float 数値化した値
     */
    function numval($var, $base = 10)
    {
        if (is_int($var) || is_float($var)) {
            return $var;
        }
        if (is_object($var)) {
            $var = (string) $var;
        }
        if (is_string($var) && strpos($var, '.') !== false) {
            return (float) $var;
        }
        return intval($var, $base);
    }
}

const arrayval = "arrayval";
if (!isset($excluded_functions["arrayval"]) && (!function_exists("arrayval") || (!false && (new \ReflectionFunction("arrayval"))->isInternal()))) {
    /**
     * array キャストの関数版
     *
     * intval とか strval とかの array 版。
     * ただキャストするだけだが、関数なのでコールバックとして使える。
     *
     * $recursive を true にすると再帰的に適用する（デフォルト）。
     * 入れ子オブジェクトを配列化するときなどに使える。
     *
     * Example:
     * ```php
     * // キャストなので基本的には配列化される
     * assertSame(arrayval(123), [123]);
     * assertSame(arrayval('str'), ['str']);
     * assertSame(arrayval([123]), [123]); // 配列は配列のまま
     *
     * // $recursive = false にしない限り再帰的に適用される
     * $stdclass = stdclass(['key' => 'val']);
     * assertSame(arrayval([$stdclass], true), [['key' => 'val']]); // true なので中身も配列化される
     * assertSame(arrayval([$stdclass], false), [$stdclass]);       // false なので中身は変わらない
     * ```
     *
     * @param mixed $var array 化する値
     * @param bool $recursive 再帰的に行うなら true
     * @return array array 化した配列
     */
    function arrayval($var, $recursive = true)
    {
        // return json_decode(json_encode($var), true);

        // 無駄なループを回したくないので非再帰で配列の場合はそのまま返す
        if (!$recursive && is_array($var)) {
            return $var;
        }

        if (is_primitive($var)) {
            return (array) $var;
        }

        $result = [];
        foreach ($var as $k => $v) {
            if ($recursive && !is_primitive($v)) {
                $v = arrayval($v, $recursive);
            }
            $result[$k] = $v;
        }
        return $result;
    }
}

const si_prefix = "si_prefix";
if (!isset($excluded_functions["si_prefix"]) && (!function_exists("si_prefix") || (!false && (new \ReflectionFunction("si_prefix"))->isInternal()))) {
    /**
     * 数値に SI 接頭辞を付与する
     *
     * 値は 1 <= $var < 1000(1024) の範囲内に収められる。
     * ヨクト（10^24）～ヨタ（1024）まで。整数だとしても 64bit の範囲を超えるような値の精度は保証しない。
     *
     * Example:
     * ```php
     * // シンプルに k をつける
     * assertSame(si_prefix(12345), '12.345 k');
     * // シンプルに m をつける
     * assertSame(si_prefix(0.012345), '12.345 m');
     * // 書式フォーマットを指定できる
     * assertSame(si_prefix(12345, 1000, '%d%s'), '12k');
     * assertSame(si_prefix(0.012345, 1000, '%d%s'), '12m');
     * // ファイルサイズを byte で表示する
     * assertSame(si_prefix(12345, 1000, '%d %sbyte'), '12 kbyte');
     * // ファイルサイズを byte で表示する（1024）
     * assertSame(si_prefix(10240, 1024, '%.3f %sbyte'), '10.000 kbyte');
     * // フォーマットに null を与えると sprintf せずに配列で返す
     * assertSame(si_prefix(12345, 1000, null), [12.345, 'k']);
     * ```
     *
     * @param mixed $var 丸める値
     * @param int $unit 桁単位。実用上は 1000, 1024 の2値しか指定することはないはず
     * @param string $format 書式フォーマット。 null を与えると sprintf せずに配列で返す
     * @return string|array 丸めた数値と SI 接頭辞で sprintf した文字列（$format が null の場合は配列）
     */
    function si_prefix($var, $unit = 1000, $format = '%.3f %s')
    {
        static $units = [
            -8 => 'y', // ヨクト
            -7 => 'z', // ゼプト
            -6 => 'a', // アト
            -5 => 'f', // フェムト
            -4 => 'p', // ピコ
            -3 => 'n', // ナノ
            -2 => 'µ', // マイクロ
            -1 => 'm', // ミリ
            0  => '',  //
            1  => 'k', // キロ
            2  => 'M', // メガ
            3  => 'G', // ギガ
            4  => 'T', // テラ
            5  => 'P', // ペタ
            6  => 'E', // エクサ
            7  => 'Z', // ゼタ
            8  => 'Y', // ヨタ
        ];

        assert($unit > 0);

        $result = function ($format, $var, $unit) {
            if ($format === null) {
                return [$var, $unit];
            }
            return sprintf($format, $var, $unit);
        };

        if ($var == 0) {
            return $result($format, $var, '');
        }

        $original = $var;
        $var = abs($var);
        $n = 0;
        while (!(1 <= $var && $var < $unit)) {
            if ($var < 1) {
                $n--;
                $var *= $unit;
            }
            else {
                $n++;
                $var /= $unit;
            }
        }
        if (!isset($units[$n])) {
            throw new \InvalidArgumentException("$original is too large or small ($n).");
        }
        return $result($format, ($original > 0 ? 1 : -1) * $var, $units[$n]);
    }
}

const si_unprefix = "si_unprefix";
if (!isset($excluded_functions["si_unprefix"]) && (!function_exists("si_unprefix") || (!false && (new \ReflectionFunction("si_unprefix"))->isInternal()))) {
    /**
     * SI 接頭辞が付与された文字列を数値化する
     *
     * 典型的な用途は ini_get で得られた値を数値化したいとき。
     * ただし、 ini は 1m のように小文字で指定することもあるので大文字化する必要はある。
     *
     * Example:
     * ```php
     * // 1k = 1000
     * assertSame(si_unprefix('1k'), 1000);
     * // 1k = 1024
     * assertSame(si_unprefix('1k', 1024), 1024);
     * // m はメガではなくミリ
     * assertSame(si_unprefix('1m'), 0.001);
     * // M がメガ
     * assertSame(si_unprefix('1M'), 1000000);
     * // K だけは特別扱いで大文字小文字のどちらでもキロになる
     * assertSame(si_unprefix('1K'), 1000);
     * ```
     *
     * @param mixed $var 数値化する値
     * @param int $unit 桁単位。実用上は 1000, 1024 の2値しか指定することはないはず
     * @return int|float SI 接頭辞を取り払った実際の数値
     */
    function si_unprefix($var, $unit = 1000)
    {
        static $units = [
            'y' => -8, // ヨクト
            'z' => -7, // ゼプト
            'a' => -6, // アト
            'f' => -5, // フェムト
            'p' => -4, // ピコ
            'n' => -3, // ナノ
            'µ' => -2, // マイクロ
            'm' => -1, // ミリ
            ''  => 0, //
            'k' => 1, // キロ
            'K' => 1, // キロ（特別扱い）
            'M' => 2, // メガ
            'G' => 3, // ギガ
            'T' => 4, // テラ
            'P' => 5, // ペタ
            'E' => 6, // エクサ
            'Z' => 7, // ゼタ
            'Y' => 8, // ヨタ
        ];

        assert($unit > 0);

        $var = trim($var);
        preg_match('#[' . implode('', array_keys($units)) . ']$#u', $var, $m);
        return numval($var) * pow($unit, $units[$m[0] ?? ''] ?? 0);
    }
}

const is_empty = "is_empty";
if (!isset($excluded_functions["is_empty"]) && (!function_exists("is_empty") || (!false && (new \ReflectionFunction("is_empty"))->isInternal()))) {
    /**
     * 値が空か検査する
     *
     * `empty` とほぼ同じ。ただし
     *
     * - string: "0"
     * - countable でない object
     * - countable である object で count() > 0
     *
     * は false 判定する。
     *
     * なお、関数の仕様上、未定義変数を true 判定することはできない。
     * 未定義変数をチェックしたい状況は大抵の場合コードが悪いが `$array['key1']['key2']` を調べたいことはある。
     * そういう時には使えない（?? する必要がある）。
     *
     * 「 `if ($var) {}` で十分なんだけど "0" が…」という状況はまれによくあるはず。
     *
     * Example:
     * ```php
     * // この辺は empty と全く同じ
     * assertTrue(is_empty(null));
     * assertTrue(is_empty(false));
     * assertTrue(is_empty(0));
     * assertTrue(is_empty(''));
     * // この辺だけが異なる
     * assertFalse(is_empty('0'));
     * assertFalse(is_empty(new \SimpleXMLElement('<foo></foo>')));
     * ```
     *
     * @param mixed $var 判定する値
     * @return bool 空なら true
     */
    function is_empty($var)
    {
        // object は is_countable 次第
        if (is_object($var)) {
            if (is_countable($var)) {
                return !count($var);
            }
            return false;
        }

        // "0" は false
        if ($var === '0') {
            return false;
        }

        // 上記以外は empty に任せる
        return empty($var);
    }
}

const is_primitive = "is_primitive";
if (!isset($excluded_functions["is_primitive"]) && (!function_exists("is_primitive") || (!false && (new \ReflectionFunction("is_primitive"))->isInternal()))) {
    /**
     * 値が複合型でないか検査する
     *
     * 「複合型」とはオブジェクトと配列のこと。
     * つまり
     *
     * - is_scalar($var) || is_null($var) || is_resource($var)
     *
     * と同義（!is_array($var) && !is_object($var) とも言える）。
     *
     * Example:
     * ```php
     * assertTrue(is_primitive(null));
     * assertTrue(is_primitive(false));
     * assertTrue(is_primitive(123));
     * assertTrue(is_primitive(STDIN));
     * assertFalse(is_primitive(new \stdClass));
     * assertFalse(is_primitive(['array']));
     * ```
     *
     * @param mixed $var 調べる値
     * @return bool 複合型なら false
     */
    function is_primitive($var)
    {
        return is_scalar($var) || is_null($var) || is_resource($var);
    }
}

const is_recursive = "is_recursive";
if (!isset($excluded_functions["is_recursive"]) && (!function_exists("is_recursive") || (!false && (new \ReflectionFunction("is_recursive"))->isInternal()))) {
    /**
     * 変数が再帰参照を含むか調べる
     *
     * Example:
     * ```php
     * // 配列の再帰
     * $array = [];
     * $array['recursive'] = &$array;
     * assertTrue(is_recursive($array));
     * // オブジェクトの再帰
     * $object = new \stdClass();
     * $object->recursive = $object;
     * assertTrue(is_recursive($object));
     * ```
     *
     * @param mixed $var 調べる値
     * @return bool 再帰参照を含むなら true
     */
    function is_recursive($var)
    {
        $core = function ($var, $parents) use (&$core) {
            // 複合型でないなら間違いなく false
            if (is_primitive($var)) {
                return false;
            }

            // 「親と同じ子」は再帰以外あり得ない。よって === で良い（オブジェクトに関してはそもそも等値比較で絶対に一致しない）
            // sql_object_hash とか serialize でキーに保持して isset の方が速いか？
            // → ベンチ取ったところ in_array の方が10倍くらい速い。多分生成コストに起因
            // raw な比較であれば瞬時に比較できるが、isset だと文字列化が必要でかなり無駄が生じていると考えられる
            foreach ($parents as $parent) {
                if ($parent === $var) {
                    return true;
                }
            }

            // 全要素を再帰的にチェック
            $parents[] = $var;
            foreach ($var as $k => $v) {
                if ($core($v, $parents)) {
                    return true;
                }
            }
            return false;
        };
        return $core($var, []);
    }
}

const is_stringable = "is_stringable";
if (!isset($excluded_functions["is_stringable"]) && (!function_exists("is_stringable") || (!false && (new \ReflectionFunction("is_stringable"))->isInternal()))) {
    /**
     * 変数が文字列化できるか調べる
     *
     * 「配列」「__toString を持たないオブジェクト」が false になる。
     * （厳密に言えば配列は "Array" になるので文字列化できるといえるがここでは考えない）。
     *
     * Example:
     * ```php
     * // こいつらは true
     * assertTrue(is_stringable(null));
     * assertTrue(is_stringable(true));
     * assertTrue(is_stringable(3.14));
     * assertTrue(is_stringable(STDOUT));
     * assertTrue(is_stringable(new \Exception()));
     * // こいつらは false
     * assertFalse(is_stringable(new \ArrayObject()));
     * assertFalse(is_stringable([1, 2, 3]));
     * ```
     *
     * @param mixed $var 調べる値
     * @return bool 文字列化できるなら true
     */
    function is_stringable($var)
    {
        if (is_array($var)) {
            return false;
        }
        if (is_object($var) && !method_exists($var, '__toString')) {
            return false;
        }
        return true;
    }
}

const is_arrayable = "is_arrayable";
if (!isset($excluded_functions["is_arrayable"]) && (!function_exists("is_arrayable") || (!false && (new \ReflectionFunction("is_arrayable"))->isInternal()))) {
    /**
     * 変数が配列アクセス可能か調べる
     *
     * Example:
     * ```php
     * assertTrue(is_arrayable([]));
     * assertTrue(is_arrayable(new \ArrayObject()));
     * assertFalse(is_arrayable(new \stdClass()));
     * ```
     *
     * @param array $var 調べる値
     * @return bool 配列アクセス可能なら true
     */
    function is_arrayable($var)
    {
        return is_array($var) || $var instanceof \ArrayAccess;
    }
}

const is_iterable = "is_iterable";
if (!isset($excluded_functions["is_iterable"]) && (!function_exists("is_iterable") || (!true && (new \ReflectionFunction("is_iterable"))->isInternal()))) {
    /**
     * 変数が foreach で回せるか調べる
     *
     * オブジェクトの場合は \Traversable のみ。
     * 要するに {@link http://php.net/manual/function.is-iterable.php is_iterable} の polyfill。
     *
     * Example:
     * ```php
     * assertTrue(is_iterable([1, 2, 3]));
     * assertTrue(is_iterable((function () { yield 1; })()));
     * assertFalse(is_iterable(1));
     * assertFalse(is_iterable(new \stdClass()));
     * ```
     *
     * @polyfill
     *
     * @param mixed $var 調べる値
     * @return bool foreach で回せるなら true
     */
    function is_iterable($var)
    {
        return is_array($var) || $var instanceof \Traversable;
    }
}

const is_countable = "is_countable";
if (!isset($excluded_functions["is_countable"]) && (!function_exists("is_countable") || (!true && (new \ReflectionFunction("is_countable"))->isInternal()))) {
    /**
     * 変数が count でカウントできるか調べる
     *
     * 要するに {@link http://php.net/manual/function.is-countable.php is_countable} の polyfill。
     *
     * Example:
     * ```php
     * assertTrue(is_countable([1, 2, 3]));
     * assertTrue(is_countable(new \ArrayObject()));
     * assertFalse(is_countable((function () { yield 1; })()));
     * assertFalse(is_countable(1));
     * assertFalse(is_countable(new \stdClass()));
     * ```
     *
     * @polyfill
     *
     * @param mixed $var 調べる値
     * @return bool count でカウントできるなら true
     */
    function is_countable($var)
    {
        return is_array($var) || $var instanceof \Countable;
    }
}

const varcmp = "varcmp";
if (!isset($excluded_functions["varcmp"]) && (!function_exists("varcmp") || (!false && (new \ReflectionFunction("varcmp"))->isInternal()))) {
    /**
     * php7 の `<=>` の関数版
     *
     * 引数で大文字小文字とか自然順とか型モードとかが指定できる。
     *
     * Example:
     * ```php
     * // 'a' と 'z' なら 'z' の方が大きい
     * assertTrue(varcmp('z', 'a') > 0);
     * assertTrue(varcmp('a', 'z') < 0);
     * assertTrue(varcmp('a', 'a') === 0);
     *
     * // 'a' と 'Z' なら 'a' の方が大きい…が SORT_FLAG_CASE なので 'Z' のほうが大きい
     * assertTrue(varcmp('Z', 'a', SORT_FLAG_CASE) > 0);
     * assertTrue(varcmp('a', 'Z', SORT_FLAG_CASE) < 0);
     * assertTrue(varcmp('a', 'A', SORT_FLAG_CASE) === 0);
     *
     * // '2' と '12' なら '2' の方が大きい…が SORT_NATURAL なので '12' のほうが大きい
     * assertTrue(varcmp('12', '2', SORT_NATURAL) > 0);
     * assertTrue(varcmp('2', '12', SORT_NATURAL) < 0);
     * ```
     *
     * @param mixed $a 比較する値1
     * @param mixed $b 比較する値2
     * @param int $mode 比較モード（SORT_XXX）。省略すると型でよしなに選択
     * @return int 等しいなら 0、 $a のほうが大きいなら > 0、 $bのほうが大きいなら < 0
     */
    function varcmp($a, $b, $mode = null)
    {
        // null が来たらよしなにする（なるべく型に寄せるが SORT_REGULAR はキモいので避ける）
        if ($mode === null || $mode === SORT_FLAG_CASE) {
            if ((is_int($a) || is_float($a)) && (is_int($b) || is_float($b))) {
                $mode = SORT_NUMERIC;
            }
            elseif (is_string($a) && is_string($b)) {
                $mode = SORT_STRING | $mode; // SORT_FLAG_CASE が単品で来てるかもしれないので混ぜる
            }
        }

        $flag_case = $mode & SORT_FLAG_CASE;
        $mode = $mode & ~SORT_FLAG_CASE;

        if ($mode === SORT_NUMERIC) {
            return $a - $b;
        }
        if ($mode === SORT_STRING) {
            if ($flag_case) {
                return strcasecmp($a, $b);
            }
            return strcmp($a, $b);
        }
        if ($mode === SORT_NATURAL) {
            if ($flag_case) {
                return strnatcasecmp($a, $b);
            }
            return strnatcmp($a, $b);
        }

        // for SORT_REGULAR
        return $a == $b ? 0 : ($a > $b ? 1 : -1);
    }
}

const var_type = "var_type";
if (!isset($excluded_functions["var_type"]) && (!function_exists("var_type") || (!false && (new \ReflectionFunction("var_type"))->isInternal()))) {
    /**
     * 値の型を取得する（gettype + get_class）
     *
     * プリミティブ型（gettype で得られるやつ）はそのまま、オブジェクトのときのみクラス名を返す。
     * ただし、オブジェクトの場合は先頭に '\\' が必ず付く。
     *
     * Example:
     * ```php
     * // プリミティブ型は gettype と同義
     * assertSame(var_type(false), 'boolean');
     * assertSame(var_type(123), 'integer');
     * assertSame(var_type(3.14), 'double');
     * assertSame(var_type([1, 2, 3]), 'array');
     * // オブジェクトは型名を返す
     * assertSame(var_type(new \stdClass), '\\stdClass');
     * assertSame(var_type(new \Exception()), '\\Exception');
     * ```
     *
     * @param mixed $var 型を取得する値
     * @return string 型名
     */
    function var_type($var)
    {
        if (is_object($var)) {
            return '\\' . get_class($var);
        }
        return gettype($var);
    }
}

const var_apply = "var_apply";
if (!isset($excluded_functions["var_apply"]) && (!function_exists("var_apply") || (!false && (new \ReflectionFunction("var_apply"))->isInternal()))) {
    /**
     * 値にコールバックを適用する
     *
     * 普通のスカラー値であれば `$callback($var)` と全く同じ。
     * この関数は「$var が配列だったら中身に適用して返す（再帰）」という点で上記とは異なる。
     *
     * 「配列が与えられたら要素に適用して配列で返す、配列じゃないなら直に適用してそれを返す」という状況はまれによくあるはず。
     *
     * Example:
     * ```php
     * // 素の値は素の呼び出しと同じ
     * assertSame(var_apply(' x ', 'trim'), 'x');
     * // 配列は中身に適用して配列で返す（再帰）
     * assertSame(var_apply([' x ', ' y ', [' z ']], 'trim'), ['x', 'y', ['z']]);
     * // 第3引数以降は残り引数を意味する
     * assertSame(var_apply(['!x!', '!y!'], 'trim', '!'), ['x', 'y']);
     * // 「まれによくある」の具体例
     * assertSame(var_apply(['<x>', ['<y>']], 'htmlspecialchars', ENT_QUOTES, 'utf-8'), ['&lt;x&gt;', ['&lt;y&gt;']]);
     * ```
     *
     * @param mixed $var $callback を適用する値
     * @param callable $callback 値変換コールバック
     * @param array $args $callback の残り引数（可変引数）
     * @return mixed|array $callback が適用された値。元が配列なら配列で返す
     */
    function var_apply($var, $callback, ...$args)
    {
        $iterable = is_iterable($var);
        if ($iterable) {
            $result = [];
            foreach ($var as $k => $v) {
                $result[$k] = var_apply($v, $callback, ...$args);
            }
            return $result;
        }

        return $callback($var, ...$args);
    }
}

const var_applys = "var_applys";
if (!isset($excluded_functions["var_applys"]) && (!function_exists("var_applys") || (!false && (new \ReflectionFunction("var_applys"))->isInternal()))) {
    /**
     * 配列にコールバックを適用する
     *
     * 配列であれば `$callback($var)` と全く同じ。
     * この関数は「$var がスカラー値だったら配列化して適用してスカラーで返す」という点で上記とは異なる。
     *
     * 「配列を受け取って配列を返す関数があるが、手元にスカラー値しか無い」という状況はまれによくあるはず。
     *
     * Example:
     * ```php
     * // 配列を受け取って中身を大文字化して返すクロージャ
     * $upper = function($array){return array_map('strtoupper', $array);};
     * // 普通はこうやって使うが・・・
     * assertSame($upper(['a', 'b', 'c']), ['A', 'B', 'C']);
     * // 手元に配列ではなくスカラー値しか無いときはこうせざるをえない
     * assertSame($upper(['a'])[0], 'A');
     * // var_applys を使うと配列でもスカラーでも統一的に記述することができる
     * assertSame(var_applys(['a', 'b', 'c'], $upper), ['A', 'B', 'C']);
     * assertSame(var_applys('a', $upper), 'A');
     * # 要するに「大文字化したい」だけなわけだが、$upper が配列を前提としているので、「大文字化」部分を得るには配列化しなければならなくなっている
     * # 「strtoupper だけ切り出せばよいのでは？」と思うかもしれないが、「（外部ライブラリなどで）手元に配列しか受け取ってくれない処理しかない」状況がまれによくある
     * ```
     *
     * @param mixed $var $callback を適用する値
     * @param callable $callback 値変換コールバック
     * @param array $args $callback の残り引数（可変引数）
     * @return mixed|array $callback が適用された値。元が配列なら配列で返す
     */
    function var_applys($var, $callback, ...$args)
    {
        $iterable = is_iterable($var);
        if (!$iterable) {
            $var = [$var];
        }
        $var = $callback($var, ...$args);
        return $iterable ? $var : $var[0];
    }
}

const var_export2 = "var_export2";
if (!isset($excluded_functions["var_export2"]) && (!function_exists("var_export2") || (!false && (new \ReflectionFunction("var_export2"))->isInternal()))) {
    /**
     * 組み込みの var_export をいい感じにしたもの
     *
     * 下記の点が異なる。
     *
     * - 配列は 5.4 以降のショートシンタックス（[]）で出力
     * - インデントは 4 固定
     * - ただの配列は1行（[1, 2, 3]）でケツカンマなし、連想配列は桁合わせインデントでケツカンマあり
     * - 文字列はダブルクオート
     * - null は null（小文字）
     * - 再帰構造を渡しても警告がでない（さらに NULL ではなく `'*RECURSION*'` という文字列になる）
     * - 配列の再帰構造の出力が異なる（Example参照）
     *
     * Example:
     * ```php
     * // 単純なエクスポート
     * assertSame(var_export2(['array' => [1, 2, 3], 'hash' => ['a' => 'A', 'b' => 'B', 'c' => 'C']], true), '[
     *     "array" => [1, 2, 3],
     *     "hash"  => [
     *         "a" => "A",
     *         "b" => "B",
     *         "c" => "C",
     *     ],
     * ]');
     * // 再帰構造を含むエクスポート（標準の var_export は形式が異なる。 var_export すれば分かる）
     * $rarray = [];
     * $rarray['a']['b']['c'] = &$rarray;
     * $robject = new \stdClass();
     * $robject->a = new \stdClass();
     * $robject->a->b = new \stdClass();
     * $robject->a->b->c = $robject;
     * assertSame(var_export2(compact('rarray', 'robject'), true), '[
     *     "rarray"  => [
     *         "a" => [
     *             "b" => [
     *                 "c" => "*RECURSION*",
     *             ],
     *         ],
     *     ],
     *     "robject" => stdClass::__set_state([
     *         "a" => stdClass::__set_state([
     *             "b" => stdClass::__set_state([
     *                 "c" => "*RECURSION*",
     *             ]),
     *         ]),
     *     ]),
     * ]');
     * ```
     *
     * @param mixed $value 出力する値
     * @param bool $return 返すなら true 出すなら false
     * @return string|null $return=true の場合は出力せず結果を返す
     */
    function var_export2($value, $return = false)
    {
        // インデントの空白数
        $INDENT = 4;

        // 再帰用クロージャ
        $export = function ($value, $nest = 0, $parents = []) use (&$export, $INDENT) {
            // 再帰を検出したら *RECURSION* とする（処理に関しては is_recursive のコメント参照）
            foreach ($parents as $parent) {
                if ($parent === $value) {
                    return $export('*RECURSION*');
                }
            }
            // 配列は連想判定したり再帰したり色々
            if (is_array($value)) {
                $spacer1 = str_repeat(' ', ($nest + 1) * $INDENT);
                $spacer2 = str_repeat(' ', $nest * $INDENT);

                $hashed = is_hasharray($value);

                // スカラー値のみで構成されているならシンプルな再帰
                if (!$hashed && array_all($value, is_primitive)) {
                    return '[' . implode(', ', array_map($export, $value)) . ']';
                }

                // 連想配列はキーを含めて桁あわせ
                if ($hashed) {
                    $keys = array_map($export, array_combine($keys = array_keys($value), $keys));
                    $maxlen = max(array_map('strlen', $keys));
                }
                $kvl = '';
                $parents[] = $value;
                foreach ($value as $k => $v) {
                    /** @noinspection PhpUndefinedVariableInspection */
                    $keystr = $hashed ? $keys[$k] . str_repeat(' ', $maxlen - strlen($keys[$k])) . ' => ' : '';
                    $kvl .= $spacer1 . $keystr . $export($v, $nest + 1, $parents) . ",\n";
                }
                return "[\n{$kvl}{$spacer2}]";
            }
            // オブジェクトは単にプロパティを __set_state する文字列を出力する
            elseif (is_object($value)) {
                $parents[] = $value;
                return get_class($value) . '::__set_state(' . $export(get_object_properties($value), $nest, $parents) . ')';
            }
            // 文字列はダブルクオート
            elseif (is_string($value)) {
                return '"' . addcslashes($value, "\"\0\\") . '"';
            }
            // null は小文字で居て欲しい
            elseif (is_null($value)) {
                return 'null';
            }
            // それ以外は標準に従う
            else {
                return var_export($value, true);
            }
        };

        // 結果を返したり出力したり
        $result = $export($value);
        if ($return) {
            return $result;
        }
        echo $result, "\n";
    }
}

const var_html = "var_html";
if (!isset($excluded_functions["var_html"]) && (!function_exists("var_html") || (!false && (new \ReflectionFunction("var_html"))->isInternal()))) {
    /**
     * var_export2 を html コンテキストに特化させたようなもの
     *
     * 下記のような出力になる。
     * - `<pre class='var_html'> ～ </pre>` で囲まれる
     * - php 構文なのでハイライトされて表示される
     * - Content-Type が強制的に text/html になる
     *
     * この関数の出力は互換性を考慮しない。頻繁に変更される可能性がある。
     *
     * @param mixed $value 出力する値
     */
    function var_html($value)
    {
        $var_export = function ($value) {
            $result = var_export($value, true);
            $result = highlight_string("<?php " . $result, true);
            $result = preg_replace('#&lt;\\?php(\s|&nbsp;)#u', '', $result, 1);
            $result = preg_replace('#<br />#u', "\n", $result);
            $result = preg_replace('#>\n<#u', '><', $result);
            return $result;
        };

        $export = function ($value, $parents) use (&$export, $var_export) {
            foreach ($parents as $parent) {
                if ($parent === $value) {
                    return '*RECURSION*';
                }
            }
            if (is_array($value)) {
                $count = count($value);
                if (!$count) {
                    return '[empty]';
                }

                $maxlen = max(array_map('strlen', array_keys($value)));
                $kvl = '';
                $parents[] = $value;
                foreach ($value as $k => $v) {
                    $align = str_repeat(' ', $maxlen - strlen($k));
                    $kvl .= $var_export($k) . $align . ' => ' . $export($v, $parents) . "\n";
                }
                $var = "<var style='text-decoration:underline'>$count elements</var>";
                $summary = "<summary style='cursor:pointer;color:#0a6ebd'>[$var]</summary>";
                return "<details style='display:inline;vertical-align:text-top'>$summary$kvl</details>";
            }
            elseif (is_object($value)) {
                $parents[] = $value;
                return get_class($value) . '::' . $export(get_object_properties($value), $parents);
            }
            elseif (is_null($value)) {
                return 'null';
            }
            elseif (is_resource($value)) {
                return ((string) $value) . '(' . get_resource_type($value) . ')';
            }
            else {
                return $var_export($value);
            }
        };

        // text/html を強制する（でないと見やすいどころか見づらくなる）
        // @codeCoverageIgnoreStart
        if (!headers_sent()) {
            header_remove('Content-Type');
            header('Content-Type: text/html');
        }
        // @codeCoverageIgnoreEnd

        echo "<pre class='var_html'>{$export($value, [])}</pre>";
    }
}

const console_log = "console_log";
if (!isset($excluded_functions["console_log"]) && (!function_exists("console_log") || (!false && (new \ReflectionFunction("console_log"))->isInternal()))) {
    /**
     * js の console に値を吐き出す
     *
     * script タグではなく X-ChromeLogger-Data を使用する。
     * したがってヘッダ送信前に呼ぶ必要がある。
     *
     * @see https://craig.is/writing/chrome-logger/techspecs
     *
     * @param mixed $values 出力する値（可変引数）
     */
    function console_log(...$values)
    {
        // X-ChromeLogger-Data ヘッダを使うので送信済みの場合は不可
        if (headers_sent($file, $line)) {
            throw new \UnexpectedValueException("header is already sent. $file#$line");
        }

        // データ行（最後だけ書き出すので static で保持する）
        static $rows = [];

        // 最終データを一度だけヘッダで吐き出す（replace を false にしても多重で表示してくれないっぽい）
        if (!$rows && $values) {
            // header_register_callback はグローバルで1度しか登録できないのでライブラリ内部で使うべきではない
            // ob_start にコールバックを渡すと ob_end～ の時に呼ばれるので、擬似的に header_register_callback 的なことができる
            ob_start(function () use (&$rows) {
                $header = base64_encode(utf8_encode(json_encode([
                    'version' => '1.0.0',
                    'columns' => ['log', 'backtrace', 'type'],
                    'rows'    => $rows,
                ])));
                header('X-ChromeLogger-Data: ' . $header);
                return false;
            });
        }

        foreach ($values as $value) {
            $rows[] = [[$value], null, 'log'];
        }
    }
}

const hashvar = "hashvar";
if (!isset($excluded_functions["hashvar"]) && (!function_exists("hashvar") || (!false && (new \ReflectionFunction("hashvar"))->isInternal()))) {
    /**
     * 変数指定をできるようにした compact
     *
     * 名前空間指定の呼び出しは未対応。use して関数名だけで呼び出す必要がある。
     *
     * Example:
     * ```php
     * $hoge = 'HOGE';
     * $fuga = 'FUGA';
     * assertSame(hashvar($hoge, $fuga), ['hoge' => 'HOGE', 'fuga' => 'FUGA']);
     * ```
     *
     * @param mixed $vars 変数（可変引数）
     * @return array 引数の変数を変数名で compact した配列
     */
    function hashvar(...$vars)
    {
        $num = count($vars);

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
        $file = $trace['file'];
        $line = $trace['line'];
        $function = function_shorten($trace['function']);

        $cache = cache($file . '#' . $line, function () use ($file, $line, $function) {
            // 呼び出し元の1行を取得
            $lines = file($file, FILE_IGNORE_NEW_LINES);
            $target = $lines[$line - 1];

            // 1行内で複数呼んでいる場合のための配列
            $caller = [];
            $callers = [];

            // php パーシング
            $starting = false;
            $tokens = token_get_all('<?php ' . $target);
            foreach ($tokens as $token) {
                // トークン配列の場合
                if (is_array($token)) {
                    // 自身の呼び出しが始まった
                    if (!$starting && $token[0] === T_STRING && $token[1] === $function) {
                        $starting = true;
                    }
                    // 呼び出し中でかつ変数トークンなら変数名を確保
                    elseif ($starting && $token[0] === T_VARIABLE) {
                        $caller[] = ltrim($token[1], '$');
                    }
                    // 上記以外の呼び出し中のトークンは空白しか許されない
                    elseif ($starting && $token[0] !== T_WHITESPACE) {
                        throw new \UnexpectedValueException('argument allows variable only.');
                    }
                }
                // 1文字単位の文字列の場合
                else {
                    // 自身の呼び出しが終わった
                    if ($starting && $token === ')' && $caller) {
                        $callers[] = $caller;
                        $caller = [];
                        $starting = false;
                    }
                }
            }

            // 同じ引数の数の呼び出しは区別することが出来ない
            $length = count($callers);
            for ($i = 0; $i < $length; $i++) {
                for ($j = $i + 1; $j < $length; $j++) {
                    if (count($callers[$i]) === count($callers[$j])) {
                        throw new \UnexpectedValueException('argument is ambiguous.');
                    }
                }
            }

            return $callers;
        }, __FUNCTION__);

        // 引数の数が一致する呼び出しを返す
        foreach ($cache as $caller) {
            if (count($caller) === $num) {
                return array_combine($caller, $vars);
            }
        }

        // 仕組み上ここへは到達しないはず（呼び出し元のシンタックスが壊れてるときに到達しうるが、それならばそもそもこの関数自体が呼ばれないはず）。
        throw new \DomainException('syntax error.'); // @codeCoverageIgnore
    }
}

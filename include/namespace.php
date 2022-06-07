<?php

# Don't touch this code. This is auto generated.

namespace ryunosuke\Functions;

# constants
if (!defined("ryunosuke\\Functions\\IS_OWNSELF")) {
    /** 自分自身を表す定数 */
    define("ryunosuke\\Functions\\IS_OWNSELF", 2);
}

if (!defined("ryunosuke\\Functions\\IS_PUBLIC")) {
    /** public を表す定数 */
    define("ryunosuke\\Functions\\IS_PUBLIC", 4);
}

if (!defined("ryunosuke\\Functions\\IS_PROTECTED")) {
    /** protected を表す定数 */
    define("ryunosuke\\Functions\\IS_PROTECTED", 8);
}

if (!defined("ryunosuke\\Functions\\IS_PRIVATE")) {
    /** private を表す定数 */
    define("ryunosuke\\Functions\\IS_PRIVATE", 16);
}

if (!defined("ryunosuke\\Functions\\JP_ERA")) {
    /** 和暦 */
    define("ryunosuke\\Functions\\JP_ERA", [
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
    ]);
}

if (!defined("ryunosuke\\Functions\\KEYWORDS")) {
    /** SQL キーワード（全 RDBMS ごちゃまぜ） */
    define("ryunosuke\\Functions\\KEYWORDS", [
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
        97  => "GROUP",
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
        125 => "JSON_ARRAY",
        126 => "JSON_ARRAY_APPEND",
        127 => "JSON_ARRAY_INSERT",
        128 => "JSON_CONTAINS",
        129 => "JSON_CONTAINS_PATH",
        130 => "JSON_DEPTH",
        131 => "JSON_EXTRACT",
        132 => "JSON_INSERT",
        133 => "JSON_KEYS",
        134 => "JSON_LENGTH",
        135 => "JSON_MERGE_PATCH",
        136 => "JSON_MERGE_PRESERVE",
        137 => "JSON_OBJECT",
        138 => "JSON_PRETTY",
        139 => "JSON_QUOTE",
        140 => "JSON_REMOVE",
        141 => "JSON_REPLACE",
        142 => "JSON_SEARCH",
        143 => "JSON_SET",
        144 => "JSON_STORAGE_SIZE",
        145 => "JSON_TYPE",
        146 => "JSON_UNQUOTE",
        147 => "JSON_VALID",
        148 => "KEY",
        149 => "KEYS",
        150 => "KILL",
        151 => "LAST_INSERT_ID",
        152 => "LEADING",
        153 => "LEFT",
        154 => "LEVEL",
        155 => "LIKE",
        156 => "LIMIT",
        157 => "LINEAR",
        158 => "LINES",
        159 => "LOAD",
        160 => "LOCAL",
        161 => "LOCK",
        162 => "LOCKS",
        163 => "LOGS",
        164 => "LOW_PRIORITY",
        165 => "MARIA",
        166 => "MASTER",
        167 => "MASTER_CONNECT_RETRY",
        168 => "MASTER_HOST",
        169 => "MASTER_LOG_FILE",
        170 => "MATCH",
        171 => "MAX_CONNECTIONS_PER_HOUR",
        172 => "MAX_QUERIES_PER_HOUR",
        173 => "MAX_ROWS",
        174 => "MAX_UPDATES_PER_HOUR",
        175 => "MAX_USER_CONNECTIONS",
        176 => "MEDIUM",
        177 => "MERGE",
        178 => "MINUTE",
        179 => "MINUTE_SECOND",
        180 => "MIN_ROWS",
        181 => "MODE",
        182 => "MODIFY",
        183 => "MONTH",
        184 => "MRG_MYISAM",
        185 => "MYISAM",
        186 => "NAMES",
        187 => "NATURAL",
        188 => "NOT",
        189 => "NOW()",
        190 => "NULL",
        191 => "OFFSET",
        192 => "ON",
        193 => "ON DELETE",
        194 => "ON UPDATE",
        195 => "OPEN",
        196 => "OPTIMIZE",
        197 => "OPTION",
        198 => "OPTIONALLY",
        199 => "OR",
        200 => "ORDER",
        201 => "BY",
        202 => "OUTER",
        203 => "OUTFILE",
        204 => "PACK_KEYS",
        205 => "PAGE",
        206 => "PARTIAL",
        207 => "PARTITION",
        208 => "PARTITIONS",
        209 => "PASSWORD",
        210 => "PRIMARY",
        211 => "PRIVILEGES",
        212 => "PROCEDURE",
        213 => "PROCESS",
        214 => "PROCESSLIST",
        215 => "PURGE",
        216 => "QUICK",
        217 => "RAID0",
        218 => "RAID_CHUNKS",
        219 => "RAID_CHUNKSIZE",
        220 => "RAID_TYPE",
        221 => "RANGE",
        222 => "READ",
        223 => "READ_ONLY",
        224 => "READ_WRITE",
        225 => "REFERENCES",
        226 => "REGEXP",
        227 => "RELOAD",
        228 => "RENAME",
        229 => "REPAIR",
        230 => "REPEATABLE",
        231 => "REPLACE",
        232 => "REPLICATION",
        233 => "RESET",
        234 => "RESTORE",
        235 => "RESTRICT",
        236 => "RETURN",
        237 => "RETURNS",
        238 => "REVOKE",
        239 => "RIGHT",
        240 => "RLIKE",
        241 => "ROLLBACK",
        242 => "ROLLUP",
        243 => "ROW",
        244 => "ROWS",
        245 => "ROW_FORMAT",
        246 => "SECOND",
        247 => "SECURITY",
        248 => "SELECT",
        249 => "SEPARATOR",
        250 => "SERIALIZABLE",
        251 => "SESSION",
        252 => "SET",
        253 => "SHARE",
        254 => "SHOW",
        255 => "SHUTDOWN",
        256 => "SLAVE",
        257 => "SONAME",
        258 => "SOUNDS",
        259 => "SQL",
        260 => "SQL_AUTO_IS_NULL",
        261 => "SQL_BIG_RESULT",
        262 => "SQL_BIG_SELECTS",
        263 => "SQL_BIG_TABLES",
        264 => "SQL_BUFFER_RESULT",
        265 => "SQL_CACHE",
        266 => "SQL_CALC_FOUND_ROWS",
        267 => "SQL_LOG_BIN",
        268 => "SQL_LOG_OFF",
        269 => "SQL_LOG_UPDATE",
        270 => "SQL_LOW_PRIORITY_UPDATES",
        271 => "SQL_MAX_JOIN_SIZE",
        272 => "SQL_NO_CACHE",
        273 => "SQL_QUOTE_SHOW_CREATE",
        274 => "SQL_SAFE_UPDATES",
        275 => "SQL_SELECT_LIMIT",
        276 => "SQL_SLAVE_SKIP_COUNTER",
        277 => "SQL_SMALL_RESULT",
        278 => "SQL_WARNINGS",
        279 => "START",
        280 => "STARTING",
        281 => "STATUS",
        282 => "STOP",
        283 => "STORAGE",
        284 => "STRAIGHT_JOIN",
        285 => "STRING",
        286 => "STRIPED",
        287 => "SUPER",
        288 => "TABLE",
        289 => "TABLES",
        290 => "TEMPORARY",
        291 => "TERMINATED",
        292 => "THEN",
        293 => "TO",
        294 => "TRAILING",
        295 => "TRANSACTIONAL",
        296 => "TRUE",
        297 => "TRUNCATE",
        298 => "TYPE",
        299 => "TYPES",
        300 => "UNCOMMITTED",
        301 => "UNION",
        302 => "UNION ALL",
        303 => "UNIQUE",
        304 => "UNLOCK",
        305 => "UNSIGNED",
        306 => "UPDATE",
        307 => "USAGE",
        308 => "USE",
        309 => "USING",
        310 => "VALUES",
        311 => "VARIABLES",
        312 => "VIEW",
        313 => "WHEN",
        314 => "WHERE",
        315 => "WITH",
        316 => "WORK",
        317 => "WRITE",
        318 => "XOR",
        319 => "YEAR_MONTH",
        320 => "ABS",
        321 => "ACOS",
        322 => "ADDDATE",
        323 => "ADDTIME",
        324 => "AES_DECRYPT",
        325 => "AES_ENCRYPT",
        326 => "AREA",
        327 => "ASBINARY",
        328 => "ASCII",
        329 => "ASIN",
        330 => "ASTEXT",
        331 => "ATAN",
        332 => "ATAN2",
        333 => "AVG",
        334 => "BDMPOLYFROMTEXT",
        335 => "BDMPOLYFROMWKB",
        336 => "BDPOLYFROMTEXT",
        337 => "BDPOLYFROMWKB",
        338 => "BENCHMARK",
        339 => "BIN",
        340 => "BIT_AND",
        341 => "BIT_COUNT",
        342 => "BIT_LENGTH",
        343 => "BIT_OR",
        344 => "BIT_XOR",
        345 => "BOUNDARY",
        346 => "BUFFER",
        347 => "CAST",
        348 => "CEIL",
        349 => "CEILING",
        350 => "CENTROID",
        351 => "CHAR",
        352 => "CHARACTER_LENGTH",
        353 => "CHARSET",
        354 => "CHAR_LENGTH",
        355 => "COALESCE",
        356 => "COERCIBILITY",
        357 => "COLLATION",
        358 => "COMPRESS",
        359 => "CONCAT",
        360 => "CONCAT_WS",
        361 => "CONNECTION_ID",
        362 => "CONTAINS",
        363 => "CONV",
        364 => "CONVERT",
        365 => "CONVERT_TZ",
        366 => "CONVEXHULL",
        367 => "COS",
        368 => "COT",
        369 => "COUNT",
        370 => "CRC32",
        371 => "CROSSES",
        372 => "CURDATE",
        373 => "CURRENT_DATE",
        374 => "CURRENT_TIME",
        375 => "CURRENT_TIMESTAMP",
        376 => "CURRENT_USER",
        377 => "CURTIME",
        378 => "DATABASE",
        379 => "DATE",
        380 => "DATEDIFF",
        381 => "DATE_ADD",
        382 => "DATE_DIFF",
        383 => "DATE_FORMAT",
        384 => "DATE_SUB",
        385 => "DAY",
        386 => "DAYNAME",
        387 => "DAYOFMONTH",
        388 => "DAYOFWEEK",
        389 => "DAYOFYEAR",
        390 => "DECODE",
        391 => "DEFAULT",
        392 => "DEGREES",
        393 => "DES_DECRYPT",
        394 => "DES_ENCRYPT",
        395 => "DIFFERENCE",
        396 => "DIMENSION",
        397 => "DISJOINT",
        398 => "DISTANCE",
        399 => "ELT",
        400 => "ENCODE",
        401 => "ENCRYPT",
        402 => "ENDPOINT",
        403 => "ENVELOPE",
        404 => "EQUALS",
        405 => "EXP",
        406 => "EXPORT_SET",
        407 => "EXTERIORRING",
        408 => "EXTRACT",
        409 => "EXTRACTVALUE",
        410 => "FIELD",
        411 => "FIND_IN_SET",
        412 => "FLOOR",
        413 => "FORMAT",
        414 => "FOUND_ROWS",
        415 => "FROM_DAYS",
        416 => "FROM_UNIXTIME",
        417 => "GEOMCOLLFROMTEXT",
        418 => "GEOMCOLLFROMWKB",
        419 => "GEOMETRYCOLLECTION",
        420 => "GEOMETRYCOLLECTIONFROMTEXT",
        421 => "GEOMETRYCOLLECTIONFROMWKB",
        422 => "GEOMETRYFROMTEXT",
        423 => "GEOMETRYFROMWKB",
        424 => "GEOMETRYN",
        425 => "GEOMETRYTYPE",
        426 => "GEOMFROMTEXT",
        427 => "GEOMFROMWKB",
        428 => "GET_FORMAT",
        429 => "GET_LOCK",
        430 => "GLENGTH",
        431 => "GREATEST",
        432 => "GROUP_CONCAT",
        433 => "GROUP_UNIQUE_USERS",
        434 => "HEX",
        435 => "HOUR",
        436 => "IF",
        437 => "IFNULL",
        438 => "INET_ATON",
        439 => "INET_NTOA",
        440 => "INSERT",
        441 => "INSTR",
        442 => "INTERIORRINGN",
        443 => "INTERSECTION",
        444 => "INTERSECTS",
        445 => "INTERVAL",
        446 => "ISCLOSED",
        447 => "ISEMPTY",
        448 => "ISNULL",
        449 => "ISRING",
        450 => "ISSIMPLE",
        451 => "IS_FREE_LOCK",
        452 => "IS_USED_LOCK",
        453 => "LAST_DAY",
        454 => "LAST_INSERT_ID",
        455 => "LCASE",
        456 => "LEAST",
        457 => "LEFT",
        458 => "LENGTH",
        459 => "LINEFROMTEXT",
        460 => "LINEFROMWKB",
        461 => "LINESTRING",
        462 => "LINESTRINGFROMTEXT",
        463 => "LINESTRINGFROMWKB",
        464 => "LN",
        465 => "LOAD_FILE",
        466 => "LOCALTIME",
        467 => "LOCALTIMESTAMP",
        468 => "LOCATE",
        469 => "LOG",
        470 => "LOG10",
        471 => "LOG2",
        472 => "LOWER",
        473 => "LPAD",
        474 => "LTRIM",
        475 => "MAKEDATE",
        476 => "MAKETIME",
        477 => "MAKE_SET",
        478 => "MASTER_POS_WAIT",
        479 => "MAX",
        480 => "MBRCONTAINS",
        481 => "MBRDISJOINT",
        482 => "MBREQUAL",
        483 => "MBRINTERSECTS",
        484 => "MBROVERLAPS",
        485 => "MBRTOUCHES",
        486 => "MBRWITHIN",
        487 => "MD5",
        488 => "MICROSECOND",
        489 => "MID",
        490 => "MIN",
        491 => "MINUTE",
        492 => "MLINEFROMTEXT",
        493 => "MLINEFROMWKB",
        494 => "MOD",
        495 => "MONTH",
        496 => "MONTHNAME",
        497 => "MPOINTFROMTEXT",
        498 => "MPOINTFROMWKB",
        499 => "MPOLYFROMTEXT",
        500 => "MPOLYFROMWKB",
        501 => "MULTILINESTRING",
        502 => "MULTILINESTRINGFROMTEXT",
        503 => "MULTILINESTRINGFROMWKB",
        504 => "MULTIPOINT",
        505 => "MULTIPOINTFROMTEXT",
        506 => "MULTIPOINTFROMWKB",
        507 => "MULTIPOLYGON",
        508 => "MULTIPOLYGONFROMTEXT",
        509 => "MULTIPOLYGONFROMWKB",
        510 => "NAME_CONST",
        511 => "NULLIF",
        512 => "NUMGEOMETRIES",
        513 => "NUMINTERIORRINGS",
        514 => "NUMPOINTS",
        515 => "OCT",
        516 => "OCTET_LENGTH",
        517 => "OLD_PASSWORD",
        518 => "ORD",
        519 => "OVERLAPS",
        520 => "PASSWORD",
        521 => "PERIOD_ADD",
        522 => "PERIOD_DIFF",
        523 => "PI",
        524 => "POINT",
        525 => "POINTFROMTEXT",
        526 => "POINTFROMWKB",
        527 => "POINTN",
        528 => "POINTONSURFACE",
        529 => "POLYFROMTEXT",
        530 => "POLYFROMWKB",
        531 => "POLYGON",
        532 => "POLYGONFROMTEXT",
        533 => "POLYGONFROMWKB",
        534 => "POSITION",
        535 => "POW",
        536 => "POWER",
        537 => "QUARTER",
        538 => "QUOTE",
        539 => "RADIANS",
        540 => "RAND",
        541 => "RELATED",
        542 => "RELEASE_LOCK",
        543 => "REPEAT",
        544 => "REPLACE",
        545 => "REVERSE",
        546 => "RIGHT",
        547 => "ROUND",
        548 => "ROW_COUNT",
        549 => "RPAD",
        550 => "RTRIM",
        551 => "SCHEMA",
        552 => "SECOND",
        553 => "SEC_TO_TIME",
        554 => "SESSION_USER",
        555 => "SHA",
        556 => "SHA1",
        557 => "SIGN",
        558 => "SIN",
        559 => "SLEEP",
        560 => "SOUNDEX",
        561 => "SPACE",
        562 => "SQRT",
        563 => "SRID",
        564 => "STARTPOINT",
        565 => "STD",
        566 => "STDDEV",
        567 => "STDDEV_POP",
        568 => "STDDEV_SAMP",
        569 => "STRCMP",
        570 => "STR_TO_DATE",
        571 => "SUBDATE",
        572 => "SUBSTR",
        573 => "SUBSTRING",
        574 => "SUBSTRING_INDEX",
        575 => "SUBTIME",
        576 => "SUM",
        577 => "SYMDIFFERENCE",
        578 => "SYSDATE",
        579 => "SYSTEM_USER",
        580 => "TAN",
        581 => "TIME",
        582 => "TIMEDIFF",
        583 => "TIMESTAMP",
        584 => "TIMESTAMPADD",
        585 => "TIMESTAMPDIFF",
        586 => "TIME_FORMAT",
        587 => "TIME_TO_SEC",
        588 => "TOUCHES",
        589 => "TO_DAYS",
        590 => "TRIM",
        591 => "TRUNCATE",
        592 => "UCASE",
        593 => "UNCOMPRESS",
        594 => "UNCOMPRESSED_LENGTH",
        595 => "UNHEX",
        596 => "UNIQUE_USERS",
        597 => "UNIX_TIMESTAMP",
        598 => "UPDATEXML",
        599 => "UPPER",
        600 => "USER",
        601 => "UTC_DATE",
        602 => "UTC_TIME",
        603 => "UTC_TIMESTAMP",
        604 => "UUID",
        605 => "VARIANCE",
        606 => "VAR_POP",
        607 => "VAR_SAMP",
        608 => "VERSION",
        609 => "WEEK",
        610 => "WEEKDAY",
        611 => "WEEKOFYEAR",
        612 => "WITHIN",
        613 => "X",
        614 => "Y",
        615 => "YEAR",
        616 => "YEARWEEK",
    ]);
}

if (!defined("ryunosuke\\Functions\\JSON_MAX_DEPTH")) {
    /** json_*** 関数で $depth 引数を表す定数 */
    define("ryunosuke\\Functions\\JSON_MAX_DEPTH", -1);
}

if (!defined("ryunosuke\\Functions\\JSON_INDENT")) {
    /** json_*** 関数でインデント数・文字を指定する定数 */
    define("ryunosuke\\Functions\\JSON_INDENT", -71);
}

if (!defined("ryunosuke\\Functions\\JSON_CLOSURE")) {
    /** json_*** 関数でクロージャをサポートするかの定数 */
    define("ryunosuke\\Functions\\JSON_CLOSURE", -72);
}

if (!defined("ryunosuke\\Functions\\JSON_INLINE_LEVEL")) {
    /** json_*** 関数で一定以上の階層をインライン化するかの定数 */
    define("ryunosuke\\Functions\\JSON_INLINE_LEVEL", -73);
}

if (!defined("ryunosuke\\Functions\\JSON_INLINE_SCALARLIST")) {
    /** json_*** 関数でスカラーのみのリストをインライン化するかの定数 */
    define("ryunosuke\\Functions\\JSON_INLINE_SCALARLIST", -74);
}

if (!defined("ryunosuke\\Functions\\JSON_ES5")) {
    /** json_*** 関数で json5 を取り扱うかの定数 */
    define("ryunosuke\\Functions\\JSON_ES5", -100);
}

if (!defined("ryunosuke\\Functions\\JSON_INT_AS_STRING")) {
    /** json_*** 関数で整数を常に文字列で返すかの定数 */
    define("ryunosuke\\Functions\\JSON_INT_AS_STRING", -101);
}

if (!defined("ryunosuke\\Functions\\JSON_FLOAT_AS_STRING")) {
    /** json_*** 関数で小数を常に文字列で返すかの定数 */
    define("ryunosuke\\Functions\\JSON_FLOAT_AS_STRING", -102);
}

if (!defined("ryunosuke\\Functions\\JSON_TRAILING_COMMA")) {
    /** json_*** 関数で強制ケツカンマを振るかの定数 */
    define("ryunosuke\\Functions\\JSON_TRAILING_COMMA", -103);
}

if (!defined("ryunosuke\\Functions\\JSON_COMMENT_PREFIX")) {
    /** json_*** 関数でコメントを判定するプレフィックス定数 */
    define("ryunosuke\\Functions\\JSON_COMMENT_PREFIX", -104);
}

if (!defined("ryunosuke\\Functions\\TOKEN_NAME")) {
    /** parse_php 関数でトークン名変換をするか */
    define("ryunosuke\\Functions\\TOKEN_NAME", 2);
}

if (!defined("ryunosuke\\Functions\\SI_UNITS")) {
    /** SI 接頭辞 */
    define("ryunosuke\\Functions\\SI_UNITS", [
        -8 => ["y"],
        -7 => ["z"],
        -6 => ["a"],
        -5 => ["f"],
        -4 => ["p"],
        -3 => ["n"],
        -2 => ["u", "μ", "µ"],
        -1 => ["m"],
        0  => [],
        1  => ["k", "K"],
        2  => ["M"],
        3  => ["G"],
        4  => ["T"],
        5  => ["P"],
        6  => ["E"],
        7  => ["Z"],
        8  => ["Y"],
    ]);
}

if (!defined("ryunosuke\\Functions\\SORT_STRICT")) {
    /** SORT_XXX 定数の厳密版 */
    define("ryunosuke\\Functions\\SORT_STRICT", 256);
}


# functions
if (!isset($excluded_functions["arrays"]) && (!function_exists("ryunosuke\\Functions\\arrays") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\arrays"))->isInternal()))) {
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
     * foreach (arrays($array) as $n => [$k, $v]) {
     *     $nkv[] = "$n,$k,$v";
     * }
     * that($nkv)->isSame(['0,a,A', '1,b,B', '2,c,C']);
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
if (function_exists("ryunosuke\\Functions\\arrays") && !defined("ryunosuke\\Functions\\arrays")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\arrays", "ryunosuke\\Functions\\arrays");
}

if (!isset($excluded_functions["arrayize"]) && (!function_exists("ryunosuke\\Functions\\arrayize") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\arrayize"))->isInternal()))) {
    /**
     * 引数の配列を生成する。
     *
     * 配列以外を渡すと配列化されて追加される。
     * 連想配列は未対応。あくまで普通の配列化のみ。
     * iterable や Traversable は考慮せずあくまで「配列」としてチェックする。
     *
     * Example:
     * ```php
     * that(arrayize(1, 2, 3))->isSame([1, 2, 3]);
     * that(arrayize([1], [2], [3]))->isSame([1, 2, 3]);
     * $object = new \stdClass();
     * that(arrayize($object, false, [1, 2, 3]))->isSame([$object, false, 1, 2, 3]);
     * ```
     *
     * @param mixed ...$variadic 生成する要素（可変引数）
     * @return array 引数を配列化したもの
     */
    function arrayize(...$variadic)
    {
        $result = [];
        foreach ($variadic as $arg) {
            if (!is_array($arg)) {
                $result[] = $arg;
            }
            elseif (!is_hasharray($arg)) {
                $result = array_merge($result, $arg);
            }
            else {
                $result += $arg;
            }
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\arrayize") && !defined("ryunosuke\\Functions\\arrayize")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\arrayize", "ryunosuke\\Functions\\arrayize");
}

if (!isset($excluded_functions["is_indexarray"]) && (!function_exists("ryunosuke\\Functions\\is_indexarray") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\is_indexarray"))->isInternal()))) {
    /**
     * 配列が数値配列か調べる
     *
     * 空の配列も数値配列とみなす。
     * さらにいわゆる「連番配列」ではなく「キーが数値のみか？」で判定する。
     *
     * つまり、 is_hasharray とは排他的ではない。
     *
     * Example:
     * ```php
     * that(is_indexarray([]))->isTrue();
     * that(is_indexarray([1, 2, 3]))->isTrue();
     * that(is_indexarray(['x' => 'X']))->isFalse();
     * // 抜け番があっても true になる（これは is_hasharray も true になる）
     * that(is_indexarray([1 => 1, 2 => 2, 3 => 3]))->isTrue();
     * ```
     *
     * @param array $array 調べる配列
     * @return bool 数値配列なら true
     */
    function is_indexarray($array)
    {
        foreach ($array as $k => $dummy) {
            if (!is_int($k)) {
                return false;
            }
        }
        return true;
    }
}
if (function_exists("ryunosuke\\Functions\\is_indexarray") && !defined("ryunosuke\\Functions\\is_indexarray")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\is_indexarray", "ryunosuke\\Functions\\is_indexarray");
}

if (!isset($excluded_functions["is_hasharray"]) && (!function_exists("ryunosuke\\Functions\\is_hasharray") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\is_hasharray"))->isInternal()))) {
    /**
     * 配列が連想配列か調べる
     *
     * 空の配列は普通の配列とみなす。
     *
     * Example:
     * ```php
     * that(is_hasharray([]))->isFalse();
     * that(is_hasharray([1, 2, 3]))->isFalse();
     * that(is_hasharray(['x' => 'X']))->isTrue();
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
if (function_exists("ryunosuke\\Functions\\is_hasharray") && !defined("ryunosuke\\Functions\\is_hasharray")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\is_hasharray", "ryunosuke\\Functions\\is_hasharray");
}

if (!isset($excluded_functions["first_key"]) && (!function_exists("ryunosuke\\Functions\\first_key") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\first_key"))->isInternal()))) {
    /**
     * 配列の最初のキーを返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * that(first_key(['a', 'b', 'c']))->isSame(0);
     * that(first_key([], 999))->isSame(999);
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
        [$k, $v] = first_keyvalue($array);
        return $k;
    }
}
if (function_exists("ryunosuke\\Functions\\first_key") && !defined("ryunosuke\\Functions\\first_key")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\first_key", "ryunosuke\\Functions\\first_key");
}

if (!isset($excluded_functions["first_value"]) && (!function_exists("ryunosuke\\Functions\\first_value") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\first_value"))->isInternal()))) {
    /**
     * 配列の最初の値を返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * that(first_value(['a', 'b', 'c']))->isSame('a');
     * that(first_value([], 999))->isSame(999);
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
        [$k, $v] = first_keyvalue($array);
        return $v;
    }
}
if (function_exists("ryunosuke\\Functions\\first_value") && !defined("ryunosuke\\Functions\\first_value")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\first_value", "ryunosuke\\Functions\\first_value");
}

if (!isset($excluded_functions["first_keyvalue"]) && (!function_exists("ryunosuke\\Functions\\first_keyvalue") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\first_keyvalue"))->isInternal()))) {
    /**
     * 配列の最初のキー/値ペアをタプルで返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * that(first_keyvalue(['a', 'b', 'c']))->isSame([0, 'a']);
     * that(first_keyvalue([], 999))->isSame(999);
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
if (function_exists("ryunosuke\\Functions\\first_keyvalue") && !defined("ryunosuke\\Functions\\first_keyvalue")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\first_keyvalue", "ryunosuke\\Functions\\first_keyvalue");
}

if (!isset($excluded_functions["last_key"]) && (!function_exists("ryunosuke\\Functions\\last_key") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\last_key"))->isInternal()))) {
    /**
     * 配列の最後のキーを返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * that(last_key(['a', 'b', 'c']))->isSame(2);
     * that(last_key([], 999))->isSame(999);
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
        [$k, $v] = last_keyvalue($array);
        return $k;
    }
}
if (function_exists("ryunosuke\\Functions\\last_key") && !defined("ryunosuke\\Functions\\last_key")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\last_key", "ryunosuke\\Functions\\last_key");
}

if (!isset($excluded_functions["last_value"]) && (!function_exists("ryunosuke\\Functions\\last_value") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\last_value"))->isInternal()))) {
    /**
     * 配列の最後の値を返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * that(last_value(['a', 'b', 'c']))->isSame('c');
     * that(last_value([], 999))->isSame(999);
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
        [$k, $v] = last_keyvalue($array);
        return $v;
    }
}
if (function_exists("ryunosuke\\Functions\\last_value") && !defined("ryunosuke\\Functions\\last_value")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\last_value", "ryunosuke\\Functions\\last_value");
}

if (!isset($excluded_functions["last_keyvalue"]) && (!function_exists("ryunosuke\\Functions\\last_keyvalue") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\last_keyvalue"))->isInternal()))) {
    /**
     * 配列の最後のキー/値ペアをタプルで返す
     *
     * 空の場合は $default を返す。
     *
     * Example:
     * ```php
     * that(last_keyvalue(['a', 'b', 'c']))->isSame([2, 'c']);
     * that(last_keyvalue([], 999))->isSame(999);
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
            $k = array_key_last($array);
            return [$k, $array[$k]];
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
if (function_exists("ryunosuke\\Functions\\last_keyvalue") && !defined("ryunosuke\\Functions\\last_keyvalue")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\last_keyvalue", "ryunosuke\\Functions\\last_keyvalue");
}

if (!isset($excluded_functions["prev_key"]) && (!function_exists("ryunosuke\\Functions\\prev_key") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\prev_key"))->isInternal()))) {
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
     * that(prev_key($array, 'b'))->isSame('a');
     * // 'a' キーの前は無いので null
     * that(prev_key($array, 'a'))->isSame(null);
     * // 'x' キーはそもそも存在しないので false
     * that(prev_key($array, 'x'))->isSame(false);
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
if (function_exists("ryunosuke\\Functions\\prev_key") && !defined("ryunosuke\\Functions\\prev_key")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\prev_key", "ryunosuke\\Functions\\prev_key");
}

if (!isset($excluded_functions["next_key"]) && (!function_exists("ryunosuke\\Functions\\next_key") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\next_key"))->isInternal()))) {
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
     * that(next_key($array, 'b'))->isSame('c');
     * // 'c' キーの次は無いので null
     * that(next_key($array, 'c'))->isSame(null);
     * // 'x' キーはそもそも存在しないので false
     * that(next_key($array, 'x'))->isSame(false);
     * // 次に生成されるキーは 10
     * that(next_key($array, null))->isSame(10);
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
if (function_exists("ryunosuke\\Functions\\next_key") && !defined("ryunosuke\\Functions\\next_key")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\next_key", "ryunosuke\\Functions\\next_key");
}

if (!isset($excluded_functions["in_array_and"]) && (!function_exists("ryunosuke\\Functions\\in_array_and") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\in_array_and"))->isInternal()))) {
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
     * that(in_array_and([1], [1, 2, 3]))->isTrue();
     * that(in_array_and([9], [1, 2, 3]))->isFalse();
     * that(in_array_and([1, 9], [1, 2, 3]))->isFalse();
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
if (function_exists("ryunosuke\\Functions\\in_array_and") && !defined("ryunosuke\\Functions\\in_array_and")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\in_array_and", "ryunosuke\\Functions\\in_array_and");
}

if (!isset($excluded_functions["in_array_or"]) && (!function_exists("ryunosuke\\Functions\\in_array_or") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\in_array_or"))->isInternal()))) {
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
     * that(in_array_or([1], [1, 2, 3]))->isTrue();
     * that(in_array_or([9], [1, 2, 3]))->isFalse();
     * that(in_array_or([1, 9], [1, 2, 3]))->isTrue();
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
if (function_exists("ryunosuke\\Functions\\in_array_or") && !defined("ryunosuke\\Functions\\in_array_or")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\in_array_or", "ryunosuke\\Functions\\in_array_or");
}

if (!isset($excluded_functions["kvsort"]) && (!function_exists("ryunosuke\\Functions\\kvsort") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\kvsort"))->isInternal()))) {
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
     * that(kvsort($array))->isSame([
     *     'b'  => 1,
     *     'c'  => 2,
     *     'a'  => 3,
     *     'x1' => 9,
     *     'x2' => 9,
     *     'x3' => 9,
     * ]);
     * // キーを使用したソート
     * that(kvsort($array, fn($av, $bv, $ak, $bk) => strcmp($bk, $ak)))->isSame([
     *     'x3' => 9,
     *     'x2' => 9,
     *     'x1' => 9,
     *     'c'  => 2,
     *     'b'  => 1,
     *     'a'  => 3,
     * ]);
     * ```
     *
     * @param iterable|array $array 対象配列
     * @param callable|int|null $comparator 比較関数。SORT_XXX も使える
     * @return array ソートされた配列
     */
    function kvsort($array, $comparator = null)
    {
        if ($comparator === null || is_int($comparator)) {
            $sort_flg = $comparator;
            $comparator = fn($av, $bv, $ak, $bk) => varcmp($av, $bv, $sort_flg);
        }

        $n = 0;
        $tmp = [];
        foreach ($array as $k => $v) {
            $tmp[$k] = [$n++, $k, $v];
        }

        uasort($tmp, fn($a, $b) => $comparator($a[2], $b[2], $a[1], $b[1]) ?: ($a[0] - $b[0]));

        foreach ($tmp as $k => $v) {
            $tmp[$k] = $v[2];
        }

        return $tmp;
    }
}
if (function_exists("ryunosuke\\Functions\\kvsort") && !defined("ryunosuke\\Functions\\kvsort")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\kvsort", "ryunosuke\\Functions\\kvsort");
}

if (!isset($excluded_functions["array_add"]) && (!function_exists("ryunosuke\\Functions\\array_add") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_add"))->isInternal()))) {
    /**
     * 配列の+演算子の関数版
     *
     * Example:
     * ```php
     * // ただの加算の関数版なので同じキーは上書きされない
     * that(array_add(['a', 'b', 'c'], ['X']))->isSame(['a', 'b', 'c']);
     * // 異なるキーは生える
     * that(array_add(['a', 'b', 'c'], ['x' => 'X']))->isSame(['a', 'b', 'c', 'x' => 'X']);
     * ```
     *
     * @param array ...$variadic 足す配列（可変引数）
     * @return array 足された配列
     */
    function array_add(...$variadic)
    {
        $array = [];
        foreach ($variadic as $arg) {
            $array += $arg;
        }
        return $array;
    }
}
if (function_exists("ryunosuke\\Functions\\array_add") && !defined("ryunosuke\\Functions\\array_add")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_add", "ryunosuke\\Functions\\array_add");
}

if (!isset($excluded_functions["array_append"]) && (!function_exists("ryunosuke\\Functions\\array_append") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_append"))->isInternal()))) {
    /**
     * 配列の末尾に要素を追加する
     *
     * array_push のキーが指定できる参照渡しでない版と言える。
     * キー指定でかつそのキーが存在するとき、値を変えつつ末尾に移動する動作となる。
     *
     * Example:
     * ```php
     * // キー未指定は言語機構を利用して末尾に追加される
     * that(array_append([1, 2, 3], 99))->is([1, 2, 3, 99]);
     * // キーを指定すればそのキーで生える
     * that(array_append([1, 2, 3], 99, 'newkey'))->is([1, 2, 3, 'newkey' => 99]);
     * // 存在する場合は値が変わって末尾に移動する
     * that(array_append([1, 2, 3], 99, 1))->is([0 => 1, 2 => 3, 1 => 99]);
     * ```
     *
     * @param array $array 対象配列
     * @return array 要素が追加された配列
     */
    function array_append($array, $value, $key = null)
    {
        if ($key === null) {
            $array[] = $value;
        }
        else {
            unset($array[$key]);
            $array[$key] = $value;
        }
        return $array;
    }
}
if (function_exists("ryunosuke\\Functions\\array_append") && !defined("ryunosuke\\Functions\\array_append")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_append", "ryunosuke\\Functions\\array_append");
}

if (!isset($excluded_functions["array_prepend"]) && (!function_exists("ryunosuke\\Functions\\array_prepend") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_prepend"))->isInternal()))) {
    /**
     * 配列の先頭に要素を追加する
     *
     * array_unshift のキーが指定できる参照渡しでない版と言える。
     * 配列の数値キーは振り直される。
     * キー指定でかつそのキーが存在するとき、値を変えつつ先頭に移動する動作となる。
     *
     * Example:
     * ```php
     * // キー未指定は0で挿入される
     * that(array_prepend([1, 2, 3], 99))->is([99, 1, 2, 3]);
     * // キーを指定すればそのキーで生える
     * that(array_prepend([1, 2, 3], 99, 'newkey'))->is(['newkey' => 99, 1, 2, 3]);
     * // 存在する場合は値が変わって先頭に移動する
     * that(array_prepend([1, 2, 3], 99, 1))->is([1 => 99, 0 => 1, 2 => 3]);
     * ```
     *
     * @param array $array 対象配列
     * @return array 要素が追加された配列
     */
    function array_prepend($array, $value, $key = null)
    {
        if ($key === null) {
            $array = array_merge([$value], $array);
        }
        else {
            $array = [$key => $value] + $array;
        }
        return $array;
    }
}
if (function_exists("ryunosuke\\Functions\\array_prepend") && !defined("ryunosuke\\Functions\\array_prepend")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_prepend", "ryunosuke\\Functions\\array_prepend");
}

if (!isset($excluded_functions["array_merge2"]) && (!function_exists("ryunosuke\\Functions\\array_merge2") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_merge2"))->isInternal()))) {
    /**
     * 配列をマージして通常配列＋αで返す
     *
     * キー・値が維持される点で array_merge とは異なる（振り直しをせず数値配列で返す）。
     * きちんと0からの連番で構成される点で配列の加算とは異なる。
     * 要するに「できるだけキーが自然数（の並び）になるように」マージする。
     *
     * 歯抜けはそのまま維持され、文字キーは後ろに追加される（負数キーも同様）。
     *
     * Example:
     * ```php
     * // キーが入り乱れているがよく見ると通し番号が振られている配列をマージ
     * that(array_merge2([4 => 4, 1 => 1], [0 => 0], [5 => 5, 2 => 2, 3 => 3]))->isSame([0, 1, 2, 3, 4, 5]);
     * // 歯抜けの配列をマージ
     * that(array_merge2([4 => 4, 1 => 1], [0 => 0], [5 => 5, 3 => 3]))->isSame([0, 1, 3 => 3, 4 => 4, 5 => 5]);
     * // 負数や文字キーは後ろに追いやられる
     * that(array_merge2(['a' => 'A', 1 => 1], [0 => 0], [-1 => 'X', 2 => 2, 3 => 3]))->isSame([0, 1, 2, 3, -1 => 'X', 'a' => 'A']);
     * // 同じキーは後ろ優先
     * that(array_merge2([0, 'a' => 'A0'], [1, 'a' => 'A1'], [2, 'a' => 'A2']))->isSame([2, 'a' => 'A2']);
     * ```
     *
     * @param array ...$arrays マージする配列
     * @return array マージされた配列
     */
    function array_merge2(...$arrays)
    {
        // array_merge を模倣するため前方優先
        $arrays = array_reverse($arrays);

        // 最大値の導出（負数は考慮せず文字キーとして扱う）
        $max = -1;
        foreach ($arrays as $array) {
            foreach ($array as $k => $v) {
                if (is_int($k) && $k > $max) {
                    $max = $k;
                }
            }
        }

        // 最大値までを埋める
        $result = [];
        for ($i = 0; $i <= $max; $i++) {
            foreach ($arrays as $array) {
                if (isset($array[$i]) && array_key_exists($i, $array)) {
                    $result[$i] = $array[$i];
                    break;
                }
            }
        }

        // 上記は数値キーだけなので負数や文字キーを補完する
        foreach ($arrays as $arg) {
            $result += $arg;
        }

        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_merge2") && !defined("ryunosuke\\Functions\\array_merge2")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_merge2", "ryunosuke\\Functions\\array_merge2");
}

if (!isset($excluded_functions["array_mix"]) && (!function_exists("ryunosuke\\Functions\\array_mix") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_mix"))->isInternal()))) {
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
     * that(array_mix([1, 3, 5], [2, 4, 6]))->isSame([1, 2, 3, 4, 5, 6]);
     * // 長さが異なる場合はそのまま追加される（短い方の足りない分は無視される）
     * that(array_mix([1], [2, 3, 4]))->isSame([1, 2, 3, 4]);
     * that(array_mix([1, 3, 4], [2]))->isSame([1, 2, 3, 4]);
     * // 可変引数なので3配列以上も可
     * that(array_mix([1], [2, 4], [3, 5, 6]))->isSame([1, 2, 3, 4, 5, 6]);
     * that(array_mix([1, 4, 6], [2, 5], [3]))->isSame([1, 2, 3, 4, 5, 6]);
     * // 文字キーは維持される
     * that(array_mix(['a' => 'A', 1, 3], ['b' => 'B', 2]))->isSame(['a' => 'A', 'b' => 'B', 1, 2, 3]);
     * ```
     *
     * @param array ...$variadic 対象配列（可変引数）
     * @return array 引数配列が交互に追加された配列
     */
    function array_mix(...$variadic)
    {
        assert(count(array_filter($variadic, fn($v) => !is_array($v))) === 0);

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
if (function_exists("ryunosuke\\Functions\\array_mix") && !defined("ryunosuke\\Functions\\array_mix")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_mix", "ryunosuke\\Functions\\array_mix");
}

if (!isset($excluded_functions["array_zip"]) && (!function_exists("ryunosuke\\Functions\\array_zip") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_zip"))->isInternal()))) {
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
     * that(array_zip(
     *     [1, 2, 3],
     *     ['hoge', 'fuga', 'piyo']
     * ))->is([[1, 'hoge'], [2, 'fuga'], [3, 'piyo']]);
     * // キーが維持される
     * that(array_zip(
     *     ['a' => 1, 2, 3],
     *     ['hoge', 'b' => 'fuga', 'piyo']
     * ))->is([['a' => 1, 'hoge'], [2, 'b' => 'fuga'], [3, 'piyo']]);
     * ```
     *
     * @param array ...$arrays 対象配列（可変引数）
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
            return array_map(fn($v) => [$v], $arrays[0]);
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
if (function_exists("ryunosuke\\Functions\\array_zip") && !defined("ryunosuke\\Functions\\array_zip")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_zip", "ryunosuke\\Functions\\array_zip");
}

if (!isset($excluded_functions["array_cross"]) && (!function_exists("ryunosuke\\Functions\\array_cross") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_cross"))->isInternal()))) {
    /**
     * 配列の直積を返す
     *
     * 文字キーは保存されるが数値キーは再割り振りされる。
     * ただし、文字キーが重複すると例外を投げる。
     *
     * Example:
     * ```php
     * // 普通の直積
     * that(array_cross(
     *     [1, 2],
     *     [3, 4]
     * ))->isSame([[1, 3], [1, 4], [2, 3], [2, 4]]);
     * // キーが維持される
     * that(array_cross(
     *     ['a' => 1, 2],
     *     ['b' => 3, 4]
     * ))->isSame([['a' => 1, 'b' => 3], ['a' => 1, 4], [2, 'b' => 3], [2, 4]]);
     * ```
     *
     * @param array ...$arrays 対象配列（可変引数）
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
if (function_exists("ryunosuke\\Functions\\array_cross") && !defined("ryunosuke\\Functions\\array_cross")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_cross", "ryunosuke\\Functions\\array_cross");
}

if (!isset($excluded_functions["array_implode"]) && (!function_exists("ryunosuke\\Functions\\array_implode") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_implode"))->isInternal()))) {
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
     * that(array_implode(['a', 'b', 'c'], 'X'))->isSame(['a', 'X', 'b', 'X', 'c']);
     * // (要素, ...配列) の呼び出し
     * that(array_implode('X', 'a', 'b', 'c'))->isSame(['a', 'X', 'b', 'X', 'c']);
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
if (function_exists("ryunosuke\\Functions\\array_implode") && !defined("ryunosuke\\Functions\\array_implode")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_implode", "ryunosuke\\Functions\\array_implode");
}

if (!isset($excluded_functions["array_explode"]) && (!function_exists("ryunosuke\\Functions\\array_explode") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_explode"))->isInternal()))) {
    /**
     * 配列を指定条件で分割する
     *
     * 文字列の explode を更に一階層掘り下げたイメージ。
     * $condition で指定された要素は結果配列に含まれない。
     *
     * $condition にはクロージャが指定できる。クロージャの場合は true 相当を返した場合に分割要素とみなされる。
     * 引数は (値, キー)の順番。
     *
     * $limit に負数を与えると「その絶対値-1までを結合したものと残り」を返す。
     * 端的に言えば「正数を与えると後詰めでその個数で返す」「負数を与えると前詰めでその（絶対値）個数で返す」という動作になる。
     *
     * Example:
     * ```php
     * // null 要素で分割
     * that(array_explode(['a', null, 'b', 'c'], null))->isSame([['a'], [2 => 'b', 3 => 'c']]);
     * // クロージャで分割（大文字で分割）
     * that(array_explode(['a', 'B', 'c', 'D', 'e'], fn($v) => ctype_upper($v)))->isSame([['a'], [2 => 'c'], [4 => 'e']]);
     * // 負数指定
     * that(array_explode(['a', null, 'b', null, 'c'], null, -2))->isSame([[0 => 'a', 1 => null, 2 => 'b'], [4 => 'c']]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param mixed $condition 分割条件
     * @param int $limit 最大分割数
     * @return array 分割された配列
     */
    function array_explode($array, $condition, $limit = \PHP_INT_MAX)
    {
        $array = arrayval($array, false);

        $limit = (int) $limit;
        if ($limit < 0) {
            // キーまで考慮するとかなりややこしくなるので富豪的にやる
            $reverse = array_explode(array_reverse($array, true), $condition, -$limit);
            $reverse = array_map(fn($v) => array_reverse($v, true), $reverse);
            return array_reverse($reverse);
        }
        // explode において 0 は 1 と等しい
        if ($limit === 0) {
            $limit = 1;
        }

        $result = [];
        $chunk = [];
        $n = -1;
        foreach ($array as $k => $v) {
            $n++;

            if ($limit === 1) {
                $chunk = array_slice($array, $n, null, true);
                break;
            }

            if ($condition instanceof \Closure) {
                $match = $condition($v, $k, $n);
            }
            else {
                $match = $condition === $v;
            }

            if ($match) {
                $limit--;
                $result[] = $chunk;
                $chunk = [];
            }
            else {
                $chunk[$k] = $v;
            }
        }
        $result[] = $chunk;
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_explode") && !defined("ryunosuke\\Functions\\array_explode")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_explode", "ryunosuke\\Functions\\array_explode");
}

if (!isset($excluded_functions["array_sprintf"]) && (!function_exists("ryunosuke\\Functions\\array_sprintf") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_sprintf"))->isInternal()))) {
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
     * that(array_sprintf($array, '%2$s=%1$s'))->isSame(['key1=val1', 'key2=val2']);
     * // 第3引数を与えるとさらに implode される
     * that(array_sprintf($array, '%2$s=%1$s', ' '))->isSame('key1=val1 key2=val2');
     * // クロージャを与えるとコールバック動作になる
     * $closure = fn($v, $k) => "$k=" . strtoupper($v);
     * that(array_sprintf($array, $closure, ' '))->isSame('key1=VAL1 key2=VAL2');
     * // 省略すると vsprintf になる
     * that(array_sprintf([
     *     'str:%s,int:%d' => ['sss', '3.14'],
     *     'single:%s'     => 'str',
     * ], null, '|'))->isSame('str:sss,int:3|single:str');
     * ```
     *
     * @param iterable $array 対象配列
     * @param string|callable|null $format 書式文字列あるいはクロージャ
     * @param ?string $glue 結合文字列。未指定時は implode しない
     * @return array|string sprintf された配列
     */
    function array_sprintf($array, $format = null, $glue = null)
    {
        if (is_callable($format)) {
            $callback = func_user_func_array($format);
        }
        elseif ($format === null) {
            $callback = fn($v, $k, $n) => vsprintf($k, is_array($v) ? $v : [$v]);
        }
        else {
            $callback = fn($v, $k, $n) => sprintf($format, $v, $k);
        }

        $result = [];
        $n = 0;
        foreach ($array as $k => $v) {
            $result[] = $callback($v, $k, $n++);
        }

        if ($glue !== null) {
            return implode($glue, $result);
        }

        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_sprintf") && !defined("ryunosuke\\Functions\\array_sprintf")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_sprintf", "ryunosuke\\Functions\\array_sprintf");
}

if (!isset($excluded_functions["array_strpad"]) && (!function_exists("ryunosuke\\Functions\\array_strpad") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_strpad"))->isInternal()))) {
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
     * that(array_strpad($array, 'prefix-'))->isSame(['prefix-key1' => 'val1', 'prefix-key2' => 'val2']);
     * // 値にサフィックス付与
     * that(array_strpad($array, '', ['-suffix']))->isSame(['key1' => 'val1-suffix', 'key2' => 'val2-suffix']);
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
            [$key_suffix, $key_prefix] = $key_prefix + [1 => ''];
        }
        $val_suffix = '';
        if (is_array($val_prefix)) {
            [$val_suffix, $val_prefix] = $val_prefix + [1 => ''];
        }

        $enable_key = strlen($key_prefix) || strlen($key_suffix);
        $enable_val = strlen($val_prefix) || strlen($val_suffix);

        $result = [];
        foreach ($array as $key => $val) {
            if ($enable_key) {
                $key = $key_prefix . $key . $key_suffix;
            }
            if ($enable_val) {
                $val = $val_prefix . $val . $val_suffix;
            }
            $result[$key] = $val;
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_strpad") && !defined("ryunosuke\\Functions\\array_strpad")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_strpad", "ryunosuke\\Functions\\array_strpad");
}

if (!isset($excluded_functions["array_pos"]) && (!function_exists("ryunosuke\\Functions\\array_pos") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_pos"))->isInternal()))) {
    /**
     * 配列・連想配列を問わず「N番目(0ベース)」の要素を返す
     *
     * 負数を与えると逆から N 番目となる。
     *
     * Example:
     * ```php
     * that(array_pos([1, 2, 3], 1))->isSame(2);
     * that(array_pos([1, 2, 3], -1))->isSame(3);
     * that(array_pos(['a' => 'A', 'b' => 'B', 'c' => 'C'], 1))->isSame('B');
     * that(array_pos(['a' => 'A', 'b' => 'B', 'c' => 'C'], 1, true))->isSame('b');
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
if (function_exists("ryunosuke\\Functions\\array_pos") && !defined("ryunosuke\\Functions\\array_pos")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_pos", "ryunosuke\\Functions\\array_pos");
}

if (!isset($excluded_functions["array_pos_key"]) && (!function_exists("ryunosuke\\Functions\\array_pos_key") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_pos_key"))->isInternal()))) {
    /**
     * 配列の指定キーの位置を返す
     *
     * Example:
     * ```php
     * that(array_pos_key(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'c'))->isSame(2);
     * that(array_pos_key(['a' => 'A', 'b' => 'B', 'c' => 'C'], 'x', -1))->isSame(-1);
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
if (function_exists("ryunosuke\\Functions\\array_pos_key") && !defined("ryunosuke\\Functions\\array_pos_key")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_pos_key", "ryunosuke\\Functions\\array_pos_key");
}

if (!isset($excluded_functions["array_of"]) && (!function_exists("ryunosuke\\Functions\\array_of") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_of"))->isInternal()))) {
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
     * that($fuga_of_array(['hoge' => 'HOGE', 'fuga' => 'FUGA']))->isSame('FUGA');
     * ```
     *
     * @param string|int|array $key 取得したいキー
     * @param mixed $default デフォルト値
     * @return \Closure $key の値を返すクロージャ
     */
    function array_of($key, $default = null)
    {
        $nodefault = func_num_args() === 1;
        return fn(array $array) => $nodefault ? array_get($array, $key) : array_get($array, $key, $default);
    }
}
if (function_exists("ryunosuke\\Functions\\array_of") && !defined("ryunosuke\\Functions\\array_of")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_of", "ryunosuke\\Functions\\array_of");
}

if (!isset($excluded_functions["array_get"]) && (!function_exists("ryunosuke\\Functions\\array_get") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_get"))->isInternal()))) {
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
     * that(array_get(['a', 'b', 'c'], 1))->isSame('b');
     * // 単純デフォルト
     * that(array_get(['a', 'b', 'c'], 9, 999))->isSame(999);
     * // 配列取得
     * that(array_get(['a', 'b', 'c'], [0, 2]))->isSame([0 => 'a', 2 => 'c']);
     * // 配列部分取得
     * that(array_get(['a', 'b', 'c'], [0, 9]))->isSame([0 => 'a']);
     * // 配列デフォルト（null ではなく [] を返す）
     * that(array_get(['a', 'b', 'c'], [9]))->isSame([]);
     * // クロージャ指定＆単値（コールバックが true を返す最初の要素）
     * that(array_get(['a', 'b', 'c'], fn($v) => in_array($v, ['b', 'c'])))->isSame('b');
     * // クロージャ指定＆配列（コールバックが true を返すもの）
     * that(array_get(['a', 'b', 'c'], fn($v) => in_array($v, ['b', 'c']), []))->isSame([1 => 'b', 2 => 'c']);
     * ```
     *
     * @param array $array 配列
     * @param string|int|array|\Closure $key 取得したいキー。配列を与えると全て返す。クロージャの場合は true 相当を返す
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
            $n = 0;
            foreach ($array as $k => $v) {
                if ($key($v, $k, $n++)) {
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
if (function_exists("ryunosuke\\Functions\\array_get") && !defined("ryunosuke\\Functions\\array_get")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_get", "ryunosuke\\Functions\\array_get");
}

if (!isset($excluded_functions["array_set"]) && (!function_exists("ryunosuke\\Functions\\array_set") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_set"))->isInternal()))) {
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
     * that(array_set($array, 'Z'))->isSame(1);
     * that($array)->isSame(['a' => 'A', 'B', 'Z']);
     * // 第3引数でキーを指定
     * that(array_set($array, 'Z', 'z'))->isSame('z');
     * that($array)->isSame(['a' => 'A', 'B', 'Z', 'z' => 'Z']);
     * that(array_set($array, 'Z', 'z'))->isSame('z');
     * // 第3引数で配列を指定
     * that(array_set($array, 'Z', ['x', 'y', 'z']))->isSame('z');
     * that($array)->isSame(['a' => 'A', 'B', 'Z', 'z' => 'Z', 'x' => ['y' => ['z' => 'Z']]]);
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
if (function_exists("ryunosuke\\Functions\\array_set") && !defined("ryunosuke\\Functions\\array_set")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_set", "ryunosuke\\Functions\\array_set");
}

if (!isset($excluded_functions["array_put"]) && (!function_exists("ryunosuke\\Functions\\array_put") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_put"))->isInternal()))) {
    /**
     * キー指定の配列値設定
     *
     * array_set とほとんど同じ。
     * 第3引数を省略すると（null を与えると）言語機構を使用して配列の最後に設定する（$array[] = $value）。
     * また、**int を与えても同様の動作**となる。
     * 第3引数に配列を指定すると潜って設定する。
     *
     * 第4引数で追加する条件クロージャを指定できる。
     * クロージャには `(追加する要素, 追加するキー, 追加される元配列)` が渡ってくる。
     * このクロージャが false 相当を返した時は追加されないようになる。
     *
     * array_set における $require_return は廃止している。
     * これはもともと end や last_key が遅かったのでオプショナルにしていたが、もう改善しているし、7.3 から array_key_last があるので、呼び元で適宜使えば良い。
     *
     * Example:
     * ```php
     * $array = ['a' => 'A', 'B'];
     * // 第3引数 int
     * that(array_put($array, 'Z', 999))->isSame(1);
     * that($array)->isSame(['a' => 'A', 'B', 'Z']);
     * // 第3引数省略（最後に連番キーで設定）
     * that(array_put($array, 'Z'))->isSame(2);
     * that($array)->isSame(['a' => 'A', 'B', 'Z', 'Z']);
     * // 第3引数でキーを指定
     * that(array_put($array, 'Z', 'z'))->isSame('z');
     * that($array)->isSame(['a' => 'A', 'B', 'Z', 'Z', 'z' => 'Z']);
     * that(array_put($array, 'Z', 'z'))->isSame('z');
     * // 第3引数で配列を指定
     * that(array_put($array, 'Z', ['x', 'y', 'z']))->isSame('z');
     * that($array)->isSame(['a' => 'A', 'B', 'Z', 'Z', 'z' => 'Z', 'x' => ['y' => ['z' => 'Z']]]);
     * // 第4引数で条件を指定（キーが存在するなら追加しない）
     * that(array_put($array, 'Z', 'z', fn($v, $k, $array) => !isset($array[$k])))->isSame(false);
     * // 第4引数で条件を指定（値が存在するなら追加しない）
     * that(array_put($array, 'Z', null, fn($v, $k, $array) => !in_array($v, $array)))->isSame(false);
     * ```
     *
     * @param array $array 配列
     * @param mixed $value 設定する値
     * @param array|string|int|null $key 設定するキー
     * @param callable|null $condition 追加する条件
     * @return string|int|false 設定したキー
     */
    function array_put(&$array, $value, $key = null, $condition = null)
    {
        if (is_array($key)) {
            $k = array_shift($key);
            if ($key) {
                if (is_array($array) && array_key_exists($k, $array) && !is_array($array[$k])) {
                    throw new \InvalidArgumentException('$array[$k] is not array.');
                }
                return array_put(...[&$array[$k], $value, $key, $condition]);
            }
            else {
                return array_put(...[&$array, $value, $k, $condition]);
            }
        }

        if ($condition !== null) {
            if (!$condition($value, $key, $array)) {
                return false;
            }
        }

        if ($key === null || is_int($key)) {
            $array[] = $value;
            $key = array_key_last($array);
        }
        else {
            $array[$key] = $value;
        }
        return $key;
    }
}
if (function_exists("ryunosuke\\Functions\\array_put") && !defined("ryunosuke\\Functions\\array_put")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_put", "ryunosuke\\Functions\\array_put");
}

if (!isset($excluded_functions["array_unset"]) && (!function_exists("ryunosuke\\Functions\\array_unset") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_unset"))->isInternal()))) {
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
     * that(array_unset($array, 'x', 'X'))->isSame('X');
     * // 指定したキーを返す。そのキーは伏せられている
     * that(array_unset($array, 'a'))->isSame('A');
     * that($array)->isSame(['b' => 'B']);
     *
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // 配列を与えるとそれらを返す。そのキーは全て伏せられている
     * that(array_unset($array, ['a', 'b', 'x']))->isSame(['A', 'B']);
     * that($array)->isSame(['c' => 'C']);
     *
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // 配列のキーは返されるキーを表す。順番も維持される
     * that(array_unset($array, ['x2' => 'b', 'x1' => 'a']))->isSame(['x2' => 'B', 'x1' => 'A']);
     *
     * $array = ['hoge' => 'HOGE', 'fuga' => 'FUGA', 'piyo' => 'PIYO'];
     * // 値に "G" を含むものを返す。その要素は伏せられている
     * that(array_unset($array, fn($v) => strpos($v, 'G') !== false))->isSame(['hoge' => 'HOGE', 'fuga' => 'FUGA']);
     * that($array)->isSame(['piyo' => 'PIYO']);
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
            $n = 0;
            foreach ($array as $k => $v) {
                if ($key($v, $k, $n++)) {
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
if (function_exists("ryunosuke\\Functions\\array_unset") && !defined("ryunosuke\\Functions\\array_unset")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_unset", "ryunosuke\\Functions\\array_unset");
}

if (!isset($excluded_functions["array_dive"]) && (!function_exists("ryunosuke\\Functions\\array_dive") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_dive"))->isInternal()))) {
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
     * that(array_dive($array, 'a.b.c'))->isSame('vvv');
     * that(array_dive($array, 'a.b.x', 9))->isSame(9);
     * // 配列を与えても良い。その場合 $delimiter 引数は意味をなさない
     * that(array_dive($array, ['a', 'b', 'c']))->isSame('vvv');
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
if (function_exists("ryunosuke\\Functions\\array_dive") && !defined("ryunosuke\\Functions\\array_dive")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_dive", "ryunosuke\\Functions\\array_dive");
}

if (!isset($excluded_functions["array_keys_exist"]) && (!function_exists("ryunosuke\\Functions\\array_keys_exist") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_keys_exist"))->isInternal()))) {
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
     * that(array_keys_exist(['a', 'b', 'c'], ['a' => 'A', 'b' => 'B', 'c' => 'C']))->isTrue();
     * // N は含まないので false
     * that(array_keys_exist(['a', 'b', 'N'], ['a' => 'A', 'b' => 'B', 'c' => 'C']))->isFalse();
     * // 配列を与えると潜る（日本語で言えば「a というキーと、x というキーとその中に x1, x2 というキーがあるか？」）
     * that(array_keys_exist(['a', 'x' => ['x1', 'x2']], ['a' => 'A', 'x' => ['x1' => 'X1', 'x2' => 'X2']]))->isTrue();
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
if (function_exists("ryunosuke\\Functions\\array_keys_exist") && !defined("ryunosuke\\Functions\\array_keys_exist")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_keys_exist", "ryunosuke\\Functions\\array_keys_exist");
}

if (!isset($excluded_functions["array_find"]) && (!function_exists("ryunosuke\\Functions\\array_find") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_find"))->isInternal()))) {
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
     * that(array_find(['a', 'b', '9'], 'ctype_digit'))->isSame(2);
     * that(array_find(['a', 'b', '9'], fn($v) => $v === 'b'))->isSame(1);
     * // 最初に見つかったコールバック結果を返す（最初の数字の2乗を返す）
     * $ifnumeric2power = fn($v) => ctype_digit($v) ? $v * $v : false;
     * that(array_find(['a', 'b', '9'], $ifnumeric2power, false))->isSame(81);
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

        $n = 0;
        foreach ($array as $k => $v) {
            $result = $callback($v, $k, $n++);
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
if (function_exists("ryunosuke\\Functions\\array_find") && !defined("ryunosuke\\Functions\\array_find")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_find", "ryunosuke\\Functions\\array_find");
}

if (!isset($excluded_functions["array_rekey"]) && (!function_exists("ryunosuke\\Functions\\array_rekey") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_rekey"))->isInternal()))) {
    /**
     * キーをマップ配列・callable で置換する
     *
     * 変換先・返り値が null だとその要素は取り除かれる。
     * callable 指定時の引数は `(キー, 値, 連番インデックス, 対象配列そのもの)` が渡ってくる。
     *
     * Example:
     * ```php
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // a は x に c は z に置換される
     * that(array_rekey($array, ['a' => 'x', 'c' => 'z']))->isSame(['x' => 'A', 'b' => 'B', 'z' => 'C']);
     * // b は削除され c は z に置換される
     * that(array_rekey($array, ['b' => null, 'c' => 'z']))->isSame(['a' => 'A', 'z' => 'C']);
     * // キーの交換にも使える（a ⇔ c）
     * that(array_rekey($array, ['a' => 'c', 'c' => 'a']))->isSame(['c' => 'A', 'b' => 'B', 'a' => 'C']);
     * // callable
     * that(array_rekey($array, 'strtoupper'))->isSame(['A' => 'A', 'B' => 'B', 'C' => 'C']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param array|callable $keymap マップ配列かキーを返すクロージャ
     * @return array キーが置換された配列
     */
    function array_rekey($array, $keymap)
    {
        // 互換性のため callable は配列以外に限定する
        $callable = ($keymap instanceof \Closure) || (!is_array($keymap) && is_callable($keymap));
        if ($callable) {
            $keymap = func_user_func_array($keymap);
        }

        $result = [];
        $n = 0;
        foreach ($array as $k => $v) {
            if ($callable) {
                $k = $keymap($k, $v, $n, $array);
                // null は突っ込まない（除去）
                if ($k !== null) {
                    $result[$k] = $v;
                }
            }
            elseif (array_key_exists($k, $keymap)) {
                // null は突っ込まない（除去）
                if ($keymap[$k] !== null) {
                    $result[$keymap[$k]] = $v;
                }
            }
            else {
                $result[$k] = $v;
            }
            $n++;
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_rekey") && !defined("ryunosuke\\Functions\\array_rekey")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_rekey", "ryunosuke\\Functions\\array_rekey");
}

if (!isset($excluded_functions["array_grep_key"]) && (!function_exists("ryunosuke\\Functions\\array_grep_key") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_grep_key"))->isInternal()))) {
    /**
     * キーを正規表現でフィルタする
     *
     * Example:
     * ```php
     * that(array_grep_key(['a' => 'A', 'aa' => 'AA', 'b' => 'B'], '#^a#'))->isSame(['a' => 'A', 'aa' => 'AA']);
     * that(array_grep_key(['a' => 'A', 'aa' => 'AA', 'b' => 'B'], '#^a#', true))->isSame(['b' => 'B']);
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
if (function_exists("ryunosuke\\Functions\\array_grep_key") && !defined("ryunosuke\\Functions\\array_grep_key")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_grep_key", "ryunosuke\\Functions\\array_grep_key");
}

if (!isset($excluded_functions["array_map_recursive"]) && (!function_exists("ryunosuke\\Functions\\array_map_recursive") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_map_recursive"))->isInternal()))) {
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
     * // デフォルトでは array_walk 等と同様に葉のみが渡ってくる（iterable も対象になる）
     * that(array_map_recursive([
     *     'k' => 'v',
     *     'c' => new \ArrayObject([
     *         'k1' => 'v1',
     *         'k2' => 'v2',
     *     ]),
     * ], 'strtoupper'))->isSame([
     *     'k' => 'V',
     *     'c' => [
     *         'k1' => 'V1',
     *         'k2' => 'V2',
     *     ],
     * ]);
     *
     * // ただし、その挙動は引数で変更可能
     * that(array_map_recursive([
     *     'k' => 'v',
     *     'c' => new \ArrayObject([
     *         'k1' => 'v1',
     *         'k2' => 'v2',
     *     ]),
     * ], 'gettype', false))->isSame([
     *     'k' => 'string',
     *     'c' => 'object',
     * ]);
     *
     * // さらに、自身にも適用できる（呼び出しは子が先で、本当の意味で「すべての要素」で呼び出される）
     * that((array_map_recursive)([
     *     'k' => 'v',
     *     'c' => [
     *         'k1' => 'v1',
     *         'k2' => 'v2',
     *     ],
     * ], function ($v) {
     *     // 配列は stdclass 化、それ以外は大文字化
     *     return is_array($v) ? (object) $v : strtoupper($v);
     * }, true, true))->is((object) [
     *     'k' => 'V',
     *     'c' => (object) [
     *         'k1' => 'V1',
     *         'k2' => 'V2',
     *     ],
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param bool $iterable is_iterable で判定するか
     * @param bool $apply_array 配列要素にもコールバックを適用するか
     * @return array map された新しい配列
     */
    function array_map_recursive($array, $callback, $iterable = true, $apply_array = false)
    {
        $callback = func_user_func_array($callback);

        // ↑の変換を再帰ごとにやるのは現実的ではないのでクロージャに閉じ込めて再帰する
        $main = static function ($array, $parent) use (&$main, $callback, $iterable, $apply_array) {
            $result = [];
            $n = 0;
            foreach ($array as $k => $v) {
                if (($iterable && is_iterable($v)) || (!$iterable && is_array($v))) {
                    $result[$k] = $main($v, $k);
                }
                else {
                    $result[$k] = $callback($v, $k, $n++);
                }
            }
            if ($apply_array) {
                return $callback($result, $parent, null);
            }
            return $result;
        };

        return $main($array, null);
    }
}
if (function_exists("ryunosuke\\Functions\\array_map_recursive") && !defined("ryunosuke\\Functions\\array_map_recursive")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_map_recursive", "ryunosuke\\Functions\\array_map_recursive");
}

if (!isset($excluded_functions["array_map_key"]) && (!function_exists("ryunosuke\\Functions\\array_map_key") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_map_key"))->isInternal()))) {
    /**
     * キーをマップして変換する
     *
     * $callback が null を返すとその要素は取り除かれる。
     *
     * Example:
     * ```php
     * that(array_map_key(['a' => 'A', 'b' => 'B'], 'strtoupper'))->isSame(['A' => 'A', 'B' => 'B']);
     * that(array_map_key(['a' => 'A', 'b' => 'B'], function () { }))->isSame([]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @return array キーが変換された新しい配列
     */
    function array_map_key($array, $callback)
    {
        $callback = func_user_func_array($callback);
        $result = [];
        $n = 0;
        foreach ($array as $k => $v) {
            $k2 = $callback($k, $v, $n++);
            if ($k2 !== null) {
                $result[$k2] = $v;
            }
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_map_key") && !defined("ryunosuke\\Functions\\array_map_key")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_map_key", "ryunosuke\\Functions\\array_map_key");
}

if (!isset($excluded_functions["array_filter_key"]) && (!function_exists("ryunosuke\\Functions\\array_filter_key") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_filter_key"))->isInternal()))) {
    /**
     * キーを主軸とした array_filter
     *
     * $callback が要求するなら値も渡ってくる。 php 5.6 の array_filter の ARRAY_FILTER_USE_BOTH と思えばよい。
     * ただし、完全な互換ではなく、引数順は ($k, $v) なので注意。
     *
     * Example:
     * ```php
     * that(array_filter_key(['a', 'b', 'c'], fn($k, $v) => $k !== 1))->isSame([0 => 'a', 2 => 'c']);
     * that(array_filter_key(['a', 'b', 'c'], fn($k, $v) => $v !== 'b'))->isSame([0 => 'a', 2 => 'c']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @return array $callback が true を返した新しい配列
     */
    function array_filter_key($array, $callback)
    {
        $callback = func_user_func_array($callback);
        $result = [];
        $n = 0;
        foreach ($array as $k => $v) {
            if ($callback($k, $v, $n++)) {
                $result[$k] = $v;
            }
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_filter_key") && !defined("ryunosuke\\Functions\\array_filter_key")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_filter_key", "ryunosuke\\Functions\\array_filter_key");
}

if (!isset($excluded_functions["array_where"]) && (!function_exists("ryunosuke\\Functions\\array_where") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_where"))->isInternal()))) {
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
     * that(array_where($array, 'flag'))->isSame([
     *     1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
     * ]);
     * // 'name' に 'h' を含むものだけ返す
     * $contain_h = fn($name) => strpos($name, 'h') !== false;
     * that(array_where($array, 'name', $contain_h))->isSame([
     *     0 => ['id' => 1, 'name' => 'hoge', 'flag' => false],
     * ]);
     * // $callback が引数2つならキーも渡ってくる（キーが 2 のものだけ返す）
     * $equal_2 = fn($row, $key) => $key === 2;
     * that(array_where($array, null, $equal_2))->isSame([
     *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
     * ]);
     * // $column に配列を渡すと共通項が渡ってくる
     * $idname_is_2fuga = fn($idname) => ($idname['id'] . $idname['name']) === '2fuga';
     * that(array_where($array, ['id', 'name'], $idname_is_2fuga))->isSame([
     *     1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
     * ]);
     * // $column に連想配列を渡すと「キーのカラム == 値」で filter する（要するに「name が piyo かつ flag が false」で filter）
     * that(array_where($array, ['name' => 'piyo', 'flag' => false]))->isSame([
     *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
     * ]);
     * // 上記において値に配列を渡すと in_array で判定される
     * that(array_where($array, ['id' => [2, 3]]))->isSame([
     *     1 => ['id' => 2, 'name' => 'fuga', 'flag' => true],
     *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
     * ]);
     * // $column の連想配列の値にはコールバックが渡せる（それぞれで AND）
     * that(array_where($array, [
     *     'id'   => fn($id) => $id >= 3,                       // id が 3 以上
     *     'name' => fn($name) => strpos($name, 'o') !== false, // name に o を含む
     * ]))->isSame([
     *     2 => ['id' => 3, 'name' => 'piyo', 'flag' => false],
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string|array|null $column キー名
     * @param ?callable $callback 評価クロージャ
     * @return array $where が真を返した新しい配列
     */
    function array_where($array, $column = null, $callback = null)
    {
        if ($column instanceof \Closure) {
            $callback = $column;
            $column = null;
        }

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
                    if ($callback) {
                        return fn($v) => $v === $c;
                    }
                    else {
                        return fn($v) => is_array($c) ? in_array($v, $c) : $v == $c;
                    }
                }, $column);
                $callback = function ($vv, $k, $v) use ($callbacks) {
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

            if ($callback($vv, $k, $v)) {
                $result[$k] = $v;
            }
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_where") && !defined("ryunosuke\\Functions\\array_where")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_where", "ryunosuke\\Functions\\array_where");
}

if (!isset($excluded_functions["array_map_filter"]) && (!function_exists("ryunosuke\\Functions\\array_map_filter") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_map_filter"))->isInternal()))) {
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
     * that(array_map_filter([' a ', ' b ', ''], 'trim'))->isSame(['a', 'b']);
     * that(array_map_filter([' a ', ' b ', ''], 'trim', true))->isSame(['a', 'b', '']);
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
        $n = 0;
        foreach ($array as $k => $v) {
            $vv = $callback($v, $k, $n++);
            if (($strict && $vv !== null) || (!$strict && $vv)) {
                $result[$k] = $vv;
            }
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_map_filter") && !defined("ryunosuke\\Functions\\array_map_filter")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_map_filter", "ryunosuke\\Functions\\array_map_filter");
}

if (!isset($excluded_functions["array_map_method"]) && (!function_exists("ryunosuke\\Functions\\array_map_method") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_map_method"))->isInternal()))) {
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
     * that(array_map_method([$exa, $exb], 'getMessage'))->isSame(['a', 'b']);
     * // getMessage で map されるが、メソッドが存在しない場合は取り除かれる
     * that(array_map_method([$exa, $exb, $std, null], 'getMessage', [], true))->isSame(['a', 'b']);
     * // getMessage で map されるが、メソッドが存在しない場合はそのまま返す
     * that(array_map_method([$exa, $exb, $std, null], 'getMessage', [], null))->isSame(['a', 'b', $std, null]);
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
            $array = array_filter(arrayval($array, false), fn($object) => is_callable([$object, $method]));
        }
        return array_map(function ($object) use ($method, $args, $ignore) {
            if ($ignore === null && !is_callable([$object, $method])) {
                return $object;
            }
            return ([$object, $method])(...$args);
        }, arrayval($array, false));
    }
}
if (function_exists("ryunosuke\\Functions\\array_map_method") && !defined("ryunosuke\\Functions\\array_map_method")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_map_method", "ryunosuke\\Functions\\array_map_method");
}

if (!isset($excluded_functions["array_maps"]) && (!function_exists("ryunosuke\\Functions\\array_maps") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_maps"))->isInternal()))) {
    /**
     * 複数コールバックを指定できる array_map
     *
     * 指定したコールバックで複数回回してマップする。
     * `array_maps($array, $f, $g)` は `array_map($g, array_map($f, $array))` とほぼ等しい。
     * ただし、引数は順番が違う（可変引数のため）し、コールバックが要求するならキーも渡ってくる。
     * さらに文字列関数で "..." から始まっているなら可変引数としてコールする。
     *
     * 少し変わった仕様として、コールバックに [$method => $args] を付けるとそれはメソッド呼び出しになる。
     * つまり各要素 $v に対して `$v->$method(...$args)` がマップ結果になる。
     * さらに引数が不要なら `@method` とするだけで良い。
     *
     * Example:
     * ```php
     * // 値を3乗したあと16進表記にして大文字化する
     * that(array_maps([1, 2, 3, 4, 5], rbind('pow', 3), 'dechex', 'strtoupper'))->isSame(['1', '8', '1B', '40', '7D']);
     * // キーも渡ってくる
     * that(array_maps(['a' => 'A', 'b' => 'B'], fn($v, $k) => "$k:$v"))->isSame(['a' => 'a:A', 'b' => 'b:B']);
     * // ... で可変引数コール
     * that(array_maps([[1, 3], [1, 5, 2]], '...range'))->isSame([[1, 2, 3], [1, 3, 5]]);
     * // メソッドコールもできる（引数不要なら `@method` でも同じ）
     * that(array_maps([new \Exception('a'), new \Exception('b')], ['getMessage' => []]))->isSame(['a', 'b']);
     * that(array_maps([new \Exception('a'), new \Exception('b')], '@getMessage'))->isSame(['a', 'b']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable ...$callbacks 評価クロージャ配列
     * @return array 評価クロージャを通した新しい配列
     */
    function array_maps($array, ...$callbacks)
    {
        $result = arrayval($array, false);
        foreach ($callbacks as $callback) {
            if (is_string($callback) && $callback[0] === '@') {
                $margs = [];
                $vargs = false;
                $callback = substr($callback, 1);
            }
            elseif (is_array($callback) && count($callback) === 1) {
                $margs = reset($callback);
                $vargs = false;
                $callback = key($callback);
            }
            elseif (is_string($callback) && substr($callback, 0, 3) === '...') {
                $margs = null;
                $vargs = true;
                $callback = substr($callback, 3);
            }
            else {
                $margs = null;
                $vargs = false;
                $callback = func_user_func_array($callback);
            }
            $n = 0;
            foreach ($result as $k => $v) {
                if (isset($margs)) {
                    $result[$k] = ([$v, $callback])(...$margs);
                }
                elseif ($vargs) {
                    $result[$k] = $callback(...$v);
                }
                else {
                    $result[$k] = $callback($v, $k, $n++);
                }
            }
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_maps") && !defined("ryunosuke\\Functions\\array_maps")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_maps", "ryunosuke\\Functions\\array_maps");
}

if (!isset($excluded_functions["array_kvmap"]) && (!function_exists("ryunosuke\\Functions\\array_kvmap") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_kvmap"))->isInternal()))) {
    /**
     * 配列の各キー・値にコールバックを適用する
     *
     * $callback は (キー, 値, $callback) が渡ってくるので 「その位置に配置したい配列」を返せばそこに置換される。
     * つまり、空配列を返せばそのキー・値は消えることになるし、複数の配列を返せば要素が増えることになる。
     * ただし、数値キーは新しく採番される。
     * null を返すと特別扱いで、そのキー・値をそのまま維持する。
     * iterable を返す必要があるが、もし iterable でない場合は配列キャストされる。
     *
     * 「map も filter も可能でキー変更可能」というとてもマッチョな関数。
     * 実質的には「数値キーが再採番される再帰的でない array_convert」のように振る舞う。
     * ただし、再帰処理はないので自前で管理する必要がある。
     *
     * Example:
     * ```php
     * $array = [
     *    'a' => 'A',
     *    'b' => 'B',
     *    'c' => 'C',
     *    'd' => 'D',
     * ];
     * // キーに '_' 、値に 'prefix-' を付与。'b' は一切何もしない。'c' は値のみ。'd' はそれ自体伏せる
     * that(array_kvmap($array, function ($k, $v) {
     *     if ($k === 'b') return null;
     *     if ($k === 'd') return [];
     *     if ($k !== 'c') $k = "_$k";
     *     return [$k => "prefix-$v"];
     * }))->isSame([
     *     '_a' => 'prefix-A',
     *     'b'  => 'B',
     *     'c'  => 'prefix-C',
     * ]);
     *
     * // 複数返せばその分増える（要素の水増し）
     * that(array_kvmap($array, fn($k, $v) => [
     *     "{$k}1" => "{$v}1",
     *     "{$k}2" => "{$v}2",
     * ]))->isSame([
     *    'a1' => 'A1',
     *    'a2' => 'A2',
     *    'b1' => 'B1',
     *    'b2' => 'B2',
     *    'c1' => 'C1',
     *    'c2' => 'C2',
     *    'd1' => 'D1',
     *    'd2' => 'D2',
     * ]);
     *
     * // $callback には $callback 自体も渡ってくるので再帰も比較的楽に書ける
     * that(array_kvmap([
     *     'x' => [
     *         'X',
     *         'y' => [
     *             'Y',
     *             'z' => ['Z'],
     *         ],
     *     ],
     * ], function ($k, $v, $callback) {
     *     // 配列だったら再帰する
     *     return ["_$k" => is_array($v) ? array_kvmap($v, $callback) : "prefix-$v"];
     * }))->isSame([
     *     "_x" => [
     *         "_0" => "prefix-X",
     *         "_y" => [
     *             "_0" => "prefix-Y",
     *             "_z" => [
     *                 "_0" => "prefix-Z",
     *             ],
     *         ],
     *     ],
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 適用するコールバック
     * @return array 変換された配列
     */
    function array_kvmap($array, $callback)
    {
        $result = [];
        foreach ($array as $k => $v) {
            $kv = $callback($k, $v, $callback) ?? [$k => $v];
            if (!is_iterable($kv)) {
                $kv = [$kv];
            }
            // $result = array_merge($result, $kv); // 遅すぎる
            foreach ($kv as $k2 => $v2) {
                if (is_int($k2)) {
                    $result[] = $v2;
                }
                else {
                    $result[$k2] = $v2;
                }
            }
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_kvmap") && !defined("ryunosuke\\Functions\\array_kvmap")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_kvmap", "ryunosuke\\Functions\\array_kvmap");
}

if (!isset($excluded_functions["array_kmap"]) && (!function_exists("ryunosuke\\Functions\\array_kmap") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_kmap"))->isInternal()))) {
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
     * that(array_kmap([
     *     'k1' => 'v1',
     *     'k2' => 'v2',
     *     'k3' => 'v3',
     * ], fn($v, $k) => "$k:$v"))->isSame([
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
if (function_exists("ryunosuke\\Functions\\array_kmap") && !defined("ryunosuke\\Functions\\array_kmap")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_kmap", "ryunosuke\\Functions\\array_kmap");
}

if (!isset($excluded_functions["array_nmap"]) && (!function_exists("ryunosuke\\Functions\\array_nmap") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_nmap"))->isInternal()))) {
    /**
     * 要素値を $callback の n 番目(0ベース)に適用して array_map する
     *
     * 引数 $n に配列を与えると [キー番目 => 値番目] とみなしてキー・値も渡される（Example 参照）。
     * その際、「挿入後の番目」ではなく、単純に「元の引数の番目」であることに留意。キー・値が同じ位置を指定している場合はキーが先にくる。
     *
     * Example:
     * ```php
     * // 1番目に値を渡して map
     * $sprintf = fn() => vsprintf('%s%s%s', func_get_args());
     * that(array_nmap(['a', 'b'], $sprintf, 1, 'prefix-', '-suffix'))->isSame(['prefix-a-suffix', 'prefix-b-suffix']);
     * // 1番目にキー、2番目に値を渡して map
     * $sprintf = fn() => vsprintf('%s %s %s %s %s', func_get_args());
     * that(array_nmap(['k' => 'v'], $sprintf, [1 => 2], 'a', 'b', 'c'))->isSame(['k' => 'a k b v c']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param int|array $n 要素値を入れる引数番目。配列を渡すとキー・値の両方を指定でき、両方が渡ってくる
     * @param mixed ...$variadic $callback に渡され、改変される引数（可変引数）
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
            [$kn, $vn] = first_keyvalue($n);

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
if (function_exists("ryunosuke\\Functions\\array_nmap") && !defined("ryunosuke\\Functions\\array_nmap")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_nmap", "ryunosuke\\Functions\\array_nmap");
}

if (!isset($excluded_functions["array_lmap"]) && (!function_exists("ryunosuke\\Functions\\array_lmap") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_lmap"))->isInternal()))) {
    /**
     * 要素値を $callback の最左に適用して array_map する
     *
     * Example:
     * ```php
     * $sprintf = fn() => vsprintf('%s%s', func_get_args());
     * that(array_lmap(['a', 'b'], $sprintf, '-suffix'))->isSame(['a-suffix', 'b-suffix']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param mixed ...$variadic $callback に渡され、改変される引数（可変引数）
     * @return array 評価クロージャを通した新しい配列
     */
    function array_lmap($array, $callback, ...$variadic)
    {
        return array_nmap(...array_insert(func_get_args(), 0, 2));
    }
}
if (function_exists("ryunosuke\\Functions\\array_lmap") && !defined("ryunosuke\\Functions\\array_lmap")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_lmap", "ryunosuke\\Functions\\array_lmap");
}

if (!isset($excluded_functions["array_rmap"]) && (!function_exists("ryunosuke\\Functions\\array_rmap") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_rmap"))->isInternal()))) {
    /**
     * 要素値を $callback の最右に適用して array_map する
     *
     * Example:
     * ```php
     * $sprintf = fn() => vsprintf('%s%s', func_get_args());
     * that(array_rmap(['a', 'b'], $sprintf, 'prefix-'))->isSame(['prefix-a', 'prefix-b']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback 評価クロージャ
     * @param mixed ...$variadic $callback に渡され、改変される引数（可変引数）
     * @return array 評価クロージャを通した新しい配列
     */
    function array_rmap($array, $callback, ...$variadic)
    {
        return array_nmap(...array_insert(func_get_args(), func_num_args() - 2, 2));
    }
}
if (function_exists("ryunosuke\\Functions\\array_rmap") && !defined("ryunosuke\\Functions\\array_rmap")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_rmap", "ryunosuke\\Functions\\array_rmap");
}

if (!isset($excluded_functions["array_each"]) && (!function_exists("ryunosuke\\Functions\\array_each") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_each"))->isInternal()))) {
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
     * that(array_each([1, 2, 3, 4, 5], function (&$carry, $v) {$carry .= $v;}, ''))->isSame('12345');
     * // 値をキーにして要素を2乗値にする
     * that(array_each([1, 2, 3, 4, 5], function (&$carry, $v) {$carry[$v] = $v * $v;}, []))->isSame([
     *     1 => 1,
     *     2 => 4,
     *     3 => 9,
     *     4 => 16,
     *     5 => 25,
     * ]);
     * // 上記と同じ。ただし、3 で break する
     * that(array_each([1, 2, 3, 4, 5], function (&$carry, $v, $k){
     *     if ($k === 3) return false;
     *     $carry[$v] = $v * $v;
     * }, []))->isSame([
     *     1 => 1,
     *     2 => 4,
     *     3 => 9,
     * ]);
     *
     * // 下記は完全に同じ（第3引数の代わりにデフォルト引数を使っている）
     * that(array_each([1, 2, 3], function (&$carry = [], $v = null) {
     *         $carry[$v] = $v * $v;
     *     }))->isSame(array_each([1, 2, 3], function (&$carry, $v) {
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
if (function_exists("ryunosuke\\Functions\\array_each") && !defined("ryunosuke\\Functions\\array_each")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_each", "ryunosuke\\Functions\\array_each");
}

if (!isset($excluded_functions["array_depth"]) && (!function_exists("ryunosuke\\Functions\\array_depth") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_depth"))->isInternal()))) {
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
     * that(array_depth([]))->isSame(1);
     * that(array_depth(['hoge']))->isSame(1);
     * that(array_depth([['nest1' => ['nest2']]]))->isSame(3);
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
            return 1 + max(array_map(fn($v) => $main($v, $depth + 1), $arrays));
        };

        return $main($array, 1);
    }
}
if (function_exists("ryunosuke\\Functions\\array_depth") && !defined("ryunosuke\\Functions\\array_depth")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_depth", "ryunosuke\\Functions\\array_depth");
}

if (!isset($excluded_functions["array_insert"]) && (!function_exists("ryunosuke\\Functions\\array_insert") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_insert"))->isInternal()))) {
    /**
     * 配列・連想配列を問わず任意の位置に値を挿入する
     *
     * $position を省略すると最後に挿入される（≒ array_push）。
     * $position に負数を与えると後ろから数えられる。
     * $value には配列も与えられるが、その場合数値キーは振り直される
     *
     * Example:
     * ```php
     * that(array_insert([1, 2, 3], 'x'))->isSame([1, 2, 3, 'x']);
     * that(array_insert([1, 2, 3], 'x', 1))->isSame([1, 'x', 2, 3]);
     * that(array_insert([1, 2, 3], 'x', -1))->isSame([1, 2, 'x', 3]);
     * that(array_insert([1, 2, 3], ['a' => 'A', 'b' => 'B'], 1))->isSame([1, 'a' => 'A', 'b' => 'B', 2, 3]);
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
if (function_exists("ryunosuke\\Functions\\array_insert") && !defined("ryunosuke\\Functions\\array_insert")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_insert", "ryunosuke\\Functions\\array_insert");
}

if (!isset($excluded_functions["array_assort"]) && (!function_exists("ryunosuke\\Functions\\array_assort") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_assort"))->isInternal()))) {
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
     * $lt2 = fn($v) => $v < 2;
     * that(array_assort([1, 2, 3], [
     *     'lt2' => $lt2,
     * ]))->isSame([
     *     'lt2' => [1],
     * ]);
     * // lt3(3より小さい)、ctd(ctype_digit)で分類（両方に属する要素が存在する）
     * $lt3 = fn($v) => $v < 3;
     * that(array_assort(['1', '2', '3'], [
     *     'lt3' => $lt3,
     *     'ctd' => 'ctype_digit',
     * ]))->isSame([
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
            $n = 0;
            foreach ($array as $k => $v) {
                if ($rule($v, $k, $n++)) {
                    $result[$name][$k] = $v;
                }
            }
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_assort") && !defined("ryunosuke\\Functions\\array_assort")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_assort", "ryunosuke\\Functions\\array_assort");
}

if (!isset($excluded_functions["array_count"]) && (!function_exists("ryunosuke\\Functions\\array_count") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_count"))->isInternal()))) {
    /**
     * 配列をコールバックに従ってカウントする
     *
     * コールバックが true 相当を返した要素をカウントして返す。
     * 普通に使う分には `count(array_filter($array, $callback))` とほとんど同じだが、下記の点が微妙に異なる。
     *
     * - $callback が要求するならキーも渡ってくる
     * - $callback には配列が渡せる。配列を渡した場合は件数を配列で返す（Example 参照）
     *
     * $recursive に true を渡すと再帰的に動作する。
     * 末端・配列を問わずに呼び出されるので場合によっては is_array などの判定が必要になる。
     *
     * Example:
     * ```php
     * $array = ['hoge', 'fuga', 'piyo'];
     * // 'o' を含むものの数（2個）
     * that(array_count($array, fn($s) => strpos($s, 'o') !== false))->isSame(2);
     * // 'a' と 'o' を含むものをそれぞれ（1個と2個）
     * that(array_count($array, [
     *     'a' => fn($s) => strpos($s, 'a') !== false,
     *     'o' => fn($s) => strpos($s, 'o') !== false,
     * ]))->isSame([
     *     'a' => 1,
     *     'o' => 2,
     * ]);
     *
     * // 再帰版
     * $array = [
     *     ['1', '2', '3'],
     *     ['a', 'b', 'c'],
     *     ['X', 'Y', 'Z'],
     *     [[[['a', 'M', 'Z']]]],
     * ];
     * that((array_count)($array, [
     *     'lower' => fn($v) => !is_array($v) && ctype_lower($v),
     *     'upper' => fn($v) => !is_array($v) && ctype_upper($v),
     *     'array' => fn($v) => is_array($v),
     * ], true))->is([
     *     'lower' => 4, // 小文字の数
     *     'upper' => 5, // 大文字の数
     *     'array' => 7, // 配列の数
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable $callback カウントルール。配列も渡せる
     * @param bool $recursive 再帰フラグ
     * @return int|array 条件一致した件数
     */
    function array_count($array, $callback, $recursive = false)
    {
        // 配列が来た場合はまるで動作が異なる（再帰でもいいがそれだと旨味がない。複数欲しいなら呼び出し元で複数回呼べば良い。ワンループに閉じ込めるからこそメリットがある））
        if (is_array($callback) && !is_callable($callback)) {
            $result = array_fill_keys(array_keys($callback), 0);
            foreach ($callback as $name => $rule) {
                $rule = func_user_func_array($rule);
                $n = 0;
                foreach ($array as $k => $v) {
                    if ($rule($v, $k, $n++)) {
                        $result[$name]++;
                    }
                    if ($recursive && is_iterable($v)) {
                        $result[$name] += array_count($v, $rule, $recursive);
                    }
                }
            }
            return $result;
        }

        $callback = func_user_func_array($callback);
        $result = 0;
        $n = 0;
        foreach ($array as $k => $v) {
            if ($callback($v, $k, $n++)) {
                $result++;
            }
            if ($recursive && is_iterable($v)) {
                $result += array_count($v, $callback, $recursive);
            }
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_count") && !defined("ryunosuke\\Functions\\array_count")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_count", "ryunosuke\\Functions\\array_count");
}

if (!isset($excluded_functions["array_group"]) && (!function_exists("ryunosuke\\Functions\\array_group") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_group"))->isInternal()))) {
    /**
     * 配列をコールバックの返り値でグループ化する
     *
     * コールバックを省略すると値そのもので評価する。
     * コールバックに配列・文字列を与えるとキーでグループ化する。
     * コールバックが配列を返すと入れ子としてグループ化する。
     *
     * Example:
     * ```php
     * that(array_group([1, 1, 1]))->isSame([
     *     1 => [1, 1, 1],
     * ]);
     * that(array_group([1, 2, 3], fn($v) => $v % 2))->isSame([
     *     1 => [1, 3],
     *     0 => [2],
     * ]);
     * // group -> id で入れ子グループにする
     * $row1 = ['id' => 1, 'group' => 'hoge'];
     * $row2 = ['id' => 2, 'group' => 'fuga'];
     * $row3 = ['id' => 3, 'group' => 'hoge'];
     * that(array_group([$row1, $row2, $row3], fn($row) => [$row['group'], $row['id']]))->isSame([
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
     * @param iterable $array 対象配列
     * @param ?callable|string|array $callback 評価クロージャ。 null なら値そのもので評価
     * @param bool $preserve_keys キーを保存するか。 false の場合数値キーは振り直される
     * @return array グルーピングされた配列
     */
    function array_group($array, $callback = null, $preserve_keys = false)
    {
        if ($callback !== null && !is_callable($callback)) {
            $callback = array_of($callback);
        }
        $callback = func_user_func_array($callback);

        $result = [];
        $n = 0;
        foreach ($array as $k => $v) {
            $vv = $callback($v, $k, $n++);
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
if (function_exists("ryunosuke\\Functions\\array_group") && !defined("ryunosuke\\Functions\\array_group")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_group", "ryunosuke\\Functions\\array_group");
}

if (!isset($excluded_functions["array_aggregate"]) && (!function_exists("ryunosuke\\Functions\\array_aggregate") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_aggregate"))->isInternal()))) {
    /**
     * 配列をコールバックの返り値で集計する
     *
     * $columns で集計列を指定する。
     * 単一の callable を渡すと結果も単一になる。
     * 複数の callable 連想配列を渡すと [キー => 集系列] の連想配列になる。
     * いずれにせよ引数としてそのグループの配列が渡ってくるので返り値がその列の値になる。
     * 第2引数には「今までの結果が詰まった配列」が渡ってくる（count, avg, sum など何度もでてくる集計で便利）。
     *
     * $key で集約列を指定する。
     * 指定しなければ引数の配列そのままで集計される。
     * 複数要素の配列を与えるとその数分潜って集計される。
     * クロージャを与えると返り値がキーになる。
     *
     * Example:
     * ```php
     * // 単純な配列の集計
     * that(array_aggregate([1, 2, 3], [
     *     'min' => fn($elems) => min($elems),
     *     'max' => fn($elems) => max($elems),
     *     'avg' => fn($elems) => array_sum($elems) / count($elems),
     * ]))->isSame([
     *     'min' => 1, // 最小値
     *     'max' => 3, // 最大値
     *     'avg' => 2, // 平均値
     * ]);
     *
     * $row1 = ['user_id' => 'hoge', 'group' => 'A', 'score' => 4];
     * $row2 = ['user_id' => 'fuga', 'group' => 'B', 'score' => 6];
     * $row3 = ['user_id' => 'fuga', 'group' => 'A', 'score' => 5];
     * $row4 = ['user_id' => 'hoge', 'group' => 'A', 'score' => 8];
     *
     * // user_id, group ごとの score を集計して階層配列で返す（第2引数 $current を利用している）
     * that(array_aggregate([$row1, $row2, $row3, $row4], [
     *     'scores' => fn($rows) => array_column($rows, 'score'),
     *     'score'  => fn($rows, $current) => array_sum($current['scores']),
     * ], ['user_id', 'group']))->isSame([
     *     'hoge' => [
     *         'A' => [
     *             'scores' => [4, 8],
     *             'score'  => 12,
     *         ],
     *     ],
     *     'fuga' => [
     *         'B' => [
     *             'scores' => [6],
     *             'score'  => 6,
     *         ],
     *         'A' => [
     *             'scores' => [5],
     *             'score'  => 5,
     *         ],
     *     ],
     * ]);
     *
     * // user_id ごとの score を集計して単一列で返す（キーのクロージャも利用している）
     * that(array_aggregate([$row1, $row2, $row3, $row4],
     *     fn($rows) => array_sum(array_column($rows, 'score')),
     *     fn($row) => strtoupper($row['user_id'])))->isSame([
     *     'HOGE' => 12,
     *     'FUGA' => 11,
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable|callable[] $columns 集計関数
     * @param string|array|null $key 集約列。クロージャを与えると返り値がキーになる
     * @return array 集約配列
     */
    function array_aggregate($array, $columns, $key = null)
    {
        if ($key === null) {
            $nest_level = 0;
        }
        elseif ($key instanceof \Closure) {
            $nest_level = 1;
        }
        elseif (is_string($key)) {
            $nest_level = 1;
            $key = array_of($key);
        }
        else {
            $nest_level = count($key);
            $key = array_of($key);
        }

        if ($key === null) {
            $group = arrayval($array);
        }
        else {
            $group = [];
            $n = 0;
            foreach ($array as $k => $v) {
                $vv = $key($v, $k, $n++);

                if (is_array($vv)) {
                    $tmp = &$group;
                    foreach ($vv as $vvv) {
                        $tmp = &$tmp[$vvv];
                    }
                    $tmp[] = $v;
                    unset($tmp);
                }
                else {
                    $group[$vv][$k] = $v;
                }
            }
        }

        if (!is_callable($columns)) {
            $columns = array_map(func_user_func_array, $columns);
        }

        $dive = function ($array, $level) use (&$dive, $columns) {
            $result = [];
            if ($level === 0) {
                if (is_callable($columns)) {
                    return $columns($array);
                }
                foreach ($columns as $name => $column) {
                    $result[$name] = $column($array, $result);
                }
            }
            else {
                foreach ($array as $k => $v) {
                    $result[$k] = $dive($v, $level - 1);
                }
            }
            return $result;
        };
        return $dive($group, $nest_level);
    }
}
if (function_exists("ryunosuke\\Functions\\array_aggregate") && !defined("ryunosuke\\Functions\\array_aggregate")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_aggregate", "ryunosuke\\Functions\\array_aggregate");
}

if (!isset($excluded_functions["array_all"]) && (!function_exists("ryunosuke\\Functions\\array_all") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_all"))->isInternal()))) {
    /**
     * 全要素が true になるなら true を返す（1つでも false なら false を返す）
     *
     * $callback が要求するならキーも渡ってくる。
     *
     * Example:
     * ```php
     * that(array_all([true, true]))->isTrue();
     * that(array_all([true, false]))->isFalse();
     * that(array_all([false, false]))->isFalse();
     * ```
     *
     * @param iterable $array 対象配列
     * @param ?callable $callback 評価クロージャ。 null なら値そのもので評価
     * @param bool|mixed $default 空配列の場合のデフォルト値
     * @return bool 全要素が true なら true
     */
    function array_all($array, $callback = null, $default = true)
    {
        if (is_empty($array)) {
            return $default;
        }

        $callback = func_user_func_array($callback);

        $n = 0;
        foreach ($array as $k => $v) {
            if (!$callback($v, $k, $n++)) {
                return false;
            }
        }
        return true;
    }
}
if (function_exists("ryunosuke\\Functions\\array_all") && !defined("ryunosuke\\Functions\\array_all")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_all", "ryunosuke\\Functions\\array_all");
}

if (!isset($excluded_functions["array_any"]) && (!function_exists("ryunosuke\\Functions\\array_any") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_any"))->isInternal()))) {
    /**
     * 全要素が false になるなら false を返す（1つでも true なら true を返す）
     *
     * $callback が要求するならキーも渡ってくる。
     *
     * Example:
     * ```php
     * that(array_any([true, true]))->isTrue();
     * that(array_any([true, false]))->isTrue();
     * that(array_any([false, false]))->isFalse();
     * ```
     *
     * @param iterable $array 対象配列
     * @param ?callable $callback 評価クロージャ。 null なら値そのもので評価
     * @param bool|mixed $default 空配列の場合のデフォルト値
     * @return bool 全要素が false なら false
     */
    function array_any($array, $callback = null, $default = false)
    {
        if (is_empty($array)) {
            return $default;
        }

        $callback = func_user_func_array($callback);

        $n = 0;
        foreach ($array as $k => $v) {
            if ($callback($v, $k, $n++)) {
                return true;
            }
        }
        return false;
    }
}
if (function_exists("ryunosuke\\Functions\\array_any") && !defined("ryunosuke\\Functions\\array_any")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_any", "ryunosuke\\Functions\\array_any");
}

if (!isset($excluded_functions["array_distinct"]) && (!function_exists("ryunosuke\\Functions\\array_distinct") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_distinct"))->isInternal()))) {
    /**
     * 比較関数が渡せる array_unique
     *
     * array_unique は微妙に癖があるのでシンプルに使いやすくしたもの。
     *
     * - SORT_STRING|SORT_FLAG_CASE のような指定が使える（大文字小文字を無視した重複除去）
     *   - 厳密に言えば array_unique も指定すれば動く（が、ドキュメントに記載がない）
     * - 配列を渡すと下記の動作になる
     *   - 数値キーは配列アクセス
     *   - 文字キーはメソッドコール（値は引数）
     * - もちろん（$a, $b を受け取る）クロージャも渡せる
     *
     * Example:
     * ```php
     * // シンプルな重複除去
     * that(array_distinct([1, 2, 3, '3']))->isSame([1, 2, 3]);
     * // 大文字小文字を無視した重複除去
     * that(array_distinct(['a', 'b', 'A', 'B'], SORT_STRING|SORT_FLAG_CASE))->isSame(['a', 'b']);
     *
     * $v1 = new \ArrayObject(['id' => '1', 'group' => 'aaa']);
     * $v2 = new \ArrayObject(['id' => '2', 'group' => 'bbb', 'dummy' => 123]);
     * $v3 = new \ArrayObject(['id' => '3', 'group' => 'aaa', 'dummy' => 456]);
     * $v4 = new \ArrayObject(['id' => '4', 'group' => 'bbb', 'dummy' => 789]);
     * // クロージャを指定して重複除去
     * that(array_distinct([$v1, $v2, $v3, $v4], fn($a, $b) => $a['group'] <=> $b['group']))->isSame([$v1, $v2]);
     * // 単純な配列アクセスなら文字列や配列でよい（上記と同じ結果になる）
     * that(array_distinct([$v1, $v2, $v3, $v4], 'group'))->isSame([$v1, $v2]);
     * // 文字キーの配列はメソッドコールになる（ArrayObject::count で重複検出）
     * that(array_distinct([$v1, $v2, $v3, $v4], ['count' => []]))->isSame([$v1, $v2]);
     * // 上記2つは混在できる（group キー + count メソッドで重複検出。端的に言えば "aaa+2", "bbb+3", "aaa+3", "bbb+3" で除去）
     * that(array_distinct([$v1, $v2, $v3, $v4], ['group', 'count' => []]))->isSame([$v1, $v2, 2 => $v3]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param callable|int|string|null $comparator 比較関数
     * @return array 重複が除去された配列
     */
    function array_distinct($array, $comparator = null)
    {
        // 配列化と個数チェック（1以下は重複のしようがないので不要）
        $array = arrayval($array, false);
        if (count($array) <= 1) {
            return $array;
        }

        // 省略時は宇宙船
        if ($comparator === null) {
            $comparator = static fn($a, $b) => $a <=> $b;
        }
        // 数字が来たら varcmp とする
        elseif (is_int($comparator)) {
            $comparator = static fn($a, $b) => varcmp($a, $b, $comparator);
        }
        // 文字列・配列が来たらキーアクセス/メソッドコールとする
        elseif (is_string($comparator) || is_array($comparator)) {
            $comparator = static function ($a, $b) use ($comparator) {
                foreach (arrayize($comparator) as $method => $args) {
                    if (is_int($method)) {
                        $delta = $a[$args] <=> $b[$args];
                    }
                    else {
                        $args = arrayize($args);
                        $delta = $a->$method(...$args) <=> $b->$method(...$args);
                    }
                    if ($delta !== 0) {
                        return $delta;
                    }
                }
                return 0;
            };
        }

        // 2重ループで探すよりは1度ソートしてしまったほうがマシ…だと思う（php の実装もそうだし）
        $backup = $array;
        uasort($array, $comparator);
        $keys = array_keys($array);

        // できるだけ元の順番は維持したいので、詰めて返すのではなくキーを導出して共通項を返す（ただし、この仕様は変えるかもしれない）
        $current = $keys[0];
        $keepkeys = [$current => null];
        for ($i = 1, $l = count($keys); $i < $l; $i++) {
            if ($comparator($array[$current], $array[$keys[$i]]) !== 0) {
                $current = $keys[$i];
                $keepkeys[$current] = null;
            }
        }
        return array_intersect_key($backup, $keepkeys);
    }
}
if (function_exists("ryunosuke\\Functions\\array_distinct") && !defined("ryunosuke\\Functions\\array_distinct")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_distinct", "ryunosuke\\Functions\\array_distinct");
}

if (!isset($excluded_functions["array_order"]) && (!function_exists("ryunosuke\\Functions\\array_order") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_order"))->isInternal()))) {
    /**
     * 配列を $orders に従って並べ替える
     *
     * データベースからフェッチしたような連想配列の配列を想定しているが、スカラー配列(['key' => 'value'])にも対応している。
     * その場合 $orders に配列ではなく直値を渡せば良い。
     *
     * $orders には下記のような配列を渡す。
     * キーに空文字を渡すとそれは「キー自体」を意味する。
     *
     * ```php
     * $orders = [
     *     'col1' => true,                      // true: 昇順, false: 降順。照合は型に依存
     *     'col2' => SORT_NATURAL,              // SORT_NATURAL, SORT_REGULAR などで照合。正数で昇順、負数で降順
     *     'col3' => ['sort', 'this', 'order'], // 指定した配列順で昇順
     *     'col4' => fn($v) => $v,              // クロージャを通した値で昇順。照合は返り値の型に依存
     *     'col5' => fn($a, $b) => $a - $b,     // クロージャで比較して昇順（いわゆる比較関数を渡す）
     * ];
     * ```
     *
     * Example:
     * ```php
     * $v1 = ['id' => '1', 'no' => 'a03', 'name' => 'yyy'];
     * $v2 = ['id' => '2', 'no' => 'a4',  'name' => 'yyy'];
     * $v3 = ['id' => '3', 'no' => 'a12', 'name' => 'xxx'];
     * // name 昇順, no 自然降順
     * that(array_order([$v1, $v2, $v3], ['name' => true, 'no' => -SORT_NATURAL]))->isSame([$v3, $v2, $v1]);
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
        $position = fn($columns, $order) => array_map(function ($v) use ($order) {
            $ndx = array_search($v, $order, true);
            return $ndx === false ? count($order) : $ndx;
        }, $columns);

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
                    $type = reflect_types($ref->getReturnType())->allows('string') ? 'string' : gettype(reset($arg));
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
if (function_exists("ryunosuke\\Functions\\array_order") && !defined("ryunosuke\\Functions\\array_order")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_order", "ryunosuke\\Functions\\array_order");
}

if (!isset($excluded_functions["array_shuffle"]) && (!function_exists("ryunosuke\\Functions\\array_shuffle") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_shuffle"))->isInternal()))) {
    /**
     * shuffle のキーが保存される＋参照渡しではない版
     *
     * Example:
     * ```php
     * that(array_shuffle(['a' => 'A', 'b' => 'B', 'c' => 'C']))->is(['b' => 'B', 'a' => 'A', 'c' => 'C']);
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
if (function_exists("ryunosuke\\Functions\\array_shuffle") && !defined("ryunosuke\\Functions\\array_shuffle")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_shuffle", "ryunosuke\\Functions\\array_shuffle");
}

if (!isset($excluded_functions["array_random"]) && (!function_exists("ryunosuke\\Functions\\array_random") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_random"))->isInternal()))) {
    /**
     * array_rand の要素版
     *
     * とはいえ多少の差異がある。
     *
     * - 第2引数に null を与えると単一の値として返す
     * - 第2引数に数値を与えると配列で返す（たとえ1でも配列で返す）
     * - 第2引数に 0 を与えてもエラーにはならない（空配列を返す）
     * - 第3引数に true を与えるとキーを維持して返す
     *
     * Example:
     * ```php
     * mt_srand(4); // テストがコケるので種固定
     * // 配列からランダムに値1件取得（単一で返す）
     * that(array_random(['a' => 'A', 'b' => 'B', 'c' => 'C']))->isSame('B');
     * // 配列からランダムに値2件取得（配列で返す）
     * that(array_random(['a' => 'A', 'b' => 'B', 'c' => 'C'], 2))->isSame(['B', 'C']);
     * // 配列からランダムに値2件取得（キーを維持）
     * that(array_random(['a' => 'A', 'b' => 'B', 'c' => 'C'], 2, true))->isSame(['a' => 'A', 'c' => 'C']);
     * ```
     *
     * @param array $array 対象配列
     * @param ?int $count 取り出す個数
     * @return mixed ランダムな要素
     */
    function array_random($array, $count = null, $preserve_keys = false)
    {
        if ($count === null) {
            return $array[array_rand($array)];
        }

        if (intval($count) === 0) {
            return [];
        }

        if ($count < 0 || count($array) < $count) {
            throw new \InvalidArgumentException('Argument #2 ($count) must be between 1 and the number of elements in argument #1 ($array)');
        }

        $result = [];
        foreach ((array) array_rand($array, $count) as $key) {
            if ($preserve_keys) {
                $result[$key] = $array[$key];
            }
            else {
                $result[] = $array[$key];
            }
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_random") && !defined("ryunosuke\\Functions\\array_random")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_random", "ryunosuke\\Functions\\array_random");
}

if (!isset($excluded_functions["array_shrink_key"]) && (!function_exists("ryunosuke\\Functions\\array_shrink_key") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_shrink_key"))->isInternal()))) {
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
     * that(array_shrink_key($array1, $array2, $array3))->isSame(['c' => 'C3']);
     * ```
     *
     * @param iterable|array ...$variadic 共通項を取る配列（可変引数）
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
if (function_exists("ryunosuke\\Functions\\array_shrink_key") && !defined("ryunosuke\\Functions\\array_shrink_key")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_shrink_key", "ryunosuke\\Functions\\array_shrink_key");
}

if (!isset($excluded_functions["array_extend"]) && (!function_exists("ryunosuke\\Functions\\array_extend") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_extend"))->isInternal()))) {
    /**
     * 独自拡張した array_replace_recursive
     *
     * 下記の点で array_replace_recursive と異なる。
     *
     * - 元配列のキーのみでフィルタされる
     * - 対象配列にクロージャを渡すと現在の状態を引数にしてコールバックされる
     * - 値に Generator や Generator 関数を渡すと最後にまとめて値化される
     *     - つまり、上書きされた値は実質的にコールされない
     * - recursive かどうかは 最初の引数で分岐する（jQuery の extend と同じ）
     * - recursive の場合、元配列の値が配列の場合のみ対象となる。配列でない場合は単純に上書きされる
     *     - 次の値が非配列の場合、末尾に追加される
     *     - 次の値がクロージャの場合、元の値を引数にしてコールバックされる
     *     - 次の値が配列の場合
     *         - 元配列が数値配列なら完全にマージされる
     *         - 元配列が連想配列なら再帰される
     *
     * この仕様上、Generator を値とする配列を対象にすることはできないが、そのような状況は稀だろう。
     * その代わり、使われるかどうか分からない状態でもとりあえず Generator にしておけば無駄な処理を省くことができる。
     *
     * Example:
     * ```php
     * # $deep ではない単純呼び出し
     * that(array_extend([
     *     'overwrite' => 'hoge',            // 後段で指定されているので上書きされる
     *     'through'   => 'fuga',            // 後段で指定されていないので生き残る
     *     'array'     => ['a', 'b', 'c'],   // $deep ではないし後段で指定されているので完全に上書きされる
     *     'yield1'    => fn() => yield 123, // 後段で指定されているのでコールすらされない
     *     'yield2'    => fn() => yield 456, // 後段で指定されていないのでコールされる
     * ], [
     *     'ignore'    => null,              // 元配列に存在しないのでスルーされる
     *     'overwrite' => 'HOGE',
     *     'array'     => ['x', 'y', 'z'],
     *     'yield1'    => fn() => yield 234,
     * ]))->is([
     *     'overwrite' => 'HOGE',
     *     'through'   => 'fuga',
     *     'array'     => ['x', 'y', 'z'],
     *     'yield1'    => 234,
     *     'yield2'    => 456,
     * ]);
     * # $deep の場合のマージ呼び出し
     * that(array_extend(true, [
     *     'array'    => ['hoge'],            // 後段がスカラーなので末尾に追加される
     *     'callback' => ['fuga'],            // 後段がクロージャなのでコールバックされる
     *     'list'     => ['a', 'b', 'c'],     // 数値配列なのでマージされる
     *     'hash'     => ['a' => null],       // 連想配列なので再帰される
     *     'yield'    => [fn() => yield 123], // generator は解決される
     * ], [
     *     'array'    => 'HOGE',
     *     'callback' => fn($v) => $v + [1 => 'FUGA'],
     *     'list'     => ['x', 'y', 'z'],
     *     'hash'     => ['a' => ['x' => ['y' => ['z' => 'xyz']]]],
     *     'yield'    => [fn() => yield 456],
     * ]))->is([
     *     'array'    => ['hoge', 'HOGE'],
     *     'callback' => ['fuga', 'FUGA'],
     *     'list'     => ['a', 'b', 'c', 'x', 'y', 'z'],
     *     'hash'     => ['a' => ['x' => ['y' => ['z' => 'xyz']]]],
     *     'yield'    => [123, 456],
     * ]);
     * ```
     *
     * @param array|bool $default 基準となる配列
     * @param iterable|\Closure ...$arrays マージする配列
     * @return array 新しい配列
     */
    function array_extend($default = [], ...$arrays)
    {
        $deep = false;
        if (is_bool($default)) {
            if (!$arrays) {
                throw new \InvalidArgumentException('target is empry');
            }
            $deep = $default;
            $default = array_shift($arrays);
        }

        $result = $default;

        foreach ($arrays as $array) {
            if ($array instanceof \Closure) {
                $array = $array($result);
            }
            if (!is_iterable($array)) {
                throw new \InvalidArgumentException('target is not array');
            }

            foreach ($array as $k => $v) {
                if (!array_key_exists($k, $result)) {
                    continue;
                }
                $current = $result[$k];
                if ($deep && is_array($current)) {
                    if (is_array($v)) {
                        if (is_indexarray($current)) {
                            $v = array_merge($current, $v);
                            $current = array_fill_keys(array_keys($v), null);
                        }
                        $v = array_extend($deep, $current, $v);
                    }
                    elseif ($v instanceof \Closure) {
                        $v = $v($current);
                    }
                    else {
                        $current[] = $v;
                        $v = $current;
                    }
                }
                $result[$k] = $v;
            }
        }

        foreach ($result as $k => $v) {
            if ($v instanceof \Closure && (new \ReflectionFunction($v))->isGenerator()) {
                $v = $v();
            }
            if ($v instanceof \Generator) {
                $result[$k] = is_array($default[$k]) ? iterator_to_array($v) : $v->current();
            }
        }

        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_extend") && !defined("ryunosuke\\Functions\\array_extend")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_extend", "ryunosuke\\Functions\\array_extend");
}

if (!isset($excluded_functions["array_fill_gap"]) && (!function_exists("ryunosuke\\Functions\\array_fill_gap") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_fill_gap"))->isInternal()))) {
    /**
     * 配列の隙間を埋める
     *
     * 「隙間」とは数値キーの隙間のこと。文字キーには関与しない。
     * 連番の抜けている箇所に $values の値を順次詰めていく動作となる。
     *
     * 値が足りなくてもエラーにはならない。つまり、この関数を通したとしても隙間が無くなるわけではない。
     * また、隙間を埋めても値が余る場合（隙間より与えられた値が多い場合）は末尾に全て追加される。
     *
     * 負数キーは考慮しない。
     *
     * Example:
     * ```php
     * // ところどころキーが抜け落ちている配列の・・・
     * $array = [
     *     1 => 'b',
     *     2 => 'c',
     *     5 => 'f',
     *     7 => 'h',
     * ];
     * // 抜けているところを可変引数で順次埋める（'i', 'j' は隙間というより末尾追加）
     * that(array_fill_gap($array, 'a', 'd', 'e', 'g', 'i', 'j'))->isSame([
     *     0 => 'a',
     *     1 => 'b',
     *     2 => 'c',
     *     3 => 'd',
     *     4 => 'e',
     *     5 => 'f',
     *     6 => 'g',
     *     7 => 'h',
     *     8 => 'i',
     *     9 => 'j',
     * ]);
     *
     * // 文字キーには関与しないし、値は足りなくても良い
     * $array = [
     *     1   => 'b',
     *     'x' => 'noize',
     *     4   => 'e',
     *     'y' => 'noize',
     *     7   => 'h',
     *     'z' => 'noize',
     * ];
     * // 文字キーはそのまま保持され、値が足りないので 6 キーはない
     * that(array_fill_gap($array, 'a', 'c', 'd', 'f'))->isSame([
     *     0   => 'a',
     *     1   => 'b',
     *     'x' => 'noize',
     *     2   => 'c',
     *     3   => 'd',
     *     4   => 'e',
     *     'y' => 'noize',
     *     5   => 'f',
     *     7   => 'h',
     *     'z' => 'noize',
     * ]);
     * ```
     *
     * @param array $array 対象配列
     * @param mixed ...$values 詰める値（可変引数）
     * @return array 隙間が詰められた配列
     */
    function array_fill_gap($array, ...$values)
    {
        $n = 0;
        $keys = array_keys($array);

        $result = [];
        for ($i = 0, $l = count($keys); $i < $l; $i++) {
            $key = $keys[$i];
            if (is_string($key)) {
                $result[$key] = $array[$key];
                continue;
            }

            if (array_key_exists($n, $array)) {
                $result[] = $array[$n];
            }
            elseif ($values) {
                $result[] = array_shift($values);
                $i--;
            }
            else {
                $result[$key] = $array[$key];
            }
            $n++;
        }
        if ($values) {
            $result = array_merge($result, $values);
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_fill_gap") && !defined("ryunosuke\\Functions\\array_fill_gap")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_fill_gap", "ryunosuke\\Functions\\array_fill_gap");
}

if (!isset($excluded_functions["array_fill_callback"]) && (!function_exists("ryunosuke\\Functions\\array_fill_callback") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_fill_callback"))->isInternal()))) {
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
     * that(array_fill_callback($abc, 'strtoupper'))->isSame([
     *     'a' => 'A',
     *     'b' => 'B',
     *     'c' => 'C',
     * ]);
     * // [a, b, c] からその sha1 配列を作って大文字化する
     * that(array_fill_callback($abc, fn($v) => strtoupper(sha1($v))))->isSame([
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
if (function_exists("ryunosuke\\Functions\\array_fill_callback") && !defined("ryunosuke\\Functions\\array_fill_callback")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_fill_callback", "ryunosuke\\Functions\\array_fill_callback");
}

if (!isset($excluded_functions["array_pickup"]) && (!function_exists("ryunosuke\\Functions\\array_pickup") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_pickup"))->isInternal()))) {
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
     * that(array_pickup($array, ['a', 'c']))->isSame(['a' => 'A', 'c' => 'C']);
     * // 順番は $keys 基準になる
     * that(array_pickup($array, ['c', 'a']))->isSame(['c' => 'C', 'a' => 'A']);
     * // 連想配列を渡すと読み替えて返す
     * that(array_pickup($array, ['c' => 'cX', 'a' => 'aX']))->isSame(['cX' => 'C', 'aX' => 'A']);
     * ```
     *
     * @param iterable $array 対象配列
     * @param array $keys 取り出すキー
     * @return array 新しい配列
     */
    function array_pickup($array, $keys)
    {
        $array = arrayval($array, false);

        $result = [];
        foreach (arrayval($keys, false) as $k => $key) {
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
if (function_exists("ryunosuke\\Functions\\array_pickup") && !defined("ryunosuke\\Functions\\array_pickup")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_pickup", "ryunosuke\\Functions\\array_pickup");
}

if (!isset($excluded_functions["array_remove"]) && (!function_exists("ryunosuke\\Functions\\array_remove") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_remove"))->isInternal()))) {
    /**
     * キーを指定してそれらを除いた配列にする
     *
     * `array_diff_key($array, array_flip($keys))` とほぼ同義。
     * 違いは Traversable を渡せること。
     *
     * array_pickup の逆とも言える。
     *
     * Example:
     * ```php
     * $array = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
     * // a と c を伏せる（b を残す）
     * that(array_remove($array, ['a', 'c']))->isSame(['b' => 'B']);
     * ```
     *
     * @param array|\Traversable $array 対象配列
     * @param array $keys 伏せるキー
     * @return array 新しい配列
     */
    function array_remove($array, $keys)
    {
        foreach (arrayval($keys, false) as $k) {
            unset($array[$k]);
        }
        return $array;
    }
}
if (function_exists("ryunosuke\\Functions\\array_remove") && !defined("ryunosuke\\Functions\\array_remove")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_remove", "ryunosuke\\Functions\\array_remove");
}

if (!isset($excluded_functions["array_lookup"]) && (!function_exists("ryunosuke\\Functions\\array_lookup") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_lookup"))->isInternal()))) {
    /**
     * キー保存可能な array_column
     *
     * array_column は キーを保存することが出来ないが、この関数は引数を2つだけ与えるとキーはそのままで array_column 相当の配列を返す。
     * 逆に第3引数にクロージャを与えるとその結果をキーにすることが出来る。
     *
     * Example:
     * ```php
     * $array = [
     *     11 => ['id' => 1, 'name' => 'name1'],
     *     12 => ['id' => 2, 'name' => 'name2'],
     *     13 => ['id' => 3, 'name' => 'name3'],
     * ];
     * // 第3引数を渡せば array_column と全く同じ
     * that(array_lookup($array, 'name', 'id'))->isSame(array_column($array, 'name', 'id'));
     * that(array_lookup($array, 'name', null))->isSame(array_column($array, 'name', null));
     * // 省略すればキーが保存される
     * that(array_lookup($array, 'name'))->isSame([
     *     11 => 'name1',
     *     12 => 'name2',
     *     13 => 'name3',
     * ]);
     * // クロージャを指定すればキーが生成される
     * that(array_lookup($array, 'name', fn($v, $k) => $k * 2))->isSame([
     *     22 => 'name1',
     *     24 => 'name2',
     *     26 => 'name3',
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string|null $column_key 値となるキー
     * @param string|\Closure|null $index_key キーとなるキー
     * @return array 新しい配列
     */
    function array_lookup($array, $column_key = null, $index_key = null)
    {
        $array = arrayval($array, false);

        if ($index_key instanceof \Closure) {
            return array_combine(array_kmap($array, $index_key), array_column($array, $column_key));
        }
        if (func_num_args() === 3) {
            return array_column($array, $column_key, $index_key);
        }
        return array_combine(array_keys($array), array_column($array, $column_key));
    }
}
if (function_exists("ryunosuke\\Functions\\array_lookup") && !defined("ryunosuke\\Functions\\array_lookup")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_lookup", "ryunosuke\\Functions\\array_lookup");
}

if (!isset($excluded_functions["array_select"]) && (!function_exists("ryunosuke\\Functions\\array_select") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_select"))->isInternal()))) {
    /**
     * 指定キーの要素で抽出する
     *
     * $columns に単純な値を渡すとそのキーの値を選択する。
     * キー付きで値を渡すと読み替えて選択する。
     * キー付きでクロージャを渡すと `(キーの値, 行自体, 現在行のキー)` を引数としてコールバックして選択する。
     * 単一のクロージャを渡すと `(行自体, 現在行のキー)` を引数としてコールバックして選択する（array_map とほぼ同じ）。
     *
     * Example:
     * ```php
     * $array = [
     *     11 => ['id' => 1, 'name' => 'name1'],
     *     12 => ['id' => 2, 'name' => 'name2'],
     *     13 => ['id' => 3, 'name' => 'name3'],
     * ];
     *
     * that(array_select($array, [
     *     'id',              // id を単純取得
     *     'alias' => 'name', // name を alias として取得
     * ]))->isSame([
     *     11 => ['id' => 1, 'alias' => 'name1'],
     *     12 => ['id' => 2, 'alias' => 'name2'],
     *     13 => ['id' => 3, 'alias' => 'name3'],
     * ]);
     *
     * that(array_select($array, [
     *     // id の 10 倍を取得
     *     'id'     => fn($id) => $id * 10,
     *     // id と name の結合を取得
     *     'idname' => fn($null, $row, $index) => $row['id'] . $row['name'],
     * ]))->isSame([
     *     11 => ['id' => 10, 'idname' => '1name1'],
     *     12 => ['id' => 20, 'idname' => '2name2'],
     *     13 => ['id' => 30, 'idname' => '3name3'],
     * ]);
     * ```
     *
     * @param iterable $array 対象配列
     * @param string|iterable|\Closure $columns 抽出項目
     * @param int|string|null $index キーとなるキー
     * @return array 新しい配列
     */
    function array_select($array, $columns, $index = null)
    {
        if (!is_iterable($columns) && !$columns instanceof \Closure) {
            return array_lookup(...func_get_args());
        }

        if ($columns instanceof \Closure) {
            $callbacks = $columns;
        }
        else {
            $callbacks = [];
            foreach ($columns as $alias => $column) {
                if ($column instanceof \Closure) {
                    $callbacks[$alias] = func_user_func_array($column);
                }
            }
        }

        $argcount = func_num_args();
        $result = [];
        $n = 0;
        foreach ($array as $k => $v) {
            if ($callbacks instanceof \Closure) {
                $row = $callbacks($v, $k, $n++);
            }
            else {
                $row = [];
                foreach ($columns as $alias => $column) {
                    if (is_int($alias)) {
                        $alias = $column;
                    }

                    if (isset($callbacks[$alias])) {
                        $row[$alias] = $callbacks[$alias](attr_get($alias, $v, null), $v, $k);
                    }
                    elseif (attr_exists($column, $v)) {
                        $row[$alias] = attr_get($column, $v);
                    }
                    else {
                        throw new \InvalidArgumentException("$column is not exists.");
                    }
                }
            }

            if ($argcount === 2) {
                $result[$k] = $row;
            }
            elseif ($index === null) {
                $result[] = $row;
            }
            elseif (array_key_exists($index, $row)) {
                $result[$row[$index]] = $row;
            }
            elseif (attr_exists($index, $v)) {
                $result[attr_get($index, $v)] = $row;
            }
            else {
                throw new \InvalidArgumentException("$index is not exists.");
            }
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_select") && !defined("ryunosuke\\Functions\\array_select")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_select", "ryunosuke\\Functions\\array_select");
}

if (!isset($excluded_functions["array_columns"]) && (!function_exists("ryunosuke\\Functions\\array_columns") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_columns"))->isInternal()))) {
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
     * that(array_columns($rows))->isSame(['id' => [1, 2], 'name' => ['A', 'B']]);
     * that(array_columns($rows, 'id'))->isSame(['id' => [1, 2]]);
     * that(array_columns($rows, 'name', 'id'))->isSame(['name' => [1 => 'A', 2 => 'B']]);
     * ```
     *
     * @param array $array 対象配列
     * @param string|array|null $column_keys 引っ張ってくるキー名
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
if (function_exists("ryunosuke\\Functions\\array_columns") && !defined("ryunosuke\\Functions\\array_columns")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_columns", "ryunosuke\\Functions\\array_columns");
}

if (!isset($excluded_functions["array_uncolumns"]) && (!function_exists("ryunosuke\\Functions\\array_uncolumns") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_uncolumns"))->isInternal()))) {
    /**
     * array_columns のほぼ逆で [キー => [要素]] 配列から連想配列の配列を生成する
     *
     * $template を指定すると「それに含まれる配列かつ値がデフォルト」になる（要するに $default みたいなもの）。
     * キーがバラバラな配列を指定する場合は指定したほうが良い。が、null を指定すると最初の要素が使われるので大抵の場合は null で良い。
     *
     * Example:
     * ```php
     * that(array_uncolumns([
     *     'id'   => [1, 2],
     *     'name' => ['A', 'B'],
     * ]))->isSame([
     *     ['id' => 1, 'name' => 'A'],
     *     ['id' => 2, 'name' => 'B'],
     * ]);
     * ```
     *
     * @param array $array 対象配列
     * @param ?array $template 抽出要素とそのデフォルト値
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
if (function_exists("ryunosuke\\Functions\\array_uncolumns") && !defined("ryunosuke\\Functions\\array_uncolumns")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_uncolumns", "ryunosuke\\Functions\\array_uncolumns");
}

if (!isset($excluded_functions["array_convert"]) && (!function_exists("ryunosuke\\Functions\\array_convert") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_convert"))->isInternal()))) {
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
     * $callback = function ($k, &$v) {
     *     if ($k === 'k21') return null;
     *     if ($k === 'k22') return false;
     *     if ($k === 'k23') return true;
     *     if (!is_array($v)) $v = "prefix-$v";
     *     return "_$k";
     * };
     * that(array_convert($array, $callback, true))->isSame([
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
if (function_exists("ryunosuke\\Functions\\array_convert") && !defined("ryunosuke\\Functions\\array_convert")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_convert", "ryunosuke\\Functions\\array_convert");
}

if (!isset($excluded_functions["array_flatten"]) && (!function_exists("ryunosuke\\Functions\\array_flatten") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_flatten"))->isInternal()))) {
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
     * that(array_flatten($array))->isSame([
     *    0 => 'v1',
     *    1 => 'v21',
     *    2 => 'v221',
     *    3 => 'v222',
     *    4 => 1,
     *    5 => 2,
     *    6 => 3,
     * ]);
     * // 区切り文字指定
     * that(array_flatten($array, '.'))->isSame([
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
     * @param string|\Closure|null $delimiter キーの区切り文字。 null を与えると連番になる
     * @return array フラット化された配列
     */
    function array_flatten($array, $delimiter = null)
    {
        $result = [];
        $core = function ($array, $delimiter, $parents) use (&$core, &$result) {
            foreach ($array as $k => $v) {
                $keys = $parents;
                $keys[] = $k;
                if (is_iterable($v)) {
                    $core($v, $delimiter, $keys);
                }
                else {
                    if ($delimiter === null) {
                        $result[] = $v;
                    }
                    elseif ($delimiter instanceof \Closure) {
                        $result[$delimiter($keys)] = $v;
                    }
                    else {
                        $result[implode($delimiter, $keys)] = $v;
                    }
                }
            }
        };

        $core($array, $delimiter, []);
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\array_flatten") && !defined("ryunosuke\\Functions\\array_flatten")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_flatten", "ryunosuke\\Functions\\array_flatten");
}

if (!isset($excluded_functions["array_nest"]) && (!function_exists("ryunosuke\\Functions\\array_nest") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_nest"))->isInternal()))) {
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
     * that(array_nest($array))->isSame([
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
     * that(array_nest($array))->isSame([
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
     *     that($e)->isInstanceOf(\InvalidArgumentException::class);
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
if (function_exists("ryunosuke\\Functions\\array_nest") && !defined("ryunosuke\\Functions\\array_nest")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_nest", "ryunosuke\\Functions\\array_nest");
}

if (!isset($excluded_functions["array_difference"]) && (!function_exists("ryunosuke\\Functions\\array_difference") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_difference"))->isInternal()))) {
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
     * that(array_difference([
     *     'common' => [
     *         'sub' => [
     *             'x' => 'val',
     *         ]
     *     ],
     *     'key1'   => 'hoge',
     *     'array'  => ['a', 'b', 'c'],
     * ], [
     *     'common' => [
     *         'sub' => [
     *             'x' => 'VAL',
     *         ]
     *     ],
     *     'key2'   => 'fuga',
     *     'array'  => ['c', 'd', 'e'],
     * ]))->isSame([
     *     'common.sub.x' => ['-' => 'val', '+' => 'VAL'],
     *     'key1'         => ['-' => 'hoge'],
     *     'array'        => ['-' => ['a', 'b'], '+' => ['d', 'e']],
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
            'list' => static fn($v, $k) => is_int($k),
            'hash' => static fn($v, $k) => !is_int($k),
        ];

        $udiff = static fn($a, $b) => $a <=> $b;

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
if (function_exists("ryunosuke\\Functions\\array_difference") && !defined("ryunosuke\\Functions\\array_difference")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_difference", "ryunosuke\\Functions\\array_difference");
}

if (!isset($excluded_functions["array_schema"]) && (!function_exists("ryunosuke\\Functions\\array_schema") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\array_schema"))->isInternal()))) {
    /**
     * 配列のスキーマを定義して配列を正規化する
     *
     * - type: 値の型を指定する
     *   - is_XXX の XXX 部分: 左記で検証
     *   - number: is_int or is_float で検証
     *   - class 名: instanceof で検証
     *   - list: 値がマージされて通常配列になる
     *     - list@string のようにすると配列の中身の型を指定できる
     *   - hash: 連想配列になる
     *   - string|int: string or int
     *   - ['string', 'int']: 上と同じ
     * - closure: 指定クロージャで検証・フィルタ
     *   - all: 値を引数に取り、返り値が新しい値となる
     * - unique: 重複を除去する
     *   - list: 重複除去（パラメータがソートアルゴリズムになる）
     * - enum: 値が指定値のいずれかであるか検証する
     *   - all: in_array で検証する
     * - min: 値が指定値以上であるか検証する
     *   - string: strlen で検証
     *   - list: count で検証
     *   - all: その値で検証
     * - max: 値が指定値以下であるか検証する
     *   - min の逆
     * - match: 値が正規表現にマッチするか検証する
     *   - all: preg_match で検証する
     * - unmatch: 値が正規表現にマッチしないか検証する
     *   - match の逆
     * - include: 値が指定値を含むか検証する
     *   - string: strpos で検証
     *   - list: in_array で検証
     * - exclude: 値が指定値を含まないか検証する
     *   - include の逆
     *
     * 検証・フィルタは原則として型を見ない（指定されていればすべて実行される）。
     * のでおかしな型におかしな検証・フィルタを与えると型エラーが出ることがある。
     *
     * 検証は途中経過を問わない。
     * 後ろの配列で上書きされた値や unique で減った配列などは以下に違反していても valid と判断される。
     *
     * 素直に json schema を使えという内なる声が聞こえなくもない。
     *
     * @param array $schema スキーマ配列
     * @param mixed ...$arrays 検証する配列（可変引数。マージされる）
     * @return array 正規化された配列
     */
    function array_schema($schema, ...$arrays)
    {
        $throw = function ($key, $value, $message) {
            $value = str_ellipsis(stringify($value), 32);
            throw new \DomainException("invalid value $key. $value must be $message");
        };
        // 検証兼フィルタ郡
        $validators = [
            'filter'    => function ($definition, $value, $key) use ($throw) {
                $filter = $definition['filter'];
                if (!is_array($filter)) {
                    $filter = [$filter];
                }
                if (($newvalue = filter_var($value, ...$filter)) === false) {
                    $filter_name = array_combine(array_map('filter_id', filter_list()), filter_list());
                    $throw($key, $value, "filter_var " . $filter_name[$filter[0]] . "(" . json_encode($filter[1] ?? []) . ")");
                }
                return $newvalue;
            },
            'type'      => function ($definition, $value, $key) use ($throw) {
                foreach ($definition['type'] as $type) {
                    if ($type === 'number' && (is_int($value) || is_float($value))) {
                        return $value;
                    }
                    if (function_exists($checker = "is_$type") && $checker($value)) {
                        return $value;
                    }
                    if (in_array($type, ['list', 'hash'], true) && is_array($value)) {
                        return $value;
                    }
                    if ($value instanceof $type) {
                        return $value;
                    }
                }
                $throw($key, $value, implode(' or ', $definition['type']));
            },
            'closure'   => function ($definition, $value, $key) use ($throw) {
                return $definition['closure']($value, $definition);
            },
            'unique'    => function ($definition, $value, $key) use ($throw) {
                return array_values(array_distinct($value, $definition['unique']));
            },
            'min'       => function ($definition, $value, $key) use ($throw) {
                if (is_string($value)) {
                    if (strlen($value) < $definition['min']) {
                        $throw($key, $value, "strlen >= {$definition['min']}");
                    }
                }
                elseif (is_array($value)) {
                    if (count($value) < $definition['min']) {
                        $throw($key, $value, "count >= {$definition['min']}");
                    }
                }
                elseif ($value < $definition['min']) {
                    $throw($key, $value, ">= {$definition['min']}");
                }
                return $value;
            },
            'max'       => function ($definition, $value, $key) use ($throw) {
                if (is_string($value)) {
                    if (strlen($value) > $definition['max']) {
                        $throw($key, $value, "strlen <= {$definition['max']}");
                    }
                }
                elseif (is_array($value)) {
                    if (count($value) > $definition['max']) {
                        $throw($key, $value, "count <= {$definition['max']}");
                    }
                }
                elseif ($value > $definition['max']) {
                    $throw($key, $value, "<= {$definition['max']}");
                }
                return $value;
            },
            'precision' => function ($definition, $value, $key) use ($throw) {
                $precision = $definition['precision'] + 1;
                if (preg_match("#\.\d{{$precision}}$#", $value)) {
                    $throw($key, $value, "precision {$definition['precision']}");
                }
                return $value;
            },
            'enum'      => function ($definition, $value, $key) use ($throw) {
                if (!in_array($value, $definition['enum'], true)) {
                    $throw($key, $value, "any of " . json_encode($definition['enum']));
                }
                return $value;
            },
            'match'     => function ($definition, $value, $key) use ($throw) {
                if (!preg_match($definition['match'], $value)) {
                    $throw($key, $value, "match {$definition['match']}");
                }
                return $value;
            },
            'unmatch'   => function ($definition, $value, $key) use ($throw) {
                if (preg_match($definition['unmatch'], $value)) {
                    $throw($key, $value, "unmatch {$definition['unmatch']}");
                }
                return $value;
            },
            'include'   => function ($definition, $value, $key) use ($throw) {
                if (is_array($value)) {
                    if (!in_array($definition['include'], $value)) {
                        $throw($key, $value, "include {$definition['include']}");
                    }
                }
                elseif (strpos($value, $definition['include']) === false) {
                    $throw($key, $value, "include {$definition['include']}");
                }
                return $value;
            },
            'exclude'   => function ($definition, $value, $key) use ($throw) {
                if (is_array($value)) {
                    if (in_array($definition['exclude'], $value)) {
                        $throw($key, $value, "exclude {$definition['exclude']}");
                    }
                }
                elseif (strpos($value, $definition['exclude']) !== false) {
                    $throw($key, $value, "exclude {$definition['exclude']}");
                }
                return $value;
            },
        ];

        $validate = function ($value, $rule, $path) use ($validators) {
            if (is_string($rule['type'])) {
                $rule['type'] = explode('|', $rule['type']);
            }
            $rule['type'] = array_map(fn($type) => explode('@', $type, 2)[0], $rule['type']);

            foreach ($validators as $name => $validator) {
                if (array_key_exists($name, $rule)) {
                    $value = $validator($rule, $value, "{$path}");
                }
            }
            return $value;
        };

        $main = function ($schema, $path, ...$arrays) use (&$main, $validate) {
            if (is_string($schema)) {
                $schema = paml_import($schema);
            }
            if (!array_key_exists('type', $schema)) {
                throw new \InvalidArgumentException("$path not have type key");
            }
            if (!$arrays) {
                if (!array_key_exists('default', $schema)) {
                    throw new \InvalidArgumentException("$path has no value");
                }
                $arrays[] = $schema['default'];
            }

            [$maintype, $subtype] = explode('@', implode('', (array) $schema['type']), 2) + [1 => null];
            if ($maintype === 'list') {
                $result = array_merge(...array_lmap($arrays, $validate, $schema, $path));
                if (isset($subtype)) {
                    $subschema = ['type' => $subtype] + array_map_key($schema, fn($k) => $k[0] === '@' ? substr($k, 1) : null);
                    foreach ($result as $k => $v) {
                        $result[$k] = $main($subschema, "$path/$k", $v);
                    }
                }
                return $validate($result, $schema, $path);
            }
            elseif ($maintype === 'hash') {
                $result = [];
                foreach ($schema as $k => $rule) {
                    if ($k[0] === '#') {
                        $name = substr($k, 1);
                        $result[$name] = $main($rule, "$path/$k", ...array_column($arrays, $name));
                    }
                }
                return $validate($result, $schema, $path);
            }
            else {
                return $validate(end($arrays), $schema, $path);
            }
        };

        return $main($schema, '', ...$arrays);
    }
}
if (function_exists("ryunosuke\\Functions\\array_schema") && !defined("ryunosuke\\Functions\\array_schema")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\array_schema", "ryunosuke\\Functions\\array_schema");
}

if (!isset($excluded_functions["stdclass"]) && (!function_exists("ryunosuke\\Functions\\stdclass") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\stdclass"))->isInternal()))) {
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
     * that(stdclass($fields))->is((object) $fields);
     * // ただしこういうことはキャストでは出来ない
     * that(array_map('stdclass', [$fields]))->is([(object) $fields]); // コールバックとして利用する
     * that(property_exists(stdclass(['a', 'b']), '0'))->isTrue();     // 数値キー付きオブジェクトにする
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
if (function_exists("ryunosuke\\Functions\\stdclass") && !defined("ryunosuke\\Functions\\stdclass")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\stdclass", "ryunosuke\\Functions\\stdclass");
}

if (!isset($excluded_functions["detect_namespace"]) && (!function_exists("ryunosuke\\Functions\\detect_namespace") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\detect_namespace"))->isInternal()))) {
    /**
     * ディレクトリ構造から名前空間を推測して返す
     *
     * 指定パスに名前空間を持つような php ファイルが有るならその名前空間を返す。
     * 指定パスに名前空間を持つような php ファイルが無いなら親をたどる。
     * 親に名前空間を持つような php ファイルが有るならその名前空間＋ローカルパスを返す。
     *
     * 言葉で表すとややこしいが、「そのパスに配置しても違和感の無い名前空間」を返してくれるはず。
     *
     * Example:
     * ```php
     * // Example 用としてこのクラスのディレクトリを使用してみる
     * $dirname = dirname(class_loader()->findFile(\ryunosuke\Functions\Package\Classobj::class));
     * // "$dirname/Hoge" の名前空間を推測して返す
     * that(detect_namespace("$dirname/Hoge"))->isSame("ryunosuke\\Functions\\Package\\Hoge");
     * ```
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
                        // @codeCoverageIgnoreStart
                        if (version_compare(PHP_VERSION, '8.0.0') >= 0) {
                            if (is_array($tokens[$m]) && $tokens[$m][0] === T_NAME_QUALIFIED) {
                                return $tokens[$m][1];
                            }
                            if (is_array($tokens[$m]) && $tokens[$m][0] === T_NAME_FULLY_QUALIFIED) {
                                $namespace[] = trim($tokens[$m][1], '\\');
                            }
                        }
                        // @codeCoverageIgnoreEnd
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
if (function_exists("ryunosuke\\Functions\\detect_namespace") && !defined("ryunosuke\\Functions\\detect_namespace")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\detect_namespace", "ryunosuke\\Functions\\detect_namespace");
}

if (!isset($excluded_functions["class_uses_all"]) && (!function_exists("ryunosuke\\Functions\\class_uses_all") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\class_uses_all"))->isInternal()))) {
    /**
     * クラスが use しているトレイトを再帰的に取得する
     *
     * トレイトが use しているトレイトが use しているトレイトが use している・・・のような場合もすべて返す。
     *
     * Example:
     * ```php
     * trait T1{}
     * trait T2{use T1;}
     * trait T3{use T2;}
     * that(class_uses_all(new class{use T3;}))->isSame([
     *     'Example\\T3', // クラスが直接 use している
     *     'Example\\T2', // T3 が use している
     *     'Example\\T1', // T2 が use している
     * ]);
     * ```
     *
     * @param string|object $class
     * @param bool $autoload オートロードを呼ぶか
     * @return array トレイト名の配列
     */
    function class_uses_all($class, $autoload = true)
    {
        // まずはクラス階層から取得
        $traits = [];
        do {
            $traits += array_fill_keys(class_uses($class, $autoload), false);
        } while ($class = get_parent_class($class));

        // そのそれぞれのトレイトに対してさらに再帰的に探す
        // 見つかったトレイトがさらに use している可能性もあるので「増えなくなるまで」 while ループして探す必要がある
        // （まずないと思うが）再帰的に use していることもあるかもしれないのでムダを省くためにチェック済みフラグを設けてある（ただ多分不要）
        $count = count($traits);
        while (true) {
            foreach ($traits as $trait => $checked) {
                if (!$checked) {
                    $traits[$trait] = true;
                    $traits += array_fill_keys(class_uses($trait, $autoload), false);
                }
            }
            if ($count === count($traits)) {
                break;
            }
            $count = count($traits);
        }
        return array_keys($traits);
    }
}
if (function_exists("ryunosuke\\Functions\\class_uses_all") && !defined("ryunosuke\\Functions\\class_uses_all")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\class_uses_all", "ryunosuke\\Functions\\class_uses_all");
}

if (!isset($excluded_functions["type_exists"]) && (!function_exists("ryunosuke\\Functions\\type_exists") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\type_exists"))->isInternal()))) {
    /**
     * 型が存在するか返す
     *
     * class/interface/trait/enum exists の合せ技。
     * trait/enum のように今後型的なものがさらに増えるかもしれないし、class_exists だけして interface/trait が抜けているコードを何度も見てきた。
     * それを一元管理するような関数となる。
     *
     * Example:
     * ```php
     * that(class_exists(\Throwable::class))->isFalse();     // class_exists は class にしか反応しない
     * that(interface_exists(\Exception::class))->isFalse(); // interface_exists は interface にしか反応しない
     * that(trait_exists(\Error::class))->isFalse();         // trait_exists は trait にしか反応しない
     * // type_exists であれば全てに反応する
     * that(type_exists(\Throwable::class))->isTrue();
     * that(type_exists(\Exception::class))->isTrue();
     * that(type_exists(\Error::class))->isTrue();
     * ```
     *
     * @param string $typename 調べる型名
     * @param bool $autoload オートロードを行うか
     * @return bool 型が存在するなら true
     */
    function type_exists($typename, $autoload = true)
    {
        if (class_exists($typename, $autoload)) {
            return true;
        }
        if (interface_exists($typename, $autoload)) {
            return true;
        }
        if (trait_exists($typename, $autoload)) {
            return true;
        }
        if (function_exists('enum_exists') && enum_exists($typename, $autoload)) {
            return true; // @codeCoverageIgnore
        }
        return false;
    }
}
if (function_exists("ryunosuke\\Functions\\type_exists") && !defined("ryunosuke\\Functions\\type_exists")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\type_exists", "ryunosuke\\Functions\\type_exists");
}

if (!isset($excluded_functions["auto_loader"]) && (!function_exists("ryunosuke\\Functions\\auto_loader") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\auto_loader"))->isInternal()))) {
    /**
     * vendor/autoload.php を返す
     *
     * かなり局所的な実装で vendor ディレクトリを変更していたりするとそれだけで例外になる。
     *
     * Example:
     * ```php
     * that(auto_loader())->contains('autoload.php');
     * ```
     *
     * @param ?string $startdir 高速化用の検索開始ディレクトリを指定するが、どちらかと言えばテスト用
     * @return string autoload.php のフルパス
     */
    function auto_loader($startdir = null)
    {
        return cache("path-$startdir", function () use ($startdir) {
            $cache = dirname_r($startdir ?: __DIR__, function ($dir) {
                if (file_exists($file = "$dir/autoload.php") || file_exists($file = "$dir/vendor/autoload.php")) {
                    return $file;
                }
            });
            if (!$cache) {
                throw new \DomainException('autoloader is not found.');
            }
            return $cache;
        }, __FUNCTION__);
    }
}
if (function_exists("ryunosuke\\Functions\\auto_loader") && !defined("ryunosuke\\Functions\\auto_loader")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\auto_loader", "ryunosuke\\Functions\\auto_loader");
}

if (!isset($excluded_functions["class_loader"]) && (!function_exists("ryunosuke\\Functions\\class_loader") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\class_loader"))->isInternal()))) {
    /**
     * composer のクラスローダを返す
     *
     * かなり局所的な実装で vendor ディレクトリを変更していたりするとそれだけで例外になる。
     *
     * Example:
     * ```php
     * that(class_loader())->isInstanceOf(\Composer\Autoload\ClassLoader::class);
     * ```
     *
     * @param ?string $startdir 高速化用の検索開始ディレクトリを指定するが、どちらかと言えばテスト用
     * @return \Composer\Autoload\ClassLoader クラスローダ
     */
    function class_loader($startdir = null)
    {
        return require auto_loader($startdir);
    }
}
if (function_exists("ryunosuke\\Functions\\class_loader") && !defined("ryunosuke\\Functions\\class_loader")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\class_loader", "ryunosuke\\Functions\\class_loader");
}

if (!isset($excluded_functions["class_aliases"]) && (!function_exists("ryunosuke\\Functions\\class_aliases") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\class_aliases"))->isInternal()))) {
    /**
     * 遅延ロードする class_alias
     *
     * class_alias は即座にオートロードされるが、この関数は必要とされるまでオートロードしない。
     *
     * Example:
     * ```php
     * class_aliases([
     *     'TestCase' => \PHPUnit\Framework\TestCase::class,
     * ]);
     * that(class_exists('TestCase', false))->isFalse(); // オートロードを走らせなければまだ定義されていない
     * that(class_exists('TestCase', true))->isTrue();   // オートロードを走らせなければ定義されている
     * ```
     *
     * @param array $aliases
     * @return array エイリアス配列
     */
    function class_aliases($aliases)
    {
        static $alias_map = [];

        foreach ($aliases as $alias => $class) {
            $alias_map[trim($alias, '\\')] = $class;
        }

        static $registered = false;
        if (!$registered) {
            $registered = true;
            spl_autoload_register(function ($class) use (&$alias_map) {
                if (isset($alias_map[$class])) {
                    class_alias($alias_map[$class], $class);
                }
            }, true, true);
        }

        return $alias_map;
    }
}
if (function_exists("ryunosuke\\Functions\\class_aliases") && !defined("ryunosuke\\Functions\\class_aliases")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\class_aliases", "ryunosuke\\Functions\\class_aliases");
}

if (!isset($excluded_functions["class_namespace"]) && (!function_exists("ryunosuke\\Functions\\class_namespace") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\class_namespace"))->isInternal()))) {
    /**
     * クラスの名前空間部分を取得する
     *
     * Example:
     * ```php
     * that(class_namespace('vendor\\namespace\\ClassName'))->isSame('vendor\\namespace');
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
if (function_exists("ryunosuke\\Functions\\class_namespace") && !defined("ryunosuke\\Functions\\class_namespace")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\class_namespace", "ryunosuke\\Functions\\class_namespace");
}

if (!isset($excluded_functions["class_shorten"]) && (!function_exists("ryunosuke\\Functions\\class_shorten") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\class_shorten"))->isInternal()))) {
    /**
     * クラスの名前空間部分を除いた短い名前を取得する
     *
     * Example:
     * ```php
     * that(class_shorten('vendor\\namespace\\ClassName'))->isSame('ClassName');
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
if (function_exists("ryunosuke\\Functions\\class_shorten") && !defined("ryunosuke\\Functions\\class_shorten")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\class_shorten", "ryunosuke\\Functions\\class_shorten");
}

if (!isset($excluded_functions["class_replace"]) && (!function_exists("ryunosuke\\Functions\\class_replace") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\class_replace"))->isInternal()))) {
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
     * class_replace('\\ryunosuke\\Test\\Package\\Classobj\\X1', function () {
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
     * that((new \ryunosuke\Test\Package\Classobj\Y1())->method())->isSame('this is X1d');
     * that((new \ryunosuke\Test\Package\Classobj\Y1())->newmethod())->isSame('this is newmethod');
     *
     * // Y2 extends X2 だとしてクロージャ配列でオーバーライドする
     * class_replace('\\ryunosuke\\Test\\Package\\Classobj\\X2', fn() => [
     *     'method'    => function () {return 'this is X2d';},
     *     'newmethod' => function () {return 'this is newmethod';},
     * ]);
     * // X2 を継承している Y2 にまで影響が出ている（X2 を完全に置換できたということ）
     * that((new \ryunosuke\Test\Package\Classobj\Y2())->method())->isSame('this is X2d');
     * that((new \ryunosuke\Test\Package\Classobj\Y2())->newmethod())->isSame('this is newmethod');
     *
     * // メソッド定義だけであればクロージャではなく配列指定でも可能。さらに trait 配列を渡すとそれらを use できる
     * class_replace('\\ryunosuke\\Test\\Package\\Classobj\\X3', [
     *     [\ryunosuke\Test\Package\Classobj\XTrait::class],
     *     'method' => function () {return 'this is X3d';},
     * ]);
     * // X3 を継承している Y3 にまで影響が出ている（X3 を完全に置換できたということ）
     * that((new \ryunosuke\Test\Package\Classobj\Y3())->method())->isSame('this is X3d');
     * // トレイトのメソッドも生えている
     * that((new \ryunosuke\Test\Package\Classobj\Y3())->traitMethod())->isSame('this is XTrait::traitMethod');
     *
     * // メソッドとトレイトだけならば無名クラスを渡すことでも可能
     * class_replace('\\ryunosuke\\Test\\Package\\Classobj\\X4', new class() {
     *     use \ryunosuke\Test\Package\Classobj\XTrait;
     *     function method(){return 'this is X4d';}
     * });
     * // X4 を継承している Y4 にまで影響が出ている（X4 を完全に置換できたということ）
     * that((new \ryunosuke\Test\Package\Classobj\Y4())->method())->isSame('this is X4d');
     * // トレイトのメソッドも生えている
     * that((new \ryunosuke\Test\Package\Classobj\Y4())->traitMethod())->isSame('this is XTrait::traitMethod');
     * ```
     *
     * @param string $class 対象クラス名
     * @param \Closure|object|array $register 置換クラスを定義 or 返すクロージャ or 定義メソッド配列 or 無名クラス
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
        if (!file_exists($fname)) {
            $content = file_get_contents($classfile);
            $content = preg_replace("#class\\s+[a-z0-9_]+#ui", '$0_', $content);
            file_put_contents($fname, $content, LOCK_EX);
        }
        require_once $fname;

        $classess = get_declared_classes();
        if ($register instanceof \Closure) {
            $newclass = $register();
        }
        elseif (is_object($register)) {
            $ref = new \ReflectionObject($register);
            $newclass = [class_uses($register)];
            $trait_methods = $ref->getTraitAliases();
            foreach (class_uses($register) as $trait) {
                $trait_methods += array_flip(get_class_methods($trait));
            }
            foreach ($ref->getMethods() as $method) {
                if (!isset($trait_methods[$method->getName()])) {
                    $newclass[$method->getName()] = $method->isStatic() ? $method->getClosure() : $method->getClosure($register);
                }
            }
        }
        else {
            $newclass = $register;
        }

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

            $classcode = '';
            foreach ($newclass as $name => $member) {
                if (is_array($member)) {
                    foreach ($member as $trait) {
                        $classcode .= "use \\" . trim($trait, '\\') . ";\n";
                    }
                }
                else {
                    [$declare, $codeblock] = callable_code($member);
                    $parentclass = new \ReflectionClass("\\$origspace\\$origclass");
                    // 元クラスに定義されているならオーバーライドとして特殊な処理を行う
                    if ($parentclass->hasMethod($name)) {
                        /** @var \ReflectionFunctionAbstract $refmember */
                        $refmember = reflect_callable($member);
                        $refmethod = $parentclass->getMethod($name);
                        // 指定クロージャに引数が無くて、元メソッドに有るなら継承
                        if (!$refmember->getNumberOfParameters() && $refmethod->getNumberOfParameters()) {
                            $declare = 'function (' . implode(', ', function_parameter($refmethod)) . ')';
                        }
                        // 同上。返り値版
                        if (!$refmember->hasReturnType() && $refmethod->hasReturnType()) {
                            $declare .= ':' . reflect_types($refmethod->getReturnType())->getName();
                        }
                    }
                    $mname = preg_replaces('#function(\\s*)\\(#u', " $name", $declare);
                    $classcode .= "public $mname $codeblock\n";
                }
            }

            $newclass = "\\$origspace\\{$origclass}_";
            evaluate("namespace $origspace;\nclass {$origclass}_ extends {$origclass}\n{\n$classcode}");
        }

        class_alias($newclass, $class);
    }
}
if (function_exists("ryunosuke\\Functions\\class_replace") && !defined("ryunosuke\\Functions\\class_replace")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\class_replace", "ryunosuke\\Functions\\class_replace");
}

if (!isset($excluded_functions["class_extends"]) && (!function_exists("ryunosuke\\Functions\\class_extends") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\class_extends"))->isInternal()))) {
    /**
     * インスタンスを動的に拡張する
     *
     * インスタンスに特異メソッド・特異フィールドのようなものを生やす。
     * ただし、特異フィールドの用途はほとんどない（php はデフォルトで特異フィールドのような動作なので）。
     * そのクラスの `__set`/`__get` が禁止されている場合に使えるかもしれない程度。
     *
     * クロージャ配列を渡すと特異メソッドになる。
     * そのクロージャの $this は元オブジェクトで bind される。
     * ただし、static closure を渡した場合はそれは static メソッドとして扱われる。
     *
     * $implements でインターフェースの配列を渡すとすべてが動的に implement される。
     * つまり得られたオブジェクトが instanceof を通るようになる。
     * もちろんメソッド配列としてその名前が含まれていなければならない。
     *
     * 内部的にはいわゆる Decorator パターンを動的に実行しているだけであり、実行速度は劣悪。
     * 当然ながら final クラス/メソッドの拡張もできない。
     *
     * Example:
     * ```php
     * // Exception に「count」メソッドと「コードとメッセージを結合して返す」メソッドを動的に生やす
     * $object = new \Exception('hoge', 123);
     * $newobject = class_extends($object, [
     *     'count'       => function () { return $this->code; },
     *     'codemessage' => function () {
     *         // bind されるので protected フィールドが使える
     *         return $this->code . ':' . $this->message;
     *     },
     * ], [], [\Countable::class]);
     * that($newobject->count())->isSame(123);
     * that($newobject->codemessage())->isSame('123:hoge');
     * that($newobject)->isInstanceOf(\Countable::class); // instanceof をパスできる
     *
     * // オーバーライドもできる（ArrayObject の count を2倍になるように上書き）
     * $object = new \ArrayObject([1, 2, 3]);
     * $newobject = class_extends($object, [
     *     'count' => function () {
     *         // parent は元オブジェクトを表す
     *         return parent::count() * 2;
     *     },
     * ]);
     * that($newobject->count())->isSame(6);
     * ```
     *
     * @template T
     * @param T $object 対象オブジェクト
     * @param \Closure[] $methods 注入するメソッド
     * @param array $fields 注入するフィールド
     * @param array $implements 実装するインターフェース
     * @return T $object を拡張した object
     */
    function class_extends($object, $methods, $fields = [], $implements = [])
    {
        assert(is_array($methods));

        static $template_source, $template_reflection;
        if (!isset($template_source)) {
            // コード補完やフォーマッタを効かせたいので文字列 eval ではなく直に new する（1回だけだし）
            // @codeCoverageIgnoreStart
            $template_reflection = new \ReflectionClass(new class() {
                    private static $__originalClass;
                    private        $__original;
                    private        $__fields;
                    private        $__methods       = [];
                    private static $__staticMethods = [];

                    public function __construct(\ReflectionClass $refclass = null, $original = null, $fields = [], $methods = [])
                    {
                        if ($refclass === null) {
                            return;
                        }
                        self::$__originalClass = get_class($original);

                        $this->__original = $original;
                        $this->__fields = $fields;

                        foreach ($methods as $name => $method) {
                            $bmethod = @$method->bindTo($this->__original, $refclass->isInternal() ? $this : $this->__original);
                            // 内部クラスは $this バインドできないので original じゃなく自身にする
                            if ($bmethod) {
                                $this->__methods[$name] = $bmethod;
                            }
                            else {
                                self::$__staticMethods[$name] = $method->bindTo(null, self::$__originalClass);
                            }
                        }
                    }

                    public function __get($name)
                    {
                        if (array_key_exists($name, $this->__fields)) {
                            return $this->__fields[$name];
                        }
                        return $this->__original->$name;
                    }

                    public function __set($name, $value)
                    {
                        if (array_key_exists($name, $this->__fields)) {
                            return $this->__fields[$name] = $value;
                        }
                        return $this->__original->$name = $value;
                    }

                    public function __call($name, $arguments)
                    {
                        return $this->__original->$name(...$arguments);
                    }

                    public static function __callStatic($name, $arguments)
                    {
                        return self::$__originalClass::$name(...$arguments);
                    }
                }
            );
            // @codeCoverageIgnoreEnd
            $sl = $template_reflection->getStartLine();
            $el = $template_reflection->getEndLine();
            $template_source = implode("", array_slice(file($template_reflection->getFileName()), $sl, $el - $sl - 1));
        }

        $getReturnType = function (\ReflectionFunctionAbstract $reffunc) {
            if ($reffunc->hasReturnType()) {
                $type = reflect_types($reffunc->getReturnType())->getName();
                if ($type !== 'void') {
                    return ": $type";
                }
            }
        };

        $parse = static function ($name, \ReflectionFunctionAbstract $reffunc) use ($getReturnType) {
            if ($reffunc instanceof \ReflectionMethod) {
                $modifier = implode(' ', \Reflection::getModifierNames($reffunc->getModifiers()));
                $receiver = ($reffunc->isStatic() ? 'self::$__originalClass::' : '$this->__original->') . $name;
            }
            else {
                $bindable = is_bindable_closure($reffunc->getClosure());
                $modifier = $bindable ? '' : 'static ';
                $receiver = ($bindable ? '$this->__methods' : 'self::$__staticMethods') . "[" . var_export($name, true) . "]";
            }

            $ref = $reffunc->returnsReference() ? '&' : '';

            $params = function_parameter($reffunc);
            $prms = implode(', ', $params);
            $args = implode(', ', array_keys($params));

            $rtype = $getReturnType($reffunc);

            return [
                "$modifier function $ref$name($prms)$rtype",
                "{ \$return = $ref$receiver(...[$args]);return \$return; }\n",
            ];
        };

        /** @var \ReflectionClass[][]|\ReflectionMethod[][][] $spawners */
        static $spawners = [];

        $classname = get_class($object);
        $classalias = str_replace('\\', '__', $classname);

        if (!isset($spawners[$classname])) {
            $refclass = new \ReflectionClass($classname);
            $classmethods = [];
            foreach ($refclass->getMethods() as $method) {
                if (!$method->isFinal() && !$method->isAbstract() && !in_array($method->getName(), get_class_methods($template_reflection->getName()))) {
                    $classmethods[$method->name] = $method;
                }
            }

            $cachefile = cachedir() . '/' . rawurlencode(__FUNCTION__ . '-' . $classname) . '.php';
            if (!file_exists($cachefile)) {
                $declares = "";
                foreach ($classmethods as $name => $method) {
                    $declares .= implode(' ', $parse($name, $method));
                }
                $traitcode = "trait X{$classalias}Trait\n{\n{$template_source}{$declares}}";
                file_put_contents($cachefile, "<?php\n" . $traitcode, LOCK_EX);
            }

            require_once $cachefile;
            $spawners[$classname] = [
                'original' => $refclass,
                'methods'  => $classmethods,
            ];
        }

        $declares = "";
        // 指定クロージャ配列から同名メソッドを差っ引いたもの（まさに特異メソッドとなる）
        foreach (array_diff_key($methods, $spawners[$classname]['methods']) as $name => $singular) {
            $declares .= implode(' ', $parse($name, new \ReflectionFunction($singular)));
        }
        // 指定クロージャ配列でメソッドと同名のもの（オーバーライドを模倣する）
        foreach (array_intersect_key($methods, $spawners[$classname]['methods']) as $name => $override) {
            $method = $spawners[$classname]['methods'][$name];
            $ref = $method->returnsReference() ? '&' : '';
            $receiver = $method->isStatic() ? 'self::$__originalClass::' : '$this->__original->';
            $modifier = implode(' ', \Reflection::getModifierNames($method->getModifiers()));

            // シグネチャエラーが出てしまうので、指定がない場合は強制的に合わせる
            $refmember = new \ReflectionFunction($override);
            $params = function_parameter(!$refmember->getNumberOfParameters() && $method->getNumberOfParameters() ? $method : $override);
            $rtype = $getReturnType(!$refmember->hasReturnType() && $method->hasReturnType() ? $method : $refmember);

            [, $codeblock] = callable_code($override);
            $tokens = parse_php($codeblock);
            array_shift($tokens);
            $parented = null;
            foreach ($tokens as $n => $token) {
                if ($token[0] !== T_WHITESPACE) {
                    if ($token[0] === T_STRING && $token[1] === 'parent') {
                        $parented = $n;
                    }
                    elseif ($parented !== null && $token[0] === T_DOUBLE_COLON) {
                        unset($tokens[$parented]);
                        $tokens[$n][1] = $receiver;
                    }
                    else {
                        $parented = null;
                    }
                }
            }
            $codeblock = implode('', array_column($tokens, 1));

            $prms = implode(', ', $params);
            $declares .= "$modifier function $ref$name($prms)$rtype $codeblock\n";
        }

        $newclassname = "X{$classalias}Class" . md5(uniqid('RF', true));
        $implements = $implements ? 'implements ' . implode(',', $implements) : '';
        evaluate("class $newclassname extends $classname $implements\n{\nuse X{$classalias}Trait;\n$declares}", [], 10);
        return new $newclassname($spawners[$classname]['original'], $object, $fields, $methods);
    }
}
if (function_exists("ryunosuke\\Functions\\class_extends") && !defined("ryunosuke\\Functions\\class_extends")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\class_extends", "ryunosuke\\Functions\\class_extends");
}

if (!isset($excluded_functions["reflect_types"]) && (!function_exists("ryunosuke\\Functions\\reflect_types") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\reflect_types"))->isInternal()))) {
    /**
     * ReflectionType の型配列を返す
     *
     * ReflectionType のインターフェース・仕様がコロコロ変わってついていけないので関数化した。
     *
     * ReflectionType に準ずるインスタンスを渡すと取り得る候補を配列ライクなオブジェクトで返す。
     * 引数は配列で複数与えても良い。よしなに扱って複数型として返す。
     * また「Type が一意に導出できる Reflection」を渡しても良い（ReflectionProperty など）。
     * null を与えた場合はエラーにはならず、スルーされる（getType は null を返し得るので利便性のため）。
     *
     * 単純に ReflectionType の配列ライクなオブジェクトを返すが、そのオブジェクトは `__toString` が実装されており、文字列化するとパイプ区切りの型文字列を返す。
     * これは 8.0 における ReflectionUnionType の `__toString` を模倣したものである。
     * 互換性のある型があった場合、上位の型に内包されて型文字列としては出現しない。
     *
     * Countable も実装されているが、その結果は「内部 Type の数」ではなく、論理的に「取り得る型の数」を返す。
     * 例えば `?int` は型としては1つだが、実際は int, null の2つを取り得るため、 count は 2 を返す。
     * 端的に言えば「`__toString` のパイプ区切りの型の数」を返す。
     *
     * あとは便利メソッドとして下記が生えている。
     *
     * - jsonSerialize: JsonSerializable 実装
     * - getTypes: 取り得る型をすべて返す（ReflectionUnionType 互換）
     * - getName: ReflectionUnionType 非互換 toString な型宣言文字列を返す
     * - allows: その値を取りうるか判定して返す
     *
     * ReflectionUnionType とは完全互換ではないので、php8.0が完全に使える環境であれば素直に ReflectionUnionType を使ったほうが良い。
     * （「常に（型分岐せずに）複数形で扱える」程度のメリットしかない。allows は惜しいが）。
     *
     * ちなみに型の変遷は下記の通り。
     *
     * - php7.1: ReflectionType::__toString が非推奨になった
     * - php7.1: ReflectionNamedType が追加され、各種 getType でそれを返すようになった
     * - php8.0: ReflectionType::__toString が非推奨ではなくなった
     * - php8.0: ReflectionUnionType が追加され、複合の場合は getType でそれを返すようになった
     *
     * Example:
     * ```php
     * $object = new class {
     *     function method(object $o):?string {}
     * };
     * $method = new \ReflectionMethod($object, 'method');
     * $types = reflect_types($method->getParameters()[0]->getType());
     * // 文字列化すると型宣言文字列を返すし、配列アクセスや count, iterable でそれぞれの型が得られる
     * that((string) $types)->is('object');
     * that($types[0])->isInstanceOf(\ReflectionType::class);
     * that(iterator_to_array($types))->eachIsInstanceOf(\ReflectionType::class);
     * that(count($types))->is(1);
     * // 返り値でも同じ（null 許容なので null が付くし count も 2 になる）
     * $types = reflect_types($method->getReturnType());
     * that((string) $types)->is('string|null');
     * that(count($types))->is(2);
     * ```
     *
     * @param \ReflectionFunctionAbstract|\ReflectionType|\ReflectionType[]|null $reflection_type getType 等で得られるインスタンス
     * @return \Traversable|\ArrayAccess|\Countable|\ReflectionNamedType|\ReflectionUnionType
     */
    function reflect_types($reflection_type = null)
    {
        if (!is_array($reflection_type)) {
            $reflection_type = [$reflection_type];
        }

        foreach ($reflection_type as $n => $rtype) {
            if ($rtype instanceof \ReflectionProperty) {
                $reflection_type[$n] = $rtype->getType();
            }
            if ($rtype instanceof \ReflectionFunctionAbstract) {
                $reflection_type[$n] = $rtype->getReturnType();
            }
            if ($rtype instanceof \ReflectionParameter) {
                $reflection_type[$n] = $rtype->getType();
            }
        }

        return new class(...$reflection_type)
            extends \stdClass
            implements \IteratorAggregate, \ArrayAccess, \Countable, \JsonSerializable {

            private const PSEUDO = [
                'mixed'    => [],
                'static'   => ['object', 'mixed'],
                'self'     => ['static', 'object', 'mixed'],
                'parent'   => ['static', 'object', 'mixed'],
                'callable' => ['mixed'],
                'iterable' => ['mixed'],
                'object'   => ['mixed'],
                'array'    => ['iterable', 'mixed'],
                'string'   => ['mixed'],
                'int'      => ['mixed'],
                'float'    => ['mixed'],
                'bool'     => ['mixed'],
                'false'    => ['bool', 'mixed'],
                'null'     => ['mixed'],
                'void'     => [],
            ];

            public function __construct(?\ReflectionType ...$reflection_types)
            {
                $types = [];
                foreach ($reflection_types as $type) {
                    if ($type === null) {
                        continue;
                    }

                    /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
                    $types = array_merge($types, $type instanceof \ReflectionUnionType ? $type->getTypes() : [$type]);
                }

                // 配列キャストで配列を得たいので下手にフィールドを宣言せず直に生やす
                foreach ($types as $n => $type) {
                    $this->$n = $type;
                }
            }

            public function __toString()
            {
                return implode('|', $this->toStrings(true, true));
            }

            public function getIterator(): \Traversable
            {
                // yield from $this->getTypes();
                return new \ArrayIterator($this->getTypes());
            }

            public function offsetExists($offset): bool
            {
                return isset($this->$offset);
            }

            /** @noinspection PhpLanguageLevelInspection */
            #[\ReturnTypeWillChange]
            public function offsetGet($offset)
            {
                return $this->$offset;
            }

            public function offsetSet($offset, $value): void
            {
                // for debug
                if (is_string($value)) {
                    $value = new class ($value, self::PSEUDO) extends \ReflectionNamedType {
                        private $typename;
                        private $nullable;
                        private $builtins;

                        public function __construct($typename, $builtins)
                        {
                            $this->typename = ltrim($typename, '?');
                            $this->nullable = $typename[0] === '?';
                            $this->builtins = $builtins;
                        }

                        public function getName(): string { return $this->typename; }

                        public function allowsNull(): bool { return $this->nullable; }

                        public function isBuiltin(): bool { return isset($this->builtins[$this->typename]); }

                        public function __toString(): string { return $this->getName(); }
                    };
                }

                assert($value instanceof \ReflectionType);
                if ($offset === null) {
                    $offset = max(array_keys($this->getTypes()) ?: [-1]) + 1;
                }
                $this->$offset = $value;
            }

            public function offsetUnset($offset): void
            {
                unset($this->$offset);
            }

            public function count(): int
            {
                return count($this->toStrings(true, false));
            }

            public function jsonSerialize(): array
            {
                return $this->toStrings(true, true);
            }

            public function getName()
            {
                $types = array_flip($this->toStrings(true, true));
                $nullable = false;
                if (isset($types['null']) && count($types) === 2) {
                    unset($types['null']);
                    $nullable = true;
                }

                $result = [];
                foreach ($types as $type => $dummy) {
                    $result[] = (isset(self::PSEUDO[$type]) ? '' : '\\') . $type;
                }
                return ($nullable ? '?' : '') . implode('|', $result);
            }

            public function getTypes()
            {
                return (array) $this;
            }

            public function allows($type, $strict = false)
            {
                $types = array_flip($this->toStrings(false, false));

                if (isset($types['mixed'])) {
                    return true;
                }

                foreach ($types as $allow => $dummy) {
                    if (function_exists($f = "is_$allow") && $f($type)) {
                        return true;
                    }
                    if (is_a($type, $allow, true)) {
                        return true;
                    }
                }

                if (!$strict) {
                    if (is_int($type) || is_float($type) || is_bool($type)) {
                        if (isset($types['int']) || isset($types['float']) || isset($types['bool']) || isset($types['string'])) {
                            return true;
                        }
                    }
                    if (is_string($type) || (is_object($type) && method_exists($type, '__toString'))) {
                        if (isset($types['string'])) {
                            return true;
                        }
                        if ((isset($types['int']) || isset($types['float'])) && is_numeric("$type")) {
                            return true;
                        }
                    }
                }
                return false;
            }

            private function toStrings($ignore_compatible = true, $sort = true)
            {
                $types = [];
                foreach ($this->getTypes() as $type) {
                    // ドキュメント上は「ReflectionNamedType を返す可能性があります」とのことなので getName 前提はダメ
                    // かといって文字列化前提だと 7.1 以降で deprecated が出てしまう
                    // つまり愚直に分岐するか @ で抑制するくらいしか多バージョン対応する術がない（7.1 の deprecated を解除して欲しい…）
                    $types[$type instanceof \ReflectionNamedType ? $type->getName() : (string) $type] = true;

                    if ($type->allowsNull()) {
                        $types['null'] = true;
                    }
                }

                if ($ignore_compatible) {
                    $types = array_filter($types, function ($type) use ($types) {
                        // いくつか互換のある内包疑似型が存在する（iterable は array を内包するし、 bool は false を内包する）
                        foreach (self::PSEUDO[$type] ?? [] as $parent) {
                            if (isset($types[$parent])) {
                                return false;
                            }
                        }
                        // さらに object 疑似型は全てのクラス名を内包する
                        if (isset($types['object']) && !isset(self::PSEUDO[$type])) {
                            return false;
                        }
                        return true;
                    }, ARRAY_FILTER_USE_KEY);
                }

                if ($sort) {
                    static $orders = null;
                    $orders ??= array_flip(array_keys(self::PSEUDO));
                    uksort($types, function ($a, $b) use ($orders) {
                        $issetA = isset($orders[$a]);
                        $issetB = isset($orders[$b]);
                        switch (true) {
                            case $issetA && $issetB:   // 共に疑似型
                                return $orders[$a] - $orders[$b];
                            case !$issetA && !$issetB: // 共にクラス名
                                return strcasecmp($a, $b);
                            case !$issetA && $issetB:  // A だけがクラス名
                                return -1;
                            case $issetA && !$issetB:  // B だけがクラス名
                                return +1;
                        }
                    });
                }
                return array_keys($types);
            }
        };
    }
}
if (function_exists("ryunosuke\\Functions\\reflect_types") && !defined("ryunosuke\\Functions\\reflect_types")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\reflect_types", "ryunosuke\\Functions\\reflect_types");
}

if (!isset($excluded_functions["const_exists"]) && (!function_exists("ryunosuke\\Functions\\const_exists") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\const_exists"))->isInternal()))) {
    /**
     * クラス定数が存在するか調べる
     *
     * グローバル定数も調べられる。ので実質的には defined とほぼ同じで違いは下記。
     *
     * - defined は単一引数しか与えられないが、この関数は2つの引数も受け入れる
     * - defined は private const で即死するが、この関数はきちんと調べることができる
     * - ClassName::class は常に true を返す
     *
     * あくまで存在を調べるだけで実際にアクセスできるかは分からないので注意（`property_exists` と同じ）。
     *
     * Example:
     * ```php
     * // クラス定数が調べられる（1引数、2引数どちらでも良い）
     * that(const_exists('ArrayObject::STD_PROP_LIST'))->isTrue();
     * that(const_exists('ArrayObject', 'STD_PROP_LIST'))->isTrue();
     * that(const_exists('ArrayObject::UNDEFINED'))->isFalse();
     * that(const_exists('ArrayObject', 'UNDEFINED'))->isFalse();
     * // グローバル（名前空間）もいける
     * that(const_exists('PHP_VERSION'))->isTrue();
     * that(const_exists('UNDEFINED'))->isFalse();
     * ```
     *
     * @param string|object $classname 調べるクラス
     * @param ?string $constname 調べるクラス定数
     * @return bool 定数が存在するなら true
     */
    function const_exists($classname, $constname = null)
    {
        $colonp = strpos($classname, '::');
        if ($colonp === false && strlen($constname) === 0) {
            return defined($classname);
        }
        if (strlen($constname) === 0) {
            $constname = substr($classname, $colonp + 2);
            $classname = substr($classname, 0, $colonp);
        }

        try {
            $refclass = new \ReflectionClass($classname);
            if (strcasecmp($constname, 'class') === 0) {
                return true;
            }
            return $refclass->hasConstant($constname);
        }
        catch (\Throwable $t) {
            return false;
        }
    }
}
if (function_exists("ryunosuke\\Functions\\const_exists") && !defined("ryunosuke\\Functions\\const_exists")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\const_exists", "ryunosuke\\Functions\\const_exists");
}

if (!isset($excluded_functions["object_dive"]) && (!function_exists("ryunosuke\\Functions\\object_dive") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\object_dive"))->isInternal()))) {
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
     * that(object_dive($class, 'a.b.c'))->isSame('vvv');
     * that(object_dive($class, 'a.b.x', 9))->isSame(9);
     * // 配列を与えても良い。その場合 $delimiter 引数は意味をなさない
     * that(object_dive($class, ['a', 'b', 'c']))->isSame('vvv');
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
if (function_exists("ryunosuke\\Functions\\object_dive") && !defined("ryunosuke\\Functions\\object_dive")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\object_dive", "ryunosuke\\Functions\\object_dive");
}

if (!isset($excluded_functions["get_class_constants"]) && (!function_exists("ryunosuke\\Functions\\get_class_constants") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\get_class_constants"))->isInternal()))) {
    /**
     * クラス定数を配列で返す
     *
     * `(new \ReflectionClass($class))->getConstants()` とほぼ同じだが、可視性でフィルタができる。
     * さらに「自分自身の定義か？」でもフィルタできる。
     *
     * Example:
     * ```php
     * $class = new class extends \ArrayObject
     * {
     *     private   const C_PRIVATE   = 'private';
     *     protected const C_PROTECTED = 'protected';
     *     public    const C_PUBLIC    = 'public';
     * };
     * // 普通に全定数を返す
     * that(get_class_constants($class))->isSame([
     *     'C_PRIVATE'      => 'private',
     *     'C_PROTECTED'    => 'protected',
     *     'C_PUBLIC'       => 'public',
     *     'STD_PROP_LIST'  => \ArrayObject::STD_PROP_LIST,
     *     'ARRAY_AS_PROPS' => \ArrayObject::ARRAY_AS_PROPS,
     * ]);
     * // public のみを返す
     * that(get_class_constants($class, IS_PUBLIC))->isSame([
     *     'C_PUBLIC'       => 'public',
     *     'STD_PROP_LIST'  => \ArrayObject::STD_PROP_LIST,
     *     'ARRAY_AS_PROPS' => \ArrayObject::ARRAY_AS_PROPS,
     * ]);
     * // 自身定義でかつ public のみを返す
     * that(get_class_constants($class, IS_OWNSELF | IS_PUBLIC))->isSame([
     *     'C_PUBLIC'       => 'public',
     * ]);
     * ```
     *
     * @param string|object $class クラス名 or オブジェクト
     * @param ?int $filter アクセスレベル定数
     * @return array クラス定数の配列
     */
    function get_class_constants($class, $filter = null)
    {
        $class = ltrim(is_object($class) ? get_class($class) : $class, '\\');
        $filter ??= (IS_PUBLIC | IS_PROTECTED | IS_PRIVATE);

        $result = [];
        foreach ((new \ReflectionClass($class))->getReflectionConstants() as $constant) {
            if (($filter & IS_OWNSELF) && $constant->getDeclaringClass()->name !== $class) {
                continue;
            }
            $modifiers = $constant->getModifiers();
            $modifiers2 = 0;
            $modifiers2 |= ($modifiers & \ReflectionProperty::IS_PUBLIC) ? IS_PUBLIC : 0;
            $modifiers2 |= ($modifiers & \ReflectionProperty::IS_PROTECTED) ? IS_PROTECTED : 0;
            $modifiers2 |= ($modifiers & \ReflectionProperty::IS_PRIVATE) ? IS_PRIVATE : 0;
            if ($modifiers2 & $filter) {
                $result[$constant->name] = $constant->getValue();
            }
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\get_class_constants") && !defined("ryunosuke\\Functions\\get_class_constants")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\get_class_constants", "ryunosuke\\Functions\\get_class_constants");
}

if (!isset($excluded_functions["get_object_properties"]) && (!function_exists("ryunosuke\\Functions\\get_object_properties") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\get_object_properties"))->isInternal()))) {
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
     * that(get_object_properties($object))->arraySubset([
     *     'message' => 'something',
     *     'code'    => 42,
     *     'oreore'  => 'oreore',
     * ]);
     * ```
     *
     * @param object $object オブジェクト
     * @param array $privates 継承ツリー上の private が格納される
     * @return array 全プロパティの配列
     */
    function get_object_properties($object, &$privates = [])
    {
        $fields = [];
        foreach ((array) $object as $name => $field) {
            $cname = '';
            $names = explode("\0", $name);
            if (count($names) > 1) {
                $name = array_pop($names);
                $cname = $names[1];
            }
            $fields[$cname][$name] = $field;
        }

        $classname = get_class($object);
        $parents = array_values(['', '*', $classname] + class_parents($object));
        uksort($fields, function ($a, $b) use ($parents) {
            return array_search($a, $parents, true) <=> array_search($b, $parents, true);
        });

        $result = [];
        foreach ($fields as $cname => $props) {
            foreach ($props as $name => $field) {
                if ($cname !== '' && $cname !== '*' && $classname !== $cname) {
                    $privates[$cname][$name] = $field;
                }
                if (!array_key_exists($name, $result)) {
                    $result[$name] = $field;
                }
            }
        }

        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\get_object_properties") && !defined("ryunosuke\\Functions\\get_object_properties")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\get_object_properties", "ryunosuke\\Functions\\get_object_properties");
}

if (!isset($excluded_functions["date_timestamp"]) && (!function_exists("ryunosuke\\Functions\\date_timestamp") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\date_timestamp"))->isInternal()))) {
    /**
     * 日時文字列をよしなにタイムスタンプに変換する
     *
     * マイクロ秒にも対応している。つまり返り値は int か float になる。
     * また、相対指定の +1 month の月末問題は起きないようにしてある。
     *
     * かなり適当に和暦にも対応している。
     *
     * Example:
     * ```php
     * // 普通の日時文字列
     * that(date_timestamp('2014/12/24 12:34:56'))->isSame(strtotime('2014/12/24 12:34:56'));
     * // 和暦
     * that(date_timestamp('昭和31年12月24日 12時34分56秒'))->isSame(strtotime('1956/12/24 12:34:56'));
     * // 相対指定
     * that(date_timestamp('2012/01/31 +1 month'))->isSame(strtotime('2012/02/29'));
     * that(date_timestamp('2012/03/31 -1 month'))->isSame(strtotime('2012/02/29'));
     * // マイクロ秒
     * that(date_timestamp('2014/12/24 12:34:56.789'))->isSame(1419392096.789);
     * ```
     *
     * @param string|int|float $datetimedata 日時データ
     * @param int|null $baseTimestamp 日時データ
     * @return int|float|null タイムスタンプ。パース失敗時は null
     */
    function date_timestamp($datetimedata, $baseTimestamp = null)
    {
        // 全角を含めた trim
        $chars = "[\\x0-\x20\x7f\xc2\xa0\xe3\x80\x80]";
        $datetimedata = preg_replace("/\A{$chars}++|{$chars}++\z/u", '', $datetimedata);

        // 和暦を西暦に置換
        $jpnames = array_merge(array_column(JP_ERA, 'name'), array_column(JP_ERA, 'abbr'));
        $datetimedata = preg_replace_callback('/^(' . implode('|', $jpnames) . ')(\d{1,2}|元)/u', function ($matches) {
            [, $era, $year] = $matches;
            $eratime = array_find(JP_ERA, function ($v) use ($era) {
                if (in_array($era, [$v['name'], $v['abbr']], true)) {
                    return $v['since'];
                }
            }, false);
            return idate('Y', $eratime) + ($year === '元' ? 1 : $year) - 1;
        }, $datetimedata);

        // 単位文字列を置換
        $datetimedata = strtr($datetimedata, [
            '　'  => ' ',
            '西暦' => '',
            '年'  => '/',
            '月'  => '/',
            '日'  => ' ',
            '時'  => ':',
            '分'  => ':',
            '秒'  => '',
        ]);
        $datetimedata = trim($datetimedata, " \t\n\r\0\x0B:/");

        // 数値4桁は年と解釈されるように
        if (preg_match('/^[0-9]{4}$/', $datetimedata)) {
            $datetimedata .= '-01-01';
        }

        // 数値系はタイムスタンプとみなす
        if (ctype_digit("$datetimedata")) {
            return (int) $datetimedata;
        }
        if (is_numeric($datetimedata)) {
            return (float) $datetimedata;
        }

        // date_parse してみる
        $parts = date_parse($datetimedata);
        if (!$parts) {
            // ドキュメントに「成功した場合に日付情報を含む配列、失敗した場合に FALSE を返します」とあるが、失敗する気配がない
            return null; // @codeCoverageIgnore
        }
        if ($parts['error_count']) {
            return null;
        }

        if (!checkdate($parts['month'], $parts['day'], $parts['year'])) {
            if (!isset($parts['relative'])) {
                return null;
            }
            $baseTimestamp ??= time();
            $parts['year'] = idate('Y', $baseTimestamp);
            $parts['month'] = idate('m', $baseTimestamp);
            $parts['day'] = idate('d', $baseTimestamp);
        }

        if (isset($parts['relative'])) {
            $relative = $parts['relative'];
            $parts['year'] += $relative['year'];
            $parts['month'] += $relative['month'];
            // php の相対指定は割と腐っているので補正する（末日を超えても月は変わらないようにする）
            if ($parts['month'] > 12) {
                $parts['year'] += intdiv($parts['month'], 12);
                $parts['month'] = $parts['month'] % 12;
            }
            if ($parts['month'] < 1) {
                $parts['year'] += intdiv(-12 + $parts['month'], 12);
                $parts['month'] = 12 + $parts['month'] % 12;
            }
            if (!checkdate($parts['month'], $parts['day'], $parts['year'])) {
                $parts['day'] = idate('t', mktime(12, 12, 12, $parts['month'], 1, $parts['year']));
            }
            $parts['day'] += $relative['day'];
            $parts['hour'] += $relative['hour'];
            $parts['minute'] += $relative['minute'];
            $parts['second'] += $relative['second'];
        }

        // ドキュメントに「引数が不正な場合、 この関数は FALSE を返します」とあるが、 date_parse の結果を与える分には失敗しないはず
        $time = mktime($parts['hour'], $parts['minute'], $parts['second'], $parts['month'], $parts['day'], $parts['year']);
        if ($parts['fraction']) {
            // 1970 以前なら減算、以降なら加算じゃないと帳尻が合わなくなる
            $time += $time >= 0 ? $parts['fraction'] : -$parts['fraction'];
        }

        return $time;
    }
}
if (function_exists("ryunosuke\\Functions\\date_timestamp") && !defined("ryunosuke\\Functions\\date_timestamp")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\date_timestamp", "ryunosuke\\Functions\\date_timestamp");
}

if (!isset($excluded_functions["date_convert"]) && (!function_exists("ryunosuke\\Functions\\date_convert") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\date_convert"))->isInternal()))) {
    /**
     * 日時文字列をよしなに別のフォーマットに変換する
     *
     * マイクロ秒にも対応している。
     * かなり適当に和暦にも対応している。
     *
     * Example:
     * ```php
     * // 和暦を Y/m/d H:i:s に変換
     * that(date_convert('Y/m/d H:i:s', '昭和31年12月24日 12時34分56秒'))->isSame('1956/12/24 12:34:56');
     * // 単純に「マイクロ秒が使える date」としても使える
     * $now = 1234567890.123; // テストがしづらいので固定時刻にする
     * that(date_convert('Y/m/d H:i:s.u', $now))->isSame('2009/02/14 08:31:30.123000');
     * ```
     *
     * @param string $format フォーマット
     * @param string|int|float|\DateTime|null $datetimedata 日時データ。省略時は microtime
     * @return string 日時文字列
     */
    function date_convert($format, $datetimedata = null)
    {
        // 省略時は microtime
        if ($datetimedata === null) {
            $timestamp = microtime(true);
        }
        elseif ($datetimedata instanceof \DateTimeInterface) {
            // @fixme DateTime オブジェクトって timestamp を float で得られないの？
            $timestamp = (float) $datetimedata->format('U.u');
        }
        else {
            $timestamp = date_timestamp($datetimedata);
            if ($timestamp === null) {
                throw new \InvalidArgumentException("parse failed '$datetimedata'");
            }
        }

        $replace = function ($string, $char, $replace) {
            $string = preg_replace('/(?<!\\\)' . $char . '/', '${1}' . $replace, $string);
            return preg_replace('/\\\\' . $char . '/', $char, preg_replace('/(?<!\\\)' . $char . '/', '${1}' . $replace, $string));
        };

        if (preg_match('/[JbKk]/', $format)) {
            $era = array_find(JP_ERA, function ($v) use ($timestamp) {
                if ($v['since'] <= $timestamp) {
                    return $v;
                }
            }, false);
            if ($era === false) {
                throw new \InvalidArgumentException("notfound JP_ERA '$datetimedata'");
            }

            $y = idate('Y', $timestamp) - idate('Y', $era['since']) + 1;
            $format = $replace($format, 'J', $era['name']);
            $format = $replace($format, 'b', $era['abbr']);
            $format = $replace($format, 'K', $y === 1 ? '元' : $y);
            $format = $replace($format, 'k', $y);
        }

        $format = $replace($format, 'x', ['日', '月', '火', '水', '木', '金', '土'][idate('w', $timestamp)]);

        if (is_float($timestamp)) {
            // datetime パラメータが UNIX タイムスタンプ (例: 946684800) だったり、タイムゾーンを含んでいたり (例: 2010-01-28T15:00:00+02:00) する場合は、 timezone パラメータや現在のタイムゾーンは無視します
            static $dtz = null;
            $dtz ??= new \DateTimeZone(date_default_timezone_get());
            return \DateTime::createFromFormat('U.u', sprintf('%f', $timestamp))->setTimezone($dtz)->format($format);
        }
        return date($format, $timestamp);
    }
}
if (function_exists("ryunosuke\\Functions\\date_convert") && !defined("ryunosuke\\Functions\\date_convert")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\date_convert", "ryunosuke\\Functions\\date_convert");
}

if (!isset($excluded_functions["date_fromto"]) && (!function_exists("ryunosuke\\Functions\\date_fromto") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\date_fromto"))->isInternal()))) {
    /**
     * 日時っぽい文字列とフォーマットを与えると取りうる範囲を返す
     *
     * 与えられた日時の最大の切り捨て日時と最小の切り上げ日時の配列を返す。
     * 日付文字列はある程度よしなに補完される（例えば "2014/12" は"2014年12月01日" と解釈されるし "12/24" は "今年12月24日" と解釈される）。
     *
     * Example:
     * ```php
     * that(date_fromto('Y/m/d H:i:s', '2010/11'))->isSame(["2010/11/01 00:00:00", "2010/12/01 00:00:00"]);
     * that(date_fromto('Y/m/d H:i:s', '2010/11/24'))->isSame(["2010/11/24 00:00:00", "2010/11/25 00:00:00"]);
     * that(date_fromto('Y/m/d H:i:s', '2010/11/24 13'))->isSame(["2010/11/24 13:00:00", "2010/11/24 14:00:00"]);
     * that(date_fromto('Y/m/d H:i:s', '2010/11/24 13:24'))->isSame(["2010/11/24 13:24:00", "2010/11/24 13:25:00"]);
     * ```
     *
     * @param string $format フォーマット。 null を与えるとタイムスタンプで返す
     * @param string $datetimestring 日時データ
     * @return array|null [from ～ to] な配列。解釈できない場合は null
     */
    function date_fromto($format, $datetimestring)
    {
        $parsed = date_parse($datetimestring);
        if (true
            && $parsed['year'] === false
            && $parsed['month'] === false
            && $parsed['day'] === false
            && $parsed['hour'] === false
            && $parsed['minute'] === false
            && $parsed['second'] === false) {
            return null;
        }

        [$date, $time] = preg_split('#[T\s　]#u', $datetimestring, -1, PREG_SPLIT_NO_EMPTY) + [0 => '', 1 => ''];
        [$y, $m, $d] = preg_split('#[^\d]+#u', $date, -1, PREG_SPLIT_NO_EMPTY) + [0 => null, 1 => null, 2 => null];
        [$h, $i, $s] = preg_split('#[^\d]+#u', $time, -1, PREG_SPLIT_NO_EMPTY) + [0 => null, 1 => null, 2 => null];

        // "2014/12" と "12/24" の区別はつかないので字数で判断
        if (strlen($y) <= 2) {
            [$y, $m, $d] = [null, $y, $m];
        }
        // 時刻区切りなし
        if (strlen($h) > 2) {
            [$h, $i, $s] = str_split($h, 2) + [0 => null, 1 => null, 2 => null];
        }

        // 文字列表現で妥当性を検証
        $strtime = sprintf('%04d-%02d-%02d %02d:%02d:%02d', $y ?? 1000, $m ?? 1, $d ?? 1, $h ?? 1, $i ?? 1, $s ?? 1);
        $datetime = date_create_from_format('Y-m-d H:i:s', $strtime);
        if (!$datetime || $datetime->format('Y-m-d H:i:s') !== $strtime) {
            return null;
        }

        $y ??= idate('Y');
        $ld = $d ?? idate('t', mktime(0, 0, 0, $m ?? 12, 1, $y));

        $min = mktime($h ?? 0, $i ?? 0, $s ?? 0, $m ?? 1, $d ?? 1, $y);
        $max = mktime($h ?? 23, $i ?? 59, $s ?? 59, $m ?? 12, $d ?? $ld, $y) + 1;
        if ($format === null) {
            return [$min, $max];
        }
        return [date($format, $min), date($format, $max)];
    }
}
if (function_exists("ryunosuke\\Functions\\date_fromto") && !defined("ryunosuke\\Functions\\date_fromto")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\date_fromto", "ryunosuke\\Functions\\date_fromto");
}

if (!isset($excluded_functions["date_interval"]) && (!function_exists("ryunosuke\\Functions\\date_interval") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\date_interval"))->isInternal()))) {
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
     * that(date_interval(60 * 60 * 24 * 900 + 12345.678, '%Y/%M/%D %H:%I:%S.%v'))->isSame('02/05/18 03:25:45.678');
     *
     * // 書式にクロージャを与えるとコールバックされる（引数はスケールの小さい方から）
     * that(date_interval(60 * 60 * 24 * 900 + 12345.678, fn() => implode(',', func_get_args())))->isSame('678,45,25,3,18,5,2,0');
     *
     * // リミットを指定（month までしか計算しないので year は 0 になり month は 29になる）
     * that(date_interval(60 * 60 * 24 * 900 + 12345.678, '%Y/%M/%D %H:%I:%S.%v', 'm'))->isSame('00/29/18 03:25:45.678');
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
     * that(date_interval(60 * 60 * 24 * 900 + 12345, $format, 3))->isSame('2年5ヶ月18日');
     * // 数がそこそこだと日・時間・分の3要素に切り替わる
     * that(date_interval(60 * 60 * 24 * 20 + 12345, $format, 3))->isSame('20日 3時間25分');
     * // どんなに数が小さくても3要素以下にはならない
     * that(date_interval(1234, $format, 3))->isSame('0時間20分34秒');
     *
     * // 書式指定なし（DateInterval を返す）
     * that(date_interval(123.456))->isInstanceOf(\DateInterval::class);
     * ```
     *
     * @param int|float $sec タイムスタンプ
     * @param string|array|null $format 時刻フォーマット
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
                        1 => static fn() => ['', $fmt[0], ''],
                        2 => static fn() => ['', $fmt[0], $fmt[1]],
                        3 => static fn() => array_values($fmt),
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

        {
            $format = preg_replace('#(^|[^%])%c#u', '${1}' . $interval->c, $format);
            $format = preg_replace('#(^|[^%])%v#u', '${1}' . $interval->v, $format);
        }
        return $interval->format($format);
    }
}
if (function_exists("ryunosuke\\Functions\\date_interval") && !defined("ryunosuke\\Functions\\date_interval")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\date_interval", "ryunosuke\\Functions\\date_interval");
}

if (!isset($excluded_functions["date_alter"]) && (!function_exists("ryunosuke\\Functions\\date_alter") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\date_alter"))->isInternal()))) {
    /**
     * 日付を除外日リストに基づいてずらす
     *
     * 典型的には「祝日前の営業日」「祝日後の営業日」のような代理日を返すイメージ。
     * $follow_count に応じて下記のように返す。
     *
     * - null: 除外日でもずらさないでそのまま返す
     * - -N: 除外日なら最大N日分前倒しした日付を返す
     * - +N: 除外日なら最大N日分先送りした日付を返す
     * - 0: 除外日でもずらさないで null を返す
     *
     * @param string|int|\DateTimeInterface $datetime 調べる日付
     * @param array $excluded_dates 除外日（いわゆる祝休日リスト）
     * @param int $follow_count ずらす範囲
     * @param string $format 日付フォーマット（$excluded_dates の形式＋返り値の形式）
     * @return string|null 代替日。除外日 null
     */
    function date_alter($datetime, $excluded_dates, $follow_count, $format = 'Y-m-d')
    {
        $timestamp = date_timestamp($datetime);
        if (!array_key_exists($date = date($format, $timestamp), $excluded_dates)) {
            return $date;
        }
        if (!strlen($follow_count)) {
            return $date;
        }
        $follow_count = (int) $follow_count;
        if ($follow_count < 0) {
            return date_alter($timestamp - 24 * 3600, $excluded_dates, $follow_count + 1);
        }
        if ($follow_count > 0) {
            return date_alter($timestamp + 24 * 3600, $excluded_dates, $follow_count - 1);
        }
        return null;
    }
}
if (function_exists("ryunosuke\\Functions\\date_alter") && !defined("ryunosuke\\Functions\\date_alter")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\date_alter", "ryunosuke\\Functions\\date_alter");
}

if (!isset($excluded_functions["file_matcher"]) && (!function_exists("ryunosuke\\Functions\\file_matcher") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\file_matcher"))->isInternal()))) {
    /**
     * 各種属性を指定してファイルのマッチングを行うクロージャを返す
     *
     * ※ 内部向け
     *
     * @param array $filter_condition マッチャーコンディション配列（ソースを参照）
     * @return \Closure ファイルマッチャー
     */
    function file_matcher(array $filter_condition)
    {
        $filter_condition += [
            // common
            'dotfile'    => null,  // switch startWith "."
            'unixpath'   => true,  // convert "\\" -> "/"
            'casefold'   => false, // ignore case
            // by getType (string or [string])
            'type'       => null,
            '!type'      => null,
            // by getPerms (int)
            'perms'      => null,
            '!perms'     => null,
            // by getMTime (int or [int, int])
            'mtime'      => null,
            '!mtime'     => null,
            // by getSize (int or [int, int])
            'size'       => null,
            '!size'      => null,
            // by getPathname (glob or regex)
            'path'       => null,
            '!path'      => null,
            // by getPath or getSubpath (glob or regex)
            'dir'        => null,
            '!dir'       => null,
            // by getFilename (glob or regex)
            'name'       => null,
            '!name'      => null,
            // by getExtension (string or [string])
            'extension'  => null,
            '!extension' => null,
            // by contents (string)
            'contains'   => null,
            '!contains'  => null,
            // by custom condition (callable)
            'filter'     => null,
            '!filter'    => null,
        ];

        foreach ([
            'mtime'  => date_timestamp,
            '!mtime' => date_timestamp,
            'size'   => si_unprefix,
            '!size'  => si_unprefix,
        ] as $key => $map) {
            if (isset($filter_condition[$key])) {
                $range = $filter_condition[$key];
                if (!is_array($range)) {
                    $range = array_fill_keys([0, 1], $range);
                }
                $range = array_map($map, $range);
                $filter_condition[$key] = static function ($value) use ($range) {
                    return (!isset($range[0]) || $value >= $range[0]) && (!isset($range[1]) || $value <= $range[1]);
                };
            }
        }

        foreach ([
            'type'       => null,
            '!type'      => null,
            'extension'  => null,
            '!extension' => null,
        ] as $key => $map) {
            if (isset($filter_condition[$key])) {
                $array = array_flip((array) $filter_condition[$key]);
                if ($filter_condition['casefold']) {
                    $array = array_change_key_case($array, CASE_LOWER);
                }
                $filter_condition[$key] = static function ($value) use ($array) {
                    return isset($array[$value]);
                };
            }
        }

        foreach ([
            'path'  => null,
            '!path' => null,
            'dir'   => null,
            '!dir'  => null,
            'name'  => null,
            '!name' => null,
        ] as $key => $convert) {
            if (isset($filter_condition[$key])) {
                $pattern = $filter_condition[$key];
                preg_match('##', ''); // clear preg_last_error
                @preg_match($pattern, '');
                if (preg_last_error() === PREG_NO_ERROR) {
                    $filter_condition[$key] = static function ($string) use ($pattern, $filter_condition) {
                        $string = $filter_condition['unixpath'] && DIRECTORY_SEPARATOR === '\\' ? str_replace('\\', '/', $string) : $string;
                        return !!preg_match($pattern, $string);
                    };
                }
                else {
                    $filter_condition[$key] = static function ($string) use ($pattern, $filter_condition) {
                        $string = $filter_condition['unixpath'] && DIRECTORY_SEPARATOR === '\\' ? str_replace('\\', '/', $string) : $string;
                        $flags = 0;
                        $flags |= $filter_condition['casefold'] ? FNM_CASEFOLD : 0;
                        return fnmatch($pattern, $string, $flags);
                    };
                }
            }
        }

        return function ($file) use ($filter_condition) {
            if (!$file instanceof \SplFileInfo) {
                $file = new \SplFileInfo($file);
            }

            if (isset($filter_condition['dotfile']) && !$filter_condition['dotfile'] === (strpos($file->getFilename(), '.') === 0)) {
                return false;
            }

            foreach (['type' => false, '!type' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && (!file_exists($file->getPathname()) || $cond === $filter_condition[$key]($file->getType()))) {
                    return false;
                }
            }
            foreach (['perms' => false, '!perms' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && (!file_exists($file->getPathname()) || $cond === !!($filter_condition[$key] & $file->getPerms()))) {
                    return false;
                }
            }
            foreach (['mtime' => false, '!mtime' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && (!file_exists($file->getPathname()) || $cond === $filter_condition[$key]($file->getMTime()))) {
                    return false;
                }
            }
            foreach (['size' => false, '!size' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && (!file_exists($file->getPathname()) || $cond === $filter_condition[$key]($file->getSize()))) {
                    return false;
                }
            }
            foreach (['path' => false, '!path' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && $cond === $filter_condition[$key]($file->getPathname())) {
                    return false;
                }
            }
            foreach (['dir' => false, '!dir' => true] as $key => $cond) {
                $dirname = $file instanceof \RecursiveDirectoryIterator ? $file->getSubPath() : $file->getPath();
                if (isset($filter_condition[$key]) && $cond === $filter_condition[$key]($dirname)) {
                    return false;
                }
            }
            foreach (['name' => false, '!name' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && $cond === $filter_condition[$key]($file->getFilename())) {
                    return false;
                }
            }
            foreach (['extension' => false, '!extension' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && $cond === $filter_condition[$key]($file->getExtension())) {
                    return false;
                }
            }
            foreach (['filter' => false, '!filter' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && $cond === !!$filter_condition[$key]($file)) {
                    return false;
                }
            }
            foreach (['contains' => false, '!contains' => true] as $key => $cond) {
                if (isset($filter_condition[$key]) && (!file_exists($file->getPathname()) || $cond === (file_pos($file->getPathname(), $filter_condition[$key]) !== false))) {
                    return false;
                }
            }

            return true;
        };
    }
}
if (function_exists("ryunosuke\\Functions\\file_matcher") && !defined("ryunosuke\\Functions\\file_matcher")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\file_matcher", "ryunosuke\\Functions\\file_matcher");
}

if (!isset($excluded_functions["file_list"]) && (!function_exists("ryunosuke\\Functions\\file_list") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\file_list"))->isInternal()))) {
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
     * that(file_list($tmp))->equalsCanonicalizing([
     *     "$tmp{$DS}a.txt",
     *     "$tmp{$DS}dir{$DS}b.txt",
     *     "$tmp{$DS}dir{$DS}dir{$DS}c.txt",
     * ]);
     * ```
     *
     * @param string $dirname 調べるディレクトリ名
     * @param callable|array $filter_condition フィルタ条件
     * @return array|false ファイルの配列
     */
    function file_list($dirname, $filter_condition = [])
    {
        $dirname = realpath($dirname);
        if (!file_exists($dirname)) {
            return false;
        }

        // for compatible
        if (is_callable($filter_condition)) {
            $filter_condition = [
                'filter' => fn(\SplFileInfo $file) => $filter_condition($file->getPathname()),
            ];
        }
        $filter_condition += [
            '!type' => 'dir',
        ];
        $match = file_matcher($filter_condition);

        $rdi = new \RecursiveDirectoryIterator($dirname, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_SELF);
        $rii = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::CHILD_FIRST);

        $result = [];
        foreach ($rii as $fullpath => $it) {
            if (!$match($it)) {
                continue;
            }

            $result[] = $fullpath;
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\file_list") && !defined("ryunosuke\\Functions\\file_list")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\file_list", "ryunosuke\\Functions\\file_list");
}

if (!isset($excluded_functions["file_tree"]) && (!function_exists("ryunosuke\\Functions\\file_tree") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\file_tree"))->isInternal()))) {
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
     * that(file_tree($tmp))->is([
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
     * @param callable|array $filter_condition フィルタ条件
     * @return array|false ツリー構造の配列
     */
    function file_tree($dirname, $filter_condition = [])
    {
        $dirname = realpath($dirname);
        if (!file_exists($dirname)) {
            return false;
        }

        // for compatible
        if (is_callable($filter_condition)) {
            $filter_condition = [
                'filter' => fn(\SplFileInfo $file) => $filter_condition($file->getPathname()),
            ];
        }
        $filter_condition += [
            '!type' => 'dir',
        ];
        $match = file_matcher($filter_condition);

        $basedir = basename($dirname);

        $result = [$basedir => []];
        $items = iterator_to_array(new \FilesystemIterator($dirname, \FilesystemIterator::SKIP_DOTS || \FilesystemIterator::CURRENT_AS_SELF));
        usort($items, function (\SplFileInfo $a, \SplFileInfo $b) {
            if ($a->isDir() xor $b->isDir()) {
                return $a->isDir() - $b->isDir();
            }
            return strcmp($a->getPathname(), $b->getPathname());
        });
        foreach ($items as $item) {
            if ($item->isDir()) {
                $result[$basedir] += file_tree($item->getPathname(), $filter_condition);
            }
            else {
                if ($match($item)) {
                    $result[$basedir][$item->getBasename()] = $item->getPathname();
                }
            }
        }
        // for compatible. 空エントリは削除（この動作は将来的になくしたい）
        if (!$result[$basedir]) {
            unset($result[$basedir]);
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\file_tree") && !defined("ryunosuke\\Functions\\file_tree")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\file_tree", "ryunosuke\\Functions\\file_tree");
}

if (!isset($excluded_functions["file_suffix"]) && (!function_exists("ryunosuke\\Functions\\file_suffix") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\file_suffix"))->isInternal()))) {
    /**
     * ファイル名にサフィックスを付与する
     *
     * pathinfoに非準拠。例えば「filename.hoge.fuga」のような形式は「filename」が変換対象になる。
     *
     * Example:
     * ```php
     * that(file_suffix('filename.ext', '-min'))->isSame('filename-min.ext');
     * that(file_suffix('filename.ext1.ext2', '-min'))->isSame('filename-min.ext1.ext2');
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
if (function_exists("ryunosuke\\Functions\\file_suffix") && !defined("ryunosuke\\Functions\\file_suffix")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\file_suffix", "ryunosuke\\Functions\\file_suffix");
}

if (!isset($excluded_functions["file_extension"]) && (!function_exists("ryunosuke\\Functions\\file_extension") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\file_extension"))->isInternal()))) {
    /**
     * ファイルの拡張子を変更する。引数を省略すると拡張子を返す
     *
     * pathinfo に準拠。例えば「filename.hoge.fuga」のような形式は「fuga」が変換対象になる。
     *
     * Example:
     * ```php
     * that(file_extension('filename.ext'))->isSame('ext');
     * that(file_extension('filename.ext', 'txt'))->isSame('filename.txt');
     * that(file_extension('filename.ext', ''))->isSame('filename');
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
if (function_exists("ryunosuke\\Functions\\file_extension") && !defined("ryunosuke\\Functions\\file_extension")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\file_extension", "ryunosuke\\Functions\\file_extension");
}

if (!isset($excluded_functions["file_get_arrays"]) && (!function_exists("ryunosuke\\Functions\\file_get_arrays") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\file_get_arrays"))->isInternal()))) {
    /**
     * 指定ファイルを拡張子別に php の配列として読み込む
     *
     * 形式は拡張子で自動判別する。
     * その際、2重拡張子で hoge.sjis.csv のように指定するとそのファイルのエンコーディングを指定したことになる。
     *
     * Example:
     * ```php
     * // csv ファイルを読み込んで配列で返す
     * file_put_contents($csvfile = sys_get_temp_dir() . '/hoge.csv', 'a,b,c
     * 1,2,3
     * 4,5,6
     * 7,8,9
     * ');
     * that(file_get_arrays($csvfile))->isSame([
     *     ['a' => '1', 'b' => '2', 'c' => '3'],
     *     ['a' => '4', 'b' => '5', 'c' => '6'],
     *     ['a' => '7', 'b' => '8', 'c' => '9'],
     * ]);
     *
     * // sjis の json ファイルを読み込んで配列で返す
     * file_put_contents($jsonfile = sys_get_temp_dir() . '/hoge.sjis.json', '[
     * {"a": 1, "b": 2, "c": 3},
     * {"a": 4, "b": 5, "c": 6},
     * {"a": 7, "b": 8, "c": 9}
     * ]');
     * that(file_get_arrays($jsonfile))->isSame([
     *     ['a' => 1, 'b' => 2, 'c' => 3],
     *     ['a' => 4, 'b' => 5, 'c' => 6],
     *     ['a' => 7, 'b' => 8, 'c' => 9],
     * ]);
     * ```
     *
     * @param string $filename 読み込むファイル名
     * @param array $options 各種オプション
     * @return array レコード配列
     */
    function file_get_arrays($filename, $options = [])
    {
        static $supported_encodings = null;
        if ($supported_encodings === null) {
            $supported_encodings = array_combine(array_map('strtolower', mb_list_encodings()), mb_list_encodings());
        }

        if (!file_exists($filename)) {
            throw new \InvalidArgumentException("$filename is not exists");
        }

        $internal_encoding = mb_internal_encoding();
        $mb_convert_encoding = function ($encoding, $contents) use ($internal_encoding) {
            if ($encoding !== $internal_encoding) {
                $contents = mb_convert_encoding($contents, $internal_encoding, $encoding);
            }
            return $contents;
        };

        $pathinfo = pathinfo($filename);
        $encoding = pathinfo($pathinfo['filename'], PATHINFO_EXTENSION);
        $encoding = $supported_encodings[strtolower($encoding)] ?? $internal_encoding;
        $extension = $pathinfo['extension'] ?? '';

        switch (strtolower($extension)) {
            default:
                throw new \InvalidArgumentException("ext '$extension' is not supported.");
            case 'php':
                return (array) require $filename;
            case 'csv':
                return (array) csv_import($mb_convert_encoding($encoding, file_get_contents($filename)), $options + ['structure' => true]);
            case 'json':
            case 'json5':
                return (array) json_import($mb_convert_encoding($encoding, file_get_contents($filename)), $options);
            case 'jsonl':
            case 'jsonl5':
                return (array) array_map(fn($json) => json_import($json, $options), $mb_convert_encoding($encoding, array_filter(file($filename, FILE_IGNORE_NEW_LINES), 'strlen')));
            case 'yml':
            case 'yaml':
                return (array) yaml_parse($mb_convert_encoding($encoding, file_get_contents($filename)), 0, $ndocs, $options);
            case 'xml':
                throw new \DomainException("ext '$extension' is supported in the future.");
            case 'ltsv':
                return (array) array_map(fn($ltsv) => ltsv_import($ltsv, $options), $mb_convert_encoding($encoding, array_filter(file($filename, FILE_IGNORE_NEW_LINES), 'strlen')));
        }
    }
}
if (function_exists("ryunosuke\\Functions\\file_get_arrays") && !defined("ryunosuke\\Functions\\file_get_arrays")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\file_get_arrays", "ryunosuke\\Functions\\file_get_arrays");
}

if (!isset($excluded_functions["file_set_contents"]) && (!function_exists("ryunosuke\\Functions\\file_set_contents") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\file_set_contents"))->isInternal()))) {
    /**
     * ディレクトリも掘る file_put_contents
     *
     * 書き込みは一時ファイルと rename を使用してアトミックに行われる。
     *
     * Example:
     * ```php
     * file_set_contents(sys_get_temp_dir() . '/not/filename.ext', 'hoge');
     * that(file_get_contents(sys_get_temp_dir() . '/not/filename.ext'))->isSame('hoge');
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

        $filename = path_normalize($filename);

        if (!is_dir($dirname = dirname($filename))) {
            if (!@mkdir_p($dirname, $umask)) {
                throw new \RuntimeException("failed to mkdir($dirname)");
            }
        }

        $tempnam = tempnam($dirname, 'tmp');
        if (($result = file_put_contents($tempnam, $data)) !== false) {
            if (rename($tempnam, $filename)) {
                @chmod($filename, 0666 & ~$umask);
                return $result;
            }
            unlink($tempnam);
        }
        return false;
    }
}
if (function_exists("ryunosuke\\Functions\\file_set_contents") && !defined("ryunosuke\\Functions\\file_set_contents")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\file_set_contents", "ryunosuke\\Functions\\file_set_contents");
}

if (!isset($excluded_functions["file_rewrite_contents"]) && (!function_exists("ryunosuke\\Functions\\file_rewrite_contents") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\file_rewrite_contents"))->isInternal()))) {
    /**
     * ファイルを読み込んで内容をコールバックに渡して書き込む
     *
     * Example:
     * ```php
     * // 適当にファイルを用意
     * $testpath = sys_get_temp_dir() . '/rewrite.txt';
     * file_put_contents($testpath, 'hoge');
     * // 前後に 'pre-', '-fix' を付与する
     * file_rewrite_contents($testpath, fn($contents, $fp) => "pre-$contents-fix");
     * that($testpath)->fileEquals('pre-hoge-fix');
     * ```
     *
     * @param string $filename 読み書きするファイル名
     * @param callable $callback 書き込む内容。引数で $contents, $fp が渡ってくる
     * @param int $operation ロック定数（LOCL_SH, LOCK_EX, LOCK_NB）
     * @return int 書き込まれたバイト数
     */
    function file_rewrite_contents($filename, $callback, $operation = 0)
    {
        /** @var resource $fp */
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
if (function_exists("ryunosuke\\Functions\\file_rewrite_contents") && !defined("ryunosuke\\Functions\\file_rewrite_contents")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\file_rewrite_contents", "ryunosuke\\Functions\\file_rewrite_contents");
}

if (!isset($excluded_functions["file_pos"]) && (!function_exists("ryunosuke\\Functions\\file_pos") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\file_pos"))->isInternal()))) {
    /**
     * 範囲指定でファイルを読んで位置を返す
     *
     * $needle に配列を与えると OR 的動作で一つでも見つかった時点の位置を返す。
     * このとき「どれが見つかったか？」は得られない（場合によっては不便なので将来の改修対象）。
     *
     * Example:
     * ```php
     * // 適当にファイルを用意
     * $testpath = sys_get_temp_dir() . '/file_pos.txt';
     * file_put_contents($testpath, "hoge\nfuga\npiyo\nfuga");
     * // fuga の位置を返す
     * that(file_pos($testpath, 'fuga'))->is(5);
     * // 2つ目の fuga の位置を返す
     * that(file_pos($testpath, 'fuga', 6))->is(15);
     * // 見つからない場合は false を返す
     * that(file_pos($testpath, 'hogera'))->is(false);
     * ```
     *
     * @param string $filename ファイル名
     * @param string|array $needle 探す文字列
     * @param int $start 読み込み位置
     * @param int|null $end 読み込むまでの位置。省略時は指定なし（最後まで）。負数は後ろからのインデックス
     * @param int|null $chunksize 読み込みチャンクサイズ。省略時は 4096 の倍数に正規化
     * @return int|false $needle の位置。見つからなかった場合は false
     */
    function file_pos($filename, $needle, $start = 0, $end = null, $chunksize = null)
    {
        if (!is_file($filename)) {
            throw new \InvalidArgumentException("'$filename' is not found.");
        }

        $needle = arrayval($needle, false);
        $maxlength = max(array_map('strlen', $needle));

        if ($start < 0) {
            $start += $filesize ?? $filesize = filesize($filename);
        }
        if ($end === null) {
            $end = $filesize ?? $filesize = filesize($filename);
        }
        if ($end < 0) {
            $end += $filesize ?? $filesize = filesize($filename);
        }
        if ($chunksize === null) {
            $chunksize = 4096 * ($maxlength % 4096 + 1);
        }

        assert(isset($filesize) || !isset($filesize));
        assert($chunksize >= $maxlength);

        $fp = fopen($filename, 'rb');
        try {
            fseek($fp, $start);
            while (!feof($fp)) {
                if ($start > $end) {
                    break;
                }
                $last = $part ?? '';
                $part = fread($fp, $chunksize);
                if (($p = strpos_array($part, $needle))) {
                    $min = min($p);
                    $result = $start + $min;
                    return $result + strlen($needle[array_flip($p)[$min]]) > $end ? false : $result;
                }
                if (($p = strpos_array($last . $part, $needle))) {
                    $min = min($p);
                    $result = $start + $min - strlen($last);
                    return $result + strlen($needle[array_flip($p)[$min]]) > $end ? false : $result;
                }
                $start += strlen($part);
            }
            return false;
        }
        finally {
            fclose($fp);
        }
    }
}
if (function_exists("ryunosuke\\Functions\\file_pos") && !defined("ryunosuke\\Functions\\file_pos")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\file_pos", "ryunosuke\\Functions\\file_pos");
}

if (!isset($excluded_functions["file_mimetype"]) && (!function_exists("ryunosuke\\Functions\\file_mimetype") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\file_mimetype"))->isInternal()))) {
    /**
     * ファイルの mimetype を返す
     *
     * mime_content_type の http 対応版。
     * 変更点は下記。
     *
     * - http(s) に対応（HEAD メソッドで取得する）
     * - 失敗時に false ではなく null を返す
     *
     * Example:
     * ```php
     * that(file_mimetype(__FILE__))->is('text/x-php');
     * that(file_mimetype('http://httpbin.org/get?name=value'))->is('application/json');
     * ```
     *
     * @param string $filename ファイル名（URL）
     * @return string|null MIME タイプ
     */
    function file_mimetype($filename)
    {
        $scheme = parse_url($filename, PHP_URL_SCHEME) ?? null;
        switch (strtolower($scheme)) {
            default:
            case 'file':
                return mime_content_type($filename) ?: null;

            case 'http':
            case 'https':
                $r = $c = [];
                http_head($filename, [], ['throw' => false], $r, $c);
                if ($c['http_code'] === 200) {
                    return $c['content_type'] ?? null;
                }
                trigger_error("HEAD $filename {$c['http_code']}", E_USER_WARNING);
        }
    }
}
if (function_exists("ryunosuke\\Functions\\file_mimetype") && !defined("ryunosuke\\Functions\\file_mimetype")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\file_mimetype", "ryunosuke\\Functions\\file_mimetype");
}

if (!isset($excluded_functions["mkdir_p"]) && (!function_exists("ryunosuke\\Functions\\mkdir_p") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\mkdir_p"))->isInternal()))) {
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
if (function_exists("ryunosuke\\Functions\\mkdir_p") && !defined("ryunosuke\\Functions\\mkdir_p")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\mkdir_p", "ryunosuke\\Functions\\mkdir_p");
}

if (!isset($excluded_functions["dirname_r"]) && (!function_exists("ryunosuke\\Functions\\dirname_r") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\dirname_r"))->isInternal()))) {
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
     * $callback = fn($path) => realpath("$path/file.txt");
     * that(dirname_r("$tmp/a/b/c/d/e/f", $callback))->isSame(realpath("$tmp/a/b/file.txt"));
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
if (function_exists("ryunosuke\\Functions\\dirname_r") && !defined("ryunosuke\\Functions\\dirname_r")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\dirname_r", "ryunosuke\\Functions\\dirname_r");
}

if (!isset($excluded_functions["dirmtime"]) && (!function_exists("ryunosuke\\Functions\\dirmtime") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\dirmtime"))->isInternal()))) {
    /**
     * ディレクトリの最終更新日時を返す
     *
     * 「ディレクトリの最終更新日時」とは filemtime で得られる結果ではなく、「配下のファイル群で最も新しい日時」を表す。
     * ディレクトリの mtime も検出に含まれるので、ファイルを削除した場合も検知できる。
     *
     * ファイル名を与えると例外を投げる。
     * 空ディレクトリの場合は自身の mtime を返す。
     *
     * Example:
     * ```php
     * $dirname = sys_get_temp_dir() . '/mtime';
     * rm_rf($dirname);
     * mkdir($dirname);
     *
     * // この時点では現在日時（単純に自身の更新日時）
     * that(dirmtime($dirname))->isBetween(time() - 2, time());
     * // ファイルを作って更新するとその時刻
     * touch("$dirname/tmp", time() + 10);
     * that(dirmtime($dirname))->isSame(time() + 10);
     * ```
     *
     * @param string $dirname ディレクトリ名
     * @param bool $recursive 再帰フラグ
     * @return int 最終更新日時
     */
    function dirmtime($dirname, $recursive = true)
    {
        if (!is_dir($dirname)) {
            throw new \InvalidArgumentException("'$dirname' is not directory.");
        }

        $rdi = new \RecursiveDirectoryIterator($dirname, \FilesystemIterator::SKIP_DOTS);
        $dirtime = filemtime($dirname);
        foreach ($rdi as $path) {
            /** @var \SplFileInfo $path */
            $mtime = $path->getMTime();
            if ($path->isDir() && $recursive) {
                $mtime = max($mtime, dirmtime($path->getPathname(), $recursive));
            }
            if ($dirtime < $mtime) {
                $dirtime = $mtime;
            }
        }
        return $dirtime;
    }
}
if (function_exists("ryunosuke\\Functions\\dirmtime") && !defined("ryunosuke\\Functions\\dirmtime")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\dirmtime", "ryunosuke\\Functions\\dirmtime");
}

if (!isset($excluded_functions["fnmatch_and"]) && (!function_exists("ryunosuke\\Functions\\fnmatch_and") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\fnmatch_and"))->isInternal()))) {
    /**
     * fnmatch の AND 版
     *
     * $patterns のうちどれか一つでもマッチしなかったら false を返す。
     * $patterns が空だと例外を投げる。
     *
     * Example:
     * ```php
     * // すべてにマッチするので true
     * that(fnmatch_and(['*aaa*', '*bbb*'], 'aaaXbbbX'))->isTrue();
     * // aaa にはマッチするが bbb にはマッチしないので false
     * that(fnmatch_and(['*aaa*', '*bbb*'], 'aaaX'))->isFalse();
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
if (function_exists("ryunosuke\\Functions\\fnmatch_and") && !defined("ryunosuke\\Functions\\fnmatch_and")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\fnmatch_and", "ryunosuke\\Functions\\fnmatch_and");
}

if (!isset($excluded_functions["fnmatch_or"]) && (!function_exists("ryunosuke\\Functions\\fnmatch_or") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\fnmatch_or"))->isInternal()))) {
    /**
     * fnmatch の OR 版
     *
     * $patterns のうちどれか一つでもマッチしたら true を返す。
     * $patterns が空だと例外を投げる。
     *
     * Example:
     * ```php
     * // aaa にマッチするので true
     * that(fnmatch_or(['*aaa*', '*bbb*'], 'aaaX'))->isTrue();
     * // どれともマッチしないので false
     * that(fnmatch_or(['*aaa*', '*bbb*'], 'cccX'))->isFalse();
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
if (function_exists("ryunosuke\\Functions\\fnmatch_or") && !defined("ryunosuke\\Functions\\fnmatch_or")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\fnmatch_or", "ryunosuke\\Functions\\fnmatch_or");
}

if (!isset($excluded_functions["path_is_absolute"]) && (!function_exists("ryunosuke\\Functions\\path_is_absolute") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\path_is_absolute"))->isInternal()))) {
    /**
     * パスが絶対パスか判定する
     *
     * Example:
     * ```php
     * that(path_is_absolute('/absolute/path'))->isTrue();
     * that(path_is_absolute('relative/path'))->isFalse();
     * // Windows 環境では下記も true になる
     * if (DIRECTORY_SEPARATOR === '\\') {
     *     that(path_is_absolute('\\absolute\\path'))->isTrue();
     *     that(path_is_absolute('C:\\absolute\\path'))->isTrue();
     * }
     * ```
     *
     * @param string $path パス文字列
     * @return bool 絶対パスなら true
     */
    function path_is_absolute($path)
    {
        // スキームが付いている場合は path 部分で判定
        $parts = parse_url($path);
        if (isset($parts['scheme'], $parts['path'])) {
            $path = $parts['path'];
        }
        elseif (isset($parts['scheme'], $parts['host'])) {
            $path = $parts['host'];
        }

        if (substr($path, 0, 1) === '/') {
            return true;
        }

        if (DIRECTORY_SEPARATOR === '\\') {
            if (preg_match('#^([a-z]+:(\\\\|/|$)|\\\\)#i', $path) !== 0) {
                return true;
            }
        }

        return false;
    }
}
if (function_exists("ryunosuke\\Functions\\path_is_absolute") && !defined("ryunosuke\\Functions\\path_is_absolute")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\path_is_absolute", "ryunosuke\\Functions\\path_is_absolute");
}

if (!isset($excluded_functions["path_resolve"]) && (!function_exists("ryunosuke\\Functions\\path_resolve") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\path_resolve"))->isInternal()))) {
    /**
     * パスを絶対パスに変換して正規化する
     *
     * 可変引数で与えられた文字列群を結合して絶対パス化して返す。
     * 出来上がったパスが絶対パスでない場合は PATH 環境変数を使用して解決を試みる。
     *
     * 歴史的な理由により最後の引数を配列にするとその候補と PATH からの解決を試みる。
     * 解決できなかった場合 null を返す。
     * 配列を指定しなかった場合はカレントディレクトリを結合して返す。
     *
     * Example:
     * ```php
     * $DS = DIRECTORY_SEPARATOR;
     * that(path_resolve('/absolute/path'))->isSame("{$DS}absolute{$DS}path");
     * that(path_resolve('absolute/path'))->isSame(getcwd() . "{$DS}absolute{$DS}path");
     * that(path_resolve('/absolute/path/through', '../current/./path'))->isSame("{$DS}absolute{$DS}path{$DS}current{$DS}path");
     *
     * # 最後の引数に最列を与えるとそのパスと PATH から解決を試みる（要するに which 的な動作になる）
     * if ($DS === '/') {
     *     that(path_resolve('php', []))->isSame(PHP_BINARY);
     * }
     * ```
     *
     * @param string|array ...$paths パス文字列（可変引数）
     * @return ?string 絶対パス
     */
    function path_resolve(...$paths)
    {
        $resolver = [];
        if (is_array($paths[count($paths) - 1] ?? '')) {
            $resolver = array_pop($paths);
            $resolver[] = getenv('PATH');
        }

        $DS = DIRECTORY_SEPARATOR;

        $path = implode($DS, $paths);

        if (!path_is_absolute($path)) {
            // for compatible
            if ($resolver) {
                foreach ($resolver as $p) {
                    foreach (explode(PATH_SEPARATOR, $p) as $dir) {
                        if (file_exists("$dir/$path")) {
                            return path_normalize("$dir/$path");
                        }
                    }
                }
                return null;
            }
            else {
                $path = getcwd() . $DS . $path;
            }
        }

        return path_normalize($path);
    }
}
if (function_exists("ryunosuke\\Functions\\path_resolve") && !defined("ryunosuke\\Functions\\path_resolve")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\path_resolve", "ryunosuke\\Functions\\path_resolve");
}

if (!isset($excluded_functions["path_relative"]) && (!function_exists("ryunosuke\\Functions\\path_relative") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\path_relative"))->isInternal()))) {
    /**
     * パスを相対パスに変換して正規化する
     *
     * $from から $to への相対パスを返す。
     *
     * Example:
     * ```php
     * $DS = DIRECTORY_SEPARATOR;
     * that(path_relative('/a/b/c/X', '/a/b/c/d/X'))->isSame("..{$DS}d{$DS}X");
     * that(path_relative('/a/b/c/d/X', '/a/b/c/X'))->isSame("..{$DS}..{$DS}X");
     * that(path_relative('/a/b/c/X', '/a/b/c/X'))->isSame("");
     * ```
     *
     * @param string $from 元パス
     * @param string $to 対象パス
     * @return string 相対パス
     */
    function path_relative($from, $to)
    {
        $DS = DIRECTORY_SEPARATOR;

        $fa = array_filter(explode($DS, path_resolve($from)), 'strlen');
        $ta = array_filter(explode($DS, path_resolve($to)), 'strlen');

        $compare = fn($a, $b) => $DS === '\\' ? strcasecmp($a, $b) : strcmp($a, $b);
        $ca = array_udiff_assoc($fa, $ta, $compare);
        $da = array_udiff_assoc($ta, $fa, $compare);

        return str_repeat("..$DS", count($ca)) . implode($DS, $da);
    }
}
if (function_exists("ryunosuke\\Functions\\path_relative") && !defined("ryunosuke\\Functions\\path_relative")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\path_relative", "ryunosuke\\Functions\\path_relative");
}

if (!isset($excluded_functions["path_normalize"]) && (!function_exists("ryunosuke\\Functions\\path_normalize") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\path_normalize"))->isInternal()))) {
    /**
     * パスを正規化する
     *
     * 具体的には ./ や ../ を取り除いたり連続したディレクトリ区切りをまとめたりする。
     * realpath ではない。のでシンボリックリンクの解決などはしない。その代わりファイルが存在しなくても使用することができる。
     *
     * Example:
     * ```php
     * $DS = DIRECTORY_SEPARATOR;
     * that(path_normalize('/path/to/something'))->isSame("{$DS}path{$DS}to{$DS}something");
     * that(path_normalize('/path/through/../something'))->isSame("{$DS}path{$DS}something");
     * that(path_normalize('./path/current/./through/../something'))->isSame("path{$DS}current{$DS}something");
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
        foreach (preg_split("#[$ds]+#u", $path) as $part) {
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
        if (count($result) > 2 && $result[count($result) - 1] === '') {
            array_pop($result);
        }
        return implode(DIRECTORY_SEPARATOR, $result);
    }
}
if (function_exists("ryunosuke\\Functions\\path_normalize") && !defined("ryunosuke\\Functions\\path_normalize")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\path_normalize", "ryunosuke\\Functions\\path_normalize");
}

if (!isset($excluded_functions["path_parse"]) && (!function_exists("ryunosuke\\Functions\\path_parse") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\path_parse"))->isInternal()))) {
    /**
     * パスをパースする
     *
     * pathinfo の（ほぼ）上位互換で下記の差異がある。
     *
     * - パスは正規化される
     * - $flags 引数はない（指定した各部だけを返すことはできない）
     * - 要素が未設定になることはない（例えば extension は拡張子がなくても明示的に null が入る）
     *
     * 更に独自で下記のキーを返す。
     *
     * - dirlocalname: 親ディレクトリと localname の結合（≒フルパスから複数拡張子を除いたもの）
     * - localname: 複数拡張子を除いた filename
     * - extensions: 複数拡張子を配列で返す（拡張子がない場合は空配列）
     *
     * Example:
     * ```php
     * $DS = DIRECTORY_SEPARATOR;
     * that(path_parse('/path/to/file.min.css'))->isSame([
     *     'dirname'      => "{$DS}path{$DS}to",
     *     'basename'     => "file.min.css",
     *     'filename'     => "file.min",
     *     'extension'    => "css",
     *     // ここまでは（正規化はされるが） pathinfo と同じ
     *     // ここからは独自のキー
     *     'dirlocalname' => "{$DS}path{$DS}to{$DS}file",
     *     'localname'    => "file",
     *     'extensions'   => ["min", "css"],
     * ]);
     * ```
     *
     * @param string $path パス文字列
     * @return array パスパーツ
     */
    function path_parse($path)
    {
        // dirname や extension など、キーの有無が分岐するのは使いにくいことこの上ないのでまずすべて null で埋める
        $pathinfo = array_replace([
            'dirname'   => null,
            'basename'  => null,
            'filename'  => null,
            'extension' => null,
        ], pathinfo(path_normalize($path)));

        $localname = $pathinfo['filename'];
        $extensions = (array) $pathinfo['extension'];

        while ((($info = pathinfo($localname))['extension'] ?? null) !== null) {
            $localname = $info['filename'];
            array_unshift($extensions, $info['extension']);
        }

        return [
            'dirname'      => path_normalize($pathinfo['dirname']),
            'basename'     => $pathinfo['basename'],
            'filename'     => $pathinfo['filename'],
            'extension'    => $pathinfo['extension'],
            'dirlocalname' => path_normalize($pathinfo['dirname'] . "/$localname"),
            'localname'    => $localname,
            'extensions'   => $extensions,
        ];
    }
}
if (function_exists("ryunosuke\\Functions\\path_parse") && !defined("ryunosuke\\Functions\\path_parse")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\path_parse", "ryunosuke\\Functions\\path_parse");
}

if (!isset($excluded_functions["cp_rf"]) && (!function_exists("ryunosuke\\Functions\\cp_rf") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\cp_rf"))->isInternal()))) {
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
     * that("$tmp/dst1/hoge.txt")->fileEquals('hoge');
     * that("$tmp/dst1/dir/fuga.txt")->fileEquals('fuga');
     * // "/" を付けると自身コピー
     * cp_rf("$tmp/src", "$tmp/dst2/");
     * that("$tmp/dst2/src/hoge.txt")->fileEquals('hoge');
     * that("$tmp/dst2/src/dir/fuga.txt")->fileEquals('fuga');
     *
     * // $src はファイルでもいい（$dst に "/" を付けるとそのディレクトリにコピーする）
     * cp_rf("$tmp/src/hoge.txt", "$tmp/dst3/");
     * that("$tmp/dst3/hoge.txt")->fileEquals('hoge');
     * // $dst に "/" を付けないとそのパスとしてコピー（copy と完全に同じ）
     * cp_rf("$tmp/src/hoge.txt", "$tmp/dst4");
     * that("$tmp/dst4")->fileEquals('hoge');
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
if (function_exists("ryunosuke\\Functions\\cp_rf") && !defined("ryunosuke\\Functions\\cp_rf")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\cp_rf", "ryunosuke\\Functions\\cp_rf");
}

if (!isset($excluded_functions["rm_rf"]) && (!function_exists("ryunosuke\\Functions\\rm_rf") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\rm_rf"))->isInternal()))) {
    /**
     * 中身があっても消せる rmdir
     *
     * Example:
     * ```php
     * mkdir(sys_get_temp_dir() . '/new/make/dir', 0777, true);
     * rm_rf(sys_get_temp_dir() . '/new');
     * that(file_exists(sys_get_temp_dir() . '/new'))->isSame(false);
     * ```
     *
     * @param string $dirname 削除するディレクトリ名。glob パターンが使える
     * @param bool $self 自分自身も含めるか。false を与えると中身だけを消す
     * @return bool 成功した場合に TRUE を、失敗した場合に FALSE を返します
     */
    function rm_rf($dirname, $self = true)
    {
        $main = static function ($dirname, $self) {
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

            return !$self || rmdir($dirname);
        };

        $result = true;
        $targets = glob($dirname, GLOB_BRACE | GLOB_NOCHECK | ($self ? 0 : GLOB_ONLYDIR));
        foreach ($targets as $target) {
            $result = $main($target, $self) && $result;
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\rm_rf") && !defined("ryunosuke\\Functions\\rm_rf")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\rm_rf", "ryunosuke\\Functions\\rm_rf");
}

if (!isset($excluded_functions["tmpname"]) && (!function_exists("ryunosuke\\Functions\\tmpname") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\tmpname"))->isInternal()))) {
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
     * @param ?string $dir 生成ディレクトリ。省略時は sys_get_temp_dir()
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
        $files[$tempfile] = new class($tempfile) {
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
if (function_exists("ryunosuke\\Functions\\tmpname") && !defined("ryunosuke\\Functions\\tmpname")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\tmpname", "ryunosuke\\Functions\\tmpname");
}

if (!isset($excluded_functions["memory_path"]) && (!function_exists("ryunosuke\\Functions\\memory_path") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\memory_path"))->isInternal()))) {
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
     * that(file_exists($memory_path))->isSame(false);
     * // file_put_contents が使える
     * that(file_put_contents($memory_path, 'Hello, World'))->isSame(12);
     * // file_get_contents が使える
     * that(file_get_contents($memory_path))->isSame('Hello, World');
     * // 上記の操作で実体が存在している
     * that(file_exists($memory_path))->isSame(true);
     * // unlink が使える
     * that(unlink($memory_path))->isSame(true);
     * // unlink したので存在しない
     * that(file_exists($memory_path))->isSame(false);
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
            stream_wrapper_register($STREAM_NAME, get_class(new class() {
                private static $entries = [];

                private $entry;
                private $id;
                private $position;
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

                /** @noinspection PhpUnusedParameterInspection */
                public function stream_set_option(int $option, int $arg1, int $arg2)
                {
                    return false;
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
                        $this->appendable = false;
                    }
                    elseif (strpos($mode, 'w') !== false) {
                        // ファイルポインタをファイルの先頭に置き、ファイルサイズをゼロにします。
                        // ファイルが存在しない場合には、作成を試みます。
                        self::$entries[$this->id] = self::create();
                        $this->position = 0;
                        $this->appendable = false;
                    }
                    elseif (strpos($mode, 'a') !== false) {
                        // ファイルポインタをファイルの終端に置きます。
                        // ファイルが存在しない場合には、作成を試みます。
                        if (!isset(self::$entries[$this->id])) {
                            self::$entries[$this->id] = self::create();
                        }
                        $this->position = 0;
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
                    $result = substr($this->entry->content, $this->position, $count);
                    $this->position += strlen($result);
                    return $result;
                }

                public function stream_write(string $data): int
                {
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
                            $nam = function_exists('posix_getpwnam') ? posix_getpwnam($var) : [];
                            $var = $nam['uid'] ?? 0;
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
if (function_exists("ryunosuke\\Functions\\memory_path") && !defined("ryunosuke\\Functions\\memory_path")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\memory_path", "ryunosuke\\Functions\\memory_path");
}

if (!isset($excluded_functions["delegate"]) && (!function_exists("ryunosuke\\Functions\\delegate") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\delegate"))->isInternal()))) {
    /**
     * 指定 callable を指定クロージャで実行するクロージャを返す
     *
     * ほぼ内部向けで外から呼ぶことはあまり想定していない。
     *
     * @param \Closure $invoker クロージャを実行するためのクロージャ（実処理）
     * @param callable $callable 最終的に実行したいクロージャ
     * @param ?int $arity 引数の数
     * @return callable $callable を実行するクロージャ
     */
    function delegate($invoker, $callable, $arity = null)
    {
        $arity ??= parameter_length($callable, true, true);

        if (reflect_callable($callable)->isInternal()) {
            static $cache = [];
            $cache[$arity] ??= evaluate('return new class()
            {
                private $invoker, $callable;

                public function spawn($invoker, $callable)
                {
                    $that = clone($this);
                    $that->invoker = $invoker;
                    $that->callable = $callable;
                    return $that;
                }

                public function __invoke(' . implode(',', is_infinite($arity)
                    ? ['...$_']
                    : array_map(fn($v) => '$_' . $v, array_keys(array_fill(1, $arity, null)))
                ) . ')
                {
                    return ($this->invoker)($this->callable, func_get_args());
                }
            };');
            return $cache[$arity]->spawn($invoker, $callable);
        }

        switch (true) {
            case $arity === 0:
                return fn() => $invoker($callable, func_get_args());
            case $arity === 1:
                return fn($_1) => $invoker($callable, func_get_args());
            case $arity === 2:
                return fn($_1, $_2) => $invoker($callable, func_get_args());
            case $arity === 3:
                return fn($_1, $_2, $_3) => $invoker($callable, func_get_args());
            case $arity === 4:
                return fn($_1, $_2, $_3, $_4) => $invoker($callable, func_get_args());
            case $arity === 5:
                return fn($_1, $_2, $_3, $_4, $_5) => $invoker($callable, func_get_args());
            case is_infinite($arity):
                return fn(...$_) => $invoker($callable, func_get_args());
            default:
                $args = implode(',', array_map(fn($v) => '$_' . $v, array_keys(array_fill(1, $arity, null))));
                $stmt = 'return function (' . $args . ') use ($invoker, $callable) { return $invoker($callable, func_get_args()); };';
                return eval($stmt);
        }
    }
}
if (function_exists("ryunosuke\\Functions\\delegate") && !defined("ryunosuke\\Functions\\delegate")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\delegate", "ryunosuke\\Functions\\delegate");
}

if (!isset($excluded_functions["abind"]) && (!function_exists("ryunosuke\\Functions\\abind") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\abind"))->isInternal()))) {
    /**
     * $callable の引数を指定配列で束縛したクロージャを返す
     *
     * Example:
     * ```php
     * $bind = abind('sprintf', [1 => 'a', 3 => 'c']);
     * that($bind('%s%s%s', 'b'))->isSame('abc');
     * ```
     *
     * @param callable $callable 対象 callable
     * @param array $default_args 本来の引数
     * @return callable 束縛したクロージャ
     */
    function abind($callable, $default_args)
    {
        return delegate(function ($callable, $args) use ($default_args) {
            return $callable(...array_fill_gap($default_args, ...$args));
        }, $callable, parameter_length($callable, true, true) - count($default_args));
    }
}
if (function_exists("ryunosuke\\Functions\\abind") && !defined("ryunosuke\\Functions\\abind")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\abind", "ryunosuke\\Functions\\abind");
}

if (!isset($excluded_functions["nbind"]) && (!function_exists("ryunosuke\\Functions\\nbind") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\nbind"))->isInternal()))) {
    /**
     * $callable の指定位置に引数を束縛したクロージャを返す
     *
     * Example:
     * ```php
     * $bind = nbind('sprintf', 2, 'X');
     * that($bind('%s%s%s', 'N', 'N'))->isSame('NXN');
     * ```
     *
     * @param callable $callable 対象 callable
     * @param int $n 挿入する引数位置
     * @param mixed ...$variadic 本来の引数（可変引数）
     * @return callable 束縛したクロージャ
     */
    function nbind($callable, $n, ...$variadic)
    {
        return delegate(function ($callable, $args) use ($variadic, $n) {
            return $callable(...array_insert($args, $variadic, $n));
        }, $callable, parameter_length($callable, true, true) - count($variadic));
    }
}
if (function_exists("ryunosuke\\Functions\\nbind") && !defined("ryunosuke\\Functions\\nbind")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\nbind", "ryunosuke\\Functions\\nbind");
}

if (!isset($excluded_functions["lbind"]) && (!function_exists("ryunosuke\\Functions\\lbind") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\lbind"))->isInternal()))) {
    /**
     * $callable の最左に引数を束縛した callable を返す
     *
     * Example:
     * ```php
     * $bind = lbind('sprintf', '%s%s');
     * that($bind('N', 'M'))->isSame('NM');
     * ```
     *
     * @param callable $callable 対象 callable
     * @param mixed ...$variadic 本来の引数（可変引数）
     * @return callable 束縛したクロージャ
     */
    function lbind($callable, ...$variadic)
    {
        return nbind(...array_insert(func_get_args(), 0, 1));
    }
}
if (function_exists("ryunosuke\\Functions\\lbind") && !defined("ryunosuke\\Functions\\lbind")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\lbind", "ryunosuke\\Functions\\lbind");
}

if (!isset($excluded_functions["rbind"]) && (!function_exists("ryunosuke\\Functions\\rbind") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\rbind"))->isInternal()))) {
    /**
     * $callable の最右に引数を束縛した callable を返す
     *
     * Example:
     * ```php
     * $bind = rbind('sprintf', 'X');
     * that($bind('%s%s', 'N'))->isSame('NX');
     * ```
     *
     * @param callable $callable 対象 callable
     * @param mixed ...$variadic 本来の引数（可変引数）
     * @return callable 束縛したクロージャ
     */
    function rbind($callable, ...$variadic)
    {
        return nbind(...array_insert(func_get_args(), null, 1));
    }
}
if (function_exists("ryunosuke\\Functions\\rbind") && !defined("ryunosuke\\Functions\\rbind")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\rbind", "ryunosuke\\Functions\\rbind");
}

if (!isset($excluded_functions["ope_func"]) && (!function_exists("ryunosuke\\Functions\\ope_func") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\ope_func"))->isInternal()))) {
    /**
     * 演算子のクロージャを返す
     *
     * 関数ベースなので `??` のような言語組み込みの特殊な演算子は若干希望通りにならない（Notice が出る）。
     * 2つ目以降の引数でオペランドを指定できる。
     *
     * Example:
     * ```php
     * $not = ope_func('!');    // 否定演算子クロージャ
     * that(false)->isSame($not(true));
     *
     * $minus = ope_func('-'); // マイナス演算子クロージャ
     * that($minus(2))->isSame(-2);       // 引数1つで呼ぶと1項演算子
     * that($minus(3, 2))->isSame(3 - 2); // 引数2つで呼ぶと2項演算子
     *
     * $cond = ope_func('?:'); // 条件演算子クロージャ
     * that($cond('OK', 'NG'))->isSame('OK' ?: 'NG');               // 引数2つで呼ぶと2項演算子
     * that($cond(false, 'OK', 'NG'))->isSame(false ? 'OK' : 'NG'); // 引数3つで呼ぶと3項演算子
     *
     * $gt5 = ope_func('<=', 5); // 5以下を判定するクロージャ
     * that(array_filter([1, 2, 3, 4, 5, 6, 7, 8, 9], $gt5))->isSame([1, 2, 3, 4, 5]);
     * ```
     *
     * @param string $operator 演算子
     * @param mixed ...$operands 右オペランド
     * @return \Closure 演算子のクロージャ
     */
    function ope_func($operator, ...$operands)
    {
        static $operators = null;
        $operators = $operators ?: [
            ''           => static fn($v1) => $v1, // こんな演算子はないが、「if ($value) {}」として使えることがある
            '!'          => static fn($v1) => !$v1,
            '+'          => static fn($v1, $v2 = null) => func_num_args() === 1 ? (+$v1) : ($v1 + $v2),
            '-'          => static fn($v1, $v2 = null) => func_num_args() === 1 ? (-$v1) : ($v1 - $v2),
            '~'          => static fn($v1) => ~$v1,
            '++'         => static fn(&$v1) => ++$v1,
            '--'         => static fn(&$v1) => --$v1,
            '?:'         => static fn($v1, $v2, $v3 = null) => func_num_args() === 2 ? ($v1 ?: $v2) : ($v1 ? $v2 : $v3),
            '??'         => static fn($v1, $v2) => $v1 ?? $v2,
            '=='         => static fn($v1, $v2) => $v1 == $v2,
            '==='        => static fn($v1, $v2) => $v1 === $v2,
            '!='         => static fn($v1, $v2) => $v1 != $v2,
            '<>'         => static fn($v1, $v2) => $v1 <> $v2,
            '!=='        => static fn($v1, $v2) => $v1 !== $v2,
            '<'          => static fn($v1, $v2) => $v1 < $v2,
            '<='         => static fn($v1, $v2) => $v1 <= $v2,
            '>'          => static fn($v1, $v2) => $v1 > $v2,
            '>='         => static fn($v1, $v2) => $v1 >= $v2,
            '<=>'        => static fn($v1, $v2) => $v1 <=> $v2,
            '.'          => static fn($v1, $v2) => $v1 . $v2,
            '*'          => static fn($v1, $v2) => $v1 * $v2,
            '/'          => static fn($v1, $v2) => $v1 / $v2,
            '%'          => static fn($v1, $v2) => $v1 % $v2,
            '**'         => static fn($v1, $v2) => $v1 ** $v2,
            '^'          => static fn($v1, $v2) => $v1 ^ $v2,
            '&'          => static fn($v1, $v2) => $v1 & $v2,
            '|'          => static fn($v1, $v2) => $v1 | $v2,
            '<<'         => static fn($v1, $v2) => $v1 << $v2,
            '>>'         => static fn($v1, $v2) => $v1 >> $v2,
            '&&'         => static fn($v1, $v2) => $v1 && $v2,
            '||'         => static fn($v1, $v2) => $v1 || $v2,
            'or'         => static fn($v1, $v2) => $v1 or $v2,
            'and'        => static fn($v1, $v2) => $v1 and $v2,
            'xor'        => static fn($v1, $v2) => $v1 xor $v2,
            'instanceof' => static fn($v1, $v2) => $v1 instanceof $v2,
            'new'        => static fn($v1, ...$v) => new $v1(...$v),
            'clone'      => static fn($v1) => clone $v1,
        ];

        $opefunc = $operators[trim($operator)] ?? throws(new \InvalidArgumentException("$operator is not defined Operator."));

        if ($operands) {
            return static fn($v1) => $opefunc($v1, ...$operands);
        }

        return $opefunc;
    }
}
if (function_exists("ryunosuke\\Functions\\ope_func") && !defined("ryunosuke\\Functions\\ope_func")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\ope_func", "ryunosuke\\Functions\\ope_func");
}

if (!isset($excluded_functions["not_func"]) && (!function_exists("ryunosuke\\Functions\\not_func") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\not_func"))->isInternal()))) {
    /**
     * 返り値の真偽値を逆転した新しいクロージャを返す
     *
     * Example:
     * ```php
     * $not_strlen = not_func('strlen');
     * that($not_strlen('hoge'))->isFalse();
     * that($not_strlen(''))->isTrue();
     * ```
     *
     * @param callable $callable 対象 callable
     * @return callable 新しいクロージャ
     */
    function not_func($callable)
    {
        return delegate(fn($callable, $args) => !$callable(...$args), $callable);
    }
}
if (function_exists("ryunosuke\\Functions\\not_func") && !defined("ryunosuke\\Functions\\not_func")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\not_func", "ryunosuke\\Functions\\not_func");
}

if (!isset($excluded_functions["eval_func"]) && (!function_exists("ryunosuke\\Functions\\eval_func") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\eval_func"))->isInternal()))) {
    /**
     * 指定コードで eval するクロージャを返す
     *
     * create_function のクロージャ版みたいなもの。
     * 参照渡しは未対応。
     *
     * Example:
     * ```php
     * $evalfunc = eval_func('$a + $b + $c', 'a', 'b', 'c');
     * that($evalfunc(1, 2, 3))->isSame(6);
     * ```
     *
     * @param string $expression eval コード
     * @param mixed ...$variadic 引数名（可変引数）
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
if (function_exists("ryunosuke\\Functions\\eval_func") && !defined("ryunosuke\\Functions\\eval_func")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\eval_func", "ryunosuke\\Functions\\eval_func");
}

if (!isset($excluded_functions["reflect_callable"]) && (!function_exists("ryunosuke\\Functions\\reflect_callable") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\reflect_callable"))->isInternal()))) {
    /**
     * callable から ReflectionFunctionAbstract を生成する
     *
     * Example:
     * ```php
     * that(reflect_callable('sprintf'))->isInstanceOf(\ReflectionFunction::class);
     * that(reflect_callable('\Closure::bind'))->isInstanceOf(\ReflectionMethod::class);
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
            [$class, $method] = explode('::', $call_name, 2);
            // for タイプ 5: 相対指定による静的クラスメソッドのコール (PHP 5.3.0 以降)
            if (strpos($method, 'parent::') === 0) {
                [, $method] = explode('::', $method);
                return (new \ReflectionClass($class))->getParentClass()->getMethod($method);
            }
            return new \ReflectionMethod($class, $method);
        }
    }
}
if (function_exists("ryunosuke\\Functions\\reflect_callable") && !defined("ryunosuke\\Functions\\reflect_callable")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\reflect_callable", "ryunosuke\\Functions\\reflect_callable");
}

if (!isset($excluded_functions["callable_code"]) && (!function_exists("ryunosuke\\Functions\\callable_code") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\callable_code"))->isInternal()))) {
    /**
     * callable のコードブロックを返す
     *
     * 返り値は2値の配列。0番目の要素が定義部、1番目の要素が処理部を表す。
     *
     * Example:
     * ```php
     * list($meta, $body) = callable_code(function (...$args) {return true;});
     * that($meta)->isSame('function (...$args)');
     * that($body)->isSame('{return true;}');
     *
     * // ReflectionFunctionAbstract を渡しても動作する
     * list($meta, $body) = callable_code(new \ReflectionFunction(function (...$args) {return true;}));
     * that($meta)->isSame('function (...$args)');
     * that($body)->isSame('{return true;}');
     * ```
     *
     * @param callable|\ReflectionFunctionAbstract $callable コードを取得する callable
     * @return array ['定義部分', '{処理コード}']
     */
    function callable_code($callable)
    {
        $ref = $callable instanceof \ReflectionFunctionAbstract ? $callable : reflect_callable($callable);
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
            'offset' => last_key($meta),
        ]);

        return [trim(implode('', array_column($meta, 1))), trim(implode('', array_column($body, 1)))];
    }
}
if (function_exists("ryunosuke\\Functions\\callable_code") && !defined("ryunosuke\\Functions\\callable_code")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\callable_code", "ryunosuke\\Functions\\callable_code");
}

if (!isset($excluded_functions["call_safely"]) && (!function_exists("ryunosuke\\Functions\\call_safely") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\call_safely"))->isInternal()))) {
    /**
     * エラーを例外に変換するブロックでコールバックを実行する
     *
     * Example:
     * ```php
     * try {
     *     call_safely(fn() => []['dummy']);
     * }
     * catch (\Exception $ex) {
     *     that($ex->getMessage())->containsAll(['Undefined', 'dummy']);
     * }
     * ```
     *
     * @param callable $callback 実行するコールバック
     * @param mixed ...$variadic $callback に渡される引数（可変引数）
     * @return mixed $callback の返り値
     */
    function call_safely($callback, ...$variadic)
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            if (!(error_reporting() & $errno)) {
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
if (function_exists("ryunosuke\\Functions\\call_safely") && !defined("ryunosuke\\Functions\\call_safely")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\call_safely", "ryunosuke\\Functions\\call_safely");
}

if (!isset($excluded_functions["ob_capture"]) && (!function_exists("ryunosuke\\Functions\\ob_capture") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\ob_capture"))->isInternal()))) {
    /**
     * ob_start ～ ob_get_clean のブロックでコールバックを実行する
     *
     * Example:
     * ```php
     * // コールバック内のテキストが得られる
     * that(ob_capture(fn() => print(123)))->isSame('123');
     * // こういう事もできる
     * that(ob_capture(function () {
     * ?>
     * bare string1
     * bare string2
     * <?php
     * }))->isSame("bare string1\nbare string2\n");
     * ```
     *
     * @param callable $callback 実行するコールバック
     * @param mixed ...$variadic $callback に渡される引数（可変引数）
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
if (function_exists("ryunosuke\\Functions\\ob_capture") && !defined("ryunosuke\\Functions\\ob_capture")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\ob_capture", "ryunosuke\\Functions\\ob_capture");
}

if (!isset($excluded_functions["is_bindable_closure"]) && (!function_exists("ryunosuke\\Functions\\is_bindable_closure") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\is_bindable_closure"))->isInternal()))) {
    /**
     * $this を bind 可能なクロージャか調べる
     *
     * Example:
     * ```php
     * that(is_bindable_closure(function () {}))->isTrue();
     * that(is_bindable_closure(static function () {}))->isFalse();
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
if (function_exists("ryunosuke\\Functions\\is_bindable_closure") && !defined("ryunosuke\\Functions\\is_bindable_closure")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\is_bindable_closure", "ryunosuke\\Functions\\is_bindable_closure");
}

if (!isset($excluded_functions["by_builtin"]) && (!function_exists("ryunosuke\\Functions\\by_builtin") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\by_builtin"))->isInternal()))) {
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
     * that(count($counter))->isSame(1);
     * that($counter->count())->isSame(0);
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
if (function_exists("ryunosuke\\Functions\\by_builtin") && !defined("ryunosuke\\Functions\\by_builtin")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\by_builtin", "ryunosuke\\Functions\\by_builtin");
}

if (!isset($excluded_functions["namedcallize"]) && (!function_exists("ryunosuke\\Functions\\namedcallize") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\namedcallize"))->isInternal()))) {
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
     * $f = fn ($x, $a = 1, $b = 2, ...$other) => get_defined_vars();
     *
     * // x に 'X', a に 9 を与えて名前付きで呼べるクロージャ
     * $f1 = namedcallize($f, [
     *     'x' => 'X',
     *     'a' => 9,
     * ]);
     * // 引数無しで呼ぶと↑で与えた引数が使用される（b は渡されていないのでデフォルト引数の 2 が使用される）
     * that($f1())->isSame([
     *     'x'     => 'X',
     *     'a'     => 9,
     *     'b'     => 2,
     *     'other' => [],
     * ]);
     * // 引数付きで呼ぶとそれが優先される
     * that($f1([
     *     'x'     => 'XXX',
     *     'a'     => 99,
     *     'b'     => 999,
     *     'other' => [1, 2, 3],
     * ]))->isSame([
     *     'x'     => 'XXX',
     *     'a'     => 99,
     *     'b'     => 999,
     *     'other' => [1, 2, 3],
     * ]);
     * // 引数名ではなく、 n 番目指定でも同じ
     * that($f1([
     *     'x' => 'XXX',
     *     1   => 99,
     *     2   => 999,
     *     3   => [1, 2, 3],
     * ]))->isSame([
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
     * that($f2(['other' => [4, 5, 6]]))->isSame([
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
        static $dummy_arg;
        $dummy_arg ??= new \stdClass();

        /** @var \ReflectionFunctionAbstract $reffunc */
        $reffunc = reflect_callable($callable);
        $refparams = $reffunc->getParameters();

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

        return function ($params = []) use ($reffunc, $defargs, $argnames, $variadicname, $dummy_arg) {
            $params = array_map_key($params, fn($k) => is_int($k) ? $argnames[$k] : $k);
            $params = array_replace($defargs, $params);

            // 勝手に突っ込んだ $dummy_class がいるのはおかしい。指定されていないと思われる
            if ($dummyargs = array_filter($params, fn($v) => $v === $dummy_arg)) {
                // が、php8 未満では組み込みのデフォルト値は取れないので、除外
                if (!$reffunc->isInternal()) {
                    throw new \InvalidArgumentException('missing required arguments(' . implode(', ', array_keys($dummyargs)) . ').');
                }
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

            if ($reffunc instanceof \ReflectionMethod && $reffunc->isConstructor()) {
                $object = $reffunc->getDeclaringClass()->newInstanceWithoutConstructor();
                $reffunc->invoke($object, ...array_values($params));
                return $object;
            }
            return $reffunc->invoke(...array_values($params));
        };
    }
}
if (function_exists("ryunosuke\\Functions\\namedcallize") && !defined("ryunosuke\\Functions\\namedcallize")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\namedcallize", "ryunosuke\\Functions\\namedcallize");
}

if (!isset($excluded_functions["parameter_length"]) && (!function_exists("ryunosuke\\Functions\\parameter_length") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\parameter_length"))->isInternal()))) {
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
     * that(parameter_length('trim'))->isSame(2);
     * // trim の必須引数は1つ
     * that(parameter_length('trim', true))->isSame(1);
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
if (function_exists("ryunosuke\\Functions\\parameter_length") && !defined("ryunosuke\\Functions\\parameter_length")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\parameter_length", "ryunosuke\\Functions\\parameter_length");
}

if (!isset($excluded_functions["parameter_default"]) && (!function_exists("ryunosuke\\Functions\\parameter_default") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\parameter_default"))->isInternal()))) {
    /**
     * callable のデフォルト引数を返す
     *
     * オプションで指定もできる。
     * 負数を指定した場合「最後の引数から数えた位置」になる。
     *
     * 内部関数には使用できない（リフレクションが対応していない）。
     *
     * Example:
     * ```php
     * $f = function ($a, $b = 'b') {};
     * // デフォルト引数である b を返す
     * that(parameter_default($f))->isSame([1 => 'b']);
     * // 引数で与えるとそれが優先される
     * that(parameter_default($f, ['A', 'B']))->isSame(['A', 'B']);
     * ```
     *
     * @param callable $callable 対象 callable
     * @param iterable|array $arguments デフォルト引数
     * @return array デフォルト引数
     */
    function parameter_default(callable $callable, $arguments = [])
    {
        static $cache = [];

        // $call_name でキャッシュ。しかしクロージャはすべて「Closure::__invoke」になるのでキャッシュできない
        is_callable($callable, true, $call_name);
        if (!isset($cache[$call_name]) || $callable instanceof \Closure) {
            /** @var \ReflectionFunctionAbstract $refunc */
            $refunc = reflect_callable($callable);
            assert($refunc->isUserDefined(), 'no support internal callable.');
            $cache[$call_name] = [
                'length'  => $refunc->getNumberOfParameters(),
                'default' => [],
            ];
            foreach ($refunc->getParameters() as $n => $param) {
                if ($param->isDefaultValueAvailable()) {
                    $cache[$call_name]['default'][$n] = $param->getDefaultValue();
                }
            }
        }

        // 指定されていないならそのまま返せば良い（高速化）
        if (is_array($arguments) && !$arguments) {
            return $cache[$call_name]['default'];
        }

        $args2 = [];
        foreach ($arguments as $n => $arg) {
            if ($n < 0) {
                $n += $cache[$call_name]['length'];
            }
            $args2[$n] = $arg;
        }

        return array_merge2($cache[$call_name]['default'], $args2);
    }
}
if (function_exists("ryunosuke\\Functions\\parameter_default") && !defined("ryunosuke\\Functions\\parameter_default")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\parameter_default", "ryunosuke\\Functions\\parameter_default");
}

if (!isset($excluded_functions["parameter_wiring"]) && (!function_exists("ryunosuke\\Functions\\parameter_wiring") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\parameter_wiring"))->isInternal()))) {
    /**
     * callable の引数の型情報に基づいてワイヤリングした引数配列を返す
     *
     * ワイヤリングは下記のルールに基づいて行われる。
     *
     * - 引数の型とキーが完全一致
     * - 引数の型とキーが継承・実装関係
     *   - 複数一致した場合は解決されない
     * - 引数名とキーが完全一致
     *   - 可変引数は追加
     * - 引数のデフォルト値
     * - 得られた値がクロージャの場合は再帰的に解決
     *   - $this は $dependency になるが FromCallable 経由の場合は元のまま
     *
     * Example:
     * ```php
     * $closure = function (\ArrayObject $ao, \Throwable $t, $array, $none, $default1, $default2 = 'default2', ...$misc) { return get_defined_vars(); };
     * $params = (parameter_wiring)($closure, [
     *     \ArrayObject::class      => $ao = new \ArrayObject([1, 2, 3]),
     *     \RuntimeException::class => $t = new \RuntimeException('hoge'),
     *     '$array'                 => fn (\ArrayObject $ao) => (array) $ao,
     *     4                        => 'default1',
     *     '$misc'                  => ['x', 'y', 'z'],
     * ]);
     * that($params)->isSame([
     *     0 => $ao,        // 0番目はクラス名が完全一致
     *     1 => $t,         // 1番目はインターフェース実装
     *     2 => [1, 2, 3],  // 2番目はクロージャをコール
     *                      // 3番目は解決されない
     *     4 => 'default1', // 4番目は順番指定のデフォルト値
     *     5 => 'default2', // 5番目は引数定義のデフォルト値
     *     6 => 'x',        // 可変引数なのでフラットに展開
     *     7 => 'y',
     *     8 => 'z',
     * ]);
     * ```
     *
     * @param callable $callable 対象 callable
     * @param array|\ArrayAccess $dependency 引数候補配列
     * @return array 引数配列
     */
    function parameter_wiring($callable, $dependency)
    {
        /** @var \ReflectionFunctionAbstract $ref */
        $ref = reflect_callable($callable);
        $result = [];

        foreach ($ref->getParameters() as $n => $parameter) {
            if (isset($dependency[$n])) {
                $result[$n] = $dependency[$n];
            }
            elseif (isset($dependency[$pname = '$' . $parameter->getName()])) {
                if ($parameter->isVariadic()) {
                    foreach (array_values(arrayize($dependency[$pname])) as $i => $v) {
                        $result[$n + $i] = $v;
                    }
                }
                else {
                    $result[$n] = $dependency[$pname];
                }
            }
            elseif (($typename = (string) reflect_types($parameter->getType()))) {
                if (isset($dependency[$typename])) {
                    $result[$n] = $dependency[$typename];
                }
                else {
                    foreach ($dependency as $key => $value) {
                        if (is_subclass_of(ltrim($key, '\\'), $typename, true)) {
                            if (array_key_exists($n, $result)) {
                                unset($result[$n]);
                                break;
                            }
                            $result[$n] = $value;
                        }
                    }
                }
            }
            elseif ($parameter->isDefaultValueAvailable()) {
                $result[$n] = $parameter->getDefaultValue();
            }
        }

        // $this bind するのでオブジェクト化しておく
        if (!is_object($dependency)) {
            $dependency = new \ArrayObject($dependency);
        }

        // recurse for closure
        return array_map(function ($arg) use ($dependency) {
            if ($arg instanceof \Closure) {
                if ((new \ReflectionFunction($arg))->getShortName() === '{closure}') {
                    $arg = $arg->bindTo($dependency);
                }
                return $arg(...parameter_wiring($arg, $dependency));
            }
            return $arg;
        }, $result);
    }
}
if (function_exists("ryunosuke\\Functions\\parameter_wiring") && !defined("ryunosuke\\Functions\\parameter_wiring")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\parameter_wiring", "ryunosuke\\Functions\\parameter_wiring");
}

if (!isset($excluded_functions["function_shorten"]) && (!function_exists("ryunosuke\\Functions\\function_shorten") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\function_shorten"))->isInternal()))) {
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
if (function_exists("ryunosuke\\Functions\\function_shorten") && !defined("ryunosuke\\Functions\\function_shorten")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\function_shorten", "ryunosuke\\Functions\\function_shorten");
}

if (!isset($excluded_functions["func_user_func_array"]) && (!function_exists("ryunosuke\\Functions\\func_user_func_array") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\func_user_func_array"))->isInternal()))) {
    /**
     * パラメータ定義数に応じて呼び出し引数を可変にしてコールする
     *
     * デフォルト引数はカウントされない。必須パラメータの数で呼び出す。
     *
     * $callback に null を与えると例外的に「第1引数を返すクロージャ」を返す。
     *
     * php の標準関数は定義数より多い引数を投げるとエラーを出すのでそれを抑制したい場合に使う。
     *
     * Example:
     * ```php
     * // strlen に2つの引数を渡してもエラーにならない
     * $strlen = func_user_func_array('strlen');
     * that($strlen('abc', null))->isSame(3);
     * ```
     *
     * @param callable $callback 呼び出すクロージャ
     * @return callable 引数ぴったりで呼び出すクロージャ
     */
    function func_user_func_array($callback)
    {
        // null は第1引数を返す特殊仕様
        if ($callback === null) {
            return fn($v) => $v;
        }
        // クロージャはユーザ定義しかありえないので調べる必要がない
        if ($callback instanceof \Closure) {
            // と思ったが、\Closure::fromCallable で作成されたクロージャは内部属性が伝播されるようなので除外
            if (reflect_callable($callback)->isUserDefined()) {
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
if (function_exists("ryunosuke\\Functions\\func_user_func_array") && !defined("ryunosuke\\Functions\\func_user_func_array")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\func_user_func_array", "ryunosuke\\Functions\\func_user_func_array");
}

if (!isset($excluded_functions["func_wiring"]) && (!function_exists("ryunosuke\\Functions\\func_wiring") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\func_wiring"))->isInternal()))) {
    /**
     * 引数の型情報に基づいてワイヤリングしたクロージャを返す
     *
     * $dependency に数値キーの配列を混ぜるとデフォルト値として使用される。
     * 得られたクロージャの呼び出し時に引数を与える事ができる。
     *
     * parameter_wiring も参照。
     *
     * Example:
     * ```php
     * $closure = fn ($a, $b) => func_get_args();
     * $new_closure = func_wiring($closure, [
     *     '$a' => 'a',
     *     '$b' => 'b',
     *     1    => 'B',
     * ]);
     * that($new_closure())->isSame(['a', 'B']);    // 同時指定の場合は数値キー優先
     * that($new_closure('A'))->isSame(['A', 'B']); // 呼び出し時の引数優先
     * ```
     *
     * @param callable $callable 対象 callable
     * @param array|\ArrayAccess $dependency 引数候補配列
     * @return \Closure 引数を確定したクロージャ
     */
    function func_wiring($callable, $dependency)
    {
        $params = parameter_wiring($callable, $dependency);
        return fn(...$args) => $callable(...$args + $params);
    }
}
if (function_exists("ryunosuke\\Functions\\func_wiring") && !defined("ryunosuke\\Functions\\func_wiring")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\func_wiring", "ryunosuke\\Functions\\func_wiring");
}

if (!isset($excluded_functions["func_new"]) && (!function_exists("ryunosuke\\Functions\\func_new") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\func_new"))->isInternal()))) {
    /**
     * 指定クラスのコンストラクタを呼び出すクロージャを返す
     *
     * この関数を呼ぶとコンストラクタのクロージャを返す。
     *
     * オプションでデフォルト引数を設定できる（Example を参照）。
     *
     * Example:
     * ```php
     * // Exception のコンストラクタを呼ぶクロージャ
     * $newException = func_new(\Exception::class, 'hoge');
     * // デフォルト引数を使用して Exception を作成
     * that($newException()->getMessage())->isSame('hoge');
     * // 引数を指定して Exception を作成
     * that($newException('fuga')->getMessage())->isSame('fuga');
     * ```
     *
     * @param string $classname クラス名
     * @param mixed ...$defaultargs コンストラクタのデフォルト引数
     * @return \Closure コンストラクタを呼び出すクロージャ
     */
    function func_new($classname, ...$defaultargs)
    {
        return fn(...$args) => new $classname(...$args + $defaultargs);
    }
}
if (function_exists("ryunosuke\\Functions\\func_new") && !defined("ryunosuke\\Functions\\func_new")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\func_new", "ryunosuke\\Functions\\func_new");
}

if (!isset($excluded_functions["func_method"]) && (!function_exists("ryunosuke\\Functions\\func_method") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\func_method"))->isInternal()))) {
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
     * that($hoge($object, 1, 2, 3))->isSame('1,2,3');
     *
     * // デフォルト値付きで hoge を呼び出すクロージャ
     * $hoge789 = func_method('hoge', 7, 8, 9);
     * // ↑を使用して $object の hoge を呼び出す（引数指定してるので結果は同じ）
     * that($hoge789($object, 1, 2, 3))->isSame('1,2,3');
     * // 同上（一部デフォルト値）
     * that($hoge789($object, 1, 2))->isSame('1,2,9');
     * // 同上（全部デフォルト値）
     * that($hoge789($object))->isSame('7,8,9');
     * ```
     *
     * @param string $methodname メソッド名
     * @param mixed ...$defaultargs メソッドのデフォルト引数
     * @return \Closure メソッドを呼び出すクロージャ
     */
    function func_method($methodname, ...$defaultargs)
    {
        if ($methodname === '__construct') {
            return fn($object, ...$args) => new $object(...$args + $defaultargs);
        }
        return fn($object, ...$args) => ([$object, $methodname])(...$args + $defaultargs);
    }
}
if (function_exists("ryunosuke\\Functions\\func_method") && !defined("ryunosuke\\Functions\\func_method")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\func_method", "ryunosuke\\Functions\\func_method");
}

if (!isset($excluded_functions["function_alias"]) && (!function_exists("ryunosuke\\Functions\\function_alias") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\function_alias"))->isInternal()))) {
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
     * that(trim_alias(' abc '))->isSame('abc');
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
        if (!file_exists($cachefile)) {
            $parts = explode('\\', ltrim($alias, '\\'));
            $reference = $ref->returnsReference() ? '&' : '';
            $funcname = $reference . array_pop($parts);
            $namespace = implode('\\', $parts);

            $params = function_parameter($ref);
            $prms = implode(', ', array_values($params));
            $args = implode(', ', array_keys($params));
            if ($ref->isInternal()) {
                $args = "array_slice([$args] + func_get_args(), 0, func_num_args())";
            }
            else {
                $args = "[$args]";
            }

            $code = <<<CODE
            namespace $namespace {
                function $funcname($prms) {
                    \$return = $reference \\$calllname(...$args);
                    return \$return;
                }
            }
            CODE;
            file_put_contents($cachefile, "<?php\n" . $code);
        }
        require_once $cachefile;
    }
}
if (function_exists("ryunosuke\\Functions\\function_alias") && !defined("ryunosuke\\Functions\\function_alias")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\function_alias", "ryunosuke\\Functions\\function_alias");
}

if (!isset($excluded_functions["function_parameter"]) && (!function_exists("ryunosuke\\Functions\\function_parameter") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\function_parameter"))->isInternal()))) {
    /**
     * 関数/メソッドの引数定義を取得する
     *
     * ほぼ内部向けで外から呼ぶことはあまり想定していない。
     *
     * @param \ReflectionFunctionAbstract|callable $eitherReffuncOrCallable 関数/メソッドリフレクション or callable
     * @return array [引数名 => 引数宣言] の配列
     */
    function function_parameter($eitherReffuncOrCallable)
    {
        $reffunc = $eitherReffuncOrCallable instanceof \ReflectionFunctionAbstract
            ? $eitherReffuncOrCallable
            : reflect_callable($eitherReffuncOrCallable);

        $result = [];
        foreach ($reffunc->getParameters() as $parameter) {
            $declare = '';

            if ($parameter->hasType()) {
                $declare .= reflect_types($parameter->getType())->getName() . ' ';
            }

            $declare .= ($parameter->isPassedByReference() ? '&' : '') . '$' . $parameter->getName();

            if ($parameter->isVariadic()) {
                $declare = '...' . $declare;
            }
            elseif ($parameter->isOptional()) {
                // 組み込み関数のデフォルト値を取得することは出来ない（isDefaultValueAvailable も false を返す）
                if ($parameter->isDefaultValueAvailable()) {
                    // 修飾なしでデフォルト定数が使われているとその名前空間で解決してしまうので場合分けが必要
                    if ($parameter->isDefaultValueConstant() && strpos($parameter->getDefaultValueConstantName(), '\\') === false) {
                        $defval = $parameter->getDefaultValueConstantName();
                    }
                    else {
                        $defval = var_export2($parameter->getDefaultValue(), true);
                    }
                }
                // 「オプショナルだけどデフォルト値がないって有り得るのか？」と思ったが、上記の通り組み込み関数だと普通に有り得るようだ
                // notice が出るので記述せざるを得ないがその値を得る術がない。が、どうせ与えられないので null でいい
                else {
                    $defval = 'null';
                }
                $declare .= ' = ' . $defval;
            }

            $name = ($parameter->isPassedByReference() ? '&' : '') . '$' . $parameter->getName();
            $result[$name] = $declare;
        }

        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\function_parameter") && !defined("ryunosuke\\Functions\\function_parameter")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\function_parameter", "ryunosuke\\Functions\\function_parameter");
}

if (!isset($excluded_functions["minimum"]) && (!function_exists("ryunosuke\\Functions\\minimum") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\minimum"))->isInternal()))) {
    /**
     * 引数の最小値を返す
     *
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * that(minimum(-1, 0, 1))->isSame(-1);
     * ```
     *
     * @param mixed ...$variadic 対象の変数・配列・リスト
     * @return mixed 最小値
     */
    function minimum(...$variadic)
    {
        $args = array_flatten($variadic) or throws(new \LengthException("argument's length is 0."));
        return min($args);
    }
}
if (function_exists("ryunosuke\\Functions\\minimum") && !defined("ryunosuke\\Functions\\minimum")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\minimum", "ryunosuke\\Functions\\minimum");
}

if (!isset($excluded_functions["maximum"]) && (!function_exists("ryunosuke\\Functions\\maximum") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\maximum"))->isInternal()))) {
    /**
     * 引数の最大値を返す
     *
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * that(maximum(-1, 0, 1))->isSame(1);
     * ```
     *
     * @param mixed ...$variadic 対象の変数・配列・リスト
     * @return mixed 最大値
     */
    function maximum(...$variadic)
    {
        $args = array_flatten($variadic) or throws(new \LengthException("argument's length is 0."));
        return max($args);
    }
}
if (function_exists("ryunosuke\\Functions\\maximum") && !defined("ryunosuke\\Functions\\maximum")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\maximum", "ryunosuke\\Functions\\maximum");
}

if (!isset($excluded_functions["mode"]) && (!function_exists("ryunosuke\\Functions\\mode") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\mode"))->isInternal()))) {
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
     * that(mode(0, 1, 2, 2, 3, 3, 3))->isSame(3);
     * ```
     *
     * @param mixed ...$variadic 対象の変数・配列・リスト
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
if (function_exists("ryunosuke\\Functions\\mode") && !defined("ryunosuke\\Functions\\mode")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\mode", "ryunosuke\\Functions\\mode");
}

if (!isset($excluded_functions["mean"]) && (!function_exists("ryunosuke\\Functions\\mean") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\mean"))->isInternal()))) {
    /**
     * 引数の相加平均値を返す
     *
     * - is_numeric でない値は除外される（計算結果に影響しない）
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * that(mean(1, 2, 3, 4, 5, 6))->isSame(3.5);
     * that(mean(1, '2', 3, 'noize', 4, 5, 'noize', 6))->isSame(3.5);
     * ```
     *
     * @param mixed ...$variadic 対象の変数・配列・リスト
     * @return int|float 相加平均値
     */
    function mean(...$variadic)
    {
        $args = array_flatten($variadic) or throws(new \LengthException("argument's length is 0."));
        $args = array_filter($args, 'is_numeric') or throws(new \LengthException("argument's must be contain munber."));
        return array_sum($args) / count($args);
    }
}
if (function_exists("ryunosuke\\Functions\\mean") && !defined("ryunosuke\\Functions\\mean")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\mean", "ryunosuke\\Functions\\mean");
}

if (!isset($excluded_functions["median"]) && (!function_exists("ryunosuke\\Functions\\median") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\median"))->isInternal()))) {
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
     * that(median(1, 2, 3, 4, 5, 6))->isSame(3.5);
     * // 奇数個なのでど真ん中
     * that(median(1, 2, 3, 4, 5))->isSame(3);
     * // 偶数個だが文字列なので中2つの後
     * that(median('a', 'b', 'c', 'd'))->isSame('c');
     * ```
     *
     * @param mixed ...$variadic 対象の変数・配列・リスト
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
if (function_exists("ryunosuke\\Functions\\median") && !defined("ryunosuke\\Functions\\median")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\median", "ryunosuke\\Functions\\median");
}

if (!isset($excluded_functions["average"]) && (!function_exists("ryunosuke\\Functions\\average") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\average"))->isInternal()))) {
    /**
     * 引数の意味平均値を返す
     *
     * - 3座標の重心座標とか日付の平均とかそういうもの
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * @param mixed ...$variadic 対象の変数・配列・リスト
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
if (function_exists("ryunosuke\\Functions\\average") && !defined("ryunosuke\\Functions\\average")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\average", "ryunosuke\\Functions\\average");
}

if (!isset($excluded_functions["sum"]) && (!function_exists("ryunosuke\\Functions\\sum") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\sum"))->isInternal()))) {
    /**
     * 引数の合計値を返す
     *
     * - is_numeric でない値は除外される（計算結果に影響しない）
     * - 配列は個数ではなくフラット展開した要素を対象にする
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * that(sum(1, 2, 3, 4, 5, 6))->isSame(21);
     * ```
     *
     * @param mixed ...$variadic 対象の変数・配列・リスト
     * @return mixed 合計値
     */
    function sum(...$variadic)
    {
        $args = array_flatten($variadic) or throws(new \LengthException("argument's length is 0."));
        $args = array_filter($args, 'is_numeric') or throws(new \LengthException("argument's must be contain munber."));
        return array_sum($args);
    }
}
if (function_exists("ryunosuke\\Functions\\sum") && !defined("ryunosuke\\Functions\\sum")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\sum", "ryunosuke\\Functions\\sum");
}

if (!isset($excluded_functions["clamp"]) && (!function_exists("ryunosuke\\Functions\\clamp") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\clamp"))->isInternal()))) {
    /**
     * 値を一定範囲に収める
     *
     * $circulative に true を渡すと値が循環する。
     * ただし、循環的な型に限る（整数のみ？）。
     *
     * Example:
     * ```php
     * // 5～9 に収める
     * that(clamp(4, 5, 9))->isSame(5); // 4 は [5～9] の範囲外なので 5 に切り上げられる
     * that(clamp(5, 5, 9))->isSame(5); // 範囲内なのでそのまま
     * that(clamp(6, 5, 9))->isSame(6); // 範囲内なのでそのまま
     * that(clamp(7, 5, 9))->isSame(7); // 範囲内なのでそのまま
     * that(clamp(8, 5, 9))->isSame(8); // 範囲内なのでそのまま
     * that(clamp(9, 5, 9))->isSame(9); // 範囲内なのでそのまま
     * that(clamp(10, 5, 9))->isSame(9); // 10 は [5～9] の範囲外なので 9 に切り下げられる
     *
     * // 5～9 に収まるように循環する
     * that(clamp(4, 5, 9, true))->isSame(9); // 4 は [5～9] の範囲外なので循環して 9 になる
     * that(clamp(5, 5, 9, true))->isSame(5); // 範囲内なのでそのまま
     * that(clamp(6, 5, 9, true))->isSame(6); // 範囲内なのでそのまま
     * that(clamp(7, 5, 9, true))->isSame(7); // 範囲内なのでそのまま
     * that(clamp(8, 5, 9, true))->isSame(8); // 範囲内なのでそのまま
     * that(clamp(9, 5, 9, true))->isSame(9); // 範囲内なのでそのまま
     * that(clamp(10, 5, 9, true))->isSame(5); // 10 は [5～9] の範囲外なので循環して 5 になる
     * ```
     *
     * @param int|mixed $value 対象の値
     * @param int|mixed $min 最小値
     * @param int|mixed $max 最大値
     * @param bool $circulative true だと切り詰めるのではなく循環する
     * @return int 一定範囲に収められた値
     */
    function clamp($value, $min, $max, $circulative = false)
    {
        if (!$circulative) {
            return max($min, min($max, $value));
        }

        if ($value < $min) {
            return $max + ($value - $max) % ($max - $min + 1);
        }
        if ($value > $max) {
            return $min + ($value - $min) % ($max - $min + 1);
        }
        return $value;
    }
}
if (function_exists("ryunosuke\\Functions\\clamp") && !defined("ryunosuke\\Functions\\clamp")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\clamp", "ryunosuke\\Functions\\clamp");
}

if (!isset($excluded_functions["decimal"]) && (!function_exists("ryunosuke\\Functions\\decimal") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\decimal"))->isInternal()))) {
    /**
     * 数値を指定桁数に丸める
     *
     * 感覚的には「桁数指定できる ceil/floor」に近い。
     * ただし、正の方向(ceil)、負の方向(floor)以外にも0の方向、無限大の方向も実装されている（さらに四捨五入もできる）。
     *
     * - 0   : 0 に近づく方向： 絶対値が必ず減る
     * - null: 0 から離れる方向： 絶対値が必ず増える
     * - -INF: 負の無限大の方向： 数値として必ず減る
     * - +INF : 正の無限大の方向： 数値として必ず増える
     *
     * のように「持っていきたい方向（の数値）」を指定すれば良い（正負自動だけ null で特殊だが）。
     *
     * Example:
     * ```php
     * that(decimal(-3.14, 1, 0))->isSame(-3.1);    // 0 に近づく方向
     * that(decimal(-3.14, 1, null))->isSame(-3.2); // 0 から離れる方向
     * that(decimal(-3.14, 1, -INF))->isSame(-3.2); // 負の無限大の方向
     * that(decimal(-3.14, 1, +INF))->isSame(-3.1); // 正の無限大の方向
     *
     * that(decimal(3.14, 1, 0))->isSame(3.1);    // 0 に近づく方向
     * that(decimal(3.14, 1, null))->isSame(3.2); // 0 から離れる方向
     * that(decimal(3.14, 1, -INF))->isSame(3.1); // 負の無限大の方向
     * that(decimal(3.14, 1, +INF))->isSame(3.2); // 正の無限大の方向
     * ```
     *
     * @param int|float $value 丸める値
     * @param int $precision 有効桁数
     * @param mixed $mode 丸めモード（0 || null || ±INF || PHP_ROUND_HALF_XXX）
     * @return float 丸めた値
     */
    function decimal($value, $precision = 0, $mode = 0)
    {
        $precision = (int) $precision;

        if ($precision === 0) {
            if ($mode === 0) {
                return (float) (int) $value;
            }
            if ($mode === INF) {
                return ceil($value);
            }
            if ($mode === -INF) {
                return floor($value);
            }
            if ($mode === null) {
                return $value > 0 ? ceil($value) : floor($value);
            }
            if (in_array($mode, [PHP_ROUND_HALF_UP, PHP_ROUND_HALF_DOWN, PHP_ROUND_HALF_EVEN, PHP_ROUND_HALF_ODD], true)) {
                return round($value, $precision, $mode);
            }
            throw new \InvalidArgumentException('$precision must be either null, 0, INF, -INF');
        }

        if ($precision > 0 && 10 ** PHP_FLOAT_DIG <= abs($value)) {
            trigger_error('it exceeds the valid values', E_USER_WARNING);
        }

        $k = 10 ** $precision;
        return decimal($value * $k, 0, $mode) / $k;
    }
}
if (function_exists("ryunosuke\\Functions\\decimal") && !defined("ryunosuke\\Functions\\decimal")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\decimal", "ryunosuke\\Functions\\decimal");
}

if (!isset($excluded_functions["random_at"]) && (!function_exists("ryunosuke\\Functions\\random_at") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\random_at"))->isInternal()))) {
    /**
     * 引数をランダムで返す
     *
     * - 候補がない場合はエラーではなく例外を投げる
     *
     * Example:
     * ```php
     * // 1 ～ 6 のどれかを返す
     * that(random_at(1, 2, 3, 4, 5, 6))->isAny([1, 2, 3, 4, 5, 6]);
     * ```
     *
     * @param mixed ...$args 候補
     * @return mixed 引数のうちどれか
     */
    function random_at(...$args)
    {
        return $args[mt_rand(0, count($args) - 1)];
    }
}
if (function_exists("ryunosuke\\Functions\\random_at") && !defined("ryunosuke\\Functions\\random_at")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\random_at", "ryunosuke\\Functions\\random_at");
}

if (!isset($excluded_functions["probability"]) && (!function_exists("ryunosuke\\Functions\\probability") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\probability"))->isInternal()))) {
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
if (function_exists("ryunosuke\\Functions\\probability") && !defined("ryunosuke\\Functions\\probability")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\probability", "ryunosuke\\Functions\\probability");
}

if (!isset($excluded_functions["normal_rand"]) && (!function_exists("ryunosuke\\Functions\\normal_rand") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\normal_rand"))->isInternal()))) {
    /**
     * 正規乱数（正規分布に従う乱数）を返す
     *
     * ※ ボックス＝ミュラー法
     *
     * Example:
     * ```php
     * mt_srand(4); // テストがコケるので種固定
     *
     * // 平均 100, 標準偏差 10 の正規乱数を得る
     * that(normal_rand(100, 10))->isSame(101.16879645296162);
     * that(normal_rand(100, 10))->isSame(96.49615862542069);
     * that(normal_rand(100, 10))->isSame(87.74557282679618);
     * that(normal_rand(100, 10))->isSame(117.93697951557125);
     * that(normal_rand(100, 10))->isSame(99.1917453115627);
     * that(normal_rand(100, 10))->isSame(96.74688207698713);
     * ```
     *
     * @param float $average 平均
     * @param float $std_deviation 標準偏差
     * @return float 正規乱数
     */
    function normal_rand($average = 0.0, $std_deviation = 1.0)
    {
        static $z2, $rand_max, $generate = true;
        $rand_max ??= mt_getrandmax();
        $generate = !$generate;

        if ($generate) {
            return $z2 * $std_deviation + $average;
        }

        $u1 = mt_rand(1, $rand_max) / $rand_max;
        $u2 = mt_rand(0, $rand_max) / $rand_max;
        $v1 = sqrt(-2 * log($u1));
        $v2 = 2 * M_PI * $u2;
        $z1 = $v1 * cos($v2);
        $z2 = $v1 * sin($v2);

        return $z1 * $std_deviation + $average;
    }
}
if (function_exists("ryunosuke\\Functions\\normal_rand") && !defined("ryunosuke\\Functions\\normal_rand")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\normal_rand", "ryunosuke\\Functions\\normal_rand");
}

if (!isset($excluded_functions["calculate_formula"]) && (!function_exists("ryunosuke\\Functions\\calculate_formula") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\calculate_formula"))->isInternal()))) {
    /**
     * 数式を計算して結果を返す
     *
     * 内部的には eval で計算するが、文字列や関数呼び出しなどは受け付けないため原則としてセーフティ。
     * 許可されるのは定数・数値リテラルと演算子のみ。
     * 定数を許可しているのは PI(3.14) や HOUR(3600) などの利便性のため。
     * 定数値が非数値の場合、強制的に数値化して警告を促す。
     *
     * Example:
     * ```php
     * that(calculate_formula('1 + 2 - 3 * 4'))->isSame(-9);
     * that(calculate_formula('1 + (2 - 3) * 4'))->isSame(-3);
     * that(calculate_formula('PHP_INT_SIZE * 3'))->isSame(PHP_INT_SIZE * 3);
     * ```
     *
     * @param string $formula 計算式
     * @return int|float 計算結果
     */
    function calculate_formula($formula)
    {
        // TOKEN_PARSE を渡せばシンタックスチェックも行ってくれる
        $tokens = parse_php("<?php ($formula);", [
            'phptag' => false,
            'flags'  => TOKEN_PARSE,
        ]);
        array_shift($tokens);
        array_pop($tokens);

        $constants = [T_STRING, T_DOUBLE_COLON, T_NS_SEPARATOR];
        // @codeCoverageIgnoreStart
        if (version_compare(PHP_VERSION, '8.0.0') >= 0) {
            /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
            $constants = [T_STRING, T_DOUBLE_COLON, T_NS_SEPARATOR, T_NAME_QUALIFIED, T_NAME_FULLY_QUALIFIED, T_NAME_RELATIVE];
        }
        // @codeCoverageIgnoreEnd
        $operands = [T_LNUMBER, T_DNUMBER];
        $operators = ['(', ')', '+', '-', '*', '/', '%', '**'];

        $constant = '';
        $expression = '';
        foreach ($tokens as $token) {
            if (in_array($token[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true)) {
                continue;
            }
            if (in_array($token[0], $constants, true)) {
                $constant .= $token[1];
            }
            elseif (in_array($token[0], $operands, true) || in_array($token[1], $operators, true)) {
                if (strlen($constant)) {
                    $expression .= constant($constant) + 0;
                    $constant = '';
                }
                $expression .= $token[1];
            }
            else {
                throw new \ParseError(sprintf("syntax error, unexpected '%s' in  on line %d", $token[1], $token[2]));
            }
        }
        return evaluate("return $expression;");
    }
}
if (function_exists("ryunosuke\\Functions\\calculate_formula") && !defined("ryunosuke\\Functions\\calculate_formula")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\calculate_formula", "ryunosuke\\Functions\\calculate_formula");
}

if (!isset($excluded_functions["getipaddress"]) && (!function_exists("ryunosuke\\Functions\\getipaddress") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\getipaddress"))->isInternal()))) {
    /**
     * 接続元となる IP を返す
     *
     * IP を指定してそこへ接続する際の SourceIP を返す（省略すると最初のエントリを返す）。
     * 複数のネットワークにマッチした場合の結果は不定（最長が無難だろうがそもそも SourceIP がどうなるかが不定）。
     *
     * Example:
     * ```php
     * // 何らかの IP アドレスが返ってくる
     * that(getipaddress())->isValidIpv4();
     * // 自分への接続元は自分なので 127.0.0.1 を返す
     * that(getipaddress('127.0.0.9'))->isSame('127.0.0.1');
     * ```
     *
     * @param string|int|null $target 接続先
     * @return ?string IP アドレス
     */
    function getipaddress($target = null)
    {
        $net_get_interfaces = cache("net_get_interfaces", fn() => net_get_interfaces(), __FUNCTION__);

        // int, null 時は最初のエントリを返す（ループバックは除く）
        if ($target === null || is_int($target)) {
            $target ??= AF_INET;
            unset($net_get_interfaces['lo']);
            foreach ($net_get_interfaces as $interface) {
                foreach ($interface['unicast'] as $unicast) {
                    if ($unicast['family'] === $target) {
                        return $unicast['address'];
                    }
                }
            }
            return null;
        }

        if (filter_var($target, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
            $family = AF_INET;
        }
        elseif (filter_var($target, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
            $family = AF_INET6;
        }
        else {
            throw new \InvalidArgumentException("$target is invalid ip address");
        }

        $targetBytes = unpack('C*', inet_pton($target));

        foreach ($net_get_interfaces as $interface) {
            foreach ($interface['unicast'] as $unicast) {
                if ($unicast['family'] === $family) {
                    $addressBytes = unpack('C*', inet_pton($unicast['address']));
                    $netmaskBytes = unpack('C*', inet_pton($unicast['netmask']));
                    foreach ($netmaskBytes as $i => $netmaskByte) {
                        if (($addressBytes[$i] & $netmaskByte) !== ($targetBytes[$i] & $netmaskByte)) {
                            continue 2;
                        }
                    }
                    return $unicast['address'];
                }
            }
        }
        return null;
    }
}
if (function_exists("ryunosuke\\Functions\\getipaddress") && !defined("ryunosuke\\Functions\\getipaddress")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\getipaddress", "ryunosuke\\Functions\\getipaddress");
}

if (!isset($excluded_functions["incidr"]) && (!function_exists("ryunosuke\\Functions\\incidr") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\incidr"))->isInternal()))) {
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
     * that(incidr('192.168.1.1', '192.168.1.0/24'))->isTrue();
     * // 範囲外なので false
     * that(incidr('192.168.1.1', '192.168.2.0/24'))->isFalse();
     * // 1つでも範囲内なら true
     * that(incidr('192.168.1.1', ['192.168.1.0/24', '192.168.2.0/24']))->isTrue();
     * // 全部範囲外なら false
     * that(incidr('192.168.1.1', ['192.168.2.0/24', '192.168.3.0/24']))->isFalse();
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
            [$subnet, $length] = explode('/', $cidr, 2) + [1 => '32'];

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
if (function_exists("ryunosuke\\Functions\\incidr") && !defined("ryunosuke\\Functions\\incidr")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\incidr", "ryunosuke\\Functions\\incidr");
}

if (!isset($excluded_functions["ping"]) && (!function_exists("ryunosuke\\Functions\\ping") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\ping"))->isInternal()))) {
    /**
     * ネットワーク疎通を返す
     *
     * $port を指定すると TCP/UDP、省略（null）すると ICMP で繋ぐ。
     * が、 ICMP は root ユーザしか実行できないので ping コマンドにフォールバックする。
     * TCP/UDP の分岐はマニュアル通り tcp://, udp:// のようなスキームで行う（スキームがなければ tcp）。
     *
     * udp は結果が不安定なので信頼しないこと（タイムアウトも疎通 OK とみなされる。プロトコルの仕様上どうしようもない）。
     *
     * Example:
     * ```php
     * // 自身へ ICMP ping を打つ（正常終了なら float を返し、失敗なら false を返す）
     * that(ping('127.0.0.1'))->isFloat();
     * // 自身の tcp:1234 が開いているか（開いていれば float を返し、開いていなければ false を返す）
     * that(ping('tcp://127.0.0.1', 1234))->isFalse();
     * that(ping('127.0.0.1', 1234))->isFalse(); // tcp はスキームを省略できる
     * ```
     *
     * @param string $host ホスト名（プロトコルも指定できる）
     * @param int|null $port ポート番号。指定しないと ICMP になる
     * @param int $timeout タイムアウト秒
     * @param string $errstr エラー文字列が格納される
     * @return float|bool 成功したときは疎通時間。失敗したときは false
     */
    function ping($host, $port = null, $timeout = 1, &$errstr = '')
    {
        $errstr = '';

        $parts = parse_url($host);
        if (!isset($parts['scheme'])) {
            if (strlen($port)) {
                $parts['scheme'] = 'tcp';
            }
            else {
                $parts['scheme'] = 'icmp';
            }
        }
        $protocol = strtolower($parts['scheme']);
        $host = $parts['host'] ?? $parts['path'];

        // icmp で linux かつ非 root は SOCK_RAW が使えないので ping コマンドへフォールバック
        if ($protocol === 'icmp' && DIRECTORY_SEPARATOR === '/' && !is_readable('/root')) {
            // @codeCoverageIgnoreStart
            $stdout = null;
            process('ping', [
                '-c' => 1,
                '-W' => (int) $timeout,
                $host,
            ], null, $stdout, $errstr);
            // min/avg/max/mdev = 0.026/0.026/0.026/0.000
            if (preg_match('#min/avg/max/mdev.*?[0-9.]+/([0-9.]+)/[0-9.]+/[0-9.]+#', $stdout, $m)) {
                return $m[1] / 1000.0;
            }
            return false;
            // @codeCoverageIgnoreEnd
        }

        if ($protocol === 'icmp') {
            $port = 0;
            $socket = socket_create(AF_INET, SOCK_RAW, getprotobyname($protocol));
        }
        elseif ($protocol === 'tcp') {
            $socket = socket_create(AF_INET, SOCK_STREAM, getprotobyname($protocol));
        }
        elseif ($protocol === 'udp') {
            $socket = socket_create(AF_INET, SOCK_DGRAM, getprotobyname($protocol));
        }
        else {
            throw new \InvalidArgumentException("'$protocol' is not supported.");
        }

        $mtime = microtime(true);
        try {
            call_safely(function ($socket, $protocol, $host, $port, $timeout) {
                socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, ['sec' => $timeout, 'usec' => 0]);
                socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, ['sec' => $timeout, 'usec' => 0]);
                if (!socket_connect($socket, $host, $port)) {
                    throw new \RuntimeException(); // @codeCoverageIgnore
                }

                // icmp は ping メッセージを送信
                if ($protocol === 'icmp') {
                    $message = "\x08\x00\x7d\x4b\x00\x00\x00\x00PingHost";
                    socket_send($socket, $message, strlen($message), 0);
                    socket_read($socket, 255);
                }
                // tcp は接続自体ができれば OK
                if ($protocol === 'tcp') {
                    assert(true); // PhpStatementHasEmptyBodyInspection
                }
                // udp は何か送ってみてその挙動で判断（=> catch 節）
                if ($protocol === 'udp') {
                    $message = ""; // noop
                    socket_send($socket, $message, strlen($message), 0);
                    socket_read($socket, 255);
                }
            }, $socket, $protocol, $host, $port, $timeout);
            return microtime(true) - $mtime;
        }
        catch (\Throwable $t) {
            $errno = socket_last_error($socket);
            // windows では到達できても socket_read がエラーを返すので errno で判断
            // 接続済みの呼び出し先が一定の時間を過ぎても正しく応答しなかったため、接続できませんでした。
            // または接続済みのホストが応答しなかったため、確立された接続は失敗しました。
            if (DIRECTORY_SEPARATOR === '\\' && $errno === 10060 && $protocol === 'udp') {
                return microtime(true) - $mtime;
            }
            $errstr = socket_strerror($errno);
            return false;
        }
        finally {
            socket_close($socket);
        }
    }
}
if (function_exists("ryunosuke\\Functions\\ping") && !defined("ryunosuke\\Functions\\ping")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\ping", "ryunosuke\\Functions\\ping");
}

if (!isset($excluded_functions["http_requests"]) && (!function_exists("ryunosuke\\Functions\\http_requests") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\http_requests"))->isInternal()))) {
    /**
     * http リクエストを並列で投げる
     *
     * $urls で複数の curl を渡し、並列で実行して複数の結果をまとめて返す。
     * $urls の要素は単一の文字列か curl のオプションである必要がある。
     * リクエストの実体は http_request なので、そっちで使えるオプションは一部を除きすべて使える。
     *
     * 返り値は $urls のキーを保持したまま、レスポンスが返ってきた順に格納して配列で返す。
     * 構造は下記のサンプルを参照。
     *
     * $infos を渡すと返り値がボディだけになり、その他の情報はすべてこの変数に格納される。
     * この動作は互換性のためであり、将来的には指定の有無に関わらずボディだけを返すようになる（失敗したリクエストは null が格納される）。
     *
     * Example:
     * ```php
     * $responses = http_requests([
     *     // このように [キー => CURL オプション] 形式が正しい使い方
     *     'fuga'             => [
     *         CURLOPT_URL     => 'http://unknown-host',
     *         CURLOPT_TIMEOUT => 5,
     *     ],
     *     // ただし、このように [キー => URL] 形式でもいい（オプションはデフォルトが使用される）
     *     'hoge'             => 'http://127.0.0.1',
     *     // さらに、このような [URL => CURL オプション] 形式も許容される（あまり用途はないだろうが）
     *     'http://127.0.0.1' => [
     *         CURLOPT_TIMEOUT => 5,
     *     ],
     * ], [
     *     // 第2引数で各リクエストの共通オプションを指定できる（個別指定優先）
     *     // @see https://www.php.net/manual/ja/function.curl-setopt.php
     * ], [
     *     // 第3引数でマルチリクエストのオプションを指定できる
     *     // @see https://www.php.net/manual/ja/function.curl-multi-setopt.php
     * ],
     *     // 第4引数を与えると動作が変わる（将来的にこの動作がデフォルトになる）
     *     $infos
     * );
     * # 第4引数を指定した場合の返り値
     * [
     *     // キーが維持されるので hoge キー
     *     'hoge'             => 'response body',
     *     // curl のエラーが出た場合は null になる（詳細なエラー情報は $infos に格納される）
     *     'fuga'             => null,
     *     'http://127.0.0.1' => 'response body',
     * ];
     * # 第4引数を指定しなかった場合の返り値
     * [
     *     // キーが維持されるので hoge キー
     *     'hoge'             => [
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
     *     'fuga'             => 6,
     * ];
     * ```
     *
     * @param array $urls 実行する curl オプション
     * @param array $single_options 全 $urls に適用されるデフォルトオプション
     * @param array $multi_options 並列リクエストとしてのオプション
     * @param array $infos curl 情報やヘッダなどが格納される受け変数
     * @return array レスポンス配列。取得した順番でキーを保持しつつ追加される
     */
    function http_requests($urls, $single_options = [], $multi_options = [], &$infos = [])
    {
        $multi_options += [
            'throw' => false, // curl レイヤーでエラーが出たら例外を投げるか（http レイヤーではない）
        ];

        // 固定オプション（必ずこの値が使用される）
        $default = [
            'raw'                  => true,
            'throw'                => false,
            CURLOPT_FAILONERROR    => false,
            CURLOPT_RETURNTRANSFER => true, // 戻り値として返す
            CURLOPT_HEADER         => true, // ヘッダを含める
        ];

        $stringify_curl = function ($curl) {
            // スクリプトの実行中 (ウェブのリクエストや CLI プロセスの処理中) は、指定したリソースに対してこの文字列が一意に割り当てられることが保証されます
            if (is_resource($curl)) {
                return (string) $curl;
            }
            // @codeCoverageIgnoreStart
            if (is_object($curl)) {
                return spl_object_id($curl);
            }
            return null;
            // @codeCoverageIgnoreEnd
        };

        $responses = [];
        $resultmap = [];
        $infos = [];

        // for compatible
        $compatible_mode = func_num_args() !== 4;
        $set_response = function ($key, $body, $header, $info) use ($compatible_mode, &$responses, &$infos) {
            if ($compatible_mode) {
                $responses[$key] = [$body, $header, $info];
            }
            else {
                $responses[$key] = $body;
                $infos[$key] = [$header, $info];
            }
        };

        $mh = curl_multi_init();
        foreach (array_filter($multi_options, 'is_int', ARRAY_FILTER_USE_KEY) as $name => $value) {
            curl_multi_setopt($mh, $name, $value);
        }

        try {
            foreach ($urls as $key => $opt) {
                // 文字列は URL 指定とみなす
                if (is_string($opt)) {
                    $opt = [CURLOPT_URL => $opt];
                }
                // さらに URL 指定がないなら key を URL とみなす
                if (!isset($opt[CURLOPT_URL]) && !isset($opt['url'])) {
                    $opt[CURLOPT_URL] = $key;
                }

                $rheader = null;
                $info = null;
                $res = http_request($default + $opt + $single_options, $rheader, $info);
                if (is_array($res) && isset($res[0]) && $handle_id = $stringify_curl($res[0])) {
                    curl_multi_add_handle($mh, $res[0]);
                    $resultmap[$handle_id] = [$key, $res[1], $res[2], microtime(true), 0];
                }
                else {
                    $set_response($key, $res, $rheader, $info);
                }
            }

            do {
                do {
                    $mrc = curl_multi_exec($mh, $active);
                } while ($mrc === CURLM_CALL_MULTI_PERFORM);

                // see http://php.net/manual/ja/function.curl-multi-select.php#115381
                if (curl_multi_select($mh) === -1) {
                    usleep(1); // @codeCoverageIgnore
                }

                do {
                    if (($minfo = curl_multi_info_read($mh, $remains)) === false) {
                        continue;
                    }

                    $handle = $minfo['handle'];
                    $handle_id = $stringify_curl($handle);
                    [$key, $responser, $retry, $now, $retry_count] = $resultmap[$handle_id];

                    $response = curl_multi_getcontent($handle);
                    $info = curl_getinfo($handle);
                    $info['errno'] = $minfo['result'];
                    $info['retry'] = $retry_count;

                    if ($time = $retry($info, $response)) {
                        // 同じリソースを使い回しても大丈夫っぽい？（大丈夫なわけないと思うが…動いてはいる）
                        curl_multi_remove_handle($mh, $handle);
                        curl_multi_add_handle($mh, $handle);

                        // 他のリクエストの待機で既に指定秒数を超えている場合は待たない（分岐は本来不要だが現在以下だと警告が出るため）
                        if (microtime(true) < ($next = $now + $time)) {
                            time_sleep_until($next);
                        }

                        $resultmap[$handle_id][3] = microtime(true);
                        $resultmap[$handle_id][4] = $retry_count + 1;

                        $active++;
                        continue;
                    }

                    if ($info['errno'] !== CURLE_OK) {
                        if ($multi_options['throw']) {
                            throw new \UnexpectedValueException("'{$info['url']}' curl_errno({$info['errno']}).");
                        }
                        if ($compatible_mode) {
                            $responses[$key] = $info['errno'];
                        }
                        else {
                            $set_response($key, null, [], $info);
                        }
                    }
                    else {
                        $set_response($key, ...$responser($response, $info));
                    }

                    curl_multi_remove_handle($mh, $handle);
                    curl_close($handle);
                } while ($remains);
            } while ($active && $mrc === CURLM_OK);
        }
        finally {
            curl_multi_close($mh);
        }

        return $responses;
    }
}
if (function_exists("ryunosuke\\Functions\\http_requests") && !defined("ryunosuke\\Functions\\http_requests")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\http_requests", "ryunosuke\\Functions\\http_requests");
}

if (!isset($excluded_functions["http_request"]) && (!function_exists("ryunosuke\\Functions\\http_request") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\http_request"))->isInternal()))) {
    /**
     * curl のラッパー関数
     *
     * curl は高機能だけど、低レベルで設定が細かすぎる上に似たようなものが大量にあるので素で書くのが割とつらい。
     * のでデフォルトをスタンダードな設定に寄せつつ、多少便利になるようにラップしている。
     * まぁ現在では guzzle みたいなクライアントも整ってるし、使い捨てスクリプトでサクッとリクエストを投げたい時用。
     *
     * 生 curl との差異は下記。
     *
     * - `CURLOPT_HTTPHEADER` は連想配列指定が可能
     * - `CURLOPT_POSTFIELDS` は連想配列・多次元配列指定が可能
     * - 単一ファイル指定は単一アップロードになる
     *
     * さらに独自のオプションとして下記がある。
     *
     * - `raw` (bool): curl インスタンスと変換クロージャを返すだけになる
     *     - ただし、ほぼデバッグや内部用なので指定することはほぼ無いはず
     * - `throw` (bool): ステータスコードが 400 以上のときに例外を投げる
     *     - `CURLOPT_FAILONERROR` は原則使わないほうがいいと思う
     * - `retry` (float[]|callable): エラーが出た場合にリトライする
     *     - 配列で指定した回数・秒数のリトライを行う（[1, 2, 3] で、1秒後、2秒後、3秒後になる）
     *     - callable を指定するとその callable が false を返すまでリトライする（引数として curl_info が渡ってきて待機秒数を返す）
     * - `atfile` (bool): キーに @ があるフィールドをファイルアップロードとみなす
     *     - 悪しき `CURLOPT_SAFE_UPLOAD` の代替。ただし値ではなくキーで判別する
     *     - 値が配列のフィールドのキーに @ をつけると連番要素のみアップロードになる
     * - `cachedir` (string): GET のときにクライアントキャッシュや 304 キャッシュが効くようになる
     *     - Cache-Control の private, public は見ないので一応注意
     * - `parser` (array): Content-Type に基づいて body をパースする
     *     - 今のところ application/json のみ
     *
     * また、頻出するオプションは下記の定数のエイリアスがあり、単純に読み替えられる。
     *
     * - `url`: `CURLOPT_URL`
     * - `method`: `CURLOPT_CUSTOMREQUEST`
     * - `cookie`: `CURLOPT_COOKIE`
     * - `header`: `CURLOPT_HTTPHEADER`
     * - `body`: `CURLOPT_POSTFIELDS`
     * - `cookie_file`: `CURLOPT_COOKIEJAR`, `CURLOPT_COOKIEFILE`
     *
     * Example:
     * ```php
     * $response = http_request([
     *     'url'    => 'http://httpbin.org/post?name=value',
     *     'method' => 'POST',
     *     'body'   => ['k1' => 'v1', 'k2' => 'v2'],
     * ]);
     * that($response['args'])->is([
     *     'name' => 'value',
     * ]);
     * that($response['form'])->is([
     *     'k1' => 'v1',
     *     'k2' => 'v2',
     * ]);
     * ```
     *
     * @param array $options curl_setopt_array に渡される
     * @param array $response_header レスポンスヘッダが連想配列で格納される
     * @param array $info curl_getinfo が格納される
     * @return mixed レスポンスボディ
     */
    function http_request($options = [], &$response_header = [], &$info = [])
    {
        $options += [
            // curl options
            CURLOPT_CUSTOMREQUEST  => 'GET', // リクエストメソッド
            CURLINFO_HEADER_OUT    => true,  // リクエストヘッダを含める
            CURLOPT_HTTPHEADER     => [],    // リクエストヘッダ
            CURLOPT_COOKIE         => null,  // リクエストクッキー
            CURLOPT_POSTFIELDS     => null,  // リクエストボディ
            CURLOPT_NOBODY         => false, // HEAD 用
            CURLOPT_ENCODING       => "",    // Accept-Encoding 兼自動展開
            CURLOPT_FOLLOWLOCATION => true,  // リダイレクトをたどる
            CURLOPT_MAXREDIRS      => 16,    // リダイレクトをたどる回数
            CURLOPT_RETURNTRANSFER => true,  // 戻り値として返す
            CURLOPT_HEADER         => true,  // レスポンスヘッダを含める
            CURLOPT_CONNECTTIMEOUT => 60,    // timeout on connect
            CURLOPT_TIMEOUT        => 60,    // timeout on response

            // alias option
            'url'                  => null,
            'method'               => null,
            'cookie'               => null,
            'header'               => null,
            'body'                 => null,
            'cookie_file'          => null,

            // custom options
            'raw'                  => false,
            'throw'                => true,
            'retry'                => [],
            'atfile'               => true,
            'cachedir'             => null,
            'parser'               => [
                'application/json' => [
                    'request'  => json_export,
                    'response' => json_import,
                ],
            ],
        ];

        // 利便性用の定数エイリアス
        $options[CURLOPT_URL] = $options['url'] ?? $options[CURLOPT_URL];
        $options[CURLOPT_CUSTOMREQUEST] = $options['method'] ?? $options[CURLOPT_CUSTOMREQUEST];
        $options[CURLOPT_COOKIE] = $options['cookie'] ?? $options[CURLOPT_COOKIE];
        $options[CURLOPT_HTTPHEADER] = $options['header'] ?? $options[CURLOPT_HTTPHEADER];
        $options[CURLOPT_POSTFIELDS] = $options['body'] ?? $options[CURLOPT_POSTFIELDS];
        if (isset($options['cookie_file'])) {
            $options[CURLOPT_COOKIEJAR] = $options['cookie_file'];
            $options[CURLOPT_COOKIEFILE] = $options['cookie_file'];
        }

        // ヘッダは後段の判定に頻出するので正規化して取得しておく
        $request_header = array_kvmap($options[CURLOPT_HTTPHEADER], function ($k, $v) {
            if (is_int($k)) {
                [$k, $v] = explode(':', $v, 2);
            }
            return [strtolower(trim($k)) => trim($v)];
        });

        // request body 変換
        if ($convert = ($options['parser'][$request_header['content-type'] ?? null]['request'] ?? null)) {
            $options[CURLOPT_POSTFIELDS] = $convert($options[CURLOPT_POSTFIELDS]);
        }

        // response クロージャ
        $response_parse = function ($response, $info) use ($options) {
            [$head, $body] = str_chunk($response, $info['header_size']);

            $head = str_array($head, ':', true);
            $info['no_request'] = false;
            $info['response_size'] = strlen($response);
            $info['content_type'] = $info['content_type'] ?? null;
            $info['cache_control'] = $head['Cache-Control'] ?? null;
            $info['last_modified'] = $head['Last-Modified'] ?? null;
            $info['etag'] = $head['ETag'] ?? null;
            if (isset($info['request_header']) && is_string($info['request_header'])) {
                $info['request_header'] = str_array($info['request_header'], ':', true);
            }

            if (!($options[CURLOPT_NOBODY] ?? false)) {
                if ($convert = ($options['parser'][$info['content_type']]['response'] ?? null)) {
                    $body = $convert($body);
                }
            }

            return [$info, $head, $body];
        };

        // キャッシュのキー
        $filekey = null;
        if ($options[CURLOPT_CUSTOMREQUEST] === 'GET' && isset($options['cachedir'])) {
            [$url, $query] = explode('?', $options[CURLOPT_URL]) + [1 => ''];
            $filekey = $options['cachedir'] . DIRECTORY_SEPARATOR . urlencode($url) . sha1($query);
        }

        // http cache
        if (isset($filekey)) {
            if (file_exists($filekey)) {
                $fp = fopen($filekey, 'r');
                try {
                    $info = json_decode(fgets($fp), true);
                    if (stripos($info['cache_control'], 'no-cache') === false && preg_match('#max-age=(\\d+)#i', $info['cache_control'], $matches)) {
                        clearstatcache(true, $filekey);
                        if (time() - filemtime($filekey) < $matches[1]) {
                            $info['no_request'] = true;
                            $response = stream_get_contents($fp);
                            [, $response_header, $body] = $response_parse($response, $info);
                            return $body;
                        }
                    }

                    if ($info['last_modified']) {
                        $options[CURLOPT_HTTPHEADER]['if-modified-since'] = $info['last_modified'];
                    }
                    if ($info['etag']) {
                        $options[CURLOPT_HTTPHEADER]['if-none-match'] = $info['etag'];
                    }
                }
                finally {
                    fclose($fp);
                }
            }
        }

        // http cache クロージャ
        $cache = function ($response, $info) use ($filekey, $response_parse) {
            if (isset($filekey)) {
                if ($info['http_code'] === 200 && stripos($info['cache_control'], 'no-store') === false) {
                    file_set_contents($filekey, json_encode($info, JSON_UNESCAPED_SLASHES) . "\n" . $response);
                }
                if ($info['http_code'] === 304 && file_exists($filekey)) {
                    touch($filekey);
                    [$info2, $response] = explode("\n", file_get_contents($filekey), 2);
                    return $response_parse($response, json_decode($info2, true))[2];
                }
            }
        };

        // CURLOPT_POSTFIELDS は配列を渡せば万事 OK ・・・と思いきや多次元には対応していないのでフラットにする
        if (is_array($options[CURLOPT_POSTFIELDS])) {
            // の、前に @ 付きキーを CURLFile に変換
            if ($options['atfile']) {
                $options[CURLOPT_POSTFIELDS] = array_kvmap($options[CURLOPT_POSTFIELDS], function ($k, $v, $callback) {
                    $atfile = ($k[0] ?? null) === '@';
                    if ($atfile) {
                        $k = substr($k, 1);
                        if (is_array($v)) {
                            $v = array_kvmap($v, fn($k, $v) => [is_int($k) ? "@$k" : $k => $v]);
                        }
                        else {
                            $v = new \CURLFile($v);
                        }
                    }
                    if (is_array($v)) {
                        $v = array_kvmap($v, $callback);
                    }
                    return [$k => $v];
                });
            }
            // CURLFile が含まれているかもしれないので http_build_query は使えない
            $options[CURLOPT_POSTFIELDS] = array_flatten($options[CURLOPT_POSTFIELDS], fn($keys) => array_shift($keys) . ($keys ? '[' . implode('][', $keys) . ']' : ''));
        }

        // 単一ファイルは単一アップロードとする
        if ($options[CURLOPT_POSTFIELDS] instanceof \CURLFile) {
            $file = $options[CURLOPT_POSTFIELDS];
            unset($options[CURLOPT_POSTFIELDS]);
            if (!isset($request_header['content-type'])) {
                $options[CURLOPT_HTTPHEADER]['content-type'] = $file->getMimeType() ?: mime_content_type($file->getFilename());
            }
            $options[CURLOPT_INFILE] = fopen($file->getFilename(), 'r');
            $options[CURLOPT_INFILESIZE] = filesize($file->getFilename());
            $options[CURLOPT_PUT] = true;
        }

        // CURLOPT_HTTPHEADER は素の配列しか受け入れてくれないので連想配列を k: v 形式に変換
        $options[CURLOPT_HTTPHEADER] = array_sprintf($options[CURLOPT_HTTPHEADER], fn($v, $k) => is_int($k) ? $v : "$k: $v");

        // 同上： CURLOPT_COOKIE
        if ($options[CURLOPT_COOKIE] && is_array($options[CURLOPT_COOKIE])) {
            $options[CURLOPT_COOKIE] = array_sprintf($options[CURLOPT_COOKIE], fn($v, $k) => is_int($k) ? $v : rawurlencode($k) . "=" . rawurlencode($v), '; ');
        }

        assert(is_callable($options['retry']) || is_array($options['retry']));
        $retry = is_callable($options['retry']) ? $options['retry'] : function ($info) use ($options) {
            // リトライを費やしたなら打ち切り
            $time = $options['retry'][$info['retry']] ?? null;
            if ($time === null) {
                return false;
            }
            // curl レイヤでは一部の curl_errno のみ
            if (in_array($info['errno'], [CURLE_OPERATION_TIMEOUTED, CURLE_GOT_NOTHING, CURLE_SEND_ERROR, CURLE_RECV_ERROR])) {
                return $time;
            }
            // 結果が返ってきてるなら打ち切り…としたいところだが、一部のコードはリトライ対象とする。ちょっと思うところがあるのでメモを下記に記す
            // 429 は微妙。いわゆるレート制限が多いだろうので、リトライしてもどうせコケる
            // 502 はもっと微妙。でも「たまたま具合の悪い ap サーバに到達してしまった」ならリトライの価値はある
            // 503 は本来あるべきリトライだろうけど、過負荷でリトライしても…という思いもある
            if ($info['errno'] === CURLE_OK && in_array($info['http_code'], [429, 502, 503])) {
                return $time;
            }

            return false;
        };

        $responser = function ($response, $info) use ($response_parse, $cache) {
            [$info, $head, $body] = $response_parse($response, $info);
            return [$cache($response, $info) ?? $body, $head, $info];
        };

        $ch = curl_init();
        curl_setopt_array($ch, array_filter($options, 'is_int', ARRAY_FILTER_USE_KEY));
        if ($options['raw']) {
            return [$ch, $responser, $retry];
        }

        try {
            $retry_count = 0;
            do {
                $response = curl_exec($ch);
                $info = curl_getinfo($ch);
                $info['retry'] = $retry_count++;
                $info['errno'] = curl_errno($ch);
                $time = $retry($info, $response);
                usleep($time * 1000 * 1000);
            } while ($time);

            if ($response === false) {
                throw new \RuntimeException(curl_error($ch), curl_errno($ch));
            }
        }
        finally {
            curl_close($ch);
        }

        if ($options['throw'] && $info['http_code'] >= 400) {
            throw new \UnexpectedValueException("status is {$info['http_code']}.");
        }

        [$body, $response_header, $info] = $responser($response, $info);
        return $body;
    }
}
if (function_exists("ryunosuke\\Functions\\http_request") && !defined("ryunosuke\\Functions\\http_request")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\http_request", "ryunosuke\\Functions\\http_request");
}

if (!isset($excluded_functions["http_head"]) && (!function_exists("ryunosuke\\Functions\\http_head") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\http_head"))->isInternal()))) {
    /**
     * {@link http_request() http_request} の HEAD 特化版
     *
     * @inheritdoc http_request()
     *
     * @param string $url 対象 URL
     * @param mixed $data パラメータ
     * @return array レスポンスヘッダ
     */
    function http_head($url, $data = [], $options = [], &$response_header = [], &$info = [])
    {
        $default = [
            'method'       => 'HEAD',
            CURLOPT_NOBODY => true,
        ];
        http_get($url, $data, $options + $default, $response_header, $info);
        return $response_header;
    }
}
if (function_exists("ryunosuke\\Functions\\http_head") && !defined("ryunosuke\\Functions\\http_head")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\http_head", "ryunosuke\\Functions\\http_head");
}

if (!isset($excluded_functions["http_get"]) && (!function_exists("ryunosuke\\Functions\\http_get") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\http_get"))->isInternal()))) {
    /**
     * {@link http_request() http_request} の GET 特化版
     *
     * @inheritdoc http_request()
     *
     * @param string $url 対象 URL
     * @param mixed $data パラメータ
     * @return mixed レスポンスボディ
     */
    function http_get($url, $data = [], $options = [], &$response_header = [], &$info = [])
    {
        if (!is_empty($data, true)) {
            $url .= (strrpos($url, '?') === false ? '?' : '&') . (is_array($data) || is_object($data) ? http_build_query($data) : $data);
        }
        $default = [
            'url'    => $url,
            'method' => 'GET',
        ];
        return http_request($options + $default, $response_header, $info);
    }
}
if (function_exists("ryunosuke\\Functions\\http_get") && !defined("ryunosuke\\Functions\\http_get")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\http_get", "ryunosuke\\Functions\\http_get");
}

if (!isset($excluded_functions["http_post"]) && (!function_exists("ryunosuke\\Functions\\http_post") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\http_post"))->isInternal()))) {
    /**
     * {@link http_request() http_request} の POST 特化版
     *
     * @inheritdoc http_request()
     *
     * @param string $url 対象 URL
     * @param mixed $data パラメータ
     * @return mixed レスポンスボディ
     */
    function http_post($url, $data = [], $options = [], &$response_header = [], &$info = [])
    {
        $default = [
            'url'    => $url,
            'method' => 'POST',
            'body'   => $data,
        ];
        return http_request($options + $default, $response_header, $info);
    }
}
if (function_exists("ryunosuke\\Functions\\http_post") && !defined("ryunosuke\\Functions\\http_post")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\http_post", "ryunosuke\\Functions\\http_post");
}

if (!isset($excluded_functions["http_put"]) && (!function_exists("ryunosuke\\Functions\\http_put") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\http_put"))->isInternal()))) {
    /**
     * {@link http_request() http_request} の PUT 特化版
     *
     * @inheritdoc http_request()
     *
     * @param string $url 対象 URL
     * @param mixed $data パラメータ
     * @return mixed レスポンスボディ
     */
    function http_put($url, $data = [], $options = [], &$response_header = [], &$info = [])
    {
        $default = [
            'url'    => $url,
            'method' => 'PUT',
            'body'   => $data,
        ];
        return http_request($options + $default, $response_header, $info);
    }
}
if (function_exists("ryunosuke\\Functions\\http_put") && !defined("ryunosuke\\Functions\\http_put")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\http_put", "ryunosuke\\Functions\\http_put");
}

if (!isset($excluded_functions["http_patch"]) && (!function_exists("ryunosuke\\Functions\\http_patch") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\http_patch"))->isInternal()))) {
    /**
     * {@link http_request() http_request} の PATCH 特化版
     *
     * @inheritdoc http_request()
     *
     * @param string $url 対象 URL
     * @param mixed $data パラメータ
     * @return mixed レスポンスボディ
     */
    function http_patch($url, $data = [], $options = [], &$response_header = [], &$info = [])
    {
        $default = [
            'url'    => $url,
            'method' => 'PATCH',
            'body'   => $data,
        ];
        return http_request($options + $default, $response_header, $info);
    }
}
if (function_exists("ryunosuke\\Functions\\http_patch") && !defined("ryunosuke\\Functions\\http_patch")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\http_patch", "ryunosuke\\Functions\\http_patch");
}

if (!isset($excluded_functions["http_delete"]) && (!function_exists("ryunosuke\\Functions\\http_delete") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\http_delete"))->isInternal()))) {
    /**
     * {@link http_request() http_request} の DELETE 特化版
     *
     * @inheritdoc http_request()
     *
     * @param string $url 対象 URL
     * @param mixed $data パラメータ
     * @return mixed レスポンスボディ
     */
    function http_delete($url, $data = [], $options = [], &$response_header = [], &$info = [])
    {
        $default = [
            'url'    => $url,
            'method' => 'DELETE',
            'body'   => $data,
        ];
        return http_request($options + $default, $response_header, $info);
    }
}
if (function_exists("ryunosuke\\Functions\\http_delete") && !defined("ryunosuke\\Functions\\http_delete")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\http_delete", "ryunosuke\\Functions\\http_delete");
}

if (!isset($excluded_functions["sql_quote"]) && (!function_exists("ryunosuke\\Functions\\sql_quote") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\sql_quote"))->isInternal()))) {
    /**
     * ものすごく雑に値をクオートする
     *
     * 非常に荒くアドホックに実装しているのでこの関数で得られた値で**実際に実行してはならない**。
     * あくまでログ出力やデバッグ用途で視認性を高める目的である。
     *
     * - null は NULL になる
     * - 数字はそのまま数字になる
     * - bool は 0 or 1 になる
     * - それ以外は addcslashes される
     *
     * Example:
     * ```php
     * that(sql_quote(null))->isSame('NULL');
     * that(sql_quote(123))->isSame(123);
     * that(sql_quote(true))->isSame(1);
     * that(sql_quote("hoge"))->isSame("'hoge'");
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
        return "'" . addcslashes((string) $value, "\0\e\f\n\r\t\v'\\") . "'";
    }
}
if (function_exists("ryunosuke\\Functions\\sql_quote") && !defined("ryunosuke\\Functions\\sql_quote")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\sql_quote", "ryunosuke\\Functions\\sql_quote");
}

if (!isset($excluded_functions["sql_bind"]) && (!function_exists("ryunosuke\\Functions\\sql_bind") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\sql_bind"))->isInternal()))) {
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
     * that(sql_bind('select ?', 1))->isSame("select 1");
     * that(sql_bind('select :hoge', ['hoge' => 'hoge']))->isSame("select 'hoge'");
     * that(sql_bind('select ?, :hoge', [1, 'hoge' => 'hoge']))->isSame("select 1, 'hoge'");
     * ```
     *
     * @param string $sql 値を埋め込む SQL
     * @param array|mixed $values 埋め込む値
     * @return mixed 値が埋め込まれた SQL
     */
    function sql_bind($sql, $values)
    {
        $embed = [];
        foreach (arrayval($values, false) as $k => $v) {
            if (is_int($k)) {
                $embed['?'][] = sql_quote($v);
            }
            else {
                $embed[":$k"] = sql_quote($v);
            }
        }

        return str_embed($sql, $embed, [
            "'"   => "'",
            '"'   => '"',
            '-- ' => "\n",
            '/*'  => "*/",
        ]);
    }
}
if (function_exists("ryunosuke\\Functions\\sql_bind") && !defined("ryunosuke\\Functions\\sql_bind")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\sql_bind", "ryunosuke\\Functions\\sql_bind");
}

if (!isset($excluded_functions["sql_format"]) && (!function_exists("ryunosuke\\Functions\\sql_format") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\sql_format"))->isInternal()))) {
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
        $keywords ??= array_flip(KEYWORDS);

        $options += [
            // インデント文字
            'indent'    => "  ",
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
            if ($options['case'] && isset($keywords[strtoupper($token)])) {
                $token = $options['case']($token);
            }
            if ($options['highlight']) {
                $token = $options['highlight']($token, $ttype);
            }
            return $token;
        };

        // 構文解析も先読みもない素朴な実装なので、特定文字列をあとから置換するための目印文字列
        $MARK = unique_string($sql, 8);
        $MARK_R = "{$MARK}_R:}";   // \r マーク
        $MARK_N = "{$MARK}_N:}";   // \n マーク
        $MARK_BR = "{$MARK}_BR:}"; // 改行マーク
        $MARK_CS = "{$MARK}_CS:}"; // コメント開始マーク
        $MARK_CE = "{$MARK}_CE:}"; // コメント終了マーク
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
            elseif ($comment && in_array($token[0], [T_WHITESPACE, T_COMMENT], true) && strpos($token[1], "\n") !== false) {
                $tokens[] = [T_COMMENT, $comment . $token[1]];
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

        $interpret = function (&$index = -1) use (&$interpret, $MARK_R, $MARK_N, $MARK_BR, $MARK_CS, $MARK_CE, $MARK_NT, $MARK_SP, $MARK_PT, $tokens, $options, $seek) {
            $index++;
            $beginning = true; // クエリの冒頭か
            $context = '';     // SELECT, INSERT などの大分類
            $subcontext = '';  // SET, VALUES などのサブ分類
            $modifier = '';    // RIGHT などのキーワード修飾語
            $firstcol = null;  // SELECT における最初の列か

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
                $beginning = false;

                switch ($uppertoken) {
                    default:
                        _DEFAULT:
                        $prev = $seek($index, -1)[1];
                        $next = $seek($index, +1)[1];

                        // "tablename. columnname" になってしまう
                        // "@ var" になってしまう
                        // ": holder" になってしまう
                        if ($prev !== '.' && $prev !== '@' && $prev !== ':' && $prev !== ';') {
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
                    case "@":
                    case ":":
                        $result[] = $MARK_SP . $virttoken;
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
                        [$index, $name, $comments] = $seek($index, +1);
                        $result[] = $MARK_SP . $virttoken . $MARK_SP . ($MARK_SP . implode('', $comments) . $MARK_CE) . $name . $MARK_SP;
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
                        $result[] = $MARK_SP . $virttoken . array_pop($result);
                        break;
                    case "SELECT":
                        if ($context === 'INSERT') {
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
                        if ($seek($index, +1)[1] === '(') {
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
                        $name = $seek($index, +1)[1];
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
                        $result[] = $virttoken;
                        if ($subcontext !== 'REFERENCES') {
                            $result[] = $MARK_BR;
                            $context = $uppertoken;
                        }
                        break;
                    /** @noinspection PhpMissingBreakStatementInspection */
                    case "WHEN":
                        $subcontext = $uppertoken;
                    case "ELSE":
                        $result[] = $MARK_BR . $MARK_NT . $virttoken . $MARK_SP;
                        break;
                    case "THEN":
                        $subcontext = '';
                        $result[] = $MARK_SP . $virttoken;
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

                        // コメントを含まない指定ネストレベル以下なら改行とインデントを吹き飛ばす
                        if (strpos($parts, $MARK_CE) === false && substr_count($parts, $MARK_PT) < $options['nestlevel']) {
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
                            $lastnt = $subcontext === 'WITH' ? '' : $MARK_NT;
                            $brnt = $MARK_BR . $MARK_NT;
                            if ($subcontext !== 'WITH' && strtoupper($seek($current, +1)[1]) === 'SELECT') {
                                $brnt .= $MARK_NT;
                            }
                            $parts = preg_replace("#($MARK_BR)+#u", $brnt, $parts) . $MARK_BR . $lastnt;
                            $parts = preg_replace("#$MARK_CS#u", "", $parts);
                        }

                        // IN や数式はネストとみなさない
                        $prev = $seek($current, -1)[1];
                        $suffix = $MARK_PT;
                        if (strtoupper($prev) === 'IN' || !preg_match('#^[a-z0-9_]+$#i', $prev)) {
                            $suffix = '';
                        }
                        if ($subcontext === 'WITH') {
                            $subcontext = '';
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
                "(?<R>$MARK_R)",
                "(?<N>$MARK_N)",
            ]) . "#u", [
            'indent' => fn($str) => "\n" . str_repeat($options['indent'], (substr_count($str, $MARK_NT) + substr_count($str, $MARK_SP))),
            'cs1'    => "\n" . $options['indent'],
            'cs2'    => "",
            'br'     => "\n",
            'sp'     => ' ',
            'ce'     => "",
            'nt'     => "",
            'pt'     => "",
            'R'      => "\r",
            'N'      => "\n",
        ], $result);

        return trim($result);
    }
}
if (function_exists("ryunosuke\\Functions\\sql_format") && !defined("ryunosuke\\Functions\\sql_format")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\sql_format", "ryunosuke\\Functions\\sql_format");
}

if (!isset($excluded_functions["strcat"]) && (!function_exists("ryunosuke\\Functions\\strcat") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\strcat"))->isInternal()))) {
    /**
     * 文字列結合の関数版
     *
     * Example:
     * ```php
     * that(strcat('a', 'b', 'c'))->isSame('abc');
     * ```
     *
     * @param mixed ...$variadic 結合する文字列（可変引数）
     * @return string 結合した文字列
     */
    function strcat(...$variadic)
    {
        return implode('', $variadic);
    }
}
if (function_exists("ryunosuke\\Functions\\strcat") && !defined("ryunosuke\\Functions\\strcat")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\strcat", "ryunosuke\\Functions\\strcat");
}

if (!isset($excluded_functions["concat"]) && (!function_exists("ryunosuke\\Functions\\concat") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\concat"))->isInternal()))) {
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
     * that(concat('prefix-', 'middle', '-suffix'))->isSame('prefix-middle-suffix');
     * that(concat('prefix-', '', '-suffix'))->isSame('');
     * ```
     *
     * @param mixed ...$variadic 結合する文字列（可変引数）
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
if (function_exists("ryunosuke\\Functions\\concat") && !defined("ryunosuke\\Functions\\concat")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\concat", "ryunosuke\\Functions\\concat");
}

if (!isset($excluded_functions["split_noempty"]) && (!function_exists("ryunosuke\\Functions\\split_noempty") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\split_noempty"))->isInternal()))) {
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
     * that(split_noempty(',', 'a, b, c'))->isSame(['a', 'b', 'c']);
     * that(split_noempty(',', 'a, , , b, c'))->isSame(['a', 'b', 'c']);
     * that(split_noempty(',', 'a, , , b, c', false))->isSame(['a', ' ', ' ', ' b', ' c']);
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
if (function_exists("ryunosuke\\Functions\\split_noempty") && !defined("ryunosuke\\Functions\\split_noempty")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\split_noempty", "ryunosuke\\Functions\\split_noempty");
}

if (!isset($excluded_functions["multiexplode"]) && (!function_exists("ryunosuke\\Functions\\multiexplode") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\multiexplode"))->isInternal()))) {
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
     * that(multiexplode([',', ' ', '|'], 'a,b c|d'))->isSame(['a', 'b', 'c', 'd']);
     * // 負数を与えると前詰め
     * that(multiexplode(',', 'a,b,c,d', -2))->isSame(['a,b,c', 'd']);
     * // もちろん上記2つは共存できる
     * that(multiexplode([',', ' ', '|'], 'a,b c|d', -2))->isSame(['a,b c', 'd']);
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
        $delimiter = array_map(fn($v) => preg_quote($v, '#'), arrayize($delimiter));
        return preg_split('#' . implode('|', $delimiter) . '#', $string, $limit);
    }
}
if (function_exists("ryunosuke\\Functions\\multiexplode") && !defined("ryunosuke\\Functions\\multiexplode")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\multiexplode", "ryunosuke\\Functions\\multiexplode");
}

if (!isset($excluded_functions["quoteexplode"]) && (!function_exists("ryunosuke\\Functions\\quoteexplode") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\quoteexplode"))->isInternal()))) {
    /**
     * エスケープやクオートに対応した explode
     *
     * $enclosures は配列で開始・終了文字が別々に指定できるが、実装上の都合で今のところ1文字ずつのみ。
     *
     * 歴史的な理由により第3引数は $limit でも $enclosures でもどちらでも渡すことができる。
     *
     * Example:
     * ```php
     * // シンプルな例
     * that(quoteexplode(',', 'a,b,c\\,d,"e,f"'))->isSame([
     *     'a', // 普通に分割される
     *     'b', // 普通に分割される
     *     'c\\,d', // \\ でエスケープしているので区切り文字とみなされない
     *     '"e,f"', // "" でクオートされているので区切り文字とみなされない
     * ]);
     *
     * // $enclosures で囲い文字の開始・終了文字を明示できる
     * that(quoteexplode(',', 'a,b,{e,f}', ['{' => '}']))->isSame([
     *     'a', // 普通に分割される
     *     'b', // 普通に分割される
     *     '{e,f}', // { } で囲まれているので区切り文字とみなされない
     * ]);
     *
     * // このように第3引数に $limit 引数を差し込むことができる
     * that(quoteexplode(',', 'a,b,{e,f}', 2, ['{' => '}']))->isSame([
     *     'a',
     *     'b,{e,f}',
     * ]);
     * ```
     *
     * @param string|array $delimiter 分割文字列
     * @param string $string 対象文字列
     * @param ?int $limit 分割数。負数未対応
     * @param array|string $enclosures 囲い文字。 ["start" => "end"] で開始・終了が指定できる
     * @param string $escape エスケープ文字
     * @return array 分割された配列
     */
    function quoteexplode($delimiter, $string, $limit = null, $enclosures = "'\"", $escape = '\\')
    {
        // for compatible 1.3.x
        if (!is_int($limit) && $limit !== null) {
            if (func_num_args() > 3) {
                $escape = $enclosures;
            }
            $enclosures = $limit;
            $limit = PHP_INT_MAX;
        }

        if ($limit === null) {
            $limit = PHP_INT_MAX;
        }
        $limit = max(1, $limit);

        $delimiters = arrayize($delimiter);
        $current = 0;
        $result = [];
        for ($i = 0, $l = strlen($string); $i < $l; $i++) {
            if (count($result) === $limit - 1) {
                break;
            }
            $i = strpos_quoted($string, $delimiters, $i, $enclosures, $escape);
            if ($i === false) {
                break;
            }
            foreach ($delimiters as $delimiter) {
                $delimiterlen = strlen($delimiter);
                if (substr_compare($string, $delimiter, $i, $delimiterlen) === 0) {
                    $result[] = substr($string, $current, $i - $current);
                    $current = $i + $delimiterlen;
                    $i += $delimiterlen - 1;
                    break;
                }
            }
        }
        $result[] = substr($string, $current, $l);
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\quoteexplode") && !defined("ryunosuke\\Functions\\quoteexplode")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\quoteexplode", "ryunosuke\\Functions\\quoteexplode");
}

if (!isset($excluded_functions["strrstr"]) && (!function_exists("ryunosuke\\Functions\\strrstr") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\strrstr"))->isInternal()))) {
    /**
     * 文字列が最後に現れる位置以前を返す
     *
     * strstr の逆のイメージで文字列を後ろから探索する動作となる。
     * strstr の動作は「文字列を前から探索して指定文字列があったらそれ以後を返す」なので、
     * その逆の動作の「文字列を後ろから探索して指定文字列があったらそれ以前を返す」という挙動を示す。
     *
     * strstr の「needle が文字列でない場合は、 それを整数に変換し、その番号に対応する文字として扱います」は直感的じゃないので踏襲しない。
     * （全体的にこの動作をやめよう、という RFC もあったはず）。
     *
     * 第3引数の意味合いもデフォルト値も逆になるので、単純に呼べばよくある「指定文字列より後ろを（指定文字列を含めないで）返す」という動作になる。
     *
     * Example:
     * ```php
     * // パス中の最後のディレクトリを取得
     * that(strrstr("path/to/1:path/to/2:path/to/3", ":"))->isSame('path/to/3');
     * // $after_needle を false にすると逆の動作になる
     * that(strrstr("path/to/1:path/to/2:path/to/3", ":", false))->isSame('path/to/1:path/to/2:');
     * // （参考）strrchr と違い、文字列が使えるしその文字そのものは含まれない
     * that(strrstr("A\r\nB\r\nC", "\r\n"))->isSame('C');
     * ```
     *
     * @param string $haystack 調べる文字列
     * @param string $needle 検索文字列
     * @param bool $after_needle $needle より後ろを返すか
     * @return string
     */
    function strrstr($haystack, $needle, $after_needle = true)
    {
        // return strrev(strstr(strrev($haystack), strrev($needle), $after_needle));

        $lastpos = mb_strrpos($haystack, $needle);
        if ($lastpos === false) {
            return false;
        }

        if ($after_needle) {
            return mb_substr($haystack, $lastpos + mb_strlen($needle));
        }
        else {
            return mb_substr($haystack, 0, $lastpos + mb_strlen($needle));
        }
    }
}
if (function_exists("ryunosuke\\Functions\\strrstr") && !defined("ryunosuke\\Functions\\strrstr")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\strrstr", "ryunosuke\\Functions\\strrstr");
}

if (!isset($excluded_functions["strpos_array"]) && (!function_exists("ryunosuke\\Functions\\strpos_array") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\strpos_array"))->isInternal()))) {
    /**
     * 複数の文字列で strpos する
     *
     * $needles のそれぞれの位置を配列で返す。
     * ただし、見つからなかった文字は結果に含まれない。
     *
     * Example:
     * ```php
     * // 見つかった位置を返す
     * that(strpos_array('hello world', ['hello', 'world']))->isSame([
     *     0 => 0,
     *     1 => 6,
     * ]);
     * // 見つからない文字は含まれない
     * that(strpos_array('hello world', ['notfound', 'world']))->isSame([
     *     1 => 6,
     * ]);
     * ```
     *
     * @param string $haystack 対象文字列
     * @param iterable $needles 位置を取得したい文字列配列
     * @param int $offset 開始位置
     * @return array $needles それぞれの位置配列
     */
    function strpos_array($haystack, $needles, $offset = 0)
    {
        if ($offset < 0) {
            $offset += strlen($haystack);
        }

        $result = [];
        foreach (arrayval($needles, false) as $key => $needle) {
            $pos = strpos($haystack, $needle, $offset);
            if ($pos !== false) {
                $result[$key] = $pos;
            }
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\strpos_array") && !defined("ryunosuke\\Functions\\strpos_array")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\strpos_array", "ryunosuke\\Functions\\strpos_array");
}

if (!isset($excluded_functions["strpos_quoted"]) && (!function_exists("ryunosuke\\Functions\\strpos_quoted") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\strpos_quoted"))->isInternal()))) {
    /**
     * クオートを考慮して strpos する
     *
     * Example:
     * ```php
     * // クオート中は除外される
     * that(strpos_quoted('hello "this" is world', 'is'))->isSame(13);
     * // 開始位置やクオート文字は指定できる（5文字目以降の \* に囲まれていない hoge の位置を返す）
     * that(strpos_quoted('1:hoge, 2:*hoge*, 3:hoge', 'hoge', 5, '*'))->isSame(20);
     * ```
     *
     * @param string $haystack 対象文字列
     * @param string|iterable $needle 位置を取得したい文字列
     * @param int $offset 開始位置
     * @param string|array $enclosure 囲い文字。この文字中にいる $from, $to 文字は走査外になる
     * @param string $escape エスケープ文字。この文字が前にある $from, $to 文字は走査外になる
     * @return false|int $needle の位置
     */
    function strpos_quoted($haystack, $needle, $offset = 0, $enclosure = "'\"", $escape = '\\')
    {
        if (is_string($enclosure) || is_null($enclosure)) {
            if (strlen($enclosure)) {
                $chars = str_split($enclosure);
                $enclosure = array_combine($chars, $chars);
            }
            else {
                $enclosure = [];
            }
        }
        $needles = arrayval($needle, false);

        $strlen = strlen($haystack);

        if ($offset < 0) {
            $offset += $strlen;
        }

        $enclosing = [];
        for ($i = $offset; $i < $strlen; $i++) {
            if ($i !== 0 && $haystack[$i - 1] === $escape) {
                continue;
            }
            foreach ($enclosure as $start => $end) {
                if (substr_compare($haystack, $end, $i, strlen($end)) === 0) {
                    if ($enclosing && $enclosing[count($enclosing) - 1] === $end) {
                        array_pop($enclosing);
                        $i += strlen($end) - 1;
                        continue 2;
                    }
                }
                if (substr_compare($haystack, $start, $i, strlen($start)) === 0) {
                    $enclosing[] = $end;
                    $i += strlen($start) - 1;
                    continue 2;
                }
            }

            if (empty($enclosing)) {
                foreach ($needles as $needle) {
                    if (substr_compare($haystack, $needle, $i, strlen($needle)) === 0) {
                        return $i;
                    }
                }
            }
        }
        return false;
    }
}
if (function_exists("ryunosuke\\Functions\\strpos_quoted") && !defined("ryunosuke\\Functions\\strpos_quoted")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\strpos_quoted", "ryunosuke\\Functions\\strpos_quoted");
}

if (!isset($excluded_functions["str_chunk"]) && (!function_exists("ryunosuke\\Functions\\str_chunk") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\str_chunk"))->isInternal()))) {
    /**
     * 文字列を可変引数の数で分割する
     *
     * str_split の $length を個別に指定できるイメージ。
     * 長さ以上を指定したりしても最後の要素は必ずついてくる（指定数で分割した後のあまり文字が最後の要素になる）。
     * これは最後が空文字でも同様で、 list での代入を想定しているため。
     *
     * Example:
     * ```php
     * // 1, 2, 3 文字に分割（ぴったりなので変わったことはない）
     * that(str_chunk('abcdef', 1, 2, 3))->isSame(['a', 'bc', 'def', '']);
     * // 2, 3 文字に分割（余った f も最後の要素として含まれてくる）
     * that(str_chunk('abcdef', 2, 3))->isSame(['ab', 'cde', 'f']);
     * // 1, 10 文字に分割
     * that(str_chunk('abcdef', 1, 10))->isSame(['a', 'bcdef', '']);
     * ```
     *
     * @param string $string 対象文字列
     * @param int ...$chunks 分割の各文字数（可変引数）
     * @return string[] 分割された文字列配列
     */
    function str_chunk($string, ...$chunks)
    {
        $offset = 0;
        $length = strlen($string);
        $result = [];
        foreach ($chunks as $chunk) {
            if ($offset >= $length) {
                break;
            }
            $result[] = substr($string, $offset, $chunk);
            $offset += $chunk;
        }
        $result[] = (string) substr($string, $offset);
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\str_chunk") && !defined("ryunosuke\\Functions\\str_chunk")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\str_chunk", "ryunosuke\\Functions\\str_chunk");
}

if (!isset($excluded_functions["str_anyof"]) && (!function_exists("ryunosuke\\Functions\\str_anyof") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\str_anyof"))->isInternal()))) {
    /**
     * 文字列が候補の中にあるか調べる
     *
     * 候補配列の中に対象文字列があるならそのキーを返す。ないなら null を返す。
     *
     * あくまで文字列としての比較に徹する（in_array/array_search の第3引数は厳密すぎて使いにくいことがある）。
     * ので array_search の文字列特化版とも言える。
     * 動作的には `array_flip($haystack)[$needle] ?? null` と同じ（大文字小文字オプションはあるけど）。
     * ただ array_flip は巨大配列に弱いし、大文字小文字などの融通が効かないので foreach での素朴な実装になっている。
     *
     * Example:
     * ```php
     * that(str_anyof('b', ['a', 'b', 'c']))->isSame(1);       // 見つかったキーを返す
     * that(str_anyof('x', ['a', 'b', 'c']))->isSame(null);    // 見つからないなら null を返す
     * that(str_anyof('C', ['a', 'b', 'c'], true))->isSame(2); // 大文字文字を区別しない
     * that(str_anyof('1', [1, 2, 3]))->isSame(0);             // 文字列の比較に徹する
     * that(str_anyof(2, ['1', '2', '3']))->isSame(1);         // 同上
     * ```
     *
     * @param string $needle 調べる文字列
     * @param iterable $haystack 候補配列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return bool 候補の中にあるならそのキー。無いなら null
     */
    function str_anyof($needle, $haystack, $case_insensitivity = false)
    {
        $needle = (string) $needle;
        foreach ($haystack as $k => $v) {
            if (!$case_insensitivity && strcmp($needle, $v) === 0) {
                return $k;
            }
            elseif ($case_insensitivity && strcasecmp($needle, $v) === 0) {
                return $k;
            }
        }
        return null;
    }
}
if (function_exists("ryunosuke\\Functions\\str_anyof") && !defined("ryunosuke\\Functions\\str_anyof")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\str_anyof", "ryunosuke\\Functions\\str_anyof");
}

if (!isset($excluded_functions["str_equals"]) && (!function_exists("ryunosuke\\Functions\\str_equals") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\str_equals"))->isInternal()))) {
    /**
     * 文字列比較の関数版
     *
     * 文字列以外が与えられた場合は常に false を返す。ただし __toString を実装したオブジェクトは別。
     *
     * Example:
     * ```php
     * that(str_equals('abc', 'abc'))->isTrue();
     * that(str_equals('abc', 'ABC', true))->isTrue();
     * that(str_equals('\0abc', '\0abc'))->isTrue();
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
if (function_exists("ryunosuke\\Functions\\str_equals") && !defined("ryunosuke\\Functions\\str_equals")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\str_equals", "ryunosuke\\Functions\\str_equals");
}

if (!isset($excluded_functions["str_contains"]) && (!function_exists("ryunosuke\\Functions\\str_contains") || (!true && (new \ReflectionFunction("ryunosuke\\Functions\\str_contains"))->isInternal()))) {
    /**
     * 指定文字列を含むか返す
     *
     * @see str_exists
     *
     * @polyfill
     * @deprecated
     * @codeCoverageIgnore
     *
     * @param string $haystack 対象文字列
     * @param string|array $needle 調べる文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @param bool $and_flag すべて含む場合に true を返すか
     * @return bool $needle を含むなら true
     */
    function str_contains($haystack, $needle, $case_insensitivity = false, $and_flag = false)
    {
        trigger_error('this function(' . __FUNCTION__ . ') is deprecated, use str_exists', E_USER_DEPRECATED);
        return str_exists($haystack, $needle, $case_insensitivity, $and_flag);
    }
}
if (function_exists("ryunosuke\\Functions\\str_contains") && !defined("ryunosuke\\Functions\\str_contains")) {
    /**
     * @deprecated
     */
    define("ryunosuke\\Functions\\str_contains", "ryunosuke\\Functions\\str_contains");
}

if (!isset($excluded_functions["str_exists"]) && (!function_exists("ryunosuke\\Functions\\str_exists") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\str_exists"))->isInternal()))) {
    /**
     * 指定文字列を含むか返す
     *
     * Example:
     * ```php
     * that(str_exists('abc', 'b'))->isTrue();
     * that(str_exists('abc', 'B', true))->isTrue();
     * that(str_exists('abc', ['b', 'x'], false, false))->isTrue();
     * that(str_exists('abc', ['b', 'x'], false, true))->isFalse();
     * ```
     *
     * @param string $haystack 対象文字列
     * @param string|array $needle 調べる文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @param bool $and_flag すべて含む場合に true を返すか
     * @return bool $needle を含むなら true
     */
    function str_exists($haystack, $needle, $case_insensitivity = false, $and_flag = false)
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
if (function_exists("ryunosuke\\Functions\\str_exists") && !defined("ryunosuke\\Functions\\str_exists")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\str_exists", "ryunosuke\\Functions\\str_exists");
}

if (!isset($excluded_functions["str_chop"]) && (!function_exists("ryunosuke\\Functions\\str_chop") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\str_chop"))->isInternal()))) {
    /**
     * 先頭・末尾の指定文字列を削ぎ落とす
     *
     * Example:
     * ```php
     * // 文字列からパス文字列と拡張子を削ぎ落とす
     * $PATH = '/path/to/something';
     * that(str_chop("$PATH/hoge.php", "$PATH/", '.php'))->isSame('hoge');
     * ```
     *
     * @param string $string 対象文字列
     * @param ?string $prefix 削ぎ落とす先頭文字列
     * @param ?string $suffix 削ぎ落とす末尾文字列
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
if (function_exists("ryunosuke\\Functions\\str_chop") && !defined("ryunosuke\\Functions\\str_chop")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\str_chop", "ryunosuke\\Functions\\str_chop");
}

if (!isset($excluded_functions["str_lchop"]) && (!function_exists("ryunosuke\\Functions\\str_lchop") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\str_lchop"))->isInternal()))) {
    /**
     * 先頭の指定文字列を削ぎ落とす
     *
     * Example:
     * ```php
     * // 文字列からパス文字列を削ぎ落とす
     * $PATH = '/path/to/something';
     * that(str_lchop("$PATH/hoge.php", "$PATH/"))->isSame('hoge.php');
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
if (function_exists("ryunosuke\\Functions\\str_lchop") && !defined("ryunosuke\\Functions\\str_lchop")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\str_lchop", "ryunosuke\\Functions\\str_lchop");
}

if (!isset($excluded_functions["str_rchop"]) && (!function_exists("ryunosuke\\Functions\\str_rchop") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\str_rchop"))->isInternal()))) {
    /**
     * 末尾の指定文字列を削ぎ落とす
     *
     * Example:
     * ```php
     * // 文字列から .php を削ぎ落とす
     * $PATH = '/path/to/something';
     * that(str_rchop("$PATH/hoge.php", ".php"))->isSame("$PATH/hoge");
     * ```
     *
     * @param string $string 対象文字列
     * @param ?string $suffix 削ぎ落とす末尾文字列
     * @param bool $case_insensitivity 大文字小文字を無視するか
     * @return string 削ぎ落とした文字列
     */
    function str_rchop($string, $suffix = null, $case_insensitivity = false)
    {
        return str_chop($string, null, $suffix, $case_insensitivity);
    }
}
if (function_exists("ryunosuke\\Functions\\str_rchop") && !defined("ryunosuke\\Functions\\str_rchop")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\str_rchop", "ryunosuke\\Functions\\str_rchop");
}

if (!isset($excluded_functions["str_putcsv"]) && (!function_exists("ryunosuke\\Functions\\str_putcsv") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\str_putcsv"))->isInternal()))) {
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
     * that(str_putcsv(['a', 'b', 'c']))->isSame("a,b,c");
     * that(str_putcsv(['a', 'b', 'c'], "\t"))->isSame("a\tb\tc");
     * that(str_putcsv(['a', ' b ', 'c'], " ", "'"))->isSame("a ' b ' c");
     *
     * // 複数行を返す
     * that(str_putcsv([['a', 'b', 'c'], ['d', 'e', 'f']]))->isSame("a,b,c\nd,e,f");
     * that(str_putcsv((function() {
     *     yield ['a', 'b', 'c'];
     *     yield ['d', 'e', 'f'];
     * })()))->isSame("a,b,c\nd,e,f");
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
if (function_exists("ryunosuke\\Functions\\str_putcsv") && !defined("ryunosuke\\Functions\\str_putcsv")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\str_putcsv", "ryunosuke\\Functions\\str_putcsv");
}

if (!isset($excluded_functions["str_subreplace"]) && (!function_exists("ryunosuke\\Functions\\str_subreplace") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\str_subreplace"))->isInternal()))) {
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
     * that(str_subreplace('xxx', 'x', [1 => 'X']))->isSame('xXx');
     * // 0番目（最前列）の x を Xa に、-1番目（最後尾）の x を Xz に置換
     * that(str_subreplace('!xxx!', 'x', [0 => 'Xa', -1 => 'Xz']))->isSame('!XaxXz!');
     * // 置換結果は置換対象にならない
     * that(str_subreplace('xxx', 'x', [0 => 'xxx', 1 => 'X']))->isSame('xxxXx');
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
if (function_exists("ryunosuke\\Functions\\str_subreplace") && !defined("ryunosuke\\Functions\\str_subreplace")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\str_subreplace", "ryunosuke\\Functions\\str_subreplace");
}

if (!isset($excluded_functions["str_submap"]) && (!function_exists("ryunosuke\\Functions\\str_submap") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\str_submap"))->isInternal()))) {
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
     * that(str_submap('hello, world', [
     *     // l は0番目と2番目のみを置換（1番目は何も行われない）
     *     'l' => [
     *         0 => 'L1',
     *         2 => 'L3',
     *     ],
     *     // o は後ろから数えて1番目を置換
     *     'o' => [
     *         -1 => 'O',
     *     ],
     * ]))->isSame('heL1lo, wOrL3d');
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
        $patterns = array_map(fn($k) => preg_quote($k, '#'), $repkeys);

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
if (function_exists("ryunosuke\\Functions\\str_submap") && !defined("ryunosuke\\Functions\\str_submap")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\str_submap", "ryunosuke\\Functions\\str_submap");
}

if (!isset($excluded_functions["str_embed"]) && (!function_exists("ryunosuke\\Functions\\str_embed") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\str_embed"))->isInternal()))) {
    /**
     * エスケープ付きで文字列を置換する
     *
     * $replacemap で from -> to 文字列を指定する。
     * to は文字列と配列を受け付ける。
     * 文字列の場合は普通に想起される動作で単純な置換となる。
     * 配列の場合は順次置換していく。要素が足りなくなったら例外を投げる。
     *
     * strtr と同様、最も長いキーから置換を行い、置換後の文字列は対象にならない。
     *
     * $enclosure で「特定文字に囲まれている」場合を無視することができる。
     * $escape で「特定文字が前にある」場合を無視することができる。
     *
     * Example:
     * ```php
     * // 最も単純な置換
     * that(str_embed('a, b, c', ['a' => 'A', 'b' => 'B', 'c' => 'C']))->isSame('A, B, C');
     * // 最も長いキーから置換される
     * that(str_embed('abc', ['a' => 'X', 'ab' => 'AB']))->isSame('ABc');
     * // 配列を渡すと「N番目の置換」が実現できる（文字列の場合は再利用される）
     * that(str_embed('a, a, b, b', [
     *     'a' => 'A',          // 全ての a が A になる
     *     'b' => ['B1', 'B2'], // 1番目の b が B1, 2番目の b が B2 になる
     * ]))->isSame('A, A, B1, B2');
     * // 最も重要な性質として "' で囲まれていると対象にならない
     * that(str_embed('a, "a", b, "b", b', [
     *     'a' => 'A',
     *     'b' => ['B1', 'B2'],
     * ]))->isSame('A, "a", B1, "b", B2');
     * ```
     *
     * @param string $string 対象文字列
     * @param array $replacemap 置換文字列
     * @param string|array $enclosure 囲い文字。この文字中にいる $from, $to 文字は走査外になる
     * @param string $escape エスケープ文字。この文字が前にある $from, $to 文字は走査外になる
     * @return string 置換された文字列
     */
    function str_embed($string, $replacemap, $enclosure = "'\"", $escape = '\\')
    {
        assert(is_iterable($replacemap));

        $string = (string) $string;

        // 長いキーから処理するためソートしておく
        $replacemap = arrayval($replacemap, false);
        uksort($replacemap, fn($a, $b) => strlen($b) - strlen($a));
        $srcs = array_keys($replacemap);

        $counter = array_fill_keys(array_keys($replacemap), 0);
        for ($i = 0; $i < strlen($string); $i++) {
            $i = strpos_quoted($string, $srcs, $i, $enclosure, $escape);
            if ($i === false) {
                break;
            }

            foreach ($replacemap as $src => $dst) {
                $srclen = strlen($src);
                if ($srclen === 0) {
                    throw new \InvalidArgumentException("src length is 0.");
                }
                if (substr_compare($string, $src, $i, $srclen) === 0) {
                    if (is_array($dst)) {
                        $n = $counter[$src]++;
                        if (!isset($dst[$n])) {
                            throw new \InvalidArgumentException("notfound search string '$src' of {$n}th.");
                        }
                        $dst = $dst[$n];
                    }
                    $string = substr_replace($string, $dst, $i, $srclen);
                    $i += strlen($dst) - 1;
                    break;
                }
            }
        }
        return $string;
    }
}
if (function_exists("ryunosuke\\Functions\\str_embed") && !defined("ryunosuke\\Functions\\str_embed")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\str_embed", "ryunosuke\\Functions\\str_embed");
}

if (!isset($excluded_functions["str_between"]) && (!function_exists("ryunosuke\\Functions\\str_between") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\str_between"))->isInternal()))) {
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
     * that(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n))->isSame('first');
     * that(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n))->isSame('second');
     * that(str_between('{first} and {second} and "{blank}" and {third}', '{', '}', $n))->isSame('third');
     * // ネストしている場合は最も外側を返す
     * that(str_between('{nest1{nest2{nest3}}}', '{', '}'))->isSame('nest1{nest2{nest3}}');
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
        $nesting = 0;
        $start = null;
        for ($i = $position; $i < $strlen; $i++) {
            $i = strpos_quoted($string, [$from, $to], $i, $enclosure, $escape);
            if ($i === false) {
                break;
            }

            // 開始文字と終了文字が重複している可能性があるので $to からチェックする
            if (substr_compare($string, $to, $i, $tolen) === 0) {
                if (--$nesting === 0) {
                    $position = $i + $tolen;
                    return substr($string, $start, $i - $start);
                }
                // いきなり終了文字が来た場合は無視する
                if ($nesting < 0) {
                    $nesting = 0;
                }
            }
            if (substr_compare($string, $from, $i, $fromlen) === 0) {
                if ($nesting++ === 0) {
                    $start = $i + $fromlen;
                }
            }
        }
        return false;
    }
}
if (function_exists("ryunosuke\\Functions\\str_between") && !defined("ryunosuke\\Functions\\str_between")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\str_between", "ryunosuke\\Functions\\str_between");
}

if (!isset($excluded_functions["str_ellipsis"]) && (!function_exists("ryunosuke\\Functions\\str_ellipsis") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\str_ellipsis"))->isInternal()))) {
    /**
     * 文字列を指定数に丸める
     *
     * mb_strimwidth と似ているが、省略文字の差し込み位置を $pos で指定できる。
     * $pos は負数が指定できる。負数の場合後ろから数えられる。
     * 省略した場合は真ん中となる。
     *
     * Example:
     * ```php
     * // 8文字に丸める（$pos 省略なので真ん中が省略される）
     * that(str_ellipsis('1234567890', 8, '...'))->isSame('12...890');
     * // 8文字に丸める（$pos=1 なので1文字目から省略される）
     * that(str_ellipsis('1234567890', 8, '...', 1))->isSame('1...7890');
     * // 8文字に丸める（$pos=-1 なので後ろから1文字目から省略される）
     * that(str_ellipsis('1234567890', 8, '...', -1))->isSame('1234...0');
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
        $pos ??= $length / 2;
        if ($pos < 0) {
            $pos += $length;
        }
        $pos = max(0, min($pos, $length));

        return mb_substr_replace($string, $trimmarker, $pos, $strlen - $length);
    }
}
if (function_exists("ryunosuke\\Functions\\str_ellipsis") && !defined("ryunosuke\\Functions\\str_ellipsis")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\str_ellipsis", "ryunosuke\\Functions\\str_ellipsis");
}

if (!isset($excluded_functions["str_diff"]) && (!function_exists("ryunosuke\\Functions\\str_diff") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\str_diff"))->isInternal()))) {
    /**
     * テキストの diff を得る
     *
     * `$options['iignore-case'] = true` で大文字小文字を無視する。
     * `$options['ignore-space-change'] = true` 空白文字の数を無視する。
     * `$options['ignore-all-space'] = true` ですべての空白文字を無視する
     * `$options['stringify']` で差分データを文字列化するクロージャを指定する。
     *
     * - normal: 標準形式（diff のオプションなしに相当する）
     * - context: コンテキスト形式（context=3 のような形式で diff の -C 3 に相当する）
     * - unified: ユニファイド形式（unified=3 のような形式で diff の -U 3 に相当する）
     *     - unified のみを指定するとヘッダを含まない +- のみの差分を出す
     * - html: ins, del の html タグ形式
     *     - html=perline とすると行レベルでの差分も出す
     *
     * Example:
     * ```php
     * // 前文字列
     * $old = 'same
     * delete
     * same
     * same
     * change
     * ';
     * // 後文字列
     * $new = 'same
     * same
     * append
     * same
     * this is changed line
     * ';
     * // シンプルな差分テキストを返す
     * that(str_diff($old, $new))->isSame(' same
     * -delete
     *  same
     * +append
     *  same
     * -change
     * +this is changed line
     * ');
     * // html で差分を返す
     * that(str_diff($old, $new, ['stringify' => 'html']))->isSame('same
     * <del>delete</del>
     * same
     * <ins>append</ins>
     * same
     * <del>change</del>
     * <ins>this is changed line</ins>
     * ');
     * // 行レベルの html で差分を返す
     * that(str_diff($old, $new, ['stringify' => 'html=perline']))->isSame('same
     * <del>delete</del>
     * same
     * <ins>append</ins>
     * same
     * <ins>this is </ins>chang<ins>ed lin</ins>e
     * ');
     * // raw な配列で差分を返す
     * that(str_diff($old, $new, ['stringify' => null]))->isSame([
     *     // 等価行（'=' という記号と前後それぞれの文字列を返す（キーは行番号））
     *     ['=', [0 => 'same'], [0 => 'same']],
     *     // 削除行（'-' という記号と前の文字列を返す（キーは行番号）、後は int で行番号のみ）
     *     ['-', [1 => 'delete'], 0],
     *     // 等価行
     *     ['=', [2 => 'same'], [1 => 'same']],
     *     // 追加行（'+' という記号と後の文字列を返す（キーは行番号）、前は int で行番号のみ）
     *     ['+', 2, [2 => 'append']],
     *     // 等価行
     *     ['=', [3 => 'same'], [3 => 'same']],
     *     // 変更行（'*' という記号と前後それぞれの文字列を返す（キーは行番号））
     *     ['*', [4 => 'change'], [4 => 'this is changed line']],
     * ]);
     * ```
     *
     * @param string|array $xstring 元文字列
     * @param string|array $ystring 比較文字列
     * @param array $options オプション配列
     * @return string|array 差分テキスト。 stringify が null の場合は raw な差分配列
     */
    function str_diff($xstring, $ystring, $options = [])
    {
        $differ = new class($options) {
            private $options;

            public function __construct($options)
            {
                $options += [
                    'ignore-case'         => false,
                    'ignore-space-change' => false,
                    'ignore-all-space'    => false,
                    'stringify'           => 'unified',
                ];
                $this->options = $options;
            }

            public function __invoke($xstring, $ystring)
            {
                $xstring = is_array($xstring) ? array_values($xstring) : preg_split('#\R#u', $xstring);
                $ystring = is_array($ystring) ? array_values($ystring) : preg_split('#\R#u', $ystring);

                $trailingN = "";
                if ($xstring[count($xstring) - 1] === '' && $ystring[count($ystring) - 1] === '') {
                    $trailingN = "\n";
                    array_pop($xstring);
                    array_pop($ystring);
                }

                $diffs = $this->diff($xstring, $ystring);

                $stringfy = $this->options['stringify'];
                if (!$stringfy) {
                    return $diffs;
                }
                if ($stringfy === 'normal') {
                    $stringfy = [$this, 'normal'];
                }
                if (is_string($stringfy) && preg_match('#context(=(\d+))?#', $stringfy, $m)) {
                    $block_size = (int) ($m[2] ?? 3);
                    $stringfy = [$this, 'context'];
                }
                if (is_string($stringfy) && preg_match('#unified(=(\d+))?#', $stringfy, $m)) {
                    $block_size = isset($m[2]) ? (int) $m[2] : null;
                    $stringfy = fn($diff) => $this->unified($diff, $block_size);
                }
                if (is_string($stringfy) && preg_match('#html(=(.+))?#', $stringfy, $m)) {
                    $mode = $m[2] ?? null;
                    $stringfy = fn($diff) => $this->html($diff, $mode);
                }

                if (isset($block_size)) {
                    $result = implode("\n", array_map($stringfy, $this->block($diffs, $block_size)));
                }
                else {
                    $result = $stringfy($diffs);
                }

                return !strlen($result) ? $result : $result . $trailingN;
            }

            private function diff(array $xarray, array $yarray)
            {
                $convert = function ($string) {
                    if ($this->options['ignore-case']) {
                        $string = strtoupper($string);
                    }
                    if ($this->options['ignore-space-change']) {
                        $string = preg_replace('#\s+#u', ' ', $string);
                    }
                    if ($this->options['ignore-all-space']) {
                        $string = preg_replace('#\s+#u', '', $string);
                    }
                    return $string;
                };
                $xarray2 = array_map($convert, $xarray);
                $yarray2 = array_map($convert, $yarray);
                $xcount = count($xarray2);
                $ycount = count($yarray2);

                $head = [];
                reset($yarray2);
                foreach ($xarray2 as $xk => $xv) {
                    $yk = key($yarray2);
                    if ($yk !== $xk || $xv !== $yarray2[$xk]) {
                        break;
                    }
                    $head[$xk] = $xv;
                    unset($xarray2[$xk], $yarray2[$xk]);
                }

                $tail = [];
                end($xarray2);
                end($yarray2);
                do {
                    $xk = key($xarray2);
                    $yk = key($yarray2);
                    if (null === $xk || null === $yk || current($xarray2) !== current($yarray2)) {
                        break;
                    }
                    prev($xarray2);
                    prev($yarray2);
                    $tail = [$xk - $xcount => $xarray2[$xk]] + $tail;
                    unset($xarray2[$xk], $yarray2[$yk]);
                } while (true);

                $common = $this->lcs(array_values($xarray2), array_values($yarray2));

                $xchanged = $ychanged = [];
                foreach ($head as $n => $line) {
                    $xchanged[$n] = false;
                    $ychanged[$n] = false;
                }
                foreach ($common as $line) {
                    foreach ($xarray2 as $n => $l) {
                        unset($xarray2[$n]);
                        $xchanged[$n] = $line !== $l;
                        if (!$xchanged[$n]) {
                            break;
                        }
                    }
                    foreach ($yarray2 as $n => $l) {
                        unset($yarray2[$n]);
                        $ychanged[$n] = $line !== $l;
                        if (!$ychanged[$n]) {
                            break;
                        }
                    }
                }
                foreach ($xarray2 as $n => $line) {
                    $xchanged[$n] = true;
                }
                foreach ($yarray2 as $n => $line) {
                    $ychanged[$n] = true;
                }
                foreach ($tail as $n => $line) {
                    $xchanged[$n + $xcount] = false;
                    $ychanged[$n + $ycount] = false;
                }

                $diffs = [];
                $xi = $yi = 0;
                while ($xi < $xcount || $yi < $ycount) {
                    for ($xequal = [], $yequal = []; $xi < $xcount && $yi < $ycount && !$xchanged[$xi] && !$ychanged[$yi]; $xi++, $yi++) {
                        $xequal[$xi] = $xarray[$xi];
                        $yequal[$yi] = $yarray[$yi];
                    }
                    for ($delete = []; $xi < $xcount && $xchanged[$xi]; $xi++) {
                        $delete[$xi] = $xarray[$xi];
                    }
                    for ($append = []; $yi < $ycount && $ychanged[$yi]; $yi++) {
                        $append[$yi] = $yarray[$yi];
                    }

                    if ($xequal && $yequal) {
                        $diffs[] = ['=', $xequal, $yequal];
                    }
                    if ($delete && $append) {
                        $diffs[] = ['*', $delete, $append];
                    }
                    elseif ($delete) {
                        $diffs[] = ['-', $delete, $yi - 1];
                    }
                    elseif ($append) {
                        $diffs[] = ['+', $xi - 1, $append];
                    }
                }
                return $diffs;
            }

            private function lcs(array $xarray, array $yarray)
            {
                $xcount = count($xarray);
                $ycount = count($yarray);
                if ($xcount === 0) {
                    return [];
                }
                if ($xcount === 1) {
                    if (in_array($xarray[0], $yarray, true)) {
                        return [$xarray[0]];
                    }
                    return [];
                }
                $i = (int) ($xcount / 2);
                $xprefix = array_slice($xarray, 0, $i);
                $xsuffix = array_slice($xarray, $i);
                $llB = $this->length($xprefix, $yarray);
                $llE = $this->length(array_reverse($xsuffix), array_reverse($yarray));
                $jMax = 0;
                $max = 0;
                for ($j = 0; $j <= $ycount; $j++) {
                    $m = $llB[$j] + $llE[$ycount - $j];
                    if ($m >= $max) {
                        $max = $m;
                        $jMax = $j;
                    }
                }
                $yprefix = array_slice($yarray, 0, $jMax);
                $ysuffix = array_slice($yarray, $jMax);
                return array_merge($this->lcs($xprefix, $yprefix), $this->lcs($xsuffix, $ysuffix));
            }

            private function length(array $xarray, array $yarray)
            {
                $xcount = count($xarray);
                $ycount = count($yarray);
                $current = array_fill(0, $ycount + 1, 0);
                for ($i = 0; $i < $xcount; $i++) {
                    $prev = $current;
                    for ($j = 0; $j < $ycount; $j++) {
                        $current[$j + 1] = $xarray[$i] === $yarray[$j] ? $prev[$j] + 1 : max($current[$j], $prev[$j + 1]);
                    }
                }
                return $current;
            }

            private function minmaxlen($diffs)
            {
                $xmin = $ymin = PHP_INT_MAX;
                $xmax = $ymax = -1;
                $xlen = $ylen = 0;
                foreach ($diffs as $diff) {
                    $xargs = (is_array($diff[1]) ? array_keys($diff[1]) : [$diff[1]]);
                    $yargs = (is_array($diff[2]) ? array_keys($diff[2]) : [$diff[2]]);
                    $xmin = min($xmin, ...$xargs);
                    $ymin = min($ymin, ...$yargs);
                    $xmax = max($xmax, ...$xargs);
                    $ymax = max($ymax, ...$yargs);
                    $xlen += is_array($diff[1]) ? count($diff[1]) : 0;
                    $ylen += is_array($diff[2]) ? count($diff[2]) : 0;
                }
                if ($xmin === -1 && $xlen > 0) {
                    $xmin = 0;
                }
                if ($ymin === -1 && $ylen > 0) {
                    $ymin = 0;
                }
                return [$xmin + 1, $xmax + 1, $xlen, $ymin + 1, $ymax + 1, $ylen];
            }

            private function normal($diffs)
            {
                $index = function ($v) {
                    if (!is_array($v)) {
                        return $v + 1;
                    }
                    $keys = array_keys($v);
                    $s = reset($keys) + 1;
                    $e = end($keys) + 1;
                    return $s === $e ? "$s" : "$s,$e";
                };

                $rule = [
                    '+' => ['a', [2 => '> ']],
                    '-' => ['d', [1 => '< ']],
                    '*' => ['c', [1 => '< ', 2 => '> ']],
                ];
                $result = [];
                foreach ($diffs as $diff) {
                    if (isset($rule[$diff[0]])) {
                        $difftext = [];
                        foreach ($rule[$diff[0]][1] as $n => $sign) {
                            $difftext[] = implode("\n", array_map(fn($v) => $sign . $v, $diff[$n]));
                        }
                        $result[] = "{$index($diff[1])}{$rule[$diff[0]][0]}{$index($diff[2])}";
                        $result[] = implode("\n---\n", $difftext);
                    }
                }
                return implode("\n", $result);
            }

            private function context($diffs)
            {
                [$xmin, $xmax, , $ymin, $ymax,] = $this->minmaxlen($diffs);
                $xheader = $xmin === $xmax ? "$xmin" : "$xmin,$xmax";
                $yheader = $ymin === $ymax ? "$ymin" : "$ymin,$ymax";

                $rules = [
                    '-*' => [
                        'header' => "*** {$xheader} ****",
                        '-'      => [1 => '- '],
                        '*'      => [1 => '! '],
                        '='      => [1 => '  '],
                    ],
                    '+*' => [
                        'header' => "--- {$yheader} ----",
                        '+'      => [2 => '+ '],
                        '*'      => [2 => '! '],
                        '='      => [2 => '  '],
                    ],
                ];
                $result = ["***************"];
                foreach ($rules as $key => $rule) {
                    $result[] = $rule['header'];
                    if (array_filter($diffs, fn($d) => strpos($key, $d[0]) !== false)) {
                        foreach ($diffs as $diff) {
                            foreach ($rule[$diff[0]] ?? [] as $n => $sign) {
                                $result[] = implode("\n", array_map(fn($v) => $sign . $v, $diff[$n]));
                            }
                        }
                    }
                }
                return implode("\n", $result);
            }

            private function unified($diffs, $block_size)
            {
                $result = [];

                if ($block_size !== null) {
                    [$xmin, , $xlen, $ymin, , $ylen] = $this->minmaxlen($diffs);
                    $xheader = $xlen === 1 ? "$xmin" : "$xmin,$xlen";
                    $yheader = $ylen === 1 ? "$ymin" : "$ymin,$ylen";
                    $result[] = "@@ -{$xheader} +{$yheader} @@";
                }

                $rule = [
                    '+' => [2 => '+'],
                    '-' => [1 => '-'],
                    '*' => [1 => '-', 2 => '+'],
                    '=' => [1 => ' '],
                ];
                foreach ($diffs as $diff) {
                    foreach ($rule[$diff[0]] as $n => $sign) {
                        $result[] = implode("\n", array_map(fn($v) => $sign . $v, $diff[$n]));
                    }
                }
                return implode("\n", $result);
            }

            private function html($diffs, $mode)
            {
                $htmlescape = function ($v) use (&$htmlescape) { return is_array($v) ? array_map($htmlescape, $v) : htmlspecialchars($v, ENT_QUOTES); };
                $taging = fn($tag, $content) => strlen($tag) && strlen($content) ? "<$tag>$content</$tag>" : $content;

                $rule = [
                    '+' => [2 => 'ins'],
                    '-' => [1 => 'del'],
                    '*' => [1 => 'del', 2 => 'ins'],
                    '=' => [1 => null],
                ];
                $result = [];
                foreach ($diffs as $diff) {
                    if ($mode === 'perline' && $diff[0] === '*') {
                        $length = min(count($diff[1]), count($diff[2]));
                        $delete = array_splice($diff[1], 0, $length, []);
                        $append = array_splice($diff[2], 0, $length, []);
                        for ($i = 0; $i < $length; $i++) {
                            $options2 = ['stringify' => null] + $this->options;
                            $diffs2 = str_diff(preg_split('/(?<!^)(?!$)/u', $delete[$i]), preg_split('/(?<!^)(?!$)/u', $append[$i]), $options2);
                            $result2 = [];
                            foreach ($diffs2 as $diff2) {
                                foreach ($rule[$diff2[0]] as $n => $tag) {
                                    $content = $taging($tag, implode("", (array) $htmlescape($diff2[$n])));
                                    if (strlen($content)) {
                                        $result2[] = $content;
                                    }
                                }
                            }
                            $result[] = implode("", $result2);
                        }
                    }
                    foreach ($rule[$diff[0]] as $n => $tag) {
                        $content = $taging($tag, implode("\n", (array) $htmlescape($diff[$n])));
                        if ($diff[0] === '=' && !strlen($content)) {
                            $result[] = "";
                        }
                        if (strlen($content)) {
                            $result[] = $content;
                        }
                    }
                }
                return implode("\n", $result);
            }

            private function block($diffs, $block_size)
            {
                $head = fn($array) => array_slice($array, 0, $block_size, true);
                $tail = fn($array) => array_slice($array, -$block_size, null, true);

                $blocks = [];
                $block = [];
                $last = count($diffs) - 1;
                foreach ($diffs as $n => $diff) {
                    if ($diff[0] !== '=') {
                        $block[] = $diff;
                        continue;
                    }

                    if (!$block) {
                        if ($block_size) {
                            $block[] = ['=', $tail($diff[1]), $tail($diff[2])];
                        }
                    }
                    elseif ($last === $n) {
                        if ($block_size) {
                            $block[] = ['=', $head($diff[1]), $head($diff[2])];
                        }
                    }
                    elseif (count($diff[1]) > $block_size * 2) {
                        if ($block_size) {
                            $block[] = ['=', $head($diff[1]), $head($diff[2])];
                        }
                        $blocks[] = $block;
                        $block = [];
                        if ($block_size) {
                            $block[] = ['=', $tail($diff[1]), $tail($diff[2])];
                        }
                    }
                    else {
                        if ($block_size) {
                            $block[] = $diff;
                        }
                    }
                }
                if (trim(implode('', array_column($block, 0)), '=')) {
                    $blocks[] = $block;
                }
                return $blocks;
            }
        };

        return $differ($xstring, $ystring);
    }
}
if (function_exists("ryunosuke\\Functions\\str_diff") && !defined("ryunosuke\\Functions\\str_diff")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\str_diff", "ryunosuke\\Functions\\str_diff");
}

if (!isset($excluded_functions["starts_with"]) && (!function_exists("ryunosuke\\Functions\\starts_with") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\starts_with"))->isInternal()))) {
    /**
     * 指定文字列で始まるか調べる
     *
     * $with に配列を渡すといずれかで始まるときに true を返す。
     *
     * Example:
     * ```php
     * that(starts_with('abcdef', 'abc'))->isTrue();
     * that(starts_with('abcdef', 'ABC', true))->isTrue();
     * that(starts_with('abcdef', 'xyz'))->isFalse();
     * that(starts_with('abcdef', ['a', 'b', 'c']))->isTrue();
     * that(starts_with('abcdef', ['x', 'y', 'z']))->isFalse();
     * ```
     *
     * @param string $string 探される文字列
     * @param string|string[] $with 探す文字列
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
if (function_exists("ryunosuke\\Functions\\starts_with") && !defined("ryunosuke\\Functions\\starts_with")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\starts_with", "ryunosuke\\Functions\\starts_with");
}

if (!isset($excluded_functions["ends_with"]) && (!function_exists("ryunosuke\\Functions\\ends_with") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\ends_with"))->isInternal()))) {
    /**
     * 指定文字列で終わるか調べる
     *
     * $with に配列を渡すといずれかで終わるときに true を返す。
     *
     * Example:
     * ```php
     * that(ends_with('abcdef', 'def'))->isTrue();
     * that(ends_with('abcdef', 'DEF', true))->isTrue();
     * that(ends_with('abcdef', 'xyz'))->isFalse();
     * that(ends_with('abcdef', ['d', 'e', 'f']))->isTrue();
     * that(ends_with('abcdef', ['x', 'y', 'z']))->isFalse();
     * ```
     *
     * @param string $string 探される文字列
     * @param string|string[] $with 探す文字列
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
if (function_exists("ryunosuke\\Functions\\ends_with") && !defined("ryunosuke\\Functions\\ends_with")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\ends_with", "ryunosuke\\Functions\\ends_with");
}

if (!isset($excluded_functions["camel_case"]) && (!function_exists("ryunosuke\\Functions\\camel_case") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\camel_case"))->isInternal()))) {
    /**
     * camelCase に変換する
     *
     * Example:
     * ```php
     * that(camel_case('this_is_a_pen'))->isSame('thisIsAPen');
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
if (function_exists("ryunosuke\\Functions\\camel_case") && !defined("ryunosuke\\Functions\\camel_case")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\camel_case", "ryunosuke\\Functions\\camel_case");
}

if (!isset($excluded_functions["pascal_case"]) && (!function_exists("ryunosuke\\Functions\\pascal_case") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\pascal_case"))->isInternal()))) {
    /**
     * PascalCase に変換する
     *
     * Example:
     * ```php
     * that(pascal_case('this_is_a_pen'))->isSame('ThisIsAPen');
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
if (function_exists("ryunosuke\\Functions\\pascal_case") && !defined("ryunosuke\\Functions\\pascal_case")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\pascal_case", "ryunosuke\\Functions\\pascal_case");
}

if (!isset($excluded_functions["snake_case"]) && (!function_exists("ryunosuke\\Functions\\snake_case") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\snake_case"))->isInternal()))) {
    /**
     * snake_case に変換する
     *
     * Example:
     * ```php
     * that(snake_case('ThisIsAPen'))->isSame('this_is_a_pen');
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
if (function_exists("ryunosuke\\Functions\\snake_case") && !defined("ryunosuke\\Functions\\snake_case")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\snake_case", "ryunosuke\\Functions\\snake_case");
}

if (!isset($excluded_functions["chain_case"]) && (!function_exists("ryunosuke\\Functions\\chain_case") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\chain_case"))->isInternal()))) {
    /**
     * chain-case に変換する
     *
     * Example:
     * ```php
     * that(chain_case('ThisIsAPen'))->isSame('this-is-a-pen');
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
if (function_exists("ryunosuke\\Functions\\chain_case") && !defined("ryunosuke\\Functions\\chain_case")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\chain_case", "ryunosuke\\Functions\\chain_case");
}

if (!isset($excluded_functions["namespace_split"]) && (!function_exists("ryunosuke\\Functions\\namespace_split") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\namespace_split"))->isInternal()))) {
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
     * that(namespace_split('ns\\hoge'))->isSame(['ns', 'hoge']);
     * that(namespace_split('hoge'))->isSame(['', 'hoge']);
     * that(namespace_split('ns\\'))->isSame(['ns', '']);
     * that(namespace_split('\\hoge'))->isSame(['', 'hoge']);
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
if (function_exists("ryunosuke\\Functions\\namespace_split") && !defined("ryunosuke\\Functions\\namespace_split")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\namespace_split", "ryunosuke\\Functions\\namespace_split");
}

if (!isset($excluded_functions["html_strip"]) && (!function_exists("ryunosuke\\Functions\\html_strip") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\html_strip"))->isInternal()))) {
    /**
     * html の空白類を除去して minify する
     *
     * 文字列的ではなく DOM 的に行うのでおかしな部分 html を食わせると意図しない結果になる可能性がある。
     * その副作用として属性のクオートやタグ内空白は全て正規化される。
     *
     * html コメントも削除される。
     * また、空白が意味を持つタグ（textarea, pre）は対象にならない。
     * さらに、php を含むような html （テンプレート）の php タグは一切の対象外となる。
     *
     * これらの挙動の一部はオプションで指定が可能。
     *
     * Example:
     * ```php
     * // e.g. id が " でクオートされている
     * // e.g. class のクオートが " になっている
     * // e.g. タグ内空白（id, class の間隔等）がスペース1つになっている
     * // e.g. php タグは一切変更されていない
     * // e.g. textarea は保持されている
     * that(html_strip("<span  id=id  class='c1  c2  c3'><?= '<hoge>  </hoge>' ?> a  b  c </span> <pre> a  b  c </pre>"))->isSame('<span id="id" class="c1  c2  c3"><?= \'<hoge>  </hoge>\' ?> a b c </span><pre> a  b  c </pre>');
     * ```
     *
     * @param string $html html 文字列
     * @param array $options オプション配列
     * @return string 空白除去された html 文字列
     */
    function html_strip($html, $options = [])
    {
        $options += [
            'error-level'    => E_USER_ERROR, // エラー時の報告レベル
            'encoding'       => 'UTF-8',      // html のエンコーディング
            'escape-phpcode' => true,         // php タグを退避するか
            'html-comment'   => true,         // html コメントも対象にするか
            'ignore-tags'    => [
                // 空白を除去しない特別タグ
                'pre',      // html の仕様でそのまま表示
                'textarea', // html の仕様...なのかスタイルなのかは分からないが普通はそのまま表示だろう
                'script',   // type が js とは限らない。そもそも js だとしても下手にいじるのは怖すぎる
                'style',    // 同上
            ],
        ];

        $preserving = unique_string($html, 64, range('a', 'z'));
        $mapping = [];

        if ($options['escape-phpcode']) {
            $mapping = [];
            $html = strip_php($html, [
                'replacer'       => $preserving,
                'trailing_break' => false,
            ], $mapping);
        }

        // xml 宣言がないとマルチバイト文字が html エンティティになってしまうし documentElement がないと <p> が自動付与されてしまう
        $docTag = "root-$preserving";
        $mapping["<$docTag>"] = '';
        $mapping["</$docTag>"] = '';
        $html = "<?xml encoding=\"{$options['encoding']}\"><$docTag>$html</$docTag>";

        // dom 化
        libxml_clear_errors();
        $current = libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOXMLDECL);
        if ($options['error-level']) {
            // http://www.xmlsoft.org/html/libxml-xmlerror.html
            $nohandling = [];
            $nohandling[] = 801;
            if (!$options['escape-phpcode']) {
                $nohandling[] = 46;
            }
            foreach (libxml_get_errors() as $error) {
                if (!in_array($error->code, $nohandling, true)) {
                    trigger_error($error->code . ': ' . $error->message, $options['error-level']);
                }
            }
        }
        libxml_use_internal_errors($current);

        $xpath = new \DOMXPath($dom);

        if ($options['html-comment']) {
            /** @var \DOMComment[] $comments */
            $comments = iterator_to_array($xpath->query('//comment()'), true);
            foreach ($comments as $comment) {
                $comment->parentNode->removeChild($comment);
            }
            $dom->documentElement->normalize();
        }

        /** @var \DOMText[] $texts */
        $texts = iterator_to_array($xpath->query('//text()'), true);
        $texts = array_values(array_filter($texts, function (\DOMNode $node) use ($options) {
            while ($node = $node->parentNode) {
                if (in_array($node->nodeName, $options['ignore-tags'], true)) {
                    return false;
                }
            }
            return true;
        }));
        // @see https://developer.mozilla.org/ja/docs/Web/API/Document_Object_Model/Whitespace
        foreach ($texts as $n => $text) {
            // 連続空白の正規化
            $text->data = preg_replace("#[\t\n\r ]+#u", " ", $text->data);

            // 空白の直後に他の空白がある場合は (2 つが別々なインライン要素をまたぐ場合も含めて) 無視
            if (($next = $texts[$n + 1] ?? null) && ($text->data[-1] ?? null) === ' ') {
                $next->data = ltrim($next->data, "\t\n\r ");
            }

            // 行頭と行末の一連の空白が削除される
            $prev = $text->previousSibling ?? $text->parentNode->previousSibling;
            if (!$prev || in_array($prev->nodeName, $options['ignore-tags'], true)) {
                $text->data = ltrim($text->data, "\t\n\r ");
            }
            $next = $text->nextSibling ?? $text->parentNode->nextSibling;
            if (!$next || in_array($next->nodeName, $options['ignore-tags'], true)) {
                $text->data = rtrim($text->data, "\t\n\r ");
            }
        }
        return trim(strtr($dom->saveHTML($dom->documentElement), $mapping), "\t\n\r ");
    }
}
if (function_exists("ryunosuke\\Functions\\html_strip") && !defined("ryunosuke\\Functions\\html_strip")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\html_strip", "ryunosuke\\Functions\\html_strip");
}

if (!isset($excluded_functions["html_attr"]) && (!function_exists("ryunosuke\\Functions\\html_attr") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\html_attr"))->isInternal()))) {
    /**
     * 配列を html の属性文字列に変換する
     *
     * data-* や style, 論理属性など、全てよしなに変換して文字列で返す。
     * 返り値の文字列はエスケープが施されており、基本的にはそのまま html に埋め込んで良い。
     * （オプション次第では危険だったり乱れたりすることはある）。
     *
     * separator オプションを指定すると属性の区切り文字を指定できる。
     * 大抵の場合は半角スペースであり、少し特殊な場合に改行文字を指定するくらいだろう。
     * ただし、この separator に null を与えると文字列ではなく生の配列で返す。
     * この配列は `属性名 => 属性値` な生の配列であり、エスケープも施されていない。
     * $options 自体に文字列を与えた場合は separator 指定とみなされる。
     *
     * 属性の変換ルールは下記。
     *
     * - 属性名が数値の場合は属性としては生成されない
     * - 属性名は camelCase -> cahin-case の変換が行われる
     * - 値が null の場合は無条件で無視される
     *     - 下記 false との違いは「配列返しの場合に渡ってくるか？」である（null は無条件フィルタなので配列返しでも渡ってこない）
     * - 値が true の場合は論理属性とみなし値なしで生成される
     * - 値が false の場合は論理属性とみなし、 属性としては生成されない
     * - 値が配列の場合は ","（カンマ）で結合される
     *     - これは観測範囲内でカンマ区切りが多いため（srcset, accept など）。属性によってはカンマが適切ではない場合がある
     *     - 更にその配列が文字キーを持つ場合、キーが "=" で結合される
     *         - これは観測範囲内で = 区切りが多いため（viewport など）。属性によっては = が適切ではない場合がある
     * - 値が配列で属性名が class, style, data の場合は下記の特殊な挙動を示す
     *     - class: 半角スペースで結合される
     *         - キーは無視される
     *     - style: キーが css 名、値が css 値として ";" で結合される
     *         - キーは cahin-case に変換される
     *         - キーが数値の場合は値がそのまま追加される
     *         - 値が配列の場合は半角スペースで結合される
     *     - data-: キーが data 名、値が data 値として data 属性になる
     *         - キーは cahin-case に変換される
     *         - 値が真偽値以外のスカラーの場合はそのまま、非スカラー||真偽値の場合は json で埋め込まれる
     *             - これは jQuery において json をよしなに扱うことができるため
     *
     * ※ 上記における「配列」とは iterable を指すが、toString を実装した iterable なオブジェクトは toString が優先され、文字列とみなされる
     *
     * 複雑に見えるが「よしなに」やってくれると考えて良い。
     * 配列や真偽値で分岐が大量にあるが、大前提として「string だった場合は余計なことはしない」がある。
     * ので迷ったり予期しない結果の場合は呼び出し側で文字列化して呼べば良い。
     *
     * Example:
     * ```php
     * that(html_attr([
     *     // camelCase は camel-case になる
     *     'camelCase' => '<value>',
     *     // true は論理属性 true とみなし、値なし属性になる
     *     'checked'   => true,
     *     // false は論理属性 false とみなし、属性として現れない
     *     'disabled'  => false,
     *     // null は無条件で無視され、属性として現れない
     *     'readonly'  => null,
     *     // 配列はカンマで結合される
     *     'srcset'    => [
     *         'hoge.jpg 1x',
     *         'fuga.jpg 2x',
     *     ],
     *     // 連想配列は = で結合される
     *     'content'   => [
     *         'width' => 'device-width',
     *         'scale' => '1.0',
     *     ],
     *     // class はスペースで結合される
     *     'class'     => ['hoge', 'fuga'],
     *     // style 原則的に proerty:value; とみなす
     *     'style'     => [
     *         'color'           => 'red',
     *         'backgroundColor' => 'white',      // camel-case になる
     *         'margin'          => [1, 2, 3, 4], // スペースで結合される
     *         'opacity:0.5',                     // 直値はそのまま追加される
     *     ],
     *     // data- はその分属性が生える
     *     'data-'     => [
     *         'camelCase' => 123,
     *         'hoge'      => false,        // 真偽値は文字列として埋め込まれる
     *         'fuga'      => "fuga",       // 文字列はそのまま文字列
     *         'piyo'      => ['a' => 'A'], // 非スカラー以外は json になる
     *     ],
     * ], ['separator' => "\n"]))->is('camel-case="&lt;value&gt;"
     * checked
     * srcset="hoge.jpg 1x,fuga.jpg 2x"
     * content="width=device-width,scale=1.0"
     * class="hoge fuga"
     * style="color:red;background-color:white;margin:1 2 3 4;opacity:0.5"
     * data-camel-case="123"
     * data-hoge="false"
     * data-fuga="fuga"
     * data-piyo="{&quot;a&quot;:&quot;A&quot;}"');
     * ```
     *
     * @param iterable $array 属性配列
     * @param string|array|null $options オプション配列
     * @return string|array 属性文字列 or 属性配列
     */
    function html_attr($array, $options = [])
    {
        if (!is_array($options)) {
            $options = ['separator' => $options];
        }

        $options += [
            'quote'     => '"',  // 属性のクオート文字
            'separator' => " ",  // 属性の区切り文字
            'chaincase' => true, // 属性名, data などキーで camelCase を chain-case に変換するか
        ];

        $chaincase = static function ($string) use ($options) {
            if ($options['chaincase']) {
                return chain_case($string);
            }
            return $string;
        };
        $is_iterable = static function ($value) {
            if (is_array($value)) {
                return true;
            }
            if (is_object($value) && $value instanceof \Traversable && !method_exists($value, '__toString')) {
                return true;
            }
            return false;
        };
        $implode = static function ($glue, $iterable) use ($is_iterable) {
            if (!$is_iterable($iterable)) {
                return $iterable;
            }
            if (is_array($iterable)) {
                return implode($glue, $iterable);
            }
            return implode($glue, iterator_to_array($iterable));
        };

        $attrs = [];
        foreach ($array as $k => $v) {
            if ($v === null) {
                continue;
            }

            $k = $chaincase($k);
            assert(!isset($attrs[$k]));

            if (strpbrk($k, "\r\n\t\f '\"<>/=") !== false) {
                throw new \UnexpectedValueException('found invalid charactor as attribute name');
            }

            switch ($k) {
                default:
                    if ($is_iterable($v)) {
                        $tmp = [];
                        foreach ($v as $name => $value) {
                            $name = (is_string($name) ? "$name=" : '');
                            $value = $implode(';', $value);
                            $tmp[] = $name . $value;
                        }
                        $v = implode(',', $tmp);
                    }
                    break;
                case 'class':
                    $v = $implode(' ', $v);
                    break;
                case 'style':
                    if ($is_iterable($v)) {
                        $tmp = [];
                        foreach ($v as $property => $value) {
                            // css において CamelCace は意味を為さないのでオプションによらず強制的に chain-case にする
                            $property = (is_string($property) ? chain_case($property) . ":" : '');
                            $value = $implode(' ', $value);
                            $tmp[] = rtrim($property . $value, ';');
                        }
                        $v = implode(';', $tmp);
                    }
                    break;
                case 'data-':
                    if ($is_iterable($v)) {
                        foreach ($v as $name => $data) {
                            $name = $chaincase($name);
                            $data = is_scalar($data) && !is_bool($data) ? $data : json_encode($data);
                            $attrs[$k . $name] = $data;
                        }
                        continue 2;
                    }
                    break;
            }

            $attrs[$k] = is_bool($v) ? $v : (string) $v;
        }

        if ($options['separator'] === null) {
            return $attrs;
        }

        $result = [];
        foreach ($attrs as $name => $value) {
            if (is_int($name)) {
                continue;
            }
            if ($value === false) {
                continue;
            }
            elseif ($value === true) {
                $result[] = htmlspecialchars($name, ENT_QUOTES);
            }
            else {
                $result[] = htmlspecialchars($name, ENT_QUOTES) . '=' . $options['quote'] . htmlspecialchars($value, ENT_QUOTES) . $options['quote'];
            }
        }
        return implode($options['separator'], $result);
    }
}
if (function_exists("ryunosuke\\Functions\\html_attr") && !defined("ryunosuke\\Functions\\html_attr")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\html_attr", "ryunosuke\\Functions\\html_attr");
}

if (!isset($excluded_functions["htmltag"]) && (!function_exists("ryunosuke\\Functions\\htmltag") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\htmltag"))->isInternal()))) {
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
     * that(
     *     htmltag('a#hoge.c1.c2[name=hoge\[\]][href="http://hoge"][hidden]'))
     *     ->isSame('<a id="hoge" class="c1 c2" name="hoge[]" href="http://hoge" hidden></a>'
     * );
     * // ペア配列を与えるとコンテント文字列になる
     * that(
     *     htmltag(['a.c1#hoge.c2[name=hoge\[\]][href="http://hoge"][hidden]' => "this is text's content"]))
     *     ->isSame('<a id="hoge" class="c1 c2" name="hoge[]" href="http://hoge" hidden>this is text&#039;s content</a>'
     * );
     * // ネストした配列を与えると再帰される
     * that(
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
     *     ]))
     *     ->isSame('<div id="wrapper"><b class="class1">&lt;plain&gt;</b><b class="class2">&lt;plain1&gt;<s>&lt;strike&gt;</s>&lt;plain2&gt;</b></div>'
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

        $html = static fn($string) => htmlspecialchars($string, ENT_QUOTES);

        $build = static function ($selector, $content, $escape) use ($html) {
            $p = min(strpos_array($selector, ['#', '.', '[', '{']) ?: [strlen($selector)]);
            $tag = substr($selector, 0, $p);
            if (!strlen($tag)) {
                throw new \InvalidArgumentException('tagname is empty.');
            }
            $attrs = css_selector(substr($selector, $p));
            if (isset($attrs['class'])) {
                $attrs['class'] = implode(' ', $attrs['class']);
            }
            foreach ($attrs as $k => $v) {
                if ($v === false) {
                    unset($attrs[$k]);
                    continue;
                }
                elseif ($v === true) {
                    $v = $html($k);
                }
                elseif (is_array($v)) {
                    $v = 'style="' . array_sprintf($v, fn($style, $key) => is_int($key) ? $style : "$key:$style", ';') . '"';
                }
                else {
                    $v = sprintf('%s="%s"', $html($k), $html(preg_replace('#^([\"\'])|([^\\\\])([\"\'])$#u', '$2', $v)));
                }
                $attrs[$k] = $v;
            }

            preg_match('#(\s*)(.+)(\s*)#u', $tag, $m);
            [, $prefix, $tag, $suffix] = $m;
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
if (function_exists("ryunosuke\\Functions\\htmltag") && !defined("ryunosuke\\Functions\\htmltag")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\htmltag", "ryunosuke\\Functions\\htmltag");
}

if (!isset($excluded_functions["css_selector"]) && (!function_exists("ryunosuke\\Functions\\css_selector") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\css_selector"))->isInternal()))) {
    /**
     * CSS セレクタ文字をパースして配列で返す
     *
     * 包含などではない属性セレクタを与えると属性として認識する。
     * 独自仕様として・・・
     *
     * - [!attr]: 否定属性として false を返す
     * - {styles}: style 属性とみなす
     *
     * がある。
     *
     * Example:
     * ```php
     * that(css_selector('#hoge.c1.c2[name=hoge\[\]][href="http://hoge"][hidden][!readonly]{width:123px;height:456px}'))->is([
     *     'id'       => 'hoge',
     *     'class'    => ['c1', 'c2'],
     *     'name'     => 'hoge[]',
     *     'href'     => 'http://hoge',
     *     'hidden'   => true,
     *     'readonly' => false,
     *     'style'    => [
     *         'width'  => '123px',
     *         'height' => '456px',
     *     ],
     * ]);
     * ```
     *
     * @param string $selector CSS セレクタ
     * @return array 属性配列
     */
    function css_selector($selector)
    {
        $id = '';
        $classes = [];
        $styles = [];
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
            if (!$escaping && $char === '{') {
                $context = $char;
                $styles[] = '';
                continue;
            }
            if (!$escaping && $char === ';') {
                $styles[] = '';
                continue;
            }
            if (!$escaping && $char === '}') {
                $context = null;
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

            if ($context === '#') {
                $id .= $char;
                continue;
            }
            if ($context === '.') {
                $classes[count($classes) - 1] .= $char;
                continue;
            }
            if ($context === '{') {
                $styles[count($styles) - 1] .= $char;
                continue;
            }
            if ($context === '[') {
                $attrs[count($attrs) - 1] .= $char;
                continue;
            }
        }

        $attrkv = [];
        if (strlen($id)) {
            $attrkv['id'] = $id;
        }
        if ($classes) {
            $attrkv['class'] = $classes;
        }
        foreach ($styles as $style) {
            $declares = array_filter(array_map('trim', explode(';', $style)), 'strlen');
            foreach ($declares as $declare) {
                [$k, $v] = array_map('trim', explode(':', $declare, 2)) + [1 => null];
                if ($v === null) {
                    throw new \InvalidArgumentException("[$k] is empty.");
                }
                $attrkv['style'][$k] = $v;
            }
        }
        foreach ($attrs as $attr) {
            [$k, $v] = explode('=', $attr, 2) + [1 => true];
            if (array_key_exists($k, $attrkv)) {
                throw new \InvalidArgumentException("[$k] is dumplicated.");
            }
            if ($k[0] === '!') {
                $k = substr($k, 1);
                $v = false;
            }
            $attrkv[$k] = is_string($v) ? json_decode($v) ?? $v : $v;
        }

        return $attrkv;
    }
}
if (function_exists("ryunosuke\\Functions\\css_selector") && !defined("ryunosuke\\Functions\\css_selector")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\css_selector", "ryunosuke\\Functions\\css_selector");
}

if (!isset($excluded_functions["build_uri"]) && (!function_exists("ryunosuke\\Functions\\build_uri") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\build_uri"))->isInternal()))) {
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
     * that(build_uri([
     *     'scheme'   => 'http',
     *     'user'     => 'user',
     *     'pass'     => 'pass',
     *     'host'     => 'localhost',
     *     'port'     => '80',
     *     'path'     => '/path/to/file',
     *     'query'    => ['id' => 1],
     *     'fragment' => 'hash',
     * ]))->isSame('http://user:pass@localhost:80/path/to/file?id=1#hash');
     * // 一部だけ指定
     * that(build_uri([
     *     'scheme'   => 'http',
     *     'host'     => 'localhost',
     *     'path'     => '/path/to/file',
     *     'fragment' => 'hash',
     * ]))->isSame('http://localhost/path/to/file#hash');
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

        $parts['user'] = rawurlencode($parts['user']);
        $parts['pass'] = rawurlencode($parts['pass']);
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
if (function_exists("ryunosuke\\Functions\\build_uri") && !defined("ryunosuke\\Functions\\build_uri")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\build_uri", "ryunosuke\\Functions\\build_uri");
}

if (!isset($excluded_functions["parse_uri"]) && (!function_exists("ryunosuke\\Functions\\parse_uri") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\parse_uri"))->isInternal()))) {
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
     * that(parse_uri('http://user:pass@localhost:80/path/to/file?id=1#hash'))->is([
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
     * that(parse_uri('localhost/path/to/file', [
     *     'scheme'   => 'http', // scheme のデフォルト値
     *     'user'     => 'user', // user のデフォルト値
     *     'port'     => '8080', // port のデフォルト値
     *     'host'     => 'hoge', // host のデフォルト値
     * ]))->is([
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

        // 諸々調整（認証エンコード、IPv6、パス / の正規化、クエリ配列化）
        $parts['user'] = rawurldecode($parts['user']);
        $parts['pass'] = rawurldecode($parts['pass']);
        $parts['host'] = preg_splice('#^\\[(.+)\\]$#', '$1', $parts['host']);
        $parts['path'] = concat('/', ltrim($parts['path'], '/'));
        if (is_string($parts['query'])) {
            parse_str($parts['query'], $parts['query']);
        }

        return $parts;
    }
}
if (function_exists("ryunosuke\\Functions\\parse_uri") && !defined("ryunosuke\\Functions\\parse_uri")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\parse_uri", "ryunosuke\\Functions\\parse_uri");
}

if (!isset($excluded_functions["build_query"]) && (!function_exists("ryunosuke\\Functions\\build_query") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\build_query"))->isInternal()))) {
    /**
     * 数値キーを削除する http_build_query
     *
     * php の世界において配列のクエリ表現は `var[]=1&var[]=2` で事足りる。
     * しかし http_build_query では数値キーでも必ず `var[0]=1&var[1]=2` になる。
     * それはそれで正しいし、他言語との連携が必要な場合はそうせざるを得ない状況もあるが、単純に php だけで配列を表したい場合は邪魔だし文字長が長くなる。
     * この関数を使うと数値キーを削除し、`var[]=1&var[]=2` のようなクエリ文字列を生成できる。
     *
     * シグネチャは http_build_query と同じで、 $numeric_prefix に数値的文字列を与えたときのみ動作が変化する。
     * （$numeric_prefix の意味を考えればこの引数に数値的文字列を与える意味は皆無だろうので流用している）。
     *
     * - 1 を与えると最前列を残して [] (%5B%5D) が置換される
     * - 2 を与えると最前列とその右を残して [] (%5B%5D) が置換される
     * - 要するに正数を与えると「abs(n) 個を残して [] (%5B%5D) を置換する」という指定になる
     * - -1 を与えると最後尾の [] (%5B%5D) が置換される
     * - -2 を与えると最後尾とその左の [] (%5B%5D) が置換される
     * - 要するに負数を与えると「右から abs(n) 個の [] (%5B%5D) を置換する」という指定になる
     *
     * この仕様は `v[][]=1&v[][]=2` のようなときにおいしくないためである。
     * これは `$v=[[1], [2]]` のような値になるが、この場合 `$v=[[1, 2]]` という値が欲しい、という事が多い。
     * そのためには `v[0][]=1&v[0][]=2` のようにする必要があるための数値指定である。
     *
     * @param array|object $data クエリデータ
     * @param string|int|null $numeric_prefix 数値キープレフィックス
     * @param string|null $arg_separator クエリセパレータ
     * @param int $encoding_type エンコードタイプ
     * @return string クエリ文字列
     */
    function build_query($data, $numeric_prefix = null, $arg_separator = null, $encoding_type = \PHP_QUERY_RFC1738)
    {
        $arg_separator ??= ini_get('arg_separator.output');

        if ($numeric_prefix === null || ctype_digit(trim($numeric_prefix, '-+'))) {
            $REGEX = '%5B\d+%5D';
            $NOSEQ = '%5B%5D';
            $numeric_prefix = $numeric_prefix === null ? null : (int) $numeric_prefix;
            $query = http_build_query($data, '', $arg_separator, $encoding_type);
            // 0は置換しないを意味する
            if ($numeric_prefix === 0) {
                return $query;
            }
            // null は無制限置換
            if ($numeric_prefix === null) {
                return preg_replace("#($REGEX)#u", $NOSEQ, $query);
            }
            // 正数は残す数とする
            if ($numeric_prefix > 0) {
                return preg_replace_callback("#(?:$REGEX)+#u", function ($m) use ($numeric_prefix) {
                    $braces = explode('%5D', $m[0]);
                    foreach (array_slice($braces, $numeric_prefix, null, true) as $n => $brace) {
                        $braces[$n] = rtrim($brace, '0123456789');
                    }
                    return implode('%5D', $braces);
                }, $query);
            }
            // 負数は後ろから n 個目まで
            $pattern = str_repeat("($REGEX)?", abs($numeric_prefix) - 1);
            return preg_replace_callback("#$pattern($REGEX=)#u", function ($m) use ($NOSEQ) {
                return str_repeat($NOSEQ, count(array_filter($m, 'strlen')) - 2) . "$NOSEQ=";
            }, $query);
        }
        else {
            return http_build_query($data, $numeric_prefix ?? '', $arg_separator, $encoding_type);
        }
    }
}
if (function_exists("ryunosuke\\Functions\\build_query") && !defined("ryunosuke\\Functions\\build_query")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\build_query", "ryunosuke\\Functions\\build_query");
}

if (!isset($excluded_functions["parse_query"]) && (!function_exists("ryunosuke\\Functions\\parse_query") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\parse_query"))->isInternal()))) {
    /**
     * parse_str の返り値版
     *
     * 標準の parse_str は参照で受ける謎シグネチャなのでそれを返り値に変更したもの。
     *
     * @param string $query クエリ文字列
     * @return array クエリのパース結果配列
     */
    function parse_query($query)
    {
        parse_str($query, $result);
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\parse_query") && !defined("ryunosuke\\Functions\\parse_query")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\parse_query", "ryunosuke\\Functions\\parse_query");
}

if (!isset($excluded_functions["ini_export"]) && (!function_exists("ryunosuke\\Functions\\ini_export") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\ini_export"))->isInternal()))) {
    /**
     * 連想配列を INI 的文字列に変換する
     *
     * Example:
     * ```php
     * that(ini_export(['a' => 1, 'b' => 'B', 'c' => PHP_SAPI]))->is('a = 1
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
            return array_sprintf($iniarray, fn($v, $k) => "[$k]\n{$generate($v)}\n", "\n");
        }

        return $generate($iniarray) . "\n";
    }
}
if (function_exists("ryunosuke\\Functions\\ini_export") && !defined("ryunosuke\\Functions\\ini_export")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\ini_export", "ryunosuke\\Functions\\ini_export");
}

if (!isset($excluded_functions["ini_import"]) && (!function_exists("ryunosuke\\Functions\\ini_import") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\ini_import"))->isInternal()))) {
    /**
     * INI 的文字列を連想配列に変換する
     *
     * Example:
     * ```php
     * that(ini_import("
     * a = 1
     * b = 'B'
     * c = PHP_VERSION
     * "))->is(['a' => 1, 'b' => 'B', 'c' => PHP_VERSION]);
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
if (function_exists("ryunosuke\\Functions\\ini_import") && !defined("ryunosuke\\Functions\\ini_import")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\ini_import", "ryunosuke\\Functions\\ini_import");
}

if (!isset($excluded_functions["csv_export"]) && (!function_exists("ryunosuke\\Functions\\csv_export") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\csv_export"))->isInternal()))) {
    /**
     * 連想配列の配列を CSV 的文字列に変換する
     *
     * CSV ヘッダ行は全連想配列のキーの共通項となる。
     * 順番には依存しないが、余計な要素があってもそのキーはヘッダには追加されないし、データ行にも含まれない。
     * ただし、オプションで headers が与えられた場合はそれを使用する。
     * この headers オプションに連想配列を与えるとヘッダ文字列変換になる（[key => header] で「key を header で吐き出し」となる）。
     * 数値配列を与えると単純に順序指定での出力指定になるが、ヘッダ行が出力されなくなる。
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
     * that(csv_export($csvarrays))->is("a,b,c
     * A1,B1,C1
     * A2,B2,C2
     * A3,B3,C3
     * ");
     *
     * // ヘッダを指定できる
     * that(csv_export($csvarrays, [
     *     'headers' => ['a' => 'A', 'c' => 'C'], // a と c だけを出力＋ヘッダ文字変更
     * ]))->is("A,C
     * A1,C1
     * A2,C2
     * A3,C3
     * ");
     *
     * // ヘッダ行を出さない
     * that(csv_export($csvarrays, [
     *     'headers' => ['a', 'c'], // a と c だけを出力＋ヘッダ行なし
     * ]))->is("A1,C1
     * A2,C2
     * A3,C3
     * ");
     *
     * // structure:true で配列も扱える
     * that(csv_export([
     *     ['scalar' => '123', 'list' => ['list11', 'list12'], 'hash' => ['a' => 'hash1A', 'b' => 'hash1B']],
     *     ['scalar' => '456', 'list' => ['list21', 'list22'], 'hash' => ['a' => 'hash2A', 'b' => 'hash2B']],
     * ], [
     *     'structure' => true,
     * ]))->is("scalar,list[],list[],hash[a],hash[b]
     * 123,list11,list12,hash1A,hash1B
     * 456,list21,list22,hash2A,hash2B
     * ");
     * ```
     *
     * @param array $csvarrays 連想配列の配列
     * @param array $options オプション配列。fputcsv の第3引数以降もここで指定する
     * @return string|int CSV 的文字列。output オプションを渡した場合は書き込みバイト数
     */
    function csv_export($csvarrays, $options = [])
    {
        $options += [
            'delimiter' => ',',
            'enclosure' => '"',
            'escape'    => '\\',
            'encoding'  => mb_internal_encoding(),
            'headers'   => null,
            'structure' => false,
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
            $size = call_safely(function ($fp, $csvarrays, $delimiter, $enclosure, $escape, $encoding, $headers, $structure, $callback) {
                $size = 0;
                $mb_internal_encoding = mb_internal_encoding();
                if ($structure) {
                    foreach ($csvarrays as $n => $array) {
                        $query = strtr(http_build_query($array, ''), ['%5B' => '[', '%5D' => ']']);
                        $csvarrays[$n] = array_map('rawurldecode', str_array(explode('&', $query), '=', true));
                    }
                }
                if (!$headers) {
                    $tmp = [];
                    foreach ($csvarrays as $array) {
                        // この関数は積集合のヘッダを出すと定義してるが、構造化の場合は和集合で出す
                        if ($structure) {
                            $tmp += $array;
                        }
                        else {
                            $tmp = array_intersect_key($tmp ?: $array, $array);
                        }
                    }
                    $keys = array_keys($tmp);
                    if ($structure) {
                        $tmp = [];
                        for ($i = 0, $l = count($keys); $i < $l; $i++) {
                            $key = $keys[$i];
                            if (isset($tmp[$key])) {
                                continue;
                            }
                            $tmp[$key] = true;
                            $p = strrpos($key, '[');
                            if ($p !== false) {
                                $plain = substr($key, 0, $p + 1);
                                for ($j = $i + 1; $j < $l; $j++) {
                                    if (starts_with($keys[$j], $plain)) {
                                        $tmp[$keys[$j]] = true;
                                    }
                                }
                            }
                        }
                        $keys = array_keys($tmp);
                    }
                    $headers = is_array($headers) ? $keys : array_combine($keys, $keys);
                }
                if (!is_hasharray($headers)) {
                    $headers = array_combine($headers, $headers);
                }
                else {
                    $headerline = $headers;
                    if ($encoding !== $mb_internal_encoding) {
                        mb_convert_variables($encoding, $mb_internal_encoding, $headerline);
                    }
                    if ($structure) {
                        $headerline = array_map(fn($header) => preg_replace('#\[\d+]$#imu', '[]', $header), $headerline);
                    }
                    $size += fputcsv($fp, $headerline, $delimiter, $enclosure, $escape);
                }
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
            }, $fp, $csvarrays, $options['delimiter'], $options['enclosure'], $options['escape'], $options['encoding'], $options['headers'], $options['structure'], $options['callback']);
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
if (function_exists("ryunosuke\\Functions\\csv_export") && !defined("ryunosuke\\Functions\\csv_export")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\csv_export", "ryunosuke\\Functions\\csv_export");
}

if (!isset($excluded_functions["csv_import"]) && (!function_exists("ryunosuke\\Functions\\csv_import") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\csv_import"))->isInternal()))) {
    /**
     * CSV 的文字列を連想配列の配列に変換する
     *
     * 1行目をヘッダ文字列とみなしてそれをキーとした連想配列の配列を返す。
     * ただし、オプションで headers が与えられた場合はそれを使用する。
     * この headers オプションはヘッダフィルタも兼ねる（[n => header] で「n 番目フィールドを header で取り込み」となる）。
     * 入力にヘッダがありかつ headers に連想配列が渡された場合はフィルタ兼読み換えとなる（Example を参照）。
     *
     * structure オプションが渡された場合は query like なヘッダーで配列になる。
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
     * that(csv_import("
     * a,b,c
     * A1,B1,C1
     * A2,B2,C2
     * A3,B3,C3
     * "))->is([
     *     ['a' => 'A1', 'b' => 'B1', 'c' => 'C1'],
     *     ['a' => 'A2', 'b' => 'B2', 'c' => 'C2'],
     *     ['a' => 'A3', 'b' => 'B3', 'c' => 'C3'],
     * ]);
     *
     * // ヘッダを指定できる
     * that(csv_import("
     * A1,B1,C1
     * A2,B2,C2
     * A3,B3,C3
     * ", [
     *     'headers' => [0 => 'a', 2 => 'c'], // 1がないので1番目のフィールドを読み飛ばしつつ、0, 2 は "a", "c" として取り込む
     * ]))->is([
     *     ['a' => 'A1', 'c' => 'C1'],
     *     ['a' => 'A2', 'c' => 'C2'],
     *     ['a' => 'A3', 'c' => 'C3'],
     * ]);
     *
     * // ヘッダありで連想配列で指定するとキーの読み換えとなる（指定しなければ読み飛ばしも行える）
     * that(csv_import("
     * a,b,c
     * A1,B1,C1
     * A2,B2,C2
     * A3,B3,C3
     * ", [
     *     'headers' => ['a' => 'hoge', 'c' => 'piyo'], // a は hoge, c は piyo で読み込む。 b は指定がないので飛ばされる
     * ]))->is([
     *     ['hoge' => 'A1', 'piyo' => 'C1'],
     *     ['hoge' => 'A2', 'piyo' => 'C2'],
     *     ['hoge' => 'A3', 'piyo' => 'C3'],
     * ]);
     *
     * // structure:true で配列も扱える
     * that(csv_import("
     * scalar,list[],list[],hash[a],hash[b]
     * 123,list11,list12,hash1A,hash1B
     * 456,list21,list22,hash2A,hash2B
     * ", [
     *     'structure' => true,
     * ]))->is([
     *     ['scalar' => '123', 'list' => ['list11', 'list12'], 'hash' => ['a' => 'hash1A', 'b' => 'hash1B']],
     *     ['scalar' => '456', 'list' => ['list21', 'list22'], 'hash' => ['a' => 'hash2A', 'b' => 'hash2B']],
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
            'structure' => false,
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
            return call_safely(function ($fp, $delimiter, $enclosure, $escape, $encoding, $headers, $headermap, $structure, $callback) {
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
                    if ($structure) {
                        $query = [];
                        foreach ($headers as $i => $header) {
                            $query[] = $header . "=" . rawurlencode($row[$i]);
                        }
                        parse_str(implode('&', $query), $row);
                        // csv の仕様上、空文字を置かざるを得ないが、数値配列の場合は空にしたいことがある
                        $row = array_map_recursive($row, function ($v) {
                            if (is_array($v) && is_indexarray($v)) {
                                return array_values(array_filter($v, function ($v) {
                                    if (is_array($v)) {
                                        $v = implode('', array_flatten($v));
                                    }
                                    return strlen($v);
                                }));
                            }
                            return $v;
                        }, true, true);
                    }
                    else {
                        $row = array_combine($headers, array_intersect_key($row, $headers));
                    }
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
            }, $fp, $options['delimiter'], $options['enclosure'], $options['escape'], $options['encoding'], $options['headers'], $options['headermap'], $options['structure'], $options['callback']);
        }
        finally {
            fclose($fp);
        }
    }
}
if (function_exists("ryunosuke\\Functions\\csv_import") && !defined("ryunosuke\\Functions\\csv_import")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\csv_import", "ryunosuke\\Functions\\csv_import");
}

if (!isset($excluded_functions["json_export"]) && (!function_exists("ryunosuke\\Functions\\json_export") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\json_export"))->isInternal()))) {
    /**
     * json_encode のプロキシ関数
     *
     * 引数体系とデフォルト値を変更してある。また、エラー時に例外が飛ぶ。
     *
     * 下記の拡張オプションがある。
     *
     * - JSON_INLINE_LEVEL: PRETTY_PRINT 時に指定以上の階層をインライン化する（数値以外にパスで階層も指定できる）
     * - JSON_INLINE_SCALARLIST: PRETTY_PRINT 時にスカラーのみのリストをインライン化する
     * - JSON_INDENT: PRETTY_PRINT 時にインデント数・文字列を指定する
     * - JSON_CLOSURE: 任意のリテラルを埋め込む
     *   - クロージャの返り値がそのまま埋め込まれるので、文字列化可能な結果を返さなければならない
     *
     * JSON_ES5 を与えると JSON5 互換でエンコードされる。
     * その際下記のプションも使用可能になる。
     *
     * - JSON_TRAILING_COMMA: 末尾カンマを強制する
     * - JSON_COMMENT_PREFIX: コメントとして埋め込まれるキープレフィックスを指定する
     *   - そのキーで始まる要素が文字列なら // コメントになる
     *   - そのキーで始まる要素が配列なら /* コメントになる
     *
     * Example:
     * ```php
     * // オプションはこのように [定数 => bool] で渡す。false は指定されていないとみなされる（JSON_MAX_DEPTH 以外）
     * that(json_export(['a' => 'A', 'b' => 'B'], [
     *    JSON_PRETTY_PRINT => false,
     * ]))->is('{"a":"A","b":"B"}');
     * // json5 でコメント付きかつ末尾カンマ強制モード
     * that(json_export(['a' => 'A', '#comment' => 'this is comment', 'b' => 'B'], [
     *    JSON_ES5            => true,
     *    JSON_TRAILING_COMMA => true,
     *    JSON_COMMENT_PREFIX => '#',
     *    JSON_PRETTY_PRINT   => true,
     * ]))->is('{
     *     a: "A",
     *     // this is comment
     *     b: "B",
     * }');
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
            JSON_THROW_ON_ERROR         => true, // 標準動作はエラーすら出ずに false を返すだけ
        ];
        $es5 = array_unset($options, JSON_ES5, false);
        $comma = array_unset($options, JSON_TRAILING_COMMA, false);
        $comment = array_unset($options, JSON_COMMENT_PREFIX, null);
        $depth = array_unset($options, JSON_MAX_DEPTH, 512);
        $indent = array_unset($options, JSON_INDENT, null);
        $closure = array_unset($options, JSON_CLOSURE, false);
        $inline_level = array_unset($options, JSON_INLINE_LEVEL, 0);
        $inline_scalarlist = array_unset($options, JSON_INLINE_SCALARLIST, false);

        $option = array_sum(array_keys(array_filter($options)));

        $encode = function ($value, $parents, $objective) use (&$encode, $option, $depth, $indent, $closure, $inline_scalarlist, $inline_level, $es5, $comma, $comment) {
            $nest = count($parents);

            if ($depth < $nest) {
                throw new \ErrorException('Maximum stack depth exceeded', JSON_ERROR_DEPTH);
            }
            if ($closure && $value instanceof \Closure) {
                return $value();
            }
            if (is_object($value)) {
                if ($value instanceof \JsonSerializable) {
                    return $encode($value->jsonSerialize(), $parents, false);
                }
                return $encode(arrayval($value, false), $parents, true);
            }
            if (is_array($value)) {
                $pretty_print = $option & JSON_PRETTY_PRINT;
                $force_object = $option & JSON_FORCE_OBJECT;

                $withoutcommentarray = $value;
                if ($es5 && strlen($comment)) {
                    $withoutcommentarray = array_filter($withoutcommentarray, fn($k) => strpos("$k", $comment) === false, ARRAY_FILTER_USE_KEY);
                }

                $objective = $force_object || $objective || is_hasharray($withoutcommentarray);

                if (!$value) {
                    return $objective ? '{}' : '[]';
                }

                $inline = false;
                if ($inline_level) {
                    if (is_array($inline_level)) {
                        $inline = $inline || fnmatch_or(array_map(fn($v) => "$v.*", $inline_level), implode('.', $parents) . '.');
                    }
                    elseif (ctype_digit("$inline_level")) {
                        $inline = $inline || $inline_level <= $nest;
                    }
                    else {
                        $inline = $inline || fnmatch("$inline_level.*", implode('.', $parents) . '.');
                    }
                }
                if ($inline_scalarlist) {
                    $inline = $inline || !$objective && array_all($value, fn($v) => is_primitive($v) || $v instanceof \Closure);
                }

                $break = $indent0 = $indent1 = $indent2 = $separator = '';
                $delimiter = ',';
                if ($pretty_print && !$inline) {
                    $break = "\n";
                    $separator = ' ';
                    $indent = $indent ?: 4;
                    $indent0 = ctype_digit("$indent") ? str_repeat(' ', ($nest + 0) * $indent) : str_repeat($indent, ($nest + 0));
                    $indent1 = ctype_digit("$indent") ? str_repeat(' ', ($nest + 1) * $indent) : str_repeat($indent, ($nest + 1));
                    $indent2 = ctype_digit("$indent") ? str_repeat(' ', ($nest + 2) * $indent) : str_repeat($indent, ($nest + 2));
                }
                if ($pretty_print && $inline) {
                    $separator = ' ';
                    $delimiter = ', ';
                }

                $n = 0;
                $count = count($withoutcommentarray);
                $result = ($objective ? '{' : '[') . $break;
                foreach ($value as $k => $v) {
                    if ($es5 && strlen($comment) && strpos("$k", $comment) === 0) {
                        if (!$pretty_print) {
                            $v = (array) $v;
                        }
                        if (is_array($v)) {
                            $comments = [];
                            foreach ($v as $vv) {
                                $comments[] = "$indent2$vv";
                            }
                            $result .= "$indent1/*$break" . implode($break, $comments) . "$break$indent1*/";
                        }
                        else {
                            $comments = [];
                            foreach (preg_split('#\\R#u', $v) as $vv) {
                                $comments[] = "$indent1// $vv";
                            }
                            $result .= implode($break, $comments);
                        }
                    }
                    else {
                        $result .= $indent1;
                        if ($objective) {
                            $result .= ($es5 && preg_match("#^[a-zA-Z_$][a-zA-Z0-9_$]*$#u", $k) ? $k : json_encode("$k")) . ":$separator";
                        }
                        $result .= $encode($v, array_append($parents, $k), false);
                        if (++$n !== $count || ($comma && !$inline)) {
                            $result .= $delimiter;
                        }
                    }
                    $result .= $break;
                }
                return $result . $indent0 . ($objective ? '}' : ']');
            }

            if ($es5) {
                if (is_float($value) && is_nan($value)) {
                    return 'NaN';
                }
                if (is_float($value) && is_infinite($value) && $value > 0) {
                    return '+Infinity';
                }
                if (is_float($value) && is_infinite($value) && $value < 0) {
                    return '-Infinity';
                }
            }
            return json_encode($value, $option, $depth);
        };

        // 特別な状況（クロージャを使うとか ES5 でないとか）以外は 標準を使用したほうが遥かに速い
        if ($indent || $closure || $inline_scalarlist || $inline_level || $es5 || $comma || $comment) {
            return $encode($value, [], false);
        }
        else {
            return json_encode($value, $option, $depth);
        }
    }
}
if (function_exists("ryunosuke\\Functions\\json_export") && !defined("ryunosuke\\Functions\\json_export")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\json_export", "ryunosuke\\Functions\\json_export");
}

if (!isset($excluded_functions["json_import"]) && (!function_exists("ryunosuke\\Functions\\json_import") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\json_import"))->isInternal()))) {
    /**
     * json_decode のプロキシ関数
     *
     * 引数体系とデフォルト値を変更してある。また、エラー時に例外が飛ぶ。
     *
     * JSON_ES5 に null か true を渡すと json5 としてでデコードする（null はまず json_decode で試みる、true は json5 のみ）。
     * その場合拡張オプションとして下記がある。
     *
     * - JSON_INT_AS_STRING: 常に整数を文字列で返す
     * - JSON_FLOAT_AS_STRING: 常に小数を文字列で返す
     *
     * Example:
     * ```php
     * // オプションはこのように [定数 => bool] で渡す。false は指定されていないとみなされる（JSON_MAX_DEPTH 以外）
     * that(json_import('{"a":"A","b":"B"}', [
     *    JSON_OBJECT_AS_ARRAY => true,
     * ]))->is(['a' => 'A', 'b' => 'B']);
     *
     * // json5 が使える
     * that(json_import('{a: "A", b: "B", }'))->is(['a' => 'A', 'b' => 'B']);
     * ```
     *
     * @param string $value JSON 文字列
     * @param array $options JSON_*** をキーにした連想配列。値が false は指定されていないとみなされる
     * @return mixed decode された値
     */
    function json_import($value, $options = [])
    {
        $specials = [
            JSON_OBJECT_AS_ARRAY => true, // 個人的嗜好だが連想配列のほうが扱いやすい
            JSON_MAX_DEPTH       => 512,
            JSON_ES5             => null,
            JSON_INT_AS_STRING   => false,
            JSON_FLOAT_AS_STRING => false,
        ];
        foreach ($specials as $key => $default) {
            $specials[$key] = $options[$key] ?? $default;
            unset($options[$key]);
        }
        $specials[JSON_BIGINT_AS_STRING] = $options[JSON_BIGINT_AS_STRING] ?? false;
        if ($specials[JSON_INT_AS_STRING] || $specials[JSON_FLOAT_AS_STRING]) {
            $specials[JSON_ES5] = true;
        }

        // true でないならまず json_decode で試行（json が来るならその方が遥かに速い）
        if ($specials[JSON_ES5] === false || $specials[JSON_ES5] === null) {
            $option = array_sum(array_keys(array_filter($options)));
            $result = json_decode($value, $specials[JSON_OBJECT_AS_ARRAY], $specials[JSON_MAX_DEPTH], $option);

            // エラーが出なかったらもうその時点で返せば良い
            if (json_last_error() === JSON_ERROR_NONE) {
                return $result;
            }
            // json5 を試行しないモードならこの時点で例外
            if ($specials[JSON_ES5] === false) {
                throw new \ErrorException(json_last_error_msg(), json_last_error());
            }
        }

        // 上記を通り抜けたら json5 で試行
        $parser = new class($value) {
            private $json_string;
            private $type;
            private $begin_position;
            private $end_position;
            private $keys;
            private $values;

            public function __construct($json_string)
            {
                $this->json_string = "[$json_string]";
            }

            public function parse($options)
            {
                error_clear_last();
                $tokens = @parse_php($this->json_string, [
                    'cache' => false,
                ]);
                $error = error_get_last();
                if (strpos($error['message'] ?? '', 'Unterminated comment') !== false) {
                    throw new \ErrorException(sprintf('%s at line %d of the JSON5 data', "Unterminated block comment", $error['line']));
                }
                array_shift($tokens);

                $braces = [];
                for ($i = 0; $i < count($tokens); $i++) {
                    $token = $tokens[$i];
                    if ($token[1] === '{' || $token[1] === '[') {
                        if ($options[JSON_MAX_DEPTH] <= count($braces) + 1) {
                            throw $this->exception("Maximum stack depth exceeded", $token);
                        }
                        $braces[] = $i;
                    }
                    elseif ($token[1] === '}' || $token[1] === ']') {
                        if (!$braces) {
                            throw $this->exception("Mismatch", $token);
                        }
                        $brace = array_pop($braces);
                        if ($tokens[$brace][1] !== '{' && $token[1] === '}' || $tokens[$brace][1] !== '[' && $token[1] === ']') {
                            throw $this->exception("Mismatch", $token);
                        }
                        $block = array_filter(array_slice(array_splice($tokens, $brace + 1, $i - $brace, []), 0, -1), fn($token) => !(is_array($token) && in_array($token[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT, T_BAD_CHARACTER], true)));
                        $elements = array_explode($block, fn($token) => is_array($token) && $token[1] === ',');
                        // for trailing comma
                        if ($elements && !$elements[count($elements) - 1]) {
                            array_pop($elements);
                        }
                        // check consecutive comma (e.g. [1,,3])
                        if (count(array_filter($elements)) !== count($elements)) {
                            throw $this->exception("Missing element", $token);
                        }
                        $i = $brace;
                        if ($token[1] === '}') {
                            $object = $this->token('object', $tokens[$brace][3], $token[3] + strlen($token[1]));
                            foreach ($elements as $element) {
                                $keyandval = array_explode($element, fn($token) => is_array($token) && $token[1] === ':');
                                // check no colon (e.g. {123})
                                if (count($keyandval) !== 2) {
                                    throw $this->exception("Missing object key", first_value($keyandval[0]));
                                }
                                // check objective key (e.g. {[1]: 123})
                                if (($k = array_find($keyandval[0], 'is_object')) !== false) {
                                    throw $this->exception("Unexpected object key", $keyandval[0][$k]);
                                }
                                // check consecutive objective value (e.g. {k: 123 [1]})
                                if (!(count($keyandval[1]) === 1 && count(array_filter($keyandval[1], 'is_object')) === 1 || count(array_filter($keyandval[1], 'is_array')) === count($keyandval[1]))) {
                                    throw $this->exception("Unexpected object value", $token);
                                }
                                $key = first_value($keyandval[0]);
                                $lastkey = last_value($keyandval[0]);
                                $val = first_value($keyandval[1]);
                                $lastval = last_value($keyandval[1]);
                                if (!is_object($val)) {
                                    $val = $this->token('value', $val[3], $lastval[3] + strlen($lastval[1]));
                                }
                                $object->append($this->token('key', $key[3], $lastkey[3] + strlen($lastkey[1])), $val);
                            }
                            $tokens[$brace] = $object;
                        }
                        if ($token[1] === ']') {
                            $array = $this->token('array', $tokens[$brace][3], $token[3] + strlen($token[1]));
                            foreach ($elements as $element) {
                                // check consecutive objective value (e.g. [123 [1]])
                                if (!(count($element) === 1 && count(array_filter($element, 'is_object')) === 1 || count(array_filter($element, 'is_array')) === count($element))) {
                                    throw $this->exception("Unexpected array value", $token);
                                }
                                $val = first_value($element);
                                $lastval = last_value($element);
                                if (!is_object($val)) {
                                    $val = $this->token('value', $val[3], $lastval[3] + strlen($lastval[1]));
                                }
                                $array->append(null, $val);
                            }
                            $tokens[$brace] = $array;
                        }
                    }
                }

                if ($braces) {
                    throw $this->exception("Mismatch", $tokens[$braces[count($braces) - 1]]);
                }

                /** @var self $root */
                $root = $tokens[0];
                $result = $root->value($options);

                if (count($result) !== 1) {
                    throw $this->exception("Mismatch", $tokens[0]);
                }
                return $result[0];
            }

            private function token($type, $begin_position, $end_position)
            {
                $clone = clone $this;
                $clone->type = $type;
                $clone->begin_position = $begin_position;
                $clone->end_position = $end_position;
                $clone->keys = [];
                $clone->values = [];
                return $clone;
            }

            private function append($key, $value)
            {
                assert(($key !== null && $this->type === 'object') || ($key === null && $this->type === 'array'));
                $this->keys[] = $key ?? count($this->keys);
                $this->values[] = $value;
            }

            private function value($options = [])
            {
                $numberify = function ($token) use ($options) {
                    if (is_numeric($token[0]) || $token[0] === '-' || $token[0] === '+' || $token[0] === '.') {
                        $sign = 1;
                        if ($token[0] === '+' || $token[0] === '-') {
                            $sign = substr($token, 0, 1) === '-' ? -1 : 1;
                            $token = substr($token, 1);
                        }
                        if (($token[0] ?? null) === '0' && isset($token[1]) && $token[1] !== '.') {
                            if (!($token[1] === 'x' || $token[1] === 'X')) {
                                throw $this->exception("Octal literal", $this);
                            }
                            $token = substr($token, 2);
                            if (!ctype_xdigit($token)) {
                                throw $this->exception("Bad hex number", $this);
                            }
                            $token = hexdec($token);
                        }
                        if (!is_numeric($token) || !is_finite($token)) {
                            throw $this->exception("Bad number", $this);
                        }
                        if (false
                            || ($options[JSON_INT_AS_STRING] && ctype_digit("$token"))
                            || ($options[JSON_FLOAT_AS_STRING] && !ctype_digit("$token"))
                            || ($options[JSON_BIGINT_AS_STRING] && ctype_digit("$token") && is_float(($token + 0)))
                        ) {
                            return $sign === -1 ? "-$token" : $token;
                        }

                        return 0 + $sign * $token;
                    }
                    return null;
                };
                $stringify = function ($token) {
                    if (strlen($token) > 1 && ($token[0] === '"' || $token[0] === "'")) {
                        if ($token[0] !== $token[-1]) {
                            throw $this->exception("Bad string", $this);
                        }
                        $token = substr($token, 1, -1);
                        $token = preg_replace_callback('/(?:\\\\u[0-9A-Fa-f]{4})+/u', function ($m) { return json_decode('"' . $m[0] . '"'); }, $token);
                        $token = strtr($token, [
                            "\\'"    => "'",
                            '\\"'    => '"',
                            '\\\\'   => '\\',
                            '\\/'    => '/',
                            "\\\n"   => "",
                            "\\\r"   => "",
                            "\\\r\n" => "",
                            '\\b'    => chr(8),
                            '\\f'    => "\f",
                            '\\n'    => "\n",
                            '\\r'    => "\r",
                            '\\t'    => "\t",
                        ]);
                        return $token;
                    }
                    return null;
                };

                switch ($this->type) {
                    default:
                        throw new \DomainException(); // @codeCoverageIgnore
                    case 'array':
                        return array_map(fn($value) => $value->value($options), $this->values);
                    case 'object':
                        $array = array_combine(
                            array_map(fn($value) => $value->value($options), $this->keys),
                            array_map(fn($value) => $value->value($options), $this->values)
                        );
                        return $options[JSON_OBJECT_AS_ARRAY] ? $array : (object) $array;
                    case 'key':
                        $token = substr($this->json_string, $this->begin_position, $this->end_position - $this->begin_position);
                        $token = trim($token, chr(0xC2) . chr(0xA0) . " \n\r\t\v\x00\x0c");
                        if (preg_match('/^(?:[\$_\p{L}\p{Nl}]|\\\\u[0-9A-Fa-f]{4})(?:[\$_\p{L}\p{Nl}\p{Mn}\p{Mc}\p{Nd}\p{Pc}‌‍]|\\\\u[0-9A-Fa-f]{4})*/u', $token)) {
                            $token = preg_replace_callback('/(?:\\\\u[0-9A-Fa-f]{4})+/u', fn($m) => json_decode('"' . $m[0] . '"'), $token);
                            return $token;
                        }
                        if (($string = $stringify($token)) !== null) {
                            return $string;
                        }
                        throw $this->exception("Bad identifier", $this);
                    case 'value':
                        $token = substr($this->json_string, $this->begin_position, $this->end_position - $this->begin_position);
                        $token = trim($token, chr(0xC2) . chr(0xA0) . " \n\r\t\v\x00\x0c");
                        $literals = [
                            'null'      => null,
                            'false'     => false,
                            'true'      => true,
                            'Infinity'  => INF,
                            '+Infinity' => +INF,
                            '-Infinity' => -INF,
                            'NaN'       => NAN,
                            '+NaN'      => +NAN,
                            '-NaN'      => -NAN,
                        ];
                        // literals
                        if (array_key_exists($token, $literals)) {
                            return $literals[$token];
                        }
                        // numbers
                        if (($number = $numberify($token)) !== null) {
                            return $number;
                        }
                        // strings
                        if (($string = $stringify($token)) !== null) {
                            return $string;
                        }
                        throw $this->exception("Bad value", $this);
                }
            }

            private function exception($message, $token)
            {
                $line = $column = $word = null;
                if (is_array($token)) {
                    $line = $token[2];
                    $column = $token[3] - strrpos($this->json_string, "\n", $token[3] - strlen($this->json_string));
                    $word = $token[1];
                }
                if (is_object($token)) {
                    $line = substr_count($token->json_string, "\n", 0, $token->begin_position) + 1;
                    $column = $token->begin_position - strrpos($token->json_string, "\n", $token->begin_position - strlen($token->json_string));
                    $word = substr($token->json_string, $token->begin_position, $token->end_position - $token->begin_position);
                }
                return new \ErrorException(sprintf("%s '%s' at line %d column %d of the JSON5 data", $message, $word, $line, $column));
            }
        };

        return $parser->parse($specials);
    }
}
if (function_exists("ryunosuke\\Functions\\json_import") && !defined("ryunosuke\\Functions\\json_import")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\json_import", "ryunosuke\\Functions\\json_import");
}

if (!isset($excluded_functions["paml_export"]) && (!function_exists("ryunosuke\\Functions\\paml_export") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\paml_export"))->isInternal()))) {
    /**
     * 連想配列を paml 的文字列に変換する
     *
     * paml で出力することはまずないのでおまけ（import との対称性のために定義している）。
     *
     * Example:
     * ```php
     * that(paml_export([
     *     'n' => null,
     *     'f' => false,
     *     'i' => 123,
     *     'd' => 3.14,
     *     's' => 'this is string',
     * ]))->isSame('n: null, f: false, i: 123, d: 3.14, s: "this is string"');
     * ```
     *
     * @param array $pamlarray 配列
     * @param array $options オプション配列
     * @return string PAML 的文字列
     */
    function paml_export($pamlarray, $options = [])
    {
        $options += [
            'trailing-comma' => false,
            'pretty-space'   => true,
        ];

        $space = $options['pretty-space'] ? ' ' : '';

        $result = [];
        $n = 0;
        foreach ($pamlarray as $k => $v) {
            if (is_array($v)) {
                $inner = paml_export($v, $options);
                if (is_hasharray($v)) {
                    $v = '{' . $inner . '}';
                }
                else {
                    $v = '[' . $inner . ']';
                }
            }
            elseif ($v === null) {
                $v = 'null';
            }
            elseif ($v === false) {
                $v = 'false';
            }
            elseif ($v === true) {
                $v = 'true';
            }
            elseif (is_string($v)) {
                $v = '"' . addcslashes($v, "\"\0\\") . '"';
            }

            if ($k === $n++) {
                $result[] = "$v";
            }
            else {
                $result[] = "$k:{$space}$v";
            }
        }
        return implode(",$space", $result) . ($options['trailing-comma'] ? ',' : '');
    }
}
if (function_exists("ryunosuke\\Functions\\paml_export") && !defined("ryunosuke\\Functions\\paml_export")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\paml_export", "ryunosuke\\Functions\\paml_export");
}

if (!isset($excluded_functions["paml_import"]) && (!function_exists("ryunosuke\\Functions\\paml_import") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\paml_import"))->isInternal()))) {
    /**
     * paml 的文字列をパースする
     *
     * paml とは yaml を簡易化したような独自フォーマットを指す（Php Array Markup Language）。
     * ざっくりと下記のような特徴がある。
     *
     * - ほとんど yaml と同じだがフロースタイルのみでキーコロンの後のスペースは不要
     * - yaml のアンカーや複数ドキュメントのようなややこしい仕様はすべて未対応
     * - 配列を前提にしているので、トップレベルの `[]` `{}` は不要
     * - `[]` でいわゆる php の配列、 `{}` で stdClass を表す（オプション指定可能）
     * - bare string で php の定数を表す（クラス定数も完全修飾すれば使用可能）
     *
     * 簡易的な設定の注入に使える（yaml は標準で対応していないし、json や php 配列はクオートの必要やケツカンマ問題がある）。
     * なお、かなり緩くパースしてるので基本的にエラーにはならない。
     *
     * 早見表：
     *
     * - php:  `["n" => null, "f" => false, "i" => 123, "d" => 3.14, "s" => "this is string", "a" => [1, 2, "x" => "X"]]`
     *     - ダブルアローとキーのクオートが冗長
     * - json: `{"n":null, "f":false, "i":123, "d":3.14, "s":"this is string", "a":{"0": 1, "1": 2, "x": "X"}}`
     *     - キーのクオートが冗長だしケツカンマ非許容
     * - yaml: `{n: null, f: false, i: 123, d: 3.14, s: "this is string", a: {0: 1, 1: 2, x: X}}`
     *     - 理想に近いが、コロンの後にスペースが必要だし連想配列が少々難。なにより拡張や外部ライブラリが必要
     * - paml: `n:null, f:false, i:123, d:3.14, s:"this is string", a:[1, 2, x:X]`
     *     - シンプルイズベスト
     *
     * Example:
     * ```php
     * // こういったスカラー型はほとんど yaml と一緒だが、コロンの後のスペースは不要（あってもよい）
     * that(paml_import('n:null, f:false, i:123, d:3.14, s:"this is string"'))->isSame([
     *     'n' => null,
     *     'f' => false,
     *     'i' => 123,
     *     'd' => 3.14,
     *     's' => 'this is string',
     * ]);
     * // 配列が使える（キーは連番なら不要）。ネストも可能
     * that(paml_import('a:[1,2,x:X,3], nest:[a:[b:[c:[X]]]]'))->isSame([
     *     'a'    => [1, 2, 'x' => 'X', 3],
     *     'nest' => [
     *         'a' => [
     *             'b' => [
     *                 'c' => ['X']
     *             ],
     *         ],
     *     ],
     * ]);
     * // bare 文字列で定数が使える。::class も特別扱いで定数とみなす
     * that(paml_import('pv:PHP_VERSION, ao:ArrayObject::STD_PROP_LIST, class:ArrayObject::class'))->isSame([
     *     'pv'    => \PHP_VERSION,
     *     'ao'    => \ArrayObject::STD_PROP_LIST,
     *     'class' => \ArrayObject::class,
     * ]);
     * ```
     *
     * @param string $pamlstring PAML 文字列
     * @param array $options オプション配列
     * @return array php 配列
     */
    function paml_import($pamlstring, $options = [])
    {
        $options += [
            'cache'          => true,
            'trailing-comma' => true,
            'stdclass'       => true,
            'expression'     => false,
            'escapers'       => ['"' => '"', "'" => "'", '[' => ']', '{' => '}'],
        ];

        static $caches = [];
        if ($options['cache']) {
            $key = $pamlstring . json_encode($options);
            return $caches[$key] ??= paml_import($pamlstring, ['cache' => false] + $options);
        }

        $resolve = function (&$value) use ($options) {
            $prefix = $value[0] ?? null;
            $suffix = $value[-1] ?? null;

            if (($prefix === '[' && $suffix === ']') || ($prefix === '{' && $suffix === '}')) {
                $values = paml_import(substr($value, 1, -1), $options);
                $value = ($prefix === '[' || !$options['stdclass']) ? (array) $values : (object) $values;
                return true;
            }

            if ($prefix === '"' && $suffix === '"') {
                //$element = stripslashes(substr($element, 1, -1));
                $value = json_decode($value);
                return true;
            }
            if ($prefix === "'" && $suffix === "'") {
                $value = substr($value, 1, -1);
                return true;
            }

            if (ctype_digit(ltrim($value, '+-'))) {
                $value = (int) $value;
                return true;
            }
            if (is_numeric($value)) {
                $value = (double) $value;
                return true;
            }

            if (defined($value)) {
                $value = constant($value);
                return true;
            }
            [$class, $cname] = explode('::', $value, 2) + [1 => null];
            if (class_exists($class) && strtolower($cname) === 'class') {
                $value = ltrim($class, '\\');
                return true;
            }

            if ($options['expression']) {
                $semicolon = ';';
                if ($prefix === '`' && $suffix === '`') {
                    $value = eval("return " . substr($value, 1, -1) . $semicolon);
                    return true;
                }
                try {
                    $evalue = @eval("return $value$semicolon");
                    if ($value !== $evalue) {
                        $value = $evalue;
                        return true;
                    }
                }
                catch (\ParseError $e) {
                }
            }

            return false;
        };

        $values = array_map('trim', quoteexplode(',', $pamlstring, null, $options['escapers']));
        if ($options['trailing-comma'] && end($values) === '') {
            array_pop($values);
        }

        $result = [];
        foreach ($values as $value) {
            $key = null;
            if (!$resolve($value)) {
                $kv = array_map('trim', quoteexplode(':', $value, 2, $options['escapers']));
                if (count($kv) === 2) {
                    [$key, $value] = $kv;
                    $resolve($value);
                }
            }

            array_put($result, $value, $key);
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\paml_import") && !defined("ryunosuke\\Functions\\paml_import")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\paml_import", "ryunosuke\\Functions\\paml_import");
}

if (!isset($excluded_functions["ltsv_export"]) && (!function_exists("ryunosuke\\Functions\\ltsv_export") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\ltsv_export"))->isInternal()))) {
    /**
     * 配列を LTSV 的文字列に変換する
     *
     * ラベル文字列に ":" を含む場合は例外を投げる（ラベルにコロンが来るとどうしようもない）。
     *
     * escape オプションで「LTSV 的にまずい文字」がその文字でエスケープされる（具体的には "\n" と "\t"）。
     * デフォルトでは "\\" でエスケープされるので、整合性が崩れることはない。
     *
     * encode オプションで「文字列化できない値」が来たときのその関数を通して出力される（その場合、目印として値の両サイドに ` が付く）。
     * デフォルトでは json_encode される。
     *
     * エンコード機能はおまけに過ぎない（大抵の場合はそんな機能は必要ない）。
     * ので、この実装は互換性を維持せず変更される可能性がある。
     *
     * Example:
     * ```php
     * // シンプルな実行例
     * that(ltsv_export([
     *     "label1" => "value1",
     *     "label2" => "value2",
     * ]))->is("label1:value1	label2:value2");
     *
     * // タブや改行文字のエスケープ
     * that(ltsv_export([
     *     "label1" => "val\tue1",
     *     "label2" => "val\nue2",
     * ]))->is("label1:val\\tue1	label2:val\\nue2");
     *
     * // 配列のエンコード
     * that(ltsv_export([
     *     "label1" => "value1",
     *     "label2" => [1, 2, 3],
     * ]))->is("label1:value1	label2:`[1,2,3]`");
     * ```
     *
     * @param array $ltsvarray 配列
     * @param array $options オプション配列
     * @return string LTSV 的文字列
     */
    function ltsv_export($ltsvarray, $options = [])
    {
        $options += [
            'escape' => '\\',
            'encode' => fn($v) => json_encode($v, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ];
        $escape = $options['escape'];
        $encode = $options['encode'];

        $map = [];
        if (strlen($escape)) {
            $map["\\"] = "{$escape}\\";
            $map["\t"] = "{$escape}t";
            $map["\n"] = "{$escape}n";
        }

        $parts = [];
        foreach ($ltsvarray as $label => $value) {
            if (strpos($label, ':')) {
                throw new \InvalidArgumentException('label contains ":".');
            }
            $should_encode = !is_stringable($value);
            if ($should_encode) {
                $value = "`{$encode($value)}`";
            }
            if ($map) {
                $label = strtr($label, $map);
                if (!$should_encode) {
                    $value = strtr($value, $map);
                }
            }
            $parts[] = $label . ':' . $value;
        }
        return implode("\t", $parts);
    }
}
if (function_exists("ryunosuke\\Functions\\ltsv_export") && !defined("ryunosuke\\Functions\\ltsv_export")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\ltsv_export", "ryunosuke\\Functions\\ltsv_export");
}

if (!isset($excluded_functions["ltsv_import"]) && (!function_exists("ryunosuke\\Functions\\ltsv_import") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\ltsv_import"))->isInternal()))) {
    /**
     * LTSV 的文字列を配列に変換する
     *
     * escape オプションで「LTSV 的にまずい文字」がその文字でエスケープされる（具体的には "\n" と "\t"）。
     * デフォルトでは "\\" でエスケープされるので、整合性が崩れることはない。
     *
     * decode オプションで「`` で囲まれた値」が来たときのその関数を通して出力される。
     * デフォルトでは json_decode される。
     *
     * エンコード機能はおまけに過ぎない（大抵の場合はそんな機能は必要ない）。
     * ので、この実装は互換性を維持せず変更される可能性がある。
     *
     * Example:
     * ```php
     * // シンプルな実行例
     * that(ltsv_import("label1:value1	label2:value2"))->is([
     *     "label1" => "value1",
     *     "label2" => "value2",
     * ]);
     *
     * // タブや改行文字のエスケープ
     * that(ltsv_import("label1:val\\tue1	label2:val\\nue2"))->is([
     *     "label1" => "val\tue1",
     *     "label2" => "val\nue2",
     * ]);
     *
     * // 配列のデコード
     * that(ltsv_import("label1:value1	label2:`[1,2,3]`"))->is([
     *     "label1" => "value1",
     *     "label2" => [1, 2, 3],
     * ]);
     * ```
     *
     * @param string $ltsvstring LTSV 的文字列
     * @param array $options オプション配列
     * @return array 配列
     */
    function ltsv_import($ltsvstring, $options = [])
    {
        $options += [
            'escape' => '\\',
            'decode' => fn($v) => json_decode($v, true),
        ];
        $escape = $options['escape'];
        $decode = $options['decode'];

        $map = [];
        if (strlen($escape)) {
            $map["{$escape}\\"] = "\\";
            $map["{$escape}t"] = "\t";
            $map["{$escape}n"] = "\n";
        }

        $result = [];
        foreach (explode("\t", $ltsvstring) as $part) {
            [$label, $value] = explode(':', $part, 2);
            $should_decode = substr($value, 0, 1) === '`' && substr($value, -1, 1) === '`';
            if ($map) {
                $label = strtr($label, $map);
                if (!$should_decode) {
                    $value = strtr($value, $map);
                }
            }
            if ($should_decode) {
                $value2 = $decode(substr($value, 1, -1));
                // たまたま ` が付いているだけかも知れないので結果で判定する
                if (!is_stringable($value2)) {
                    $value = $value2;
                }
            }
            $result[$label] = $value;
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\ltsv_import") && !defined("ryunosuke\\Functions\\ltsv_import")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\ltsv_import", "ryunosuke\\Functions\\ltsv_import");
}

if (!isset($excluded_functions["markdown_table"]) && (!function_exists("ryunosuke\\Functions\\markdown_table") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\markdown_table"))->isInternal()))) {
    /**
     * 連想配列の配列を markdown テーブル文字列にする
     *
     * 見出しはキーの和集合で生成され、改行は `<br>` に置換される。
     * 要素が全て数値の場合は右寄せになる。
     *
     * Example:
     * ```php
     * // 最初の "\n" に意味はない（ズレると見づらいので冒頭に足しているだけ）
     * that("\n" . markdown_table([
     *    ['a' => 'a1', 'b' => 'b1'],
     *    ['b' => 'b2', 'c' => '2'],
     *    ['a' => 'a3', 'c' => '3'],
     * ]))->is("
     * | a   | b   |   c |
     * | --- | --- | --: |
     * | a1  | b1  |     |
     * |     | b2  |   2 |
     * | a3  |     |   3 |
     * ");
     * ```
     *
     * @param array $array 連想配列の配列
     * @param array $option オプション配列
     * @return string markdown テーブル文字列
     */
    function markdown_table($array, $option = [])
    {
        if (!is_array($array) || is_empty($array)) {
            throw new \InvalidArgumentException('$array must be array of hasharray.');
        }

        $option += [
            'keylabel' => null, // 指定すると一番左端にキーの列が生える
        ];

        $defaults = [];
        $numerics = [];
        $lengths = [];
        foreach ($array as $n => $fields) {
            assert(is_array($fields), '$array must be array of hasharray.');
            if ($option['keylabel'] !== null) {
                $fields = [$option['keylabel'] => $n] + $fields;
            }
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
if (function_exists("ryunosuke\\Functions\\markdown_table") && !defined("ryunosuke\\Functions\\markdown_table")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\markdown_table", "ryunosuke\\Functions\\markdown_table");
}

if (!isset($excluded_functions["markdown_list"]) && (!function_exists("ryunosuke\\Functions\\markdown_list") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\markdown_list"))->isInternal()))) {
    /**
     * 配列を markdown リスト文字列にする
     *
     * Example:
     * ```php
     * // 最初の "\n" に意味はない（ズレると見づらいので冒頭に足しているだけ）
     * that("\n" . markdown_list([
     *     'dict'        => [
     *         'Key1' => 'Value1',
     *         'Key2' => 'Value2',
     *     ],
     *     'list'        => ['Item1', 'Item2', 'Item3'],
     *     'dict & list' => [
     *         'Key' => 'Value',
     *         ['Item1', 'Item2', 'Item3'],
     *     ],
     * ], ['separator' => ':']))->is("
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
            foreach (arrays($array) as $n => [$k, $v]) {
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
if (function_exists("ryunosuke\\Functions\\markdown_list") && !defined("ryunosuke\\Functions\\markdown_list")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\markdown_list", "ryunosuke\\Functions\\markdown_list");
}

if (!isset($excluded_functions["random_string"]) && (!function_exists("ryunosuke\\Functions\\random_string") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\random_string"))->isInternal()))) {
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
if (function_exists("ryunosuke\\Functions\\random_string") && !defined("ryunosuke\\Functions\\random_string")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\random_string", "ryunosuke\\Functions\\random_string");
}

if (!isset($excluded_functions["unique_string"]) && (!function_exists("ryunosuke\\Functions\\unique_string") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\unique_string"))->isInternal()))) {
    /**
     * 文字列に含まれない文字列を生成する
     *
     * 例えば http のマルチパートバウンダリのような、「競合しない文字列」を生成する。
     * 実装は愚直に文字列を調べて存在しなければそれを返すようになっている。
     * 一応初期値や文字セットは指定可能。
     *
     * $initial に int を与えると初期値としてその文字数分 $charlist から確保する。
     * 例えば生成後の変更が前提で、ある程度の長さを担保したいときに指定すれば最低でもその長さ以上は保証される。
     * $initial に string を与えるとそれがそのまま初期値として使用される。
     * 例えば「ほぼ存在しない文字列」が予測できるのであればそれを指定すれば無駄な処理が省ける。
     *
     * Example:
     * ```php
     * // 単純に呼ぶと生成1,2文字程度の文字列になる
     * that(unique_string('hello, world'))->stringLengthEqualsAny([1, 2]);
     * // 数値を含んでいないので候補文字に数値のみを指定すれば1文字で「存在しない文字列」となる
     * that(unique_string('hello, world', null, range(0, 9)))->stringLengthEquals(1);
     * // int を渡すと最低でもそれ以上は保証される
     * that(unique_string('hello, world', 5))->stringLengthEqualsAny([5, 6]);
     * // string を渡すとそれが初期値となる
     * that(unique_string('hello, world', 'prefix-'))->stringStartsWith('prefix');
     * ```
     *
     * @param string $source 元文字列
     * @param string|int $initial 初期文字列あるいは文字数
     * @param string|array $charlist 使用する文字セット
     * @return string 一意な文字列
     */
    function unique_string($source, $initial = null, $charlist = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        assert(is_stringable($initial) || is_int($initial) || is_null($initial));

        if (is_stringable($charlist)) {
            $charlist = preg_split('//', $charlist, -1, PREG_SPLIT_NO_EMPTY);
        }

        $charlength = count($charlist);
        if ($charlength === 0) {
            throw new \InvalidArgumentException('charlist is empty.');
        }

        $result = '';
        if (is_int($initial)) {
            shuffle($charlist);
            $result = implode('', array_slice($charlist, 0, $initial));
        }
        elseif (is_stringable($initial)) {
            $result = $initial;
        }

        $p = 0;
        do {
            $result .= $charlist[mt_rand(0, $charlength - 1)];
        } while (($p = strpos($source, $result, $p)) !== false);

        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\unique_string") && !defined("ryunosuke\\Functions\\unique_string")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\unique_string", "ryunosuke\\Functions\\unique_string");
}

if (!isset($excluded_functions["kvsprintf"]) && (!function_exists("ryunosuke\\Functions\\kvsprintf") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\kvsprintf"))->isInternal()))) {
    /**
     * 連想配列を指定できるようにした vsprintf
     *
     * sprintf の順序指定構文('%1$d')にキーを指定できる。
     *
     * Example:
     * ```php
     * that(kvsprintf('%hoge$s %fuga$d', ['hoge' => 'ThisIs', 'fuga' => '3.14']))->isSame('ThisIs 3');
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
if (function_exists("ryunosuke\\Functions\\kvsprintf") && !defined("ryunosuke\\Functions\\kvsprintf")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\kvsprintf", "ryunosuke\\Functions\\kvsprintf");
}

if (!isset($excluded_functions["preg_matches"]) && (!function_exists("ryunosuke\\Functions\\preg_matches") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\preg_matches"))->isInternal()))) {
    /**
     * 複数マッチに対応した preg_match
     *
     * 要するに preg_match_all とほぼ同義だが、下記の差異がある。
     *
     * - 正規表現フラグに "g" フラグが使用できる。 "g" を指定すると preg_match_all 相当の動作になる
     * - キャプチャは参照引数ではなく返り値で返す
     * - 「パターン全体マッチ」を表す 0 キーは返さない
     * - 上記2つの動作により「マッチしなかったら空配列を返す」という動作になる
     * - 名前付きキャプチャーに対応する数値キーは伏せられる
     * - 伏せられても数値キーは 0 ベースで通し連番となる
     *
     * Example:
     * ```php
     * $pattern = '#(\d{4})/(?<month>\d{1,2})(?:/(\d{1,2}))?#';
     * // 1(month)番目は名前付きキャプチャなので 1 キーとしては含まれず month というキーで返す（2 が詰められて 1 になる）
     * that(preg_matches($pattern, '2014/12/24'))->isSame([0 => '2014', 'month' => '12', 1 => '24']);
     * // 一切マッチしなければ空配列が返る
     * that(preg_matches($pattern, 'hoge'))->isSame([]);
     *
     * // g オプションを与えると preg_match_all 相当の動作になる（flags も使える）
     * $pattern = '#(\d{4})/(?<month>\d{1,2})(?:/(\d{1,2}))?#g';
     * that(preg_matches($pattern, '2013/11/23, 2014/12/24', PREG_SET_ORDER))->isSame([
     *     [0 => '2013', 'month' => '11', 1 => '23'],
     *     [0 => '2014', 'month' => '12', 1 => '24'],
     * ]);
     * ```
     *
     * @param string $pattern 正規表現
     * @param string $subject 対象文字列
     * @param int $flags PREG 定数
     * @param int $offset 開始位置
     * @return array キャプチャした配列
     */
    function preg_matches($pattern, $subject, $flags = 0, $offset = 0)
    {
        // 0 と名前付きに対応する数値キーを伏せてその上で通し連番にするクロージャ
        $unset = function ($match) {
            $result = [];
            $keys = array_keys($match);
            for ($i = 1; $i < count($keys); $i++) {
                $key = $keys[$i];
                if (is_string($key)) {
                    $result[$key] = $match[$key];
                    $i++;
                }
                else {
                    $result[] = $match[$key];
                }
            }
            return $result;
        };

        $endpairs = [
            '(' => ')',
            '{' => '}',
            '[' => ']',
            '<' => '>',
        ];
        $endpos = strrpos($pattern, $endpairs[$pattern[0]] ?? $pattern[0]);
        $expression = substr($pattern, 0, $endpos);
        $modifiers = str_split(substr($pattern, $endpos));

        if (($g = array_search('g', $modifiers, true)) !== false) {
            unset($modifiers[$g]);

            preg_match_all($expression . implode('', $modifiers), $subject, $matches, $flags, $offset);
            if (($flags & PREG_SET_ORDER) === PREG_SET_ORDER) {
                return array_map($unset, $matches);
            }
            return $unset($matches);
        }
        else {
            $flags = ~PREG_PATTERN_ORDER & ~PREG_SET_ORDER & $flags;

            preg_match($pattern, $subject, $matches, $flags, $offset);
            return $unset($matches);
        }
    }
}
if (function_exists("ryunosuke\\Functions\\preg_matches") && !defined("ryunosuke\\Functions\\preg_matches")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\preg_matches", "ryunosuke\\Functions\\preg_matches");
}

if (!isset($excluded_functions["preg_capture"]) && (!function_exists("ryunosuke\\Functions\\preg_capture") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\preg_capture"))->isInternal()))) {
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
     * that(preg_capture($pattern, '2014/12/24', $default))->isSame([1 => '2014', 2 => '12', 4 => '24']);
     * // 最後の \d{1,2} はマッチしないのでデフォルト値が使われる
     * that(preg_capture($pattern, '2014/12', $default))->isSame([1 => '2014', 2 => '12', 4 => '1']);
     * // 一切マッチしないので全てデフォルト値が使われる
     * that(preg_capture($pattern, 'hoge', $default))->isSame([1 => '2000', 2 => '1', 4 => '1']);
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
if (function_exists("ryunosuke\\Functions\\preg_capture") && !defined("ryunosuke\\Functions\\preg_capture")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\preg_capture", "ryunosuke\\Functions\\preg_capture");
}

if (!isset($excluded_functions["preg_splice"]) && (!function_exists("ryunosuke\\Functions\\preg_splice") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\preg_splice"))->isInternal()))) {
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
     * that(preg_splice('#\\d+#', '', 'abc123', $m))->isSame('abc');
     * that($m)->isSame(['123']);
     *
     * // callable だと preg_replace_callback が呼ばれる
     * that(preg_splice('#[a-z]+#', fn($m) => strtoupper($m[0]), 'abc123', $m))->isSame('ABC123');
     * that($m)->isSame(['abc']);
     *
     * // ただし、 文字列 callable は文字列として扱う
     * that(preg_splice('#[a-z]+#', 'strtoupper', 'abc123', $m))->isSame('strtoupper123');
     * that($m)->isSame(['abc']);
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
if (function_exists("ryunosuke\\Functions\\preg_splice") && !defined("ryunosuke\\Functions\\preg_splice")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\preg_splice", "ryunosuke\\Functions\\preg_splice");
}

if (!isset($excluded_functions["preg_replaces"]) && (!function_exists("ryunosuke\\Functions\\preg_replaces") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\preg_replaces"))->isInternal()))) {
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
     * that(preg_replaces('#a(\d+)z#', [1 => 'XXX'], 'a123z'))->isSame('aXXXz');
     * // 名前付きキャプチャも指定できる
     * that(preg_replaces('#a(?<digit>\d+)z#', ['digit' => 'XXX'], 'a123z'))->isSame('aXXXz');
     * // クロージャを渡すと元文字列を引数としてコールバックされる
     * that(preg_replaces('#a(?<digit>\d+)z#', ['digit' => fn($src) => $src * 2], 'a123z'))->isSame('a246z');
     * // 複合的なサンプル（a タグの href と target 属性を書き換える）
     * that(preg_replaces('#<a\s+href="(?<href>.*)"\s+target="(?<target>.*)">#', [
     *     'href'   => fn($href) => strtoupper($href),
     *     'target' => fn($target) => strtoupper($target),
     * ], '<a href="hoge" target="fuga">inner text</a>'))->isSame('<a href="HOGE" target="FUGA">inner text</a>');
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
if (function_exists("ryunosuke\\Functions\\preg_replaces") && !defined("ryunosuke\\Functions\\preg_replaces")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\preg_replaces", "ryunosuke\\Functions\\preg_replaces");
}

if (!isset($excluded_functions["damerau_levenshtein"]) && (!function_exists("ryunosuke\\Functions\\damerau_levenshtein") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\damerau_levenshtein"))->isInternal()))) {
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
     * that(levenshtein("destroy", "destory"))->isSame(2);
     * // damerau_levenshtein だと1である
     * that(damerau_levenshtein("destroy", "destory"))->isSame(1);
     * // UTF-8 でも大丈夫
     * that(damerau_levenshtein("あいうえお", "あいえうお"))->isSame(1);
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
if (function_exists("ryunosuke\\Functions\\damerau_levenshtein") && !defined("ryunosuke\\Functions\\damerau_levenshtein")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\damerau_levenshtein", "ryunosuke\\Functions\\damerau_levenshtein");
}

if (!isset($excluded_functions["ngram"]) && (!function_exists("ryunosuke\\Functions\\ngram") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\ngram"))->isInternal()))) {
    /**
     * N-gram 化して配列で返す
     *
     * 素朴な実装であり特記事項はない。
     * 末端要素や除去フィルタくらいは実装するかもしれない。
     *
     * Example:
     * ```php
     * that(ngram("あいうえお", 1))->isSame(["あ", "い", "う", "え", "お"]);
     * that(ngram("あいうえお", 2))->isSame(["あい", "いう", "うえ", "えお", "お"]);
     * that(ngram("あいうえお", 3))->isSame(["あいう", "いうえ", "うえお", "えお", "お"]);
     * ```
     *
     * @param string $string 対象文字列
     * @param int $N N-gram の N
     * @param string $encoding マルチバイトエンコーディング
     * @return array N-gram 配列
     */
    function ngram($string, $N, $encoding = 'UTF-8')
    {
        if (func_num_args() < 3) {
            $encoding = mb_internal_encoding();
        }

        $result = [];
        for ($i = 0, $l = mb_strlen($string, $encoding); $i < $l; ++$i) {
            $result[] = mb_substr($string, $i, $N, $encoding);
        }

        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\ngram") && !defined("ryunosuke\\Functions\\ngram")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\ngram", "ryunosuke\\Functions\\ngram");
}

if (!isset($excluded_functions["str_guess"]) && (!function_exists("ryunosuke\\Functions\\str_guess") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\str_guess"))->isInternal()))) {
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
}
if (function_exists("ryunosuke\\Functions\\str_guess") && !defined("ryunosuke\\Functions\\str_guess")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\str_guess", "ryunosuke\\Functions\\str_guess");
}

if (!isset($excluded_functions["str_array"]) && (!function_exists("ryunosuke\\Functions\\str_array") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\str_array"))->isInternal()))) {
    /**
     * 文字列を区切り文字で区切って配列に変換する
     *
     * 典型的には http ヘッダとか sar の結果とかを配列にする。
     *
     * Example:
     * ```php
     * // http response header  を ":" 区切りで連想配列にする
     * that(str_array("
     * HTTP/1.1 200 OK
     * Content-Type: text/html; charset=utf-8
     * Connection: Keep-Alive
     * ", ':', true))->isSame([
     *     'HTTP/1.1 200 OK',
     *     'Content-Type' => 'text/html; charset=utf-8',
     *     'Connection'   => 'Keep-Alive',
     * ]);
     *
     * // sar の結果を " " 区切りで連想配列の配列にする
     * that(str_array("
     * 13:00:01        CPU     %user     %nice   %system   %iowait    %steal     %idle
     * 13:10:01        all      0.99      0.10      0.71      0.00      0.00     98.19
     * 13:20:01        all      0.60      0.10      0.56      0.00      0.00     98.74
     * ", ' ', false))->isSame([
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
if (function_exists("ryunosuke\\Functions\\str_array") && !defined("ryunosuke\\Functions\\str_array")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\str_array", "ryunosuke\\Functions\\str_array");
}

if (!isset($excluded_functions["str_common_prefix"]) && (!function_exists("ryunosuke\\Functions\\str_common_prefix") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\str_common_prefix"))->isInternal()))) {
    /**
     * 文字列群の共通のプレフィックスを返す
     *
     * 共通部分がない場合は空文字を返す。
     * 引数は2個以上必要で足りない場合は null を返す。
     *
     * Example:
     * ```php
     * // 共通プレフィックスを返す
     * that(str_common_prefix('ab', 'abc', 'abcd'))->isSame('ab');
     * that(str_common_prefix('あ', 'あい', 'あいう'))->isSame('あ');
     * // 共通部分がない場合は空文字を返す
     * that(str_common_prefix('xab', 'yabc', 'zabcd'))->isSame('');
     * that(str_common_prefix('わあ', 'をあい', 'んあいう'))->isSame('');
     * // 引数不足の場合は null を返す
     * that(str_common_prefix('a'))->isSame(null);
     * ```
     *
     * @param string[] $strings
     * @return ?string 共通部分（共通がない場合は空文字）
     */
    function str_common_prefix(...$strings)
    {
        if (count($strings) < 2) {
            return null;
        }
        $common = array_shift($strings);
        foreach ($strings as $string) {
            for ($i = min(mb_strlen($common), mb_strlen($string)); $i >= 1; $i--) {
                $part = mb_substr($common, 0, $i);
                if ($part === mb_substr($string, 0, $i)) {
                    $common = $part;
                    continue 2;
                }
            }
            return '';
        }
        return $common;
    }
}
if (function_exists("ryunosuke\\Functions\\str_common_prefix") && !defined("ryunosuke\\Functions\\str_common_prefix")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\str_common_prefix", "ryunosuke\\Functions\\str_common_prefix");
}

if (!isset($excluded_functions["mb_substr_replace"]) && (!function_exists("ryunosuke\\Functions\\mb_substr_replace") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\mb_substr_replace"))->isInternal()))) {
    /**
     * マルチバイト対応 substr_replace
     *
     * 本家は配列を与えたりできるが、ややこしいし使う気がしないので未対応。
     *
     * Example:
     * ```php
     * // 2文字目から5文字を「あいうえお」に置換する
     * that(mb_substr_replace('０１２３４５６７８９', 'あいうえお', 2, 5))->isSame('０１あいうえお７８９');
     * ```
     *
     * @param string $string 対象文字列
     * @param string $replacement 置換文字列
     * @param int $start 開始位置
     * @param ?int $length 置換長
     * @return string 置換した文字列
     */
    function mb_substr_replace($string, $replacement, $start, $length = null)
    {
        $string = (string) $string;

        $strlen = mb_strlen($string);
        if ($start < 0) {
            $start += $strlen;
        }
        if ($length === null) {
            $length = $strlen;
        }
        if ($length < 0) {
            $length += $strlen - $start;
        }

        return mb_substr($string, 0, $start) . $replacement . mb_substr($string, $start + $length);
    }
}
if (function_exists("ryunosuke\\Functions\\mb_substr_replace") && !defined("ryunosuke\\Functions\\mb_substr_replace")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\mb_substr_replace", "ryunosuke\\Functions\\mb_substr_replace");
}

if (!isset($excluded_functions["mb_str_pad"]) && (!function_exists("ryunosuke\\Functions\\mb_str_pad") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\mb_str_pad"))->isInternal()))) {
    /**
     * マルチバイト版 str_pad
     *
     * 単純な mb_strlen での実装ではなく mb_strwidth による実装となっている。
     * 「文字数を指定して pad したい」という状況は utf8 で2バイト超えという状況がふさわしくないことが非常に多い。
     * 多くは単純に「全角は2文字、半角は1文字」というユースケースが多い（埋める文字がスペースなら特に）。
     *
     * また、$pad_string が切り捨てられることもない。
     * 標準の str_pad はできるだけ詰めようとして中途半端な $pad_string になることがあるが、その動作は模倣していない。
     * 端的に「$width を超えないようにできる限り敷き詰めて返す」という動作になる。
     *
     * Example:
     * ```php
     * // マルチバイトは2文字幅として換算される
     * that(mb_str_pad('aaaa', 12, '-'))->isSame('aaaa--------');
     * that(mb_str_pad('ああ', 12, '-'))->isSame('ああ--------');
     * // $pad_string は切り捨てられない
     * that(mb_str_pad('aaaa', 12, 'xyz'))->isSame('aaaaxyzxyz'); // 10文字で返す（あと1回 xyz すると 13 文字になり width を超えてしまう（かといって xy だけを足したりもしない））
     * that(mb_str_pad('ああ', 12, 'xyz'))->isSame('ああxyzxyz'); // マルチバイトでも同じ
     * ```
     *
     * @param string $string 対象文字列
     * @param int $width 埋める幅
     * @param string $pad_string 埋める文字列
     * @param int $pad_type 埋める位置
     * @return string 指定文字で埋められた文字列
     */
    function mb_str_pad($string, $width, $pad_string = " ", $pad_type = STR_PAD_RIGHT)
    {
        assert(in_array($pad_type, [STR_PAD_LEFT, STR_PAD_RIGHT, STR_PAD_BOTH]));

        $str_length = mb_strwidth($string);
        $pad_length = mb_strwidth($pad_string);
        $target_length = intval($width - $str_length);

        if ($pad_length === 0 || $target_length <= 0) {
            return $string;
        }

        $pad_count = $target_length / $pad_length;

        switch ($pad_type) {
            default:
                throw new \InvalidArgumentException("pad_type is invalid($pad_type)"); // @codeCoverageIgnore
            case STR_PAD_BOTH:
                $left = str_repeat($pad_string, floor($pad_count / 2));
                $right = str_repeat($pad_string, floor(($target_length - mb_strwidth($left)) / $pad_length));
                return $left . $string . $right;
            case STR_PAD_RIGHT:
                return $string . str_repeat($pad_string, floor($pad_count));
            case STR_PAD_LEFT:
                return str_repeat($pad_string, floor($pad_count)) . $string;
        }
    }
}
if (function_exists("ryunosuke\\Functions\\mb_str_pad") && !defined("ryunosuke\\Functions\\mb_str_pad")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\mb_str_pad", "ryunosuke\\Functions\\mb_str_pad");
}

if (!isset($excluded_functions["mb_ellipsis"]) && (!function_exists("ryunosuke\\Functions\\mb_ellipsis") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\mb_ellipsis"))->isInternal()))) {
    /**
     * 文字列を指定幅に丸める
     *
     * mb_strimwidth と機能的には同じだが、省略文字の差し込み位置を $pos で指定できる。
     * $pos は負数が指定できる。負数の場合後ろから数えられる。
     * 省略した場合は真ん中となる。
     *
     * Example:
     * ```php
     * // 10文字幅に丸める（$pos 省略なので真ん中が省略される）
     * that(mb_ellipsis('あいうえお1234567890', 10, '...'))->isSame('あい...890');
     * // 10文字幅に丸める（$pos=1 なので1幅目から省略される…が、1文字は「あ」なので前方に切られる）
     * that(mb_ellipsis('あいうえお1234567890', 10, '...', 1))->isSame('...567890');
     * // 10文字幅に丸める（$pos=2 なので2幅目から省略される）
     * that(mb_ellipsis('あいうえお1234567890', 10, '...', 2))->isSame('あ...67890');
     * // 10文字幅に丸める（$pos=-1 なので後ろから1幅目から省略される）
     * that(mb_ellipsis('あいうえお1234567890', 10, '...', -1))->isSame('あいう...0');
     * ```
     *
     * @param string $string 対象文字列
     * @param int $width 丸める幅
     * @param string $trimmarker 省略文字列
     * @param int|null $pos 省略記号の差し込み位置
     * @return string 丸められた文字列
     */
    function mb_ellipsis($string, $width, $trimmarker = '...', $pos = null)
    {
        $string = (string) $string;

        $strwidth = mb_strwidth($string);
        if ($strwidth <= $width) {
            return $string;
        }

        $markerwidth = mb_strwidth($trimmarker);
        if ($markerwidth >= $width) {
            return $trimmarker;
        }

        $maxwidth = $width - $markerwidth;
        $pos ??= $maxwidth / 2;
        if ($pos < 0) {
            $pos += $maxwidth;
        }
        $pos = ceil(max(0, min($pos, $maxwidth)));
        $end = $pos + $strwidth - $maxwidth;

        $widths = array_map('mb_strwidth', mb_str_split($string));
        $s = $e = null;
        $sum = 0;
        foreach ($widths as $n => $w) {
            $sum += $w;
            if (!isset($s) && $sum > $pos) {
                $s = $n;
            }
            if (!isset($e) && $sum >= $end) {
                $e = $n + 1;
            }
        }

        return mb_substr($string, 0, $s) . $trimmarker . mb_substr($string, $e);
    }
}
if (function_exists("ryunosuke\\Functions\\mb_ellipsis") && !defined("ryunosuke\\Functions\\mb_ellipsis")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\mb_ellipsis", "ryunosuke\\Functions\\mb_ellipsis");
}

if (!isset($excluded_functions["mb_trim"]) && (!function_exists("ryunosuke\\Functions\\mb_trim") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\mb_trim"))->isInternal()))) {
    /**
     * マルチバイト対応 trim
     *
     * Example:
     * ```php
     * that(mb_trim(' 　 あああ　 　'))->isSame('あああ');
     * ```
     *
     * @param string $string 対象文字列
     * @return string trim した文字列
     */
    function mb_trim($string)
    {
        return preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $string);
    }
}
if (function_exists("ryunosuke\\Functions\\mb_trim") && !defined("ryunosuke\\Functions\\mb_trim")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\mb_trim", "ryunosuke\\Functions\\mb_trim");
}

if (!isset($excluded_functions["render_template"]) && (!function_exists("ryunosuke\\Functions\\render_template") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\render_template"))->isInternal()))) {
    /**
     * "hoge ${hoge}" 形式のレンダリング
     *
     * ES6 のテンプレートリテラルのようなもの。
     *
     * - 埋め込みは ${var} のみで、{$var} は無効
     * - ${expression} は「評価結果の変数名」ではなく「評価結果」が埋め込まれる
     *
     * $vars に callable を渡すと元文字列とプレースホルダー部分の配列でコールバックされる（タグ付きテンプレートの模倣）。
     *
     * 実装的にはただの文字列 eval なので " はエスケープする必要がある。
     *
     * この関数は実験的機能のため、互換性を維持せず変更される可能性がある。
     *
     * Example:
     * ```php
     * that(render_template('${max($nums)}', ['nums' => [1, 9, 3]]))->isSame('9');
     * ```
     *
     * @param string $template レンダリングするファイル名
     * @param array|object|\Closure $vars レンダリング変数
     * @return string レンダリングされた文字列
     */
    function render_template($template, $vars)
    {
        assert(is_arrayable($vars) || is_callable($vars) || is_array($vars));

        $tokens = array_slice(parse_php('"' . $template . '"', [
            //'flags' => TOKEN_NAME,
        ]), 2, -1);

        $callable_mode = is_callable($vars);

        $embed = $callable_mode ? null : unique_string($template, "embedclosure");
        $blocks = [""];
        $values = [];
        for ($i = 0, $l = count($tokens); $i < $l; $i++) {
            if (!$callable_mode) {
                if ($tokens[$i][0] === T_VARIABLE) {
                    $tokens[$i][1] = '\\' . $tokens[$i][1];
                }
            }
            if ($tokens[$i][0] === T_DOLLAR_OPEN_CURLY_BRACES) {
                for ($j = $i; $j < $l; $j++) {
                    if ($tokens[$j][1] === '}') {
                        $stmt = implode('', array_column(array_slice($tokens, $i + 1, $j - $i - 1, true), 1));
                        if (attr_exists($stmt, $vars)) {
                            if ($callable_mode) {
                                $blocks[] = "";
                                $values[] = attr_get($stmt, $vars);
                            }
                            else {
                                // 書き換える必要はない（`${varname}` は正しく埋め込まれる）
                                assert(strlen($stmt));
                            }
                        }
                        else {
                            if ($callable_mode) {
                                $blocks[] = "";
                                $values[] = phpval($stmt, (array) $vars);
                            }
                            else {
                                // ${varname} を {$embedclosure(varname)} に書き換えて埋め込みを有効化する
                                $tokens = array_replace($tokens, array_fill($i, $j - $i + 1, [1 => '']));
                                $tokens[$i][1] = "{\$$embed($stmt)}";
                            }
                        }
                        $i = $j;
                        break;
                    }
                }
            }
            else {
                if ($callable_mode) {
                    $blocks[count($blocks) - 1] .= $tokens[$i][1];
                }
            }
        }

        if ($callable_mode) {
            if (strlen($blocks[count($blocks) - 1]) === 0) {
                unset($blocks[count($blocks) - 1]);
            }
            return $vars($blocks, ...$values);
        }

        $template = '"' . implode('', array_column($tokens, 1)) . '"';
        return evaluate("return $template;", $vars + [$embed => fn($v) => $v]);
    }
}
if (function_exists("ryunosuke\\Functions\\render_template") && !defined("ryunosuke\\Functions\\render_template")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\render_template", "ryunosuke\\Functions\\render_template");
}

if (!isset($excluded_functions["render_string"]) && (!function_exists("ryunosuke\\Functions\\render_string") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\render_string"))->isInternal()))) {
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
     * that(render_string('${0}', ['number']))->isSame('number');
     * // クロージャは呼び出し結果が埋め込まれる
     * that(render_string('$c', ['c' => fn($vars, $k) => $k . '-closure']))->isSame('c-closure');
     * // 引数をそのまま返すだけの特殊な変数 $_ が宣言される
     * that(render_string('{$_(123 + 456)}', []))->isSame('579');
     * // 要するに '$_()' の中に php の式が書けるようになる
     * that(render_string('{$_(implode(\',\', $strs))}', ['strs' => ['a', 'n', 'z']]))->isSame('a,n,z');
     * that(render_string('{$_(max($nums))}', ['nums' => [1, 9, 3]]))->isSame('9');
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
            $vars['_'] = fn($v) => $v;
        }

        try {
            /** @noinspection PhpMethodParametersCountMismatchInspection */
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
if (function_exists("ryunosuke\\Functions\\render_string") && !defined("ryunosuke\\Functions\\render_string")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\render_string", "ryunosuke\\Functions\\render_string");
}

if (!isset($excluded_functions["render_file"]) && (!function_exists("ryunosuke\\Functions\\render_file") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\render_file"))->isInternal()))) {
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
if (function_exists("ryunosuke\\Functions\\render_file") && !defined("ryunosuke\\Functions\\render_file")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\render_file", "ryunosuke\\Functions\\render_file");
}

if (!isset($excluded_functions["ob_include"]) && (!function_exists("ryunosuke\\Functions\\ob_include") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\ob_include"))->isInternal()))) {
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
     * that(ob_include(sys_get_temp_dir() . '/template.php', ['var' => 'hoge']))->isSame('
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
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        return (static function () {
            ob_start();
            extract(func_get_arg(1));
            include func_get_arg(0);
            return ob_get_clean();
        })($include_file, $array);
    }
}
if (function_exists("ryunosuke\\Functions\\ob_include") && !defined("ryunosuke\\Functions\\ob_include")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\ob_include", "ryunosuke\\Functions\\ob_include");
}

if (!isset($excluded_functions["include_string"]) && (!function_exists("ryunosuke\\Functions\\include_string") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\include_string"))->isInternal()))) {
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
if (function_exists("ryunosuke\\Functions\\include_string") && !defined("ryunosuke\\Functions\\include_string")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\include_string", "ryunosuke\\Functions\\include_string");
}

if (!isset($excluded_functions["evaluate"]) && (!function_exists("ryunosuke\\Functions\\evaluate") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\evaluate"))->isInternal()))) {
    /**
     * eval のプロキシ関数
     *
     * 一度ファイルに吐いてから require した方が opcache が効くので抜群に速い。
     * また、素の eval は ParseError が起こったときの表示がわかりにくすぎるので少し見やすくしてある。
     *
     * 関数化してる以上 eval におけるコンテキストの引き継ぎはできない。
     * ただし、引数で変数配列を渡せるようにしてあるので get_defined_vars を併用すれば基本的には同じ（$this はどうしようもない）。
     *
     * 短いステートメントだと opcode が少ないのでファイルを経由せず直接 eval したほうが速いことに留意。
     * 一応引数で指定できるようにはしてある。
     *
     * Example:
     * ```php
     * $a = 1;
     * $b = 2;
     * $phpcode = ';
     * $c = $a + $b;
     * return $c * 3;
     * ';
     * that(evaluate($phpcode, get_defined_vars()))->isSame(9);
     * ```
     *
     * @param string $phpcode 実行する php コード
     * @param array $contextvars コンテキスト変数配列
     * @param int $cachesize キャッシュするサイズ
     * @return mixed eval の return 値
     */
    function evaluate($phpcode, $contextvars = [], $cachesize = 256)
    {
        $cachefile = null;
        if ($cachesize && strlen($phpcode) >= $cachesize) {
            $cachefile = cachedir() . '/' . rawurlencode(__FUNCTION__) . '-' . sha1($phpcode) . '.php';
            if (!file_exists($cachefile)) {
                file_put_contents($cachefile, "<?php $phpcode", LOCK_EX);
            }
        }

        try {
            if ($cachefile) {
                /** @noinspection PhpMethodParametersCountMismatchInspection */
                return (static function () {
                    extract(func_get_arg(1));
                    return require func_get_arg(0);
                })($cachefile, $contextvars);
            }
            else {
                /** @noinspection PhpMethodParametersCountMismatchInspection */
                return (static function () {
                    extract(func_get_arg(1));
                    return eval(func_get_arg(0));
                })($phpcode, $contextvars);
            }
        }
        catch (\ParseError $ex) {
            $errline = $ex->getLine();
            $errline_1 = $errline - 1;
            $codes = preg_split('#\\R#u', $phpcode);
            $codes[$errline_1] = '>>> ' . $codes[$errline_1];

            $N = 5; // 前後の行数
            $message = $ex->getMessage();
            $message .= "\n" . implode("\n", array_slice($codes, max(0, $errline_1 - $N), $N * 2 + 1));
            if ($cachefile) {
                $message .= "\n in " . realpath($cachefile) . " on line " . $errline . "\n";
            }
            throw new \ParseError($message, $ex->getCode(), $ex);
        }
    }
}
if (function_exists("ryunosuke\\Functions\\evaluate") && !defined("ryunosuke\\Functions\\evaluate")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\evaluate", "ryunosuke\\Functions\\evaluate");
}

if (!isset($excluded_functions["parse_php"]) && (!function_exists("ryunosuke\\Functions\\parse_php") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\parse_php"))->isInternal()))) {
    /**
     * php のコード断片をパースする
     *
     * 結果配列は token_get_all したものだが、「字句の場合に文字列で返す」仕様は適用されずすべて配列で返す。
     * つまり必ず `[TOKENID, TOKEN, LINE, POS]` で返す。
     *
     * @todo 現在の仕様では php タグが自動で付与されるが、標準と異なり直感的ではないのでその仕様は除去する
     * @todo そもそも何がしたいのかよくわからない関数になってきたので動作の洗い出しが必要
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
     * that(implode('', array_column($part, 1)))->isSame('namespace Hogera;');
     *
     * // class ～ { を取得
     * $part = parse_php($phpcode, [
     *     'begin' => T_CLASS,
     *     'end'   => '{',
     * ]);
     * that(implode('', array_column($part, 1)))->isSame("class Example\n{");
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
            'phptag'         => true, // 初めに php タグを付けるか
            'short_open_tag' => null, // ショートオープンタグを扱うか（null だと余計なことはせず ini に従う）
            'line'           => [],   // 行の範囲（以上以下）
            'position'       => [],   // 文字位置の範囲（以上以下）
            'begin'          => [],   // 開始トークン
            'end'            => [],   // 終了トークン
            'offset'         => 0,    // 開始トークン位置
            'flags'          => 0,    // token_get_all の $flags. TOKEN_PARSE を与えると ParseError が出ることがあるのでデフォルト 0
            'cache'          => true, // キャッシュするか否か
            'nest_token'     => [
                ')' => '(',
                '}' => '{',
                ']' => '[',
            ],
        ];
        $option += $default;

        $cachekey = var_hash($phpcode) . $option['flags'] . '-' . $option['phptag'] . '-' . var_export($option['short_open_tag'], true);
        static $cache = [];
        if (!($option['cache'] && isset($cache[$cachekey]))) {
            $phptag = $option['phptag'] ? '<?php ' : '';
            $phpcode = $phptag . $phpcode;
            $position = -strlen($phptag);

            $tokens = [];
            $tmp = token_get_all($phpcode, $option['flags']);
            for ($i = 0; $i < count($tmp); $i++) {
                $token = $tmp[$i];

                // token_get_all の結果は微妙に扱いづらいので少し調整する（string/array だったり、名前変換の必要があったり）
                if (!is_array($token)) {
                    $last = $tokens[count($tokens) - 1] ?? [null, 1, 0];
                    $token = [ord($token), $token, $last[2] + preg_match_all('/(?:\r\n|\r|\n)/', $last[1])];
                }

                // @codeCoverageIgnoreStart
                if ($option['short_open_tag'] === true && $token[0] === T_INLINE_HTML && ($p = strpos($token[1], '<?')) !== false) {
                    $newtokens = [];
                    $nlcount = 0;

                    if ($p !== 0) {
                        $html = substr($token[1], 0, $p);
                        $nlcount = preg_match_all('#\r\n|\r|\n#u', $html);
                        $newtokens[] = [T_INLINE_HTML, $html, $token[2]];
                    }

                    $code = substr($token[1], $p + 2);
                    $subtokens = token_get_all("<?php $code");
                    $subtokens[0][1] = '<?';
                    foreach ($subtokens as $subtoken) {
                        if (is_array($subtoken)) {
                            $subtoken[2] += $token[2] + $nlcount - 1;
                        }
                        $newtokens[] = $subtoken;
                    }

                    array_splice($tmp, $i + 1, 0, $newtokens);
                    continue;
                }
                if ($option['short_open_tag'] === false && $token[0] === T_OPEN_TAG && $token[1] === '<?') {
                    for ($j = $i + 1; $j < count($tmp); $j++) {
                        if ($tmp[$j][0] === T_CLOSE_TAG) {
                            break;
                        }
                    }
                    $html = implode('', array_map(fn($token) => is_array($token) ? $token[1] : $token, array_slice($tmp, $i, $j - $i + 1)));
                    array_splice($tmp, $i + 1, $j - $i, [[T_INLINE_HTML, $html, $token[2]]]);
                    continue;
                }
                // @codeCoverageIgnoreEnd

                $token[] = $position;
                if ($option['flags'] & TOKEN_NAME) {
                    $token[] = token_name($token[0]);
                }

                $position += strlen($token[1]);
                $tokens[] = $token;
            }
            // @codeCoverageIgnoreStart
            if ($option['short_open_tag'] === false) {
                for ($i = 0; $i < count($tokens); $i++) {
                    if ($tokens[$i][0] === T_INLINE_HTML && isset($tokens[$i + 1]) && $tokens[$i + 1][0] === T_INLINE_HTML) {
                        $tokens[$i][1] .= $tokens[$i + 1][1];
                        array_splice($tokens, $i + 1, 1, []);
                        $i--;
                    }
                }
            }
            // @codeCoverageIgnoreEnd
            $cache[$cachekey] = $tokens;
        }
        $tokens = $cache[$cachekey];

        $lines = $option['line'] + [-PHP_INT_MAX, PHP_INT_MAX];
        $positions = $option['position'] + [-PHP_INT_MAX, PHP_INT_MAX];
        $begin_tokens = (array) $option['begin'];
        $end_tokens = (array) $option['end'];
        $nest_tokens = $option['nest_token'];

        $result = [];
        $starting = !$begin_tokens;
        $nesting = 0;
        $offset = is_array($option['offset']) ? ($option['offset'][0] ?? 0) : $option['offset'];
        $endset = is_array($option['offset']) ? ($option['offset'][1] ?? count($tokens)) : count($tokens);

        for ($i = $offset; $i < $endset; $i++) {
            $token = $tokens[$i];

            if ($lines[0] > $token[2]) {
                continue;
            }
            if ($lines[1] < $token[2]) {
                continue;
            }
            if ($positions[0] > $token[3]) {
                continue;
            }
            if ($positions[1] < $token[3]) {
                continue;
            }

            foreach ($begin_tokens as $t) {
                if ($t === $token[0] || $t === $token[1]) {
                    $starting = true;
                    break;
                }
            }
            if (!$starting) {
                continue;
            }

            $result[$i] = $token;

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
if (function_exists("ryunosuke\\Functions\\parse_php") && !defined("ryunosuke\\Functions\\parse_php")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\parse_php", "ryunosuke\\Functions\\parse_php");
}

if (!isset($excluded_functions["strip_php"]) && (!function_exists("ryunosuke\\Functions\\strip_php") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\strip_php"))->isInternal()))) {
    /**
     * 文字列から php コードを取り除く
     *
     * 正確にはオプションの replacer で指定したものに置換される（デフォルト空文字なので削除になる）。
     * replacer にクロージャを渡すと(phpコード, 出現番号) が渡ってくるので、それに応じて値を返せばそれに置換される。
     * 文字列を指定すると自動で出現番号が付与される。
     *
     * 歴史的な理由によりオプションには直接 replacer を渡せるが、互換性のためでありその指定は推奨されない。
     *
     * $mapping 配列には「どれをどのように」と言った変換表が格納される。
     * 典型的には strtr に渡して php コードを復元させるのに使用する。
     *
     * Example:
     * ```php
     * $phtml = 'begin php code <?php echo 123 ?> end';
     * // php コードが消えている
     * that(strip_php($phtml))->is('begin php code  end');
     * // $mapping を使用すると元の文字列に復元できる
     * $html = strip_php($phtml, null, $mapping);
     * that(strtr($html, $mapping))->is($phtml);
     * ```
     *
     * @param string $phtml php コードを含む文字列
     * @param array|string|\Closure $option オプション配列
     * @param array $mapping 変換表が格納される参照変数
     * @return string php コードが除かれた文字列
     */
    function strip_php($phtml, $option = [], &$mapping = [])
    {
        // for compatible
        if (!is_array($option)) {
            $option = [
                'replacer' => $option,
            ];
        }

        $option = array_replace([
            'short_open_tag' => true,
            'trailing_break' => true,
            'replacer'       => '',
        ], $option, [
            //'flags'  => TOKEN_NAME,
            //'cache'  => false,
            'phptag' => false,
        ]);

        $replacer = $option['replacer'];
        if ($replacer === '') {
            $replacer = fn($phptag, $n) => '';
        }
        if ($replacer === null) {
            $replacer = unique_string($phtml, 64);
        }

        $tmp = parse_php($phtml, $option);

        if ($option['trailing_break']) {
            $tokens = $tmp;
        }
        else {
            $tokens = [];
            $echoopen = false;
            $taglength = strlen('?>');
            foreach ($tmp as $token) {
                if ($token[0] === T_OPEN_TAG_WITH_ECHO) {
                    $echoopen = true;
                }
                if ($echoopen && $token[0] === T_CLOSE_TAG && isset($token[1][$taglength])) {
                    $echoopen = false;

                    $tokens[] = [
                        $token[0],
                        rtrim($token[1]),
                        $token[2],
                        $token[3],
                    ];
                    $tokens[] = [
                        T_INLINE_HTML,
                        substr($token[1], $taglength),
                        $token[2],
                        $token[3] + $taglength,
                    ];
                }
                else {
                    $tokens[] = $token;
                }
            }
        }

        $offsets = [];
        foreach ($tokens as $token) {
            if ($token[0] === T_OPEN_TAG || $token[0] === T_OPEN_TAG_WITH_ECHO) {
                $offsets[] = [$token[3], null];
            }
            elseif ($token[0] === T_CLOSE_TAG) {
                $lastkey = count($offsets) - 1;
                $offsets[$lastkey][1] = $token[3] + strlen($token[1]) - $offsets[$lastkey][0];
            }
        }
        if ($offsets) {
            $lastkey = count($offsets) - 1;
            $offsets[$lastkey][1] = $offsets[$lastkey][1] ?? strlen($phtml) - $offsets[$lastkey][0];
        }

        $mapping = [];
        foreach (array_reverse($offsets) as $n => [$offset, $length]) {
            if ($replacer instanceof \Closure) {
                $mapping[$n] = substr($phtml, $offset, $length);
                $phtml = substr_replace($phtml, $replacer($mapping[$n], $n), $offset, $length);
            }
            else {
                $tag = $replacer . $n;
                $mapping[$tag] = substr($phtml, $offset, $length);
                $phtml = substr_replace($phtml, $tag, $offset, $length);
            }
        }

        return $phtml;
    }
}
if (function_exists("ryunosuke\\Functions\\strip_php") && !defined("ryunosuke\\Functions\\strip_php")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\strip_php", "ryunosuke\\Functions\\strip_php");
}

if (!isset($excluded_functions["indent_php"]) && (!function_exists("ryunosuke\\Functions\\indent_php") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\indent_php"))->isInternal()))) {
    /**
     * php のコードのインデントを調整する
     *
     * baseline で基準インデント位置を指定する。
     * その基準インデントを削除した後、指定したインデントレベルでインデントするようなイメージ。
     *
     * Example:
     * ```php
     * $phpcode = '
     *     echo 123;
     *
     *     if (true) {
     *         echo 456;
     *     }
     * ';
     * // 数値指定は空白換算
     * that(indent_php($phpcode, 8))->isSame('
     *         echo 123;
     *
     *         if (true) {
     *             echo 456;
     *         }
     * ');
     * // 文字列を指定すればそれが使用される
     * that(indent_php($phpcode, "  "))->isSame('
     *   echo 123;
     *
     *   if (true) {
     *       echo 456;
     *   }
     * ');
     * // オプション指定
     * that(indent_php($phpcode, [
     *     'baseline'  => 1,    // 基準インデントの行番号（負数で下からの指定になる）
     *     'indent'    => 4,    // インデント指定（上記の数値・文字列指定はこれの糖衣構文）
     *     'trimempty' => true, // 空行を trim するか
     *     'heredoc'   => true, // Flexible Heredoc もインデントするか
     * ]))->isSame('
     *     echo 123;
     *
     *     if (true) {
     *         echo 456;
     *     }
     * ');
     * ```
     *
     * @param string $phpcode インデントする php コード
     * @param array|int|string $options オプション
     * @return string インデントされた php コード
     */
    function indent_php($phpcode, $options = [])
    {
        if (!is_array($options)) {
            $options = ['indent' => $options];
        }
        $options += [
            'baseline'  => 1,
            'indent'    => 0,
            'trimempty' => true,
            'heredoc'   => true,
        ];
        if (is_int($options['indent'])) {
            $options['indent'] = str_repeat(' ', $options['indent']);
        }

        $lines = preg_split('#\\R#u', $phpcode);
        $baseline = $options['baseline'];
        if ($baseline < 0) {
            $baseline = count($lines) + $baseline;
        }
        preg_match('@^[ \t]*@u', $lines[$baseline] ?? '', $matches);
        $indent = $matches[0] ?? '';

        $tmp = token_get_all("<?php $phpcode");
        array_shift($tmp);

        // トークンの正規化
        $tokens = [];
        for ($i = 0; $i < count($tmp); $i++) {
            if (is_string($tmp[$i])) {
                $tmp[$i] = [-1, $tmp[$i], null];
            }

            // 行コメントの分割（T_COMMENT には改行が含まれている）
            if ($tmp[$i][0] === T_COMMENT && preg_match('@^(#|//).*?(\\R)@um', $tmp[$i][1], $matches)) {
                $tmp[$i][1] = trim($tmp[$i][1]);
                if (($tmp[$i + 1][0] ?? null) === T_WHITESPACE) {
                    $tmp[$i + 1][1] = $matches[2] . $tmp[$i + 1][1];
                }
                else {
                    array_splice($tmp, $i + 1, 0, [[T_WHITESPACE, $matches[2], null]]);
                }
            }

            if ($options['heredoc']) {
                // 行コメントと同じ（T_START_HEREDOC には改行が含まれている）
                if ($tmp[$i][0] === T_START_HEREDOC && preg_match('@^(<<<).*?(\\R)@um', $tmp[$i][1], $matches)) {
                    $tmp[$i][1] = trim($tmp[$i][1]);
                    if (($tmp[$i + 1][0] ?? null) === T_ENCAPSED_AND_WHITESPACE) {
                        $tmp[$i + 1][1] = $matches[2] . $tmp[$i + 1][1];
                    }
                    else {
                        array_splice($tmp, $i + 1, 0, [[T_ENCAPSED_AND_WHITESPACE, $matches[2], null]]);
                    }
                }
                // php 7.3 において T_END_HEREDOC は必ず単一行になる
                if ($tmp[$i][0] === T_ENCAPSED_AND_WHITESPACE) {
                    if (($tmp[$i + 1][0] ?? null) === T_END_HEREDOC && preg_match('@^(\\s+)(.*)@um', $tmp[$i + 1][1], $matches)) {
                        $tmp[$i][1] = $tmp[$i][1] . $matches[1];
                        $tmp[$i + 1][1] = $matches[2];
                    }
                }
            }

            $tokens[] = $tmp[$i] + [3 => token_name($tmp[$i][0])];
        }

        // 改行を置換してインデント
        $hereing = false;
        foreach ($tokens as $i => $token) {
            if ($options['heredoc']) {
                if ($token[0] === T_START_HEREDOC) {
                    $hereing = true;
                }
                if ($token[0] === T_END_HEREDOC) {
                    $hereing = false;
                }
            }
            if (in_array($token[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true) || ($hereing && $token[0] === T_ENCAPSED_AND_WHITESPACE)) {
                $token[1] = preg_replace("@(\\R)$indent@um", '$1' . $options['indent'], $token[1]);
            }
            if ($options['trimempty']) {
                if ($token[0] === T_WHITESPACE) {
                    $token[1] = preg_replace("@(\\R)[ \\t]+(\\R)@um", '$1$2', $token[1]);
                }
            }

            $tokens[$i] = $token;
        }
        return implode('', array_column($tokens, 1));
    }
}
if (function_exists("ryunosuke\\Functions\\indent_php") && !defined("ryunosuke\\Functions\\indent_php")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\indent_php", "ryunosuke\\Functions\\indent_php");
}

if (!isset($excluded_functions["highlight_php"]) && (!function_exists("ryunosuke\\Functions\\highlight_php") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\highlight_php"))->isInternal()))) {
    /**
     * php のコードをハイライトする
     *
     * SAPI に応じて自動でハイライトする（html タグだったり ASCII color だったり）。
     * highlight_string の CLI 対応版とも言える。
     *
     * @param string $phpcode ハイライトする php コード
     * @param array|int $options オプション
     * @return string ハイライトされた php コード
     */
    function highlight_php($phpcode, $options = [])
    {
        $options += [
            'context' => null,
        ];

        $context = $options['context'];

        if ($context === null) {
            $context = 'html'; // SAPI でテストカバレッジが辛いので if else ではなくデフォルト代入にしてある
            if (PHP_SAPI === 'cli') {
                $context = is_ansi(STDOUT) ? 'cli' : 'plain';
            }
        }

        $colorize = static function ($value, $style) use ($context) {
            switch ($context) {
                default:
                    throw new \InvalidArgumentException("'$context' is not supported.");
                case 'plain':
                    return $value;
                case 'cli':
                    return ansi_colorize($value, $style);
                case 'html':
                    $names = array_flip(preg_split('#[^a-z]#i', $style));
                    $keys = [
                        'bold'       => 'font-weight:bold',
                        'faint'      => '',
                        'italic'     => 'font-style:italic',
                        'underscore' => 'text-decoration:underline',
                        'blink'      => '',
                        'reverse'    => '',
                        'conceal'    => '',
                    ];
                    $colors = array_keys(array_diff_key($names, $keys));
                    $styles = array_intersect_key($keys, $names);
                    $styles[] = 'color:' . reset($colors);
                    $style = implode(';', $styles);
                    return "<span style='$style'>" . htmlspecialchars($value, ENT_QUOTES) . '</span>';
            }
        };

        $type = 'bold';
        $keyword = 'magenta|bold';
        $symbol = 'green|italic';
        $literal = 'red';
        $variable = 'underscore';
        $comment = 'blue|italic';

        $rules = [
            'null'                     => $type,
            'false'                    => $type,
            'true'                     => $type,
            'iterable'                 => $type,
            'bool'                     => $type,
            'float'                    => $type,
            'int'                      => $type,
            'string'                   => $type,
            T_ABSTRACT                 => $keyword,
            T_ARRAY                    => $keyword,
            T_CALLABLE                 => $keyword,
            T_CLASS_C                  => $keyword,
            T_DIR                      => $keyword,
            T_FILE                     => $keyword,
            T_FUNC_C                   => $keyword,
            T_LINE                     => $keyword,
            T_METHOD_C                 => $keyword,
            T_NS_C                     => $keyword,
            T_TRAIT_C                  => $keyword,
            T_AS                       => $keyword,
            T_BOOLEAN_AND              => $keyword,
            T_BOOLEAN_OR               => $keyword,
            T_BREAK                    => $keyword,
            T_CASE                     => $keyword,
            T_CATCH                    => $keyword,
            T_CLASS                    => $keyword,
            T_CLONE                    => $keyword,
            T_CONST                    => $keyword,
            T_CONTINUE                 => $keyword,
            T_DECLARE                  => $keyword,
            T_DEFAULT                  => $keyword,
            T_DO                       => $keyword,
            T_ELSE                     => $keyword,
            T_ELSEIF                   => $keyword,
            T_ENDDECLARE               => $keyword,
            T_ENDFOR                   => $keyword,
            T_ENDFOREACH               => $keyword,
            T_ENDIF                    => $keyword,
            T_ENDSWITCH                => $keyword,
            T_ENDWHILE                 => $keyword,
            T_END_HEREDOC              => $keyword,
            T_EXIT                     => $keyword,
            T_EXTENDS                  => $keyword,
            T_FINAL                    => $keyword,
            T_FINALLY                  => $keyword,
            T_FOR                      => $keyword,
            T_FOREACH                  => $keyword,
            T_ECHO                     => $keyword,
            T_FUNCTION                 => $keyword,
            T_GLOBAL                   => $keyword,
            T_GOTO                     => $keyword,
            T_IF                       => $keyword,
            T_IMPLEMENTS               => $keyword,
            T_INSTANCEOF               => $keyword,
            T_INSTEADOF                => $keyword,
            T_INTERFACE                => $keyword,
            T_LOGICAL_AND              => $keyword,
            T_LOGICAL_OR               => $keyword,
            T_LOGICAL_XOR              => $keyword,
            T_NAMESPACE                => $keyword,
            T_NEW                      => $keyword,
            T_PRIVATE                  => $keyword,
            T_PUBLIC                   => $keyword,
            T_PROTECTED                => $keyword,
            T_RETURN                   => $keyword,
            T_STATIC                   => $keyword,
            T_SWITCH                   => $keyword,
            T_THROW                    => $keyword,
            T_TRAIT                    => $keyword,
            T_TRY                      => $keyword,
            T_USE                      => $keyword,
            T_VAR                      => $keyword,
            T_WHILE                    => $keyword,
            T_YIELD                    => $keyword,
            T_YIELD_FROM               => $keyword,
            T_EMPTY                    => $keyword,
            T_EVAL                     => $keyword,
            T_ISSET                    => $keyword,
            T_LIST                     => $keyword,
            T_PRINT                    => $keyword,
            T_UNSET                    => $keyword,
            T_INCLUDE                  => $keyword,
            T_INCLUDE_ONCE             => $keyword,
            T_REQUIRE                  => $keyword,
            T_REQUIRE_ONCE             => $keyword,
            T_HALT_COMPILER            => $keyword,
            T_STRING                   => $symbol,
            T_CONSTANT_ENCAPSED_STRING => $literal,
            T_ENCAPSED_AND_WHITESPACE  => $literal,
            T_NUM_STRING               => $literal,
            T_DNUMBER                  => $literal,
            T_LNUMBER                  => $literal,
            // T_STRING_VARNAME           => $literal,
            // T_CURLY_OPEN               => $literal,
            // T_DOLLAR_OPEN_CURLY_BRACES => $literal,
            '"'                        => $literal,
            T_VARIABLE                 => $variable,
            T_COMMENT                  => $comment,
            T_DOC_COMMENT              => $comment,
        ];

        $tokens = token_get_all($phpcode, TOKEN_PARSE);
        foreach ($tokens as $n => $token) {
            if (is_string($token)) {
                $token = [null, $token, null];
            }

            $style = $rules[strtolower($token[1])] ?? $rules[$token[0]] ?? null;
            if ($style !== null) {
                $token[1] = $colorize($token[1], $style);
            }
            $tokens[$n] = $token;
        }
        return implode('', array_column($tokens, 1));
    }
}
if (function_exists("ryunosuke\\Functions\\highlight_php") && !defined("ryunosuke\\Functions\\highlight_php")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\highlight_php", "ryunosuke\\Functions\\highlight_php");
}

if (!isset($excluded_functions["optional"]) && (!function_exists("ryunosuke\\Functions\\optional") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\optional"))->isInternal()))) {
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
     * $getobject = fn () => null;
     * // メソッド呼び出しは null を返す
     * that(optional($getobject())->method())->isSame(null);
     * // プロパティアクセスは null を返す
     * that(optional($getobject())->property)->isSame(null);
     * // empty は true を返す
     * that(empty(optional($getobject())->nothing))->isSame(true);
     * // __isset は false を返す
     * that(isset(optional($getobject())->nothing))->isSame(false);
     * // __toString は '' を返す
     * that(strval(optional($getobject())))->isSame('');
     * // __invoke は null を返す
     * that(call_user_func(optional($getobject())))->isSame(null);
     * // 配列アクセスは null を返す
     * that(optional($getobject())['hoge'])->isSame(null);
     * // 空イテレータを返す
     * that(iterator_to_array(optional($getobject())))->isSame([]);
     *
     * // $expected を与えるとその型以外は NullObject を返す（\ArrayObject はオブジェクトだが stdClass ではない）
     * that(optional(new \ArrayObject([1]), 'stdClass')->count())->isSame(null);
     * ```
     *
     * @template T
     * @param T|null $object オブジェクト
     * @param ?string $expected 期待するクラス名。指定した場合は is_a される
     * @return T $object がオブジェクトならそのまま返し、違うなら NullObject を返す
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
            $nullobject = new class implements \ArrayAccess, \IteratorAggregate {
                // @formatter:off
                public function __isset($name) { return false; }
                public function __get($name) { return null; }
                public function __set($name, $value) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function __unset($name) { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function __call($name, $arguments) { return null; }
                public function __invoke() { return null; }
                public function __toString() { return ''; }
                public function offsetExists($offset): bool { return false; }
                public function offsetGet($offset): ?string { return null; }
                public function offsetSet($offset, $value): void { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function offsetUnset($offset): void { throw new \DomainException('called NullObject#' . __FUNCTION__); }
                public function getIterator(): \Traversable { return new \ArrayIterator([]); }
                // @formatter:on
            };
        }
        return $nullobject;
    }
}
if (function_exists("ryunosuke\\Functions\\optional") && !defined("ryunosuke\\Functions\\optional")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\optional", "ryunosuke\\Functions\\optional");
}

if (!isset($excluded_functions["chain"]) && (!function_exists("ryunosuke\\Functions\\chain") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\chain"))->isInternal()))) {
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
     *   - 省略した結果、他の関数と被るようであれば短縮呼び出しは出来ない（array_優先でコールされる）
     *   - ini に 'rfunc.chain_overload' 定義されていれば型で分岐させることができる
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
     * なお、最初の引数を省略するとスタックモードになり、一切の処理が適用されなくなる。
     * その代わり `invoke` で遅延的に値を渡すことができるようになる。
     * 「処理の流れだけ決めておいて後で適用する」イメージ。
     *
     * Example:
     * ```php
     * # 1～9 のうち「5以下を抽出」して「値を2倍」して「合計」を出すシチュエーション
     * $n1_9 = range(1, 9);
     * // 素の php で処理したもの。パッと見で何してるか分からないし、処理の順番が思考と逆なので混乱する
     * that(array_sum(array_map(fn($v) => $v * 2, array_filter($n1_9, fn($v) => $v <= 5))))->isSame(30);
     * // chain でクロージャを渡したもの。処理の順番が思考どおりだが、 fn() が微妙にうざい（array_ は省略できるので filter, map, sum のような呼び出しができている）
     * that(chain($n1_9)->filter(fn($v) => $v <= 5)->map(fn($v) => $v * 2)->sum()())->isSame(30);
     * // funcP を介して fn() をなくしたもの。ここまで来ると若干読みやすい
     * that(chain($n1_9)->filterP(['<=' => 5])->mapP(['*' => 2])->sum()())->isSame(30);
     * // funcE を介したもの。かなり直感的だが eval なので少し不安
     * that(chain($n1_9)->filterE('<= 5')->mapE('* 2')->sum()())->isSame(30);
     *
     * # "hello   world" を「" " で分解」して「空文字を除去」してそれぞれに「ucfirst」して「"/" で結合」して「rot13」して「md5」して「大文字化」するシチュエーション
     * $string = 'hello   world';
     * // 素の php で処理したもの。もはやなにがなんだか分からない
     * that(strtoupper(md5(str_rot13(implode('/', array_map('ucfirst', array_filter(explode(' ', $string))))))))->isSame('10AF4DAF67D0D666FCEA0A8C6EF57EE7');
     * // chain だとかなりそれっぽくできる。 explode/implode の第1引数は区切り文字なので func1 構文を使用している。また、 rot13 以降は引数がないので () を省略している
     * that(chain($string)->explode1(' ')->filter()->map('ucfirst')->implode1('/')->rot13->md5->strtoupper()())->isSame('10AF4DAF67D0D666FCEA0A8C6EF57EE7');
     *
     *  # よくある DB レコードをあれこれするシチュエーション
     * $rows = [
     *     ['id' => 1, 'name' => 'hoge', 'sex' => 'F', 'age' => 17, 'salary' => 230000],
     *     ['id' => 3, 'name' => 'fuga', 'sex' => 'M', 'age' => 43, 'salary' => 480000],
     *     ['id' => 7, 'name' => 'piyo', 'sex' => 'M', 'age' => 21, 'salary' => 270000],
     *     ['id' => 9, 'name' => 'hage', 'sex' => 'F', 'age' => 30, 'salary' => 320000],
     * ];
     * // e.g. 男性の平均給料
     * that(chain($rows)->whereP('sex', ['===' => 'M'])->column('salary')->mean()())->isSame(375000);
     * // e.g. 女性の平均年齢
     * that(chain($rows)->whereE('sex', '=== "F"')->column('age')->mean()())->isSame(23.5);
     * // e.g. 30歳以上の平均給料
     * that(chain($rows)->whereP('age', ['>=' => 30])->column('salary')->mean()())->isSame(400000);
     * // e.g. 20～30歳の平均給料
     * that(chain($rows)->whereP('age', ['>=' => 20])->whereE('age', '<= 30')->column('salary')->mean()())->isSame(295000);
     * // e.g. 男性の最小年齢
     * that(chain($rows)->whereP('sex', ['===' => 'M'])->column('age')->min()())->isSame(21);
     * // e.g. 女性の最大給料
     * that(chain($rows)->whereE('sex', '=== "F"')->column('salary')->max()())->isSame(320000);
     *
     * # 上記の引数遅延モード（結果は同じなのでいくつかピックアップ）
     * that(chain()->whereP('sex', ['===' => 'M'])->column('salary')->mean()($rows))->isSame(375000);
     * that(chain()->whereP('age', ['>=' => 30])->column('salary')->mean()($rows))->isSame(400000);
     * that(chain()->whereP('sex', ['===' => 'M'])->column('age')->min()($rows))->isSame(21);
     * ```
     *
     * @param mixed $source 元データ
     * @return \ChainObject
     */
    function chain($source = null)
    {
        return new class(...func_get_args()) implements \IteratorAggregate {
            private $data;
            private $stack;

            public function __construct($source = null)
            {
                if (func_num_args() === 0) {
                    $this->stack = [];
                }
                $this->data = $source;
            }

            public function __invoke(...$source)
            {
                $func_num_args = func_num_args();

                if ($this->stack !== null && $func_num_args === 0) {
                    throw new \InvalidArgumentException('nonempty stack and no parameter given. maybe invalid __invoke args.');
                }
                if ($this->stack === null && $func_num_args > 0) {
                    throw new \UnexpectedValueException('empty stack and parameter given > 0. maybe invalid __invoke args.');
                }

                if ($func_num_args > 0) {
                    $result = [];
                    foreach ($source as $s) {
                        $chain = chain($s);
                        foreach ($this->stack as $stack) {
                            $chain->{$stack[0]}(...$stack[1]);
                        }
                        $result[] = $chain();
                    }
                    return $func_num_args === 1 ? reset($result) : $result;
                }
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

            public function getIterator(): \Traversable
            {
                foreach ($this->data as $k => $v) {
                    yield $k => $v;
                }
            }

            public function apply($callback, ...$args)
            {
                if (is_array($this->stack)) {
                    $this->stack[] = [__FUNCTION__, func_get_args()];
                    return $this;
                }

                $this->data = $callback($this->data, ...$args);
                return $this;
            }

            private function _resolve($name)
            {
                $overload = get_cfg_var('rfunc.chain_overload') ?: false; // for compatible
                $isiterable = !$overload || is_iterable($this->data);
                if (false
                    // for global
                    || (function_exists($fname = $name))
                    || ($isiterable && function_exists($fname = "array_$name"))
                    || (function_exists($fname = "str_$name"))
                    // for package
                    || (defined($cname = $name) && is_callable($fname = constant($cname)))
                    || ($isiterable && defined($cname = "array_$name") && is_callable($fname = constant($cname)))
                    || (defined($cname = "str_$name") && is_callable($fname = constant($cname)))
                    // for namespace
                    || (defined($cname = __NAMESPACE__ . "\\$name") && is_callable($fname = constant($cname)))
                    || ($isiterable && defined($cname = __NAMESPACE__ . "\\array_$name") && is_callable($fname = constant($cname)))
                    || (defined($cname = __NAMESPACE__ . "\\str_$name") && is_callable($fname = constant($cname)))
                    // for class
                    || (defined($cname = __CLASS__ . "::$name") && is_callable($fname = constant($cname)))
                    || ($isiterable && defined($cname = __CLASS__ . "::array_$name") && is_callable($fname = constant($cname)))
                    || (defined($cname = __CLASS__ . "::str_$name") && is_callable($fname = constant($cname)))
                ) {
                    return $fname;
                }
            }

            private function _apply($name, $arguments)
            {
                if (is_array($this->stack)) {
                    $this->stack[] = [$name, $arguments];
                    return $this;
                }

                // 特別扱い1: map は非常によく呼ぶので引数を補正する
                if ($name === 'map') {
                    return $this->_apply('array_map1', $arguments);
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
if (function_exists("ryunosuke\\Functions\\chain") && !defined("ryunosuke\\Functions\\chain")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\chain", "ryunosuke\\Functions\\chain");
}

if (!isset($excluded_functions["throws"]) && (!function_exists("ryunosuke\\Functions\\throws") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\throws"))->isInternal()))) {
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
     *     that($ex->getMessage())->isSame('throws');
     * }
     * ```
     *
     * @param \Exception $ex 投げる例外
     * @return mixed （`return hoge or throws` のようなコードで警告が出るので抑止用）
     */
    function throws($ex)
    {
        throw $ex;
    }
}
if (function_exists("ryunosuke\\Functions\\throws") && !defined("ryunosuke\\Functions\\throws")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\throws", "ryunosuke\\Functions\\throws");
}

if (!isset($excluded_functions["throw_if"]) && (!function_exists("ryunosuke\\Functions\\throw_if") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\throw_if"))->isInternal()))) {
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
if (function_exists("ryunosuke\\Functions\\throw_if") && !defined("ryunosuke\\Functions\\throw_if")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\throw_if", "ryunosuke\\Functions\\throw_if");
}

if (!isset($excluded_functions["blank_if"]) && (!function_exists("ryunosuke\\Functions\\blank_if") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\blank_if"))->isInternal()))) {
    /**
     * 値が空なら null を返す
     *
     * `is_empty($value) ? $value : null` とほぼ同じ。
     * 言ってしまえば「falsy な値を null に変換する」とも言える。
     *
     * ここでいう falsy とは php 標準の `empty` ではなく本ライブラリの `is_empty` であることに留意（"0" は空ではない）。
     * さらに利便性のため 0, 0.0 も空ではない判定をする（strpos や array_search などで「0 は意味のある値」という事が多いので）。
     * 乱暴に言えば「仮に文字列化したとき、情報量がゼロ」が falsy になる。
     *
     * - 「 `$var ?: 'default'` で十分なんだけど "0" が…」
     * - 「 `$var ?? 'default'` で十分なんだけど false が…」
     *
     * という状況はまれによくあるはず。
     *
     * ?? との親和性のため null を返す動作がデフォルトだが、そのデフォルト値は引数で渡すこともできる。
     * 用途は Example を参照。
     *
     * Example:
     * ```php
     * // falsy な値は null を返すので null 合体演算子でデフォルト値が得られる
     * that(blank_if(null) ?? 'default')->isSame('default');
     * that(blank_if('')   ?? 'default')->isSame('default');
     * // falsy じゃない値の場合は引数をそのまま返すので null 合体演算子には反応しない
     * that(blank_if(0)   ?? 'default')->isSame(0);   // 0 は空ではない
     * that(blank_if('0') ?? 'default')->isSame('0'); // "0" は空ではない
     * that(blank_if(1)   ?? 'default')->isSame(1);
     * that(blank_if('X') ?? 'default')->isSame('X');
     * // 第2引数で返る値を指定できるので下記も等価となる。ただし、php の仕様上第2引数が必ず評価されるため、関数呼び出しなどだと無駄な処理となる
     * that(blank_if(null, 'default'))->isSame('default');
     * that(blank_if('',   'default'))->isSame('default');
     * that(blank_if(0,    'default'))->isSame(0);
     * that(blank_if('0',  'default'))->isSame('0');
     * that(blank_if(1,    'default'))->isSame(1);
     * that(blank_if('X',  'default'))->isSame('X');
     * // 第2引数の用途は少し短く書けることと演算子の優先順位のつらみの回避程度（`??` は結構優先順位が低い。下記を参照）
     * that(0 < blank_if(null) ?? 1)->isFalse();  // (0 < null) ?? 1 となるので false
     * that(0 < blank_if(null, 1))->isTrue();     // 0 < 1 となるので true
     * that(0 < (blank_if(null) ?? 1))->isTrue(); // ?? で同じことしたいならこのように括弧が必要
     *
     * # ここから下は既存言語機構との比較（愚痴っぽいので読まなくてもよい）
     *
     * // エルビス演算子は "0" にも反応するので正直言って使いづらい（php における falsy の定義は広すぎる）
     * that(null ?: 'default')->isSame('default');
     * that(''   ?: 'default')->isSame('default');
     * that(1    ?: 'default')->isSame(1);
     * that('0'  ?: 'default')->isSame('default'); // こいつが反応してしまう
     * that('X'  ?: 'default')->isSame('X');
     * // 逆に null 合体演算子は null にしか反応しないので微妙に使い勝手が悪い（php の標準関数が false を返したりするし）
     * that(null ?? 'default')->isSame('default'); // こいつしか反応しない
     * that(''   ?? 'default')->isSame('');
     * that(1    ?? 'default')->isSame(1);
     * that('0'  ?? 'default')->isSame('0');
     * that('X'  ?? 'default')->isSame('X');
     * // 恣意的な例だが、 array_search は false も 0 も返し得るので ?: は使えない。 null を返すこともないので ?? も使えない（エラーも吐かない）
     * that(array_search('a', ['a', 'b', 'c']) ?: 'default')->isSame('default'); // 見つかったのに 0 に反応するので 'default' になってしまう
     * that(array_search('x', ['a', 'b', 'c']) ?? 'default')->isSame(false);     // 見つからないので 'default' としたいが false になってしまう
     * // 要するに単に「見つからなかった場合に 'default' としたい」だけなんだが、下記のようにめんどくさいことをせざるを得ない
     * that(array_search('x', ['a', 'b', 'c']) === false ? 'default' : array_search('x', ['a', 'b', 'c']))->isSame('default'); // 3項演算子で2回呼ぶ
     * that(($tmp = array_search('x', ['a', 'b', 'c']) === false) ? 'default' : $tmp)->isSame('default');                      // 一時変数を使用する（あるいは if 文）
     * // このように書きたかった
     * that(blank_if(array_search('x', ['a', 'b', 'c'])) ?? 'default')->isSame('default'); // null 合体演算子版
     * that(blank_if(array_search('x', ['a', 'b', 'c']), 'default'))->isSame('default');   // 第2引数版
     * ```
     *
     * @param mixed $var 判定する値
     * @param mixed $default 空だった場合のデフォルト値
     * @return mixed 空なら $default, 空じゃないなら $var をそのまま返す
     */
    function blank_if($var, $default = null)
    {
        if (is_object($var)) {
            // 文字列化できるかが優先
            if (is_stringable($var)) {
                return strlen($var) ? $var : $default;
            }
            // 次点で countable
            if (is_countable($var)) {
                return count($var) ? $var : $default;
            }
            return $var;
        }

        // 0, 0.0, "0" は false
        if ($var === 0 || $var === 0.0 || $var === '0') {
            return $var;
        }

        // 上記以外は empty に任せる
        return empty($var) ? $default : $var;
    }
}
if (function_exists("ryunosuke\\Functions\\blank_if") && !defined("ryunosuke\\Functions\\blank_if")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\blank_if", "ryunosuke\\Functions\\blank_if");
}

if (!isset($excluded_functions["call_if"]) && (!function_exists("ryunosuke\\Functions\\call_if") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\call_if"))->isInternal()))) {
    /**
     * 条件を満たしたときにコールバックを実行する
     *
     * `if ($condition) $callable(...$arguments);` と（$condition はクロージャを受け入れるけど）ほぼ同じ。
     * ただし、 $condition に数値を与えると「指定回数呼ばれたあとに実行する」という意味になる。
     * 主に「ループ内でデバッグ出力したいけど、毎回だと少しうざい」というデバッグ用途。
     *
     * $condition が正数だと「指定回数呼ばれた次のみ」負数だと「指定回数呼ばれた次以降」実行される。
     * 0 のときは無条件で実行される。
     *
     * Example:
     * ```php
     * $output = [];
     * $debug_print = function ($debug) use (&$output) { $output[] = $debug; };
     * for ($i=0; $i<4; $i++) {
     *     call_if($i == 1, $debug_print, '$i == 1のとき呼ばれた');
     *     call_if(2, $debug_print, '2回呼ばれた');
     *     call_if(-2, $debug_print, '2回以上呼ばれた');
     * }
     * that($output)->isSame([
     *     '$i == 1のとき呼ばれた',
     *     '2回呼ばれた',
     *     '2回以上呼ばれた',
     *     '2回以上呼ばれた',
     * ]);
     * ```
     *
     * @param mixed $condition 呼ばれる条件
     * @param callable $callable 呼ばれる処理
     * @param mixed ...$arguments $callable の引数（可変引数）
     * @return mixed 呼ばれた場合は $callable の返り値
     */
    function call_if($condition, $callable, ...$arguments)
    {
        // 数値の場合はかなり特殊な動きになる
        if (is_int($condition)) {
            static $counts = [];
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
            $caller = $trace['file'] . '#' . $trace['line'];
            $counts[$caller] ??= 0;
            if ($condition === 0) {
                $condition = true;
            }
            elseif ($condition > 0) {
                $condition = $condition === $counts[$caller]++;
            }
            else {
                $condition = -$condition <= $counts[$caller]++;
            }
        }
        elseif (is_callable($condition)) {
            $condition = (func_user_func_array($condition))();
        }

        if ($condition) {
            return $callable(...$arguments);
        }
        return null;
    }
}
if (function_exists("ryunosuke\\Functions\\call_if") && !defined("ryunosuke\\Functions\\call_if")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\call_if", "ryunosuke\\Functions\\call_if");
}

if (!isset($excluded_functions["switchs"]) && (!function_exists("ryunosuke\\Functions\\switchs") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\switchs"))->isInternal()))) {
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
     *     2 => fn() => 'value is 2',
     * ];
     * that(switchs(1, $cases))->isSame('value is 1');
     * that(switchs(2, $cases))->isSame('value is 2');
     * that(switchs(3, $cases, 'undefined'))->isSame('undefined');
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
if (function_exists("ryunosuke\\Functions\\switchs") && !defined("ryunosuke\\Functions\\switchs")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\switchs", "ryunosuke\\Functions\\switchs");
}

if (!isset($excluded_functions["try_null"]) && (!function_exists("ryunosuke\\Functions\\try_null") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\try_null"))->isInternal()))) {
    /**
     * 例外を握りつぶす try 構文
     *
     * 例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * // 例外が飛ばない場合は平和極まりない
     * $try = function ($a, $b, $c) {return [$a, $b, $c];};
     * that(try_null($try, 1, 2, 3))->isSame([1, 2, 3]);
     * // 例外が飛ぶ場合は null が返ってくる
     * $try = function () {throw new \Exception('tried');};
     * that(try_null($try))->isSame(null);
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param mixed ...$variadic $try に渡る引数
     * @return mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら null
     */
    function try_null($try, ...$variadic)
    {
        try {
            return $try(...$variadic);
        }
        catch (\Exception $tried_ex) {
            return null;
        }
    }
}
if (function_exists("ryunosuke\\Functions\\try_null") && !defined("ryunosuke\\Functions\\try_null")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\try_null", "ryunosuke\\Functions\\try_null");
}

if (!isset($excluded_functions["try_return"]) && (!function_exists("ryunosuke\\Functions\\try_return") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\try_return"))->isInternal()))) {
    /**
     * 例外が飛んだら例外オブジェクトを返す
     *
     * 例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * // 例外が飛ばない場合は平和極まりない
     * $try = function ($a, $b, $c) {return [$a, $b, $c];};
     * that(try_return($try, 1, 2, 3))->isSame([1, 2, 3]);
     * // 例外が飛ぶ場合は例外オブジェクトが返ってくる
     * $try = function () {throw new \Exception('tried');};
     * that(try_return($try))->IsInstanceOf(\Exception::class);
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param mixed ...$variadic $try に渡る引数
     * @return mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら null
     */
    function try_return($try, ...$variadic)
    {
        try {
            return $try(...$variadic);
        }
        catch (\Exception $tried_ex) {
            return $tried_ex;
        }
    }
}
if (function_exists("ryunosuke\\Functions\\try_return") && !defined("ryunosuke\\Functions\\try_return")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\try_return", "ryunosuke\\Functions\\try_return");
}

if (!isset($excluded_functions["try_catch"]) && (!function_exists("ryunosuke\\Functions\\try_catch") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\try_catch"))->isInternal()))) {
    /**
     * try ～ catch 構文の関数版
     *
     * 例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * // 例外が飛ばない場合は平和極まりない
     * $try = function ($a, $b, $c) {return [$a, $b, $c];};
     * that(try_catch($try, null, 1, 2, 3))->isSame([1, 2, 3]);
     * // 例外が飛ぶ場合は特殊なことをしなければ例外オブジェクトが返ってくる
     * $try = function () {throw new \Exception('tried');};
     * that(try_catch($try)->getMessage())->isSame('tried');
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param ?callable $catch catch ブロッククロージャ
     * @param mixed ...$variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    function try_catch($try, $catch = null, ...$variadic)
    {
        return try_catch_finally($try, $catch, null, ...$variadic);
    }
}
if (function_exists("ryunosuke\\Functions\\try_catch") && !defined("ryunosuke\\Functions\\try_catch")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\try_catch", "ryunosuke\\Functions\\try_catch");
}

if (!isset($excluded_functions["try_finally"]) && (!function_exists("ryunosuke\\Functions\\try_finally") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\try_finally"))->isInternal()))) {
    /**
     * try ～ finally 構文の関数版
     *
     * 例外は投げっぱなす。例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * $finally_count = 0;
     * $finally = function () use (&$finally_count) {$finally_count++;};
     * // 例外が飛ぼうと飛ぶまいと $finally は実行される
     * $try = function ($a, $b, $c) {return [$a, $b, $c];};
     * that(try_finally($try, $finally, 1, 2, 3))->isSame([1, 2, 3]);
     * that($finally_count)->isSame(1); // 呼ばれている
     * // 例外は投げっぱなすが、 $finally は実行される
     * $try = function () {throw new \Exception('tried');};
     * try {try_finally($try, $finally, 1, 2, 3);} catch(\Exception $e){}
     * that($finally_count)->isSame(2); // 呼ばれている
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param ?callable $finally finally ブロッククロージャ
     * @param mixed ...$variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    function try_finally($try, $finally = null, ...$variadic)
    {
        return try_catch_finally($try, throws, $finally, ...$variadic);
    }
}
if (function_exists("ryunosuke\\Functions\\try_finally") && !defined("ryunosuke\\Functions\\try_finally")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\try_finally", "ryunosuke\\Functions\\try_finally");
}

if (!isset($excluded_functions["try_catch_finally"]) && (!function_exists("ryunosuke\\Functions\\try_catch_finally") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\try_catch_finally"))->isInternal()))) {
    /**
     * try ～ catch ～ finally 構文の関数版
     *
     * 例外機構構文が冗長なことがまれによくあるはず。
     *
     * Example:
     * ```php
     * $finally_count = 0;
     * $finally = function () use (&$finally_count) {$finally_count++;};
     * // 例外が飛ぼうと飛ぶまいと $finally は実行される
     * $try = function ($a, $b, $c) {return [$a, $b, $c];};
     * that(try_catch_finally($try, null, $finally, 1, 2, 3))->isSame([1, 2, 3]);
     * that($finally_count)->isSame(1); // 呼ばれている
     * // 例外を投げるが、 $catch で握りつぶす
     * $try = function () {throw new \Exception('tried');};
     * that(try_catch_finally($try, null, $finally, 1, 2, 3)->getMessage())->isSame('tried');
     * that($finally_count)->isSame(2); // 呼ばれている
     * ```
     *
     * @param callable $try try ブロッククロージャ
     * @param ?callable $catch catch ブロッククロージャ
     * @param ?callable $finally finally ブロッククロージャ
     * @param mixed ...$variadic $try に渡る引数
     * @return \Exception|mixed 例外が飛ばなかったら $try ブロックの返り値、飛んだなら $catch の返り値（デフォルトで例外オブジェクト）
     */
    function try_catch_finally($try, $catch = null, $finally = null, ...$variadic)
    {
        if ($catch === null) {
            $catch = fn($v) => $v;
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
if (function_exists("ryunosuke\\Functions\\try_catch_finally") && !defined("ryunosuke\\Functions\\try_catch_finally")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\try_catch_finally", "ryunosuke\\Functions\\try_catch_finally");
}

if (!isset($excluded_functions["ini_sets"]) && (!function_exists("ryunosuke\\Functions\\ini_sets") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\ini_sets"))->isInternal()))) {
    /**
     * 複数の php.ini の設定をまとめて設定する
     *
     * 返り値として「もとに戻すためのクロージャ」を返すので、復元するためにはそのクロージャを呼ぶだけで良い。
     *
     * @param array $values ini のエントリ名と値の配列
     * @return callable ini を元に戻すクロージャ
     */
    function ini_sets($values)
    {
        $currents = [];
        foreach ($values as $name => $value) {
            $current = ini_set($name, $value);
            if ($current !== false) {
                $currents[$name] = $current;
            }
        }
        return static function () use ($currents) {
            ini_sets($currents);
            return $currents;
        };
    }
}
if (function_exists("ryunosuke\\Functions\\ini_sets") && !defined("ryunosuke\\Functions\\ini_sets")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\ini_sets", "ryunosuke\\Functions\\ini_sets");
}

if (!isset($excluded_functions["get_uploaded_files"]) && (!function_exists("ryunosuke\\Functions\\get_uploaded_files") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\get_uploaded_files"))->isInternal()))) {
    /**
     * $_FILES の構造を組み替えて $_POST などと同じにする
     *
     * $_FILES の配列構造はバグとしか思えないのでそれを是正する関数。
     * 第1引数 $files は指定可能だが、大抵は $_FILES であり、指定するのはテスト用。
     *
     * サンプルを書くと長くなるので例は{@source \ryunosuke\Test\Package\UtilityTest::test_get_uploaded_files() テストファイル}を参照。
     *
     * @param ?array $files $_FILES の同じ構造の配列。省略時は $_FILES
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
if (function_exists("ryunosuke\\Functions\\get_uploaded_files") && !defined("ryunosuke\\Functions\\get_uploaded_files")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\get_uploaded_files", "ryunosuke\\Functions\\get_uploaded_files");
}

if (!isset($excluded_functions["number_serial"]) && (!function_exists("ryunosuke\\Functions\\number_serial") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\number_serial"))->isInternal()))) {
    /**
     * 連続した数値の配列を縮めて返す
     *
     * 例えば `[1, 2, 4, 6, 7, 9]` が `['1~2', 4, '6~7', 9]` になる。
     * 結合法則は指定可能（上記は "~" を指定したもの）。
     * null を与えると配列の配列で返すことも可能。
     *
     * Example:
     * ```php
     * // 単純に文字列指定
     * that(number_serial([1, 2, 4, 6, 7, 9], 1, '~'))->is(['1~2', 4, '6~7', 9]);
     * // null を与えると from, to の配列で返す
     * that(number_serial([1, 2, 4, 6, 7, 9], 1, null))->is([[1, 2], [4, 4], [6, 7], [9, 9]]);
     * // $step は負数・小数・逆順も対応している（正負でよしなにソートされる）
     * that(number_serial([-9, 0.2, 0.5, -0.3, 0.1, 0, -0.2, 9], -0.1, '~'))->is([9, 0.5, '0.2~0', '-0.2~-0.3', -9]);
     * ```
     *
     * @param iterable|array $numbers 数値配列
     * @param int|float $step 連続とみなすステップ。負数を指定すれば逆順指定にも使える
     * @param string|null|\Closure $separator 連続列を結合する文字列（string: 文字結合、null: 配列、Closure: 2引数が渡ってくる）
     * @param bool $doSort ソートをするか否か。事前にソート済みであることが明らかであれば false の方が良い
     * @return array 連続値をまとめた配列
     */
    function number_serial($numbers, $step = 1, $separator = null, $doSort = true)
    {
        $precision = ini_get('precision');
        $step = $step + 0;

        if ($doSort) {
            $numbers = kvsort($numbers, $step < 0 ? -SORT_NUMERIC : SORT_NUMERIC);
        }

        $build = function ($from, $to) use ($separator, $precision) {
            if ($separator instanceof \Closure) {
                return $separator($from, $to);
            }
            if (varcmp($from, $to, SORT_NUMERIC, $precision) === 0) {
                if ($separator === null) {
                    return [$from, $to];
                }
                return $from;
            }
            elseif ($separator === null) {
                return [$from, $to];
            }
            else {
                return $from . $separator . $to;
            }
        };

        $result = [];
        foreach ($numbers as $number) {
            $number = $number + 0;
            if (!isset($from, $to)) {
                $from = $to = $number;
                continue;
            }
            if (varcmp($to + $step, $number, SORT_NUMERIC, $precision) !== 0) {
                $result[] = $build($from, $to);
                $from = $number;
            }
            $to = $number;
        }
        if (isset($from, $to)) {
            $result[] = $build($from, $to);
        }

        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\number_serial") && !defined("ryunosuke\\Functions\\number_serial")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\number_serial", "ryunosuke\\Functions\\number_serial");
}

if (!isset($excluded_functions["cacheobject"]) && (!function_exists("ryunosuke\\Functions\\cacheobject") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\cacheobject"))->isInternal()))) {
    /**
     * psr-16 を実装したキャッシュオブジェクトを返す
     *
     * このオブジェクトはあくまで「他のパッケージに依存したくない」場合のデフォルト実装としての使用を想定している。
     *
     * - キャッシュはファイルシステムに保存される
     * - キャッシュキーの . はディレクトリ区切りとして使用される
     * - TTL を指定しなかったときのデフォルト値は約100年（実質無期限だろう）
     * - clear するとディレクトリ自体を吹き飛ばすのでそのディレクトリはキャッシュ以外の用途に使用してはならない
     * - psr-16 にはない getOrSet が生えている（利便性が非常に高く使用頻度が多いため）
     *
     * psr/simple-cache （\Psr\SimpleCache\CacheInterface）が存在するなら implement される。
     * 存在しないなら素の無名クラスで返す。
     * 動作に違いはないが instanceoof や class_implements に違いが出てくるので注意。
     *
     * @param string $directory キャッシュ保存ディレクトリ
     * @return \Psr16CacheInterface psr-16 実装オブジェクト
     */
    function cacheobject($directory)
    {
        $cacheobject = new class($directory) {
            private $directory;
            private $entries = [];

            public function __construct(string $directory)
            {
                assert(strlen($directory));
                $this->directory = $directory;
            }

            private function _exception(string $message = "", int $code = 0, \Throwable $previous = null): \Throwable
            {
                return interface_exists(\Psr\SimpleCache\InvalidArgumentException::class)
                    ? new class ( $message, $code, $previous ) extends \InvalidArgumentException implements \Psr\SimpleCache\InvalidArgumentException { }
                    : new class ( $message, $code, $previous ) extends \InvalidArgumentException { };
            }

            private function _validateKey(string $key): void
            {
                if ($key === '') {
                    throw $this->_exception("\$key is empty string");
                }
                if (strpbrk($key, '{}()/\\@:') !== false) {
                    throw $this->_exception("\$key contains reserved character({}()/\\@:)");
                }
            }

            private function _normalizeTtl($ttl): int
            {
                if ($ttl === null) {
                    return 60 * 60 * 24 * 365 * 100;
                }
                if (is_int($ttl)) {
                    return $ttl;
                }
                if ($ttl instanceof \DateInterval) {
                    return (new \DateTime())->setTimestamp(0)->add($ttl)->getTimestamp();
                }
                throw $this->_exception("\$ttl must be null|int|DateInterval(" . gettype($ttl) . ")");
            }

            private function _getFilename(string $key): string
            {
                return $this->directory . DIRECTORY_SEPARATOR . strtr(rawurlencode($key), ['.' => DIRECTORY_SEPARATOR]) . ".php";
            }

            public function fetch($key, $provider, $ttl = null)
            {
                $value = $this->get($key);
                if ($value === null) {
                    $value = $provider($this);
                    $this->set($key, $value, $ttl);
                }
                return $value;
            }

            public function fetchMultiple($providers, $ttl = null)
            {
                $result = $this->getMultiple(array_keys($providers));
                foreach ($providers as $key => $provider) {
                    $result[$key] ??= $this->fetch($key, $provider, $ttl);
                }
                return $result;
            }

            public function get($key, $default = null)
            {
                $this->_validateKey($key);

                error_clear_last();
                $entry = $this->entries[$key] ?? @include $this->_getFilename($key);
                if (error_get_last() !== null || $entry[0] < time()) {
                    $this->delete($key);
                    return $default;
                }

                $this->entries[$key] = $entry;
                return $entry[1];
            }

            public function set($key, $value, $ttl = null)
            {
                $this->_validateKey($key);
                $ttl = $this->_normalizeTtl($ttl);

                if ($ttl <= 0) {
                    return $this->delete($key);
                }

                $this->entries[$key] = [time() + $ttl, $value];
                $code = var_export3($this->entries[$key], ['outmode' => 'file']);
                return !!file_set_contents($this->_getFilename($key), $code);
            }

            public function delete($key)
            {
                $this->_validateKey($key);

                unset($this->entries[$key]);
                return @unlink($this->_getFilename($key));
            }

            public function clear()
            {
                $this->entries = [];
                return rm_rf($this->directory, false);
            }

            public function getMultiple($keys, $default = null)
            {
                return array_each($keys, function (&$result, $v) use ($default) {
                    $result[$v] = $this->get($v, $default);
                }, []);
            }

            public function setMultiple($values, $ttl = null)
            {
                return array_each($values, function (&$result, $v, $k) use ($ttl) {
                    $result = $this->set($k, $v, $ttl) && $result;
                }, true);
            }

            public function deleteMultiple($keys)
            {
                return array_each($keys, function (&$result, $v) {
                    $result = $this->delete($v) && $result;
                }, true);
            }

            public function has($key)
            {
                return $this->get($key) !== null;
            }
        };

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return !interface_exists(\Psr\SimpleCache\CacheInterface::class) ? $cacheobject : new class($cacheobject) implements \Psr\SimpleCache\CacheInterface {
            private $cacheobject;

            public function __construct($cacheobject)
            {
                $this->cacheobject = $cacheobject;
            }

            // @formatter:off
            public function fetch($key, $provider, $ttl = null)    { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function fetchMultiple($providers, $ttl = null) { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function get($key, $default = null)             { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function set($key, $value, $ttl = null)         { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function delete($key)                           { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function clear()                                { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function getMultiple($keys, $default = null)    { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function setMultiple($values, $ttl = null)      { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function deleteMultiple($keys)                  { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            public function has($key)                              { return $this->cacheobject->{__FUNCTION__}(...func_get_args()); }
            // @formatter:on
        };
    }
}
if (function_exists("ryunosuke\\Functions\\cacheobject") && !defined("ryunosuke\\Functions\\cacheobject")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\cacheobject", "ryunosuke\\Functions\\cacheobject");
}

if (!isset($excluded_functions["cachedir"]) && (!function_exists("ryunosuke\\Functions\\cachedir") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\cachedir"))->isInternal()))) {
    /**
     * 本ライブラリで使用するキャッシュディレクトリを設定する
     *
     * @param string|null $dirname キャッシュディレクトリ。省略時は返すのみ
     * @return string 設定前のキャッシュディレクトリ
     */
    function cachedir($dirname = null)
    {
        static $cachedir;
        if ($cachedir === null) {
            $cachedir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . strtr(__NAMESPACE__, ['\\' => '%']);
            cachedir($cachedir); // for mkdir
        }

        if ($dirname === null) {
            return $cachedir;
        }

        if (!file_exists($dirname)) {
            @mkdir($dirname, 0777 & (~umask()), true);
        }
        $result = $cachedir;
        $cachedir = realpath($dirname);
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\cachedir") && !defined("ryunosuke\\Functions\\cachedir")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\cachedir", "ryunosuke\\Functions\\cachedir");
}

if (!isset($excluded_functions["cache"]) && (!function_exists("ryunosuke\\Functions\\cache") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\cache"))->isInternal()))) {
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
     * $provider = fn() => rand();
     * // 乱数を返す処理だが、キャッシュされるので同じ値になる
     * $rand1 = cache('rand', $provider);
     * $rand2 = cache('rand', $provider);
     * that($rand1)->isSame($rand2);
     * // $provider に null を与えると削除される
     * cache('rand', null);
     * $rand3 = cache('rand', $provider);
     * that($rand1)->isNotSame($rand3);
     * ```
     *
     * @param string $key キャッシュのキー
     * @param callable $provider キャッシュがない場合にコールされる callable
     * @param ?string $namespace 名前空間
     * @return mixed キャッシュ
     */
    function cache($key, $provider, $namespace = null)
    {
        static $cacheobject;
        $cacheobject ??= new class(cachedir()) {
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
                            @unlink($temppath); // @codeCoverageIgnore
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
                foreach (glob($this->cachedir . '/*' . self::CACHE_EXT) as $file) {
                    unlink($file);
                }
            }
        };

        // flush (for test)
        if ($key === null) {
            if ($provider === null) {
                $cacheobject->clear();
            }
            $cacheobject = null;
            return;
        }

        $namespace ??= __FILE__;

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
if (function_exists("ryunosuke\\Functions\\cache") && !defined("ryunosuke\\Functions\\cache")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\cache", "ryunosuke\\Functions\\cache");
}

if (!isset($excluded_functions["parse_namespace"]) && (!function_exists("ryunosuke\\Functions\\parse_namespace") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\parse_namespace"))->isInternal()))) {
    /**
     * php ファイルをパースして名前空間配列を返す
     *
     * ファイル内で use/use const/use function していたり、シンボルを定義していたりする箇所を検出して名前空間単位で返す。
     *
     * Example:
     * ```php
     * // このような php ファイルをパースすると・・・
     * file_set_contents(sys_get_temp_dir() . '/namespace.php', '
     * <?php
     * namespace NS1;
     * use ArrayObject as AO;
     * use function strlen as SL;
     * function InnerFunc(){}
     * class InnerClass{}
     * define("OUTER\\\\CONST", "OuterConst");
     *
     * namespace NS2;
     * use RuntimeException as RE;
     * use const COUNT_RECURSIVE as CR;
     * class InnerClass{}
     * const InnerConst = 123;
     * ');
     * // このような名前空間配列が得られる
     * that(parse_namespace(sys_get_temp_dir() . '/namespace.php'))->isSame([
     *     'NS1' => [
     *         'const'    => [],
     *         'function' => [
     *             'SL'        => 'strlen',
     *             'InnerFunc' => 'NS1\\InnerFunc',
     *         ],
     *         'alias'    => [
     *             'AO'         => 'ArrayObject',
     *             'InnerClass' => 'NS1\\InnerClass',
     *         ],
     *     ],
     *     'OUTER' => [
     *         'const'    => [
     *             'CONST' => 'OUTER\\CONST',
     *         ],
     *         'function' => [],
     *         'alias'    => [],
     *     ],
     *     'NS2' => [
     *         'const'    => [
     *             'CR'         => 'COUNT_RECURSIVE',
     *             'InnerConst' => 'NS2\\InnerConst',
     *         ],
     *         'function' => [],
     *         'alias'    => [
     *             'RE'         => 'RuntimeException',
     *             'InnerClass' => 'NS2\\InnerClass',
     *         ],
     *     ],
     * ]);
     * ```
     *
     * @param string $filename ファイル名
     * @param array $options オプション配列
     * @return array 名前空間配列
     */
    function parse_namespace($filename, $options = [])
    {
        $options += [
            'cache' => true,
        ];
        if (!$options['cache']) {
            cache(realpath($filename), null, __FUNCTION__);
        }
        return cache(realpath($filename), function () use ($filename) {
            $stringify = function ($tokens) {
                // @codeCoverageIgnoreStart
                if (version_compare(PHP_VERSION, '8.0.0') >= 0) {
                    return trim(implode('', array_column(array_filter($tokens, function ($token) {
                        /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
                        return in_array($token[0], [T_NAME_QUALIFIED, T_NAME_FULLY_QUALIFIED, T_NAME_RELATIVE, T_STRING], true);
                    }), 1)), '\\');
                }
                // @codeCoverageIgnoreEnd
                return trim(implode('', array_column(array_filter($tokens, function ($token) {
                    return $token[0] === T_NS_SEPARATOR || $token[0] === T_STRING;
                }), 1)), '\\');
            };

            $keys = [
                0           => 'alias', // for use
                T_CLASS     => 'alias',
                T_INTERFACE => 'alias',
                T_TRAIT     => 'alias',
                T_STRING    => 'const', // for define
                T_CONST     => 'const',
                T_FUNCTION  => 'function',
            ];

            $contents = "?>" . file_get_contents($filename);
            $namespace = '';
            $tokens = [-1 => null];
            $result = [];
            while (true) {
                $tokens = parse_php($contents, [
                    'flags'  => TOKEN_PARSE,
                    'begin'  => ["define", T_NAMESPACE, T_USE, T_CONST, T_FUNCTION, T_CLASS, T_INTERFACE, T_TRAIT],
                    'end'    => ['{', ';', '(', T_EXTENDS, T_IMPLEMENTS],
                    'offset' => last_key($tokens) + 1,
                ]);
                if (!$tokens) {
                    break;
                }
                $token = reset($tokens);
                // define は現在の名前空間とは無関係に名前空間定数を宣言することができる
                if ($token[0] === T_STRING && $token[1] === "define") {
                    $tokens = parse_php($contents, [
                        'flags'  => TOKEN_PARSE,
                        'begin'  => [T_CONSTANT_ENCAPSED_STRING],
                        'end'    => [T_CONSTANT_ENCAPSED_STRING],
                        'offset' => last_key($tokens),
                    ]);
                    $define = trim(json_decode(implode('', array_column($tokens, 1))), '\\');
                    [$ns, $nm] = namespace_split($define);
                    if (!isset($result[$ns])) {
                        $result[$ns] = [
                            'const'    => [],
                            'function' => [],
                            'alias'    => [],
                        ];
                    }
                    $result[$ns][$keys[$token[0]]][$nm] = $define;
                }
                switch ($token[0]) {
                    case T_NAMESPACE:
                        $namespace = $stringify($tokens);
                        $result[$namespace] = [
                            'const'    => [],
                            'function' => [],
                            'alias'    => [],
                        ];
                        break;
                    case T_USE:
                        $tokenCorF = array_find($tokens, fn($token) => ($token[0] === T_CONST || $token[0] === T_FUNCTION) ? $token[0] : 0, false);

                        $prefix = '';
                        if (end($tokens)[1] === '{') {
                            $prefix = $stringify($tokens);
                            $tokens = parse_php($contents, [
                                'flags'  => TOKEN_PARSE,
                                'begin'  => ['{'],
                                'end'    => ['}'],
                                'offset' => last_key($tokens),
                            ]);
                        }

                        $multi = array_explode($tokens, fn($token) => $token[1] === ',');
                        foreach ($multi as $ttt) {
                            $as = array_explode($ttt, fn($token) => $token[0] === T_AS);

                            $alias = $stringify($as[0]);
                            if (isset($as[1])) {
                                $result[$namespace][$keys[$tokenCorF]][$stringify($as[1])] = concat($prefix, '\\') . $alias;
                            }
                            else {
                                $result[$namespace][$keys[$tokenCorF]][namespace_split($alias)[1]] = concat($prefix, '\\') . $alias;
                            }
                        }
                        break;
                    case T_CONST:
                    case T_FUNCTION:
                    case T_CLASS:
                    case T_INTERFACE:
                    case T_TRAIT:
                        $alias = $stringify($tokens);
                        if (strlen($alias)) {
                            $result[$namespace][$keys[$token[0]]][$alias] = concat($namespace, '\\') . $alias;
                        }
                        // ブロック内に興味はないので進めておく（function 内 function などはあり得るが考慮しない）
                        if ($token[0] !== T_CONST) {
                            $tokens = parse_php($contents, [
                                'flags'  => TOKEN_PARSE,
                                'begin'  => ['{'],
                                'end'    => ['}'],
                                'offset' => last_key($tokens),
                            ]);
                            break;
                        }
                }
            }
            return $result;
        }, __FUNCTION__);
    }
}
if (function_exists("ryunosuke\\Functions\\parse_namespace") && !defined("ryunosuke\\Functions\\parse_namespace")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\parse_namespace", "ryunosuke\\Functions\\parse_namespace");
}

if (!isset($excluded_functions["resolve_symbol"]) && (!function_exists("ryunosuke\\Functions\\resolve_symbol") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\resolve_symbol"))->isInternal()))) {
    /**
     * エイリアス名を完全修飾名に解決する
     *
     * 例えばあるファイルのある名前空間で `use Hoge\Fuga\Piyo;` してるときの `Piyo` を `Hoge\Fuga\Piyo` に解決する。
     *
     * Example:
     * ```php
     * // このような php ファイルがあるとして・・・
     * file_set_contents(sys_get_temp_dir() . '/symbol.php', '
     * <?php
     * namespace vendor\NS;
     *
     * use ArrayObject as AO;
     * use function strlen as SL;
     *
     * function InnerFunc(){}
     * class InnerClass{}
     * ');
     * // 下記のように解決される
     * that(resolve_symbol('AO', sys_get_temp_dir() . '/symbol.php'))->isSame('ArrayObject');
     * that(resolve_symbol('SL', sys_get_temp_dir() . '/symbol.php'))->isSame('strlen');
     * that(resolve_symbol('InnerFunc', sys_get_temp_dir() . '/symbol.php'))->isSame('vendor\\NS\\InnerFunc');
     * that(resolve_symbol('InnerClass', sys_get_temp_dir() . '/symbol.php'))->isSame('vendor\\NS\\InnerClass');
     * ```
     *
     * @param string $shortname エイリアス名
     * @param string|array $nsfiles ファイル名 or [ファイル名 => 名前空間名]
     * @param array $targets エイリアスタイプ（'const', 'function', 'alias' のいずれか）
     * @return string|null 完全修飾名。解決できなかった場合は null
     */
    function resolve_symbol(string $shortname, $nsfiles, $targets = ['const', 'function', 'alias'])
    {
        // 既に完全修飾されている場合は何もしない
        if (($shortname[0] ?? null) === '\\') {
            return $shortname;
        }

        // use Inner\Space のような名前空間の use の場合を考慮する
        $parts = explode('\\', $shortname, 2);
        $prefix = isset($parts[1]) ? array_shift($parts) : null;

        if (is_string($nsfiles)) {
            $nsfiles = [$nsfiles => []];
        }

        $targets = (array) $targets;
        foreach ($nsfiles as $filename => $namespaces) {
            $namespaces = array_flip(array_map(fn($n) => trim($n, '\\'), (array) $namespaces));
            foreach (parse_namespace($filename) as $namespace => $ns) {
                /** @noinspection PhpIllegalArrayKeyTypeInspection */
                if (!$namespaces || isset($namespaces[$namespace])) {
                    if (isset($ns['alias'][$prefix])) {
                        return $ns['alias'][$prefix] . '\\' . implode('\\', $parts);
                    }
                    foreach ($targets as $target) {
                        if (isset($ns[$target][$shortname])) {
                            return $ns[$target][$shortname];
                        }
                    }
                }
            }
        }
        return null;
    }
}
if (function_exists("ryunosuke\\Functions\\resolve_symbol") && !defined("ryunosuke\\Functions\\resolve_symbol")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\resolve_symbol", "ryunosuke\\Functions\\resolve_symbol");
}

if (!isset($excluded_functions["parse_annotation"]) && (!function_exists("ryunosuke\\Functions\\parse_annotation") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\parse_annotation"))->isInternal()))) {
    /**
     * アノテーションっぽい文字列をそれっぽくパースして返す
     *
     * $annotation にはリフレクションオブジェクトも渡せる。
     * その場合、getDocComment や getFilename, getNamespaceName などを用いてある程度よしなに名前解決する。
     * もっとも、@Class(args) 形式を使わないのであれば特に意味はない。
     *
     * $schame で「どのように取得するか？」のスキーマ定義が渡せる。
     * スキーマ定義は連想配列で各アノテーションごとに下記のような定義を指定でき、連想配列でない場合はすべてのアノテーションにおいて指定したとみなされる。
     *
     * - true: 余計なことはせず、アノテーションの文字列をそのまま返す
     * - false: 下記にようによしなに変換して返す
     * - []: 複数値モードを強制する
     * - null: 単一値モードを強制する
     *
     * アノテーションの仕様は下記（すべて $schema が false であるとする）。
     *
     * - @から行末まで（1行に複数のアノテーションは含められない）
     *     - ただし行末が `({[` のいずれかであれば次の `]})` までブロックを記載する機会が与えられる
     *     - ブロックを見つけたときは本来値となるべき値がキーに、ブロックが値となり、結果は必ず配列化される
     * - 同じアノテーションを複数見つけたときは配列化される
     * - `@hogera`: 値なしは null を返す
     * - `@hogera v1 "v2 v3"`: ["v1", "v2 v3"] という配列として返す
     * - `@hogera {key: 123}`: ["key" => 123] という（連想）配列として返す
     * - `@hogera [123, 456]`: [123, 456] という連番配列として返す
     * - `@hogera ("2019/12/23")`: hogera で解決できるクラス名で new して返す（$filename 引数の指定が必要）
     * - 下3つの形式はアノテーション区切りのスペースはあってもなくても良い
     *
     * $schema が true だと上記のような変換は一切行わず、素朴な文字列で返す。
     * あくまで簡易実装であり、本格的に何かをしたいなら専用のパッケージを導入したほうが良い。
     *
     * Example:
     * ```php
     * $annotations = parse_annotation('
     *
     * @noval
     * @single this is value
     * @closure this is value
     * @array this is value
     * @hash {key: 123}
     * @list [1, 2, 3]
     * @ArrayObject([1, 2, 3])
     * @block message {
     *     this is message1
     *     this is message2
     * }
     * @same this is same value1
     * @same this is same value2
     * @same this is same value3
     * ', [
     *     'single'  => true,
     *     'closure' => fn($value) => explode(' ', strtoupper($value)),
     * ]);
     * that($annotations)->is([
     *     'noval'       => null,                        // 値なしは null になる
     *     'single'      => 'this is value',             // $schema 指定してるので文字列になる
     *     'closure'     => ['THIS', 'IS', 'VALUE'],     // $schema 指定してそれがクロージャだとコールバックされる
     *     'array'       => ['this', 'is', 'value'],     // $schema 指定していないので配列になる
     *     'hash'        => ['key' => '123'],            // 連想配列になる
     *     'list'        => [1, 2, 3],                   // 連番配列になる
     *     'ArrayObject' => new \ArrayObject([1, 2, 3]), // new されてインスタンスになる
     *     "block"       => [                            // ブロックはブロック外をキーとした連想配列になる（複数指定でキーは指定できるイメージ）
     *         "message" => ["this is message1\n    this is message2"],
     *     ],
     *     'same'        => [                            // 複数あるのでそれぞれの配列になる
     *         ['this', 'is', 'same', 'value1'],
     *         ['this', 'is', 'same', 'value2'],
     *         ['this', 'is', 'same', 'value3'],
     *     ],
     * ]);
     * ```
     *
     * @param string|\Reflector $annotation アノテーション文字列
     * @param array|mixed $schema スキーマ定義
     * @param string|array $nsfiles ファイル名 or [ファイル名 => 名前空間名]
     * @return array アノテーション配列
     */
    function parse_annotation($annotation, $schema = [], $nsfiles = [])
    {
        if ($annotation instanceof \Reflector) {
            $reflector = $annotation;
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            $annotation = $reflector->getDocComment();

            // クラスメンバーリフレクションは getDeclaringClass しないと名前空間が取れない
            if (false
                || $reflector instanceof \ReflectionClassConstant
                || $reflector instanceof \ReflectionProperty
                || $reflector instanceof \ReflectionMethod
            ) {
                $reflector = $reflector->getDeclaringClass();
            }

            // 無名クラスに名前空間という概念はない（無くはないが普通に想起される名前空間ではない）
            $namespaces = [];
            if (!($reflector instanceof \ReflectionClass && $reflector->isAnonymous())) {
                $namespaces[] = $reflector->getNamespaceName();
            }
            $nsfiles[$reflector->getFileName()] = $nsfiles[$reflector->getFileName()] ?? $namespaces;

            // doccomment 特有のインデントを削除する
            $annotation = preg_replace('#(\\R)[ \\t]+\\*[ \\t]?#u', '$1', str_chop($annotation, '/**', '*/'));
        }

        $result = [];
        $multiples = [];

        $brace = [
            '(' => ')',
            '{' => '}',
            '[' => ']',
        ];
        for ($i = 0, $l = strlen($annotation); $i < $l; $i++) {
            $i = strpos_quoted($annotation, '@', $i);
            if ($i === false) {
                break;
            }

            $seppos = min(strpos_array($annotation, [" ", "\t", "\n", '[', '{', '('], $i + 1) ?: [false]);
            $name = substr($annotation, $i + 1, $seppos - $i - 1);
            $i += strlen($name);
            $name = trim($name);

            $key = null;
            $brkpos = strpos_quoted($annotation, "\n", $seppos) ?: strlen($annotation);
            if (isset($brace[$annotation[$brkpos - 1]])) {
                $s = $annotation[$brkpos - 1];
                $e = $brace[$s];
                $brkpos--;
                $key = trim(substr($annotation, $seppos, $brkpos - $seppos));
                $value = $s . str_between($annotation, $s, $e, $brkpos) . $e;
                $i = $brkpos;
            }
            else {
                $endpos = strpos_quoted($annotation, "@", $seppos) ?: strlen($annotation);
                $value = substr($annotation, $seppos, $endpos - $seppos);
                $i += strlen($value);
                $value = trim($value);
            }

            $rawmode = $schema;
            if (is_array($rawmode)) {
                $rawmode = array_key_exists($name, $rawmode) ? $rawmode[$name] : false;
            }
            if ($rawmode instanceof \Closure) {
                $value = $rawmode($value, $key);
            }
            elseif ($rawmode) {
                if (is_string($key)) {
                    $value = substr($value, 1, -1);
                }
            }
            else {
                if (is_array($rawmode)) {
                    $multiples[$name] = true;
                }
                if (is_null($rawmode)) {
                    $multiples[$name] = false;
                }
                if ($value === '') {
                    $value = null;
                }
                elseif (in_array($value[0] ?? null, ['('], true)) {
                    $class = resolve_symbol($name, $nsfiles, 'alias') ?? $name;
                    $value = new $class(...paml_import(substr($value, 1, -1)));
                }
                elseif (in_array($value[0] ?? null, ['{', '['], true)) {
                    $value = (array) paml_import($value)[0];
                }
                else {
                    $value = array_values(array_filter(quoteexplode([" ", "\t"], $value), "strlen"));
                }
            }

            if (array_key_exists($name, $result) && !isset($multiples[$name])) {
                $multiples[$name] = true;
                $result[$name] = [$result[$name]];
            }
            if (strlen($key)) {
                $multiples[$name] = true;
                $result[$name][$key] = $value;
            }
            elseif (isset($multiples[$name]) && $multiples[$name] === true) {
                $result[$name][] = $value;
            }
            else {
                $result[$name] = $value;
            }
        }

        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\parse_annotation") && !defined("ryunosuke\\Functions\\parse_annotation")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\parse_annotation", "ryunosuke\\Functions\\parse_annotation");
}

if (!isset($excluded_functions["is_ansi"]) && (!function_exists("ryunosuke\\Functions\\is_ansi") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\is_ansi"))->isInternal()))) {
    /**
     * リソースが ansi color に対応しているか返す
     *
     * パイプしたりリダイレクトしていると false を返す。
     *
     * @see https://github.com/symfony/console/blob/v4.2.8/Output/StreamOutput.php#L98
     *
     * @param resource $stream 調べるリソース
     * @return bool ansi color に対応しているなら true
     */
    function is_ansi($stream)
    {
        // テスト用に隠し引数で DS を取っておく
        $DIRECTORY_SEPARATOR = DIRECTORY_SEPARATOR;
        assert(!!$DIRECTORY_SEPARATOR = func_num_args() > 1 ? func_get_arg(1) : $DIRECTORY_SEPARATOR);

        if ('Hyper' === getenv('TERM_PROGRAM')) {
            return true;
        }

        if ($DIRECTORY_SEPARATOR === '\\') {
            return (\function_exists('sapi_windows_vt100_support') && @sapi_windows_vt100_support($stream))
                || false !== getenv('ANSICON')
                || 'ON' === getenv('ConEmuANSI')
                || 'xterm' === getenv('TERM');
        }

        return @stream_isatty($stream);
    }
}
if (function_exists("ryunosuke\\Functions\\is_ansi") && !defined("ryunosuke\\Functions\\is_ansi")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\is_ansi", "ryunosuke\\Functions\\is_ansi");
}

if (!isset($excluded_functions["ansi_colorize"]) && (!function_exists("ryunosuke\\Functions\\ansi_colorize") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\ansi_colorize"))->isInternal()))) {
    /**
     * 文字列に ANSI Color エスケープシーケンスを埋め込む
     *
     * - "blue" のような小文字色名は文字色
     * - "BLUE" のような大文字色名は背景色
     * - "bold" のようなスタイル名は装飾
     *
     * となる。その区切り文字は現在のところ厳密に定めていない（`fore+back|bold` のような形式で定めることも考えたけどメリットがない）。
     * つまり、アルファベット以外で分割するので、
     *
     * - `blue|WHITE@bold`: 文字青・背景白・太字
     * - `blue WHITE bold underscore`: 文字青・背景白・太字・下線
     * - `italic|bold,blue+WHITE  `: 文字青・背景白・太字・斜体
     *
     * という動作になる（記号で区切られていれば形式はどうでも良いということ）。
     * ただ、この指定方法は変更が入る可能性が高いのでスペースあたりで区切っておくのがもっとも無難。
     *
     * @param string $string 対象文字列
     * @param string $color 色とスタイル文字列
     * @return string エスケープシーケンス付きの文字列
     */
    function ansi_colorize($string, $color)
    {
        // see https://en.wikipedia.org/wiki/ANSI_escape_code#SGR_parameters
        // see https://misc.flogisoft.com/bash/tip_colors_and_formatting
        $ansicodes = [
            // forecolor
            'default'    => [39, 39],
            'black'      => [30, 39],
            'red'        => [31, 39],
            'green'      => [32, 39],
            'yellow'     => [33, 39],
            'blue'       => [34, 39],
            'magenta'    => [35, 39],
            'cyan'       => [36, 39],
            'white'      => [97, 39],
            'gray'       => [90, 39],
            // backcolor
            'DEFAULT'    => [49, 49],
            'BLACK'      => [40, 49],
            'RED'        => [41, 49],
            'GREEN'      => [42, 49],
            'YELLOW'     => [43, 49],
            'BLUE'       => [44, 49],
            'MAGENTA'    => [45, 49],
            'CYAN'       => [46, 49],
            'WHITE'      => [47, 49],
            'GRAY'       => [100, 49],
            // style
            'bold'       => [1, 22],
            'faint'      => [2, 22], // not working ?
            'italic'     => [3, 23],
            'underscore' => [4, 24],
            'blink'      => [5, 25],
            'reverse'    => [7, 27],
            'conceal'    => [8, 28],
        ];

        $names = array_flip(preg_split('#[^a-z]#i', $color));
        $styles = array_intersect_key($ansicodes, $names);
        $setters = implode(';', array_column($styles, 0));
        $unsetters = implode(';', array_column($styles, 1));
        return "\033[{$setters}m{$string}\033[{$unsetters}m";
    }
}
if (function_exists("ryunosuke\\Functions\\ansi_colorize") && !defined("ryunosuke\\Functions\\ansi_colorize")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\ansi_colorize", "ryunosuke\\Functions\\ansi_colorize");
}

if (!isset($excluded_functions["process"]) && (!function_exists("ryunosuke\\Functions\\process") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\process"))->isInternal()))) {
    /**
     * proc_open ～ proc_close の一連の処理を行う
     *
     * 標準入出力は文字列で受け渡しできるが、決め打ち実装なのでいわゆる対話型なプロセスは起動できない。
     * また、標準入出力はリソース型を渡すこともできる。
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
     * that($rc)->isSame(123); // -d で与えた max_file_uploads で exit してるので 123
     * that($stdout)->isSame('out'); // 標準出力に標準入力を書き込んでいるので "out" が格納される
     * that($stderr)->isSame('err'); // 標準エラーに書き込んでいるので "err" が格納される
     * ```
     *
     * @param string $command 実行コマンド。php7.4 未満では escapeshellcmd される
     * @param array|string $args コマンドライン引数。php7.4 未満では文字列はそのまま結合され、配列は escapeshellarg された上でキーと結合される
     * @param string|resource $stdin 標準入力（string を渡すと単純に読み取れられる。resource を渡すと fread される）
     * @param string|resource $stdout 標準出力（string を渡すと参照渡しで格納される。resource を渡すと fwrite される）
     * @param string|resource $stderr 標準エラー（string を渡すと参照渡しで格納される。resource を渡すと fwrite される）
     * @param ?string $cwd 作業ディレクトリ
     * @param ?array $env 環境変数
     * @return int リターンコード
     */
    function process($command, $args = [], $stdin = '', &$stdout = '', &$stderr = '', $cwd = null, array $env = null)
    {
        $rc = process_async($command, $args, $stdin, $stdout, $stderr, $cwd, $env)();
        if ($rc === -1) {
            // どうしたら失敗するのかわからない
            throw new \RuntimeException("$command exit failed."); // @codeCoverageIgnore
        }
        return $rc;
    }
}
if (function_exists("ryunosuke\\Functions\\process") && !defined("ryunosuke\\Functions\\process")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\process", "ryunosuke\\Functions\\process");
}

if (!isset($excluded_functions["process_async"]) && (!function_exists("ryunosuke\\Functions\\process_async") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\process_async"))->isInternal()))) {
    /**
     * proc_open ～ proc_close の一連の処理を行う（非同期版）
     *
     * @see process
     *
     * @param string $command 実行コマンド
     * @param array|string $args コマンドライン引数。文字列はそのまま結合され、配列は escapeshellarg された上でキーと結合される
     * @param string|resource $stdin 標準入力（string を渡すと単純に読み取れられる。resource を渡すと fread される）
     * @param string|resource $stdout 標準出力（string を渡すと参照渡しで格納される。resource を渡すと fwrite される）
     * @param string|resource $stderr 標準エラー（string を渡すと参照渡しで格納される。resource を渡すと fwrite される）
     * @param ?string $cwd 作業ディレクトリ
     * @param ?array $env 環境変数
     * @return callable プロセスオブジェクト
     */
    function process_async($command, $args = [], $stdin = '', &$stdout = '', &$stderr = '', $cwd = null, array $env = null)
    {
        if (is_array($args)) {
            $statement = [$command];
            foreach ($args as $k => $v) {
                if (!is_int($k)) {
                    $statement[] = $k;
                }
                $statement[] = $v;
            }
        }
        else {
            $statement = escapeshellcmd($command) . " $args";
        }

        $proc = proc_open($statement, [
            0 => is_resource($stdin) ? $stdin : ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ], $pipes, $cwd, $env);

        if ($proc === false) {
            // どうしたら失敗するのかわからない
            throw new \RuntimeException("$command start failed."); // @codeCoverageIgnore
        }

        if (!is_resource($stdin)) {
            fwrite($pipes[0], $stdin);
            fclose($pipes[0]);
        }
        if (!is_resource($stdout)) {
            $stdout = '';
        }
        if (!is_resource($stderr)) {
            $stderr = '';
        }

        stream_set_blocking($pipes[1], false);
        stream_set_blocking($pipes[2], false);

        return new class($proc, $pipes, $stdout, $stderr) {
            private $proc;
            private $pipes;
            public  $stdout;
            public  $stderr;

            public function __construct($proc, $pipes, &$stdout, &$stderr)
            {
                $this->proc = $proc;
                $this->pipes = $pipes;
                $this->stdout = &$stdout;
                $this->stderr = &$stderr;
            }

            public function __destruct()
            {
                if ($this->proc !== null) {
                    fclose($this->pipes[1]);
                    fclose($this->pipes[2]);
                    proc_close($this->proc);
                }
            }

            public function __invoke()
            {
                try {
                    while (feof($this->pipes[1]) === false || feof($this->pipes[2]) === false) {
                        $read = [$this->pipes[1], $this->pipes[2]];
                        $write = $except = null;
                        if (stream_select($read, $write, $except, 1) === false) {
                            // （システムコールが別のシグナルによって中断された場合などに起こりえます）
                            throw new \RuntimeException('stream_select failed.'); // @codeCoverageIgnore
                        }
                        foreach ($read as $fp) {
                            $buffer = fread($fp, 1024);
                            if ($fp === $this->pipes[1]) {
                                if (!is_resource($this->stdout)) {
                                    $this->stdout .= $buffer;
                                }
                                else {
                                    fwrite($this->stdout, $buffer);
                                }
                            }
                            elseif ($fp === $this->pipes[2]) {
                                if (!is_resource($this->stderr)) {
                                    $this->stderr .= $buffer;
                                }
                                else {
                                    fwrite($this->stderr, $buffer);
                                }
                            }
                        }
                    }
                }
                finally {
                    fclose($this->pipes[1]);
                    fclose($this->pipes[2]);
                    $rc = proc_close($this->proc);
                    $this->proc = null;
                }

                return $rc;
            }

            public function status()
            {
                return proc_get_status($this->proc);
            }
        };
    }
}
if (function_exists("ryunosuke\\Functions\\process_async") && !defined("ryunosuke\\Functions\\process_async")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\process_async", "ryunosuke\\Functions\\process_async");
}

if (!isset($excluded_functions["process_parallel"]) && (!function_exists("ryunosuke\\Functions\\process_parallel") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\process_parallel"))->isInternal()))) {
    /**
     * 複数の callable を並列で実行する
     *
     * callable はクロージャも使用できるが、独自の方法でエクスポートしてから実行するので可能な限り this bind は外したほうが良い。
     *
     * Example:
     * ```php
     * # 単一のクロージャを複数の引数で回す
     * $t = microtime(true);
     * $result = process_parallel(static function ($arg1, $arg2) {
     *     usleep(1000 * 1000);
     *     fwrite(STDOUT, "this is stdout");
     *     fwrite(STDERR, "this is stderr");
     *     return $arg1 + $arg2;
     * }, ['a' => [1, 2], 'b' => [2, 3], [3, 4]]);
     * // 1000ms かかる処理を3本実行するが、トータル時間は 3000ms ではなくそれ以下になる（多少のオーバーヘッドはある）
     * that(microtime(true) - $t)->lessThan(2.0);
     * // 実行結果は下記のような配列で返ってくる（その際キーは維持される）
     * that($result)->isSame([
     *     'a' => [
     *         'status' => 0,
     *         'stdout' => "this is stdout",
     *         'stderr' => "this is stderr",
     *         'return' => 3,
     *     ],
     *     'b' => [
     *         'status' => 0,
     *         'stdout' => "this is stdout",
     *         'stderr' => "this is stderr",
     *         'return' => 5,
     *     ],
     *     [
     *         'status' => 0,
     *         'stdout' => "this is stdout",
     *         'stderr' => "this is stderr",
     *         'return' => 7,
     *     ],
     * ]);
     * # 複数のクロージャを複数の引数で回す（この場合、引数のキーは合わせなければならない）
     * $t = microtime(true);
     * $result = process_parallel([
     *     'a' => static function ($arg1, $arg2) {
     *         usleep(300 * 1000);
     *         return $arg1 + $arg2;
     *     },
     *     'b' => static function ($arg1, $arg2) {
     *         usleep(500 * 1000);
     *         return $arg1 * $arg2;
     *     },
     *     static function ($arg) {
     *         usleep(1000 * 1000);
     *         exit($arg);
     *     },
     * ], ['a' => [1, 2], 'b' => [2, 3], [127]]);
     * // 300,500,1000ms かかる処理を3本実行するが、トータル時間は 1800ms ではなくそれ以下になる（多少のオーバーヘッドはある）
     * that(microtime(true) - $t)->lessThan(1.5);
     * // 実行結果は下記のような配列で返ってくる（その際キーは維持される）
     * that($result)->isSame([
     *     'a' => [
     *         'status' => 0,
     *         'stdout' => "",
     *         'stderr' => "",
     *         'return' => 3,
     *     ],
     *     'b' => [
     *         'status' => 0,
     *         'stdout' => "",
     *         'stderr' => "",
     *         'return' => 6,
     *     ],
     *     [
     *         'status' => 127,  // 終了コードが入ってくる
     *         'stdout' => "",
     *         'stderr' => "",
     *         'return' => null,
     *     ],
     * ]);
     * ```
     *
     * @param callable|callable[] $tasks 並列実行する callable. 単一の場合は引数分実行して結果を返す
     * @param array $args 各々の引数。$tasks が配列の場合はそれに対応する引数配列。単一の場合は実行回数も兼ねた引数配列
     * @param ?array $autoload 実行前に読み込むスクリプト。省略時は自動検出された vendor/autoload.php
     * @param ?string $workdir ワーキングディレクトリ。省略時はテンポラリディレクトリ
     * @return array 実行結果（['return' => callable の返り値, 'status' => 終了コード, 'stdout' => 標準出力, 'stderr' => 標準エラー]）
     */
    function process_parallel($tasks, $args = [], $autoload = null, $workdir = null, $env = null)
    {
        // 単一で来た場合は同じものを異なる引数で呼び出すシングルモードとなる
        if (!is_array($tasks)) {
            $tasks = array_fill_keys(array_keys($args) ?: [0], $tasks);
        }

        // 引数配列は単一の値でも良い
        $args = array_map(arrayize, $args);

        // 実行すれば "ArgumentCountError: Too few arguments" で怒られるがもっと早い段階で気づきたい
        foreach ($tasks as $key => $task) {
            assert(parameter_length($task, true) <= count($args[$key] ?? []), "task $key's arguments are mismatch.");
        }

        // 変数や環境の準備
        $autoload = arrayize($autoload ?? auto_loader());
        $workdir ??= (sys_get_temp_dir() . '/rfpp');
        mkdir_p($workdir);

        // 実行バイナリとコード本体
        $phpbin = path_resolve('php' . (DIRECTORY_SEPARATOR === '\\' ? '.exe' : ''), [dirname(PHP_BINARY)]);
        $maincode = '<?php
            $context = ' . var_export3([$autoload, $tasks], true) . ';
            foreach ($context[0] as $file) {
                require_once $file;
            }
            $stdin = unserialize(stream_get_contents(STDIN));
            $return = $context[1][$argv[2]](...$stdin);
            file_put_contents($argv[1], serialize($return));
        ';
        file_put_contents($mainscript = tempnam($workdir, 'main'), $maincode);

        // プロセスを準備
        $processes = [];
        foreach ($tasks as $key => $task) {
            unset($stdout, $stderr);
            $stdout = $stderr = '';
            $return = tempnam($workdir, 'return');
            $processes[$key] = process_async($phpbin, [$mainscript, $return, $key], serialize($args[$key] ?? []), $stdout, $stderr, $workdir, $env);
            $processes[$key]->return = static fn() => strlen($result = file_get_contents($return)) ? unserialize($result) : null;
        }

        // プロセスを実行兼返り値用に加工
        $results = [];
        foreach ($processes as $key => $process) {
            $results[$key] = [
                'status' => $process(),
                'stdout' => $process->stdout,
                'stderr' => $process->stderr,
                'return' => ($process->return)(),
            ];
        }
        return $results;
    }
}
if (function_exists("ryunosuke\\Functions\\process_parallel") && !defined("ryunosuke\\Functions\\process_parallel")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\process_parallel", "ryunosuke\\Functions\\process_parallel");
}

if (!isset($excluded_functions["arguments"]) && (!function_exists("ryunosuke\\Functions\\arguments") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\arguments"))->isInternal()))) {
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
            [$longname, $shortname] = preg_split('#\s+#u', $name, -1, PREG_SPLIT_NO_EMPTY) + [1 => null];
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
}
if (function_exists("ryunosuke\\Functions\\arguments") && !defined("ryunosuke\\Functions\\arguments")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\arguments", "ryunosuke\\Functions\\arguments");
}

if (!isset($excluded_functions["stacktrace"]) && (!function_exists("ryunosuke\\Functions\\stacktrace") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\stacktrace"))->isInternal()))) {
    /**
     * スタックトレースを文字列で返す
     *
     * `(new \Exception())->getTraceAsString()` と実質的な役割は同じ。
     * ただし、 getTraceAsString は引数が Array になったりクラス名しか取れなかったり微妙に使い勝手が悪いのでもうちょっと情報量を増やしたもの。
     *
     * 第1引数 $traces はトレース的配列を受け取る（`(new \Exception())->getTrace()` とか）。
     * 未指定時は debug_backtrace() で採取する。
     *
     * 第2引数 $option は文字列化する際の設定を指定する。
     * 情報量が増える分、機密も含まれる可能性があるため、 mask オプションで塗りつぶすキーや引数名を指定できる（クロージャの引数までは手出ししないため留意）。
     * limit と format は比較的指定頻度が高いかつ互換性維持のため配列オプションではなく直に渡すことが可能になっている。
     *
     * @param ?array $traces debug_backtrace 的な配列
     * @param int|string|array $option オプション
     * @return string|array トレース文字列（delimiter オプションに null を渡すと配列で返す）
     */
    function stacktrace($traces = null, $option = [])
    {
        if (is_int($option)) {
            $option = ['limit' => $option];
        }
        elseif (is_string($option)) {
            $option = ['format' => $option];
        }

        $option += [
            'format'    => '%s:%s %s', // 文字列化するときの sprintf フォーマット
            'args'      => true,       // 引数情報を埋め込むか否か
            'limit'     => 16,         // 配列や文字列を千切る長さ
            'delimiter' => "\n",       // スタックトレースの区切り文字（null で配列になる）
            'mask'      => ['#^password#', '#^secret#', '#^credential#', '#^credit#'],
        ];
        $limit = $option['limit'];
        $maskregexs = (array) $option['mask'];
        $mask = static function ($key, $value) use ($maskregexs) {
            if (!is_string($value)) {
                return $value;
            }
            foreach ($maskregexs as $regex) {
                if (preg_match($regex, $key)) {
                    return str_repeat('*', strlen($value));
                }
            }
            return $value;
        };

        $stringify = static function ($value) use ($limit, $mask) {
            // 再帰用クロージャ
            $export = static function ($value, $nest = 0, $parents = []) use (&$export, $limit, $mask) {
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
                        $kvl[] = ($flat ? '' : $k . ':') . $export(call_user_func($mask, $k, $v), $nest + 1, $parents);
                    }
                    return ($flat ? '[' : '{') . implode(', ', $kvl) . ($flat ? ']' : '}');
                }
                // オブジェクトは単にプロパティを配列的に出力する
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

        $traces ??= array_slice(debug_backtrace(), 1);
        $result = [];
        foreach ($traces as $i => $trace) {
            // メソッド内で関数定義して呼び出したりすると file が無いことがある（かなりレアケースなので無視する）
            if (!isset($trace['file'])) {
                continue; // @codeCoverageIgnore
            }

            $file = $trace['file'];
            $line = $trace['line'];
            if (strpos($trace['file'], "eval()'d code") !== false && ($traces[$i + 1]['function'] ?? '') === 'eval') {
                $file = $traces[$i + 1]['file'];
                $line = $traces[$i + 1]['line'] . "." . $trace['line'];
            }

            if (isset($trace['type'])) {
                $callee = $trace['class'] . $trace['type'] . $trace['function'];
                if ($option['args'] && $maskregexs && method_exists($trace['class'], $trace['function'])) {
                    $ref = new \ReflectionMethod($trace['class'], $trace['function']);
                }
            }
            else {
                $callee = $trace['function'];
                if ($option['args'] && $maskregexs && function_exists($callee)) {
                    $ref = new \ReflectionFunction($trace['function']);
                }
            }
            $args = [];
            if ($option['args']) {
                $args = $trace['args'] ?? [];
                if (isset($ref)) {
                    $params = $ref->getParameters();
                    foreach ($params as $n => $param) {
                        if (array_key_exists($n, $args)) {
                            $args[$n] = $mask($param->getName(), $args[$n]);
                        }
                    }
                }
            }
            $callee .= '(' . implode(', ', array_map($stringify, $args)) . ')';

            $result[] = sprintf($option['format'], $file, $line, $callee);
        }
        if ($option['delimiter'] === null) {
            return $result;
        }
        return implode($option['delimiter'], $result);
    }
}
if (function_exists("ryunosuke\\Functions\\stacktrace") && !defined("ryunosuke\\Functions\\stacktrace")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\stacktrace", "ryunosuke\\Functions\\stacktrace");
}

if (!isset($excluded_functions["backtrace"]) && (!function_exists("ryunosuke\\Functions\\backtrace") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\backtrace"))->isInternal()))) {
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
     * that($traces)->count(2);
     * // 「function が f002 以降」を返す
     * that($traces[0])->arraySubset([
     *     'function' => __NAMESPACE__ . '\\f002'
     * ]);
     * that($traces[1])->arraySubset([
     *     'function' => __NAMESPACE__ . '\\f003'
     * ]);
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

        // offset, limit は特別扱いで千切り指定
        if (isset($options['offset']) || isset($options['limit'])) {
            $result = array_slice($result, $options['offset'] ?? 0, $options['limit'] ?? count($result));
        }

        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\backtrace") && !defined("ryunosuke\\Functions\\backtrace")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\backtrace", "ryunosuke\\Functions\\backtrace");
}

if (!isset($excluded_functions["profiler"]) && (!function_exists("ryunosuke\\Functions\\profiler") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\profiler"))->isInternal()))) {
    /**
     * 外部ツールに頼らない pure php なプロファイラを返す
     *
     * file プロトコル上書きと ticks と debug_backtrace によるかなり無理のある実装なので動かない環境・コードは多い。
     * その分お手軽だが下記の注意点がある。
     *
     * - file プロトコルを上書きするので、既に読み込み済みのファイルは計上されない
     * - tick されないステートメントは計上されない
     *     - 1行メソッドなどでありがち
     * - A->B->C という呼び出しで C が 3秒、B が 2秒、A が1秒かかった場合、 A は 6 秒、B は 5秒、C は 3 秒といて計上される
     *     - つまり、配下の呼び出しも重複して計上される
     *
     * この関数を呼んだ時点で計測は始まる。
     * 返り値としてイテレータを返すので、foreach で回せばコールスタック・回数・時間などが取得できる。
     * 配列で欲しい場合は直に呼べば良い。
     *
     * @param array $options オプション配列
     * @return \Traversable|callable プロファイライテレータ
     */
    function profiler($options = [])
    {
        static $declareProtocol = null;
        $declareProtocol ??= new
        /**
         * @method opendir($path, $context = null)
         * @method touch($filename, $time = null, $atime = null)
         * @method chmod($filename, $mode)
         * @method chown($filename, $user)
         * @method chgrp($filename, $group)
         * @method fopen($filename, $mode, $use_include_path = false, $context = null)
         */
        class {
            const DECLARE_TICKS = "<?php declare(ticks=1) ?>";

            /** @var int https://github.com/php/php-src/blob/php-7.2.11/main/php_streams.h#L528-L529 */
            private const STREAM_OPEN_FOR_INCLUDE = 0x00000080;

            /** @var resource https://www.php.net/manual/class.streamwrapper.php */
            public $context;

            private $require;
            private $prepend;
            private $handle;

            public function __call($name, $arguments)
            {
                $fname = preg_replace(['#^dir_#', '#^stream_#'], ['', 'f'], $name, 1, $count);
                if ($count) {
                    // flock は特別扱い（file_put_contents (LOCK_EX) を呼ぶと 0 で来ることがある）
                    // __call で特別扱いもおかしいけど、個別に定義するほうが逆にわかりにくい
                    if ($fname === 'flock' && ($arguments[0] ?? null) === 0) {
                        return true;
                    }
                    return $fname($this->handle, ...$arguments);
                }

                stream_wrapper_restore('file');
                try {
                    switch ($name) {
                        default:
                            // mkdir, rename, unlink, ...
                            return $name(...$arguments);
                        case 'rmdir':
                            [$path, $options] = $arguments + [1 => 0];
                            assert(isset($options)); // @todo It is used?
                            return rmdir($path, $this->context);
                        case 'url_stat':
                            [$path, $flags] = $arguments + [1 => 0];
                            if ($flags & STREAM_URL_STAT_LINK) {
                                $func = 'lstat';
                            }
                            else {
                                $func = 'stat';
                            }
                            if ($flags & STREAM_URL_STAT_QUIET) {
                                return @$func($path);
                            }
                            else {
                                return $func($path);
                            }
                    }
                }
                finally {
                    stream_wrapper_unregister('file');
                    stream_wrapper_register('file', get_class($this));
                }
            }

            /** @noinspection PhpUnusedParameterInspection */
            public function dir_opendir($path, $options)
            {
                return !!$this->handle = $this->opendir(...$this->context ? [$path, $this->context] : [$path]);
            }

            public function stream_open($path, $mode, $options, &$opened_path)
            {
                $this->require = $options & self::STREAM_OPEN_FOR_INCLUDE;
                $this->prepend = false;
                $use_path = $options & STREAM_USE_PATH;
                if ($options & STREAM_REPORT_ERRORS) {
                    $this->handle = $this->fopen($path, $mode, $use_path); // @codeCoverageIgnore
                }
                else {
                    $this->handle = @$this->fopen($path, $mode, $use_path);
                }
                if ($use_path && $this->handle) {
                    $opened_path = stream_get_meta_data($this->handle)['uri']; // @codeCoverageIgnore
                }
                return !!$this->handle;
            }

            public function stream_read($count)
            {
                if (!$this->prepend && $this->require && ftell($this->handle) === 0) {
                    $this->prepend = true;
                    return self::DECLARE_TICKS;
                }
                return fread($this->handle, $count);
            }

            public function stream_stat()
            {
                $stat = fstat($this->handle);
                if ($this->require) {
                    $decsize = strlen(self::DECLARE_TICKS);
                    $stat[7] += $decsize;
                    $stat['size'] += $decsize;
                }
                return $stat;
            }

            public function stream_set_option($option, $arg1, $arg2)
            {
                // Windows の file スキームでは呼ばれない？（確かにブロッキングやタイムアウトは無縁そう）
                // @codeCoverageIgnoreStart
                switch ($option) {
                    default:
                        throw new \Exception();
                    case STREAM_OPTION_BLOCKING:
                        return stream_set_blocking($this->handle, $arg1);
                    case STREAM_OPTION_READ_TIMEOUT:
                        return stream_set_timeout($this->handle, $arg1, $arg2);
                    case STREAM_OPTION_READ_BUFFER:
                        return stream_set_read_buffer($this->handle, $arg2) === 0; // @todo $arg1 is used?
                    case STREAM_OPTION_WRITE_BUFFER:
                        return stream_set_write_buffer($this->handle, $arg2) === 0; // @todo $arg1 is used?
                }
                // @codeCoverageIgnoreEnd
            }

            public function stream_metadata($path, $option, $value)
            {
                switch ($option) {
                    default:
                        throw new \Exception(); // @codeCoverageIgnore
                    case STREAM_META_TOUCH:
                        return $this->touch($path, ...$value);
                    case STREAM_META_ACCESS:
                        return $this->chmod($path, $value);
                    case STREAM_META_OWNER_NAME:
                    case STREAM_META_OWNER:
                        return $this->chown($path, $value);
                    case STREAM_META_GROUP_NAME:
                    case STREAM_META_GROUP:
                        return $this->chgrp($path, $value);
                }
            }

            public function stream_cast($cast_as) { /* @todo I'm not sure */ }
        };

        $profiler = new class(get_class($declareProtocol), $options) implements \IteratorAggregate {
            private $result = [];
            private $ticker;

            public function __construct($wrapper, $options = [])
            {
                $options = array_replace([
                    'callee'   => null,
                    'location' => null,
                ], $options);
                $last_trace = [];
                $result = &$this->result;
                $this->ticker = static function () use ($options, &$last_trace, &$result) {
                    $now = microtime(true);
                    $traces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

                    $last_count = count($last_trace);
                    $current_count = count($traces);

                    // スタック数が変わってない（=同じメソッドを処理している？）
                    if ($current_count === $last_count) {
                        // dummy
                        assert($current_count === $last_count);
                    }
                    // スタック数が増えた（=新しいメソッドが開始された？）
                    elseif ($current_count > $last_count) {
                        foreach (array_slice($traces, 1, $current_count - $last_count) as $last) {
                            $last['time'] = $now;
                            $last['callee'] = (isset($last['class'], $last['type']) ? $last['class'] . $last['type'] : '') . $last['function'];
                            $last['location'] = isset($last['file'], $last['line']) ? $last['file'] . '#' . $last['line'] : null;
                            array_unshift($last_trace, $last);
                        }
                    }
                    // スタック数が減った（=処理してたメソッドを抜けた？）
                    elseif ($current_count < $last_count) {
                        $prev = null; // array_map などの内部関数はスタックが一気に2つ増減する
                        foreach (array_splice($last_trace, 0, $last_count - $current_count) as $last) {
                            $time = $now - $last['time'];
                            $callee = $last['callee'];
                            $location = $last['location'] ?? ($prev['file'] ?? '') . '#' . ($prev['line'] ?? '');
                            $prev = $last;

                            foreach (['callee', 'location'] as $key) {
                                $condition = $options[$key];
                                $value = $$key;
                                if ($condition !== null) {
                                    if ($condition instanceof \Closure) {
                                        if (!$condition($value)) {
                                            continue 2;
                                        }
                                    }
                                    else {
                                        if (!preg_match($condition, $value)) {
                                            continue 2;
                                        }
                                    }
                                }
                            }
                            $result[$callee][$location][] = $time;
                        }
                    }
                };

                stream_wrapper_unregister('file');
                stream_wrapper_register('file', $wrapper);

                register_tick_function($this->ticker);
                opcache_reset();
            }

            public function __destruct()
            {
                unregister_tick_function($this->ticker);

                stream_wrapper_restore('file');
            }

            public function __invoke()
            {
                return $this->result;
            }

            public function getIterator(): \Traversable
            {
                return yield from $this->result;
            }
        };

        return $profiler;
    }
}
if (function_exists("ryunosuke\\Functions\\profiler") && !defined("ryunosuke\\Functions\\profiler")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\profiler", "ryunosuke\\Functions\\profiler");
}

if (!isset($excluded_functions["error"]) && (!function_exists("ryunosuke\\Functions\\error") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\error"))->isInternal()))) {
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
            $destination = blank_if(ini_get('error_log'), 'php://stderr');
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
if (function_exists("ryunosuke\\Functions\\error") && !defined("ryunosuke\\Functions\\error")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\error", "ryunosuke\\Functions\\error");
}

if (!isset($excluded_functions["add_error_handler"]) && (!function_exists("ryunosuke\\Functions\\add_error_handler") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\add_error_handler"))->isInternal()))) {
    /**
     * エラーハンドラを追加する
     *
     * 追加したエラーハンドラが false を返すと標準のエラーハンドラではなく、直近の設定されていたエラーハンドラに移譲される。
     * （直近にエラーハンドラが設定されていなかったら標準ハンドラになる）。
     *
     * 「局所的にエラーハンドラを変更したいけど特定の状況は設定済みハンドラへ流したい」という状況はまれによくあるはず。
     *
     * Example:
     * ```php
     * // @ 付きなら元々のハンドラに移譲、@ なしなら何らかのハンドリングを行う例
     * add_error_handler(function ($errno) {
     *     if (!(error_reporting() & $errno)) {
     *         // この false はマニュアルにある「この関数が FALSE を返した場合は、通常のエラーハンドラが処理を引き継ぎます」ではなく、
     *         // 「さっきまで設定されていたエラーハンドラが処理を引き継ぎます」という意味になる
     *         return false;
     *     }
     *     // do something
     * });
     * // false の扱いが異なるだけでその他の挙動はすべて set_error_handler と同じなので restore_error_handler で戻せる
     * restore_error_handler();
     * ```
     *
     * @param callable $handler エラーハンドラ
     * @param int $error_types エラータイプ
     * @return callable|null 直近に設定されていたエラーハンドラ（未設定の場合は null）
     */
    function add_error_handler($handler, $error_types = \E_ALL | \E_STRICT)
    {
        $already = set_error_handler(static function () use ($handler, &$already) {
            $result = $handler(...func_get_args());
            if ($result === false && $already !== null) {
                return $already(...func_get_args());
            }
            return $result;
        }, $error_types);
        return $already;
    }
}
if (function_exists("ryunosuke\\Functions\\add_error_handler") && !defined("ryunosuke\\Functions\\add_error_handler")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\add_error_handler", "ryunosuke\\Functions\\add_error_handler");
}

if (!isset($excluded_functions["timer"]) && (!function_exists("ryunosuke\\Functions\\timer") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\timer"))->isInternal()))) {
    /**
     * 処理時間を計測する
     *
     * 第1引数 $callable を $count 回回してその処理時間を返す。
     *
     * Example:
     * ```php
     * // 0.01 秒を 10 回回すので 0.1 秒は超える
     * that(timer(function () {usleep(10 * 1000);}, 10))->greaterThan(0.1);
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
if (function_exists("ryunosuke\\Functions\\timer") && !defined("ryunosuke\\Functions\\timer")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\timer", "ryunosuke\\Functions\\timer");
}

if (!isset($excluded_functions["benchmark"]) && (!function_exists("ryunosuke\\Functions\\benchmark") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\benchmark"))->isInternal()))) {
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
     *     'intcast' => fn($v) => (int) $v,
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

            $benchset[$name] = \Closure::fromCallable($caller);
        }

        if (!$benchset) {
            throw new \InvalidArgumentException('benchset is empty.');
        }

        // opcache を利用するようなベンチはこの辺を切っておかないと正確な結果にならない
        // ウォームアップで mtime が更新され、その1秒以内にベンチが走るので一切 opcache が効かなくなるため
        $restore = ini_sets([
            'opcache.validate_timestamps'    => 0,
            'opcache.file_update_protection' => "0",
        ]);

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

        $restore();

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
if (function_exists("ryunosuke\\Functions\\benchmark") && !defined("ryunosuke\\Functions\\benchmark")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\benchmark", "ryunosuke\\Functions\\benchmark");
}

if (!isset($excluded_functions["stringify"]) && (!function_exists("ryunosuke\\Functions\\stringify") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\stringify"))->isInternal()))) {
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
                if (method_exists($var, '__serialize') || $var instanceof \Serializable) {
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
if (function_exists("ryunosuke\\Functions\\stringify") && !defined("ryunosuke\\Functions\\stringify")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\stringify", "ryunosuke\\Functions\\stringify");
}

if (!isset($excluded_functions["numberify"]) && (!function_exists("ryunosuke\\Functions\\numberify") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\numberify"))->isInternal()))) {
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
     * that(numberify([1, 2, 3]))->isSame(3);
     * // int/float は基本的にそのまま
     * that(numberify(123))->isSame(123);
     * that(numberify(123.45))->isSame(123);
     * that(numberify(123.45, true))->isSame(123.45);
     * // 文字列は数値抽出
     * that(numberify('a1b2c3'))->isSame(123);
     * that(numberify('a1b2.c3', true))->isSame(12.3);
     * ```
     *
     * @param mixed $var 対象の値
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
if (function_exists("ryunosuke\\Functions\\numberify") && !defined("ryunosuke\\Functions\\numberify")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\numberify", "ryunosuke\\Functions\\numberify");
}

if (!isset($excluded_functions["numval"]) && (!function_exists("ryunosuke\\Functions\\numval") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\numval"))->isInternal()))) {
    /**
     * 値を数値化する
     *
     * int か float ならそのまま返す。
     * 文字列の場合、一言で言えば「.を含むなら float、含まないなら int」を返す。
     * int でも float でも stringable でもない場合は実装依存（ただの int キャスト）。
     *
     * Example:
     * ```php
     * that(numval(3.14))->isSame(3.14);   // int や float はそのまま返す
     * that(numval('3.14'))->isSame(3.14); // . を含む文字列は float を返す
     * that(numval('11', 8))->isSame(9);   // 基数が指定できる
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
if (function_exists("ryunosuke\\Functions\\numval") && !defined("ryunosuke\\Functions\\numval")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\numval", "ryunosuke\\Functions\\numval");
}

if (!isset($excluded_functions["flagval"]) && (!function_exists("ryunosuke\\Functions\\flagval") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\flagval"))->isInternal()))) {
    /**
     * falsy の範囲を少し拡張した bool キャスト
     *
     * 例えば ajax 等で {hoge: false} とすると "false" が飛んできてしまうが、その場合も false 判定されるようになる。
     * この処理は FILTER_VALIDATE_BOOLEAN で行うので "off", "no", 等も false を返す。
     *
     * あとドキュメントには空白文字について言及がないが、どうも trim される模様。
     * trim するかどうかは呼び元で判断すべきだと思う（" true " が true, "    " が false になるのは果たして正しいのか）ので、第2引数で分岐できるようにしてある。
     * boolval やキャストでは trim されないようなのでデフォルト false にしてある。
     *
     * Example:
     * ```php
     * // こういう文字列も false になる
     * that(flagval('false'))->isFalse();
     * that(flagval('off'))->isFalse();
     * that(flagval('no'))->isFalse();
     * ```
     *
     * @param mixed $var bool 化する値
     * @param bool $trim $var が文字列の場合に trim するか
     * @return bool bool 化した値
     */
    function flagval($var, $trim = false)
    {
        if ($trim === false && is_string($var)) {
            if (strlen(trim($var)) !== strlen($var)) {
                return true;
            }
        }
        return filter_var($var, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? (bool) $var;
    }
}
if (function_exists("ryunosuke\\Functions\\flagval") && !defined("ryunosuke\\Functions\\flagval")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\flagval", "ryunosuke\\Functions\\flagval");
}

if (!isset($excluded_functions["arrayval"]) && (!function_exists("ryunosuke\\Functions\\arrayval") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\arrayval"))->isInternal()))) {
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
     * that(arrayval(123))->isSame([123]);
     * that(arrayval('str'))->isSame(['str']);
     * that(arrayval([123]))->isSame([123]); // 配列は配列のまま
     *
     * // $recursive = false にしない限り再帰的に適用される
     * $stdclass = stdclass(['key' => 'val']);
     * that(arrayval([$stdclass], true))->isSame([['key' => 'val']]); // true なので中身も配列化される
     * that(arrayval([$stdclass], false))->isSame([$stdclass]);       // false なので中身は変わらない
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
if (function_exists("ryunosuke\\Functions\\arrayval") && !defined("ryunosuke\\Functions\\arrayval")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\arrayval", "ryunosuke\\Functions\\arrayval");
}

if (!isset($excluded_functions["phpval"]) && (!function_exists("ryunosuke\\Functions\\phpval") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\phpval"))->isInternal()))) {
    /**
     * 文字列を php の式として評価して値を返す
     *
     * 実質的には `eval("return $var;")` とほぼ同義。
     * ただ、 eval するまでもない式はそのまま返し、bare な文字列はそのまま文字列として返す（7.2 以前の未定義定数のような動作）。
     *
     * Example:
     * ```php
     * that(phpval('strtoupper($var)', ['var' => 'string']))->isSame('STRING');
     * that(phpval('bare string'))->isSame('bare string');
     * ```
     *
     * @param mixed $var 評価する式
     * @param array $contextvars eval される場合のローカル変数
     * @return mixed 評価した値
     */
    function phpval($var, $contextvars = [])
    {
        if (!is_string($var)) {
            return $var;
        }

        if (defined($var)) {
            return constant($var);
        }
        if (ctype_digit(ltrim($var, '+-'))) {
            return (int) $var;
        }
        if (is_numeric($var)) {
            return (double) $var;
        }

        set_error_handler(function () { });
        try {
            return evaluate("return $var;", $contextvars);
        }
        catch (\Throwable $t) {
            return $var;
        }
        finally {
            restore_error_handler();
        }
    }
}
if (function_exists("ryunosuke\\Functions\\phpval") && !defined("ryunosuke\\Functions\\phpval")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\phpval", "ryunosuke\\Functions\\phpval");
}

if (!isset($excluded_functions["arrayable_key_exists"]) && (!function_exists("ryunosuke\\Functions\\arrayable_key_exists") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\arrayable_key_exists"))->isInternal()))) {
    /**
     * 配列・ArrayAccess にキーがあるか調べる
     *
     * 配列が与えられた場合は array_key_exists と同じ。
     * ArrayAccess は一旦 isset で確認した後 null の場合は実際にアクセスして試みる。
     *
     * Example:
     * ```php
     * $array = [
     *     'k' => 'v',
     *     'n' => null,
     * ];
     * // 配列は array_key_exists と同じ
     * that(arrayable_key_exists('k', $array))->isTrue();  // もちろん存在する
     * that(arrayable_key_exists('n', $array))->isTrue();  // isset ではないので null も true
     * that(arrayable_key_exists('x', $array))->isFalse(); // 存在しないので false
     * that(isset($array['n']))->isFalse();                // isset だと null が false になる（参考）
     *
     * $object = new \ArrayObject($array);
     * // ArrayAccess は isset + 実際に取得を試みる
     * that(arrayable_key_exists('k', $object))->isTrue();  // もちろん存在する
     * that(arrayable_key_exists('n', $object))->isTrue();  // isset ではないので null も true
     * that(arrayable_key_exists('x', $object))->isFalse(); // 存在しないので false
     * that(isset($object['n']))->isFalse();                // isset だと null が false になる（参考）
     * ```
     *
     * @param string|int $key キー
     * @param array|\ArrayAccess $arrayable 調べる値
     * @return bool キーが存在するなら true
     */
    function arrayable_key_exists($key, $arrayable)
    {
        if (is_array($arrayable) || $arrayable instanceof \ArrayAccess) {
            return attr_exists($key, $arrayable);
        }

        throw new \InvalidArgumentException(sprintf('%s must be array or ArrayAccess (%s).', '$arrayable', var_type($arrayable)));
    }
}
if (function_exists("ryunosuke\\Functions\\arrayable_key_exists") && !defined("ryunosuke\\Functions\\arrayable_key_exists")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\arrayable_key_exists", "ryunosuke\\Functions\\arrayable_key_exists");
}

if (!isset($excluded_functions["attr_exists"]) && (!function_exists("ryunosuke\\Functions\\attr_exists") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\attr_exists"))->isInternal()))) {
    /**
     * 配列・オブジェクトを問わずキーやプロパティの存在を確認する
     *
     * 配列が与えられた場合は array_key_exists と同じ。
     * オブジェクトは一旦 isset で確認した後 null の場合は実際にアクセスして試みる。
     *
     * Example:
     * ```php
     * $array = [
     *     'k' => 'v',
     *     'n' => null,
     * ];
     * // 配列は array_key_exists と同じ
     * that(attr_exists('k', $array))->isTrue();  // もちろん存在する
     * that(attr_exists('n', $array))->isTrue();  // isset ではないので null も true
     * that(attr_exists('x', $array))->isFalse(); // 存在しないので false
     *
     * $object = (object) $array;
     * // オブジェクトでも使える
     * that(attr_exists('k', $object))->isTrue();  // もちろん存在する
     * that(attr_exists('n', $object))->isTrue();  // isset ではないので null も true
     * that(attr_exists('x', $object))->isFalse(); // 存在しないので false
     * ```
     *
     * @param int|string $key 調べるキー
     * @param array|object $value 調べられる配列・オブジェクト
     * @return bool $key が存在するなら true
     */
    function attr_exists($key, $value)
    {
        return attr_get($key, $value, $dummy = new \stdClass()) !== $dummy;
    }
}
if (function_exists("ryunosuke\\Functions\\attr_exists") && !defined("ryunosuke\\Functions\\attr_exists")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\attr_exists", "ryunosuke\\Functions\\attr_exists");
}

if (!isset($excluded_functions["attr_get"]) && (!function_exists("ryunosuke\\Functions\\attr_get") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\attr_get"))->isInternal()))) {
    /**
     * 配列・オブジェクトを問わずキーやプロパティの値を取得する
     *
     * 配列が与えられた場合は array_key_exists でチェック。
     * オブジェクトは一旦 isset で確認した後 null の場合は実際にアクセスして取得する。
     *
     * Example:
     * ```php
     * $array = [
     *     'k' => 'v',
     *     'n' => null,
     * ];
     * that(attr_get('k', $array))->isSame('v');                  // もちろん存在する
     * that(attr_get('n', $array))->isSame(null);                 // isset ではないので null も true
     * that(attr_get('x', $array, 'default'))->isSame('default'); // 存在しないのでデフォルト値
     *
     * $object = (object) $array;
     * // オブジェクトでも使える
     * that(attr_get('k', $object))->isSame('v');                  // もちろん存在する
     * that(attr_get('n', $object))->isSame(null);                 // isset ではないので null も true
     * that(attr_get('x', $object, 'default'))->isSame('default'); // 存在しないのでデフォルト値
     * ```
     *
     * @param int|string $key 取得するキー
     * @param array|object $value 取得される配列・オブジェクト
     * @param mixed $default なかった場合のデフォルト値
     * @return mixed $key の値
     */
    function attr_get($key, $value, $default = null)
    {
        if (is_array($value)) {
            // see https://www.php.net/manual/function.array-key-exists.php#107786
            return isset($value[$key]) || array_key_exists($key, $value) ? $value[$key] : $default;
        }

        if ($value instanceof \ArrayAccess) {
            // あるならあるでよい
            if (isset($value[$key])) {
                return $value[$key];
            }
            // 問題は「ない場合」と「あるが null だった場合」の区別で、ArrayAccess の実装次第なので一元的に確定するのは不可能
            // ここでは「ない場合はなんらかのエラー・例外が出るはず」という前提で実際に値を取得して確認する
            try {
                error_clear_last();
                $result = @$value[$key];
                return error_get_last() ? $default : $result;
            }
            catch (\Throwable $t) {
                return $default;
            }
        }

        // 上記のプロパティ版
        if (is_object($value)) {
            try {
                if (isset($value->$key)) {
                    return $value->$key;
                }
                error_clear_last();
                $result = @$value->$key;
                return error_get_last() ? $default : $result;
            }
            catch (\Throwable $t) {
                return $default;
            }
        }

        throw new \InvalidArgumentException(sprintf('%s must be array or object (%s).', '$value', var_type($value)));
    }
}
if (function_exists("ryunosuke\\Functions\\attr_get") && !defined("ryunosuke\\Functions\\attr_get")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\attr_get", "ryunosuke\\Functions\\attr_get");
}

if (!isset($excluded_functions["si_prefix"]) && (!function_exists("ryunosuke\\Functions\\si_prefix") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\si_prefix"))->isInternal()))) {
    /**
     * 数値に SI 接頭辞を付与する
     *
     * 値は 1 <= $var < 1000(1024) の範囲内に収められる。
     * ヨクト（10^24）～ヨタ（1024）まで。整数だとしても 64bit の範囲を超えるような値の精度は保証しない。
     *
     * Example:
     * ```php
     * // シンプルに k をつける
     * that(si_prefix(12345))->isSame('12.345 k');
     * // シンプルに m をつける
     * that(si_prefix(0.012345))->isSame('12.345 m');
     * // 書式フォーマットを指定できる
     * that(si_prefix(12345, 1000, '%d%s'))->isSame('12k');
     * that(si_prefix(0.012345, 1000, '%d%s'))->isSame('12m');
     * // ファイルサイズを byte で表示する
     * that(si_prefix(12345, 1000, '%d %sbyte'))->isSame('12 kbyte');
     * // ファイルサイズを byte で表示する（1024）
     * that(si_prefix(10240, 1024, '%.3f %sbyte'))->isSame('10.000 kbyte');
     * // フォーマットに null を与えると sprintf せずに配列で返す
     * that(si_prefix(12345, 1000, null))->isSame([12.345, 'k']);
     * // フォーマットにクロージャを与えると実行して返す
     * that(si_prefix(12345, 1000, fn($v, $u) => number_format($v, 2) . $u))->isSame('12.35k');
     * ```
     *
     * @param mixed $var 丸める値
     * @param int $unit 桁単位。実用上は 1000, 1024 の2値しか指定することはないはず
     * @param string|\Closure $format 書式フォーマット。 null を与えると sprintf せずに配列で返す
     * @return string|array 丸めた数値と SI 接頭辞で sprintf した文字列（$format が null の場合は配列）
     */
    function si_prefix($var, $unit = 1000, $format = '%.3f %s')
    {
        assert($unit > 0);

        $result = function ($format, $var, $unit) {
            if ($format instanceof \Closure) {
                return $format($var, $unit);
            }
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
        if (!isset(SI_UNITS[$n])) {
            throw new \InvalidArgumentException("$original is too large or small ($n).");
        }
        return $result($format, ($original > 0 ? 1 : -1) * $var, SI_UNITS[$n][0] ?? '');
    }
}
if (function_exists("ryunosuke\\Functions\\si_prefix") && !defined("ryunosuke\\Functions\\si_prefix")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\si_prefix", "ryunosuke\\Functions\\si_prefix");
}

if (!isset($excluded_functions["si_unprefix"]) && (!function_exists("ryunosuke\\Functions\\si_unprefix") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\si_unprefix"))->isInternal()))) {
    /**
     * SI 接頭辞が付与された文字列を数値化する
     *
     * 典型的な用途は ini_get で得られた値を数値化したいとき。
     * ただし、 ini は 1m のように小文字で指定することもあるので大文字化する必要はある。
     *
     * Example:
     * ```php
     * // 1k = 1000
     * that(si_unprefix('1k'))->isSame(1000);
     * // 1k = 1024
     * that(si_unprefix('1k', 1024))->isSame(1024);
     * // m はメガではなくミリ
     * that(si_unprefix('1m'))->isSame(0.001);
     * // M がメガ
     * that(si_unprefix('1M'))->isSame(1000000);
     * // K だけは特別扱いで大文字小文字のどちらでもキロになる
     * that(si_unprefix('1K'))->isSame(1000);
     * ```
     *
     * @param mixed $var 数値化する値
     * @param int $unit 桁単位。実用上は 1000, 1024 の2値しか指定することはないはず
     * @return int|float SI 接頭辞を取り払った実際の数値
     */
    function si_unprefix($var, $unit = 1000)
    {
        assert($unit > 0);

        $var = trim($var);

        foreach (SI_UNITS as $exp => $sis) {
            foreach ($sis as $si) {
                if (strpos($var, $si) === (strlen($var) - strlen($si))) {
                    return numval($var) * pow($unit, $exp);
                }
            }
        }

        return numval($var);
    }
}
if (function_exists("ryunosuke\\Functions\\si_unprefix") && !defined("ryunosuke\\Functions\\si_unprefix")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\si_unprefix", "ryunosuke\\Functions\\si_unprefix");
}

if (!isset($excluded_functions["is_empty"]) && (!function_exists("ryunosuke\\Functions\\is_empty") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\is_empty"))->isInternal()))) {
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
     * ただし、 $empty_stcClass に true を指定すると「フィールドのない stdClass」も true を返すようになる。
     * これは stdClass の立ち位置はかなり特殊で「フィールドアクセスできる組み込み配列」のような扱いをされることが多いため。
     * （例えば `json_decode('{}')` は stdClass を返すが、このような状況は空判定したいことが多いだろう）。
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
     * that(is_empty(null))->isTrue();
     * that(is_empty(false))->isTrue();
     * that(is_empty(0))->isTrue();
     * that(is_empty(''))->isTrue();
     * // この辺だけが異なる
     * that(is_empty('0'))->isFalse();
     * // 第2引数に true を渡すと空の stdClass も empty 判定される
     * $stdclass = new \stdClass();
     * that(is_empty($stdclass, true))->isTrue();
     * // フィールドがあれば empty ではない
     * $stdclass->hoge = 123;
     * that(is_empty($stdclass, true))->isFalse();
     * ```
     *
     * @param mixed $var 判定する値
     * @param bool $empty_stdClass 空の stdClass を空とみなすか
     * @return bool 空なら true
     */
    function is_empty($var, $empty_stdClass = false)
    {
        // object は is_countable 次第
        if (is_object($var)) {
            // が、 stdClass だけは特別扱い（stdClass は継承もできるので、クラス名で判定する（継承していたらそれはもう stdClass ではないと思う））
            if ($empty_stdClass && get_class($var) === 'stdClass') {
                return !(array) $var;
            }
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
if (function_exists("ryunosuke\\Functions\\is_empty") && !defined("ryunosuke\\Functions\\is_empty")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\is_empty", "ryunosuke\\Functions\\is_empty");
}

if (!isset($excluded_functions["is_primitive"]) && (!function_exists("ryunosuke\\Functions\\is_primitive") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\is_primitive"))->isInternal()))) {
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
     * that(is_primitive(null))->isTrue();
     * that(is_primitive(false))->isTrue();
     * that(is_primitive(123))->isTrue();
     * that(is_primitive(STDIN))->isTrue();
     * that(is_primitive(new \stdClass))->isFalse();
     * that(is_primitive(['array']))->isFalse();
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
if (function_exists("ryunosuke\\Functions\\is_primitive") && !defined("ryunosuke\\Functions\\is_primitive")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\is_primitive", "ryunosuke\\Functions\\is_primitive");
}

if (!isset($excluded_functions["is_recursive"]) && (!function_exists("ryunosuke\\Functions\\is_recursive") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\is_recursive"))->isInternal()))) {
    /**
     * 変数が再帰参照を含むか調べる
     *
     * Example:
     * ```php
     * // 配列の再帰
     * $array = [];
     * $array['recursive'] = &$array;
     * that(is_recursive($array))->isTrue();
     * // オブジェクトの再帰
     * $object = new \stdClass();
     * $object->recursive = $object;
     * that(is_recursive($object))->isTrue();
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
            foreach ($var as $v) {
                if ($core($v, $parents)) {
                    return true;
                }
            }
            return false;
        };
        return $core($var, []);
    }
}
if (function_exists("ryunosuke\\Functions\\is_recursive") && !defined("ryunosuke\\Functions\\is_recursive")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\is_recursive", "ryunosuke\\Functions\\is_recursive");
}

if (!isset($excluded_functions["is_stringable"]) && (!function_exists("ryunosuke\\Functions\\is_stringable") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\is_stringable"))->isInternal()))) {
    /**
     * 変数が文字列化できるか調べる
     *
     * 「配列」「__toString を持たないオブジェクト」が false になる。
     * （厳密に言えば配列は "Array" になるので文字列化できるといえるがここでは考えない）。
     *
     * Example:
     * ```php
     * // こいつらは true
     * that(is_stringable(null))->isTrue();
     * that(is_stringable(true))->isTrue();
     * that(is_stringable(3.14))->isTrue();
     * that(is_stringable(STDOUT))->isTrue();
     * that(is_stringable(new \Exception()))->isTrue();
     * // こいつらは false
     * that(is_stringable(new \ArrayObject()))->isFalse();
     * that(is_stringable([1, 2, 3]))->isFalse();
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
if (function_exists("ryunosuke\\Functions\\is_stringable") && !defined("ryunosuke\\Functions\\is_stringable")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\is_stringable", "ryunosuke\\Functions\\is_stringable");
}

if (!isset($excluded_functions["is_arrayable"]) && (!function_exists("ryunosuke\\Functions\\is_arrayable") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\is_arrayable"))->isInternal()))) {
    /**
     * 変数が配列アクセス可能か調べる
     *
     * Example:
     * ```php
     * that(is_arrayable([]))->isTrue();
     * that(is_arrayable(new \ArrayObject()))->isTrue();
     * that(is_arrayable(new \stdClass()))->isFalse();
     * ```
     *
     * @param array|object $var 調べる値
     * @return bool 配列アクセス可能なら true
     */
    function is_arrayable($var)
    {
        return is_array($var) || $var instanceof \ArrayAccess;
    }
}
if (function_exists("ryunosuke\\Functions\\is_arrayable") && !defined("ryunosuke\\Functions\\is_arrayable")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\is_arrayable", "ryunosuke\\Functions\\is_arrayable");
}

if (!isset($excluded_functions["cipher_metadata"]) && (!function_exists("ryunosuke\\Functions\\cipher_metadata") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\cipher_metadata"))->isInternal()))) {
    /**
     * 暗号化アルゴリズムのメタデータを返す
     *
     * ※ 内部向け
     *
     * @param string $cipher 暗号化方式（openssl_get_cipher_methods で得られるもの）
     * @return array 暗号化アルゴリズムのメタデータ
     */
    function cipher_metadata($cipher)
    {
        static $cache = [];

        $cipher = strtolower($cipher);

        if (!in_array($cipher, openssl_get_cipher_methods())) {
            return [];
        }

        if (isset($cache[$cipher])) {
            return $cache[$cipher];
        }

        $ivlen = openssl_cipher_iv_length($cipher);
        @openssl_encrypt('dummy', $cipher, 'password', 0, str_repeat('x', $ivlen), $tag);
        return $cache[$cipher] = [
            'ivlen'  => $ivlen,
            'taglen' => strlen($tag),
        ];
    }
}
if (function_exists("ryunosuke\\Functions\\cipher_metadata") && !defined("ryunosuke\\Functions\\cipher_metadata")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\cipher_metadata", "ryunosuke\\Functions\\cipher_metadata");
}

if (!isset($excluded_functions["encrypt"]) && (!function_exists("ryunosuke\\Functions\\encrypt") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\encrypt"))->isInternal()))) {
    /**
     * 指定されたパスワードで暗号化する
     *
     * データは json を経由して base64（URL セーフ） して返す。
     * $tag を与えると認証タグが設定される。
     *
     * データ末尾には =v が付与される。
     * これによって処理が変わり、バージョン違いの暗号化文字列を与えたとしても複合することができる。
     *
     * - v0: バージョンのない無印。json -> encrypt -> base64
     * - v1: 上記に圧縮処理を加えたもの。json -> deflate -> encrypt -> base64
     * - v2: 生成文字列に $cipher, $iv, $tag を加えたもの。json -> deflate -> cipher+iv+tag+encrypt -> base64
     *
     * Example:
     * ```php
     * $plaindata = ['a', 'b', 'c'];
     * $encrypted = encrypt($plaindata, 'password');
     * $decrypted = decrypt($encrypted, 'password');
     * // 暗号化されて base64 の文字列になる
     * that($encrypted)->isString();
     * // 復号化されて元の配列になる
     * that($decrypted)->isSame(['a', 'b', 'c']);
     * // password が異なれば失敗して null を返す
     * that(decrypt($encrypted, 'invalid'))->isSame(null);
     * ```
     *
     * @param mixed $plaindata 暗号化するデータ
     * @param string $password パスワード。十分な長さ、あるいは鍵導出関数を通した文字列でなければならない
     * @param string $cipher 暗号化方式（openssl_get_cipher_methods で得られるもの）
     * @param string $tag 認証タグ
     * @return string 暗号化された文字列
     */
    function encrypt($plaindata, $password, $cipher = 'aes-256-gcm', &$tag = '')
    {
        $jsondata = json_encode($plaindata, JSON_UNESCAPED_UNICODE);
        $zlibdata = gzdeflate($jsondata, 9);

        $metadata = cipher_metadata($cipher);
        if (!$metadata) {
            throw new \InvalidArgumentException("undefined cipher algorithm('$cipher')");
        }
        $iv = $metadata['ivlen'] ? random_bytes($metadata['ivlen']) : '';
        $payload = openssl_encrypt($zlibdata, $cipher, $password, OPENSSL_RAW_DATA, $iv, ...$metadata['taglen'] ? [&$tag] : []);

        return rtrim(strtr(base64_encode($cipher . ':' . $iv . $tag . $payload), ['+' => '-', '/' => '_']), '=') . '=2';
    }
}
if (function_exists("ryunosuke\\Functions\\encrypt") && !defined("ryunosuke\\Functions\\encrypt")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\encrypt", "ryunosuke\\Functions\\encrypt");
}

if (!isset($excluded_functions["decrypt"]) && (!function_exists("ryunosuke\\Functions\\decrypt") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\decrypt"))->isInternal()))) {
    /**
     * 指定されたパスワードで復号化する
     *
     * $ciphers は配列で複数与えることができる。
     * 複数与えた場合、順に試みて複合できた段階でその値を返す。
     * v2 以降は生成文字列に $cipher が含まれているため指定不要（今後指定してはならない）。
     *
     * 復号に失敗すると null を返す。
     * 単体で使うことはないと思うので詳細は encrypt を参照。
     *
     * @param string $cipherdata 復号化するデータ
     * @param string $password パスワード
     * @param string|array $ciphers 暗号化方式（openssl_get_cipher_methods で得られるもの）
     * @param string $tag 認証タグ
     * @return mixed 復号化されたデータ
     */
    function decrypt($cipherdata, $password, $ciphers = 'aes-256-cbc', $tag = '')
    {
        [$cipherdata, $version] = explode('=', $cipherdata, 2) + [1 => 0];
        $cipherdata = base64_decode(strtr($cipherdata, ['-' => '+', '_' => '/']));
        $version = (int) $version;

        if ($version === 2) {
            [$cipher, $ivtagpayload] = explode(':', $cipherdata, 2) + [1 => null];
            $metadata = cipher_metadata($cipher);
            if (!$metadata) {
                return null;
            }
            $iv = substr($ivtagpayload, 0, $metadata['ivlen']);
            $tag = substr($ivtagpayload, $metadata['ivlen'], $metadata['taglen']);
            $payload = substr($ivtagpayload, $metadata['ivlen'] + $metadata['taglen']);
            $tags = array_merge([$tag], (array) $ciphers); // for compatible
            foreach ($tags as $tag) {
                if ($metadata['taglen'] === strlen($tag)) {
                    $decryptdata = openssl_decrypt($payload, $cipher, $password, OPENSSL_RAW_DATA, $iv, ...$metadata['taglen'] ? [$tag] : []);
                    if ($decryptdata !== false) {
                        return json_decode(gzinflate($decryptdata), true);
                    }
                }
            }
            return null;
        }

        foreach ((array) $ciphers as $c) {
            $ivlen = openssl_cipher_iv_length($c);
            if (strlen($cipherdata) <= $ivlen) {
                continue;
            }
            $iv = substr($cipherdata, 0, $ivlen);
            $payload = substr($cipherdata, $ivlen);

            $decryptdata = openssl_decrypt($payload, $c, $password, OPENSSL_RAW_DATA, $iv, $tag);
            if ($decryptdata !== false) {
                if ($version === 1) {
                    $decryptdata = gzinflate($decryptdata);
                }
                return json_decode($decryptdata, true);
            }
        }
        return null;
    }
}
if (function_exists("ryunosuke\\Functions\\decrypt") && !defined("ryunosuke\\Functions\\decrypt")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\decrypt", "ryunosuke\\Functions\\decrypt");
}

if (!isset($excluded_functions["var_hash"]) && (!function_exists("ryunosuke\\Functions\\var_hash") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\var_hash"))->isInternal()))) {
    /**
     * 値に複数のハッシュアルゴリズムを適用させて結合して返す
     *
     * $data は何らかの方法で文字列化される（この「何らかの方法」は互換性を担保しない）。
     * 文字長がかなり増えるため、 $base64 に true を与えるとバイナリ変換してその結果を base64（url セーフ）して返す。
     * さらに false を与えると 16進数文字列で返し、 null を与えるとバイナリ文字列で返す。
     *
     * Example:
     * ```php
     * // 配列をハッシュ化する
     * that(var_hash(['a', 'b', 'c']))->isSame('7BDgx6NE2hkXAKtKzhpeJm6-mheMOQWNgrCe7768OiFeoWgA');
     * // オブジェクトをハッシュ化する
     * that(var_hash(new \ArrayObject(['a', 'b', 'c'])))->isSame('-zR2rZ58CzuYhhdHn1Oq90zkYSaxMS-dHUbmb0MTRM4gBpj2');
     * ```
     *
     * @param mixed $var ハッシュ化する値
     * @param string[] $algos ハッシュアルゴリズム
     * @param ?bool $base64 結果を base64 化するか
     * @return string ハッシュ文字列
     */
    function var_hash($var, $algos = ['md5', 'sha1'], $base64 = true)
    {
        if (!is_string($var)) {
            $var = serialize($var);
        }

        $algos = arrayize($algos);
        assert($algos);

        $hash = '';
        foreach ($algos as $algo) {
            $hash .= hash($algo, "$var", $base64 !== false);
        }

        if ($base64 !== true) {
            return $hash;
        }

        return rtrim(strtr(base64_encode($hash), ['+' => '-', '/' => '_']));
    }
}
if (function_exists("ryunosuke\\Functions\\var_hash") && !defined("ryunosuke\\Functions\\var_hash")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\var_hash", "ryunosuke\\Functions\\var_hash");
}

if (!isset($excluded_functions["varcmp"]) && (!function_exists("ryunosuke\\Functions\\varcmp") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\varcmp"))->isInternal()))) {
    /**
     * php7 の `<=>` の関数版
     *
     * 引数で大文字小文字とか自然順とか型モードとかが指定できる。
     * さらに追加で SORT_STRICT という厳密比較フラグを渡すことができる。
     *
     * Example:
     * ```php
     * // 'a' と 'z' なら 'z' の方が大きい
     * that(varcmp('z', 'a') > 0)->isTrue();
     * that(varcmp('a', 'z') < 0)->isTrue();
     * that(varcmp('a', 'a') === 0)->isTrue();
     *
     * // 'a' と 'Z' なら 'a' の方が大きい…が SORT_FLAG_CASE なので 'Z' のほうが大きい
     * that(varcmp('Z', 'a', SORT_FLAG_CASE) > 0)->isTrue();
     * that(varcmp('a', 'Z', SORT_FLAG_CASE) < 0)->isTrue();
     * that(varcmp('a', 'A', SORT_FLAG_CASE) === 0)->isTrue();
     *
     * // '2' と '12' なら '2' の方が大きい…が SORT_NATURAL なので '12' のほうが大きい
     * that(varcmp('12', '2', SORT_NATURAL) > 0)->isTrue();
     * that(varcmp('2', '12', SORT_NATURAL) < 0)->isTrue();
     *
     * // SORT_STRICT 定数が使える（下記はすべて宇宙船演算子を使うと 0 になる）
     * that(varcmp(['a' => 'A', 'b' => 'B'], ['b' => 'B', 'a' => 'A'], SORT_STRICT) < 0)->isTrue();
     * that(varcmp((object) ['a'], (object) ['a'], SORT_STRICT) < 0)->isTrue();
     * ```
     *
     * @param mixed $a 比較する値1
     * @param mixed $b 比較する値2
     * @param ?int $mode 比較モード（SORT_XXX）。省略すると型でよしなに選択
     * @param ?int $precision 小数比較の際の誤差桁
     * @return int 等しいなら 0、 $a のほうが大きいなら > 0、 $bのほうが大きいなら < 0
     */
    function varcmp($a, $b, $mode = null, $precision = null)
    {
        // 負数は逆順とみなす
        $reverse = 1;
        if ($mode < 0) {
            $reverse = -1;
            $mode = -$mode;
        }

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
            $delta = $a - $b;
            if ($precision > 0 && abs($delta) < pow(10, -$precision)) {
                return 0;
            }
            return $reverse * (0 < $delta ? 1 : ($delta < 0 ? -1 : 0));
        }
        if ($mode === SORT_STRING) {
            if ($flag_case) {
                return $reverse * strcasecmp($a, $b);
            }
            return $reverse * strcmp($a, $b);
        }
        if ($mode === SORT_NATURAL) {
            if ($flag_case) {
                return $reverse * strnatcasecmp($a, $b);
            }
            return $reverse * strnatcmp($a, $b);
        }
        if ($mode === SORT_STRICT) {
            return $reverse * ($a === $b ? 0 : ($a > $b ? 1 : -1));
        }

        // for SORT_REGULAR
        return $reverse * ($a == $b ? 0 : ($a > $b ? 1 : -1));
    }
}
if (function_exists("ryunosuke\\Functions\\varcmp") && !defined("ryunosuke\\Functions\\varcmp")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\varcmp", "ryunosuke\\Functions\\varcmp");
}

if (!isset($excluded_functions["var_type"]) && (!function_exists("ryunosuke\\Functions\\var_type") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\var_type"))->isInternal()))) {
    /**
     * 値の型を取得する（gettype + get_class）
     *
     * プリミティブ型（gettype で得られるやつ）はそのまま、オブジェクトのときのみクラス名を返す。
     * ただし、オブジェクトの場合は先頭に '\\' が必ず付く。
     * また、 $valid_name を true にするとタイプヒントとして正当な名前を返す（integer -> int, double -> float など）。
     * 互換性のためデフォルト false になっているが、将来的にこの引数は削除されるかデフォルト true に変更される。
     *
     * 無名クラスの場合は extends, implements の優先順位でその名前を使う。
     * 継承も実装もされていない場合は標準の get_class の結果を返す。
     *
     * Example:
     * ```php
     * // プリミティブ型は gettype と同義
     * that(var_type(false))->isSame('boolean');
     * that(var_type(123))->isSame('integer');
     * that(var_type(3.14))->isSame('double');
     * that(var_type([1, 2, 3]))->isSame('array');
     * // オブジェクトは型名を返す
     * that(var_type(new \stdClass))->isSame('\\stdClass');
     * that(var_type(new \Exception()))->isSame('\\Exception');
     * // 無名クラスは継承元の型名を返す（インターフェース実装だけのときはインターフェース名）
     * that(var_type(new class extends \Exception{}))->isSame('\\Exception');
     * that(var_type(new class implements \JsonSerializable{
     *     public function jsonSerialize() { return ''; }
     * }))->isSame('\\JsonSerializable');
     * ```
     *
     * @param mixed $var 型を取得する値
     * @param bool $valid_name タイプヒントとして有効な名前を返すか
     * @return string 型名
     */
    function var_type($var, $valid_name = false)
    {
        if (is_object($var)) {
            $ref = new \ReflectionObject($var);
            if ($ref->isAnonymous()) {
                if ($pc = $ref->getParentClass()) {
                    return '\\' . $pc->name;
                }
                if ($is = $ref->getInterfaceNames()) {
                    return '\\' . reset($is);
                }
            }
            return '\\' . get_class($var);
        }
        $type = gettype($var);
        if (!$valid_name) {
            return $type;
        }
        switch ($type) {
            default:
                return $type;
            case 'NULL':
                return 'null';
            case 'boolean':
                return 'bool';
            case 'integer':
                return 'int';
            case 'double':
                return 'float';
        }
    }
}
if (function_exists("ryunosuke\\Functions\\var_type") && !defined("ryunosuke\\Functions\\var_type")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\var_type", "ryunosuke\\Functions\\var_type");
}

if (!isset($excluded_functions["var_apply"]) && (!function_exists("ryunosuke\\Functions\\var_apply") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\var_apply"))->isInternal()))) {
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
     * that(var_apply(' x ', 'trim'))->isSame('x');
     * // 配列は中身に適用して配列で返す（再帰）
     * that(var_apply([' x ', ' y ', [' z ']], 'trim'))->isSame(['x', 'y', ['z']]);
     * // 第3引数以降は残り引数を意味する
     * that(var_apply(['!x!', '!y!'], 'trim', '!'))->isSame(['x', 'y']);
     * // 「まれによくある」の具体例
     * that(var_apply(['<x>', ['<y>']], 'htmlspecialchars', ENT_QUOTES, 'utf-8'))->isSame(['&lt;x&gt;', ['&lt;y&gt;']]);
     * ```
     *
     * @param mixed $var $callback を適用する値
     * @param callable $callback 値変換コールバック
     * @param mixed ...$args $callback の残り引数（可変引数）
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
if (function_exists("ryunosuke\\Functions\\var_apply") && !defined("ryunosuke\\Functions\\var_apply")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\var_apply", "ryunosuke\\Functions\\var_apply");
}

if (!isset($excluded_functions["var_applys"]) && (!function_exists("ryunosuke\\Functions\\var_applys") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\var_applys"))->isInternal()))) {
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
     * $upper = fn($array) => array_map('strtoupper', $array);
     * // 普通はこうやって使うが・・・
     * that($upper(['a', 'b', 'c']))->isSame(['A', 'B', 'C']);
     * // 手元に配列ではなくスカラー値しか無いときはこうせざるをえない
     * that($upper(['a'])[0])->isSame('A');
     * // var_applys を使うと配列でもスカラーでも統一的に記述することができる
     * that(var_applys(['a', 'b', 'c'], $upper))->isSame(['A', 'B', 'C']);
     * that(var_applys('a', $upper))->isSame('A');
     * # 要するに「大文字化したい」だけなわけだが、$upper が配列を前提としているので、「大文字化」部分を得るには配列化しなければならなくなっている
     * # 「strtoupper だけ切り出せばよいのでは？」と思うかもしれないが、「（外部ライブラリなどで）手元に配列しか受け取ってくれない処理しかない」状況がまれによくある
     * ```
     *
     * @param mixed $var $callback を適用する値
     * @param callable $callback 値変換コールバック
     * @param mixed ...$args $callback の残り引数（可変引数）
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
if (function_exists("ryunosuke\\Functions\\var_applys") && !defined("ryunosuke\\Functions\\var_applys")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\var_applys", "ryunosuke\\Functions\\var_applys");
}

if (!isset($excluded_functions["var_stream"]) && (!function_exists("ryunosuke\\Functions\\var_stream") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\var_stream"))->isInternal()))) {
    /**
     * 変数をリソースのように扱えるファイルポインタを返す
     *
     * 得られたファイルポインタに fread すれば変数の値が見えるし、 fwrite すれば変数の値が書き換わる。
     * 逆に変数を書き換えればファイルポインタで得られる値も書き換わる。
     *
     * 用途は主にテスト用。
     * 例えば「何らかのファイルポインタを要求する処理」に対して fopen や tmpfile を駆使して値の確認をするのは結構めんどくさい。
     * （`rewind` したり `stream_get_contents` したり削除したりする必要がある）。
     * それよりもこの関数で得られたファイルポインタを渡し、 `that($var)->is($expected)` とできる方がテストの視認性が良くなる。
     *
     * Example:
     * ```php
     * // $var のファイルポインタを取得
     * $fp = var_stream($var);
     * // ファイルポインタに書き込みを行うと変数にも反映される
     * fwrite($fp, 'hoge');
     * that($var)->is('hoge');
     * // 変数に追記を行うとファイルポインタで読み取れる
     * $var .= 'fuga';
     * that(fread($fp, 1024))->is('fuga');
     * // 変数をまるっと置換するとファイルポインタ側もまるっと変わる
     * $var = 'hello, world';
     * that(stream_get_contents($fp, -1, 0))->is('hello, world');
     * // ファイルポインタをゴリっと削除すると変数も空になる
     * ftruncate($fp, 0);
     * that($var)->is('');
     * ```
     *
     * @param string|null $var 対象の変数
     * @param string $initial 初期値。与えたときのみ初期化される
     * @return resource 変数のファイルポインタ
     */
    function var_stream(&$var, $initial = '')
    {
        static $STREAM_NAME, $stream_class, $registered = false;
        if (!$registered) {
            $STREAM_NAME = $STREAM_NAME ?: get_cfg_var('rfunc.var_stream') ?: 'VarStreamV010000';
            if (in_array($STREAM_NAME, stream_get_wrappers())) {
                throw new \DomainException("$STREAM_NAME is registered already.");
            }

            $registered = true;
            stream_wrapper_register($STREAM_NAME, $stream_class = get_class(new class() {
                private static $ids     = 0;
                private static $entries = [];

                private $id;
                private $entry;
                private $position;

                public static function create(string &$var): int
                {
                    self::$entries[++self::$ids] = &$var;
                    return self::$ids;
                }

                public function stream_open(string $path, string $mode, int $options, &$opened_path): bool
                {
                    assert([$mode, $options, &$opened_path]);
                    $this->id = parse_url($path, PHP_URL_HOST);
                    $this->entry = &self::$entries[$this->id];
                    $this->position = 0;

                    return true;
                }

                public function stream_close()
                {
                    unset(self::$entries[$this->id]);
                }

                public function stream_lock(int $operation): bool
                {
                    assert(is_int($operation));
                    // 競合しないので常に true を返す
                    return true;
                }

                public function stream_flush(): bool
                {
                    // バッファしないので常に true を返す
                    return true;
                }

                public function stream_eof(): bool
                {
                    // 変数の書き換えを検知する術はないので eof は殺しておく
                    return false;
                }

                public function stream_read(int $count): string
                {
                    $result = substr($this->entry, $this->position, $count);
                    $this->position += strlen($result);
                    return $result;
                }

                public function stream_write(string $data): int
                {
                    $datalen = strlen($data);
                    $posision = $this->position;
                    // 一般的に、ファイルの終端より先の位置に移動することも許されています。
                    // そこにデータを書き込んだ場合、ファイルの終端からシーク位置までの範囲を読み込むと 値 0 が埋められたバイトを返します。
                    $current = str_pad($this->entry, $posision, "\0", STR_PAD_RIGHT);
                    $this->entry = substr_replace($current, $data, $posision, $datalen);
                    $this->position += $datalen;
                    return $datalen;
                }

                public function stream_truncate(int $new_size): bool
                {
                    $current = substr($this->entry, 0, $new_size);
                    $this->entry = str_pad($current, $new_size, "\0", STR_PAD_RIGHT);
                    return true;
                }

                public function stream_tell(): int
                {
                    return $this->position;
                }

                public function stream_seek(int $offset, int $whence = SEEK_SET): bool
                {
                    $strlen = strlen($this->entry);
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
                    $size = strlen($this->entry);
                    return [
                        7      => $size,
                        'size' => $size,
                    ];
                }
            }));
        }

        if (func_num_args() > 1) {
            $var = $initial;
        }
        // タイプヒントによる文字列化とキャストによる文字列化は動作が異なるので、この段階で早めに文字列化しておく
        $var = (string) $var;
        return fopen($STREAM_NAME . '://' . $stream_class::create($var), 'r+b');
    }
}
if (function_exists("ryunosuke\\Functions\\var_stream") && !defined("ryunosuke\\Functions\\var_stream")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\var_stream", "ryunosuke\\Functions\\var_stream");
}

if (!isset($excluded_functions["var_export2"]) && (!function_exists("ryunosuke\\Functions\\var_export2") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\var_export2"))->isInternal()))) {
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
     * that(var_export2(['array' => [1, 2, 3], 'hash' => ['a' => 'A', 'b' => 'B', 'c' => 'C']], true))->isSame('[
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
     * that(var_export2(compact('rarray', 'robject'), true))->isSame('[
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
                return '"' . addcslashes($value, "\$\"\0\\") . '"';
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
if (function_exists("ryunosuke\\Functions\\var_export2") && !defined("ryunosuke\\Functions\\var_export2")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\var_export2", "ryunosuke\\Functions\\var_export2");
}

if (!isset($excluded_functions["var_export3"]) && (!function_exists("ryunosuke\\Functions\\var_export3") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\var_export3"))->isInternal()))) {
    /**
     * var_export を色々と出力できるようにしたもの
     *
     * php のコードに落とし込むことで serialize と比較してかなり高速に動作する。
     *
     * 各種オブジェクトやクロージャ、循環参照を含む配列など様々なものが出力できる。
     * ただし、下記は不可能あるいは復元不可（今度も対応するかは未定）。
     *
     * - Generator クラス
     * - 特定の内部クラス（PDO など）
     * - リソース
     * - アロー関数によるクロージャ
     *
     * オブジェクトは「リフレクションを用いてコンストラクタなしで生成してプロパティを代入する」という手法で復元する。
     * のでクラスによってはおかしな状態で復元されることがある（大体はリソース型のせいだが…）。
     * sleep, wakeup, Serializable などが実装されているとそれはそのまま機能する。
     * set_state だけは呼ばれないので注意。
     *
     * クロージャはコード自体を引っ張ってきて普通に function (){} として埋め込む。
     * クラス名のエイリアスや use, $this バインドなど可能な限り復元するが、おそらくあまりに複雑なことをしてると失敗する。
     *
     * 軽くベンチを取ったところ、オブジェクトを含まない純粋な配列の場合、serialize の 200 倍くらいは速い（それでも var_export の方が速いが…）。
     * オブジェクトを含めば含むほど遅くなり、全要素がオブジェクトになると serialize と同程度になる。
     * 大体 var_export:var_export3:serialize が 1:5:1000 くらい。
     *
     * @param mixed $value エクスポートする値
     * @param bool|array $return 返り値として返すなら true. 配列を与えるとオプションになる
     * @return string エクスポートされた文字列
     */
    function var_export3($value, $return = false)
    {
        // 原則として var_export に合わせたいのでデフォルトでは bool: false で単に出力するのみとする
        if (is_bool($return)) {
            $return = [
                'return' => $return,
            ];
        }
        $options = $return;
        $options += [
            'format'  => 'pretty', // pretty or minify
            'outmode' => null,     // null: 本体のみ, 'eval': return ...;, 'file': <?php return ...;
        ];
        $options['return'] ??= !!$options['outmode'];

        $var_manager = new class() {
            private $vars = [];
            private $refs = [];

            private function arrayHasReference($array)
            {
                foreach ($array as $k => $v) {
                    $ref = \ReflectionReference::fromArrayElement($array, $k);
                    if ($ref) {
                        return true;
                    }
                    if (is_array($v) && $this->arrayHasReference($v)) {
                        return true;
                    }
                }
                return false;
            }

            public function varId($var)
            {
                // オブジェクトは明確な ID が取れる（closure/object の区分けに処理的な意味はない）
                if (is_object($var)) {
                    $id = ($var instanceof \Closure ? 'closure' : 'object') . (spl_object_id($var) + 1);
                    $this->vars[$id] = $var;
                    return $id;
                }
                // 配列は明確な ID が存在しないので、貯めて検索して ID を振る（参照さえ含まなければ ID に意味はないので参照込みのみ）
                if (is_array($var) && $this->arrayHasReference($var)) {
                    $id = array_search($var, $this->vars, true);
                    if (!$id) {
                        $id = 'array' . (count($this->vars) + 1);
                    }
                    $this->vars[$id] = $var;
                    return $id;
                }
            }

            public function refId($array, $k)
            {
                static $ids = [];
                $ref = \ReflectionReference::fromArrayElement($array, $k);
                if ($ref) {
                    $refid = $ref->getId();
                    $ids[$refid] = ($ids[$refid] ?? count($ids) + 1);
                    $id = 'reference' . $ids[$refid];
                    $this->refs[$id] = $array[$k];
                    return $id;
                }
            }

            public function orphan()
            {
                foreach ($this->refs as $rid => $var) {
                    $vid = array_search($var, $this->vars, true);
                    yield $rid => [!!$vid, $vid, $var];
                }
            }
        };

        // 再帰用クロージャ
        $vars = [];
        $export = function ($value, $nest = 0) use (&$export, &$vars, $var_manager) {
            $neighborToken = function ($n, $d, $tokens) {
                for ($i = $n + $d; isset($tokens[$i]); $i += $d) {
                    if ($tokens[$i][0] !== T_WHITESPACE) {
                        return $tokens[$i];
                    }
                }
            };
            $resolveSymbol = function ($token, $prev, $next, $filename) {
                if ($token[0] === T_STRING) {
                    if ($prev[0] === T_NEW || $next[0] === T_DOUBLE_COLON || $next[0] === T_VARIABLE || $next[1] === '{') {
                        $token[1] = resolve_symbol($token[1], $filename, 'alias') ?? $token[1];
                    }
                    elseif ($next[1] === '(') {
                        $token[1] = resolve_symbol($token[1], $filename, 'function') ?? $token[1];
                    }
                    else {
                        $token[1] = resolve_symbol($token[1], $filename, 'const') ?? $token[1];
                    }
                }
                return $token;
            };
            $var_export = fn($v) => var_export($v, true);
            $spacer0 = str_repeat(" ", 4 * ($nest + 0));
            $spacer1 = str_repeat(" ", 4 * ($nest + 1));

            $vid = $var_manager->varId($value);
            if ($vid) {
                if (isset($vars[$vid])) {
                    return "\$this->$vid";
                }
                $vars[$vid] = $value;
            }

            if (is_array($value)) {
                $hashed = is_hasharray($value);
                if (!$hashed && array_all($value, is_primitive)) {
                    [$begin, $middle, $end] = ["", ", ", ""];
                }
                else {
                    [$begin, $middle, $end] = ["\n{$spacer1}", ",\n{$spacer1}", ",\n{$spacer0}"];
                }

                $keys = array_map($var_export, array_combine($keys = array_keys($value), $keys));
                $maxlen = max(array_map('strlen', $keys ?: ['']));
                $kvl = [];
                foreach ($value as $k => $v) {
                    $refid = $var_manager->refId($value, $k);
                    $keystr = $hashed ? $keys[$k] . str_repeat(" ", $maxlen - strlen($keys[$k])) . " => " : '';
                    $valstr = $refid ? "&\$this->$refid" : $export($v, $nest + 1);
                    $kvl[] = $keystr . $valstr;
                }
                $kvl = implode($middle, $kvl);
                $declare = $vid ? "\$this->$vid = " : "";
                return "{$declare}[$begin{$kvl}$end]";
            }
            if ($value instanceof \Closure) {
                $ref = new \ReflectionFunction($value);
                $bind = $ref->getClosureThis();
                $class = $ref->getClosureScopeClass() ? $ref->getClosureScopeClass()->getName() : null;
                $statics = $ref->getStaticVariables();

                // 内部由来はきちんと fromCallable しないと差異が出てしまう
                if ($ref->isInternal()) {
                    $receiver = $bind ?? $class;
                    $callee = $receiver ? [$receiver, $ref->getName()] : $ref->getName();
                    return "\$this->$vid = \\Closure::fromCallable({$export($callee, $nest)})";
                }

                $tokens = array_slice(parse_php(implode(' ', callable_code($value)) . ';', TOKEN_PARSE), 1, -1);
                $uses = "";
                $context = [
                    'use'   => false,
                    'class' => 0,
                    'brace' => 0,
                ];
                foreach ($tokens as $n => $token) {
                    $prev = $neighborToken($n, -1, $tokens) ?? [null, null, null];
                    $next = $neighborToken($n, +1, $tokens) ?? [null, null, null];

                    // クロージャは何でもかける（クロージャ・無名クラス・ジェネレータ etc）のでネスト（ブレース）レベルを記録しておく
                    if ($token[1] === '{') {
                        $context['brace']++;
                    }
                    if ($token[1] === '}') {
                        $context['brace']--;
                    }

                    // 無名クラスは色々厄介なので読み飛ばすために覚えておく
                    if ($prev[0] === T_NEW && $token[0] === T_CLASS) {
                        $context['class'] = $context['brace'];
                    }
                    // そして無名クラスは色々かける上に終了条件が自明ではない（シンタックスエラーでない限りは {} が一致するはず）
                    if ($token[1] === '}' && $context['class'] === $context['brace']) {
                        $context['class'] = 0;
                    }

                    // fromCallable 由来だと名前がついてしまう
                    if (!$context['class'] && $prev[0] === T_FUNCTION && $token[0] === T_STRING) {
                        unset($tokens[$n]);
                        continue;
                    }

                    // use 変数の導出
                    if ($prev[1] === ')' && $token[0] === T_USE) {
                        $context['use'] = true;
                    }
                    if ($context['use'] && $token[0] === T_VARIABLE) {
                        $varname = substr($token[1], 1);
                        // クロージャ内クロージャの use に反応してしまうので存在するときのみとする
                        if (array_key_exists($varname, $statics)) {
                            $recurself = $statics[$varname] === $value ? '&' : '';
                            $uses .= "$spacer1\$$varname = $recurself{$export($statics[$varname], $nest + 1)};\n";
                        }
                    }
                    if ($context['use'] && $token[1] === ')') {
                        $context['use'] = false;
                    }

                    $tokens[$n] = $resolveSymbol($token, $prev, $next, $ref->getFileName());
                }

                $code = indent_php(implode('', array_column($tokens, 1)), [
                    'indent'   => $spacer1,
                    'baseline' => -1,
                ]);
                if ($bind) {
                    $scope = $var_export($class === 'Closure' ? 'static' : $class);
                    $code = "\Closure::bind($code, {$export($bind, $nest + 1)}, $scope)";
                }
                elseif (!is_bindable_closure($value)) {
                    $code = "static $code";
                }

                return "\$this->$vid = (function () {\n{$uses}{$spacer1}return $code;\n$spacer0})->call(\$this)";
            }
            if (is_object($value)) {
                $ref = new \ReflectionObject($value);

                // ジェネレータはどう頑張っても無理
                if ($value instanceof \Generator) {
                    throw new \DomainException('Generator Class is not support.');
                }

                // 無名クラスは定義がないのでパースが必要
                // さらにコンストラクタを呼ぶわけには行かない（引数を検出するのは不可能）ので潰す必要もある
                if ($ref->isAnonymous()) {
                    $fname = $ref->getFileName();
                    $sline = $ref->getStartLine();
                    $eline = $ref->getEndLine();
                    $tokens = parse_php(implode('', array_slice(file($fname), $sline - 1, $eline - $sline + 1)));

                    $block = [];
                    $starting = false;
                    $constructing = 0;
                    $nesting = 0;
                    foreach ($tokens as $n => $token) {
                        $prev = $neighborToken($n, -1, $tokens) ?? [null, null, null];
                        $next = $neighborToken($n, +1, $tokens) ?? [null, null, null];

                        // 無名クラスは new class で始まるはず
                        if ($token[0] === T_NEW && $next[0] === T_CLASS) {
                            $starting = true;
                        }
                        if (!$starting) {
                            continue;
                        }

                        // コンストラクタの呼び出し引数はスキップする
                        if ($constructing !== null) {
                            if ($token[1] === '(') {
                                $constructing++;
                            }
                            if ($token[1] === ')') {
                                $constructing--;
                                if ($constructing === 0) {
                                    $constructing = null;          // null を終了済みマークとして変数を再利用している
                                    $block[] = [null, '()', null]; // for psr-12
                                    continue;
                                }
                            }
                            if ($constructing) {
                                continue;
                            }
                        }

                        // コンストラクタは呼ばないのでリネームしておく
                        if ($token[1] === '__construct') {
                            $token[1] = "replaced__construct";
                        }

                        $block[] = $resolveSymbol($token, $prev, $next, $ref->getFileName());

                        if ($token[1] === '{') {
                            $nesting++;
                        }
                        if ($token[1] === '}') {
                            $nesting--;
                            if ($nesting === 0) {
                                break;
                            }
                        }
                    }

                    $code = indent_php(implode('', array_column($block, 1)), [
                        'indent'   => $spacer1,
                        'baseline' => -1,
                    ]);
                    $classname = "(function () {\n{$spacer1}return $code;\n{$spacer0}})";
                }
                else {
                    $classname = "\\" . get_class($value) . "::class";
                }

                $privates = [];

                // __serialize があるならそれに従う
                if (method_exists($value, '__serialize')) {
                    $fields = $value->__serialize();
                }
                // __sleep があるならそれをプロパティとする
                elseif (method_exists($value, '__sleep')) {
                    $fields = array_intersect_key(get_object_properties($value, $privates), array_flip($value->__sleep()));
                }
                // それ以外は適当に漁る
                else {
                    $fields = get_object_properties($value, $privates);
                }

                return "\$this->new(\$this->$vid, $classname, (function () {\n{$spacer1}return {$export([$fields, $privates], $nest + 1)};\n{$spacer0}}))";
            }

            return is_null($value) || is_resource($value) ? 'null' : $var_export($value);
        };

        $exported = $export($value, 1);
        $others = "";
        $vars = [];
        foreach ($var_manager->orphan() as $rid => [$isref, $vid, $var]) {
            $declare = $isref ? "&\$this->$vid" : $export($var, 1);
            $others .= "    \$this->$rid = $declare;\n";
        }
        $result = "(function () {
{$others}    return $exported;
" . '})->call(new class() {
    public function new(&$object, $class, $provider)
    {
        if ($class instanceof \\Closure) {
            $object = $class();
            $reflection = $this->reflect(get_class($object));
        }
        else {
            $reflection = $this->reflect($class);
            $object = $reflection["self"]->newInstanceWithoutConstructor();
        }
        [$fields, $privates] = $provider();

        if ($reflection["unserialize"]) {
            $object->__unserialize($fields);
            return $object;
        }

        foreach ($reflection["parents"] as $parent) {
            foreach ($this->reflect($parent->name)["properties"] as $name => $property) {
                if (isset($privates[$parent->name][$name])) {
                    $property->setValue($object, $privates[$parent->name][$name]);
                }
                if (isset($fields[$name]) || array_key_exists($name, $fields)) {
                    $property->setValue($object, $fields[$name]);
                    unset($fields[$name]);
                }
            }
        }
        foreach ($fields as $name => $value) {
            $object->$name = $value;
        }

        if ($reflection["wakeup"]) {
            $object->__wakeup();
        }

        return $object;
    }

    private function reflect($class)
    {
        static $cache = [];
        if (!isset($cache[$class])) {
            $refclass = new \ReflectionClass($class);
            $cache[$class] = [
                "self"        => $refclass,
                "parents"     => [],
                "properties"  => [],
                "unserialize" => $refclass->hasMethod("__unserialize"),
                "wakeup"      => $refclass->hasMethod("__wakeup"),
            ];
            for ($current = $refclass; $current; $current = $current->getParentClass()) {
                $cache[$class]["parents"][$current->name] = $current;
            }
            foreach ($refclass->getProperties() as $property) {
                if (!$property->isStatic()) {
                    $property->setAccessible(true);
                    $cache[$class]["properties"][$property->name] = $property;
                }
            }
        }
        return $cache[$class];
    }
})';

        if ($options['format'] === 'minify') {
            $tmp = memory_path('var_export3.php');
            file_put_contents($tmp, "<?php $result;");
            $result = substr(php_strip_whitespace($tmp), 6, -1);
        }

        if ($options['outmode'] === 'eval') {
            $result = "return $result;";
        }
        if ($options['outmode'] === 'file') {
            $result = "<?php return $result;\n";
        }

        if (!$options['return']) {
            echo $result;
        }
        return $result;
    }
}
if (function_exists("ryunosuke\\Functions\\var_export3") && !defined("ryunosuke\\Functions\\var_export3")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\var_export3", "ryunosuke\\Functions\\var_export3");
}

if (!isset($excluded_functions["var_html"]) && (!function_exists("ryunosuke\\Functions\\var_html") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\var_html"))->isInternal()))) {
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
if (function_exists("ryunosuke\\Functions\\var_html") && !defined("ryunosuke\\Functions\\var_html")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\var_html", "ryunosuke\\Functions\\var_html");
}

if (!isset($excluded_functions["var_pretty"]) && (!function_exists("ryunosuke\\Functions\\var_pretty") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\var_pretty"))->isInternal()))) {
    /**
     * var_dump の出力を見やすくしたもの
     *
     * var_dump はとても縦に長い上見づらいので色や改行・空白を調整して見やすくした。
     * sapi に応じて自動で色分けがなされる（$context で指定もできる）。
     * また、 xdebug のように呼び出しファイル:行数が先頭に付与される。
     *
     * この関数の出力は互換性を考慮しない。頻繁に変更される可能性がある。
     *
     * Example:
     * ```php
     * // 下記のように出力される（実際は色付きで出力される）
     * $using = 123;
     * var_pretty([
     *     "array"   => [1, 2, 3],
     *     "hash"    => [
     *         "a" => "A",
     *         "b" => "B",
     *         "c" => "C",
     *     ],
     *     "object"  => new \Exception(),
     *     "closure" => function () use ($using) { },
     * ]);
     * ?>
     * {
     *   array: [1, 2, 3],
     *   hash: {
     *     a: 'A',
     *     b: 'B',
     *     c: 'C',
     *   },
     *   object: Exception#1 {
     *     message: '',
     *     string: '',
     *     code: 0,
     *     file: '...',
     *     line: 19,
     *     trace: [],
     *     previous: null,
     *   },
     *   closure: Closure#0(static) use {
     *     using: 123,
     *   },
     * }
     * <?php
     * ```
     *
     * @param mixed $value 出力する値
     * @param array|string|null $context 出力コンテキスト（[null, "plain", "cli", "html"]）。 null を渡すと自動判別される
     * @param bool $return 出力するのではなく値を返すなら true
     * @return string $return: true なら値の出力結果
     */
    function var_pretty($value, $context = null, $return = false)
    {
        $options = [
            'indent'    => 2,     // インデントの空白数
            'context'   => null,  // html なコンテキストか cli なコンテキストか
            'return'    => false, // 値を戻すか出力するか
            'trace'     => false, // スタックトレースの表示
            'callback'  => null,  // 値1つごとのコールバック（値と文字列表現（参照）が引数で渡ってくる）
            'debuginfo' => true,  // debugInfo を利用してオブジェクトのプロパティを絞るか
            'maxcolumn' => null,  // 1行あたりの文字数
            'maxcount'  => null,  // 複合型の要素の数
            'maxdepth'  => null,  // 複合型の深さ
            'maxlength' => null,  // スカラー・非複合配列の文字数
            'limit'     => null,  // 最終出力の文字数
        ];

        // for compatible
        if (!is_array($context)) {
            $context = [
                'context' => $context,
                'return'  => $return,
            ];
        }
        $options = array_replace($options, $context);

        if ($options['context'] === null) {
            $options['context'] = 'html'; // SAPI でテストカバレッジが辛いので if else ではなくデフォルト代入にしてある
            if (PHP_SAPI === 'cli') {
                $options['context'] = is_ansi(STDOUT) && !$options['return'] ? 'cli' : 'plain';
            }
        }

        $appender = new class($options) {
            private $options;
            private $objects;
            private $content;
            private $length;
            private $column;

            public function __construct($options)
            {
                $this->options = $options;
                $this->objects = [];
                $this->content = '';
                $this->length = 0;
                $this->column = 0;
            }

            private function _append($value, $style = null, $data = [])
            {
                $strlen = strlen($value);

                if ($this->options['limit'] && $this->options['limit'] < $this->length += $strlen) {
                    throw new \LengthException($this->content);
                }

                //$current = count($this->content) - 1;
                if ($this->options['maxcolumn'] !== null) {
                    $breakpos = strrpos($value, "\n");
                    if ($breakpos === false) {
                        $this->column += $strlen;
                    }
                    else {
                        $this->column = $strlen - $breakpos - 1;
                    }
                    if ($this->column >= $this->options['maxcolumn']) {
                        preg_match('# +#', $this->content, $m, 0, strrpos($this->content, "\n"));
                        $this->column = 0;
                        $this->content .= "\n\t" . $m[0];
                    }
                }

                if ($style === null || $this->options['context'] === 'plain') {
                    $this->content .= $value;
                }
                elseif ($this->options['context'] === 'cli') {
                    $this->content .= ansi_colorize($value, $style);
                }
                elseif ($this->options['context'] === 'html') {
                    // 今のところ bold しか使っていないのでこれでよい
                    $style = $style === 'bold' ? 'font-weight:bold' : "color:$style";
                    $dataattr = array_sprintf($data, 'data-%2$s="%1$s"', ' ');
                    $this->content .= "<span style='$style' $dataattr>" . htmlspecialchars($value, ENT_QUOTES) . '</span>';
                }
                else {
                    throw new \InvalidArgumentException("'{$this->options['context']}' is not supported.");
                }
                return $this;
            }

            public function plain($token)
            {
                return $this->_append($token);
            }

            public function index($token)
            {
                if (is_int($token)) {
                    return $this->_append($token, 'bold');
                }
                elseif (is_string($token)) {
                    return $this->_append($token, 'red');
                }
                elseif (is_object($token)) {
                    return $this->_append($this->string($token), 'green', ['type' => 'object-index', 'id' => spl_object_id($token)]);
                }
                else {
                    throw new \DomainException(); // @codeCoverageIgnore
                }
            }

            public function value($token)
            {
                if (is_null($token)) {
                    return $this->_append($this->string($token), 'bold', ['type' => 'null']);
                }
                elseif (is_object($token)) {
                    return $this->_append($this->string($token), 'green', ['type' => 'object', 'id' => spl_object_id($token)]);
                }
                elseif (is_resource($token)) {
                    return $this->_append($this->string($token), 'bold', ['type' => 'resource']);
                }
                elseif (is_string($token)) {
                    return $this->_append($this->string($token), 'magenta', ['type' => 'scalar']);
                }
                elseif (is_bool($token)) {
                    return $this->_append($this->string($token), 'bold', ['type' => 'bool']);
                }
                elseif (is_scalar($token)) {
                    return $this->_append($this->string($token), 'magenta', ['type' => 'scalar']);
                }
                else {
                    throw new \DomainException(); // @codeCoverageIgnore
                }
            }

            public function string($token)
            {
                if (is_null($token)) {
                    return 'null';
                }
                elseif (is_object($token)) {
                    return get_class($token) . "#" . spl_object_id($token);
                }
                elseif (is_resource($token)) {
                    return sprintf('%s of type (%s)', $token, get_resource_type($token));
                }
                elseif (is_string($token)) {
                    if ($this->options['maxlength']) {
                        $token = str_ellipsis($token, $this->options['maxlength'], '...(too length)...');
                    }
                    return var_export($token, true);
                }
                elseif (is_scalar($token)) {
                    return var_export($token, true);
                }
                else {
                    throw new \DomainException(gettype($token)); // @codeCoverageIgnore
                }
            }

            public function export($value, $nest, $parents, $callback)
            {
                $position = strlen($this->content);

                // オブジェクトは一度処理してれば無駄なので参照表示
                if (is_object($value)) {
                    $id = spl_object_id($value);
                    if (isset($this->objects[$id])) {
                        $this->index($value);
                        goto FINALLY_;
                    }
                    $this->objects[$id] = $value;
                }

                // 再帰を検出したら *RECURSION* とする（処理に関しては is_recursive のコメント参照）
                foreach ($parents as $parent) {
                    if ($parent === $value) {
                        $this->plain('*RECURSION*');
                        goto FINALLY_;
                    }
                }

                if (is_array($value)) {
                    if ($this->options['maxdepth'] && $nest + 1 > $this->options['maxdepth']) {
                        $this->plain('(too deep)');
                        goto FINALLY_;
                    }

                    $parents[] = $value;

                    $count = count($value);
                    $omitted = false;
                    if ($this->options['maxcount'] && ($omitted = $count - $this->options['maxcount']) > 0) {
                        $value = array_slice($value, 0, $this->options['maxcount'], true);
                    }

                    $is_hasharray = is_hasharray($value);
                    $primitive_only = array_all($value, is_primitive);
                    $assoc = $is_hasharray || !$primitive_only;

                    $spacer1 = str_repeat(' ', ($nest + 1) * $this->options['indent']);
                    $spacer2 = str_repeat(' ', ($nest + 0) * $this->options['indent']);

                    $key = null;
                    if ($primitive_only && $this->options['maxlength']) {
                        $lengths = [];
                        foreach ($value as $k => $v) {
                            if ($assoc) {
                                $lengths[] = strlen($this->string($spacer1)) + strlen($this->string($k)) + strlen($this->string($v)) + 4;
                            }
                            else {
                                $lengths[] = strlen($this->string($v)) + 2;
                            }
                        }
                        while (count($lengths) > 0 && array_sum($lengths) > $this->options['maxlength']) {
                            $middle = (int) (count($lengths) / 2);
                            $unpos = fn($v, $k, $n) => $n === $middle;
                            array_unset($value, $unpos);
                            array_unset($lengths, $unpos);
                            $key = (int) (count($lengths) / 2);
                        }
                    }

                    if ($count === 0) {
                        $this->plain('[]');
                    }
                    elseif ($assoc) {
                        $n = 0;
                        if ($is_hasharray) {
                            $this->plain("{\n");
                        }
                        else {
                            $this->plain("[\n");
                        }
                        if (!$value) {
                            $this->plain($spacer1)->plain('...(too length)...')->plain(",\n");
                        }
                        foreach ($value as $k => $v) {
                            if ($key === $n++) {
                                $this->plain($spacer1)->plain('...(too length)...')->plain(",\n");
                            }
                            $this->plain($spacer1);
                            if ($is_hasharray) {
                                $this->index($k)->plain(': ');
                            }
                            $this->export($v, $nest + 1, $parents, true);
                            $this->plain(",\n");
                        }
                        if ($omitted > 0) {
                            $this->plain("$spacer1(more $omitted elements)\n");
                        }
                        if ($is_hasharray) {
                            $this->plain("{$spacer2}}");
                        }
                        else {
                            $this->plain("{$spacer2}]");
                        }
                    }
                    else {
                        $lastkey = last_key($value);
                        $n = 0;
                        $this->plain('[');
                        if (!$value) {
                            $this->plain('...(too length)...')->plain(', ');
                        }
                        foreach ($value as $k => $v) {
                            if ($key === $n++) {
                                $this->plain('...(too length)...')->plain(', ');
                            }
                            $this->export($v, $nest, $parents, true);
                            if ($k !== $lastkey) {
                                $this->plain(', ');
                            }
                        }
                        if ($omitted > 0) {
                            $this->plain(" (more $omitted elements)");
                        }
                        $this->plain(']');
                    }
                }
                elseif ($value instanceof \Closure) {
                    /** @var \ReflectionFunctionAbstract $ref */
                    $ref = reflect_callable($value);
                    $that = $ref->getClosureThis();
                    $properties = $ref->getStaticVariables();

                    $this->value($value)->plain("(");
                    if ($that) {
                        $this->index($that);
                    }
                    else {
                        $this->plain("static");
                    }
                    $this->plain(') use ');
                    if ($properties) {
                        $this->export($properties, $nest, $parents, false);
                    }
                    else {
                        $this->plain('{}');
                    }
                }
                elseif (is_object($value)) {
                    if ($this->options['debuginfo'] && method_exists($value, '__debugInfo')) {
                        $properties = [];
                        foreach (array_reverse($value->__debugInfo(), true) as $k => $v) {
                            $p = strrpos($k, "\0");
                            if ($p !== false) {
                                $k = substr($k, $p + 1);
                            }
                            $properties[$k] = $v;
                        }
                    }
                    else {
                        $properties = get_object_properties($value);
                    }

                    $this->value($value)->plain(" ");
                    if ($properties) {
                        $this->export($properties, $nest, $parents, false);
                    }
                    else {
                        $this->plain('{}');
                    }
                }
                else {
                    $this->value($value);
                }

                FINALLY_:
                $content = substr($this->content, $position);
                if ($callback && $this->options['callback']) {
                    ($this->options['callback'])($content, $value, $nest);
                    $this->content = substr_replace($this->content, $content, $position);
                }
                return $content;
            }
        };

        try {
            $content = $appender->export($value, 0, [], false);
        }
        catch (\LengthException $ex) {
            $content = $ex->getMessage() . '(...omitted)';
        }

        if ($options['callback']) {
            ($options['callback'])($content, $value, 0);
        }

        // 結果を返したり出力したり
        $traces = [];
        if ($options['trace']) {
            $traces = stacktrace(null, ['format' => "%s:%s", 'args' => false, 'delimiter' => null]);
            $traces = array_reverse(array_slice($traces, 0, $options['trace'] === true ? null : $options['trace']));
            $traces[] = '';
        }
        $result = implode("\n", $traces) . $content;

        if ($options['context'] === 'html') {
            $result = "<pre class='var_pretty'>$result</pre>";
        }
        if ($options['return']) {
            return $result;
        }
        echo $result, "\n";
    }
}
if (function_exists("ryunosuke\\Functions\\var_pretty") && !defined("ryunosuke\\Functions\\var_pretty")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\var_pretty", "ryunosuke\\Functions\\var_pretty");
}

if (!isset($excluded_functions["console_log"]) && (!function_exists("ryunosuke\\Functions\\console_log") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\console_log"))->isInternal()))) {
    /**
     * js の console に値を吐き出す
     *
     * script タグではなく X-ChromeLogger-Data を使用する。
     * したがってヘッダ送信前に呼ぶ必要がある。
     *
     * @see https://craig.is/writing/chrome-logger/techspecs
     *
     * @param mixed ...$values 出力する値（可変引数）
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
if (function_exists("ryunosuke\\Functions\\console_log") && !defined("ryunosuke\\Functions\\console_log")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\console_log", "ryunosuke\\Functions\\console_log");
}

if (!isset($excluded_functions["hashvar"]) && (!function_exists("ryunosuke\\Functions\\hashvar") || (!false && (new \ReflectionFunction("ryunosuke\\Functions\\hashvar"))->isInternal()))) {
    /**
     * 変数指定をできるようにした compact
     *
     * 名前空間指定の呼び出しは未対応。use して関数名だけで呼び出す必要がある。
     *
     * Example:
     * ```php
     * $hoge = 'HOGE';
     * $fuga = 'FUGA';
     * that(hashvar($hoge, $fuga))->isSame(['hoge' => 'HOGE', 'fuga' => 'FUGA']);
     * ```
     *
     * @param mixed ...$vars 変数（可変引数）
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
if (function_exists("ryunosuke\\Functions\\hashvar") && !defined("ryunosuke\\Functions\\hashvar")) {
    /**
     *
     */
    define("ryunosuke\\Functions\\hashvar", "ryunosuke\\Functions\\hashvar");
}

<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../pcre/preg_replaces.php';
require_once __DIR__ . '/../random/unique_string.php';
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
    static $keywords = [
        'ACCESSIBLE'                 => true,
        'ACTION'                     => true,
        'ADD'                        => true,
        'AFTER'                      => true,
        'AGAINST'                    => true,
        'AGGREGATE'                  => true,
        'ALGORITHM'                  => true,
        'ALL'                        => true,
        'ALTER'                      => true,
        'ALTER TABLE'                => true,
        'ANALYSE'                    => true,
        'ANALYZE'                    => true,
        'AND'                        => true,
        'AS'                         => true,
        'ASC'                        => true,
        'AUTOCOMMIT'                 => true,
        'AUTO_INCREMENT'             => true,
        'BACKUP'                     => true,
        'BEGIN'                      => true,
        'BETWEEN'                    => true,
        'BINLOG'                     => true,
        'BOTH'                       => true,
        'CASCADE'                    => true,
        'CASE'                       => true,
        'CHANGE'                     => true,
        'CHANGED'                    => true,
        'CHARACTER SET'              => true,
        'CHARSET'                    => true,
        'CHECK'                      => true,
        'CHECKSUM'                   => true,
        'COLLATE'                    => true,
        'COLLATION'                  => true,
        'COLUMN'                     => true,
        'COLUMNS'                    => true,
        'COMMENT'                    => true,
        'COMMIT'                     => true,
        'COMMITTED'                  => true,
        'COMPRESSED'                 => true,
        'CONCURRENT'                 => true,
        'CONSTRAINT'                 => true,
        'CONTAINS'                   => true,
        'CONVERT'                    => true,
        'CREATE'                     => true,
        'CROSS'                      => true,
        'CURRENT_TIMESTAMP'          => true,
        'DATABASE'                   => true,
        'DATABASES'                  => true,
        'DAY'                        => true,
        'DAY_HOUR'                   => true,
        'DAY_MINUTE'                 => true,
        'DAY_SECOND'                 => true,
        'DEFAULT'                    => true,
        'DEFINER'                    => true,
        'DELAYED'                    => true,
        'DELETE'                     => true,
        'DELETE FROM'                => true,
        'DESC'                       => true,
        'DESCRIBE'                   => true,
        'DETERMINISTIC'              => true,
        'DISTINCT'                   => true,
        'DISTINCTROW'                => true,
        'DIV'                        => true,
        'DO'                         => true,
        'DROP'                       => true,
        'DUMPFILE'                   => true,
        'DUPLICATE'                  => true,
        'DYNAMIC'                    => true,
        'ELSE'                       => true,
        'ENCLOSED'                   => true,
        'END'                        => true,
        'ENGINE'                     => true,
        'ENGINES'                    => true,
        'ENGINE_TYPE'                => true,
        'ESCAPE'                     => true,
        'ESCAPED'                    => true,
        'EVENTS'                     => true,
        'EXCEPT'                     => true,
        'EXECUTE'                    => true,
        'EXISTS'                     => true,
        'EXPLAIN'                    => true,
        'EXTENDED'                   => true,
        'FAST'                       => true,
        'FIELDS'                     => true,
        'FILE'                       => true,
        'FIRST'                      => true,
        'FIXED'                      => true,
        'FLUSH'                      => true,
        'FOR'                        => true,
        'FORCE'                      => true,
        'FOREIGN'                    => true,
        'FROM'                       => true,
        'FULL'                       => true,
        'FULLTEXT'                   => true,
        'FUNCTION'                   => true,
        'GLOBAL'                     => true,
        'GRANT'                      => true,
        'GRANTS'                     => true,
        'GROUP'                      => true,
        'GROUP_CONCAT'               => true,
        'HAVING'                     => true,
        'HEAP'                       => true,
        'HIGH_PRIORITY'              => true,
        'HOSTS'                      => true,
        'HOUR'                       => true,
        'HOUR_MINUTE'                => true,
        'HOUR_SECOND'                => true,
        'IDENTIFIED'                 => true,
        'IF'                         => true,
        'IFNULL'                     => true,
        'IGNORE'                     => true,
        'IN'                         => true,
        'INDEX'                      => true,
        'INDEXES'                    => true,
        'INFILE'                     => true,
        'INNER'                      => true,
        'INSERT'                     => true,
        'INSERT_ID'                  => true,
        'INSERT_METHOD'              => true,
        'INTERSECT'                  => true,
        'INTERVAL'                   => true,
        'INTO'                       => true,
        'INVOKER'                    => true,
        'IS'                         => true,
        'ISOLATION'                  => true,
        'JOIN'                       => true,
        'JSON_ARRAY'                 => true,
        'JSON_ARRAY_APPEND'          => true,
        'JSON_ARRAY_INSERT'          => true,
        'JSON_CONTAINS'              => true,
        'JSON_CONTAINS_PATH'         => true,
        'JSON_DEPTH'                 => true,
        'JSON_EXTRACT'               => true,
        'JSON_INSERT'                => true,
        'JSON_KEYS'                  => true,
        'JSON_LENGTH'                => true,
        'JSON_MERGE_PATCH'           => true,
        'JSON_MERGE_PRESERVE'        => true,
        'JSON_OBJECT'                => true,
        'JSON_PRETTY'                => true,
        'JSON_QUOTE'                 => true,
        'JSON_REMOVE'                => true,
        'JSON_REPLACE'               => true,
        'JSON_SEARCH'                => true,
        'JSON_SET'                   => true,
        'JSON_STORAGE_SIZE'          => true,
        'JSON_TYPE'                  => true,
        'JSON_UNQUOTE'               => true,
        'JSON_VALID'                 => true,
        'KEY'                        => true,
        'KEYS'                       => true,
        'KILL'                       => true,
        'LAST_INSERT_ID'             => true,
        'LATERAL'                    => true,
        'LEADING'                    => true,
        'LEFT'                       => true,
        'LEVEL'                      => true,
        'LIKE'                       => true,
        'LIMIT'                      => true,
        'LINEAR'                     => true,
        'LINES'                      => true,
        'LOAD'                       => true,
        'LOCAL'                      => true,
        'LOCK'                       => true,
        'LOCKS'                      => true,
        'LOGS'                       => true,
        'LOW_PRIORITY'               => true,
        'MARIA'                      => true,
        'MASTER'                     => true,
        'MASTER_CONNECT_RETRY'       => true,
        'MASTER_HOST'                => true,
        'MASTER_LOG_FILE'            => true,
        'MATCH'                      => true,
        'MAX_CONNECTIONS_PER_HOUR'   => true,
        'MAX_QUERIES_PER_HOUR'       => true,
        'MAX_ROWS'                   => true,
        'MAX_UPDATES_PER_HOUR'       => true,
        'MAX_USER_CONNECTIONS'       => true,
        'MEDIUM'                     => true,
        'MERGE'                      => true,
        'MINUTE'                     => true,
        'MINUTE_SECOND'              => true,
        'MIN_ROWS'                   => true,
        'MODE'                       => true,
        'MODIFY'                     => true,
        'MONTH'                      => true,
        'MRG_MYISAM'                 => true,
        'MYISAM'                     => true,
        'NAMES'                      => true,
        'NATURAL'                    => true,
        'NOT'                        => true,
        'NOW()'                      => true,
        'NULL'                       => true,
        'OFFSET'                     => true,
        'ON'                         => true,
        'ON DELETE'                  => true,
        'ON UPDATE'                  => true,
        'OPEN'                       => true,
        'OPTIMIZE'                   => true,
        'OPTION'                     => true,
        'OPTIONALLY'                 => true,
        'OR'                         => true,
        'ORDER'                      => true,
        'BY'                         => true,
        'OUTER'                      => true,
        'OUTFILE'                    => true,
        'PACK_KEYS'                  => true,
        'PAGE'                       => true,
        'PARTIAL'                    => true,
        'PARTITION'                  => true,
        'PARTITIONS'                 => true,
        'PASSWORD'                   => true,
        'PRIMARY'                    => true,
        'PRIVILEGES'                 => true,
        'PROCEDURE'                  => true,
        'PROCESS'                    => true,
        'PROCESSLIST'                => true,
        'PURGE'                      => true,
        'QUICK'                      => true,
        'RAID0'                      => true,
        'RAID_CHUNKS'                => true,
        'RAID_CHUNKSIZE'             => true,
        'RAID_TYPE'                  => true,
        'RANGE'                      => true,
        'READ'                       => true,
        'READ_ONLY'                  => true,
        'READ_WRITE'                 => true,
        'REFERENCES'                 => true,
        'REGEXP'                     => true,
        'RELEASE'                    => true,
        'RELOAD'                     => true,
        'RENAME'                     => true,
        'REPAIR'                     => true,
        'REPEATABLE'                 => true,
        'REPLACE'                    => true,
        'REPLICATION'                => true,
        'RESET'                      => true,
        'RESTORE'                    => true,
        'RESTRICT'                   => true,
        'RETURN'                     => true,
        'RETURNS'                    => true,
        'REVOKE'                     => true,
        'RIGHT'                      => true,
        'RLIKE'                      => true,
        'ROLLBACK'                   => true,
        'ROLLUP'                     => true,
        'ROW'                        => true,
        'ROWS'                       => true,
        'ROW_FORMAT'                 => true,
        'SAVEPOINT'                  => true,
        'SECOND'                     => true,
        'SECURITY'                   => true,
        'SELECT'                     => true,
        'SEPARATOR'                  => true,
        'SERIALIZABLE'               => true,
        'SESSION'                    => true,
        'SET'                        => true,
        'SHARE'                      => true,
        'SHOW'                       => true,
        'SHUTDOWN'                   => true,
        'SLAVE'                      => true,
        'SONAME'                     => true,
        'SOUNDS'                     => true,
        'SQL'                        => true,
        'SQL_AUTO_IS_NULL'           => true,
        'SQL_BIG_RESULT'             => true,
        'SQL_BIG_SELECTS'            => true,
        'SQL_BIG_TABLES'             => true,
        'SQL_BUFFER_RESULT'          => true,
        'SQL_CACHE'                  => true,
        'SQL_CALC_FOUND_ROWS'        => true,
        'SQL_LOG_BIN'                => true,
        'SQL_LOG_OFF'                => true,
        'SQL_LOG_UPDATE'             => true,
        'SQL_LOW_PRIORITY_UPDATES'   => true,
        'SQL_MAX_JOIN_SIZE'          => true,
        'SQL_NO_CACHE'               => true,
        'SQL_QUOTE_SHOW_CREATE'      => true,
        'SQL_SAFE_UPDATES'           => true,
        'SQL_SELECT_LIMIT'           => true,
        'SQL_SLAVE_SKIP_COUNTER'     => true,
        'SQL_SMALL_RESULT'           => true,
        'SQL_WARNINGS'               => true,
        'START'                      => true,
        'STARTING'                   => true,
        'STATUS'                     => true,
        'STOP'                       => true,
        'STORAGE'                    => true,
        'STRAIGHT_JOIN'              => true,
        'STRING'                     => true,
        'STRIPED'                    => true,
        'SUPER'                      => true,
        'TABLE'                      => true,
        'TABLES'                     => true,
        'TEMPORARY'                  => true,
        'TERMINATED'                 => true,
        'THEN'                       => true,
        'TO'                         => true,
        'TRAILING'                   => true,
        'TRANSACTIONAL'              => true,
        'TRUE'                       => true,
        'TRUNCATE'                   => true,
        'TYPE'                       => true,
        'TYPES'                      => true,
        'UNCOMMITTED'                => true,
        'UNION'                      => true,
        'UNION ALL'                  => true,
        'UNIQUE'                     => true,
        'UNLOCK'                     => true,
        'UNSIGNED'                   => true,
        'UPDATE'                     => true,
        'USAGE'                      => true,
        'USE'                        => true,
        'USING'                      => true,
        'VALUES'                     => true,
        'VARIABLES'                  => true,
        'VIEW'                       => true,
        'WHEN'                       => true,
        'WHERE'                      => true,
        'WITH'                       => true,
        'WORK'                       => true,
        'WRITE'                      => true,
        'XOR'                        => true,
        'YEAR_MONTH'                 => true,
        'ABS'                        => true,
        'ACOS'                       => true,
        'ADDDATE'                    => true,
        'ADDTIME'                    => true,
        'AES_DECRYPT'                => true,
        'AES_ENCRYPT'                => true,
        'AREA'                       => true,
        'ASBINARY'                   => true,
        'ASCII'                      => true,
        'ASIN'                       => true,
        'ASTEXT'                     => true,
        'ATAN'                       => true,
        'ATAN2'                      => true,
        'AVG'                        => true,
        'BDMPOLYFROMTEXT'            => true,
        'BDMPOLYFROMWKB'             => true,
        'BDPOLYFROMTEXT'             => true,
        'BDPOLYFROMWKB'              => true,
        'BENCHMARK'                  => true,
        'BIN'                        => true,
        'BIT_AND'                    => true,
        'BIT_COUNT'                  => true,
        'BIT_LENGTH'                 => true,
        'BIT_OR'                     => true,
        'BIT_XOR'                    => true,
        'BOUNDARY'                   => true,
        'BUFFER'                     => true,
        'CAST'                       => true,
        'CEIL'                       => true,
        'CEILING'                    => true,
        'CENTROID'                   => true,
        'CHAR'                       => true,
        'CHARACTER_LENGTH'           => true,
        'CHAR_LENGTH'                => true,
        'COALESCE'                   => true,
        'COERCIBILITY'               => true,
        'COMPRESS'                   => true,
        'CONCAT'                     => true,
        'CONCAT_WS'                  => true,
        'CONNECTION_ID'              => true,
        'CONV'                       => true,
        'CONVERT_TZ'                 => true,
        'CONVEXHULL'                 => true,
        'COS'                        => true,
        'COT'                        => true,
        'COUNT'                      => true,
        'CRC32'                      => true,
        'CROSSES'                    => true,
        'CURDATE'                    => true,
        'CURRENT_DATE'               => true,
        'CURRENT_TIME'               => true,
        'CURRENT_USER'               => true,
        'CURTIME'                    => true,
        'DATE'                       => true,
        'DATEDIFF'                   => true,
        'DATE_ADD'                   => true,
        'DATE_DIFF'                  => true,
        'DATE_FORMAT'                => true,
        'DATE_SUB'                   => true,
        'DAYNAME'                    => true,
        'DAYOFMONTH'                 => true,
        'DAYOFWEEK'                  => true,
        'DAYOFYEAR'                  => true,
        'DECODE'                     => true,
        'DEGREES'                    => true,
        'DES_DECRYPT'                => true,
        'DES_ENCRYPT'                => true,
        'DIFFERENCE'                 => true,
        'DIMENSION'                  => true,
        'DISJOINT'                   => true,
        'DISTANCE'                   => true,
        'ELT'                        => true,
        'ENCODE'                     => true,
        'ENCRYPT'                    => true,
        'ENDPOINT'                   => true,
        'ENVELOPE'                   => true,
        'EQUALS'                     => true,
        'EXP'                        => true,
        'EXPORT_SET'                 => true,
        'EXTERIORRING'               => true,
        'EXTRACT'                    => true,
        'EXTRACTVALUE'               => true,
        'FIELD'                      => true,
        'FIND_IN_SET'                => true,
        'FLOOR'                      => true,
        'FORMAT'                     => true,
        'FOUND_ROWS'                 => true,
        'FROM_DAYS'                  => true,
        'FROM_UNIXTIME'              => true,
        'GEOMCOLLFROMTEXT'           => true,
        'GEOMCOLLFROMWKB'            => true,
        'GEOMETRYCOLLECTION'         => true,
        'GEOMETRYCOLLECTIONFROMTEXT' => true,
        'GEOMETRYCOLLECTIONFROMWKB'  => true,
        'GEOMETRYFROMTEXT'           => true,
        'GEOMETRYFROMWKB'            => true,
        'GEOMETRYN'                  => true,
        'GEOMETRYTYPE'               => true,
        'GEOMFROMTEXT'               => true,
        'GEOMFROMWKB'                => true,
        'GET_FORMAT'                 => true,
        'GET_LOCK'                   => true,
        'GLENGTH'                    => true,
        'GREATEST'                   => true,
        'GROUP_UNIQUE_USERS'         => true,
        'HEX'                        => true,
        'INET_ATON'                  => true,
        'INET_NTOA'                  => true,
        'INSTR'                      => true,
        'INTERIORRINGN'              => true,
        'INTERSECTION'               => true,
        'INTERSECTS'                 => true,
        'ISCLOSED'                   => true,
        'ISEMPTY'                    => true,
        'ISNULL'                     => true,
        'ISRING'                     => true,
        'ISSIMPLE'                   => true,
        'IS_FREE_LOCK'               => true,
        'IS_USED_LOCK'               => true,
        'LAST_DAY'                   => true,
        'LCASE'                      => true,
        'LEAST'                      => true,
        'LENGTH'                     => true,
        'LINEFROMTEXT'               => true,
        'LINEFROMWKB'                => true,
        'LINESTRING'                 => true,
        'LINESTRINGFROMTEXT'         => true,
        'LINESTRINGFROMWKB'          => true,
        'LN'                         => true,
        'LOAD_FILE'                  => true,
        'LOCALTIME'                  => true,
        'LOCALTIMESTAMP'             => true,
        'LOCATE'                     => true,
        'LOG'                        => true,
        'LOG10'                      => true,
        'LOG2'                       => true,
        'LOWER'                      => true,
        'LPAD'                       => true,
        'LTRIM'                      => true,
        'MAKEDATE'                   => true,
        'MAKETIME'                   => true,
        'MAKE_SET'                   => true,
        'MASTER_POS_WAIT'            => true,
        'MAX'                        => true,
        'MBRCONTAINS'                => true,
        'MBRDISJOINT'                => true,
        'MBREQUAL'                   => true,
        'MBRINTERSECTS'              => true,
        'MBROVERLAPS'                => true,
        'MBRTOUCHES'                 => true,
        'MBRWITHIN'                  => true,
        'MD5'                        => true,
        'MICROSECOND'                => true,
        'MID'                        => true,
        'MIN'                        => true,
        'MLINEFROMTEXT'              => true,
        'MLINEFROMWKB'               => true,
        'MOD'                        => true,
        'MONTHNAME'                  => true,
        'MPOINTFROMTEXT'             => true,
        'MPOINTFROMWKB'              => true,
        'MPOLYFROMTEXT'              => true,
        'MPOLYFROMWKB'               => true,
        'MULTILINESTRING'            => true,
        'MULTILINESTRINGFROMTEXT'    => true,
        'MULTILINESTRINGFROMWKB'     => true,
        'MULTIPOINT'                 => true,
        'MULTIPOINTFROMTEXT'         => true,
        'MULTIPOINTFROMWKB'          => true,
        'MULTIPOLYGON'               => true,
        'MULTIPOLYGONFROMTEXT'       => true,
        'MULTIPOLYGONFROMWKB'        => true,
        'NAME_CONST'                 => true,
        'NULLIF'                     => true,
        'NUMGEOMETRIES'              => true,
        'NUMINTERIORRINGS'           => true,
        'NUMPOINTS'                  => true,
        'OCT'                        => true,
        'OCTET_LENGTH'               => true,
        'OLD_PASSWORD'               => true,
        'ORD'                        => true,
        'OVERLAPS'                   => true,
        'PERIOD_ADD'                 => true,
        'PERIOD_DIFF'                => true,
        'PI'                         => true,
        'POINT'                      => true,
        'POINTFROMTEXT'              => true,
        'POINTFROMWKB'               => true,
        'POINTN'                     => true,
        'POINTONSURFACE'             => true,
        'POLYFROMTEXT'               => true,
        'POLYFROMWKB'                => true,
        'POLYGON'                    => true,
        'POLYGONFROMTEXT'            => true,
        'POLYGONFROMWKB'             => true,
        'POSITION'                   => true,
        'POW'                        => true,
        'POWER'                      => true,
        'QUARTER'                    => true,
        'QUOTE'                      => true,
        'RADIANS'                    => true,
        'RAND'                       => true,
        'RELATED'                    => true,
        'RELEASE_LOCK'               => true,
        'REPEAT'                     => true,
        'REVERSE'                    => true,
        'ROUND'                      => true,
        'ROW_COUNT'                  => true,
        'RPAD'                       => true,
        'RTRIM'                      => true,
        'SCHEMA'                     => true,
        'SEC_TO_TIME'                => true,
        'SESSION_USER'               => true,
        'SHA'                        => true,
        'SHA1'                       => true,
        'SIGN'                       => true,
        'SIN'                        => true,
        'SLEEP'                      => true,
        'SOUNDEX'                    => true,
        'SPACE'                      => true,
        'SQRT'                       => true,
        'SRID'                       => true,
        'STARTPOINT'                 => true,
        'STD'                        => true,
        'STDDEV'                     => true,
        'STDDEV_POP'                 => true,
        'STDDEV_SAMP'                => true,
        'STRCMP'                     => true,
        'STR_TO_DATE'                => true,
        'SUBDATE'                    => true,
        'SUBSTR'                     => true,
        'SUBSTRING'                  => true,
        'SUBSTRING_INDEX'            => true,
        'SUBTIME'                    => true,
        'SUM'                        => true,
        'SYMDIFFERENCE'              => true,
        'SYSDATE'                    => true,
        'SYSTEM_USER'                => true,
        'TAN'                        => true,
        'TIME'                       => true,
        'TIMEDIFF'                   => true,
        'TIMESTAMP'                  => true,
        'TIMESTAMPADD'               => true,
        'TIMESTAMPDIFF'              => true,
        'TIME_FORMAT'                => true,
        'TIME_TO_SEC'                => true,
        'TOUCHES'                    => true,
        'TO_DAYS'                    => true,
        'TRIM'                       => true,
        'UCASE'                      => true,
        'UNCOMPRESS'                 => true,
        'UNCOMPRESSED_LENGTH'        => true,
        'UNHEX'                      => true,
        'UNIQUE_USERS'               => true,
        'UNIX_TIMESTAMP'             => true,
        'UPDATEXML'                  => true,
        'UPPER'                      => true,
        'USER'                       => true,
        'UTC_DATE'                   => true,
        'UTC_TIME'                   => true,
        'UTC_TIMESTAMP'              => true,
        'UUID'                       => true,
        'VARIANCE'                   => true,
        'VAR_POP'                    => true,
        'VAR_SAMP'                   => true,
        'VERSION'                    => true,
        'WEEK'                       => true,
        'WEEKDAY'                    => true,
        'WEEKOFYEAR'                 => true,
        'WITHIN'                     => true,
        'X'                          => true,
        'Y'                          => true,
        'YEAR'                       => true,
        'YEARWEEK'                   => true,
    ];

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
        $rule = $rules[$options['highlight']] ?? throw new \InvalidArgumentException('highlight must be "cli" or "html".');
        $options['highlight'] = function ($token, $ttype) use ($keywords, $rule) {
            return match (true) {
                isset($keywords[strtoupper($token)])                                      => $rule['KEYWORD']($token),
                in_array($ttype, [T_COMMENT, T_DOC_COMMENT])                              => $rule['COMMENT']($token),
                in_array($ttype, [T_CONSTANT_ENCAPSED_STRING, T_ENCAPSED_AND_WHITESPACE]) => $rule['STRING']($token),
                in_array($ttype, [T_LNUMBER, T_DNUMBER])                                  => $rule['NUMBER']($token),
                default                                                                   => $token,
            };
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
    foreach (\PhpToken::tokenize("<?php $sql") as $token) {
        // パースのために無理やり <?php を付けているので無視
        if ($token->id === T_OPEN_TAG) {
            continue;
        }

        // '--' は php ではデクリメントだが sql ではコメントなので特別扱いする
        if ($token->id === T_DEC) {
            $comment = $token->text;
        }
        // 改行は '--' コメントの終わり
        elseif ($comment && in_array($token->id, [T_WHITESPACE, T_COMMENT], true) && strpos($token->text, "\n") !== false) {
            $tokens[] = new \PhpToken(T_COMMENT, $comment . $token->text);
            $comment = '';
        }
        // コメント中はコメントに格納する
        elseif ($comment) {
            $comment .= $token->text;
        }
        // END IF, END LOOP などは一つのトークンとする
        elseif (strtoupper($last->text ?? '') === 'END' && in_array(strtoupper($token->text), ['CASE', 'IF', 'LOOP', 'REPEAT', 'WHILE'], true)) {
            $lasttoken = $tokens[array_key_last($tokens)];
            $lasttoken->text .= " " . $token->text;
        }
        // 上記以外はただのトークンとして格納する
        else {
            // `string` のような文字列は T_ENCAPSED_AND_WHITESPACE として得られる（ただし ` がついていないので付与）
            if ($token->id === T_ENCAPSED_AND_WHITESPACE) {
                $tokens[] = new \PhpToken($token->id, "`{$token->text}`");
            }
            elseif ($token->id !== T_WHITESPACE && $token->text !== '`') {
                $tokens[] = new \PhpToken($token->id, $token->text);
            }
        }

        if ($token->id !== T_WHITESPACE) {
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
            if ($token->id === T_COMMENT || $token->id === T_DOC_COMMENT) {
                $comments[] = trim($token->text);
            }
            else {
                return [$index, trim($token->text), $comments];
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
            $ttype = $token->id;

            $rawtoken = trim($token->text);
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
                    // （コメントを含めた）先頭行にスペースがついてしまう
                    // "tablename. columnname" になってしまう
                    // "@ var" になってしまう
                    // ": holder" になってしまう
                    if (!in_array($prev[1], ['', '.', '@', ':', ';'], true)) {
                        $result[] = $MARK_SP;
                    }

                    $result[] = $virttoken;

                    // "tablename .columnname" になってしまう
                    // "columnname ," になってしまう
                    // mysql において関数呼び出し括弧の前に空白は許されない
                    // ただし、関数呼び出しではなく記号の場合はスペースを入れたい（ colname = (SELECT ～) など）
                    if (!in_array($prev[1], [';']) && !in_array($next[1], ['.', ',', '(', ';']) || ($next[1] === '(' && !preg_match('#^[a-z0-9_"\'`]+$#i', $rawtoken))) {
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
                case "LATERAL":
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
                case "COMMIT":
                case "ROLLBACK":
                case "SAVEPOINT":
                case "RELEASE":
                    // begin は begin～end の一部の可能性があるが commit,rollback は俺の知る限りそのような構文はない
                    $result[] = $virttoken;
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

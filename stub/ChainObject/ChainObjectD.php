<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectD
{
    /** @see \date() */
    public self $date;
    public function date(string $format, ?int $timestamp = null): self { }
    public function date(?int $timestamp = null): self { }

    /** @see \date_create() */
    public self $date_create;
    public function date_create(string $datetime = "now", ?\DateTimeZone $timezone = null): self { }
    public function date_create(?\DateTimeZone $timezone = null): self { }

    /** @see \date_create_immutable() */
    public self $date_create_immutable;
    public function date_create_immutable(string $datetime = "now", ?\DateTimeZone $timezone = null): self { }
    public function date_create_immutable(?\DateTimeZone $timezone = null): self { }

    /** @see \date_create_from_format() */
    public self $date_create_from_format;
    public function date_create_from_format(string $format, string $datetime, ?\DateTimeZone $timezone = null): self { }
    public function date_create_from_format(string $datetime, ?\DateTimeZone $timezone = null): self { }

    /** @see \date_create_immutable_from_format() */
    public self $date_create_immutable_from_format;
    public function date_create_immutable_from_format(string $format, string $datetime, ?\DateTimeZone $timezone = null): self { }
    public function date_create_immutable_from_format(string $datetime, ?\DateTimeZone $timezone = null): self { }

    /** @see \date_parse() */
    public self $date_parse;
    public function date_parse(string $datetime): self { }
    public function date_parse(): self { }

    /** @see \date_parse_from_format() */
    public self $date_parse_from_format;
    public function date_parse_from_format(string $format, string $datetime): self { }
    public function date_parse_from_format(string $datetime): self { }

    /** @see \date_format() */
    public self $date_format;
    public function date_format(\DateTimeInterface $object, string $format): self { }
    public function date_format(string $format): self { }

    /** @see \date_modify() */
    public self $date_modify;
    public function date_modify(\DateTime $object, string $modifier): self { }
    public function date_modify(string $modifier): self { }

    /** @see \date_add() */
    public self $date_add;
    public function date_add(\DateTime $object, \DateInterval $interval): self { }
    public function date_add(\DateInterval $interval): self { }

    /** @see \date_sub() */
    public self $date_sub;
    public function date_sub(\DateTime $object, \DateInterval $interval): self { }
    public function date_sub(\DateInterval $interval): self { }

    /** @see \date_timezone_get() */
    public self $date_timezone_get;
    public function date_timezone_get(\DateTimeInterface $object): self { }
    public function date_timezone_get(): self { }

    /** @see \date_timezone_set() */
    public self $date_timezone_set;
    public function date_timezone_set(\DateTime $object, \DateTimeZone $timezone): self { }
    public function date_timezone_set(\DateTimeZone $timezone): self { }

    /** @see \date_offset_get() */
    public self $date_offset_get;
    public function date_offset_get(\DateTimeInterface $object): self { }
    public function date_offset_get(): self { }

    /** @see \date_diff() */
    public self $date_diff;
    public function date_diff(\DateTimeInterface $baseObject, \DateTimeInterface $targetObject, bool $absolute = false): self { }
    public function date_diff(\DateTimeInterface $targetObject, bool $absolute = false): self { }

    /** @see \date_time_set() */
    public self $date_time_set;
    public function date_time_set(\DateTime $object, int $hour, int $minute, int $second = 0, int $microsecond = 0): self { }
    public function date_time_set(int $hour, int $minute, int $second = 0, int $microsecond = 0): self { }

    /** @see \date_date_set() */
    public self $date_date_set;
    public function date_date_set(\DateTime $object, int $year, int $month, int $day): self { }
    public function date_date_set(int $year, int $month, int $day): self { }

    /** @see \date_isodate_set() */
    public self $date_isodate_set;
    public function date_isodate_set(\DateTime $object, int $year, int $week, int $dayOfWeek = 1): self { }
    public function date_isodate_set(int $year, int $week, int $dayOfWeek = 1): self { }

    /** @see \date_timestamp_set() */
    public self $date_timestamp_set;
    public function date_timestamp_set(\DateTime $object, int $timestamp): self { }
    public function date_timestamp_set(int $timestamp): self { }

    /** @see \date_timestamp_get() */
    public self $date_timestamp_get;
    public function date_timestamp_get(\DateTimeInterface $object): self { }
    public function date_timestamp_get(): self { }

    /** @see \date_interval_create_from_date_string() */
    public self $date_interval_create_from_date_string;
    public function date_interval_create_from_date_string(string $datetime): self { }
    public function date_interval_create_from_date_string(): self { }

    /** @see \date_interval_format() */
    public self $date_interval_format;
    public function date_interval_format(\DateInterval $object, string $format): self { }
    public function date_interval_format(string $format): self { }

    /** @see \date_default_timezone_set() */
    public self $date_default_timezone_set;
    public function date_default_timezone_set(string $timezoneId): self { }
    public function date_default_timezone_set(): self { }

    /** @see \date_sunrise() */
    public self $date_sunrise;
    public function date_sunrise(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }
    public function date_sunrise(int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }

    /** @see \date_sunset() */
    public self $date_sunset;
    public function date_sunset(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }
    public function date_sunset(int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }

    /** @see \date_sun_info() */
    public self $date_sun_info;
    public function date_sun_info(int $timestamp, float $latitude, float $longitude): self { }
    public function date_sun_info(float $latitude, float $longitude): self { }

    /** @see \dns_check_record() */
    public self $dns_check_record;
    public function dns_check_record(string $hostname, string $type = "MX"): self { }
    public function dns_check_record(string $type = "MX"): self { }

    /** @see \dns_get_record() */
    public self $dns_get_record;
    public function dns_get_record(string $hostname, int $type = DNS_ANY, &$authoritative_name_servers = null, &$additional_records = null, bool $raw = false): self { }
    public function dns_get_record(int $type = DNS_ANY, &$authoritative_name_servers = null, &$additional_records = null, bool $raw = false): self { }

    /** @see \dns_get_mx() */
    public self $dns_get_mx;
    public function dns_get_mx(string $hostname, &$hosts, &$weights = null): self { }
    public function dns_get_mx(&$hosts, &$weights = null): self { }

    /** @see \dirname() */
    public self $dirname;
    public function dirname(string $path, int $levels = 1): self { }
    public function dirname(int $levels = 1): self { }

    /** @see \dir() */
    public self $dir;
    public function dir(string $directory, $context = null): self { }
    public function dir($context = null): self { }

    /** @see \disk_total_space() */
    public self $disk_total_space;
    public function disk_total_space(string $directory): self { }
    public function disk_total_space(): self { }

    /** @see \disk_free_space() */
    public self $disk_free_space;
    public function disk_free_space(string $directory): self { }
    public function disk_free_space(): self { }

    /** @see \diskfreespace() */
    public self $diskfreespace;
    public function diskfreespace(string $directory): self { }
    public function diskfreespace(): self { }

    /** @see \deg2rad() */
    public self $deg2rad;
    public function deg2rad(float $num): self { }
    public function deg2rad(): self { }

    /** @see \decbin() */
    public self $decbin;
    public function decbin(int $num): self { }
    public function decbin(): self { }

    /** @see \decoct() */
    public self $decoct;
    public function decoct(int $num): self { }
    public function decoct(): self { }

    /** @see \dechex() */
    public self $dechex;
    public function dechex(int $num): self { }
    public function dechex(): self { }

    /** @see \doubleval() */
    public self $doubleval;
    public function doubleval(mixed $value): self { }
    public function doubleval(): self { }

    /** @see \debug_zval_dump() */
    public self $debug_zval_dump;
    public function debug_zval_dump(mixed ...$values): self { }
    public function debug_zval_dump(): self { }

    /** @see \dl() */
    public self $dl;
    public function dl(string $extension_filename): self { }
    public function dl(): self { }

    /** @see \detect_namespace() */
    public self $detect_namespace;
    public function detect_namespace($location): self { }
    public function detect_namespace(): self { }

    /** @see \date_validate() */
    public self $date_validate;
    public function date_validate($datetime_string, $format = "Y/m/d H:i:s", $overhour = 0): self { }
    public function date_validate($format = "Y/m/d H:i:s", $overhour = 0): self { }

    /** @see \date_timestamp() */
    public self $date_timestamp;
    public function date_timestamp($datetimedata, $baseTimestamp = null): self { }
    public function date_timestamp($baseTimestamp = null): self { }

    /** @see \date_convert() */
    public self $date_convert;
    public function date_convert($format, $datetimedata = null): self { }
    public function date_convert($datetimedata = null): self { }

    /** @see \date_fromto() */
    public self $date_fromto;
    public function date_fromto($format, $datetimestring): self { }
    public function date_fromto($datetimestring): self { }

    /** @see \date_interval() */
    public self $date_interval;
    public function date_interval($sec, $format = null, $limit_type = "y"): self { }
    public function date_interval($format = null, $limit_type = "y"): self { }

    /** @see \date_interval_second() */
    public self $date_interval_second;
    public function date_interval_second($interval, $basetime = 0): self { }
    public function date_interval_second($basetime = 0): self { }

    /** @see \date_alter() */
    public self $date_alter;
    public function date_alter($datetime, $excluded_dates, $follow_count, $format = "Y-m-d"): self { }
    public function date_alter($excluded_dates, $follow_count, $format = "Y-m-d"): self { }

    /** @see \dirname_r() */
    public self $dirname_r;
    public function dirname_r($path, callable $callback): self { }
    public function dirname_r(callable $callback): self { }

    /** @see \dirmtime() */
    public self $dirmtime;
    public function dirmtime($dirname, $recursive = true): self { }
    public function dirmtime($recursive = true): self { }

    /** @see \dir_diff() */
    public self $dir_diff;
    public function dir_diff($path1, $path2, $options = []): self { }
    public function dir_diff($path2, $options = []): self { }

    /** @see \delegate() */
    public self $delegate;
    public function delegate($invoker, callable $callable, $arity = null): self { }
    public function delegate(callable $callable, $arity = null): self { }

    /** @see \decimal() */
    public self $decimal;
    public function decimal($value, $precision = 0, $mode = 0): self { }
    public function decimal($precision = 0, $mode = 0): self { }

    /** @see \damerau_levenshtein() */
    public self $damerau_levenshtein;
    public function damerau_levenshtein($s1, $s2, $cost_ins = 1, $cost_rep = 1, $cost_del = 1, $cost_swp = 1): self { }
    public function damerau_levenshtein($s2, $cost_ins = 1, $cost_rep = 1, $cost_del = 1, $cost_swp = 1): self { }

    /** @see \decrypt() */
    public self $decrypt;
    public function decrypt($cipherdata, $password, $ciphers = "aes-256-cbc", $tag = ""): self { }
    public function decrypt($password, $ciphers = "aes-256-cbc", $tag = ""): self { }

}

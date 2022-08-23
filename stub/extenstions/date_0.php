<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait date_0
{
    /** @see \checkdate() */
    public function checkdate(int $month, int $day, int $year): self { }
    public function checkdate0(int $day, int $year): self { }
    public function checkdate1(int $month, int $year): self { }
    public function checkdate2(int $month, int $day): self { }

    /** @see \date() */
    public self $date;
    public function date(string $format, ?int $timestamp = null): self { }
    public function date0(?int $timestamp = null): self { }
    public function date1(string $format): self { }

    /** @see \date_add() */
    public function date_add(\DateTime $object, \DateInterval $interval): self { }
    public function date_add0(\DateInterval $interval): self { }
    public function date_add1(\DateTime $object): self { }

    /** @see \date_create() */
    public function date_create(string $datetime = "now", ?\DateTimeZone $timezone = null): self { }
    public function date_create0(?\DateTimeZone $timezone = null): self { }
    public function date_create1(string $datetime = "now"): self { }

    /** @see \date_create_from_format() */
    public function date_create_from_format(string $format, string $datetime, ?\DateTimeZone $timezone = null): self { }
    public function date_create_from_format0(string $datetime, ?\DateTimeZone $timezone = null): self { }
    public function date_create_from_format1(string $format, ?\DateTimeZone $timezone = null): self { }
    public function date_create_from_format2(string $format, string $datetime): self { }

    /** @see \date_create_immutable() */
    public function date_create_immutable(string $datetime = "now", ?\DateTimeZone $timezone = null): self { }
    public function date_create_immutable0(?\DateTimeZone $timezone = null): self { }
    public function date_create_immutable1(string $datetime = "now"): self { }

    /** @see \date_create_immutable_from_format() */
    public function date_create_immutable_from_format(string $format, string $datetime, ?\DateTimeZone $timezone = null): self { }
    public function date_create_immutable_from_format0(string $datetime, ?\DateTimeZone $timezone = null): self { }
    public function date_create_immutable_from_format1(string $format, ?\DateTimeZone $timezone = null): self { }
    public function date_create_immutable_from_format2(string $format, string $datetime): self { }

    /** @see \date_date_set() */
    public function date_date_set(\DateTime $object, int $year, int $month, int $day): self { }
    public function date_date_set0(int $year, int $month, int $day): self { }
    public function date_date_set1(\DateTime $object, int $month, int $day): self { }
    public function date_date_set2(\DateTime $object, int $year, int $day): self { }
    public function date_date_set3(\DateTime $object, int $year, int $month): self { }

    /** @see \date_default_timezone_set() */
    public self $date_default_timezone_set;
    public function date_default_timezone_set(string $timezoneId): self { }
    public function date_default_timezone_set0(): self { }

    /** @see \date_diff() */
    public function date_diff(\DateTimeInterface $baseObject, \DateTimeInterface $targetObject, bool $absolute = false): self { }
    public function date_diff0(\DateTimeInterface $targetObject, bool $absolute = false): self { }
    public function date_diff1(\DateTimeInterface $baseObject, bool $absolute = false): self { }
    public function date_diff2(\DateTimeInterface $baseObject, \DateTimeInterface $targetObject): self { }

    /** @see \date_format() */
    public function date_format(\DateTimeInterface $object, string $format): self { }
    public function date_format0(string $format): self { }
    public function date_format1(\DateTimeInterface $object): self { }

    /** @see \date_interval_create_from_date_string() */
    public self $date_interval_create_from_date_string;
    public function date_interval_create_from_date_string(string $datetime): self { }
    public function date_interval_create_from_date_string0(): self { }

    /** @see \date_interval_format() */
    public function date_interval_format(\DateInterval $object, string $format): self { }
    public function date_interval_format0(string $format): self { }
    public function date_interval_format1(\DateInterval $object): self { }

    /** @see \date_isodate_set() */
    public function date_isodate_set(\DateTime $object, int $year, int $week, int $dayOfWeek = 1): self { }
    public function date_isodate_set0(int $year, int $week, int $dayOfWeek = 1): self { }
    public function date_isodate_set1(\DateTime $object, int $week, int $dayOfWeek = 1): self { }
    public function date_isodate_set2(\DateTime $object, int $year, int $dayOfWeek = 1): self { }
    public function date_isodate_set3(\DateTime $object, int $year, int $week): self { }

    /** @see \date_modify() */
    public function date_modify(\DateTime $object, string $modifier): self { }
    public function date_modify0(string $modifier): self { }
    public function date_modify1(\DateTime $object): self { }

    /** @see \date_offset_get() */
    public self $date_offset_get;
    public function date_offset_get(\DateTimeInterface $object): self { }
    public function date_offset_get0(): self { }

    /** @see \date_parse() */
    public self $date_parse;
    public function date_parse(string $datetime): self { }
    public function date_parse0(): self { }

    /** @see \date_parse_from_format() */
    public function date_parse_from_format(string $format, string $datetime): self { }
    public function date_parse_from_format0(string $datetime): self { }
    public function date_parse_from_format1(string $format): self { }

    /** @see \date_sub() */
    public function date_sub(\DateTime $object, \DateInterval $interval): self { }
    public function date_sub0(\DateInterval $interval): self { }
    public function date_sub1(\DateTime $object): self { }

    /** @see \date_sun_info() */
    public function date_sun_info(int $timestamp, float $latitude, float $longitude): self { }
    public function date_sun_info0(float $latitude, float $longitude): self { }
    public function date_sun_info1(int $timestamp, float $longitude): self { }
    public function date_sun_info2(int $timestamp, float $latitude): self { }

    /** @see \date_sunrise() */
    public self $date_sunrise;
    public function date_sunrise(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }
    public function date_sunrise0(int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }
    public function date_sunrise1(int $timestamp, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }
    public function date_sunrise2(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }
    public function date_sunrise3(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }
    public function date_sunrise4(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $utcOffset = null): self { }
    public function date_sunrise5(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null): self { }

    /** @see \date_sunset() */
    public self $date_sunset;
    public function date_sunset(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }
    public function date_sunset0(int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }
    public function date_sunset1(int $timestamp, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }
    public function date_sunset2(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $longitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }
    public function date_sunset3(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $zenith = null, ?float $utcOffset = null): self { }
    public function date_sunset4(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $utcOffset = null): self { }
    public function date_sunset5(int $timestamp, int $returnFormat = SUNFUNCS_RET_STRING, ?float $latitude = null, ?float $longitude = null, ?float $zenith = null): self { }

    /** @see \date_time_set() */
    public function date_time_set(\DateTime $object, int $hour, int $minute, int $second = 0, int $microsecond = 0): self { }
    public function date_time_set0(int $hour, int $minute, int $second = 0, int $microsecond = 0): self { }
    public function date_time_set1(\DateTime $object, int $minute, int $second = 0, int $microsecond = 0): self { }
    public function date_time_set2(\DateTime $object, int $hour, int $second = 0, int $microsecond = 0): self { }
    public function date_time_set3(\DateTime $object, int $hour, int $minute, int $microsecond = 0): self { }
    public function date_time_set4(\DateTime $object, int $hour, int $minute, int $second = 0): self { }

    /** @see \date_timestamp_get() */
    public self $date_timestamp_get;
    public function date_timestamp_get(\DateTimeInterface $object): self { }
    public function date_timestamp_get0(): self { }

    /** @see \date_timestamp_set() */
    public function date_timestamp_set(\DateTime $object, int $timestamp): self { }
    public function date_timestamp_set0(int $timestamp): self { }
    public function date_timestamp_set1(\DateTime $object): self { }

    /** @see \date_timezone_get() */
    public self $date_timezone_get;
    public function date_timezone_get(\DateTimeInterface $object): self { }
    public function date_timezone_get0(): self { }

    /** @see \date_timezone_set() */
    public function date_timezone_set(\DateTime $object, \DateTimeZone $timezone): self { }
    public function date_timezone_set0(\DateTimeZone $timezone): self { }
    public function date_timezone_set1(\DateTime $object): self { }

    /** @see \getdate() */
    public function getdate(?int $timestamp = null): self { }
    public function getdate0(): self { }

    /** @see \gmdate() */
    public self $gmdate;
    public function gmdate(string $format, ?int $timestamp = null): self { }
    public function gmdate0(?int $timestamp = null): self { }
    public function gmdate1(string $format): self { }

    /** @see \gmmktime() */
    public self $gmmktime;
    public function gmmktime(int $hour, ?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null): self { }
    public function gmmktime0(?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null): self { }
    public function gmmktime1(int $hour, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null): self { }
    public function gmmktime2(int $hour, ?int $minute = null, ?int $month = null, ?int $day = null, ?int $year = null): self { }
    public function gmmktime3(int $hour, ?int $minute = null, ?int $second = null, ?int $day = null, ?int $year = null): self { }
    public function gmmktime4(int $hour, ?int $minute = null, ?int $second = null, ?int $month = null, ?int $year = null): self { }
    public function gmmktime5(int $hour, ?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null): self { }

    /** @see \gmstrftime() */
    public self $gmstrftime;
    public function gmstrftime(string $format, ?int $timestamp = null): self { }
    public function gmstrftime0(?int $timestamp = null): self { }
    public function gmstrftime1(string $format): self { }

    /** @see \idate() */
    public self $idate;
    public function idate(string $format, ?int $timestamp = null): self { }
    public function idate0(?int $timestamp = null): self { }
    public function idate1(string $format): self { }

    /** @see \localtime() */
    public function localtime(?int $timestamp = null, bool $associative = false): self { }
    public function localtime0(bool $associative = false): self { }
    public function localtime1(?int $timestamp = null): self { }

    /** @see \mktime() */
    public self $mktime;
    public function mktime(int $hour, ?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null): self { }
    public function mktime0(?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null): self { }
    public function mktime1(int $hour, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null): self { }
    public function mktime2(int $hour, ?int $minute = null, ?int $month = null, ?int $day = null, ?int $year = null): self { }
    public function mktime3(int $hour, ?int $minute = null, ?int $second = null, ?int $day = null, ?int $year = null): self { }
    public function mktime4(int $hour, ?int $minute = null, ?int $second = null, ?int $month = null, ?int $year = null): self { }
    public function mktime5(int $hour, ?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null): self { }

    /** @see \strftime() */
    public self $strftime;
    public function strftime(string $format, ?int $timestamp = null): self { }
    public function strftime0(?int $timestamp = null): self { }
    public function strftime1(string $format): self { }

    /** @see \strtotime() */
    public self $strtotime;
    public function strtotime(string $datetime, ?int $baseTimestamp = null): self { }
    public function strtotime0(?int $baseTimestamp = null): self { }
    public function strtotime1(string $datetime): self { }

}

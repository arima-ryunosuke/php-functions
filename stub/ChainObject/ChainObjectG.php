<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectG
{
    /** @see \gmdate() */
    public self $gmdate;
    public function gmdate(string $format, ?int $timestamp = null): self { }
    public function gmdate(?int $timestamp = null): self { }

    /** @see \gmmktime() */
    public self $gmmktime;
    public function gmmktime(int $hour, ?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null): self { }
    public function gmmktime(?int $minute = null, ?int $second = null, ?int $month = null, ?int $day = null, ?int $year = null): self { }

    /** @see \gmstrftime() */
    public self $gmstrftime;
    public function gmstrftime(string $format, ?int $timestamp = null): self { }
    public function gmstrftime(?int $timestamp = null): self { }

    /** @see \getdate() */
    public self $getdate;
    public function getdate(?int $timestamp = null): self { }
    public function getdate(): self { }

    /** @see \getenv() */
    public self $getenv;
    public function getenv(?string $name = null, bool $local_only = false): self { }
    public function getenv(bool $local_only = false): self { }

    /** @see \getopt() */
    public self $getopt;
    public function getopt(string $short_options, array $long_options = [], &$rest_index = null): self { }
    public function getopt(array $long_options = [], &$rest_index = null): self { }

    /** @see \get_cfg_var() */
    public self $get_cfg_var;
    public function get_cfg_var(string $option): self { }
    public function get_cfg_var(): self { }

    /** @see \getservbyname() */
    public self $getservbyname;
    public function getservbyname(string $service, string $protocol): self { }
    public function getservbyname(string $protocol): self { }

    /** @see \getservbyport() */
    public self $getservbyport;
    public function getservbyport(int $port, string $protocol): self { }
    public function getservbyport(string $protocol): self { }

    /** @see \getprotobyname() */
    public self $getprotobyname;
    public function getprotobyname(string $protocol): self { }
    public function getprotobyname(): self { }

    /** @see \getprotobynumber() */
    public self $getprotobynumber;
    public function getprotobynumber(int $protocol): self { }
    public function getprotobynumber(): self { }

    /** @see \get_browser() */
    public self $get_browser;
    public function get_browser(?string $user_agent = null, bool $return_array = false): self { }
    public function get_browser(bool $return_array = false): self { }

    /** @see \gethostbyaddr() */
    public self $gethostbyaddr;
    public function gethostbyaddr(string $ip): self { }
    public function gethostbyaddr(): self { }

    /** @see \gethostbyname() */
    public self $gethostbyname;
    public function gethostbyname(string $hostname): self { }
    public function gethostbyname(): self { }

    /** @see \gethostbynamel() */
    public self $gethostbynamel;
    public function gethostbynamel(string $hostname): self { }
    public function gethostbynamel(): self { }

    /** @see \getmxrr() */
    public self $getmxrr;
    public function getmxrr(string $hostname, &$hosts, &$weights = null): self { }
    public function getmxrr(&$hosts, &$weights = null): self { }

    /** @see \get_html_translation_table() */
    public self $get_html_translation_table;
    public function get_html_translation_table(int $table = HTML_SPECIALCHARS, int $flags = ENT_COMPAT, string $encoding = "UTF-8"): self { }
    public function get_html_translation_table(int $flags = ENT_COMPAT, string $encoding = "UTF-8"): self { }

    /** @see \glob() */
    public self $glob;
    public function glob(string $pattern, int $flags = 0): self { }
    public function glob(int $flags = 0): self { }

    /** @see \get_meta_tags() */
    public self $get_meta_tags;
    public function get_meta_tags(string $filename, bool $use_include_path = false): self { }
    public function get_meta_tags(bool $use_include_path = false): self { }

    /** @see \getimagesize() */
    public self $getimagesize;
    public function getimagesize(string $filename, &$image_info = null): self { }
    public function getimagesize(&$image_info = null): self { }

    /** @see \getimagesizefromstring() */
    public self $getimagesizefromstring;
    public function getimagesizefromstring(string $string, &$image_info = null): self { }
    public function getimagesizefromstring(&$image_info = null): self { }

    /** @see \gettimeofday() */
    public self $gettimeofday;
    public function gettimeofday(bool $as_float = false): self { }
    public function gettimeofday(): self { }

    /** @see \getrusage() */
    public self $getrusage;
    public function getrusage(int $mode = 0): self { }
    public function getrusage(): self { }

    /** @see \gettype() */
    public self $gettype;
    public function gettype(mixed $value): self { }
    public function gettype(): self { }

    /** @see \get_debug_type() */
    public self $get_debug_type;
    public function get_debug_type(mixed $value): self { }
    public function get_debug_type(): self { }

    /** @see \get_headers() */
    public self $get_headers;
    public function get_headers(string $url, bool $associative = false, $context = null): self { }
    public function get_headers(bool $associative = false, $context = null): self { }

    /** @see \get_class_constants() */
    public self $get_class_constants;
    public function get_class_constants($class, $filter = null): self { }
    public function get_class_constants($filter = null): self { }

    /** @see \get_object_properties() */
    public self $get_object_properties;
    public function get_object_properties($object, &$privates = []): self { }
    public function get_object_properties(&$privates = []): self { }

    /** @see \get_modified_files() */
    public self $get_modified_files;
    public function get_modified_files($target_pattern = "*.php", $ignore_pattern = "*.phtml"): self { }
    public function get_modified_files($ignore_pattern = "*.phtml"): self { }

    /** @see \getipaddress() */
    public self $getipaddress;
    public function getipaddress($target = null): self { }
    public function getipaddress(): self { }

    /** @see \glob2regex() */
    public self $glob2regex;
    public function glob2regex($pattern, $flags = 0): self { }
    public function glob2regex($flags = 0): self { }

    /** @see \getenvs() */
    public self $getenvs;
    public function getenvs($env_vars): self { }
    public function getenvs(): self { }

    /** @see \get_uploaded_files() */
    public self $get_uploaded_files;
    public function get_uploaded_files($files = null): self { }
    public function get_uploaded_files(): self { }

}

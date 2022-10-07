<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait user_3
{
    /** @see \dirname_r() */
    public function dirname_r($path, $callback): self { }
    public function dirname_r0($callback): self { }
    public function dirname_r1($path): self { }
    public function dirname_rP($path, $callback): self { }
    public function dirname_r0P($callback): self { }
    public function dirname_r1P($path): self { }
    public function dirname_rE($path, $callback): self { }
    public function dirname_r0E($callback): self { }
    public function dirname_r1E($path): self { }

    /** @see \encrypt() */
    public function encrypt($plaindata, $password, $cipher = "aes-256-gcm", &$tag = ""): self { }
    public function encrypt0($password, $cipher = "aes-256-gcm", &$tag = ""): self { }
    public function encrypt1($plaindata, $cipher = "aes-256-gcm", &$tag = ""): self { }
    public function encrypt2($plaindata, $password, &$tag = ""): self { }
    public function encrypt3($plaindata, $password, $cipher = "aes-256-gcm"): self { }

    /** @see \ends_with() */
    public function ends_with($string, $with, $case_insensitivity = false): self { }
    public function ends_with0($with, $case_insensitivity = false): self { }
    public function ends_with1($string, $case_insensitivity = false): self { }
    public function ends_with2($string, $with): self { }

    /** @see \error() */
    public self $error;
    public function error($message, $destination = null): self { }
    public function error0($destination = null): self { }
    public function error1($message): self { }

    /** @see \eval_func() */
    public self $eval_func;
    public function eval_func($expression, ...$variadic): self { }
    public function eval_func0(...$variadic): self { }
    public function eval_func1($expression): self { }

    /** @see \evaluate() */
    public self $evaluate;
    public function evaluate($phpcode, $contextvars = [], $cachesize = 256): self { }
    public function evaluate0($contextvars = [], $cachesize = 256): self { }
    public function evaluate1($phpcode, $cachesize = 256): self { }
    public function evaluate2($phpcode, $contextvars = []): self { }

    /** @see \file_extension() */
    public self $file_extension;
    public function file_extension($filename, $extension = ""): self { }
    public function file_extension0($extension = ""): self { }
    public function file_extension1($filename): self { }

    /** @see \file_get_arrays() */
    public self $file_get_arrays;
    public function file_get_arrays($filename, $options = []): self { }
    public function file_get_arrays0($options = []): self { }
    public function file_get_arrays1($filename): self { }

    /** @see \file_list() */
    public self $file_list;
    public function file_list($dirname, $filter_condition = []): self { }
    public function file_list0($filter_condition = []): self { }
    public function file_list1($dirname): self { }

    /** @see \file_matcher() */
    public self $file_matcher;
    public function file_matcher(array $filter_condition): self { }
    public function file_matcher0(): self { }

    /** @see \file_mimetype() */
    public self $file_mimetype;
    public function file_mimetype($filename): self { }
    public function file_mimetype0(): self { }

    /** @see \file_pos() */
    public function file_pos($filename, $needle, $start = 0, $end = null, $chunksize = null): self { }
    public function file_pos0($needle, $start = 0, $end = null, $chunksize = null): self { }
    public function file_pos1($filename, $start = 0, $end = null, $chunksize = null): self { }
    public function file_pos2($filename, $needle, $end = null, $chunksize = null): self { }
    public function file_pos3($filename, $needle, $start = 0, $chunksize = null): self { }
    public function file_pos4($filename, $needle, $start = 0, $end = null): self { }

    /** @see \file_rewrite_contents() */
    public function file_rewrite_contents($filename, $callback, $operation = 0): self { }
    public function file_rewrite_contents0($callback, $operation = 0): self { }
    public function file_rewrite_contents1($filename, $operation = 0): self { }
    public function file_rewrite_contents2($filename, $callback): self { }
    public function file_rewrite_contentsP($filename, $callback, $operation = 0): self { }
    public function file_rewrite_contents0P($callback, $operation = 0): self { }
    public function file_rewrite_contents1P($filename, $operation = 0): self { }
    public function file_rewrite_contents2P($filename, $callback): self { }
    public function file_rewrite_contentsE($filename, $callback, $operation = 0): self { }
    public function file_rewrite_contents0E($callback, $operation = 0): self { }
    public function file_rewrite_contents1E($filename, $operation = 0): self { }
    public function file_rewrite_contents2E($filename, $callback): self { }

    /** @see \file_set_contents() */
    public function file_set_contents($filename, $data, $umask = 2): self { }
    public function file_set_contents0($data, $umask = 2): self { }
    public function file_set_contents1($filename, $umask = 2): self { }
    public function file_set_contents2($filename, $data): self { }

    /** @see \file_set_tree() */
    public function file_set_tree($root, $contents_tree, $umask = 2): self { }
    public function file_set_tree0($contents_tree, $umask = 2): self { }
    public function file_set_tree1($root, $umask = 2): self { }
    public function file_set_tree2($root, $contents_tree): self { }

    /** @see \file_suffix() */
    public function file_suffix($filename, $suffix): self { }
    public function file_suffix0($suffix): self { }
    public function file_suffix1($filename): self { }

    /** @see \file_tree() */
    public self $file_tree;
    public function file_tree($dirname, $filter_condition = []): self { }
    public function file_tree0($filter_condition = []): self { }
    public function file_tree1($dirname): self { }

    /** @see \first_key() */
    public self $first_key;
    public function first_key($array, $default = null): self { }
    public function first_key0($default = null): self { }
    public function first_key1($array): self { }

    /** @see \first_keyvalue() */
    public self $first_keyvalue;
    public function first_keyvalue($array, $default = null): self { }
    public function first_keyvalue0($default = null): self { }
    public function first_keyvalue1($array): self { }

    /** @see \first_value() */
    public self $first_value;
    public function first_value($array, $default = null): self { }
    public function first_value0($default = null): self { }
    public function first_value1($array): self { }

    /** @see \flagval() */
    public self $flagval;
    public function flagval($var, $trim = false): self { }
    public function flagval0($trim = false): self { }
    public function flagval1($var): self { }

    /** @see \fnmatch_and() */
    public function fnmatch_and($patterns, $string, $flags = 0): self { }
    public function fnmatch_and0($string, $flags = 0): self { }
    public function fnmatch_and1($patterns, $flags = 0): self { }
    public function fnmatch_and2($patterns, $string): self { }

    /** @see \fnmatch_or() */
    public function fnmatch_or($patterns, $string, $flags = 0): self { }
    public function fnmatch_or0($string, $flags = 0): self { }
    public function fnmatch_or1($patterns, $flags = 0): self { }
    public function fnmatch_or2($patterns, $string): self { }

    /** @see \func_method() */
    public self $func_method;
    public function func_method($methodname, ...$defaultargs): self { }
    public function func_method0(...$defaultargs): self { }
    public function func_method1($methodname): self { }

    /** @see \func_new() */
    public self $func_new;
    public function func_new($classname, ...$defaultargs): self { }
    public function func_new0(...$defaultargs): self { }
    public function func_new1($classname): self { }

    /** @see \func_user_func_array() */
    public self $func_user_func_array;
    public function func_user_func_array($callback): self { }
    public function func_user_func_array0(): self { }
    public function func_user_func_arrayP($callback): self { }
    public function func_user_func_array0P(): self { }
    public function func_user_func_arrayE($callback): self { }
    public function func_user_func_array0E(): self { }

    /** @see \func_wiring() */
    public function func_wiring($callable, $dependency): self { }
    public function func_wiring0($dependency): self { }
    public function func_wiring1($callable): self { }
    public function func_wiringP($callable, $dependency): self { }
    public function func_wiring0P($dependency): self { }
    public function func_wiring1P($callable): self { }
    public function func_wiringE($callable, $dependency): self { }
    public function func_wiring0E($dependency): self { }
    public function func_wiring1E($callable): self { }

    /** @see \function_alias() */
    public function function_alias($original, $alias): self { }
    public function function_alias0($alias): self { }
    public function function_alias1($original): self { }

    /** @see \function_configure() */
    public self $function_configure;
    public function function_configure($option): self { }
    public function function_configure0(): self { }

    /** @see \function_parameter() */
    public self $function_parameter;
    public function function_parameter($eitherReffuncOrCallable): self { }
    public function function_parameter0(): self { }

    /** @see \function_shorten() */
    public self $function_shorten;
    public function function_shorten($function): self { }
    public function function_shorten0(): self { }

    /** @see \get_class_constants() */
    public self $get_class_constants;
    public function get_class_constants($class, $filter = null): self { }
    public function get_class_constants0($filter = null): self { }
    public function get_class_constants1($class): self { }

    /** @see \get_object_properties() */
    public self $get_object_properties;
    public function get_object_properties($object, &$privates = []): self { }
    public function get_object_properties0(&$privates = []): self { }
    public function get_object_properties1($object): self { }

    /** @see \get_uploaded_files() */
    public function get_uploaded_files($files = null): self { }
    public function get_uploaded_files0(): self { }

    /** @see \getenvs() */
    public self $getenvs;
    public function getenvs($env_vars): self { }
    public function getenvs0(): self { }

    /** @see \getipaddress() */
    public function getipaddress($target = null): self { }
    public function getipaddress0(): self { }

    /** @see \hashvar() */
    public function hashvar(...$vars): self { }
    public function hashvar0(): self { }

    /** @see \highlight_php() */
    public self $highlight_php;
    public function highlight_php($phpcode, $options = []): self { }
    public function highlight_php0($options = []): self { }
    public function highlight_php1($phpcode): self { }

    /** @see \html_attr() */
    public self $html_attr;
    public function html_attr($array, $options = []): self { }
    public function html_attr0($options = []): self { }
    public function html_attr1($array): self { }

    /** @see \html_strip() */
    public self $html_strip;
    public function html_strip($html, $options = []): self { }
    public function html_strip0($options = []): self { }
    public function html_strip1($html): self { }

    /** @see \htmltag() */
    public self $htmltag;
    public function htmltag($selector): self { }
    public function htmltag0(): self { }

    /** @see \http_delete() */
    public self $http_delete;
    public function http_delete($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_delete0($data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_delete1($url, $options = [], &$response_header = [], &$info = []): self { }
    public function http_delete2($url, $data = [], &$response_header = [], &$info = []): self { }
    public function http_delete3($url, $data = [], $options = [], &$info = []): self { }
    public function http_delete4($url, $data = [], $options = [], &$response_header = []): self { }

    /** @see \http_get() */
    public self $http_get;
    public function http_get($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_get0($data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_get1($url, $options = [], &$response_header = [], &$info = []): self { }
    public function http_get2($url, $data = [], &$response_header = [], &$info = []): self { }
    public function http_get3($url, $data = [], $options = [], &$info = []): self { }
    public function http_get4($url, $data = [], $options = [], &$response_header = []): self { }

    /** @see \http_head() */
    public self $http_head;
    public function http_head($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_head0($data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_head1($url, $options = [], &$response_header = [], &$info = []): self { }
    public function http_head2($url, $data = [], &$response_header = [], &$info = []): self { }
    public function http_head3($url, $data = [], $options = [], &$info = []): self { }
    public function http_head4($url, $data = [], $options = [], &$response_header = []): self { }

    /** @see \http_patch() */
    public self $http_patch;
    public function http_patch($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_patch0($data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_patch1($url, $options = [], &$response_header = [], &$info = []): self { }
    public function http_patch2($url, $data = [], &$response_header = [], &$info = []): self { }
    public function http_patch3($url, $data = [], $options = [], &$info = []): self { }
    public function http_patch4($url, $data = [], $options = [], &$response_header = []): self { }

    /** @see \http_post() */
    public self $http_post;
    public function http_post($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_post0($data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_post1($url, $options = [], &$response_header = [], &$info = []): self { }
    public function http_post2($url, $data = [], &$response_header = [], &$info = []): self { }
    public function http_post3($url, $data = [], $options = [], &$info = []): self { }
    public function http_post4($url, $data = [], $options = [], &$response_header = []): self { }

    /** @see \http_put() */
    public self $http_put;
    public function http_put($url, $data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_put0($data = [], $options = [], &$response_header = [], &$info = []): self { }
    public function http_put1($url, $options = [], &$response_header = [], &$info = []): self { }
    public function http_put2($url, $data = [], &$response_header = [], &$info = []): self { }
    public function http_put3($url, $data = [], $options = [], &$info = []): self { }
    public function http_put4($url, $data = [], $options = [], &$response_header = []): self { }

    /** @see \http_request() */
    public function http_request($options = [], &$response_header = [], &$info = []): self { }
    public function http_request0(&$response_header = [], &$info = []): self { }
    public function http_request1($options = [], &$info = []): self { }
    public function http_request2($options = [], &$response_header = []): self { }

    /** @see \http_requests() */
    public self $http_requests;
    public function http_requests($urls, $single_options = [], $multi_options = [], &$infos = []): self { }
    public function http_requests0($single_options = [], $multi_options = [], &$infos = []): self { }
    public function http_requests1($urls, $multi_options = [], &$infos = []): self { }
    public function http_requests2($urls, $single_options = [], &$infos = []): self { }
    public function http_requests3($urls, $single_options = [], $multi_options = []): self { }

    /** @see \in_array_and() */
    public function in_array_and($needle, $haystack, $strict = false): self { }
    public function in_array_and0($haystack, $strict = false): self { }
    public function in_array_and1($needle, $strict = false): self { }
    public function in_array_and2($needle, $haystack): self { }

    /** @see \in_array_or() */
    public function in_array_or($needle, $haystack, $strict = false): self { }
    public function in_array_or0($haystack, $strict = false): self { }
    public function in_array_or1($needle, $strict = false): self { }
    public function in_array_or2($needle, $haystack): self { }

    /** @see \incidr() */
    public function incidr($ipaddr, $cidr): self { }
    public function incidr0($cidr): self { }
    public function incidr1($ipaddr): self { }

    /** @see \include_string() */
    public self $include_string;
    public function include_string($template, $array = []): self { }
    public function include_string0($array = []): self { }
    public function include_string1($template): self { }

    /** @see \indent_php() */
    public self $indent_php;
    public function indent_php($phpcode, $options = []): self { }
    public function indent_php0($options = []): self { }
    public function indent_php1($phpcode): self { }

    /** @see \ini_export() */
    public self $ini_export;
    public function ini_export($iniarray, $options = []): self { }
    public function ini_export0($options = []): self { }
    public function ini_export1($iniarray): self { }

    /** @see \ini_import() */
    public self $ini_import;
    public function ini_import($inistring, $options = []): self { }
    public function ini_import0($options = []): self { }
    public function ini_import1($inistring): self { }

    /** @see \ini_sets() */
    public self $ini_sets;
    public function ini_sets($values): self { }
    public function ini_sets0(): self { }

    /** @see \ip2cidr() */
    public function ip2cidr($fromipaddr, $toipaddr): self { }
    public function ip2cidr0($toipaddr): self { }
    public function ip2cidr1($fromipaddr): self { }

    /** @see \is_ansi() */
    public self $is_ansi;
    public function is_ansi($stream): self { }
    public function is_ansi0(): self { }

    /** @see \is_arrayable() */
    public self $is_arrayable;
    public function is_arrayable($var): self { }
    public function is_arrayable0(): self { }

    /** @see \is_bindable_closure() */
    public self $is_bindable_closure;
    public function is_bindable_closure(\Closure $closure): self { }
    public function is_bindable_closure0(): self { }
    public function is_bindable_closureP(\Closure $closure): self { }
    public function is_bindable_closure0P(): self { }
    public function is_bindable_closureE(\Closure $closure): self { }
    public function is_bindable_closure0E(): self { }

    /** @see \is_empty() */
    public self $is_empty;
    public function is_empty($var, $empty_stdClass = false): self { }
    public function is_empty0($empty_stdClass = false): self { }
    public function is_empty1($var): self { }

    /** @see \is_hasharray() */
    public self $is_hasharray;
    public function is_hasharray(array $array): self { }
    public function is_hasharray0(): self { }

    /** @see \is_indexarray() */
    public self $is_indexarray;
    public function is_indexarray($array): self { }
    public function is_indexarray0(): self { }

}

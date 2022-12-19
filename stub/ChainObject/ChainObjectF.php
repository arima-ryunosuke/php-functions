<?php
// @formatter:off

/**
 * @noinspection PhpLanguageLevelInspection
 * @noinspection PhpUnusedParameterInspection
 * @noinspection PhpUndefinedClassInspection
 */
trait ChainObjectF
{
    /** @see \forward_static_call() */
    public self $forward_static_call;
    public function forward_static_call(callable $callback, mixed ...$args): self { }
    public function forward_static_call(mixed ...$args): self { }

    /** @see \forward_static_call_array() */
    public self $forward_static_call_array;
    public function forward_static_call_array(callable $callback, array $args): self { }
    public function forward_static_call_array(array $args): self { }

    /** @see \ftok() */
    public self $ftok;
    public function ftok(string $filename, string $project_id): self { }
    public function ftok(string $project_id): self { }

    /** @see \flock() */
    public self $flock;
    public function flock($stream, int $operation, &$would_block = null): self { }
    public function flock(int $operation, &$would_block = null): self { }

    /** @see \fclose() */
    public self $fclose;
    public function fclose($stream): self { }
    public function fclose(): self { }

    /** @see \feof() */
    public self $feof;
    public function feof($stream): self { }
    public function feof(): self { }

    /** @see \fgetc() */
    public self $fgetc;
    public function fgetc($stream): self { }
    public function fgetc(): self { }

    /** @see \fgets() */
    public self $fgets;
    public function fgets($stream, ?int $length = null): self { }
    public function fgets(?int $length = null): self { }

    /** @see \fread() */
    public self $fread;
    public function fread($stream, int $length): self { }
    public function fread(int $length): self { }

    /** @see \fopen() */
    public self $fopen;
    public function fopen(string $filename, string $mode, bool $use_include_path = false, $context = null): self { }
    public function fopen(string $mode, bool $use_include_path = false, $context = null): self { }

    /** @see \fscanf() */
    public self $fscanf;
    public function fscanf($stream, string $format, mixed &...$vars): self { }
    public function fscanf(string $format, mixed &...$vars): self { }

    /** @see \fpassthru() */
    public self $fpassthru;
    public function fpassthru($stream): self { }
    public function fpassthru(): self { }

    /** @see \ftruncate() */
    public self $ftruncate;
    public function ftruncate($stream, int $size): self { }
    public function ftruncate(int $size): self { }

    /** @see \fstat() */
    public self $fstat;
    public function fstat($stream): self { }
    public function fstat(): self { }

    /** @see \fseek() */
    public self $fseek;
    public function fseek($stream, int $offset, int $whence = SEEK_SET): self { }
    public function fseek(int $offset, int $whence = SEEK_SET): self { }

    /** @see \ftell() */
    public self $ftell;
    public function ftell($stream): self { }
    public function ftell(): self { }

    /** @see \fflush() */
    public self $fflush;
    public function fflush($stream): self { }
    public function fflush(): self { }

    /** @see \fwrite() */
    public self $fwrite;
    public function fwrite($stream, string $data, ?int $length = null): self { }
    public function fwrite(string $data, ?int $length = null): self { }

    /** @see \fputs() */
    public self $fputs;
    public function fputs($stream, string $data, ?int $length = null): self { }
    public function fputs(string $data, ?int $length = null): self { }

    /** @see \file() */
    public self $file;
    public function file(string $filename, int $flags = 0, $context = null): self { }
    public function file(int $flags = 0, $context = null): self { }

    /** @see \file_get_contents() */
    public self $file_get_contents;
    public function file_get_contents(string $filename, bool $use_include_path = false, $context = null, int $offset = 0, ?int $length = null): self { }
    public function file_get_contents(bool $use_include_path = false, $context = null, int $offset = 0, ?int $length = null): self { }

    /** @see \file_put_contents() */
    public self $file_put_contents;
    public function file_put_contents(string $filename, mixed $data, int $flags = 0, $context = null): self { }
    public function file_put_contents(mixed $data, int $flags = 0, $context = null): self { }

    /** @see \fputcsv() */
    public self $fputcsv;
    public function fputcsv($stream, array $fields, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function fputcsv(array $fields, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }

    /** @see \fgetcsv() */
    public self $fgetcsv;
    public function fgetcsv($stream, ?int $length = null, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }
    public function fgetcsv(?int $length = null, string $separator = ",", string $enclosure = "\"", string $escape = "\\"): self { }

    /** @see \fnmatch() */
    public self $fnmatch;
    public function fnmatch(string $pattern, string $filename, int $flags = 0): self { }
    public function fnmatch(string $filename, int $flags = 0): self { }

    /** @see \fileatime() */
    public self $fileatime;
    public function fileatime(string $filename): self { }
    public function fileatime(): self { }

    /** @see \filectime() */
    public self $filectime;
    public function filectime(string $filename): self { }
    public function filectime(): self { }

    /** @see \filegroup() */
    public self $filegroup;
    public function filegroup(string $filename): self { }
    public function filegroup(): self { }

    /** @see \fileinode() */
    public self $fileinode;
    public function fileinode(string $filename): self { }
    public function fileinode(): self { }

    /** @see \filemtime() */
    public self $filemtime;
    public function filemtime(string $filename): self { }
    public function filemtime(): self { }

    /** @see \fileowner() */
    public self $fileowner;
    public function fileowner(string $filename): self { }
    public function fileowner(): self { }

    /** @see \fileperms() */
    public self $fileperms;
    public function fileperms(string $filename): self { }
    public function fileperms(): self { }

    /** @see \filesize() */
    public self $filesize;
    public function filesize(string $filename): self { }
    public function filesize(): self { }

    /** @see \filetype() */
    public self $filetype;
    public function filetype(string $filename): self { }
    public function filetype(): self { }

    /** @see \file_exists() */
    public self $file_exists;
    public function file_exists(string $filename): self { }
    public function file_exists(): self { }

    /** @see \fprintf() */
    public self $fprintf;
    public function fprintf($stream, string $format, mixed ...$values): self { }
    public function fprintf(string $format, mixed ...$values): self { }

    /** @see \fsockopen() */
    public self $fsockopen;
    public function fsockopen(string $hostname, int $port = -1, &$error_code = null, &$error_message = null, ?float $timeout = null): self { }
    public function fsockopen(int $port = -1, &$error_code = null, &$error_message = null, ?float $timeout = null): self { }

    /** @see \floor() */
    public self $floor;
    public function floor(int|float $num): self { }
    public function floor(): self { }

    /** @see \fmod() */
    public self $fmod;
    public function fmod(float $num1, float $num2): self { }
    public function fmod(float $num2): self { }

    /** @see \fdiv() */
    public self $fdiv;
    public function fdiv(float $num1, float $num2): self { }
    public function fdiv(float $num2): self { }

    /** @see \floatval() */
    public self $floatval;
    public function floatval(mixed $value): self { }
    public function floatval(): self { }

    /** @see \first_key() */
    public self $first_key;
    public function first_key(iterable $array, $default = null): self { }
    public function first_key($default = null): self { }

    /** @see \first_value() */
    public self $first_value;
    public function first_value(iterable $array, $default = null): self { }
    public function first_value($default = null): self { }

    /** @see \first_keyvalue() */
    public self $first_keyvalue;
    public function first_keyvalue(iterable $array, $default = null): self { }
    public function first_keyvalue($default = null): self { }

    /** @see \file_matcher() */
    public self $file_matcher;
    public function file_matcher(array $filter_condition): self { }
    public function file_matcher(): self { }

    /** @see \file_list() */
    public self $file_list;
    public function file_list($dirname, $filter_condition = []): self { }
    public function file_list($filter_condition = []): self { }

    /** @see \file_tree() */
    public self $file_tree;
    public function file_tree($dirname, $filter_condition = []): self { }
    public function file_tree($filter_condition = []): self { }

    /** @see \file_suffix() */
    public self $file_suffix;
    public function file_suffix($filename, $suffix): self { }
    public function file_suffix($suffix): self { }

    /** @see \file_extension() */
    public self $file_extension;
    public function file_extension($filename, $extension = ""): self { }
    public function file_extension($extension = ""): self { }

    /** @see \file_get_arrays() */
    public self $file_get_arrays;
    public function file_get_arrays($filename, $options = []): self { }
    public function file_get_arrays($options = []): self { }

    /** @see \file_set_contents() */
    public self $file_set_contents;
    public function file_set_contents($filename, $data, $umask = 2): self { }
    public function file_set_contents($data, $umask = 2): self { }

    /** @see \file_rewrite_contents() */
    public self $file_rewrite_contents;
    public function file_rewrite_contents($filename, callable $callback, $operation = 0): self { }
    public function file_rewrite_contents(callable $callback, $operation = 0): self { }

    /** @see \file_set_tree() */
    public self $file_set_tree;
    public function file_set_tree($root, $contents_tree, $umask = 2): self { }
    public function file_set_tree($contents_tree, $umask = 2): self { }

    /** @see \file_pos() */
    public self $file_pos;
    public function file_pos($filename, $needle, $start = 0, $end = null, $chunksize = null): self { }
    public function file_pos($needle, $start = 0, $end = null, $chunksize = null): self { }

    /** @see \file_slice() */
    public self $file_slice;
    public function file_slice($filename, $start_line = 1, $length = null, $flags = 0, $context = null): self { }
    public function file_slice($start_line = 1, $length = null, $flags = 0, $context = null): self { }

    /** @see \file_mimetype() */
    public self $file_mimetype;
    public function file_mimetype($filename): self { }
    public function file_mimetype(): self { }

    /** @see \fnmatch_and() */
    public self $fnmatch_and;
    public function fnmatch_and($patterns, $string, $flags = 0): self { }
    public function fnmatch_and($string, $flags = 0): self { }

    /** @see \fnmatch_or() */
    public self $fnmatch_or;
    public function fnmatch_or($patterns, $string, $flags = 0): self { }
    public function fnmatch_or($string, $flags = 0): self { }

    /** @see \function_shorten() */
    public self $function_shorten;
    public function function_shorten($function): self { }
    public function function_shorten(): self { }

    /** @see \func_user_func_array() */
    public self $func_user_func_array;
    public function func_user_func_array(callable $callback): self { }
    public function func_user_func_array(): self { }

    /** @see \func_wiring() */
    public self $func_wiring;
    public function func_wiring(callable $callable, $dependency): self { }
    public function func_wiring($dependency): self { }

    /** @see \func_new() */
    public self $func_new;
    public function func_new($classname, ...$defaultargs): self { }
    public function func_new(...$defaultargs): self { }

    /** @see \func_method() */
    public self $func_method;
    public function func_method($methodname, ...$defaultargs): self { }
    public function func_method(...$defaultargs): self { }

    /** @see \function_alias() */
    public self $function_alias;
    public function function_alias($original, $alias): self { }
    public function function_alias($alias): self { }

    /** @see \function_parameter() */
    public self $function_parameter;
    public function function_parameter($eitherReffuncOrCallable): self { }
    public function function_parameter(): self { }

    /** @see \function_configure() */
    public self $function_configure;
    public function function_configure($option): self { }
    public function function_configure(): self { }

    /** @see \flagval() */
    public self $flagval;
    public function flagval($var, $trim = false): self { }
    public function flagval($trim = false): self { }

}

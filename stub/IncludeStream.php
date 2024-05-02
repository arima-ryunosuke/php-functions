<?php
// @formatter:off

/**
 * stub for include_stream
 *
 * file スキームで STREAM_OPEN_FOR_INCLUDE だけを特別扱いしたプロトコル
 *
 * include/require で呼ばれるメソッドはたかが知れているが、その前後等で通常操作がある可能性があるため、結局全部の実装が必要。
 *
 * @used-by \include_stream()
 * @used-by \ryunosuke\Functions\include_stream()
 * @used-by \ryunosuke\Functions\Package\include_stream()
 */
class IncludeStream
{
    public $context;

    public function dir_opendir($path, $options) { }
    public function dir_readdir() { }
    public function dir_rewinddir() { }
    public function dir_closedir() { }
    public function stream_open($path, $mode, $options, &$opened_path) { }
    public function stream_lock($operation) { }
    public function stream_tell() { }
    public function stream_seek(int $offset, int $whence = SEEK_SET) { }
    public function stream_eof() { }
    public function stream_read($count) { }
    public function stream_write(string $data) { }
    public function stream_truncate(int $new_size): bool { }
    public function stream_flush(): bool { }
    public function stream_close() { }
    public function stream_stat() { }
    public function stream_set_option($option, $arg1, $arg2) { }
    /**
     * @codeCoverageIgnore
     */
    public function stream_cast(int $cast_as) { }
    public function stream_metadata($path, $option, $value) { }
    public function url_stat($path, $flags) { }
    public function mkdir(string $path, int $mode, int $options) { }
    public function rmdir(string $path, int $options) { }
    public function rename(string $path_from, string $path_to) { }
    public function unlink(string $path) { }
    public function register($hook) { }
    public function restore() { }
}

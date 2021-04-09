<?php

return (static function () {
    $result = [];

    $result['scandir'] = (function () {
        $result = [];

        $handle = opendir(__DIR__);
        while (($file = readdir($handle)) !== false) {
            $result[] = $file;
        }
        rewinddir($handle);
        while (($file = readdir($handle)) !== false) {
            $result[] = $file;
        }
        rewinddir();
        while (($file = readdir()) !== false) {
            $result[] = $file;
        }
        closedir($handle);

        return $result;
    })();

    $result['meta'] = (function () {
        $result = [];

        $tmpname = tempnam(sys_get_temp_dir(), 'meta');
        touch($tmpname, 1234, 5678);
        chmod($tmpname, 0777);
        if (DIRECTORY_SEPARATOR === '\\') {
            chown($tmpname, 48);
            chgrp($tmpname, 27);
        }

        $result['touch'] = filemtime($tmpname);
        $result['chmod'] = fileperms($tmpname);
        //$result['chown'] = fileowner($tmpname);
        //$result['chgrp'] = filegroup($tmpname);

        return $result;
    })();

    $result['option'] = (function () {
        $result = [];

        $tmpfile = tmpfile();
        $result['blocking'] = stream_set_blocking($tmpfile, false);
        $result['timeout'] = stream_set_timeout($tmpfile, 1, 234);
        $result['buffer'] = stream_set_write_buffer($tmpfile, 255);

        return $result;
    })();

    $result['dir'] = (function () {
        $result = [];

        $dirname = sys_get_temp_dir() . '/misc';
        $result['mkdir'] = @mkdir($dirname);
        $result['rmdir'] = rmdir($dirname);

        return $result;
    })();

    $result['misc'] = (function () {
        $result = [];

        $result['flock'] = file_put_contents(tempnam(sys_get_temp_dir(), 'misc'), 'hoge', LOCK_EX);
        $result['file_exists'] = file_exists(__FILE__);
        $result['stat'] = stat(__FILE__);
        $result['lstat'] = lstat(__FILE__);

        return $result;
    })();

    return $result;
})();

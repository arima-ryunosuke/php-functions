<?php
namespace ryunosuke\Functions\Package;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/../array/arrayize.php';
require_once __DIR__ . '/../datetime/date_timestamp.php';
require_once __DIR__ . '/../filesystem/file_pos.php';
require_once __DIR__ . '/../strings/concat.php';
require_once __DIR__ . '/../var/si_unprefix.php';
// @codeCoverageIgnoreEnd

/**
 * 各種属性を指定してファイルのマッチングを行うクロージャを返す
 *
 * ※ 内部向け
 *
 * @package ryunosuke\Functions\Package\filesystem
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
        'fnmflag'    => 0,     // FNM_*
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
        // by getSubPath (glob or regex)
        'subpath'    => null,
        '!subpath'   => null,
        // by getPath or getSubpath (glob or regex)
        'dir'        => null,
        '!dir'       => null,
        // by getFilename (glob or regex)
        'name'       => null,
        '!name'      => null,
        // by getBasename (glob or regex)
        'basename'   => null,
        '!basename'  => null,
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
        'mtime'  => fn(...$args) => date_timestamp(...$args),
        '!mtime' => fn(...$args) => date_timestamp(...$args),
        'size'   => fn(...$args) => si_unprefix(...$args),
        '!size'  => fn(...$args) => si_unprefix(...$args),
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
        'path'      => null,
        '!path'     => null,
        'subpath'   => null,
        '!subpath'  => null,
        'dir'       => null,
        '!dir'      => null,
        'name'      => null,
        '!name'     => null,
        'basename'  => null,
        '!basename' => null,
    ] as $key => $convert) {
        if (isset($filter_condition[$key])) {
            $callback = fn() => false;
            foreach (arrayize($filter_condition[$key]) as $pattern) {
                preg_match('##', ''); // clear preg_last_error
                @preg_match($pattern, '');
                if (preg_last_error() === PREG_NO_ERROR) {
                    $callback = static function ($string) use ($callback, $pattern, $filter_condition) {
                        if ($callback($string)) {
                            return true;
                        }
                        $string = $filter_condition['unixpath'] && DIRECTORY_SEPARATOR === '\\' ? str_replace('\\', '/', $string) : $string;
                        return !!preg_match($pattern, $string);
                    };
                }
                else {
                    $callback = static function ($string) use ($callback, $pattern, $filter_condition) {
                        if ($callback($string)) {
                            return true;
                        }
                        if ($filter_condition['unixpath'] && DIRECTORY_SEPARATOR === '\\') {
                            $pattern = str_replace('\\', '/', $pattern);
                            $string = str_replace('\\', '/', $string);
                        }
                        $flags = $filter_condition['fnmflag'];
                        $flags |= $filter_condition['casefold'] ? FNM_CASEFOLD : 0;
                        $flags &= ~((strpos($pattern, '**') !== false) ? FNM_PATHNAME : 0);
                        return fnmatch($pattern, $string, $flags);
                    };
                }
            }
            $filter_condition[$key] = $callback;
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
        foreach (['subpath' => false, '!subpath' => true] as $key => $cond) {
            $subpath = $file instanceof \RecursiveDirectoryIterator ? $file->getSubPathname() : $file->getPathname();
            if (isset($filter_condition[$key]) && $cond === $filter_condition[$key]($subpath)) {
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
        foreach (['basename' => false, '!basename' => true] as $key => $cond) {
            if (isset($filter_condition[$key]) && $cond === $filter_condition[$key]($file->getBasename(concat('.', $file->getExtension())))) {
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
            if (isset($filter_condition[$key]) && (!file_exists($file->getPathname()) || $cond === (file_pos($file->getPathname(), $filter_condition[$key]) !== null))) {
                return false;
            }
        }

        return true;
    };
}

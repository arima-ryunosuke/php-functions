<?php

$rdi = new \RecursiveDirectoryIterator(__DIR__ . '/src/Package', \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::CURRENT_AS_PATHNAME);
$rii = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::LEAVES_ONLY);
$filelist = iterator_to_array($rii);

return [
    'cachekey'   => md5(implode(',', array_map('md5_file', $filelist))),
    'title'      => 'ryunosuke function',
    'frontpage'  => 'ryunosuke\\Functions\\Package\\',
    'menusize'   => 35,
    'source-map' => [
        '.*/' => 'https://github.com/arima-ryunosuke/php-functions/blob/master/src/Package/',
    ],
];

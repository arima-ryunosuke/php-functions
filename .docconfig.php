<?php
return [
    'directory'       => ['src/Package'],
    'contain'         => ['ryunosuke\\Functions\\Package'],
    'template'        => 'markdown',
    'template-config' => [
        'extension'  => 'html',
        'source-map' => [
            '.*/tests/'        => 'https://github.com/arima-ryunosuke/php-functions/blob/master/tests/',
            '.*?/src/Package/' => 'https://github.com/arima-ryunosuke/php-functions/blob/master/src/Package/',
        ],
    ],
];

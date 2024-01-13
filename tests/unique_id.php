<?php

use function ryunosuke\Functions\Package\unique_id;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Package/misc/unique_id.php';

const PROCESS_COUNT = 10;
const GENERATE_COUNT = 4000;
const DELIMITER = "\n";

$filename = sys_get_temp_dir() . '/unique_ids.txt';
file_put_contents($filename, "");
$fp = fopen($filename, 'a+'); // a はアトミック

$pids = [];
for ($p = 0; $p < PROCESS_COUNT; $p++) {
    $pid = pcntl_fork();
    if ($pid < 0) {
        echo "failed to fork";
        die(1);
    }
    elseif ($pid > 0) {
        $pids[] = $pid;
    }
    else {
        for ($i = 0; $i < GENERATE_COUNT; $i++) {
            fwrite($fp, unique_id() . DELIMITER); // 逐次書き込みで程よく他のプロセスに回す
        }
        exit;
    }
}

foreach ($pids as $pid) {
    pcntl_waitpid($pid, $status, WUNTRACED);
}

rewind($fp);
$ids = explode(DELIMITER, stream_get_contents($fp));
array_pop($ids);
fclose($fp);

printf("expected filesize: %s\n", number_format(PROCESS_COUNT * GENERATE_COUNT * (12 + strlen(DELIMITER))));
printf("actual   filesize: %s\n", number_format(filesize($filename)));
printf("expected count: %s\n", number_format(PROCESS_COUNT * GENERATE_COUNT));
printf("actual   count: %s\n", number_format(count($ids)));
printf("unique   count: %s\n", number_format(count(array_unique($ids))));

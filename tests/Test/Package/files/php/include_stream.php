<?php

// この中での file:// の操作も可能なことを担保
$fp = fopen(sys_get_temp_dir() . '/include_stream.txt', 'w+');
flock($fp, constant(strtoupper('LOCK_EX')));
fwrite($fp, 'ABCDEFG');
rewind($fp);
fwrite($fp, 'HIJKLMN');
fseek($fp, -3, constant(strtoupper('SEEK_CUR')));
fwrite($fp, 'XYZ');
rewind($fp);
$result = stream_get_contents($fp);
flock($fp, constant(strtoupper('LOCK_UN')));
fclose($fp);

rename(sys_get_temp_dir() . '/include_stream.txt', sys_get_temp_dir() . '/include_stream2.txt');
file_exists(sys_get_temp_dir() . '/include_stream2.txt');
unlink(sys_get_temp_dir() . '/include_stream2.txt');

return $result;

<?php

// この中での file:// の操作も可能なことを担保
$file1 = tempnam(sys_get_temp_dir(), 'is1');
$file2 = tempnam(sys_get_temp_dir(), 'is2');
$fp = fopen($file1, 'w+');
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

rename($file1, $file2);
file_exists($file2);
unlink($file2);

return $result;

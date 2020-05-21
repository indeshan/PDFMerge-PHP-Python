<?php
/*
  This File is used to Download the File from URL.
  Also write the count in tracking file.
*/
$url = $argv[1];
$location = $argv[2];

file_put_contents($location . ".pdf", fopen($url, 'r'));

$fp = fopen('completed.txt','a');
fwrite($fp,$location . "\n");
fclose($fp);

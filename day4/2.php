<?php

$key = "iwrupvqb";

$num = -1;

do {
  $num++;
  $hash = md5($key . $num);
} while (substr($hash, 0, 6) !== '000000');

echo $num . ' creates hash ' . $hash . "\r\n";

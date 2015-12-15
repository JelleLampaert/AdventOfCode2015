<?php

$key = "iwrupvqb";

$num = -1;

do {
  $num++;
  $hash = md5($key . $num);
} while (substr($hash, 0, 5) !== '00000');

echo $num . ' creates hash ' . $hash . "\r\n";

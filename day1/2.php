<?php

$fp = fopen('input.txt', 'r');

$line = trim(fgets($fp));
$size = strlen($line);
$floor = 0;

for ($i =0; $i < $size; $i++) {
  $char = substr($line, $i, 1);
  if ($char == '(') {
    $floor++;
  } else {
    $floor--;
  }

  if ($floor < 0) {
    echo ($i + 1);
    die();
  }
}

echo $floor . "\r\n\r\n";

fclose($fp);

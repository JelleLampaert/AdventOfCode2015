<?php

$fp = fopen('input.txt', 'r');

$total = 0;

while ($line = trim(fgets($fp))) {
  $dimensions = explode('x', $line);

  sort($dimensions);

  $total += (2 * $dimensions[0] + 2 * $dimensions[1] + ($dimensions[0] * $dimensions[1] * $dimensions[2]));
}

echo $total . "\r\n\r\n";

fclose($fp);

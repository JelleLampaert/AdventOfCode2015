<?php

$fp = fopen('input.txt', 'r');

$total = 0;

while ($line = trim(fgets($fp))) {
  $dimensions = explode('x', $line);

  $area1 = $dimensions[0] * $dimensions[1];
  $area2 = $dimensions[1] * $dimensions[2];
  $area3 = $dimensions[2] * $dimensions[0];

  $extra = min($area1, $area2, $area3);

  $total += (2 * $area1 + 2 * $area2 + 2 * $area3 + $extra);
}

echo $total . "\r\n\r\n";

fclose($fp);

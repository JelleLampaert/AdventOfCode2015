<?php

$fp = fopen('input.txt', 'r');

$nice = 0;

while ($line = fgets($fp)) {
  $size = strlen($line);
  $vowels = 0;
  $twice = false;
  $illegal_combo = false;
  $prev = '';

  for ($i = 0; $i < $size; $i++) {
    $char = substr($line, $i, 1);

    // Detect vowels
    if ($char == 'a' || $char == 'e' || $char == 'i' || $char == 'o' || $char == 'u') {
      $vowels++;
    }

    // Detect twice in a row
    if ($char == $prev) {
      $twice = true;
    }

    if (($char == 'b' && $prev == 'a') || ($char == 'd' && $prev == 'c') || ($char == 'q' && $prev == 'p') || ($char == 'y' && $prev == 'x')) {
      $illegal_combo = true;
    }

    $prev = $char;
  }

  if ($vowels > 2 && $twice && !$illegal_combo) {
    $nice++;
  }
}

fclose($fp);

echo $nice . "\r\n";

?>

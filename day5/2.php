<?php

$fp = fopen('input.txt', 'r');

$nice = 0;

while ($line = fgets($fp)) {
  $size = strlen($line);

  $pairs = array();
  $prev = '';
  $prev2 = '';

  $condition1 = false;
  $condition2 = false;

  for ($i = 0; $i < $size; $i++) {
    $char = substr($line, $i, 1);

    if ($i > 0) {
      $pair = $prev . $char;

      if (in_array($pair, $pairs)) {
        // Pair alreay exist. Can't be the last pair due to overlap
        if ($pairs[sizeof($pairs) - 1] != $pair) {
          $condition1 = true;
        } else {
          // Unless the second last pair is the same.
          if (sizeof($pairs) > 1 && $pairs[sizeof($pairs) - 2] == $pair) {
            $condition1 = true;
          }
        }
      }

      $pairs[] = $pair;

      // Check condition 2
      if ($char == $prev2) {
        $condition2 = true;
      }
    }

    $prev2 = $prev;
    $prev = $char;
  }

  if ($condition1 && $condition2) {
    $nice++;
  }
}

fclose($fp);

echo $nice . "\r\n";

?>

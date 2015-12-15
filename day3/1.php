<?php

$fp = fopen('input.txt', 'r');

$pos = array();
$pos[0][0] = 1;

$x = 0;
$y = 0;
$doubles = 0;
$count = 1;
$line = trim(fgets($fp));
$length = strlen($line);

for ($i = 0; $i < $length; $i++) {
  $char = substr($line, $i, 1);

  switch ($char) {
    case '>':
      $x++;
      break;
    case '<':
      $x--;
      break;
    case '^':
      $y--;
      break;
    case 'v':
      $y++;
      break;
  }

  if (!isset($pos[$x][$y])) {
    $count++;
    $pos[$x][$y] = 1;
  }

/*  if (isset($pos[$x][$y]) && $pos[$x][$y] == 1) {
    $doubles++;
    $pos[$x][$y]++;
  } else {
    $pos[$x][$y] = 1;
  }*/
}

echo $count . "\r\n\r\n";

fclose($fp);

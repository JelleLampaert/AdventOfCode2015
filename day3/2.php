<?php

$fp = fopen('input.txt', 'r');

$pos = array();
$pos[0][0] = 1;

$xsanta = 0;
$ysanta = 0;
$xrobot = 0;
$yrobot = 0;

$count = 1;
$line = trim(fgets($fp));
$length = strlen($line);

$turn = 0;

for ($i = 0; $i < $length; $i++) {
  $char = substr($line, $i, 1);

  if ($turn == 0) {
    switch ($char) {
      case '>':
        $xsanta++;
        break;
      case '<':
        $xsanta--;
        break;
      case '^':
        $ysanta--;
        break;
      case 'v':
        $ysanta++;
        break;
    }

    if (!isset($pos[$xsanta][$ysanta])) {
      $count++;
      $pos[$xsanta][$ysanta] = 1;
    }
    $turn = 1;
  } else {
    switch ($char) {
      case '>':
        $xrobot++;
        break;
      case '<':
        $xrobot--;
        break;
      case '^':
        $yrobot--;
        break;
      case 'v':
        $yrobot++;
        break;
    }

    if (!isset($pos[$xrobot][$yrobot])) {
      $count++;
      $pos[$xrobot][$yrobot] = 1;
    }
    $turn = 0;
  }

}

echo $count . "\r\n\r\n";

fclose($fp);

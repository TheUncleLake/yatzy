<?php
require_once('_config.php');

use Yatzy\{Dice, YatzyGame};

$d = new Dice();
$g = new YatzyGame();

for ($i=1; $i<=5; $i++) {
  $r = $d->roll();
  echo "ROLL {$i}: {$r}<br>";
  array_push($g->dice, $r);
}

$g->rollNo++;
array_push($g->keep, 1);

echo "<br>";
echo "ROLL NUMBER: " . $g->rollNo . "<br>";
echo "DICE LIST: ";
print_r($g->dice);
echo "<br>";
echo "KEEP LIST: ";
print_r($g->keep);
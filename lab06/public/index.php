<?php
require_once('_config.php');

use Yatzy\{Dice, YatzyGame, YatzyEngine};

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

echo "<br><br>";
YatzyEngine::init();
foreach (array_keys(YatzyEngine::$scoreBoxFunctions) as $key) {
    $g->dice = [$d->roll(), $d->roll(), $d->roll(), $d->roll(), $d->roll()];
    switch ($key) {
        case "fours": $g->dice = [4,1,1,1,1]; break;
        case "fives": $g->dice = [5,5,5,5,5]; break;
        case "yatzy":
        case "sixes": $g->dice = [6,6,6,6,6]; break;
    }
    $g->scoreBox[$key] = YatzyEngine::calculateScore($g, $key);
    echo "{$key} = {$g->scoreBox[$key]}" . str_repeat("&emsp;", 3);
    print_r($g->dice);
    echo("<br>");
}
$tot = YatzyEngine::calculateScoreBonus($g);
echo "<br>";
echo "TOTAL SCORE: {$tot["score"]}<br>";
echo "BONUS: {$tot["bonus"]}";
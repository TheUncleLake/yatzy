<?php
namespace Yatzy;

class Leaderboard {
    static function add(&$board, $score) {
        $i = count($board);
        while ($i > 0 && $score > $board[$i-1]) {
            $board[$i] = $board[$i-1];
            $i--;
        }
        $board[$i] = $score;
    }
}
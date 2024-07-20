<?php
namespace Yatzy;

class Leaderboard {
    private static $MAX_RECORDS = 10;

    static function add(&$board, $score) {
        $i = count($board);
        while ($i > 0 && $score > $board[$i-1]) {
            $board[$i] = $board[$i-1];
            $i--;
        }
        $board[$i] = $score;
        $i = count($board) - 1;
        while ($i >= static::$MAX_RECORDS) {
            unset($board[$i]);
            $i--;
        }
    }
}
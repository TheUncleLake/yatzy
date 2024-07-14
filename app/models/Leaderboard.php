<?php
namespace Yatzy;

class Leaderboard {
    private $board; // ordered array of scores

    function __construct() {
        $this->board = array();
    }

    function add($score) {
        $i = count($this->board);
        while ($i > 0 && $score > $this->board[$i-1]) {
            $this->board[$i] = $this->board[$i-1];
            $i--;
        }
        $this->board[$i] = $score;
    }

    function get($idx) {
        return $this->board[$idx];
    }
}
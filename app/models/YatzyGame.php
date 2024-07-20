<?php
namespace Yatzy;

use Yatzy\{Dice, YatzyEngine, Leaderboard};

class YatzyGame {
    public $rollNo; // 0, 1, 2, or 3
    public $dice; // array of 5 numbers
    public $keep; // array of indices of $dice
    public $scoreBox; // filled in score boxes

    function __construct() {
        $this->rollNo = 0;
        $this->dice = array();
        $this->keep = array();
        $this->scoreBox = array();
    }

    static function output_scores($game) {
        $result = array();
        foreach (array_keys(YatzyEngine::getScoreBoxFunctions()) as $key) {
            if (array_key_exists($key, $game->scoreBox))
                $result[$key] = [1 => $game->scoreBox[$key]];
            else if ($game->rollNo > 0)
                $result[$key] = [0 => YatzyEngine::calculateScore($game, $key)];
        }
        return $result;
    }

    function roll() {
        if ($this->rollNo >= 3 || $this->rollNo > 0 && count($this->keep) >= 5)
            return null;
        $list = [0,1,2,3,4];
        if ($this->rollNo == 0) $this->keep = array();
        else $list = array_diff($list, $this->keep);
        Dice::roll_dice($this->dice, $list);
        $this->rollNo++;
        return array(
            "rollNo" => $this->rollNo,
            "dice" => $this->dice,
            "keep" => $this->keep,
            "scoreBox" => self::output_scores($this)
        );
    }

    function select($idx) {
        if (!is_int($idx)) return null;
        if (isset($this->keep[$idx])) unset($this->keep[$idx]);
        else $this->keep[$idx] = $idx;
        return array(
            "rollNo" => $this->rollNo,
            "keep" => $this->keep
        );
    }

    function restart() {
        $this->__construct();
        return array(
            "rollNo" => $this->rollNo,
            "dice" => $this->dice,
            "keep" => $this->keep,
            "scoreBox" => self::output_scores($this)
        );
    }

    function score($key) {
        return array(
            "rollNo" => $this->rollNo,
            "scoreBox" => self::output_scores($this)
        );
    }
}
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
        $gameOver = true;
        foreach (array_keys(YatzyEngine::getScoreBoxFunctions()) as $key) {
            if (array_key_exists($key, $game->scoreBox))
                $result[$key] = [1 => $game->scoreBox[$key]];
            else {
                $gameOver = false;
                if ($game->rollNo > 0)
                    $result[$key] = [0 => YatzyEngine::calculateScore($game, $key)];
            }
        }
        if ($gameOver) {
            foreach (YatzyEngine::calculateScoreBonus($game) as $key => $val)
                $result[$key] = [2 => $val];
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
            "scoreBox" => static::output_scores($this)
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
            "scoreBox" => static::output_scores($this)
        );
    }

    function score($key) {
        if ($this->rollNo <= 0 || array_key_exists($key, $this->scoreBox))
            return null;
        $this->rollNo = 0;
        $this->scoreBox[$key] = YatzyEngine::calculateScore($this, $key);
        $scores = static::output_scores($this);
        if (array_key_exists("total", $scores)) {
            $this->rollNo = 3;
            Leaderboard::add($_SESSION["leaderboard"], $scores["total"][2]);
        }
        return array(
            "rollNo" => $this->rollNo,
            "scoreBox" => $scores
        );
    }
}
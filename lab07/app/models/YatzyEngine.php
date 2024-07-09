<?php
namespace Yatzy;

class YatzyEngine {
    static $scoreBoxFunctions;

    static function init() {
        static::$scoreBoxFunctions = [
            // Upper section
            "ones" => static::sumNDice(1),
            "twos" => static::sumNDice(2),
            "threes" => static::sumNDice(3),
            "fours" => static::sumNDice(4),
            "fives" => static::sumNDice(5),
            "sixes" => static::sumNDice(6),
            // Lower section
            "onePair" => static::checkNGroups(1, 2),
            "twoPairs" => static::checkNGroups(2, 2),
            "threeKind" => static::checkNGroups(1, 3),
            "fourKind" => static::checkNGroups(1, 4),
            "smallStraight" => static::checkStraight(0),
            "largeStraight" => static::checkStraight(1),
            "fullHouse" => function($dice) {return static::checkFullHouse($dice);},
            "chance" => function($dice) {return static::sumAllDice($dice);},
            "yatzy" => function($dice) {return static::checkYatzy($dice);}
        ];
    }

    static function sumAllDice($dice) {
        return array_sum($dice);
    }
    
    static function checkFullHouse($dice) {
        $counts = static::countDice($dice);
        $kind2 = in_array(2, $counts, true);
        $kind3 = in_array(3, $counts, true);
        return ($kind2 && $kind3) ? static::sumAllDice($dice) : 0;
    }
    
    static function checkYatzy($dice) {
        $counts = static::countDice($dice);
        return in_array(5, $counts, true) ? 50 : 0;
    }
    
    static function countDice($dice) {
        $counts = [0, 0, 0, 0, 0, 0];
        foreach ($dice as $die) $counts[$die-1]++;
        return $counts;
    }
    
    static function checkStraight($offset) {
        return function($dice) use ($offset) {
            $counts = static::countDice($dice);
            for ($i = 0; $i < 5; $i++) {
                if ($counts[$i + $offset] != 1) return 0;
            }
            return static::sumAllDice($dice);
        };
    }
    
    static function checkNGroups($n, $k) {
        return function($dice) use ($n, $k) {
            $sum = 0;
            $counts = static::countDice($dice);
            for ($i = 5, $m = $n; $i >= 0 && $m > 0; $i--) {
                if ($counts[$i] >= $k) {
                    $sum += $k * ($i+1);
                    $m--;
                }
            }
            return ($m == 0) ? $sum : 0;
        };
    }
    
    static function sumNDice($n) {
        return function($dice) use ($n) {
            $sum = 0;
            foreach ($dice as $die) {
                if ($die == $n) $sum += $n;
            }
            return $sum;
        };
    }
    
    static function calculateScore($game, $scoreBox) {
        return static::$scoreBoxFunctions[$scoreBox]($game->dice);
    }
    
    static function calculateScoreBonus($game) {
        $keys1to6 = ['ones', 'twos', 'threes', 'fours', 'fives', 'sixes'];
        $sum1to6 = 0;
        $sum = 0;
        foreach (array_keys(static::$scoreBoxFunctions) as $key) {
            if (in_array($key, $keys1to6, true)) $sum1to6 += $game->scoreBox[$key];
            $sum += $game->scoreBox[$key];
        }
        return [
            "score" => $sum,
            "bonus" => ($sum1to6 >= 63) ? 50 : 0
        ];
    }
}
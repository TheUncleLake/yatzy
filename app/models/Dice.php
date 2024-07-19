<?php
namespace Yatzy;

class Dice {
    public $min;
    public $max;

    function __construct($min=1, $max=6) {
        $this->min = $min;
        $this->max = $max;
    }

    function roll() {
        return rand($this->min, $this->max);
    }

    static function roll_dice(&$dice, $idx) {
        $d = new Dice();
        foreach ($idx as $i) $dice[$i] = $d->roll();
    }
}
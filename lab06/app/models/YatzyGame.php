<?php
namespace Yatzy;

class YatzyGame {
    public $rollNo; // 0, 1, 2, or 3
    public $dice; // array of 5 numbers
    public $keep; // array of indices of $dice

    function __construct() {
        $this->rollNo = 0;
        $this->dice = array();
        $this->keep = array();
    }
}
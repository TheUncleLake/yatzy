<?php
namespace Yatzy\Test;

use Yatzy\YatzyEngine;
use PHPUnit\Framework\TestCase;

class YatzyEngineTest extends TestCase {
    /**
     * @beforeClass
     */
    public static function setUpEngine() {
        YatzyEngine::init();
    }

    public function testUpperScoring() {
        $this->assertEquals(3, YatzyEngine::$scoreBoxFunctions["ones"]([1,1,5,3,1]));
        $this->assertEquals(2, YatzyEngine::$scoreBoxFunctions["twos"]([2,1,6,3,1]));
        $this->assertEquals(0, YatzyEngine::$scoreBoxFunctions["threes"]([1,1,5,6,1]));
        $this->assertEquals(20, YatzyEngine::$scoreBoxFunctions["fours"]([4,4,4,4,4]));
        $this->assertEquals(20, YatzyEngine::$scoreBoxFunctions["fives"]([5,5,5,5,1]));
        $this->assertEquals(30, YatzyEngine::$scoreBoxFunctions["sixes"]([6,6,6,6,6]));
    }

    public function testLowerScoring() {
        $this->assertEquals(2, YatzyEngine::$scoreBoxFunctions["onePair"]([1,1,5,3,1]));
        $this->assertEquals(6, YatzyEngine::$scoreBoxFunctions["twoPairs"]([2,1,2,3,1]));
        $this->assertEquals(3, YatzyEngine::$scoreBoxFunctions["threeKind"]([1,1,5,6,1]));
        $this->assertEquals(16, YatzyEngine::$scoreBoxFunctions["fourKind"]([4,4,4,4,2]));
        $this->assertEquals(15, YatzyEngine::$scoreBoxFunctions["smallStraight"]([1,2,3,4,5]));
        $this->assertEquals(20, YatzyEngine::$scoreBoxFunctions["largeStraight"]([2,3,4,5,6]));
        $this->assertEquals(13, YatzyEngine::$scoreBoxFunctions["fullHouse"]([3,3,3,2,2]));
        $this->assertEquals(5, YatzyEngine::$scoreBoxFunctions["chance"]([1,1,1,1,1]));
        $this->assertEquals(50, YatzyEngine::$scoreBoxFunctions["yatzy"]([2,2,2,2,2]));
    }
}
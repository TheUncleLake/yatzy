<?php
namespace Yatzy\Test;

use Yatzy\YatzyEngine;
use PHPUnit\Framework\TestCase;

class YatzyEngineTest extends TestCase {
    private static $scoreBoxFunctions;

    /**
     * @beforeClass
     */
    public static function setUpEngine() {
        static::$scoreBoxFunctions = YatzyEngine::getScoreBoxFunctions();
    }

    public function testUpperScoring() {
        $this->assertEquals(3, static::$scoreBoxFunctions["ones"]([1,1,5,3,1]));
        $this->assertEquals(2, static::$scoreBoxFunctions["twos"]([2,1,6,3,1]));
        $this->assertEquals(0, static::$scoreBoxFunctions["threes"]([1,1,5,6,1]));
        $this->assertEquals(20, static::$scoreBoxFunctions["fours"]([4,4,4,4,4]));
        $this->assertEquals(20, static::$scoreBoxFunctions["fives"]([5,5,5,5,1]));
        $this->assertEquals(30, static::$scoreBoxFunctions["sixes"]([6,6,6,6,6]));
    }

    public function testLowerScoring() {
        $this->assertEquals(2, static::$scoreBoxFunctions["onePair"]([1,1,5,3,1]));
        $this->assertEquals(6, static::$scoreBoxFunctions["twoPairs"]([2,1,2,3,1]));
        $this->assertEquals(3, static::$scoreBoxFunctions["threeKind"]([1,1,5,6,1]));
        $this->assertEquals(16, static::$scoreBoxFunctions["fourKind"]([4,4,4,4,2]));
        $this->assertEquals(15, static::$scoreBoxFunctions["smallStraight"]([1,2,3,4,5]));
        $this->assertEquals(20, static::$scoreBoxFunctions["largeStraight"]([2,3,4,5,6]));
        $this->assertEquals(13, static::$scoreBoxFunctions["fullHouse"]([3,3,3,2,2]));
        $this->assertEquals(5, static::$scoreBoxFunctions["chance"]([1,1,1,1,1]));
        $this->assertEquals(50, static::$scoreBoxFunctions["yatzy"]([2,2,2,2,2]));
    }
}
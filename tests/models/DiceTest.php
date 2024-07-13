<?php
namespace Yatzy\Test;

use Yatzy\Dice;
use PHPUnit\Framework\TestCase;

class DiceTest extends TestCase {
    public function testConstructor() {
        $d = new Dice();
        $this->assertEquals(1, $d->min);
        $this->assertEquals(6, $d->max);

        $d = new Dice(10, 20);
        $this->assertEquals(10, $d->min);
        $this->assertEquals(20, $d->max);
    }

    public function testRoll() {
        $d = new Dice();
        for ($i = 0; $i < $d->max; $i++) {
            $this->assertEqualsWithDelta(3.5, $d->roll(), 2.6);
        }
        
        $d = new Dice(10, 20);
        for ($i = 0; $i < $d->max; $i++){
            $this->assertEqualsWithDelta(15, $d->roll(), 5.1);
        }
    }
}
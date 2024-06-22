<?php
namespace Yatzy\Test;

use Yatzy\YatzyGame;
use PHPUnit\Framework\TestCase;

class YatzyGameTest extends TestCase {
    public function testConstructor() {
        $g = new YatzyGame();
        $this->assertEquals(0, $g->rollNo);
        $this->assertEquals([], $g->dice);
        $this->assertEquals([], $g->keep);
        $this->assertEquals([], $g->scoreBox);
    }
}
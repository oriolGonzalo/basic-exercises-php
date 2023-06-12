<?php

declare(strict_types=1);

class ResistorColorTest extends PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass(): void
    {
        require_once 'ResistorColor.php';
    }

    public function testColors(): void
    {
        $this->assertEquals([
            "black",
            "brown",
            "red",
            "orange",
            "yellow",
            "green",
            "blue",
            "violet",
            "grey",
            "white"
        ], COLORS);
    }

    public function testBlackColorCode(): void
    {
        $this->assertEquals(0, colorCode("black"));
    }

    public function testOrangeColorCode(): void
    {
        $this->assertEquals(3, colorCode("orange"));
    }

    public function testWhiteColorCode(): void
    {
        $this->assertEquals(9, colorCode("white"));
    }
}

<?php

namespace App\Tests\Helper;

use App\Entity\Deck;
use App\Helper\Color;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * All tests for Color
 *
 * @see Color
 */
class ColorTest extends TestCase
{
    /**
     * Test to convert string
     *
     * @return void
     * @throws Exception
     */
    public function testCanConvertString(): void
    {
        $this->assertEquals([0, 0, 0], Color::fromHex(Color::BLACK));
        $this->assertEquals([255, 255, 255], Color::fromHex(Color::WHITE));
        $this->assertEquals([0, 255, 0], Color::fromHex(Color::GREEN));
        $this->assertEquals([255, 136, 0], Color::fromHex(Color::ORANGE));
    }
    /**
     * Test to convert string
     *
     * @return void
     * @throws Exception
     */
    public function testCantConvertString(): void
    {
        $color = 'RED';
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(sprintf(Color::COLOR_ERROR, $color));
        Color::fromHex($color);
    }
}
<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Card;
use Exception;
use PHPUnit\Framework\TestCase;
use Stringable;

/**
 * All tests for Card
 *
 * @see Card
 */
final class CardTest extends TestCase
{
    /**
     * Test the creation
     *
     * @return void
     * @throws Exception
     */
    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(
            Card::class,
            new Card(1)
        );
    }

    /**
     * Test the invalid creation
     *
     * @return void
     * @throws Exception
     */
    public function testCannotBeCreated(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(sprintf(Card::MIN_ERROR, Card::MIN_VALUE));
        new Card(Card::MIN_VALUE-1);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(sprintf(Card::MAX_ERROR, Card::MAX_VALUE));
        new Card(Card::MAX_VALUE+1);
    }

    /**
     * Test to get value of a Card
     *
     * @throws Exception
     */
    public function testCanGetValue(): void
    {
        $card = new Card(1);

        $this->assertEquals(1, $card->getValue());
    }

    /**
     * Test if a Card can be stringify
     *
     * @return void
     * @throws Exception
     */
    public function testCanBeStringify(): void
    {
        $card = new Card(1);

        $this->assertInstanceOf(Stringable::class, $card);
        $this->assertEquals('01', $card);
    }
}
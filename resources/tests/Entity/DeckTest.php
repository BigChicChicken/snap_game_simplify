<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Card;
use App\Entity\Deck;
use Countable;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * All tests for Deck
 *
 * @see Deck
 */
final class DeckTest extends TestCase
{
    /**
     * Get some Cards
     *
     * @return Card[]
     * @throws Exception
     */
    static function getCards(): array
    {
        return [
            new Card(1),
            new Card(2),
            new Card(3),
            new Card(4)
        ];
    }

    /**
     * Test the creation
     *
     * @return void
     */
    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(
            Deck::class,
            new Deck()
        );
    }

    /**
     * Test to see Cards
     *
     * @return void
     * @throws Exception
     */
    public function testCanSeeCards(): void
    {
        $cards = self::getCards();
        $deck = new Deck($cards);

        $this->assertEquals($cards, $deck->seeCards());
    }

    /**
     * Test to add Cards
     *
     * @return void
     * @throws Exception
     */
    public function testCanAddCards(): void
    {
        $cards = self::getCards();
        $deck = new Deck();

        $deck
            ->addCard($cards[1])
            ->addCard($cards[2])
            ->addCard($cards[0], Deck::UNSHIFT)
            ->addCard($cards[3])
        ;

        $this->assertEquals($cards, $deck->seeCards());
    }

    /**
     * Test to draw a Card
     *
     * @return void
     * @throws Exception
     */
    public function testCanDrawCard(): void
    {
        $cards = self::getCards();
        $deck = new Deck($cards);

        $this->assertEquals($cards[0], $deck->drawCard());
        $this->assertEquals(array_slice($cards, 1, count($cards) - 1), $deck->seeCards());
    }

    /**
     * Test to draw on empty Deck
     *
     * @return void
     * @throws Exception
     */
    public function testCantDrawCard(): void
    {
        $deck = new Deck();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(Deck::DRAW_ERROR);
        $deck->drawCard();
    }

    /**
     * Test to shuffle Cards
     *
     * @return void
     * @throws Exception
     */
    public function testCanShuffleCards(): void
    {
        $cards = self::getCards();
        $deck = new Deck($cards);
        $deck->shuffle();

        $this->assertIsArray($deck->seeCards());
    }

    /**
     * Test to remove all Cards
     *
     * @return void
     * @throws Exception
     */
    public function testCanBeClear(): void
    {
        $cards = self::getCards();
        $deck = new Deck($cards);
        $deck->clearCards();

        $this->assertEmpty($deck->seeCards());
    }

    /**
     * Test to split the Deck
     *
     * @return void
     * @throws Exception
     */
    public function testCanBeSplit(): void
    {
        $cards = self::getCards();
        $deck = new Deck($cards);
        $decks = $deck->split();

        $this->assertEmpty($deck->seeCards());
        $this->assertSameSize($decks[0]->seeCards(), $decks[1]->seeCards());
    }

    /**
     * Test to split an invalid Deck
     *
     * @return void
     * @throws Exception
     */
    public function testCantBeSplit(): void
    {
        $cards = self::getCards();
        $deck = new Deck();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(Deck::SPLIT_ERROR);
        $deck->split();

        $deck
            ->addCard($cards[0])
            ->addCard($cards[1])
            ->addCard($cards[2])
        ;
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(Deck::SPLIT_ERROR);
        $deck->split();
    }

    /**
     * Test if a Deck can be counted
     *
     * @return void
     * @throws Exception
     */
    public function testCanBeCounted(): void
    {
        $cards = self::getCards();
        $deck = new Deck($cards);

        $this->assertInstanceOf(Countable::class, $deck);
        $this->assertSameSize($cards, $deck);
    }
}
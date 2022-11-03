<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Deck;
use App\Entity\Player;
use Exception;
use PHPUnit\Framework\TestCase;
use Stringable;

/**
 * All tests for Player
 *
 * @see Player
 */
final class PlayerTest extends TestCase
{
    const NAME_TEST = "John Doe";

    /**
     * Test the creation
     *
     * @return void
     */
    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(
            Player::class,
            new Player(self::NAME_TEST)
        );
    }

    /**
     * Test to give and get the Player's Deck
     *
     * @throws Exception
     */
    public function testCanHaveDeck(): void
    {
        $player = new Player(self::NAME_TEST);
        $deck = new Deck(DeckTest::getCards());

        $this->assertEmpty($player->getDeck());
        $player->setDeck($deck);
        $this->assertEquals($deck, $player->getDeck());
    }

    /**
     * Test to modify the score of a Player
     *
     * @return void
     */
    public function testCanModifyScore(): void
    {
        $player = new Player(self::NAME_TEST);

        $this->assertEquals(0, $player->getScore());
        $player->addToScore(1);
        $this->assertEquals(1, $player->getScore());
    }

    /**
     * Test if a Player can be stringify
     *
     * @return void
     */
    public function testCanBeStringify(): void
    {
        $player = new Player(self::NAME_TEST);

        $this->assertInstanceOf(Stringable::class, $player);
        $this->assertEquals(self::NAME_TEST, $player);
    }
}
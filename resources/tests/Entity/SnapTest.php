<?php

namespace App\Tests\Entity;

use App\Entity\Deck;
use App\Entity\Player;
use App\Entity\Snap;
use App\Output\ConsoleOutput;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * All tests for Snap
 *
 * @see Snap
 */
final class SnapTest extends TestCase
{
    /**
     * Test the creation
     *
     * @return void
     */
    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(
            Snap::class,
            new Snap(new ConsoleOutput())
        );
    }

    /**
     * Test when Player 1 win
     *
     * @return void
     * @throws Exception
     */
    public function testWhenPlayer1Win(): void
    {
        $name1 = "Player1";
        $name2 = "Player2";
        $cards = DeckTest::getCards();
        $snap = new Snap(new ConsoleOutput());

        $this->expectOutputString(sprintf(
            "\n".
            "\033[38;2;0;0;0m".
            "\033[48;2;255;255;255m".
            "\033[1m".
            "%s".
            "\033[0m".
            "\n".
            "\n".

            "\033[38;2;255;255;255m".
            "\033[48;2;0;255;0m".
            "%s".
            "\033[0m".
            "%s".
            "\n".

            "\033[38;2;255;255;255m".
            "\033[48;2;0;255;0m".
            "%s".
            "\033[0m".
            "%s".
            "\n".

            "\n".
            "\033[38;2;255;255;255m".
            "\033[48;2;0;255;0m".
            "\033[1m".
            "%s".
            "\033[0m".
            "\n".
            "\n"
            ,
            Snap::START_MESSAGE,
            $name1." ".$cards[2]." ",
            " ".$cards[0]." ".$name2,
            $name1." ".$cards[3]." ",
            " ".$cards[1]." ".$name2,
            sprintf(Snap::WIN_MESSAGE, $name1)
        ));
        $snap->start(function(&$player1, &$player2) use ($name1, $name2, $cards) {
            $deck = new Deck($cards);
            $decks = $deck->split();

            $player1 = new Player($name1);
            $player1->setDeck($decks[1]);

            $player2 = new Player($name2);
            $player2->setDeck($decks[0]);
        });
    }

    /**
     * Test when Player 2 win
     *
     * @return void
     * @throws Exception
     */
    public function testWhenPlayer2Win(): void
    {
        $name1 = "Player1";
        $name2 = "Player2";
        $cards = DeckTest::getCards();
        $snap = new Snap(new ConsoleOutput());

        $this->expectOutputString(sprintf(
            "\n".
            "\033[38;2;0;0;0m".
            "\033[48;2;255;255;255m".
            "\033[1m".
            "%s".
            "\033[0m".
            "\n".
            "\n".

            "%s".
            "\033[38;2;255;255;255m".
            "\033[48;2;0;255;0m".
            "%s".
            "\033[0m".
            "\n".

            "%s".
            "\033[38;2;255;255;255m".
            "\033[48;2;0;255;0m".
            "%s".
            "\033[0m".
            "\n".

            "\n".
            "\033[38;2;255;255;255m".
            "\033[48;2;0;255;0m".
            "\033[1m".
            "%s".
            "\033[0m".
            "\n".
            "\n"
            ,
            Snap::START_MESSAGE,
            $name1." ".$cards[0]." ",
            " ".$cards[2]." ".$name2,
            $name1." ".$cards[1]." ",
            " ".$cards[3]." ".$name2,
            sprintf(Snap::WIN_MESSAGE, $name2)
        ));
        $snap->start(function(&$player1, &$player2) use ($name1, $name2, $cards) {
            $deck = new Deck($cards);
            $decks = $deck->split();

            $player1 = new Player($name1);
            $player1->setDeck($decks[0]);

            $player2 = new Player($name2);
            $player2->setDeck($decks[1]);
        });
    }

    /**
     * Test when there is equality
     *
     * @return void
     * @throws Exception
     */
    public function testWhenEquality(): void
    {
        $name1 = "Player1";
        $name2 = "Player2";
        $snap = new Snap(new ConsoleOutput());

        $this->expectOutputString(sprintf(
            "\n".
            "\033[38;2;0;0;0m".
            "\033[48;2;255;255;255m".
            "\033[1m".
            "%s".
            "\033[0m".
            "\n".
            "\n".

            "\n".
            "\033[38;2;255;255;255m".
            "\033[48;2;255;136;0m".
            "\033[1m".
            "%s".
            "\033[0m".
            "\n".
            "\n"
            ,
            Snap::START_MESSAGE,
            Snap::EQUALITY_MESSAGE
        ));
        $snap->start(function(&$player1, &$player2) use ($name1, $name2) {
            $player1 = new Player($name1);
            $player2 = new Player($name2);
        });
    }
}
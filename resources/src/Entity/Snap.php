<?php

namespace App\Entity;

use App\Helper\Color;
use App\Output\OutputInterface;
use Exception;

class Snap
{
    const START_MESSAGE = "Game start:";
    const FIRST_PROMPT_MESSAGE = "Name of the first Player";
    const SECOND_PROMPT_MESSAGE = "Name of the second Player";
    const WIN_MESSAGE = "%s WINS ! FATALITY !";
    const EQUALITY_MESSAGE = "EQUALITY ! (╯°□°)╯ ┻━┻";
    const PLAYER_ERROR = "You need to initialize both players.";

    /**
     * @var OutputInterface
     */
    private OutputInterface $output;

    /**
     * @var Player|null
     */
    private ?Player $player1;

    /**
     * @var Player|null
     */
    private ?Player $player2;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
        $this->player1 = null;
        $this->player2 = null;
    }

    /**
     * Initialise the game
     *
     * @return void
     * @throws Exception
     */
    private function init(): void
    {
        $range = range(Card::MIN_VALUE, Card::MAX_VALUE);
        $deck = new Deck(
            array_map(
                fn(int $value) => new Card($value),
                $range
            )
        );

        $deck->shuffle();
        $decks = $deck->split();

        $name = $this->output->prompt(self::FIRST_PROMPT_MESSAGE, "David");
        $this->player1 = new Player($name);
        $this->player1->setDeck($decks[0]);

        $name = $this->output->prompt(self::SECOND_PROMPT_MESSAGE, "Goliath");
        $this->player2 = new Player($name);
        $this->player2->setDeck($decks[1]);
    }

    /**
     * Start the game
     *
     * @param callable|null $overwriteInit
     *
     * @return $this
     * @throws Exception
     */
    public function start(?callable $overwriteInit = null): Snap
    {
        if ($overwriteInit) {
            $overwriteInit($this->player1, $this->player2);
        } else {
            $this->init();
        }

        if (!$this->player1 || !$this->player2) {
            throw new Exception(self::PLAYER_ERROR);
        }

        $deckPlayer1 = $this->player1->getDeck();
        $deckPlayer2 = $this->player2->getDeck();
        $round = min(count($deckPlayer1), count($deckPlayer2));

        $this->output
            ->ln()
            ->foreground(Color::BLACK)
            ->background(Color::WHITE)
            ->bold()
            ->write(self::START_MESSAGE)
            ->reset()
            ->ln()
            ->ln()
        ;

        for ($i = 1; $i <= $round; $i++) {
            $card1 = $deckPlayer1->drawCard();
            $card2 = $deckPlayer2->drawCard();

            $result = $card1->getValue() - $card2->getValue();

            // >0 : Player1 win; <0 Player2 win; =0 equality
            if ($result > 0) {
                $this->player1->addToScore(1);

                $this->output
                    ->foreground(Color::WHITE)
                    ->background(Color::GREEN)
                    ->write(sprintf("%s %s ", $this->player1, $card1))
                    ->reset()
                    ->write(sprintf(" %s %s", $card2, $this->player2))
                    ->ln()
                ;
            } elseif ($result < 0) {
                $this->player2->addToScore(1);

                $this->output
                    ->write(sprintf("%s %s ", $this->player1, $card1))
                    ->foreground(Color::WHITE)
                    ->background(Color::GREEN)
                    ->write(sprintf(" %s %s", $card2, $this->player2))
                    ->reset()
                    ->ln()
                ;
            }
        }

        $result = $this->player1->getScore() - $this->player2->getScore();

        // >0 : Player1 win; <0 Player2 win; =0 equality
        if ($result !== 0) {
            $this->output
                ->ln()
                ->foreground(Color::WHITE)
                ->background(Color::GREEN)
                ->bold()
                ->write(sprintf(self::WIN_MESSAGE, ($result > 0 )  ? $this->player1 : $this->player2))
                ->reset()
                ->ln()
                ->ln()
            ;
        } else {
            $this->output
                ->ln()
                ->foreground(Color::WHITE)
                ->background(Color::ORANGE)
                ->bold()
                ->write(self::EQUALITY_MESSAGE)
                ->reset()
                ->ln()
                ->ln()
            ;
        }

        return $this;
    }
}
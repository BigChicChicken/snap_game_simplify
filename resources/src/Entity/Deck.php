<?php

namespace App\Entity;

use Countable;
use Exception;

/**
 * Represent a Deck
 */
class Deck implements Countable
{
    const SPLIT_ERROR = "The cannot be split into two Decks of the same size.";
    const DRAW_ERROR = "The deck is empty, you cannot draw a card.";
    const PUSH = "PUSH";
    const UNSHIFT = "UNSHIFT";

    /**
     * @var Card[]
     */
    private array $cards;

    /**
     * @param Card[] $cards
     */
    function __construct(array $cards = [])
    {
        $this->cards = [];
        foreach ($cards as $card) {
            $this->addCard($card);
        }
    }

    /**
     * Look all Card of the Deck
     *
     * @return Card[]
     */
    public function seeCards(): array
    {
        return $this->cards;
    }

    /**
     * Add a card to the beginning or to the ending of the Deck
     *
     * @param Card   $card
     * @param string $mode
     *
     * @return Deck
     */
    public function addCard(Card $card, string $mode = self::PUSH): Deck
    {
        switch ($mode) {
            case self::UNSHIFT:
                array_unshift($this->cards, $card);
                break;

            default:
                $this->cards[] = $card;
        }

        return $this;
    }

    /**
     * Draw one card
     *
     * @return Card
     * @throws Exception
     */
    public function drawCard(): Card
    {
        if ($this->count() === 0) {
            throw new Exception(self::DRAW_ERROR);
        }

        return array_shift($this->cards);
    }

    /**
     * Shuffle the Deck
     *
     * @return Deck
     */
    public function shuffle(): Deck
    {
        shuffle($this->cards);

        return $this;
    }

    /**
     * Remove all cards
     *
     * @return $this
     */
    public function clearCards(): Deck
    {
        $this->cards = [];

        return $this;
    }

    /**
     * Split this Deck into two
     *
     * @return Deck[]
     * @throws Exception
     */
    public function split(): array
    {
        $count = $this->count();
        if ($count === 0 || $count%2 !== 0) {
            throw new Exception(self::SPLIT_ERROR);
        }

        $decks = array_map(
            fn(array $cards) => new Deck($cards),
            array_chunk($this->cards, $count/2)
        );
        $this->clearCards();

        return $decks;
    }

    /**
     * @inheritdoc
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->cards);
    }
}
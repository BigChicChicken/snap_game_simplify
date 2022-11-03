<?php

namespace App\Entity;

use Stringable;

/**
 * Represent a Player
 */
class Player implements Stringable
{
    /**
     * Name of the Player
     *
     * @var string
     */
    private string $name;

    /**
     * Deck
     *
     * @var Deck
     */
    private Deck $deck;

    /**
     * @var int
     */
    private int $score;

    /**
     * @param string $name
     */
    function __construct(string $name)
    {
        $this->name = $name;
        $this->deck = new Deck();
        $this->score = 0;
    }

    /**
     * Get the Deck
     *
     * @return Deck|null
     */
    public function getDeck(): ?Deck
    {
        return $this->deck;
    }

    /**
     * Get the Deck
     *
     * @param Deck $deck
     * @return Player
     */
    public function setDeck(Deck $deck): Player
    {
        $this->deck = $deck;

        return $this;
    }

    /**
     * Add the modifier to the score
     *
     * @return $this
     */
    public function addToScore(int $modifier): Player
    {
        $this->score += $modifier;

        return $this;
    }

    /**
     * Get the score
     *
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
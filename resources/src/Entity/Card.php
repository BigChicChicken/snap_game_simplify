<?php

declare(strict_types=1);

namespace App\Entity;

use Exception;
use Stringable;

/**
 * Represent a Card to play
 */
class Card implements Stringable
{
    const MIN_ERROR= "A card must have a value greater or equal than %u.";
    const MIN_VALUE = 1;
    const MAX_ERROR = "A card must have a value less or equal than %u.";
    const MAX_VALUE = 52;

    /**
     * Value of the card between
     *
     * @var int
     */
    private int $value;

    /**
     * @throws Exception
     */
    function __construct(int $value)
    {
        if ($value < self::MIN_VALUE) {
            throw new Exception(sprintf(self::MIN_ERROR, self::MIN_VALUE));
        }

        if ($value > self::MAX_VALUE) {
            throw new Exception(sprintf(self::MAX_ERROR, self::MAX_VALUE));
        }

        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%02u', $this->value);
    }
}
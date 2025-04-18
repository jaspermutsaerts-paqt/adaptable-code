<?php

declare(strict_types=1);

namespace App\Cards;

readonly class Card
{
    public function __construct(
        public Suit $suit,
        public string $id,
    ) {
    }

    public function __toString(): string
    {
        return $this->suit->value . $this->id;
    }
}

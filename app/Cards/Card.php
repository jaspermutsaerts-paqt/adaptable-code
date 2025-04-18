<?php

declare(strict_types=1);

namespace App\Cards;

readonly class Card
{
    public function __construct(
        public string $suit,
        public string $id,
    ) {
    }

    public function __toString(): string
    {
        return $this->id . $this->suit;
    }
}

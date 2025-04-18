<?php

namespace Cards;

readonly class Card
{
    public function __construct(
        public string     $suit,
        public int|string $value,

    )
    {
    }
}

<?php

declare(strict_types=1);

namespace App\Cards;

use Countable;

class Hand implements Countable
{
    private array $cards = [];

    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }

    public function getValue(): int
    {
        $faceCards = ['J', 'Q', 'K'];
        $numbers = range(2, 10);
        $valueMap = array_combine($numbers, $numbers) + array_fill_keys($faceCards, 10);
        $valueMap['A'] = 1; // Ace can be 1 or 11 usually, for now no logic to determine the best value implemented

        return array_reduce($this->cards, function (int $total, Card $card) use ($valueMap) {
            return $total + $valueMap[$card->id];
        }, 0);
    }

    public function __toString(): string
    {
        return implode(', ', $this->cards);
    }

    public function count(): int
    {
        return count($this->cards);
    }
}

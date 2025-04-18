<?php

declare(strict_types=1);

namespace App\Cards;

class Hand
{
    /** @param array<Card> $cards */
    public function __construct(private array $cards = [])
    {
    }

    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }

    public function getValue(): int
    {
        $faceCards = ['J', 'Q', 'K'];
        $numbers = range(2, 10);
        $valueMap = array_combine($numbers, $numbers) + array_fill_keys($faceCards, 10);
        $valueMap['A'] = 11; // We start counting them high, unless we need them low

        $acesCount = 0;

        $value = array_reduce($this->cards, function (int $total, Card $card) use ($valueMap, &$acesCount) {
            $acesCount += $card->id === 'A' ? 1 : 0;

            return $total + $valueMap[$card->id];
        }, 0);

        // Change value of aces from 11 to 1, only to get below 21
        while ($value > 21 && $acesCount) {
            $value -= 10;
            $acesCount--;
        }

        return $value;
    }

    public function __toString(): string
    {
        return implode(', ', $this->cards);
    }
}

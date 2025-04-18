<?php

declare(strict_types=1);

namespace App\Cards;

use App\Cards\NumberGenerators\RandomNumberGeneratorInterface;
use Webmozart\Assert\Assert;

class Deck
{
    private array $cards = [];

    public function __construct(
        private readonly RandomNumberGeneratorInterface $randomNumberGenerator,
    ) {
        $this->createCards();
    }

    public function drawCard(): Card
    {
        Assert::notEmpty($this->cards, 'No cards left in the deck');

        $index = $this->randomNumberGenerator->getRandomNumberLessThan(count($this->cards));
        $card = $this->cards[$index];

        array_splice($this->cards, $index, 1);

        return $card;
    }

    private function createCards(): void
    {
        $this->cards = [];
        $cardIds = ['A', ...range(2, 10), 'J', 'Q', 'K'];

        foreach (Suit::cases() as $suit) {
            foreach ($cardIds as $cardId) {
                $this->cards[] = new Card($suit, (string) $cardId);
            }
        }
        // To support the example in the presentation, we do not shuffle
        // instead we make drawing random
    }
}

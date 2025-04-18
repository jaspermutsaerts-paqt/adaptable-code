<?php

namespace App\Cards;


use App\Cards\NumberGenerators\RandomNumberGeneratorInterface;

class Deck
{
    private array $cards = [];

    public function __construct(
        private readonly RandomNumberGeneratorInterface $randomNumberGenerator,
    )
    {
    }

    public function drawCard(): Card
    {
        if (empty($this->cards)) {
            echo "No cards left in the deck\n";
            exit;
        }

        $index = $this->randomNumberGenerator->getRandomNumberBelow(count($this->cards));
        $card = $this->cards[$index];

        array_splice($this->cards, $index, 1);

        return $card;
    }

    public function deal(): void
    {
        $this->cards = [];
        $suits = ['❤️', '♣️', '♦️', '♠️'];
        $values = ['A',  'J', 'Q', 'K'];;

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $this->cards[] = new Card($suit, (string)$value);
            }
        }
    }
}

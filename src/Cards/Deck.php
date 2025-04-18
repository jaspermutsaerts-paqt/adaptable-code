<?php

namespace Cards;

use NumberGenerators\RandomNumberGeneratorInterface;

class CardDeck
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

    public function deal()
    {
        $this->cards = [];
        $suits = ['❤️', '♣️', '♦️', '♠️'];
        $faceCards = ['J', 'Q', 'K', 'A'];

        foreach ($suits as $suit) {
            foreach (range(2, 14) as $value) {
                $value = $value > 10 ? $faceCards[$value - 11] : $value;
                $this->cards[] = new Card($suit, $value);
            }
        }
    }

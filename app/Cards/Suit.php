<?php

declare(strict_types=1);

namespace App\Cards;

enum Suit: string
{
    case Hearts = '❤️';
    case Spades = '♠️';
    case Diamonds = '♦️';
    case Clubs = '♣️';
}

<?php

declare(strict_types=1);

namespace App\Cards;

enum GameOutcome
{
    case PlayerWins;
    case DealerWins;
    case Tie;
}

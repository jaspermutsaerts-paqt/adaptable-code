<?php

declare(strict_types=1);

namespace App\Cards;

enum TurnResult
{
    case Win;
    case Lose;
    case Stand;
}

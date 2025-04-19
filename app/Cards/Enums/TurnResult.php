<?php

declare(strict_types=1);

namespace App\Cards\Enums;

enum TurnResult
{
    case StrongBlackJack;
    case BlackJack;
    case Stand;
    case Bust;
}

<?php

declare(strict_types=1);

namespace App\Cards\Rules;

use App\Cards\GameOutcome;
use App\Cards\TurnResult;

interface DetermineGameOutcomeInterface
{
    public function determineGameOutcome(
        TurnResult $playerResult,
        int $playerValue,
        TurnResult $dealerResult,
        int $dealerValue
    ): GameOutcome;
}

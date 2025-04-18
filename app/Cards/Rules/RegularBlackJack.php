<?php

declare(strict_types=1);

namespace App\Cards\Rules;

use App\Cards\GameOutcome;
use App\Cards\TurnResult;

class RegularBlackJack implements DetermineGameOutcomeInterface
{
    public function determineGameOutcome(
        TurnResult $playerResult,
        int $playerValue,
        TurnResult $dealerResult,
        int $dealerValue
    ): GameOutcome {
        if ($playerResult === TurnResult::Bust) {
            return GameOutcome::DealerWins;
        }

        if ($dealerResult === TurnResult::Bust) {
            return GameOutcome::PlayerWins;
        }

        if ($playerValue > $dealerValue) {
            return GameOutcome::PlayerWins;
        }

        if ($playerValue < $dealerValue) {
            return GameOutcome::DealerWins;
        }

        return GameOutcome::Tie;
    }
}

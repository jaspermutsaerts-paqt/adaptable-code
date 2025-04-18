<?php

declare(strict_types=1);

namespace App\Cards\Rules;

use App\Cards\GameOutcome;
use App\Cards\TurnResult;

class StrongBlackJackWinsFromRegularBlackJack implements DetermineGameOutcomeInterface
{
    public function __construct(private RegularBlackJack $regularRules)
    {
    }

    public function determineGameOutcome(TurnResult $playerResult, int $playerValue, TurnResult $dealerResult, int $dealerValue): GameOutcome
    {
        // if no strong black jack in play, we use the simple one
        if (!in_array(TurnResult::StrongBlackJack, [$playerResult, $dealerResult])) {
            return $this->regularRules->determineGameOutcome($playerResult, $playerValue, $dealerResult, $dealerValue);
        }

        if ($playerResult === $dealerResult) {
            return GameOutcome::Tie;
        }

        return $playerResult === TurnResult::StrongBlackJack ? GameOutcome::PlayerWins : GameOutcome::DealerWins;
    }
}

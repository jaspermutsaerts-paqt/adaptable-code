<?php

namespace App\Cards\Strategies;

use App\Cards\Hand;

class DealerContinueStrategy implements ContinueStrategyInterface
{

    public function shouldHit(Hand $hand): bool
    {
        return $hand->getValue() <= 17;
    }

}

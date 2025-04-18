<?php

namespace App\Cards\Strategies;

use App\Cards\Hand;

class DealerShouldHitStrategy implements ShouldHitStrategyInterface
{

    public function shouldHit(Hand $hand): bool
    {
        return $hand->getValue() < 17;
    }

}

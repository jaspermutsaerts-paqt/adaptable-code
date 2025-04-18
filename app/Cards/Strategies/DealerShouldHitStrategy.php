<?php

declare(strict_types=1);

namespace App\Cards\Strategies;

use App\Cards\Hand;

class DealerShouldHitStrategy implements HitCardStrategyInterface
{
    public function shouldHitCard(Hand $hand): bool
    {
        return $hand->getValue() < 17;
    }
}

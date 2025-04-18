<?php

namespace App\Cards\Strategies;

use App\Cards\Hand;

interface ShouldHitStrategyInterface
{
    public function shouldHit(Hand $hand): bool;
}

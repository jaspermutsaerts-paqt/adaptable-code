<?php

namespace App\Cards\Strategies;

use App\Cards\Hand;

interface ContinueStrategyInterface
{
    public function shouldHit(Hand $hand): bool;
}

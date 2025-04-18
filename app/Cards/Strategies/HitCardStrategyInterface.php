<?php

declare(strict_types=1);

namespace App\Cards\Strategies;

use App\Cards\Hand;

interface HitCardStrategyInterface
{
    public function shouldHitCard(Hand $hand): bool;
}

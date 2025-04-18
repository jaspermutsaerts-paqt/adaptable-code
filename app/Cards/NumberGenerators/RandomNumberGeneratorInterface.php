<?php

declare(strict_types=1);

namespace App\Cards\NumberGenerators;

interface RandomNumberGeneratorInterface
{
    public function getRandomNumberLessThan(int $limit): int;
}

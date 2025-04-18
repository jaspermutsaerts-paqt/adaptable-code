<?php

declare(strict_types=1);

namespace App\Cards\NumberGenerators;

class PseudoRandomNumberGenerator implements RandomNumberGeneratorInterface
{
    public function getRandomNumberLessThan(int $limit): int
    {
        return random_int(0, $limit - 1);
    }
}

<?php

namespace App\Cards\NumberGenerators;

class XkcdNumberGenerator implements RandomNumberGeneratorInterface
{
    public function getRandomNumberLessThan(int $limit): int
    {
        return min(4, $limit - 1);
    }
}

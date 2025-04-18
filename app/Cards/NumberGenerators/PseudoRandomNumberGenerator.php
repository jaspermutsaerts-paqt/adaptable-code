<?php

namespace App\Cards\NumberGenerators;

class PseudoRandomNumberGenerator implements RandomNumberGeneratorInterface
{
    public function getRandomNumberLessThan(int $limit): int
    {
        return rand(0, $limit - 1);
    }
}

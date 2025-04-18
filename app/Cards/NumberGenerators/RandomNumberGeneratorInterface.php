<?php

namespace App\Cards\NumberGenerators;

interface RandomNumberGeneratorInterface
{
    public function getRandomNumberLessThan(int $limit): int;
}

<?php

namespace App\Cards\NumberGenerators;

interface RandomNumberGeneratorInterface
{
    public function getRandomNumberBelow(int $limit): int;
}

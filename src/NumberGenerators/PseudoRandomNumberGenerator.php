<?php

namespace NumberGenerators;

class PseudoRandomNumberGenerator implements RandomNumberGeneratorInterface
{
    public function getRandomNumberBelow(int $limit): int
    {
        return rand(0, $limit - 1);
    }
}

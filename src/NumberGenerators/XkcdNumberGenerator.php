<?php

namespace NumberGenerators;

use NumberGenerators\RandomNumberGeneratorInterface;

class XkcdNumberGenerator implements RandomNumberGeneratorInterface
{
    public function getRandomNumberBelow(int $limit): int
    {
        return min(4, $limit - 1);
    }
}

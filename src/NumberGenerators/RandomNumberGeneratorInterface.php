<?php

namespace NumberGenerators;

interface RandomNumberGeneratorInterface
{
    public function getRandomNumberBelow(int $limit): int;
}

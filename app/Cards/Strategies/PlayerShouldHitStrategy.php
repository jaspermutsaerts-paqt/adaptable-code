<?php

declare(strict_types=1);

namespace App\Cards\Strategies;

use App\Cards\Hand;
use Symfony\Component\Console\Output\OutputInterface;

class PlayerShouldHitStrategy implements HitCardStrategyInterface
{
    private OutputInterface $output;

    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }

    public function shouldHitCard(Hand $hand): bool
    {
        return $this->output->confirm('Do you want another card?', false);
    }
}

<?php

namespace App\Cards\Strategies;

use App\Cards\Hand;
use Symfony\Component\Console\Output\OutputInterface;

class PlayerContinueStrategy implements ContinueStrategyInterface
{
    private OutputInterface $output;

    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;

    }

    public function shouldHit(Hand $hand): bool
    {
        return $this->output->confirm('Do you want a card?', true);
    }

}

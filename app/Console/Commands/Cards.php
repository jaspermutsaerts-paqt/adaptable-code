<?php

namespace App\Console\Commands;

use App\Cards\Deck;
use App\Cards\Hand;
use App\Cards\Strategies\ContinueStrategyInterface;
use App\Cards\Strategies\DealerContinueStrategy;
use App\Cards\Strategies\PlayerContinueStrategy;
use Illuminate\Console\Command;

class Cards extends Command
{

    protected $signature = 'app:cards';

    public function handle(Deck                      $deck,
                           PlayerContinueStrategy $playerContinueStrategy,
                           DealerContinueStrategy $dealerContinueStrategy
    )
    {
        $playerContinueStrategy->setOutput($this->output);

        $deck->deal();

        $playerHand = new Hand();
        $dealerHand = new Hand();

        $player = $this->play($deck, $playerHand, $playerContinueStrategy);
        if ($player === true) {
            $this->info('Blackjack! You win!');
            return 0;
        }
        if ($player === false) {
            $this->info($playerHand->getValue() .' is too high. You lose!');
            return 1;
        }

        $this->info("Player stands");
        // If reach here, dealer plays

        $dealer = $this->play($deck, $dealerHand, $dealerContinueStrategy);
        if ($dealer === true) {
            $this->info('Blackjack! You lose!');
            return 1;
        }
        if ($dealer === false) {
            $this->info($playerHand->getValue() .' is too high. You win!');
            return 0;
        }

        $this->info("Dealer stands");

        if ($playerHand->getValue() > $dealerHand->getValue()) {
            $this->info('You win!');
            return 0;
        }

        $this->info('You lose!');

        return 0;

    }

    function play(Deck $deck, Hand $hand, ContinueStrategyInterface $continueStrategy): ?bool
    {
        while ($continueStrategy->shouldHit($hand)) {
            $card = $deck->drawCard();

            if ($card->id == 'A') {
                $this->warn('In this implementation Aces are only worth 1, not 11.');;
            }

            $hand->addCard($card);
            $this->info('Hand: ' . $hand);

            $value = $hand->getValue();

            if ($value == 21) {
                return true;
            }

            if ($value > 21) {
                return false;
            }

            $this->comment('Current value: ' . $value);
        }

        return null;
    }

}

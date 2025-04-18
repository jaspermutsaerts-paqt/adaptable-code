<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Cards\Card;
use App\Cards\Deck;
use App\Cards\Hand;
use App\Cards\Strategies\DealerShouldHitStrategy;
use App\Cards\Strategies\HitCardStrategyInterface;
use App\Cards\Strategies\PlayerShouldHitStrategy;
use Illuminate\Console\Command;

class BlackJack extends Command
{
    protected $signature = 'app:blackjack';

    protected $description = 'Play a simple game of Black Jack';

    public function handle(
        Deck $deck,
        PlayerShouldHitStrategy $playerHitStrategy,
        DealerShouldHitStrategy $dealerHitStrategy
    ) {
        $playerHitStrategy->setOutput($this->output);

        $this->getOutput()->title('Black Jack');
        $this->comment('In this simple implementation Aces are only worth 1, not 11.');
        $this->newLine();

        $playerHand = new Hand();
        $dealerHand = new Hand();

        $player = $this->playTurn($deck, $playerHand, $playerHitStrategy);
        if ($player === true) {
            $this->info('Blackjack! You win!');

            return 0;
        }
        if ($player === false) {
            $this->info($playerHand->getValue() . ' is too high. You lose!');

            return 1;
        }

        $this->info('Player stands');
        $this->newLine();
        $this->info("Dealer's turn.");
        // If reach here, dealer plays

        $dealer = $this->playTurn($deck, $dealerHand, $dealerHitStrategy);
        if ($dealer === true) {
            $this->info('Blackjack! You lose!');

            return 1;
        }
        if ($dealer === false) {
            $this->info($playerHand->getValue() . ' is too high. You win!');

            return 0;
        }

        $this->info('Dealer stands');

        if ($playerHand->getValue() > $dealerHand->getValue()) {
            $this->info('You win!');

            return 0;
        }

        $this->info('You lose!');

        return 0;
    }

    public function playTurn(Deck $deck, Hand $hand, HitCardStrategyInterface $continueStrategy): ?bool
    {
        // First two cards are not optional
        $this->info('Dealing cards...');
        sleep(1); // use delays to make it feel more like something is happening
        $this->drawCard($deck, $hand);
        $this->drawCard($deck, $hand);

        $this->info('Hand: ' . $hand);
        $this->comment('Current value: ' . $hand->getValue());

        while ($continueStrategy->shouldHitCard($hand)) {
            $this->info('Drawing card...');
            sleep(1);
            $card = $this->drawCard($deck, $hand);
            $this->info('Card drawn: ' . $card);
            sleep(1);
            $this->info('Hand: ' . $hand);
            $value = $hand->getValue();
            sleep(1);

            if ($value == 21) {
                $this->newLine();

                return true;
            }

            if ($value > 21) {
                $this->newLine();

                return false;
            }

            $this->comment('Current value: ' . $value);
        }
        $this->newLine();

        return null;
    }

    private function drawCard(Deck $deck, Hand $hand): Card
    {
        $card = $deck->drawCard();
        $hand->addCard($card);

        return $card;
    }
}

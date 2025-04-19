<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Cards\Card;
use App\Cards\Deck;
use App\Cards\Enums\GameOutcome;
use App\Cards\Enums\TurnResult;
use App\Cards\Hand;
use App\Cards\Rules\DetermineGameOutcomeInterface;
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
        DetermineGameOutcomeInterface $outcomeDeterminer,
        PlayerShouldHitStrategy $playerHitStrategy,
        DealerShouldHitStrategy $dealerHitStrategy
    ) {
        $playerHitStrategy->setOutput($this->output);

        $this->getOutput()->title('Black Jack');
        $this->newLine();

        $playerHand = new Hand();
        $dealerHand = new Hand();

        $playerResult = $this->playTurn('Player', $deck, $playerHand, $playerHitStrategy);

        // Dealer doesn't play when player busts
        if ($playerResult === TurnResult::Bust) {
            $this->determineWinner($outcomeDeterminer, $playerResult, $playerHand, TurnResult::Stand, $dealerHand);

            return 0;
        }

        $this->info("Dealer's turn.");
        $dealerResult = $this->playTurn('Dealer', $deck, $dealerHand, $dealerHitStrategy);
        $this->determineWinner($outcomeDeterminer, $playerResult, $playerHand, $dealerResult, $dealerHand);

        return 0;
    }

    public function playTurn(
        string $playerName,
        Deck $deck,
        Hand $hand,
        HitCardStrategyInterface $continueStrategy
    ): TurnResult {
        // First two cards are not optional
        $this->info('Dealing cards...');
        sleep(1); // use delays to make it feel more like something is happening
        $this->drawCard($deck, $hand);
        $this->drawCard($deck, $hand);

        $value = $hand->getValue();
        $this->line('<info>Hand: ' . $hand . '</info> <comment>(' . $value . ')</comment>');

        if ($value == 21) {
            $this->newLine();
            $this->info('BlackJack!');

            return TurnResult::StrongBlackJack;
        }

        while ($continueStrategy->shouldHitCard($hand)) {
            $this->info('Drawing card...');
            sleep(1);
            $card = $this->drawCard($deck, $hand);
            $this->info('Card drawn: ' . $card);
            sleep(1);
            $value = $hand->getValue();
            $this->line('<info>Hand: ' . $hand . '</info> <comment>(' . $value . ')</comment>');
            sleep(1);

            $this->newLine();

            if ($value == 21) {
                $this->comment($playerName . ' has BlackJack!');

                return TurnResult::BlackJack;
            }

            if ($value > 21) {
                $this->comment($playerName . ' bust!');

                return TurnResult::Bust;
            }
        }
        $this->newLine();
        $this->info($playerName . ' stands.');
        $this->newLine();

        return TurnResult::Stand;
    }

    private function drawCard(Deck $deck, Hand $hand): Card
    {
        $card = $deck->drawCard();
        $hand->addCard($card);

        return $card;
    }

    public function determineWinner(
        DetermineGameOutcomeInterface $outcomeDeterminer,
        TurnResult $playerResult,
        Hand $playerHand,
        TurnResult $dealerResult,
        Hand $dealerHand,
    ): void {
        $outcome = $outcomeDeterminer->determineGameOutcome(
            $playerResult,
            $playerHand->getValue(),
            $dealerResult,
            $dealerHand->getValue(),
        );

        $message = match($outcome) {
            GameOutcome::PlayerWins => 'You win!',
            GameOutcome::DealerWins => 'You Lose!',
            GameOutcome::Tie        => 'Tie!',
        };

        $this->info($message);
    }
}

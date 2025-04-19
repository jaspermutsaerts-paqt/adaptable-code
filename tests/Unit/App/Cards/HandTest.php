<?php

declare(strict_types=1);

namespace Tests\Unit\App\Cards;

use App\Cards\Card;
use App\Cards\Enums\Suit;
use App\Cards\Hand;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class HandTest extends TestCase
{
    #[Test]
    public function it_converts_to_human_readable_string(): void
    {
        $hand = new Hand([
            new Card(Suit::Diamonds, '2'),
            new Card(Suit::Clubs, '3'),
            new Card(Suit::Hearts, '10'),
            new Card(Suit::Clubs, '4'),
            new Card(Suit::Clubs, 'J'),
            new Card(Suit::Clubs, 'K'),
            new Card(Suit::Spades, 'A'),
        ]);

        $this->assertEquals('♦️ 2, ♣️ 3, ❤️ 10, ♣️ 4, ♣️ J, ♣️ K, ♠️ A', (string) $hand);
    }

    #[Test]
    #[TestWith(['cardIds' => [], 'expected' => 0])]
    #[TestWith(['cardIds' => ['A'], 'expected' => 11])]
    #[TestWith(['cardIds' => ['A', 'A'], 'expected' => 12])]
    #[TestWith(['cardIds' => ['A', 'A', 'A', 'A'], 'expected' => 14])]
    #[TestWith(['cardIds' => ['2', 'A'], 'expected' => 13])]
    #[TestWith(['cardIds' => ['K', 'A'], 'expected' => 21])]
    #[TestWith(['cardIds' => ['J', '2', '3', 'A'], 'expected' => 16])]
    #[TestWith(['cardIds' => ['2', 'A', 'A'], 'expected' => 14])]
    #[TestWith(['cardIds' => ['2', 'A', 'A', 'A'], 'expected' => 15])]
    #[TestWith(['cardIds' => [3, 5, 'A', 'A', 'A'], 'expected' => 21])]
    #[TestWith(['cardIds' => ['K', 'Q', 'J', 'A', 'A'], 'expected' => 32])]
    public function it_calculates_optimal_total_value(array $cardIds, int $expected): void
    {
        $hand = new Hand(
            array_map(fn (string $value) => new Card(Suit::Hearts, $value), $cardIds)
        );

        $this->assertEquals($expected, $hand->getValue());
    }
}

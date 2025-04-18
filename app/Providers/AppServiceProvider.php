<?php

declare(strict_types=1);

namespace App\Providers;

use App\Cards\NumberGenerators\PseudoRandomNumberGenerator;
use App\Cards\NumberGenerators\RandomNumberGeneratorInterface;
use App\Cards\NumberGenerators\XkcdNumberGenerator;
use App\Cards\Rules\DetermineGameOutcomeInterface;
use App\Cards\Rules\StrongBlackJackWinsFromRegularBlackJack;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            RandomNumberGeneratorInterface::class,
            time() % 3 ? PseudoRandomNumberGenerator::class : XkcdNumberGenerator::class // 🧌
        );
        $this->app->bind(DetermineGameOutcomeInterface::class, StrongBlackJackWinsFromRegularBlackJack::class);
    }
}

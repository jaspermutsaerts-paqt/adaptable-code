<?php

namespace App\Providers;

use App\Cards\NumberGenerators\PseudoRandomNumberGenerator;
use App\Cards\NumberGenerators\RandomNumberGeneratorInterface;
use App\Cards\NumberGenerators\XkcdNumberGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton(RandomNumberGeneratorInterface::class, function ($app) {
            return $app->get(time() % 2 ? PseudoRandomNumberGenerator::class : XkcdNumberGenerator::class); // 🧌
        });
    }
}

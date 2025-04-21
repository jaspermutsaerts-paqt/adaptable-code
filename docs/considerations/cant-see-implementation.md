# Considerations

## "But when all dependencies are interfaces, I can not see what it does!"

Yes you can. As long as we name our interfaces and methods appropriately.

```php
namespace App\Cards;

use Webmozart\Assert\Assert;

class Deck
{
    private array $cards = [];

    public function __construct(
        private readonly RandomNumberGeneratorInterface $randomNumberGenerator,
    )
    {
    }

    public function drawCard(): Card
    {
        Assert::notEmpty($this->cards, 'No cards left in the deck');

        $index = $this->randomNumberGenerator->getRandomNumberLessThan(count($this->cards));
        $card = $this->cards[$index];

        array_splice($this->cards, $index, 1);

        return $card;
    }
...
```

Do you really need to see the implementation of `RandomNumberGeneratorInterface::getRandomNumberLessThan()` to know
understand what is going on in `drawCard()`?

That is only relevant when fixing _that_ dependency, but if that's not reported broken you better believe it returns a
random number less than the given argument.

Also yes this is a working game: `./artisan app:blackjack`

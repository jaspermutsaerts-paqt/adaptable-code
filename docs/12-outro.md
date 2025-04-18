# Conclusion ##

This talk was just about interfaces. But that's not a catchy title.
For those who are not a fan, 

## Summary

When introducing interfaces

## When do you introduce an interface?

Always.  
No, not really. It depends on how interchangeable it likely will be.

In case of a client for a remote source, I do it by default, because

- I'd like to be able to make an offline/in memory version
- Even if you don't think the remote source will change, API's can change, so you could have an implementation for both
  versions in a transition period.
- More than once in my something was "only needed from remote X",  to later be asked to add it for remote Y too.
  And sometimes even during development of X I needed to pivot to Y

Even during development, I'd like to ask myself this question:

**If for a specific situation (but not all), some part needs other conditions, another remote source, another remote destination,
How much of the application code do I need to change?** 

Try to make those parts separate dependencies (if they aren't already) and try to define them as interfaces.
In other words: can you make the application plug & play while maintaining its basic flow/business rules regardless of the implementations?


## When do you split up your interface?

- Decide whether all implementations will definitely need to implement all methods, if not: split up.
- Are you sure the interface serves a single purpose, or is it just that your current intended implementation does all
  these things?

## "But when all dependencies are interfaces, I can not see what it does!"

Yes you can.

```php
class CardDeck {

    public function __(
        private array $cards;
        private readonly RandomNumberGeneratorInterface randomNumberGenerator
    ){        
    }
    
    public function drawCard(): Card {
        $index = $this->randomNumberGenerator->getRandomNumberBelow(count($cards));
        $this->cards = array_slice($this->cards, $index, 1)
        
    }
}

```

If you see a dependency is called `RandomNumberGeneratorInterface` and a method is called `getRandomNumber()`
Do you really need to see the source?

That is only relevant when fixing _that_ dependency, but if that's not reported broken you better believe it returns a random number.

# Thoughts?

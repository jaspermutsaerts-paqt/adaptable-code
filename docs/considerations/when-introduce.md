# Considerations

## When do you introduce an interface?

Always.  
No, not really. It depends on how interchangeable it likely will be.

In case of a client for a remote source, I do it by default, because

- I'd like to be able to make an offline/in memory version
- Even if you don't think the remote source will change, API's can change, so you could have an implementation for both
  versions in a transition period.
- More than once in my career something was "only needed from remote X", to later be asked to add it for remote Y too.
  And sometimes even during development of X, I needed to pivot to Y

Even during development, I'd like to ask myself this question:

**If for a specific situation (but not all), some part needs other conditions, another remote source, another remote
destination,
How much of the application code do I need to change?**

Try to make those parts separate dependencies (if they aren't already) and try to define them as interfaces.
In other words: can you make the application plug & play while maintaining its basic flow/business rules regardless of
the implementations of the interfaces?

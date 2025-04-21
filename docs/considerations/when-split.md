# Considerations

## When do you split up your interface into multiple parts?

- Decide whether all implementations will definitely need to implement all methods, if not: split up.
- Are you sure the interface serves a single purpose, or is it just that your current intended implementation does all
  these things?

"We need to at this method to a class, so we need to add it to all its interface's implementations"
That's a good starting point to consider whether the new method is part of the same context of purpose.

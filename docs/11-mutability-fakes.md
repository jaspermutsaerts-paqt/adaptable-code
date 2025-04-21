Making fakes work with persistence is harder, but not impossible.
I wanted to put some examples here, but it was hard to make it not too complex.
There are some considerations:

- unique value generation for create-methods
- If you use database as a source for your fake, an update to sync remote with local won't do anything.
It's easy to make it work in a flow, but hard to make it useful.
- An in-memory solution like a simple array is easier to implement, but gets tricky when you need to maintain relations.

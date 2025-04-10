Using an interface makes it easier to make tests independent of remote connections.  
You could mock dependencies of course, but there are some disadvantages:

- Each test (case) is responsible for setting up both expectations and return values
- It might accept incorrect arguments or return incorrect 
- Too many mocking might lead to a test only testing itself instead of production code
{TODO: Try to think of a concrete example here}

```php
class RemotePersonControllerTest extends TestCase {

    /** @test */
    public function it_retrieves_people_from_remote(): void {
        $clientMock = $this->mock(ListRemotePeopleInterface::class);
        $clientMock
            ->expects()
            ->getLicensesForPerson()
            ->andReturn([
                new Dto\License('all', 'constructor', 'args'),
                new Dto\License('some', 'more', 'args'),
            ]);
    }
} 
```


Fakes are another type of test doubles. They are not mocks, but they "actually" work, but usually in a simplified case.
In teams I've worked with, we usually called them `Fake`, but it is also common to namespace or prefix it as `InMemory`, or even `Database`.


This example just lists the people, or licenses already stored. 

```php

namespace \App\Clients\Database;

class ListPeopleClient implements ListRemotePeopleClient {

    public function __construct(private readonly string $validAccessToken): {
    
    }

    public function getPeopleInGroup(string $accessToken, Group $person): Collection {
        Assert::eq($accessToken, $this->validAccessToken, 'Invalid access token');
        Assert::keyExists($person->some_identifier, $this->validAccessToken, 'Unknown group');
        
        $localPeople = Person::whereHasGroup($group)
            ->whereNotNull('some_identifier')
            ->get();       
        
        $remotePeople = $localPeople->map($this->someTransformation(...)); // still just go with it

        return $remotePeople;
    }
} 
```



```php

namespace \App\Clients\Database;

class ListLicenceClient implements ListRemoteLicenseClient {

    public function __construct(private readonly string $validAccessToken): {
    
    }

    public function getLicensesForPerson(string $accessToken, Person $person): Collection {
        Assert::eq($accessToken, $this->validAccessToken, 'Invalid access token');
        Assert::keyExists($person->some_identifier, $this->validAccessToken, 'Unknown person');
        
        $localLicenses = $person->licenses;       
        
        $remoteLicenses = $localLicenses->map($this->someTransformation(...));
        return $remoteLicenses;
        
    }
} 
```

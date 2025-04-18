Previous example will not work correctly when we expect an update to also be persisted on the remote, but shouldn't change anything locally.

Now, what if you want things to be persisted, at least during your tests.


**Sorry, Not ready**
```php

namespace \App\Clients\InMemory;

class PeopleClient implements ListRemotePeopleClientInterface, EditRemotePersonClient {

    /** @var Collection<string, Collection<Dto\Person>> */
    private Collection $remotePeopleInGroups;

    public function __construct(private readonly string $validAccessToken): {
         $this->remotePeopleInGroups = Groups::whereNotNull('some_identifier')
            ->mapWithKeys(fn (Group $group) => [
                $group->some_identifier => $group->people->map($this->someTransformation(...)); // still going with it?
            ]);         
    }

    public function getPeopleInGroup(string $accessToken, Group $group): array {
        Assert::eq($accessToken, $this->validAccessToken, 'Invalid access token');
        Assert::true($this->remotePeopleInGroups->has($group->some_identifier), 'Unknown group');        
    }
    
    
    public function createPerson(string $accessToken, PersonDto $person): Person {
        ...
    }
    
    public function deletePerson(string $accessToken, PersonDto $person): bool {
        ...
    }
    
    public function updatePerson(string $accessToken, PersonDto $person): bool {
        ...
    }    
    
    public function createPerson(string $accessToken, PersonDto $person): Person {
        ...
    }
} 
```

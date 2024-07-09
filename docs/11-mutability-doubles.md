Previous example will not work correctly when we expect an update to also be persisted on the remote, but shouldn't change anything localy 


**Sorry, Not ready**
```php

namespace \App\Clients\Database;

class PeopleClient implements ListRemotePeopleClientInterface, EditRemotePersonClient {

    /** @var Collection<string, Collection<Dto\Person>> */
    private Collection $remotePeopleInGroups;

    public function __construct(private readonly string $validAccessToken): {
         $this->remotePeopleInGroups = Groups::whereNotNull('some_identifier')
            ->mapWithKeys(fn (Group $group) => [
                $group->some_identifier => $group->people->map($this->someTransformation(...)); // still going with it?
            ]);         
    }

    public function getPeopleInGroup(string $accessToken, Group $group): Collection {
        Assert::eq($accessToken, $this->validAccessToken, 'Invalid access token');
        Assert::true($this->remotePeopleInGroups->has($group->some_identifier), 'Unknown group');        
    }
    
    
    public function createPerson(string $accessToken, App\Dto\Person $person): Person {
        ...
    }
    
    public function deletePerson(string $accessToken, App\Dto\Person $person): bool {
        ...
    }
    
    public function updatePerson(string $accessToken, App\Dto\Person $person): bool {
        ...
    }    
    
    public function createPerson(string $accessToken, App\Dto\Person $person): Person {
        ...
    }
} 
```

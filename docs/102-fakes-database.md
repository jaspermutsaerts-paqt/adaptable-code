## Fakes: Database

```php

namespace \App\Clients\Database;

class ListPersonClient implements ListRemotePersonClient {

    /** @return PersonDto[] */
    public function getPeopleInGroup(Group $group): array
    {
        Assert::notNull($group->some_identifier, 'Unknown group');

        $people = $group->people()
            ->whereNotNull('some_identifier')
            ->chunkMap(
                fn (Person $person) => $this->personTransformer->transformRecord($person->attributesToArray())
            );

        return $people->all();
    }
} 
```

```php
use App\Clients\Database\ListPersonClient as DatabaseListPersonClient;

#[Test]
public function it_gets_people_from_group_using_database_fake(): void
{
    $this->instance(ListRemotePersonClientInterface::class, app(DatabaseListPersonClient::class));

    $groupWithPeople = Group::factory()
        ->hasAttached(Person::factory(['name' => 'John']))
        ->hasAttached(Person::factory(['name' => 'Jackie']))
        ->createOne();

    $otherGroupWithPeople = Group::factory()
        ->hasAttached(Person::factory(['name' => 'James']))
        ->createOne();

    $groupWithoutPeople = Group::factory()->createOne();
    $groupNotOnRemote = Group::factory()->createOne(['some_identifier' => null]);

    $this->get(route('person.group', $groupWithPeople))
        ->assertSeeInOnrder(['John', 'Jackie']);

    $this->get(route('person.group', $otherGroupWithPeople))
        ->assertSee(['James']);

    $this->get(route('person.group', $groupWithoutPeople))
        ->assertSee(['No people found in group.']);

    // Fails on clear exception: unknown group
    $this->get(route('person.group', $groupNotOnRemote)) 
        ->assertSee(['No people found in group.']);
}
```

# Mocks vs Fakes

Using an interface makes it easier to make tests independent of remote connections.  
You could mock dependencies of course, but there are some disadvantages.

### Mocking

- Each test (case) is responsible for setting up both expectations and return values
- It might accept incorrect arguments or return incorrect data
- Too many mocking might lead to a test only testing itself instead of production code

```php
class RemotePersonControllerTest extends TestCase {

    #[Test]
    public function it_gets_licenses_for_person(): void
    {
        $licenses = [
            new LicenseDto('111111', 'person1-license-1'),
            new LicenseDto('122222', 'person1-license-2'),
        ];

        $this->mock(RemoteLicenseClientInterface::class)
            ->expects('getLicensesForPerson')
            ->andReturn($licenses);

        $this->get(route('license.index', $this->personWithLicenses))
            ->assertSeeInOrder('person2-license-1', 'person2-license-2']);

        $licenses = [
            new LicenseDto('211111', 'person2-license-1'),
            new LicenseDto('222222', 'person2-license-2'),
        ];

        $this->mock(RemoteLicenseClientInterface::class)
            ->expects('getLicensesForPerson')
            ->andReturn($licenses);

        // What will go wrong here?
        $this->get(route('license.index', $this->personWithLicenses))
            ->assertSeeInOrder('person2-license-1', 'person2-license-2']); 

        // What will go wrong here?
        $this->get(route('license.index', $this->personNotOnRemote))
            ->assertSee('No licenses found.'); 
    }
} 
```

### Fakes

Fakes are another type of test doubles. They are not mocks, but they "actually" work, but usually in a simplified case.
In teams I've worked with, we usually called them `Fake`,
but it is also common to namespace or prefix it as `InMemory`, or even `Database`, depending on how they work.
Depending on the implementation you could even just consider them just alternative drivers.




#### In Memory

```php
namespace \App\Clients\Fake;

class ListLicenseClient implements RemoteLicenseClientInterface
{
    /**
     * @param array<string, LicenseDto> $licensesPerPerson
     */
    public function __construct(private array $licensesPerPerson)
    {
    }

    public function getLicensesForPerson(Person $person): array
    {
        Assert::keyExists($person->some_identifier, 'Unknown person');

        return $this->licensesPerPerson[$person->some_identifier];
    }
}
```

```php
use App\Clients\Fake\ListLicenseClient as FakeLicenseClient;
...
#[Test]
public function it_gets_licenses_for_person(): void
{
    // This setup could be done outside of the test(case)
    $licenses = [
        $this->personWithLicenses->id => [
            new LicenseDto('111111', 'person1-license-1'),
            new LicenseDto('122222', 'person1-license-2'),
        ],
        $this->otherPersonWithLicenses->id => [
            new LicenseDto('211111', 'person2-license-1'),
            new LicenseDto('222222', 'person2-license-2'),
        ],
    ];
    $this->instance(RemoteLicenseClientInterface::class, new FakeLicenseClient($licenses));

    $this->get(route('license.index', $this->personWithLicenses))
        ->assertSeeInOrder('person1-license-1', 'person1-license-2']);

    $this->get(route('license.index', $this->otherPersonWithLicenses))
        ->assertSeeInOrder('person2-license-1', 'person2-license-2']);

    // Fails on clear exception: unknown person
    $this->get(route('license.index', $this->personNotOnRemote)) 
        ->assertSee('No licenses found.'); 
}
```

#### Database

```php

namespace \App\Clients\Database;

class ListPeopleClient implements ListRemotePeopleClient {

    /** @return PersonDto[] */
    public function getPeopleInGroup(Group $group): array
    {
        Assert::notNull($group->some_identifier, 'Unknown group');

        $people = $group->people()
            ->whereNotNull('some_identifier')
            ->chunkMap(
            fn (Person $person) => $this->personTransformer->transformRecord($person->attributesToArray()));

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

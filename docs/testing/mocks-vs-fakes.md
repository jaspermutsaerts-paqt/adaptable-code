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

## Fakes

**Fakes** are another type of test doubles. They are not mocks, but they "actually" work, but usually in a simplified case.
In teams I've worked with, we usually called them `Fake`,
but it is also common to namespace or prefix it as `InMemory`, or even `Database`, depending on how they work.
Depending on the implementation you could even just consider them just alternative drivers.

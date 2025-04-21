## Fakes: In Memory

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

class RemotePersonControllerTest extends TestCase {
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
        $this->instance(ListRemoteLicenseClientInterface::class, new FakeLicenseClient($licenses));
    
        $this->get(route('license.index', $this->personWithLicenses))
            ->assertSeeInOrder('person1-license-1', 'person1-license-2']);
    
        $this->get(route('license.index', $this->otherPersonWithLicenses))
            ->assertSeeInOrder('person2-license-1', 'person2-license-2']);
    
        // Fails on clear exception: unknown person
        $this->get(route('license.index', $this->personNotOnRemote)) 
            ->assertSee('No licenses found.'); 
    }
}
```

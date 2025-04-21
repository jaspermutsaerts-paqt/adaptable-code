<?php

declare(strict_types=1);

namespace Feature\App;

use App\Clients\InMemory\LicenseClient as FakeListLicenseClient;
use App\Domains\License\Clients\ListRemoteLicenseClientInterface;
use App\Domains\License\Dto\LicenseDto;
use App\Models\Person;
use Illuminate\Foundation\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Contains deliberately failing tests, to drive home a point.
 */
class RemoteLicenseControllerTest extends TestCase
{
    private Person $personWithLicenses;
    private Person $otherPersonWithLicenses;
    private Person $personNotOnRemote;

    protected function setUp(): void
    {
        parent::setUp();

        $this->personWithLicenses = Person::factory()->createOne();
        $this->otherPersonWithLicenses = Person::factory()->createOne();
        $this->personNotOnRemote = Person::factory()->createOne();
    }

    #[Test]
    public function it_gets_licenses_for_person_using_mocks(): void
    {
        $licenses = [
            new LicenseDto('111111', 'person1-license-1'),
            new LicenseDto('122222', 'person1-license-2'),
        ];

        $this->mock(ListRemoteLicenseClientInterface::class)
            ->expects('getLicensesForPerson')
            ->andReturn($licenses);

        $this->get(route('license.index', $this->personWithLicenses))
            ->assertJsonPath('data.*.name', ['person1-license-1', 'person1-license-2']);

        $licenses = [
            new LicenseDto('211111', 'person2-license-1'),
            new LicenseDto('222222', 'person2-license-2'),
        ];

        $this->mock(ListRemoteLicenseClientInterface::class)
            ->expects('getLicensesForPerson')
            ->andReturn($licenses);

        $this->get(route('license.index', $this->personWithLicenses))
            ->assertJsonPath('data.*.name', ['person2-license-1', 'person2-license-2']); // Passes incorrectly

        $this->get(route('license.index', $this->personNotOnRemote))
            ->assertJsonPath('data.*.name', []); // Fails because it incorrectlu returns
    }

    #[Test]
    public function it_gets_licenses_for_person__using_database_in_memory_fake(): void
    {
        $licenses = [
            $this->personWithLicenses->some_identifier => [
                new LicenseDto('111111', 'person2-license-1'),
                new LicenseDto('122222', 'person2-license-2'),
            ],
            $this->otherPersonWithLicenses->some_identifier => [
                new LicenseDto('211111', 'person2-license-1'),
                new LicenseDto('222222', 'person2-license-2'),
            ],
        ];
        $this->instance(ListRemoteLicenseClientInterface::class, new FakeListLicenseClient($licenses));

        $this->get(route('license.index', $this->personWithLicenses))
            ->assertJsonPath('data.*.name', ['person2-license-1', 'person2-license-2']);

        $this->get(route('license.index', $this->otherPersonWithLicenses))
            ->assertJsonPath('data.*.name', ['person2-license-1', 'person2-license-2']);

        $this->get(route('license.index', $this->personNotOnRemote)) // Fails on clear exception: unknown person
            ->assertJsonPath('data.*.name', []);
    }
}

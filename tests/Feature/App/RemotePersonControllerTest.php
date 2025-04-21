<?php

declare(strict_types=1);

namespace Feature\App;

use App\Clients\Database\PersonClient as DatabaseListPersonClient;
use App\Domains\Person\Clients\RemotePersonClientInterface as ListRemotePersonClientInterface;
use App\Models\Group;
use App\Models\Person;
use Illuminate\Foundation\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Contains deliberately failing tests, to drive home a point.
 */
class RemotePersonControllerTest extends TestCase
{
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
            ->assertJsonPath('data.*.name', ['John', 'Jackie']);

        $this->get(route('person.group', $otherGroupWithPeople))
            ->assertJsonPath('data.*.name', ['James']);

        $this->get(route('person.group', $groupWithoutPeople))
            ->assertJsonPath('data.*.name', []);

        $this->get(route('person.group', $groupNotOnRemote)) // Fails on clear exception: unknown group
            ->assertJsonPath('data.*.name', []);
    }
}

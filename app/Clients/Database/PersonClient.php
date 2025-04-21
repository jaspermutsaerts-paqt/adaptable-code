<?php

declare(strict_types=1);

namespace App\Clients\Database;

use App\Domains\Person\Clients\RemotePersonClientInterface;
use App\Models\Group;
use App\Models\Person;
use Webmozart\Assert\Assert;

class PersonClient implements RemotePersonClientInterface
{
    public function __construct(private PersonTransformer $personTransformer)
    {
    }

    public function getPeopleInGroup(Group $group): array
    {
        Assert::notNull($group->some_identifier, 'Unknown group');

        $people = $group->people()
            ->whereNotNull('some_identifier')
            ->chunkMap(fn (Person $person) => $this->personTransformer->transformRecord($person->attributesToArray()));

        return $people->all();
    }
}

<?php

declare(strict_types=1);

namespace App\Clients\InMemory;

use App\Domains\Person\Clients\ListRemotePersonClientInterface;
use App\Domains\Person\Dto\PersonDto;
use App\Models\Group;
use Webmozart\Assert\Assert;

class ListPersonClient implements ListRemotePersonClientInterface
{
    /**
     * @param array<string, PersonDto> $peoplePerGroup
     */
    public function __construct(private array $peoplePerGroup)
    {
    }

    public function getPeopleInGroup(Group $group): array
    {
        Assert::keyExists($this->peoplePerGroup, $group->some_identifier, 'Unknown group');

        return $this->peoplePerGroup[$group->some_identifier];
    }
}

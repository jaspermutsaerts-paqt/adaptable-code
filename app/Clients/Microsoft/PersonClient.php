<?php

declare(strict_types=1);

use App\Domains\Person\Clients\RemotePersonClientInterface;
use App\Models\Group;

class PersonClient implements RemotePersonClientInterface
{
    public function __construct(private readonly PersonTransformer $personTransformer)
    {
    }

    public function getPeopleInGroup(Group $group): array
    {
        $remoteUsers = []; // TODO

        return array_map($this->personTransformer->transformRecord(...), $remoteUsers);
    }
}

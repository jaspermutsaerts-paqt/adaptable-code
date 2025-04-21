<?php

declare(strict_types=1);

namespace App\Clients\Google;

use App\Domains\Person\Clients\ListRemotePersonClientInterface;
use App\Models\Group;

class Client implements ListRemotePersonClientInterface
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

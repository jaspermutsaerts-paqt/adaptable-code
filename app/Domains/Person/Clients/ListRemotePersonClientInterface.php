<?php

declare(strict_types=1);

namespace App\Domains\Person\Clients;

use App\Domains\Person\Dto\PersonDto;
use App\Models\Group;

interface ListRemotePersonClientInterface
{
    /** @return array<PersonDto> */
    public function getPeopleInGroup(Group $group): array;
}

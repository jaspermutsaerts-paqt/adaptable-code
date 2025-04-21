<?php

declare(strict_types=1);

namespace App\Domains\Person\Clients;

use App\Domains\Person\Dto\PersonDto;
use App\Models\Group;

interface RemotePersonClientInterface
{
    /** @return array<PersonDto> */
    public function getPeopleInGroup(Group $group): array;
}

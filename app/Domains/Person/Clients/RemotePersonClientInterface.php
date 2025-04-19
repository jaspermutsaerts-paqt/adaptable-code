<?php

declare(strict_types=1);

namespace App\Domains\Person\Clients;

use App\Models\Group;

interface RemotePersonClientInterface
{
    /** @return array */
    public function getPeopleInGroup(Group $group): array;
}

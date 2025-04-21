<?php

declare(strict_types=1);

namespace App\Domains\Person\Clients;

use App\Domains\Person\Dto\PersonDto;
use App\Models\Person;

interface EditRemotePersonClientInterface
{
    public function createPerson(Person $person): PersonDto;

    public function deletePerson(Person $person): bool;

    public function updatePerson(Person $person): bool;
}

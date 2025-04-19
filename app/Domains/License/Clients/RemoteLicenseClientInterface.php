<?php

declare(strict_types=1);

namespace App\Domains\License\Clients;

use App\Models\Person;

interface RemoteLicenseClientInterface
{
    /** @return array */
    public function getLicensesForPerson(Person $person): array;
}

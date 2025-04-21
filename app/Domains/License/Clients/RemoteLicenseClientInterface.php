<?php

declare(strict_types=1);

namespace App\Domains\License\Clients;

use App\Domains\License\Dto\LicenseDto;
use App\Models\Person;

interface RemoteLicenseClientInterface
{
    /** @return array<LicenseDto> */
    public function getLicensesForPerson(Person $person): array;
}

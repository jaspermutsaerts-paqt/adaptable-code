<?php

declare(strict_types=1);

namespace App\Clients\Microsoft;

use App\Domains\License\Clients\ListRemoteLicenseClientInterface;
use App\Domains\Person\Clients\ListRemotePersonClientInterface;
use App\Models\Group;
use App\Models\Person;

class Client implements ListRemotePersonClientInterface, ListRemoteLicenseClientInterface
{
    public function __construct(
        private readonly PersonTransformer $personTransformer,
        private readonly LicenseTransformer $licenseTransformer,
    ) {
    }

    public function getPeopleInGroup(Group $group): array
    {
        $remoteUsers = []; // TODO

        return array_map($this->personTransformer->transformRecord(...), $remoteUsers);
    }

    public function getLicensesForPerson(Person $person): array
    {
        $licences = []; // TODO

        return array_map($this->licenseTransformer->transformRecord(...), $licences);
    }
}

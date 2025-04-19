<?php

declare(strict_types=1);

use App\Clients\Microsoft\LicenseTransformer;
use App\Domains\License\Clients\RemoteLicenseClientInterface;
use App\Domains\Person\Clients\RemotePersonClientInterface;
use App\Models\Group;
use App\Models\Person;

class Client implements RemotePersonClientInterface, RemoteLicenseClientInterface
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

<?php

declare(strict_types=1);

namespace App\Clients\Afas;

use App\Domains\License\Clients\ListRemoteLicenseClientInterface;
use App\Models\Person;

class Client implements ListRemoteLicenseClientInterface
{
    public function __construct(private readonly LicenseTransformer $licenseTransformer)
    {
    }

    public function getLicensesForPerson(Person $person): array
    {
        $licences = []; // TODO

        return array_map($this->licenseTransformer->transformRecord(...), $licences);
    }
}

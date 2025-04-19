<?php

declare(strict_types=1);

namespace App\Clients\Afas;

use App\Domains\License\Clients\RemoteLicenseClientInterface;
use App\Models\Person;

class LicenseClient implements RemoteLicenseClientInterface
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

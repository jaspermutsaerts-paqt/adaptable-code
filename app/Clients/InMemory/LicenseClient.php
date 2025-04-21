<?php

declare(strict_types=1);

namespace App\Clients\InMemory;

use App\Domains\License\Clients\ListRemoteLicenseClientInterface;
use App\Domains\License\Dto\LicenseDto;
use App\Models\Person;
use Webmozart\Assert\Assert;

class LicenseClient implements ListRemoteLicenseClientInterface
{
    /**
     * @param array<string, LicenseDto> $licensesPerPerson
     */
    public function __construct(private array $licensesPerPerson)
    {
    }

    public function getLicensesForPerson(Person $person): array
    {
        Assert::keyExists($this->licensesPerPerson, $person->some_identifier, 'Unknown person');

        return $this->licensesPerPerson[$person->some_identifier];
    }
}

<?php

declare(strict_types=1);

namespace App\Clients\Fake;

use App\Domains\License\Clients\RemoteLicenseClientInterface;
use App\Domains\License\Dto\LicenseDto;
use App\Models\Person;
use Webmozart\Assert\Assert;

class LicenseClient implements RemoteLicenseClientInterface
{
    /**
     * @param array<string, LicenseDto> $licensesPerPerson
     */
    public function __construct(private array $licensesPerPerson)
    {
    }

    public function getLicensesForPerson(Person $person): array
    {
        Assert::keyExists($this->licensesPerPerson, $person->id, 'Unknown person');

        return $this->licensesPerPerson[$person->id];
    }
}

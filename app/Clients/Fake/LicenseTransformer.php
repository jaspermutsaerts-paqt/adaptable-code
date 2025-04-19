<?php

declare(strict_types=1);

namespace App\Clients\Microsoft;

use App\Domains\Person\Dto\PersonDto;

class LicenseTransformer
{
    public function transformRecord(array $record): PersonDto
    {
        return new PersonDto(
            remoteId: $record['some-microsoft-license-id'],
            name: $record['some-microsoft-license-name'],
        );
    }
}

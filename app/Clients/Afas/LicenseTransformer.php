<?php

declare(strict_types=1);

namespace App\Clients\Afas;

use App\Domains\License\Dto\LicenseDto;

class LicenseTransformer
{
    public function transformRecord(array $record): LicenseDto
    {
        return new LicenseDto(
            remoteId: $record['id'],
            name: $record['displayName'],
        );
    }
}

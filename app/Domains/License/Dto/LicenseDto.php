<?php

declare(strict_types=1);

namespace App\Domains\License\Dto;

readonly class LicenseDto
{
    public function __construct(
        public string $remoteId,
        public string $name,
    ) {
    }
}

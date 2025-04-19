<?php

declare(strict_types=1);

namespace App\Domains\Person\Dto;

readonly class PersonDto
{
    public function __construct(
        private string $remoteId,
        private string $name,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace App\Clients\Google;

use App\Domains\Person\Dto\PersonDto;

class PersonTransformer
{
    public function transformRecord(array $record): PersonDto
    {
        return new PersonDto(
            remoteId: $record['id'],
            name:$record['username'],
        );
    }
}

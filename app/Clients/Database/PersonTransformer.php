<?php

declare(strict_types=1);

namespace App\Clients\Database;

use App\Domains\Person\Dto\PersonDto;

class PersonTransformer
{
    public function transformRecord(array $record): PersonDto
    {
        return new PersonDto(
            remoteId: $record['some_identifier'],
            name: $record['name'],
        );
    }
}

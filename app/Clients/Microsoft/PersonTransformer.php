<?php

declare(strict_types=1);

use App\Domains\Person\Dto\PersonDto;

class PersonTransformer
{
    public function transformRecord(array $record): PersonDto
    {
        return new PersonDto(
            remoteId: $record['id'],
            name:$record['displayName'],
        );
    }
}

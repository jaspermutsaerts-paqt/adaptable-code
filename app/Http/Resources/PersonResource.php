<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Domains\License\Dto\LicenseDto;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin LicenseDto */
class PersonResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'remote_id' => $this->remoteId,
            'name'      => $this->name,
        ];
    }
}

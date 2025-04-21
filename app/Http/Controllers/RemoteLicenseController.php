<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\License\Clients\RemoteLicenseClientInterface;
use App\Http\Resources\LicenseResource;
use App\Models\Person;
use Illuminate\Http\Resources\Json\JsonResource;

class RemoteLicenseController extends Controller
{
    public function index(Person $person, RemoteLicenseClientInterface $client): JsonResource
    {
        $licenses = $client->getLicensesForPerson($person);

        return LicenseResource::collection($licenses);
    }
}

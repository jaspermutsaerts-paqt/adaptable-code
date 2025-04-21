<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\Person\Clients\RemotePersonClientInterface as ListRemotePersonClientInterface;
use App\Http\Resources\PersonResource;
use App\Models\Group;
use Illuminate\Http\Resources\Json\JsonResource;

class RemotePersonController extends Controller
{
    public function index(Group $group, ListRemotePersonClientInterface $client): JsonResource
    {
        $people = $client->getPeopleInGroup($group);

        return PersonResource::collection($people);
    }
}

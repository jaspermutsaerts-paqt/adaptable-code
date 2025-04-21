<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\Person\Clients\EditRemotePersonClientInterface;
use App\Domains\Person\Clients\ListRemotePersonClientInterface as ListRemotePersonClientInterface;
use App\Http\Resources\PersonResource;
use App\Models\Group;
use App\Models\Person;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class RemotePersonController extends Controller
{
    public function index(Group $group, ListRemotePersonClientInterface $client): JsonResource
    {
        $people = $client->getPeopleInGroup($group);

        return PersonResource::collection($people);
    }

    public function create(Person $person, EditRemotePersonClientInterface $client): Response
    {
        $client->createPerson($person);

        return response()->noContent(201);
    }

    public function update(Person $person, EditRemotePersonClientInterface $client): Response
    {
        $client->updatePerson($person);

        return response()->noContent();
    }

    public function delete(Person $person, EditRemotePersonClientInterface $client): JsonResponse
    {
        $deleted = $client->deletePerson($person);

        return response()->json([
            'deleted' => $deleted,
        ]);
    }
}

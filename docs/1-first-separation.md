
Perhaps you prefer to wrap the MS client because you want it to reflect our use case more instead of reflect a Graph API client.

```php
class RemotePersonController extends Controller
{
    public function index(Group $group, \App\Clients\Microsoft $client): Response {

        $accessToken = config('pretend-this-is-always-valid');

        /** @var Collection<\Microsoft\Graph\Model\User> $people */
        $users = $client->listUsersInGroup($accessToken, $group);
        $people = $users->pluck('displayName', 'id');

        return response()->view('person.index', ['people' => $people]);
    }
}
```



----
But now, let's say a requirement for connecting to Google instead of Microsoft is introduced, and (for this example) Google might not call them users.
Since we're looking for people not users, we can make interfaces use Person instead of User.
We don't need the conversion of users to people in the controller anymore, since the clients are responsible for that

```php
class RemotePersonController extends Controller
{
    public function index(Group $group, ClientInterface $client): Response {

        $people = $client->listPeopleInGroup($accessToken, $group);

        return response()->view('person.index', ['people' => $people]);
    }
}
```

```php
interface ClientInterface {

    /** @return PersonDto[] $people */
    public function listPeopleInGroup(string $accessToken, Group $group): array;
}

class \App\Clients\Microsoft implements ClientInterface { ... }
class \App\Clients\Google implements ClientInterface { ... }
```


```php
namespace App\Controllers;

use App\Models\Group;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class RemotePersonController extends Controller
{
    public function index(Group $group, \Microsoft\Graph\Graph $client): Response {

        $accessToken = // pretend-this-has-valid origin
        
        /** @var \Microsoft\Graph\Model\User[] $people */
        $users = $client->createRequest('GET', '/people?$filter=groupId eq ' . $group->remote_id) // pretend this is a valid filter
            ->setAccessToken($accessToken)
            ->setReturnType(\Microsoft\Graph\Model\User::class)
            ->execute();

        $people = collect($people)->pluck('displayName', 'id');

        return response()->view('people.index', ['people' => $people]);
    }
}
```

```php
class RemotePersonController extends Controller
{
    public function index(Group $group, \App\Clients\Microsoft $client): Response {

        $accessToken = config('pretend-this-is-always-valid');

        /** @var Collection<\Microsoft\Graph\Model\User> $people */
        $users = $client->listUsersInGroup($accessToken, $group);
        $people = $users->pluck('displayName', 'id');

        return response()->view('people.index', ['people' => $people]);
    }
}
```



----

Google is introduced, and (for this example) might not call them users.
Since we're looking voor people not users we can make the interfaces use Person instead of User.
We don't need the conversion of users to people in the controller anymore, since the clients are responsible for that

```php
class RemotePersonController extends Controller
{
    public function index(Group $group, ClientInterface $client): Response {

        $people = $client->listPeopleInGroup($accessToken, $group);

        return response()->view('people.index', ['people' => $people]);
    }
}
```

```php
interface ClientInterface {

    /** @return Collection<App\Dto\Person> $people */
    public function listPeopleInGroup(string $accessToken, Group $group): Collection;
}

class \App\Clients\Microsoft implements ClientInterface { ... }
class \App\Clients\Google implements ClientInterface { ... }
```

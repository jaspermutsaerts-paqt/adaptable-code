
# Example case

Let's say you have a view that will show you some people from a remote source filtered by some scope (a group, for this example).  
These people come from Microsoft.


```php
namespace App\Controllers;

use App\Models\Group;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class RemotePersonController extends Controller
{
    public function index(Group $group, \Microsoft\Graph\Graph $client): Response {

        $accessToken = // pretend-this-has-valid origin
        
        /** @var \Microsoft\Graph\Model\User[] $users */
        $users = $client->createRequest('GET', '/people?$filter=groupId eq ' . $group->remote_id) // pretend this is a valid filter
            ->setAccessToken($accessToken)
            ->setReturnType(\Microsoft\Graph\Model\User::class)
            ->execute();

        $people = collect($users)->pluck('displayName', 'id');

        return response()->view('person.index', ['people' => $people]);
    }
}
```

What can you think of that you would do differently than this implementation?
  
# Shoot.

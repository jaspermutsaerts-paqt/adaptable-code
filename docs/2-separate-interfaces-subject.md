
Licenses are introduced, so we add a license method to the client interfaace


```php
class RemoteLicenseController extends Controller
{
    public function index(App\Person $person, ClientInterface $client): Response {

        $licenses = $client->getLicensesForPerson($accessToken, $person);

        return response()->view('license.index', ['licenses' => $licenses]);
    }
}
```

```php
interface ClientInterface {

    /** @return App\Dto\Person[] $people */
    public function getPeopleInGroup(string $accessToken, Group $group): Collection;
     
     /** @return App\Dto\License[] $licenses */
    public function getLicensesForPerson(string $accessToken, Group $group): Collection;
}

class \App\Clients\Microsoft implements ClientInterface { ... }
class \App\Clients\Google implements ClientInterface { ... }
```


----

But, our customer using Google people uses Licences from AFAS
We actually don't have a case for Google Licenses at the moment.

So, we split them up per subject: 


```php
interface RemotePersonClientInterface {   
     /** @return App\Dto\License[] $licenses */
    public function getPeopleInGroup(string $accessToken, Group $group): Collection;
}

interface RemoteLicensesClientInterface {
     /** @return App\Dto\License[] $licenses */
    public function getLicensesForPerson(string $accessToken, Person $person): Collection;
}

class \App\Clients\Microsoft implements RemotePersonClientInterface, RemoteLicensesClientInterface  { ... }
class \App\Clients\Google implements RemotePersonClientInterface { ... }
class \App\Clients\Afas implements RemoteLicensesClientInterface { ... }
```

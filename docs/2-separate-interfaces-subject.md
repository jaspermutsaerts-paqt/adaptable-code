
Licenses are introduced, so we add a license method to the client interface


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

    /** @return PersonDto[] $people */
    public function getPeopleInGroup(string $accessToken, Group $group): array;
     
     /** @return LicenseDto[] $licenses */
    public function getLicensesForPerson(string $accessToken, Group $group): array;
}

class \App\Clients\Microsoft implements ClientInterface { ... }
class \App\Clients\Google implements ClientInterface { ... }
```


----

But, our customer using Google people uses Licences from AFAS.  
We actually don't have a case for Google Licenses at the moment.

So, we split them up per subject: 


```php
interface RemotePersonClientInterface {   
     /** @return LicenseDto[] $licenses */
    public function getPeopleInGroup(string $accessToken, Group $group): array;
}

interface RemoteLicensesClientInterface {
     /** @return LicenseDto[] $licenses */
    public function getLicensesForPerson(string $accessToken, Person $person): array;
}

class \App\Clients\Microsoft implements RemotePersonClientInterface, RemoteLicensesClientInterface  { ... }
class \App\Clients\Google implements RemotePersonClientInterface { ... }
class \App\Clients\Afas implements RemoteLicensesClientInterface { ... }
```

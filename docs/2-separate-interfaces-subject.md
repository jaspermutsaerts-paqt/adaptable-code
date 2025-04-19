
A concept called Licenses is introduced, so we add a license method to the client interface


```php
class RemoteLicenseController extends Controller
{
    public function index(App\Person $person, ClientInterface $client): Response {

        $licenses = $client->getLicensesForPerson($person);

        return response()->view('license.index', ['licenses' => $licenses]);
    }
}
```

```php
interface ClientInterface {

    /** @return PersonDto[] */
    public function getPeopleInGroup(Group $group): array;
     
     /** @return LicenseDto[] */
    public function getLicensesForPerson(Person $person): array;
}

class \App\Clients\Microsoft implements ClientInterface { ... }
class \App\Clients\Google implements ClientInterface { ... }
```


----

But, our customer using Google people uses Licenses from a different source, for example AFAS.  
We actually don't have a case for Google Licenses at the moment.

So, we split them up per subject: 


```php
interface RemotePersonClientInterface {   
    /** @return PersonDto[] */
    public function getPeopleInGroup(Group $group): array;
}

interface RemoteLicensesClientInterface {
     /** @return LicenseDto[] $licenses */
    public function getLicensesForPerson(Person $person): array;
}

class \App\Clients\Microsoft implements RemotePersonClientInterface, RemoteLicensesClientInterface  { ... }
class \App\Clients\Google implements RemotePersonClientInterface { ... }
class \App\Clients\Afas implements RemoteLicensesClientInterface { ... }
```

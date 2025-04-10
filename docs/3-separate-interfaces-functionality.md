
Jump in time, we have all remote CRUD methods now, so we have a controller like this

```php
class RemoteLicenseController extends Controller
{

    public function index(App\Person $person, RemotePersonClientInterface $client): Response { ... }
    
    public function create(): Response { .. }
    
    public function store(Request $request, RemotePersonClientInterface $client): Response {

        $accessToken = ...
        $licenseDto = $this->someTransformation($request); // just go with it
        ...
        $license = $client->createLicence($accessToken, $licenseDto);

        return response()->redirect('license.index');
    }
    
    public function edit(): Response { .. }
    public function update(Request $request, RemotePersonClientInterface $client): Response { .. }

}
```

We update our client interfaces accordingly:

```php
interface RemotePersonClientInterface {   
     
    public function createPerson(string $accessToken, App\Dto\Person $person): Person;
    
    public function updatePerson(string $accessToken, App\Dto\Person $person): bool;   
      
    public function deletePerson(string $accessToken, App\Dto\Person $person): bool;
    
    
    /** @return App\Dto\Person[] $people */
    public function getPeopleInGroup(string $accessToken, Group $group): Collection;
     
}

interface RemoteLicensesClientInterface {

    public function createLicense(string $accessToken, App\Dto\License $license): License;
    
    public function updateLicense(string $accessToken, App\Dto\License $license): bool;
    
    public function deleteLicense(string $accessToken, App\Dto\License $license): bool;    
          
    public function assignLicenseToPerson(string $accessToken, Person $person, App\Dto\License $license): bool;
    
    public function removeLicenseFromPerson(string $accessToken, Person $person, App\Dto\License $license): bool;
    
    /** @return App\Dto\License[] $licenses */
    public function getLicensesForPerson(string $accessToken, Person $person): Collection;
}
```

But, when we want to implement those methods, we realize we don't want to support CRUD methods for AFAS Licences, nor for Google People.
All customers using those, handle their updating outside of our application, not much sense writing support for it just to comply with the interfaces.

We can split up the interfaces for their specific use cases

```php
interface ListRemotePeopleClientInterface { 
    
    /** @return App\Dto\Person[] $people */
    public function getPeopleInGroup(string $accessToken, Group $group): Collection;
}

interface ListRemoteLicensesClientInterface {
    
    /** @return App\Dto\License[] $licenses */
    public function getLicensesForPerson(string $accessToken, Person $person): Collection;
}

interface EditRemotePersonClientInterface {

    public function createPerson(string $accessToken, App\Dto\Person $person): Person;
    
    public function updatePerson(string $accessToken, App\Dto\Person $person): bool;
        
    public function deletePerson(string $accessToken, App\Dto\Person $person): bool;
}

interface EditRemoteLicenseClientInterface {

    public function createLicense(string $accessToken, App\Dto\License $license): License;
    
    public function updateLicense(string $accessToken, App\Dto\License $license): bool;
    
    public function deleteLicense(string $accessToken, App\Dto\License $license): bool;
          
    public function assignLicenseToPerson(string $accessToken, Person $person, App\Dto\License $license): bool;
    
    public function removeLicenseFromPerson(string $accessToken, Person $person, App\Dto\License $license): bool;
}
```
Note: depending on the situation it's likely the Edit-version always needs to support Listing, so you could opt for  
`EditRemotePersonClientInterface extends ListRemotePeopleClientInterface`
For the purpose of this presentation they're considered as completed separate.


We make sure the supporting clients implement only what they support

```php
class \App\Clients\Microsoft implements
    ListRemotePeopleClientInterface,
    EditRemoteLicenseClientInterface,
    ListRemotePeopleClientInterface,
    EditRemoteLicenseClientInterface { ... }
    
    
class \App\Clients\Google implements RemotePersonClientInterface { ... }
class \App\Clients\Afas implements RemotePersonLicenseInterface { ... }
```


Controllers can fairly easily\* be updated

```php
class RemoteLicenseController extends Controller
{
    public function index(App\Person $person, ListRemoteLicensesClientInterface $client): Response { ... }
    public function create(): Response { ... }    
    public function edit(): Response { ... }
    public function update(Request $request, EditRemoteLicenseClientInterface $client): Response { ... }
}
```

```php
class RemoteLicenseController extends Controller
{
    public function index(App\Person $person, ListRemoteLicensesClientInterface $client): Response { ... }
    public function create(): Response { ... }    
    public function edit(): Response { ... }
    public function update(Request $request, EditRemoteLicenseClientInterface $client): Response { ... }
}
```

\* Some DI tomfoolery is required, that's for later


Jump in time, we have all remote CRUD methods now, so we have a controller like this

```php
class RemoteLicenseController extends Controller
{

    public function index(App\Person $person, RemoteLicenseClientInterface $client): Response { ... }
    
    public function create(): Response { .. }
    
    public function store(Request $request, RemoteLicenseClientInterface $client): Response {

        $licenseDto = $this->someTransformation($request); // just go with it
        ...
        $license = $client->createLicense($licenseDto);

        return response()->redirect('license.index');
    }
    
    public function edit(): Response { .. }
    public function update(Request $request, RemoteLicenseClientInterface $client): Response { .. }

}
```

We update our client interfaces accordingly:

```php
interface RemotePersonClientInterface {   
     
    public function createPerson(string PersonDto $person): Person;
    
    public function updatePerson(string PersonDto $person): bool;   
      
    public function deletePerson(string PersonDto $person): bool;
    
    
    /** @return PersonDto[] $people */
    public function getPeopleInGroup(string Group $group): array;
     
}

interface RemoteLicenseClientInterface {

    public function createLicense(string LicenseDto $license): License;
    
    public function updateLicense(string LicenseDto $license): bool;
    
    public function deleteLicense(string LicenseDto $license): bool;    
          
    public function assignLicenseToPerson(string Person $person, LicenseDto $license): bool;
    
    public function removeLicenseFromPerson(string Person $person, LicenseDto $license): bool;
    
    /** @return LicenseDto[] $licenses */
    public function getLicensesForPerson(string Person $person): array;
}
```

But, when we want to implement those methods, we realize we don't want to support CRUD methods for AFAS Licenses, nor for Google People.
All customers using those, handle their updating outside of our application, not much sense writing support for it just to comply with the interfaces.

We can split up the interfaces for their specific use cases

```php
interface ListRemotePersonClientInterface { 
    
    /** @return PersonDto[] $people */
    public function getPeopleInGroup(string Group $group): array;
}

interface ListRemoteLicenseClientInterface {
    
    /** @return LicenseDto[] $licenses */
    public function getLicensesForPerson(string Person $person): array;
}

interface EditRemotePersonClientInterface {

    public function createPerson(string PersonDto $person): Person;
    
    public function updatePerson(string PersonDto $person): bool;
        
    public function deletePerson(string PersonDto $person): bool;
}

interface EditRemoteLicenseClientInterface {

    public function createLicense(string LicenseDto $license): License;
    
    public function updateLicense(string LicenseDto $license): bool;
    
    public function deleteLicense(string LicenseDto $license): bool;
          
    public function assignLicenseToPerson(string Person $person, LicenseDto $license): bool;
    
    public function removeLicenseFromPerson(string Person $person, LicenseDto $license): bool;
}
```
Note: depending on the situation it's likely the Edit-version always needs to support Listing, so you could opt for  
`EditRemotePersonClientInterface extends ListRemotePersonClientInterface`
For the purpose of this presentation they're considered as completed separate.


We make sure the clients implement only what they support

```php
class \App\Clients\Microsoft implements
    ListRemotePersonClientInterface,
    EditRemotePersonClientInterface,
    ListRemoteLicenseClientInterface,
    EditRemoteLicenseClientInterface { ... }
    
    
class \App\Clients\Google implements ListRemotePersonClientInterface { ... }
class \App\Clients\Afas implements ListRemoteLicenseInterface { ... }
```


Controllers can fairly easily\* be updated

```php
class RemotePersonController extends Controller
{
    public function index(App\Person $person, ListRemotePersonClientInterface $client): Response { ... }
    
    public function create(): Response { ... }    
    
    public function store(Request $request, EditRemotePersonClientInterface $client): Response { ... }
    
    public function edit(): Response { ... }
    
    public function update(Request $request, EditRemotePersonClientInterface $client): Response { ... }
}
```

```php
class RemoteLicenseController extends Controller
{
    public function index(App\Person $person, ListRemoteLicenseClientInterface $client): Response { ... }
    
    public function create(): Response { ... }    
    
    public function store(Request $request, EditRemoteLicenseClientInterface $client): Response { ... }
    
    public function edit(): Response { ... }
     
    public function update(Request $request, EditRemoteLicenseClientInterface $client): Response { ... }
}
```

\* Some DI tomfoolery is required

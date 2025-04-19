
Jump in time, we have all remote CRUD methods now, so we have a controller like this

```php
class RemoteLicenseController extends Controller
{

    public function index(App\Person $person, RemotePersonClientInterface $client): Response { ... }
    
    public function create(): Response { .. }
    
    public function store(Request $request, RemotePersonClientInterface $client): Response {

        $licenseDto = $this->someTransformation($request); // just go with it
        ...
        $license = $client->createLicense($licenseDto);

        return response()->redirect('license.index');
    }
    
    public function edit(): Response { .. }
    public function update(Request $request, RemotePersonClientInterface $client): Response { .. }

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

interface RemoteLicensesClientInterface {

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
interface ListRemotePeopleClientInterface { 
    
    /** @return PersonDto[] $people */
    public function getPeopleInGroup(string Group $group): array;
}

interface ListRemoteLicensesClientInterface {
    
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

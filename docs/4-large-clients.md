Microsoft client supports all the features, so  it now looks like this

```php
namespace \App\Clients;

class Microsoft implements
    ListRemotePersonClientInterface,
    EditRemoteLicenseClientInterface,
    ListRemotePersonClientInterface,
    EditRemoteLicenseClientInterface { 
    
    public function getPeopleInGroup(string $accessToken, Group $group): array {
        ...
    }
    
    public function createPerson(string $accessToken, PersonDto $person): Person {
        ...
    }
    
    public function deletePerson(string $accessToken, PersonDto $person): bool {
        ...
    }
    
    public function updatePerson(string $accessToken, PersonDto $person): bool {
        ...
    }    
    
    public function createPerson(string $accessToken, PersonDto $person): Person {
        ...
    }
    
    public function deletePerson(string $accessToken, PersonDto $person): bool {
        ...
    }
    
    public function updatePerson(string $accessToken, PersonDto $person): bool {
        ...
    }    
    
    public function getLicensesForPerson(string $accessToken, Person $person): array {
        ...
    }    
    
    public function createLicense(string $accessToken, LicenseDto $license): License {
        ...
    }
    
    public function deleteLicense(string $accessToken, LicenseDto $license): bool {
        ...
    }
    
    public function updateLicense(string $accessToken, LicenseDto $license): boo {
        ...
    }
          
    public function assignLicenseToPerson(string $accessToken, Person $person, LicenseDto $license): bool {
        ...
    }
    
    public function removeLicenseFromPerson(string $accessToken, Person $person, LicenseDto $license): bool {
        ...
    }
}
```

You probably want to separate them as such:


```php
namespace \App\Clients\Microsoft;

class PersonClient implements
    ListRemotePeopleClientInterface,
    EditRemoteLicenseClientInterface { 
    
    public function getPeopleInGroup(string $accessToken, Group $group): array {
        ...
    }
    
    public function createPerson(string $accessToken, PersonDto $person): Person {
        ...
    }
    
    public function deletePerson(string $accessToken, PersonDto $person): bool {
        ...
    }
    
    public function updatePerson(string $accessToken, PersonDto $person): bool {
        ...
    }    
    
    public function createPerson(string $accessToken, PersonDto $person): Person {
        ...
    }
    
    public function deletePerson(string $accessToken, PersonDto $person): bool {
        ...
    }
    
    public function updatePerson(string $accessToken, PersonDto $person): bool {
        ...
    }    
}
```

```php
namespace \App\Clients\Microsoft;
  
class LicenseClient implements
    ListRemoteLicensesClientInterface,
    EditRemoteLicenseClientInterface { 
      
    public function getLicensesForPerson(string $accessToken, Person $person): array {
        ...
    }    
    
    public function createLicense(string $accessToken, LicenseDto $license): License {
        ...
    }
    
    public function deleteLicense(string $accessToken, LicenseDto $license): bool {
        ...
    }
    
    public function updateLicense(string $accessToken, LicenseDto $license): boo {
        ...
    }
          
    public function assignLicenseToPerson(string $accessToken, Person $person, LicenseDto $license): bool {
        ...
    }
    
    public function removeLicenseFromPerson(string $accessToken, Person $person, LicenseDto $license): bool {
        ...
    }
}
```

It should not need much change in any application code, only  (if any) in the Dependence Injection,
in other words in the Service Container setup. 

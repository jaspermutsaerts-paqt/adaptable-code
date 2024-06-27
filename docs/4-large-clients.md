Microsoft client supports all the features, so  it now looks like this

```php
namespace \App\Clients;

class Microsoft implements
    ListRemotePersonClientInterface,
    EditRemoteLicenseClientInterface,
    ListRemotePersonClientInterface,
    EditRemoteLicenseClientInterface { 
    
    public function getPeopleInGroup(string $accessToken, Group $group): Collection {
        ...
    }
    
    public function createPerson(string $accessToken, App\Dto\Person $person): Person {
        ...
    }
    
    public function deletePerson(string $accessToken, App\Dto\Person $person): bool {
        ...
    }
    
    public function updatePerson(string $accessToken, App\Dto\Person $person): bool {
        ...
    }    
    
    public function createPerson(string $accessToken, App\Dto\Person $person): Person {
        ...
    }
    
    public function deletePerson(string $accessToken, App\Dto\Person $person): bool {
        ...
    }
    
    public function updatePerson(string $accessToken, App\Dto\Person $person): bool {
        ...
    }    
    
    public function getLicensesForPerson(string $accessToken, Person $person): Collection {
        ...
    }    
    
    public function createLicense(string $accessToken, App\Dto\License $license): License {
        ...
    }
    
    public function deleteLicense(string $accessToken, App\Dto\License $license): bool {
        ...
    }
    
    public function updateLicense(string $accessToken, App\Dto\License $license): boo {
        ...
    }
          
    public function assignLicenseToPerson(string $accessToken, Person $person, App\Dto\License $license): bool {
        ...
    }
    
    public function removeLicenseFromPerson(string $accessToken, Person $person, App\Dto\License $license): bool {
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
    
    public function getPeopleInGroup(string $accessToken, Group $group): Collection {
        ...
    }
    
    public function createPerson(string $accessToken, App\Dto\Person $person): Person {
        ...
    }
    
    public function deletePerson(string $accessToken, App\Dto\Person $person): bool {
        ...
    }
    
    public function updatePerson(string $accessToken, App\Dto\Person $person): bool {
        ...
    }    
    
    public function createPerson(string $accessToken, App\Dto\Person $person): Person {
        ...
    }
    
    public function deletePerson(string $accessToken, App\Dto\Person $person): bool {
        ...
    }
    
    public function updatePerson(string $accessToken, App\Dto\Person $person): bool {
        ...
    }    
}
```

```php
namespace \App\Clients\Microsoft;
  
class LicenseClient implements
    ListRemoteLicencesClientInterface,
    EditRemoteLicenseClientInterface { 
      
    public function getLicensesForPerson(string $accessToken, Person $person): Collection {
        ...
    }    
    
    public function createLicense(string $accessToken, App\Dto\License $license): License {
        ...
    }
    
    public function deleteLicense(string $accessToken, App\Dto\License $license): bool {
        ...
    }
    
    public function updateLicense(string $accessToken, App\Dto\License $license): boo {
        ...
    }
          
    public function assignLicenseToPerson(string $accessToken, Person $person, App\Dto\License $license): bool {
        ...
    }
    
    public function removeLicenseFromPerson(string $accessToken, Person $person, App\Dto\License $license): bool {
        ...
    }
}
```

It should not need much change in any application code, only in DI setup (if any)

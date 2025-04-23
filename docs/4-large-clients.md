Microsoft client supports all the features, so  it now looks like this

```php
namespace \App\Clients;

class Microsoft implements
    ListRemotePersonClientInterface,
    EditRemoteLicenseClientInterface,
    ListRemotePersonClientInterface,
    EditRemoteLicenseClientInterface { 
    
    public function getPeopleInGroup(Group $group): array { ... }
    
    public function createPerson(PersonDto $person): Person { ... }
    
    public function deletePerson(PersonDto $person): bool { ... }
    
    public function updatePerson(PersonDto $person): bool { ... }    
    
    public function createPerson(PersonDto $person): Person { ... }
    
    public function deletePerson(PersonDto $person): bool { ... }
    
    public function updatePerson(PersonDto $person): bool { ... }    
    
    public function getLicensesForPerson(Person $person): array { ... }    
    
    public function createLicense(LicenseDto $license): License { ... }
    
    public function deleteLicense(LicenseDto $license): bool { ... }
    
    public function updateLicense(LicenseDto $license): bool { ... }
          
    public function assignLicenseToPerson(Person $person, LicenseDto $license): bool { ... }
    
    public function removeLicenseFromPerson(Person $person, LicenseDto $license): bool { ... }
}
```

That is one long class. You might want to separate this one client by subject:


```php
namespace \App\Clients\Microsoft;

class PersonClient implements
    ListRemotePersonClientInterface,
    EditRemoteLicenseClientInterface { 
    
    public function getPeopleInGroup(Group $group): array { ... }
    
    public function createPerson(PersonDto $person): Person { ... }
    
    public function deletePerson(PersonDto $person): bool { ... }
    
    public function updatePerson(PersonDto $person): bool { ... }    
    
    public function createPerson(PersonDto $person): Person { ... }
    
    public function deletePerson(PersonDto $person): bool { ... }
    
    public function updatePerson(PersonDto $person): bool { ... }    
}
```

```php
namespace \App\Clients\Microsoft;
  
class LicenseClient implements
    ListRemoteLicenseClientInterface,
    EditRemoteLicenseClientInterface { 
      
    public function getLicensesForPerson(Person $person): array { ... }    
    
    public function createLicense(LicenseDto $license): License { ... }
    
    public function deleteLicense(LicenseDto $license): bool { ... }
    
    public function updateLicense(LicenseDto $license): bool { ... }
          
    public function assignLicenseToPerson(Person $person, LicenseDto $license): bool { ... }
    
    public function removeLicenseFromPerson(Person $person, LicenseDto $license): bool { ... }
}
```

It should not need much change in any application code, only  (if any) in the Dependence Injection,
in other words in the Service Container setup. 

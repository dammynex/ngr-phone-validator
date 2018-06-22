#ngr-phone-validator
A PHP Libary to validate a nigerian phone number based on availabe public data.

It utilizes some very common data to check if a Nigerian phone number is valid.

It's very easy to setup and use.

```
composer require dammynex/ngr-phone-validator
```

**Validating a phone number without exceptions**
```php
use Brainex\Tools\PhoneValidator;

$phone = (new PhoneValidator())
                //Phone number to validate
                ->setPhoneNumber('+2349061668519')
                //We do not want exceptions
                ->setThrowExceptions(false)
                //Do validation
                ->validate();

if($phone->isValid()) {
    echo 'The phone number is valid';
}
```

**Validating a phone number using exceptions**
```php
use Brainex\Tools\PhoneValidator;
use Brainex\Exceptions\InvalidPhoneException;

try {
    $phone = (new PhoneValidator())
                ->setPhoneNumber('+2349061668519')
                ->validate();
} catch(InvalidPhoneException $e) {
    echo 'Invalid phone: ' . $e->getMessage();
}
```

When ```PhoneValidator::isValid()``` returns true, Other methods can be utilized.

Method | Description
------|-------------
__toString()| Returns the phone number
getInternationalFormat()|Returns the international format of the specified phone number (eg. +23349061668519)
getInternationalFormatWithoutPlusPrefix()|Returns the international format with the plus sign (eg. 2349061668519)
getLength()|Returns the length of the phone number
getLocalFormat()|Returns the local format of specified phone number (eg. 09061668519)
getNetwork()|Returns the phone number's network
getPhoneNumber()|Returns the raw (unedited) specified phone number
getThrowExceptions()|Returns whether validator is assigned to throw exceptions
isOfLength(int $length)|Returns whether length of phone number matches a valid phone number length from the ```Brainex\Tools\PhoneLengthParser``` class
isNetwork(string $network)|Returns whether the phone number's network matches the specified ```$network```. ```$network``` should be one from ```Brainex\Tools\PhoneNetworkParser```
isValid()|Returns whether phone number is valid
isValidLength()|Return whether phone's length is parsed and valid
setPhoneNumber(string $phone)|Assign phone number to validator
setThrowExceptions()|Assign whether exceptions should be thrown
toJson()|Return phone number's data in json string
validate()|Initialize validation for the phone number

- [x] Supports Major Networks

Todo: Support other networks
- [ ] Smile
- [ ] Ntel
- [ ] Spectranet

Feel free to contribute!!!
<?php

require_once '../vendor/autoload.php';

use Brainex\Tools\PhoneValidator;
use Brainex\Exceptions\InvalidPhoneException;

$validator = (new PhoneValidator())
                ->setPhoneNumber('091 6166 8519')
                ->setThrowExceptions(false)
                ->validate();

if($validator->isValid()) {
    var_dump($validator->toJson());
    echo 'Phone number is valid. =>> ' . $validator->getInternationalFormatWithoutPlusPrefix();
}
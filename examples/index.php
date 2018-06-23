<?php

require_once '../vendor/autoload.php';

use Brainex\Tools\PhoneValidator;
use Brainex\Exceptions\InvalidPhoneException;

$validator = (new PhoneValidator())
                ->setPhoneNumber('09061668519')
                ->setThrowExceptions(false)
                ->validate();

if($validator->isValid()) {
    echo 'Phone number is valid. =>> ' . $validator->getInternationalFormat();
}
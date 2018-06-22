<?php

require_once '../vendor/autoload.php';

use Brainex\Tools\PhoneValidator;
use Brainex\Exceptions\InvalidPhoneException;

$validator = (new PhoneValidator())
                ->setPhoneNumber('+2342061668519')
                ->setThrowExceptions(true)
                ->validate();

if($validator->isValid()) {
    echo 'Phone number is valid';
}
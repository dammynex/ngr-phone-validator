<?php

require_once './vendor/autoload.php';

use Brainex\Tools\PhoneValidator;
use Brainex\Tools\PhoneNetworkParser;

$validator = (new PhoneValidator())
                ->setPhoneNumber('+2349061668519')
                ->validate();

echo($validator->toJson());
<?php

use PHPUnit\Framework\TestCase;

use Brainex\Tools\PhoneValidator;
use Brainex\Tools\PhoneNetworkParser;

class PhoneNetworkParserTest extends TestCase
{   
    public function testNetworkIsMtn()
    {
        $validator = (new PhoneValidator())
                        ->setPhoneNumber('+2349061668519')
                        ->validate();
        
        $this->assertTrue($validator->isNetwork(PhoneNetworkParser::NETWORK_MTN));
    }

    public function testNetworkIsAirtel()
    {
        $validator = (new PhoneValidator())
                        ->setPhoneNumber('+2347016449102')
                        ->validate();
        
        $this->assertTrue($validator->isNetwork(PhoneNetworkParser::NETWORK_AIRTEL));
    }

    public function testNetworkIs9mobile()
    {
        $validator = (new PhoneValidator())
                        ->setPhoneNumber('+2349081021231')
                        ->validate();
        
        $this->assertTrue($validator->isNetwork(PhoneNetworkParser::NETWORK_9MOBILE));
    }

    public function testNetworkIsGlo()
    {
        $validator = (new PhoneValidator())
                        ->setPhoneNumber('+2348151222744')
                        ->validate();
        
        $this->assertTrue($validator->isNetwork(PhoneNetworkParser::NETWORK_GLO));
    }
}
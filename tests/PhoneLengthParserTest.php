<?php

use PHPUnit\Framework\TestCase;
use Brainex\Tools\PhoneValidator;
use Brainex\Tools\PhoneLengthParser;

class PhoneLengthParserTest extends TestCase
{
    private $_phone;

    public function setUp()
    {
        $this->_phone = new PhoneValidator();
    }

    public function testPhoneHasPlusPrefix()
    {
        $this->_phone->setPhoneNumber('+2349061668519');
        $parser = new PhoneLengthParser($this->_phone);
        $this->assertTrue($parser->hasPlusPrefix());
    }

    public function testPhoneHasNoPlusPrefix()
    {
        $this->_phone->setPhoneNumber('2349061668519');
        $parser = new PhoneLengthParser($this->_phone);
        $this->assertFalse($parser->hasPlusPrefix());
    }

    public function testPhoneHasCorrectCountryCode()
    {
        $this->_phone->setPhoneNumber('+2349061668519');
        $parser = new PhoneLengthParser($this->_phone);
        $this->assertTrue($parser->hasCorrectCountryCode());
    }

    public function testPhoneHasNoCorrectCountryCode()
    {
        $this->_phone->setPhoneNumber('+2291668519');
        $parser = new PhoneLengthParser($this->_phone);
        $this->assertFalse($parser->hasCorrectCountryCode());
    }
}
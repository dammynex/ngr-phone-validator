<?php

use PHPUnit\Framework\TestCase;
use Brainex\Tools\PhoneValidator;
use Brainex\Tools\PhoneLengthParser;

class PhoneValidatorTest extends TestCase
{

    private $validator;

    public function setUp()
    {
        $this->validator = new PhoneValidator();
    }

    public function testPhoneNumberCanSet()
    {
        $this->validator->setPhoneNumber('09061668519');
        $this->assertEquals($this->validator->getPhoneNumber(), '09061668519');
    }

    public function testPhoneNumberIsValid()
    {
        
    }

    public function testPhoneIsOfLocalLength()
    {
        $this->validator->setPhoneNumber('09061668519');
        $this->assertTrue($this->validator->isOfLength(PhoneLengthParser::PHONE_LENGTH_LOCAL));
    }

    public function testPhoneIsOfInternationalLength()
    {
        $this->validator->setPhoneNumber('+23409061668519');
        $this->assertTrue($this->validator->isOfLength(PhoneLengthParser::PHONE_LENGTH_INTERNATIONAL));
    }

    public function testPhoneIsInternationalWithNoPlusPrefix()
    {
        $this->validator->setPhoneNumber('23409061668519');
        $this->assertTrue($this->validator->isOfLength(PhoneLengthParser::PHONE_LENGTH_INTERNATIONAL_NO_PLUS));
    }

    public function testPhoneIsInternationalWithNoZeroPrefix()
    {
        $this->validator->setPhoneNumber('23409061668519');
        $this->assertTrue($this->validator->isOfLength(PhoneLengthParser::PHONE_LENGTH_INTERNATIONAL_NO_PREFIX_ZERO));
    }
}
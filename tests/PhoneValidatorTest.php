<?php

use PHPUnit\Framework\TestCase;
use Brainex\Tools\PhoneValidator;
use Brainex\Tools\PhoneLengthParser;
use Brainex\Exceptions\InvalidPhoneException;

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
        $this->validator->setPhoneNumber('+2349061668519')->validate();
        $this->assertTrue($this->validator->isValid());
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

    public function testSetThrowExceptions()
    {
        $validator = (new PhoneValidator())
                        ->setThrowExceptions(true);

        $this->assertTrue($validator->getThrowExceptions());
    }

    public function testSetThrowNoExceptions()
    {
        $validator = (new PhoneValidator())
                        ->setThrowExceptions(false);

        $this->assertFalse($validator->getThrowExceptions());
    }

    public function testParseInternationalPhoneLength()
    {
        $validator = (new PhoneValidator())
                        ->setThrowExceptions(false)
                        ->setPhoneNumber('+23409061668519')
                        ->validate();

        $this->assertTrue($validator->isValidLength());
        $this->assertEquals($validator->getLocalFormat(), '09061668519');
    }

    public function testParseInternationalPhoneWithNoPlusPrefix()
    {
        $validator = (new PhoneValidator())
                        ->setThrowExceptions(false)
                        ->setPhoneNumber('23409061668519')
                        ->validate();

        $this->assertTrue($validator->isValidLength());
        $this->assertEquals($validator->getLocalFormat(), '09061668519');
    }

    public function testParseInternationalPhoneWithNoPlusNoZeroPrefix()
    {
        $validator = (new PhoneValidator())
                        ->setThrowExceptions(false)
                        ->setPhoneNumber('2349061668519')
                        ->validate();

        $this->assertTrue($validator->isValidLength());
        $this->assertEquals($validator->getLocalFormat(), '09061668519');
    }

    public function testParseInternationalPhoneWithNoZeroPrefix()
    {
        $validator = (new PhoneValidator())
                        ->setThrowExceptions(false)
                        ->setPhoneNumber('+2349061668519')
                        ->validate();

        $this->assertTrue($validator->isValidLength());
        $this->assertEquals($validator->getLocalFormat(), '09061668519');
    }

    public function testReturnsFullInternationalPhone()
    {
        $validator = (new PhoneValidator())
                        ->setThrowExceptions(false)
                        ->setPhoneNumber('2349061668519')
                        ->validate();

        $this->assertEquals($validator->getInternationalFormat(), '+2349061668519');
    }

    public function testReturnsFullInternationalPhoneWithoutPlusPrefix()
    {
        $validator = (new PhoneValidator())
                        ->setThrowExceptions(false)
                        ->setPhoneNumber('+23409061668519')
                        ->validate();

        $this->assertEquals($validator->getInternationalFormatWithoutPlusPrefix(), '2349061668519');
    }

    public function testThrowsExceptionIfInvalidPhone()
    {
        $this->expectException(InvalidPhoneException::class);

        $validator = (new PhoneValidator())
                        ->setPhoneNumber('+2309668519')
                        ->validate();
    }
}
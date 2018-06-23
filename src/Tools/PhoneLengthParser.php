<?php

namespace Brainex\Tools;

use Brainex\Tools\PhoneValidator;
use Brainex\Exceptions\InvalidPhoneException;

class PhoneLengthParser
{
    /**
     * Internation phone number with full phone number
     *
     * @var integer
     */
    const PHONE_LENGTH_INTERNATIONAL = 15;

    /**
     * Internation phone number length without the "plus" sign prefix
     *
     * @var integer
     */
    const PHONE_LENGTH_INTERNATIONAL_NO_PLUS = 14;

    /**
     * International phone number without the preceeding zero but has the plus sign
     *
     * @var integer
     */
    const PHONE_LENGTH_INTERNATIONAL_NO_PREFIX_ZERO = 14;

    /**
     * Internation phone number without the "plus" sign prefix and without the preceeding zero
     * 
     * @var integer
     */
    const PHONE_LENGTH_INTERNATION_NO_PLUS_NO_PREFIX_ZERO = 13;

    /**
     * Local phone number length
     *
     * @var integer
     */
    const PHONE_LENGTH_LOCAL = 11;

    /**
     * The "plus" sign
     *
     * @var string
     */
    private $_plus = '+';

    /**
     * Phone number
     *
     * @var PhoneValidator
     */
    private $_phone;

    /**
     * Nigeria's country code
     *
     * @var integer
     */
    private $_country_code = '234';

    private $_raw_phone;

    /**
     * Class constructor
     *
     * @param PhoneValidator $phone Phone number
     */
    public function __construct(PhoneValidator $phone)
    {
        $this->_phone = $phone;
    }

    /**
     * Return full international number
     *
     * @return string
     */
    public function getInternationalPhone() : string
    {
        $raw = substr($this->getRawPhone(), 1);
        return $this->_plus . $this->_country_code . $raw;
    }

    /**
     * Return clean raw phone number
     *
     * @return string
     */
    public function getRawPhone() : string
    {
        return (string) $this->_raw_phone;
    }

    /**
     * Return value if phone number has plus prefix
     *
     * @return boolean
     */
    public function hasPlusPrefix() : bool
    {
        return substr($this->_phone->getPhoneNumber(), 0, 1) === $this->_plus;
    }

    /**
     * Return value if $phone has the right country code
     *
     * @return boolean
     */
    public function hasCorrectCountryCode() : bool
    {
        $phone = $this->_phone->getPhoneNumber();
        $specified_country_code = $this->hasPlusPrefix() ? substr($phone, 1, 3) : substr($phone, 0, 3);
        return $specified_country_code === $this->_country_code;
    }
    
    /**
     * Parse
     *
     * @throws InvalidPhoneException
     * @return boolean
     */
    public function parse()
    {

        $phone = $this->_phone;

        if($phone->isOfLength(self::PHONE_LENGTH_INTERNATIONAL)) {
            $this->_raw_phone = $this->parseInternationalPhone();
            return true;
        }

        if($phone->isOfLength(self::PHONE_LENGTH_INTERNATIONAL_NO_PLUS) && !$this->hasPlusPrefix()) {
            $this->_raw_phone = $this->parseInternationalPhoneWithNoPlusPrefix();
            return true;
        }

        if($phone->isOfLength(self::PHONE_LENGTH_INTERNATION_NO_PLUS_NO_PREFIX_ZERO)) {
            $this->_raw_phone = $this->parseInternationalPhoneWithNoPlusNoZeroPrefix();
            return true;
        }

        if($phone->isOfLength(self::PHONE_LENGTH_INTERNATIONAL_NO_PREFIX_ZERO)) {
            $this->_raw_phone = $this->parseInternationalPhoneWithNoZeroPrefix();
            return true;
        }

        if($phone->isOfLength(self::PHONE_LENGTH_LOCAL)) {
            $this->_raw_phone = $this->parseLocalPhone();
            return true;
        }

        return $this->throwParseError();
    }

    /**
     * Parse full international phone number
     *
     * @return string|bool
     */
    private function parseInternationalPhone()
    {
        if(!$this->hasCorrectCountryCode()) {
            return $this->throwParseError();
        }

        return substr($this->_phone, 4);
    }

    /**
     * Parse international phone number without plus prefix
     * eg. 23409061668519
     *
     * @return boolean|string
     */
    private function parseInternationalPhoneWithNoPlusPrefix()
    {
        if(!$this->hasCorrectCountryCode()) {
            return $this->throwParseError();
        }

        return substr($this->_phone, 3);
    }

    /**
     * Parse internation phone number without plus prefix
     * And without the preceeding zero in the main phone number
     * eg. 2349061668519
     *
     * @return boolean|string
     */
    private function parseInternationalPhoneWithNoPlusNoZeroPrefix()
    {
        if(!$this->hasCorrectCountryCode()) {
            return $this->throwParseError();
        }

        $dirty_phone = substr($this->_phone, 3);
        $raw_phone = '0' . $dirty_phone;

        if(strlen($raw_phone) !== self::PHONE_LENGTH_LOCAL) {
            return $this->throwParseError();
        }

        return $raw_phone;
    }

    /**
     * Parse internation phone number with plus and with no preceeding zero on the main phone number
     * eg. +2349061668519
     *
     * @return void
     */
    private function parseInternationalPhoneWithNoZeroPrefix()
    {
        if(!$this->hasCorrectCountryCode()) {
            return $this->throwParseError();
        }

        $dirty_phone = substr($this->_phone, 4);
        $raw_phone = '0' . $dirty_phone;

        if(strlen($raw_phone) !== self::PHONE_LENGTH_LOCAL) {
            return $this->throwParseError();
        }

        return $raw_phone;
    }

    /**
     * Parse local phone number
     *
     * @return string
     */
    private function parseLocalPhone()
    {
        return (string) $this->_phone;
    }

    private function throwParseError()
    {
        if(!$this->_phone->getThrowExceptions()) {
            return false;
        }

        throw new InvalidPhoneException('Unable to parse phone number, Invalid phone number detected');
    }
}
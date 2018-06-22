<?php

namespace Brainex\Tools;

use Brainex\Tools\PhoneValidator;

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

    public function parseInternationalPhoneNumber()
    {
        $phone = $this->_phone;
        $has_prefix = $this->hasPlusPrefix($phone);

        $this->_phone_is_valid = false;

        if(!$has_prefix) {
            return false;
        }

        if(!$this->hasCorrectCountryCode($phone, $has_prefix)) {
            return false;
        }

        $network = $this->validateNetwork();
    }
}
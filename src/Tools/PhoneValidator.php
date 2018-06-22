<?php

namespace Brainex\Tools;

use Brainex\Tools\PhoneLengthParser;
use SebastianBergmann\Diff\Parser;

class PhoneValidator
{
    /**
     * Phone number to validate
     *
     * @var string
     */
    private $_phone;

    /**
     * Set if phone number is valid
     *
     * @var boolean
     */
    private $_phone_is_valid = false;

    /**
     * Specified phone number's network
     *
     * @var integer
     */
    private $_phone_network = 0;

    /**
     * Parser
     *
     * @var PhoneLengthParser
     */
    private $_parser;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->_parser = new PhoneLengthParser($this);
    }

    public function __toString()
    {
        
    }

    public function getInternationalFormat()
    {

    }

    /**
     * Phone number length
     *
     * @return string
     */
    public function getLength()
    {
        return strlen($this->_phone);
    }

    public function getLocalFormat()
    {

    }

    /**
     * Return phone number 
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->_phone;
    }

    /**
     * Return value if phone number length matches
     *
     * @param integer $length Length to match
     * @return boolean
     */
    public function isOfLength(int $length)
    {
        return $this->getLength() === $length;
    }

    /**
     * Set and validate phone number
     *
     * @param string $phone Phone number to validate
     * @return self
     */
    public function setPhoneNumber(string $phone)
    {
        $this->_phone = $phone;
        $this->validate();
        return $this;
    }

    public function validate()
    {
        $this->_phone_is_valid = false;
        $phone_number_length = strlen($this->getPhoneNumber());

        if($this->isOfLength(PhoneLengthParser::PHONE_LENGTH_INTERNATIONAL)) {
            return $this->_parser->parseInternationalPhoneNumber();
        }
    }

    private function validateNetwork()
    {

    }
}
<?php

namespace Brainex\Tools;

use Brainex\Tools\PhoneLengthParser;
use SebastianBergmann\Diff\Parser;

class PhoneValidator
{
    //Networks
    const NETWORK_MTN = 'MTN';
    const NETWORK_AIRTEL = 'AIRTEL';
    const NETWORK_9MOBILE = '9MOBILE';
    const NETWORK_GLO = 'GLO';

    /**
     * Major phone number prefixes
     *
     * @see https://en.wikipedia.org/wiki/Telephone_numbers_in_Nigeria
     * @var array
     */
    private $prefixes = array(
        self::NETWORK_MTN => array(
            '0703',
            '0706',
            '0803',
            '0806',
            '0813',
            '0814',
            '0816',
            '0903'
        ),

        self::NETWORK_AIRTEL => array(
            '0701',
            '0708',
            '0802',
            '0808',
            '0812',
            '0902',
            '0907'
        ),

        self::NETWORK_GLO => array(
            '0705',
            '0805',
            '0807',
            '0811',
            '0815',
            '0905'
        ),

        self::NETWORK_9MOBILE => array(
            '0809',
            '0817',
            '0818',
            '0909',
            '0908'
        )
    );

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
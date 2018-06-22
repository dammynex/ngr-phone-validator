<?php

namespace Brainex\Tools;

class PhoneValidator
{
    /**
     * Phone number to validate
     *
     * @var string
     */
    private $_phone;

    /**
     * Set if phone number's length is valid
     *
     * @var boolean
     */
    private $_phone_length_is_parsed = false;

    /**
     * Set if phone number's network is valid
     *
     * @var boolean
     */
    private $_phone_network_is_passed = false;

    /**
     * Parser
     *
     * @var PhoneLengthParser
     */
    private $_parser;

    /**
     * Network parser
     *
     * @var PhoneNetworkParser
     */
    private $_network_parser;

    /**
     * Throw exceptions on error
     *
     * @var boolean
     */
    private $_throw_exceptions = true;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->_parser = new PhoneLengthParser($this);
        $this->_network_parser = new PhoneNetworkParser($this);
    }

    /**
     * Return phone number when treated as string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getPhoneNumber() ?? '';
    }

    /**
     * Return full international phone number
     *
     * @return string
     */
    public function getInternationalFormat() : string
    {
        return $this->_parser->getInternationalPhone();
    }
    
    /**
     * Return international phone number without plus prefix
     *
     * @return string
     */
    public function getInternationalFormatWithoutPlusPrefix() : string
    {
        return substr($this->getInternationalFormat(), 1);
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

    /**
     * Return phone number in local format
     *
     * @return string
     */
    public function getLocalFormat() : string
    {
        return $this->_parser->getRawPhone();
    }

    /**
     * Return phone number's network
     *
     * @return string
     */
    public function getNetwork() : string
    {
        return $this->_network_parser->getNetworkId();
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
     * Return value if class is set to throw exception
     *
     * @return bool
     */
    public function getThrowExceptions() : bool
    {
        return $this->_throw_exceptions;
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
     * Return value if network id is equal to $network_id
     *
     * @param string $network_id Network id
     * @return boolean
     */
    public function isNetwork(string $network_id)
    {
        return $this->_network_parser->getNetworkId() === $network_id;
    }

    /**
     * Return value if phone number is valid
     *
     * @return boolean
     */
    public function isValid() : bool
    {
        return $this->isValidLength() && $this->getNetwork();
    }

    /**
     * Return value if phone number's length is valid
     *
     * @return boolean
     */
    public function isValidLength()
    {
        return $this->_phone_length_is_parsed;
    }

    /**
     * Set and validate phone number
     *
     * @param string $phone Phone number to validate
     * @return self
     */
    public function setPhoneNumber(string $phone) : self
    {
        $this->_phone = $phone;
        return $this;
    }

    /**
     * Set whether exceptions should be thrown
     *
     * @param boolean $value
     * @return self
     */
    public function setThrowExceptions(bool $value) : self
    {
        $this->_throw_exceptions = $value;
        return $this;
    }

    /**
     * Return phone number data in json formT
     *
     * @return string
     */
    public function toJson()
    {
        $data = array(
            'phone' => $this->_phone,
            'validated' => [
                'local' => $this->getLocalFormat(),
                'intl' => $this->getInternationalFormat(),
                'intl_no_plus' => $this->getInternationalFormatWithoutPlusPrefix(),
                'network' => $this->getNetwork()
            ]
        );

        return json_encode($data);
    }

    /**
     * Validate phone number
     *
     * @return self
     */
    public function validate() : self
    {
        $this->_phone_length_is_parsed = $this->_parser->parse();
        $this->_phone_network_is_passed = $this->_network_parser->parse();
        return $this;
    }
}
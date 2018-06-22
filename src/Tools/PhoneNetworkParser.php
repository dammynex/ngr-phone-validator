<?php

namespace Brainex\Tools;

use Brainex\Tools\PhoneValidator;
use Brainex\Exceptions\InvalidPhoneException;

class PhoneNetworkParser
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
    private $_prefixes = array(
        self::NETWORK_MTN => array(
            '0703',
            '0706',
            '0803',
            '0806',
            '0813',
            '0814',
            '0816',
            '0903',
            '0906'
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
     * Phone number
     *
     * @var PhoneValidator
     */
    private $_phone;

    /**
     * Phone network id
     *
     * @var int
     */
    private $_network_id = '';

    /**
     * Class constructor
     *
     * @param PhoneValidator $phone Phone Number
     */
    public function __construct(PhoneValidator $phone)
    {
        $this->_phone = $phone;
    }

    /**
     * Return phone number prefix
     *
     * @return string
     */
    public function getPhoneNetworkPrefix() : string
    {
        return substr($this->_phone->getLocalFormat(), 0, 4);
    }

    /**
     * Phone number network's id
     *
     * @return string
     */
    public function getNetworkId() : string
    {
        return $this->_network_id;
    }

    /**
     * Parser phone number's network
     *
     * @return bool
     */
    public function parse()
    {
        $prefix = $this->getPhoneNetworkPrefix();
        $filter = array_filter($this->_prefixes, [$this, 'parseNetwork'], ARRAY_FILTER_USE_BOTH);
        return true;
    }

    /**
     * Parse netowrk loop
     *
     * @param [type] $network
     * @return void
     */
    private function parseNetwork($prefixes, $index)
    {
        
        if($this->getNetworkId()) {
            return;
        }

        if(!in_array($this->getPhoneNetworkPrefix(), $prefixes)) {
            return $this->throwError();
        }

        $this->_network_id = $index;

        return true;
    }

    /**
     * Return false if exceptions are disabled else throw invalid exception
     *
     * @throws InvalidPhoneException
     * @return false
     */
    private function throwError()
    {
        if(!$this->_phone->getThrowExceptions()) {
            return false;
        }

        throw new InvalidPhoneException('Unknown phone number network');
    }
}
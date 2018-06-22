<?php

namespace Brainex\Tools;

use Brainex\Tools\PhoneValidator;

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
     * Phone number
     *
     * @var PhoneValidator
     */
    private $_phone;

    /**
     * Class constructor
     *
     * @param PhoneValidator $phone Phone Number
     */
    public function __construct(PhoneValidator $phone)
    {
        $this->_phone = $phone;
    }
}
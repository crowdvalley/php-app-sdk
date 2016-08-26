<?php

namespace CrowdValley\Bundle\ClientBundle\Entity;

use CrowdValley\Bundle\ClientBundle\Entity\CVObject;

/**
 * BankDetail
 *
 */
class BankDetail extends CVObject
{

    public $bankAccountNumber;
    public $bankAddress;
    public $bankCountryCode;
    public $bankCurrency;
    public $bankName;
    public $bankRoutingNumber;
    public $bankSwiftCode;

}

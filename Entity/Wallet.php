<?php

namespace CrowdValley\Bundle\ClientBundle\Entity;

use CrowdValley\Bundle\ClientBundle\Entity\CVObject;

/**
 * Wallet
 *
 */
class Wallet extends CVObject
{
    public $user;
    public $balance;
    public $committedBalance;
    public $freeBalance;
    public $currency;
}

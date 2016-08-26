<?php

namespace CrowdValley\Bundle\ClientBundle\Entity;

use CrowdValley\Bundle\ClientBundle\Entity\CVObject;

/**
 * Payout
 *
 */
class Payout extends CVObject
{
    public $investment;
    public $dueDate;
    public $payoutAmount;
    public $minimumPayment;
    public $currency;
    public $payoutType;
    public $additionalType;
    public $lateFee;
    public $serviceCharge;
    public $chargeOffs;
    public $netRecoveries;
    public $transactionsPaid;
    public $paidAt;
    public $netAnnualizedReturn;
    public $custom;
}

<?php

namespace CrowdValley\Bundle\ClientBundle\Entity;

use CrowdValley\Bundle\ClientBundle\Entity\CVObject;

/**
 * Transaction
 *
 */
class Transaction extends CVObject
{
    public $wallet;
    public $user;
    public $userName;
    public $transactionDescription;
    public $transactionAmount;
    public $transactionCurrency;
    public $paymentStatus;
    public $paymentService;
    public $payout;
    public $originalTransactionAmount;
    public $originalTransactionCurrency;
    public $paymentServiceLogId;
    public $confirmationNumber;
}
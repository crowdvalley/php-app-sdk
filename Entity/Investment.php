<?php

namespace CrowdValley\Bundle\ClientBundle\Entity;

use CrowdValley\Bundle\ClientBundle\Entity\CVObject;

/**
 * Investment
 *
 */
class Investment extends CVObject
{     
    const INVESTMENT_LIFECYCLESTAGE_OPEN = 0;
    const INVESTMENT_LIFECYCLESTAGE_REJECTED = 1;
    const INVESTMENT_LIFECYCLESTAGE_APPROVED = 2;
    const INVESTMENT_LIFECYCLESTAGE_WITHDRAWN = 3;
    const INVESTMENT_LIFECYCLESTAGE_SETTLED = 4;
    
    public $capitalOutstanding;
    public $currency;
    public $custom;
    public $divestedAmount;
    public $divestedShares;
    public $interestRate;
    public $investmentAmount;
    public $isLoanbook;
    public $lifeCycleStage;
    public $numberOfShares;
    public $offering;
    public $offeringId;
    public $organization;
    public $organizationId;
    public $organizationName;
    public $repaymentsRemaining;
    public $settledAt;
    public $term;
    public $user;
    public $userEmail;
    public $userId;
    public $userName;
    public $visibility;
}

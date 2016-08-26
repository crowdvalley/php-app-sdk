<?php

namespace CrowdValley\Bundle\ClientBundle\Entity;

use CrowdValley\Bundle\ClientBundle\Entity\CVObject;

/**
 * Offering
 *
 */
class Offering extends CVObject
{     
    const OFFERING_LIFECYCLESTAGE_DRAFT = 0;
    const OFFERING_LIFECYCLESTAGE_SUBMITTED = 1;
    const OFFERING_LIFECYCLESTAGE_REJECTED = 2;
    const OFFERING_LIFECYCLESTAGE_APPROVED = 3;
    const OFFERING_LIFECYCLESTAGE_RESTRICTED = 4;
    const OFFERING_LIFECYCLESTAGE_PUBLISHED = 5;
    const OFFERING_LIFECYCLESTAGE_LIVE = 6;
    const OFFERING_LIFECYCLESTAGE_CLOSING = 7;
    const OFFERING_LIFECYCLESTAGE_SETTLED = 8;
    const OFFERING_LIFECYCLESTAGE_CANCELLED = 9;
    
    public $additionalType;
    public $amountRaised;
    public $capitalOutstanding;
    public $category;
    public $closeDate;
    public $creditScore;
    public $currency;
    public $custom;
    public $equityOffered;
    public $externalCommitments;
    public $fundingGoal;
    public $gcenClientId;
    public $interestRate;
    public $investmentCount;
    public $investorCount;
    public $isFeatured;
    public $isSecondaryOffering;
    public $lifeCycleStage;
    public $loanToValue;
    public $mangopayWalletId;
    public $maximumCommitment;
    public $maximumOverfundingAmount;
    public $minimumCommitment;
    public $name;
    public $numberOfShares;
    public $offeringDescription;
    public $openDate;
    public $organization;
    public $organizationId;
    public $pricePerShare;
    public $primaryOfferingId;
    public $raisedPercent;
    public $repaymentsRemaining;
    public $term;
    public $user;
    public $userId;
    public $valuation;
}

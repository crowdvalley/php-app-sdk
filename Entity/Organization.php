<?php

namespace CrowdValley\Bundle\ClientBundle\Entity;

use CrowdValley\Bundle\ClientBundle\Entity\CVObject;

/**
 * Organization
 *
 */
class Organization extends CVObject
{ 
    const ORGANIZATION_LIFECYCLESTAGE_DRAFT = 0;
    const ORGANIZATION_LIFECYCLESTAGE_SUBMITTED = 1;
    const ORGANIZATION_LIFECYCLESTAGE_REJECTED = 2;
    const ORGANIZATION_LIFECYCLESTAGE_APPROVED = 3;
    const ORGANIZATION_LIFECYCLESTAGE_RESTRICTED = 4;
    const ORGANIZATION_LIFECYCLESTAGE_PUBLISHED = 5;
    const ORGANIZATION_LIFECYCLESTAGE_ARCHIVED = 6;
    const ORGANIZATION_LIFECYCLESTAGE_CANCELED = 7;
    
    const ORGANIZATION_VISIBILITY_FULL = 0;
    const ORGANIZATION_VISIBILITY_ANONYMOUS = 1;
    const ORGANIZATION_VISIBILITY_HIDDEN = 2;
        
    public $additionalType;
    public $address;
    public $alternateName;
    public $briefDescription;
    public $companyNumber;
    public $contactPoint;
    public $creditScore;
    public $custom;
    public $detailedDescription;
    public $displayName;
    public $facebook;
    public $foundingDate;
    public $foundingLocation;
    public $legalName;
    public $lifeCycleStage;
    public $linkedin;
    public $location;
    public $logo;
    public $mangopayUserId;
    public $mangopayWalletId;
    public $mangopayCardId;
    public $members;
    public $organizationEmail;
    public $sector;
    public $taxId;
    public $telephone;
    public $twitter;
    public $user;
    public $userId;
    public $visibility;
    public $website;
    public $youtube;  
}

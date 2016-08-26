<?php

namespace CrowdValley\Bundle\ClientBundle\Entity;

use CrowdValley\Bundle\ClientBundle\Entity\CVObject;
use CrowdValley\Bundle\ClientBundle\Entity\Document;

/**
 * User
 *
 */
class User extends CVObject
{ 
    const USER_VISIBILITY_OPEN = 0;
    const USER_VISIBILITY_HIDDEN = 1;
    const USER_VISIBILITY_ANONYMOUS = 2;
    
    public function __construct()
    {
        parent::__construct();
	
		$this->additionalType = '';    
		$this->affiliateCode = '';    
		$this->biography = '';    
		$this->email = '';    
		$this->externalReferenceId = '';    
		$this->familyName = '';    
		$this->fullName = '';    
		$this->givenName = '';    
		$this->honorificPrefix = '';
		$this->honorificSuffix = '';    
		$this->isAdmin = false;
		$this->isVip = false;
		$this->jobTitle = '';    
		$this->location = '';    
		$this->phone1 = '';    
		$this->phone2 = '';    
		$this->referralCode = '';    
		$this->sector = '';    
		$this->tagline = '';    
		$this->timeZone = '';    
		$this->visibility = $this::USER_VISIBILITY_OPEN;    
		$this->website = '';    
    }
    
    public $additionalType;
    public $affiliateCode;
    public $biography;
    public $custom;
    public $documents;
    public $email;
    public $externalReferenceId;
    public $familyName;
    public $fullName;
    public $givenName;
    public $honorificPrefix;
    public $honorificSuffix;
    public $image;
    public $isAdmin;
    public $isVip;
    public $jobTitle;
    public $location;
    public $organizations;
    public $phone1;
    public $phone2;
    public $referralCode;
    public $sector;
    public $tagline;
    public $timeZone;
    public $visibility;
    public $website;
}

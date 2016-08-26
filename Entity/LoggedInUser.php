<?php

namespace CrowdValley\Bundle\ClientBundle\Entity;

use CrowdValley\Bundle\ClientBundle\Entity\User;

/**
 * LoggedInUser
 *
 */
class LoggedInUser extends User
{     
    public $address;
    public $addresses;
    public $bankAccounts;
    public $birthDate;
    public $birthPlace;
    public $drivingLicenseNumber;
    public $emailVerified;
    public $gbgPassId;
    public $gcenClientId;
    public $hasBeenApproved;
    public $hasBeenBlocked;
    public $incomeRange;
    public $lastLoginAt;
    public $mangopayCardId;
    public $mangopayUserId;
    public $passportCountry;
    public $passportExpiry;
    public $passportNumber;
    public $passwordExpired;
    public $phoneVerified;
    public $registrationComplete;
    public $taxId;
    public $termsOfServiceAccepted; 
}

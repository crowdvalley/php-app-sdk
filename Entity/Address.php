<?php

namespace CrowdValley\Bundle\ClientBundle\Entity;

use CrowdValley\Bundle\ClientBundle\Entity\CVObject;

/**
 * Address
 *
 */
class Address extends CVObject
{
    public $addressLocality;
    public $building;
    public $city;
    public $country;
    public $postalCode;
    public $region;
    public $streetAddress;
}

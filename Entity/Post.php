<?php

namespace CrowdValley\Bundle\ClientBundle\Entity;

use CrowdValley\Bundle\ClientBundle\Entity\CVObject;

/**
 * Post
 *
 */
class Post extends CVObject
{
    public $body;
    public $user;
    public $userName;
}

<?php

namespace CrowdValley\Bundle\ClientBundle\Entity;

use CrowdValley\Bundle\ClientBundle\Entity\CVObject;

/**
 * Comment
 *
 */
class Comment extends CVObject
{
    public $body;
    public $user;
    public $userName;
}

<?php

namespace CrowdValley\Bundle\ClientBundle\Entity;

use CrowdValley\Bundle\ClientBundle\Entity\CVObject;

/**
 * Document
 *
 */
class Document extends CVObject
{     
    public $fileAlias;
    public $fileDescription;
    public $fileName;
    public $fileType;
    public $groupId;
    public $lifeCycleStage;
    public $sourceType;
    public $tag;
    public $url;
    public $user;
}

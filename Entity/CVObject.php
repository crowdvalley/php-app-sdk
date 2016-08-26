<?php

namespace CrowdValley\Bundle\ClientBundle\Entity;

/**
 * CVObject
 *
 */
class CVObject
{
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();

	}
	
    public $id;
    
    public $createdAt;
    
    public $updatedAt;
        
    public $author;
}

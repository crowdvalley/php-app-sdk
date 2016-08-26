<?php

namespace CrowdValley\Bundle\ClientBundle\Entity;

/**
 * CVList
 *
 */
class CVList
{
    public function __construct()
    {
		$this->offset = 0;
		$this->limit = 0;
		$this->count = 0;
		$this->objects = [];
	}

    public $offset;
    
    public $limit;
    
    public $count;
        
    public $objects;
        
}

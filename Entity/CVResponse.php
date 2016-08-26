<?php

namespace CrowdValley\Bundle\ClientBundle\Entity;

/**
 * CVResponse
 *
 */
class CVResponse
{
    const RESPONSE_OUTCOME_SUCCESS = 'success';
    const RESPONSE_OUTCOME_EXCEPTION = 'error';
    const RESPONSE_OUTCOME_UNKNOWN = 'unknown';
    
    public function __construct()
    {
		$this->outcome = $this::RESPONSE_OUTCOME_UNKNOWN;
    }
    
    public $outcome;
    
    public $object;
    
    public $objectList;
        
    public $exception;
    
}

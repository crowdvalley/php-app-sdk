<?php

namespace CrowdValley\Bundle\ClientBundle\Utility;
use Guzzle\Http\Exception\BadResponseException;

class ApiManager
{	
    /**
     *
     */
    public function sendRequest($request)
    {
        $responseBody = "";

        try {
            $response = $request->send();
            $responseBody = $response->getBody();
        } catch (BadResponseException $e) {
            if ($e->getResponse()) {
                $responseBody = $e->getResponse()->getBody();
            }
        }

        $responseArray = json_decode($responseBody, true);
        
        return $responseArray;	    
    }    
}

<?php

namespace CrowdValley\Bundle\ClientBundle\Service;

use CrowdValley\Bundle\AuthBundle\Service\PublicService as BasePublicService;
use CrowdValley\Bundle\ClientBundle\Entity\CVResponse;
use CrowdValley\Bundle\ClientBundle\Entity\CVException;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Session\Session;

class AuthenticateService extends BasePublicService {

    public function __construct($container, $end_point, $api_key, $api_secret, Session $session)
    {
        parent::__construct($container, $end_point, $api_key, $api_secret, $session);
        $this->network = $this->session->get('cv_network') ? $this->session->get('cv_network') : $this->container->getParameter('cv_network');
    }

    /**
     *
     */
    public function login($email, $password)
    {
        $client = $this->container->get('client');
        
        $responseArray = $this->authenticate($this->network, $email, $password);
            
        $cvResponse = new CVResponse();

        if (!empty($responseArray['outcome']) && $responseArray['outcome'] == 'success') {

            $cvResponse->outcome = CVResponse::RESPONSE_OUTCOME_SUCCESS;
        }

        else {

            $cvResponse->outcome = CVResponse::RESPONSE_OUTCOME_EXCEPTION;

            $exception = new CVException();
            $exception->http_status = $responseArray['status'];
            $exception->code = $responseArray['data']['code'];
            $exception->userMessage = 'Unable to log in';
            $exception->developerMessage = 'Unable to log in';

            $cvResponse->exception = $exception;
        }
        
        return $cvResponse;
    }
}





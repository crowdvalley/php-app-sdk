<?php

namespace CrowdValley\Bundle\ClientBundle\Service;

use CrowdValley\Bundle\AuthBundle\Service\UserService as BaseUserService;
use CrowdValley\Bundle\ClientBundle\Utility\ApiManager;
use CrowdValley\Bundle\ClientBundle\Utility\DataConverter;
use CrowdValley\Bundle\ClientBundle\Entity\CVResponse;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Session\Session;

class ReykerService extends BaseUserService {

    private $apiManager;
    private $dataConverter;

    public function __construct($container, $end_point, Session $session, ApiManager $apiManager, DataConverter $dataConverter)
    {
        $this->container = $container;
        $this->end_point = $end_point;
        $this->session = $session;
        $this->network = $this->session->get('cv_network') ? $this->session->get('cv_network') : $this->container->getParameter('cv_network');
        $this->apiManager = $apiManager;
        $this->dataConverter = $dataConverter;

    }

    /**
     *
     */
    public function selfReykerRegister()
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/' . $this->network . '/self/reyker/register', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForReykerRegister($responseArray);

        return $cvResponse;
    }
    
    /**
     *
     */
    public function getReykerProfile()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/self/reyker', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForReykerProfile($responseArray);

        return $cvResponse;
    }    
    
    /**
     *
     */
    public function getReykerPortfolio()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/self/reyker/plans', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForReykerPortfolio($responseArray);

        return $cvResponse;
    }        
}
<?php

namespace CrowdValley\Bundle\ClientBundle\Service;

use CrowdValley\Bundle\AuthBundle\Service\UserService as BaseUserService;
use CrowdValley\Bundle\ClientBundle\Utility\ApiManager;
use CrowdValley\Bundle\ClientBundle\Utility\DataConverter;
use CrowdValley\Bundle\ClientBundle\Entity\CVResponse;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Session\Session;

class VeriduService extends BaseUserService {

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
     * Register new user with Veridu
     *
     */
    public function selfRegisterVeriduUser()
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/' . $this->network . '/self/veridu/profile', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }

    /**
     * Get Veridu user profile details
     *
     */
    public function getSelfVeriduUserProfile()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/self/veridu/profile', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForSelfVeriduUserProfile($responseArray);

        return $cvResponse;
    }

    /**
     * Create an OTP using sms for this user
     *
     */
    public function selfSendPhoneVerificationMessage()
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/' . $this->network . '/self/veridu/sendPhoneVerificationMessage', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }

    /**
     * Verify an OTP using sms for this user
     *
     */
    public function selfVerifyPhoneVerificationMessage()
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/' . $this->network . '/self/veridu/verifyPhoneMessage', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }

    /**
     * Run background check for this user
     *
     */
    public function selfVeriduBackgroundCheck()
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/' . $this->network . '/self/veridu/backgroundCheck', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForSelfBackgroundCheck($responseArray);

        return $cvResponse;
    }


}
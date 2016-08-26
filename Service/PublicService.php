<?php

namespace CrowdValley\Bundle\ClientBundle\Service;

use CrowdValley\Bundle\AuthBundle\Service\PublicService as BasePublicService;
use CrowdValley\Bundle\ClientBundle\Utility\ApiManager;
use CrowdValley\Bundle\ClientBundle\Utility\DataConverter;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Session\Session;

class PublicService extends BasePublicService {

    private $apiManager;
    private $dataConverter;
    
    public function __construct($container, $end_point, $api_key, $api_secret, Session $session, ApiManager $apiManager, DataConverter $dataConverter)
    {
        parent::__construct($container, $end_point, $api_key, $api_secret, $session);

        $this->network = $this->session->get('cv_network') ? $this->session->get('cv_network') : $this->container->getParameter('cv_network');
        $this->apiManager = $apiManager;
        $this->dataConverter = $dataConverter;
    }

    /**
     *
     */
    public function getUsers()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/public/users', ['cv-auth' =>$this->container->get('user')->getTokenNewUser()]);
        
        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForUsers($responseArray);
        
        return $cvResponse;
    }
    
    /**
     *
     */
    public function getOrganizations()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/public/organizations', ['cv-auth' =>$this->container->get('user')->getTokenNewUser()]);
        
        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForOrganizations($responseArray);
        
        return $cvResponse;
    }    

    /**
     *
     */
    public function getOrganizationWithId($organizationId)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/public/organizations/'.$organizationId, ['cv-auth' =>$this->container->get('user')->getTokenNewUser()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForOrganization($responseArray);

        return $cvResponse;
    }
    
    /**
     *
     */
    public function getFeaturedOfferings()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/public/featuredOfferings', ['cv-auth' =>$this->container->get('user')->getTokenNewUser()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForOfferings($responseArray);

        return $cvResponse;
    }        
    
    /**
     *
     */
    public function getOfferings()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/public/offerings', ['cv-auth' =>$this->container->get('user')->getTokenNewUser()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForOfferings($responseArray);

        return $cvResponse;
    }        
    
    /**
     *
     */
    public function getOfferingWithId($offeringId)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/public/offerings/'.$offeringId, ['cv-auth' =>$this->container->get('user')->getTokenNewUser()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForOffering($responseArray);

        return $cvResponse;
    }
    
    /**
     *
     */
    public function verifyEmail($userId, $secret)
    {
        $client = $this->container->get('client');        
        $request = $client->post('v1/'.$this->network.'/self/verifyEmail', ['cv-auth' =>$this->container->get('user')->getTokenNewUser()]);

		$parameters = [
			'user_id' => $userId, 
			'secret' => $secret
        ];
			
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }    
    
    /**
     *
     */
    public function forgotPassword($url, $email)
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/'.$this->network.'/self/forgotPassword', ['cv-auth' =>$this->container->get('user')->getTokenNewUser()]);

		$parameters = [
			'url' => $url, 
			'email' => $email
		];
			
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }    

    /**
     *
     */
    public function resetPassword($userId, $secret, $password, $passwordConfirm)
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/'.$this->network.'/self/resetPassword', ['cv-auth' =>$this->container->get('user')->getTokenNewUser()]);

		$parameters = [
			'user_id' => $userId, 
			'secret' => $secret,
			'password' => $password,
			'password_confirm' => $passwordConfirm
		];
			
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }  

    /**
     *
     */
    public function newsletterSignUp($email)
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/'.$this->network.'/self/newsletterSignUp', ['cv-auth' =>$this->container->get('user')->getTokenNewUser()]);

		$parameters = [
			'email' => $email
		];
			
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }

    /**
     *
     */
    public function getPublicStats()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/public/stats', ['cv-auth' =>$this->container->get('user')->getTokenNewUser()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForStats($responseArray);

        return $cvResponse;
    }
}



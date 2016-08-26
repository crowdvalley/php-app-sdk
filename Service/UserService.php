<?php

namespace CrowdValley\Bundle\ClientBundle\Service;

use CrowdValley\Bundle\AuthBundle\Service\UserService as BaseUserService;
use CrowdValley\Bundle\ClientBundle\Utility\ApiManager;
use CrowdValley\Bundle\ClientBundle\Utility\DataConverter;
use CrowdValley\Bundle\ClientBundle\Entity\User;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Session\Session;

class UserService extends BaseUserService
{
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
    public function createUser($email, $password, $url, $additionalData = [])
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/'.$this->network.'/users', ['cv-auth' =>$this->container->get('user')->getTokenNewUser()]);
        
		$parameters = array_merge(array('email' => $email, 'password' => $password, 'url' => $url), $additionalData);
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');      

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);
        
        return $cvResponse;
    }     

    /**
     *
     */
    public function getUsers()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/users', $this->getToken());
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

        $cvResponse = new CVResponse();

        if (!empty($responseArray['outcome']) && $responseArray['outcome'] == 'success') {

            $cvResponse->outcome = CVResponse::RESPONSE_OUTCOME_SUCCESS;

            $cvResponse->objectList = $this->convertListArrayToUsers($responseArray['data']['list']);
        }

        else if ($responseArray['outcome'] == 'error') {

            $cvResponse->outcome = CVResponse::RESPONSE_OUTCOME_EXCEPTION;

            $exception = new CVException();
            $exception->http_status = $responseArray['status'];
            $exception->code = $responseArray['data']['code'];
            $exception->userMessage = $responseArray['data']['user_message'];
            $exception->developerMessage = $responseArray['data']['developer_message'];

            $cvResponse->exception = $exception;
        }

        return $cvResponse;
    }    
    
    /**
     *
     */
    public function getUserWithId($user_id)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/'.$this->network.'/users/'.$user_id, $this->getToken());
        $responseBody = '';
        try
        {
            $response = $request->send();
            $responseBody= $response->getBody();
        }
        catch(BadResponseException $e)
        {
            if ($e->getResponse())
                $responseBody =  $e->getResponse()->getBody();
        }

        $responseArray = json_decode($responseBody, true);

        $cvResponse = new CVResponse();

        if (!empty($responseArray['outcome']) && $responseArray['outcome'] == 'success') {

            $cvResponse->outcome = CVResponse::RESPONSE_OUTCOME_SUCCESS;
            $cvResponse->object = $this->convertArrayToUser($responseArray['data']['user']);
        }

        else if (!empty($responseArray['outcome']) && $responseArray['outcome'] == 'error')
        {
            $exception = new CVException();
            $exception->http_status = $responseArray['status'];
            $exception->code = $responseArray['data']['code'];
            $exception->userMessage = $responseArray['data']['user_message'];
            $exception->developerMessage = $responseArray['data']['developer_message'];

            $cvResponse->outcome = CVResponse::RESPONSE_OUTCOME_ERROR;
            $cvResponse->exception = $exception;
        }

        return $cvResponse;
    }    
    
    /**
     *
     */
    public function getInvestmentsForUserWithId($user_id)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/'.$this->network.'/users/'.$user_id.'/investments', $this->getToken());
        $responseBody = '';
        try
        {
            $response = $request->send();
            $responseBody= $response->getBody();
        }
        catch(BadResponseException $e)
        {
            if ($e->getResponse())
                $responseBody =  $e->getResponse()->getBody();
        }

        $responseArray = json_decode($responseBody, true);

        $cvResponse = new CVResponse();

        if (!empty($responseArray['outcome']) && $responseArray['outcome'] == 'success') {

            $cvResponse->outcome = CVResponse::RESPONSE_OUTCOME_SUCCESS;
            $cvResponse->objectList = $this->convertListArrayToInvestments($responseArray['data']['list']);
        }

        else if (!empty($responseArray['outcome']) && $responseArray['outcome'] == 'error')
        {
            $exception = new CVException();
            $exception->http_status = $responseArray['status'];
            $exception->code = $responseArray['data']['code'];
            $exception->userMessage = $responseArray['data']['user_message'];
            $exception->developerMessage = $responseArray['data']['developer_message'];

            $cvResponse->outcome = CVResponse::RESPONSE_OUTCOME_ERROR;
            $cvResponse->exception = $exception;
        }

        return $cvResponse;
    }

    /**
     *
     */
    public function getOfferingsForUserWithId(User $user)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/users/'.$user->id.'/offerings', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForOfferings($responseArray);

        return $cvResponse;
    }
}
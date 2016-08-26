<?php

namespace CrowdValley\Bundle\ClientBundle\Service;

use CrowdValley\Bundle\AuthBundle\Service\UserService as BaseUserService;
use CrowdValley\Bundle\ClientBundle\Utility\ApiManager;
use CrowdValley\Bundle\ClientBundle\Utility\DataConverter;
use CrowdValley\Bundle\ClientBundle\Entity\Offering;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Session\Session;

class OfferingService extends BaseUserService
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
    public function getOfferings()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/offerings', ['cv-auth' =>$this->container->get('user')->getToken()]);

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
        $request = $client->get('v1/' . $this->network . '/offerings/'.$offeringId, ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForOffering($responseArray);

        return $cvResponse;
    }

    /**
     * @param Offering $offering
     * @return CVResponse $cvResponse
     */
    public function save(Offering $offering)
    {
        $client = $this->container->get('client');
        $request = $client->patch('v1/'.$this->network.'/offerings/'.$offering->id, ['cv-auth' =>$this->container->get('user')->getToken()]);
        
        $parameters = $this->dataConverter->convertOfferingToArray($offering);        
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');
        
        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);
        
        return $cvResponse;
    }
    
    /**
     * @param Offering $organization
     * @return CVResponse $cvResponse
     */
    public function cancel(Offering $offering)
    {
        $client = $this->container->get('client');
        $request = $client->delete('v1/'.$this->network.'/offerings/'.$offering->id, ['cv-auth' =>$this->container->get('user')->getToken()]);
                
        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);
        
        return $cvResponse;
    }    
    
    /**
     *
     */
    public function getInvestmentsForOffering(Offering $offering)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/offerings/'.$offering->id.'/investments', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForInvestments($responseArray);

        return $cvResponse;
    }         
    
    /**
     *
     */
    public function createInvestmentForOffering(Offering $offering, Investment $investment)
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/' . $this->network . '/offerings/'.$offering->id.'/investments', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $parameters = $this->dataConverter->convertInvestmentToArray($investment);        
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');
        
        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }       
    
    /**
     *
     */
    public function getDealRoomsForOffering(Offering $offering)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/offerings/'.$offering->id.'/dealrooms', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForDealRooms($responseArray);

        return $cvResponse;
    }        
    
    /**
     *
     */
    public function createDealRoomForOffering(Offering $offering)
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/' . $this->network . '/offerings/'.$offering->id.'/dealrooms', ['cv-auth' =>$this->container->get('user')->getToken()]);
        
        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }       
    
    /**
     *
     */
    public function getBulletinsForOffering(Offering $offering)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/offerings/'.$offering->id.'/bulletins', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForBulletins($responseArray);

        return $cvResponse;
    }        
        
    /**
     *
     */
    public function createBulletinForOffering(Offering $offering, Bulletin $bulletin)
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/' . $this->network . '/offerings/'.$offering->id.'/bulletins', ['cv-auth' =>$this->container->get('user')->getToken()]);
        
        $parameters = $this->dataConverter->convertBulletinToArray($bulletin);        
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');
        
        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }        
    
    /**
     *
     */
    public function getDocumentsForOffering(Offering $offering)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/offerings/'.$offering->id.'/documents', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForDocuments($responseArray);

        return $cvResponse;
    }  
    
    /**
     *
     */
    public function createDocumentForOffering(Offering $offering, $url, $fileType, $fileAlias = '', $fileDescription = '', $groupId = '', $sourceType = 0, $tag = '')
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/' . $this->network . '/offerings/'.$offering->id.'/documents', ['cv-auth' =>$this->container->get('user')->getToken()]);

		$parameters = array(
			'url' => $url, 
			'file_type' => $fileType, 
			'file_alias' => $fileAlias, 
			'file_description' => $fileDescription, 
			'group_id' => $groupId, 
			'source_type' => $sourceType, 
			'tag' => $tag
			);
			
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');
        
        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }          
}
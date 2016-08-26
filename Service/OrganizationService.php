<?php

namespace CrowdValley\Bundle\ClientBundle\Service;

use CrowdValley\Bundle\AuthBundle\Service\UserService as BaseUserService;
use CrowdValley\Bundle\ClientBundle\Utility\ApiManager;
use CrowdValley\Bundle\ClientBundle\Utility\DataConverter;
use CrowdValley\Bundle\ClientBundle\Entity\Organization;
use CrowdValley\Bundle\ClientBundle\Entity\Offering;
use CrowdValley\Bundle\ClientBundle\Entity\User;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Session\Session;


class OrganizationService extends BaseUserService
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
    public function getOrganizations()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/'.$this->network.'/organizations', ['cv-auth' =>$this->container->get('user')->getToken()]);

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
        $request = $client->get('v1/' . $this->network . '/organizations/'.$organizationId, ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForOrganization($responseArray);

        return $cvResponse; 
    }    

    /**
     * Create a new Organization.
 	 *
     * @param Organization $organization
     * @return CVResponse $cvResponse
     */
    public function createOrganization(Organization $organization)
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/'.$this->network.'/organizations', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $parameters = $this->dataConverter->convertOrganizationToArray($organization);        
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);
                
        return $cvResponse; 
    }

    /**
     * @param Organization $organization
     * @return CVResponse $cvResponse
     */
    public function save(Organization $organization)
    {
        $client = $this->container->get('client');
        $request = $client->patch('v1/'.$this->network.'/organizations/'.$organization->id, ['cv-auth' =>$this->container->get('user')->getToken()]);
        
        $parameters = $this->dataConverter->convertOrganizationToArray($organization);        
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');
        
        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);
        
        return $cvResponse;
    }
    
    /**
     * 
     */
    public function addMemberToOrganization(User $user, Organization $organization)
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/'.$this->network.'/organizations/'.$organization->id.'/members/'.$user->id, ['cv-auth' =>$this->container->get('user')->getToken()]);
        
        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);
        
        return $cvResponse;
    }    
    
    /**
     * 
     */
    public function removeMemberFromOrganization(User $user, Organization $organization)
    {
        $client = $this->container->get('client');
        $request = $client->delete('v1/'.$this->network.'/organizations/'.$organization->id.'/members/'.$user->id, ['cv-auth' =>$this->container->get('user')->getToken()]);
        
        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);
        
        return $cvResponse;
    }       
    
    /**
     *
     */
    public function getOfferingsForOrganization(Organization $organization)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/organizations/'.$organization->id.'/offerings', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForOfferings($responseArray);

        return $cvResponse;
    }       

    /**
     *
     */
    public function createOfferingForOrganization(Organization $organization, Offering $offering)
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/' . $this->network . '/organizations/'.$organization->id.'/offerings', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $parameters = $this->dataConverter->convertOfferingToArray($offering);        
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');
        
        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }   

    /**
     *
     */
    public function getDocumentsForOrganization(Organization $organization)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/organizations/'.$organization->id.'/documents', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForDocuments($responseArray);

        return $cvResponse;
    }  
    
    /**
     *
     */
    public function createDocumentForOrganization(Organization $organization, $url, $fileType, $fileAlias = '', $fileDescription = '', $groupId = '', $sourceType = 0, $tag = '')
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/' . $this->network . '/organizations/'.$organization->id.'/documents', ['cv-auth' =>$this->container->get('user')->getToken()]);

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


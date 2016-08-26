<?php

namespace CrowdValley\Bundle\ClientBundle\Service;

use CrowdValley\Bundle\AuthBundle\Service\UserService as BaseUserService;
use CrowdValley\Bundle\ClientBundle\Utility\ApiManager;
use CrowdValley\Bundle\ClientBundle\Utility\DataConverter;
use CrowdValley\Bundle\ClientBundle\Entity\Investment;
use CrowdValley\Bundle\ClientBundle\Entity\Payout;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Session\Session;

class InvestmentService extends BaseUserService
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
    public function getInvestmentWithId($investmentId)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/investments/'.$investmentId, ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForInvestment($responseArray);

        return $cvResponse;
    }    

    /**
     * @param Investment $investment
     * @return CVResponse $cvResponse
     */
    public function save(Investment $investment)
    {
        $client = $this->container->get('client');
        $request = $client->patch('v1/'.$this->network.'/investments/'.$investment->id, ['cv-auth' =>$this->container->get('user')->getToken()]);
        
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
    public function getDocumentsForInvestment(Investment $investment)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/investments/'.$investment->id.'/documents', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForDocuments($responseArray);

        return $cvResponse;
    }  
    
    /**
     *
     */
    public function createDocumentForInvestment(Investment $investment, $url, $fileType, $fileAlias = '', $fileDescription = '', $groupId = '', $sourceType = 0, $tag = '')
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/' . $this->network . '/investments/'.$investment->id.'/documents', ['cv-auth' =>$this->container->get('user')->getToken()]);

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

    /**
     * List of Payouts for this Investment
     * @param Investment $investment
     * @return CVResponse $cvResponse
     */
    public function getPayoutsForInvestment(Investment $investment)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/investments/'.$investment->id.'/payouts', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForPayouts($responseArray);

        return $cvResponse;
    }

    /**
     * Create a Payout for this Investment
     * @param Payout $payout
     * @param Investment $investment
     * @return CVResponse $cvResponse
     */
    public function createPayoutForInvestment(Payout $payout, Investment $investment)
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/' . $this->network . '/investments/'.$investment->id.'/payouts', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $parameters = $this->dataConverter->convertPayoutToArray($payout);
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }
}

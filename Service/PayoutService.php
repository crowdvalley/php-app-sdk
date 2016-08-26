<?php

namespace CrowdValley\Bundle\ClientBundle\Service;

use CrowdValley\Bundle\AuthBundle\Service\UserService as BaseUserService;
use CrowdValley\Bundle\ClientBundle\Utility\ApiManager;
use CrowdValley\Bundle\ClientBundle\Utility\DataConverter;
use CrowdValley\Bundle\ClientBundle\Entity\LoggedInUser;
use CrowdValley\Bundle\ClientBundle\Entity\Payout;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Session\Session;

class PayoutService extends BaseUserService {

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
     * Information about this Payout
     * @param Payout $payout
     * @return CVResponse $cvResponse
     */
    public function getPayoutWithId(Payout $payout)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/payouts/'.$payout->id, ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForPayout($responseArray);
                
        return $cvResponse;
    }

    /**
     * Update the Payout information
     * @param Payout $offering
     * @return CVResponse $cvResponse
     */
    public function save(Payout $payout)
    {
        $client = $this->container->get('client');
        $request = $client->patch('v1/'.$this->network.'/payouts/'.$payout->id, ['cv-auth' =>$this->container->get('user')->getToken()]);

        $parameters = $this->dataConverter->convertPayoutToArray($payout);
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }

    /**
     * Retrieve transactions for this payout
     * @param Payout $payout
     * @return CVResponse $cvResponse
     */
    public function getTransactionsForPayout(Payout $payout)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/payouts/'.$payout->id.'/transactions', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForTransactions($responseArray);

        return $cvResponse;
    }
}
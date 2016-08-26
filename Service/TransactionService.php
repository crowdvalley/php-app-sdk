<?php

namespace CrowdValley\Bundle\ClientBundle\Service;

use CrowdValley\Bundle\AuthBundle\Service\UserService as BaseUserService;
use CrowdValley\Bundle\ClientBundle\Utility\ApiManager;
use CrowdValley\Bundle\ClientBundle\Utility\DataConverter;
use CrowdValley\Bundle\ClientBundle\Entity\CVResponse;
use CrowdValley\Bundle\ClientBundle\Entity\Transaction;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Session\Session;

class TransactionService extends BaseUserService {

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
     * Information about this Transaction
     * @param Transaction $transaction
     * @return CVResponse $cvResponse
     */
    public function getTransactionWithId(Transaction $transaction)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/transactions/'.$transaction->id, ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForTransaction($responseArray);
                
        return $cvResponse;
    }

    /**
     * Update the Transaction information
     * @param Transaction $transaction
     * @return CVResponse $cvResponse
     */
    public function save(Transaction $transaction)
    {
        $client = $this->container->get('client');
        $request = $client->patch('v1/'.$this->network.'/transactions/'.$transaction->id, ['cv-auth' =>$this->container->get('user')->getToken()]);

        $parameters = $this->dataConverter->convertTransactionToArray($transaction);
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }
}
<?php

namespace CrowdValley\Bundle\ClientBundle\Service;

use CrowdValley\Bundle\AuthBundle\Service\UserService as BaseUserService;
use CrowdValley\Bundle\ClientBundle\Utility\ApiManager;
use CrowdValley\Bundle\ClientBundle\Utility\DataConverter;
use CrowdValley\Bundle\ClientBundle\Entity\Document;
use Symfony\Component\HttpFoundation\Session\Session;
use Guzzle\Http\Exception\BadResponseException;
use CrowdValley\Bundle\ClientBundle\Service\BaseService;

class DocumentService extends BaseUserService
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
     * Delete document by id
     * @param Document $document
     * @return CVResponse $cvResponse
     */
    public function deleteDocumentWithId(Document $document)
    {
        $client = $this->container->get('client');
        $request = $client->delete('v1/' . $this->network . '/documents/'.$document->id, ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }

    /**
     * Get document by id
     * @param $document_id
     * @return CVResponse $cvResponse
     */
    public function getDocument($document_id)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/'.$this->network.'/document/'.$document_id, $this->getHeader());
        
        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForDocument($responseArray);

        return $cvResponse;
    }
}

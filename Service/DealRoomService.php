<?php

namespace CrowdValley\Bundle\ClientBundle\Service;

use CrowdValley\Bundle\AuthBundle\Service\UserService as BaseUserService;
use CrowdValley\Bundle\ClientBundle\Utility\ApiManager;
use CrowdValley\Bundle\ClientBundle\Utility\DataConverter;
use CrowdValley\Bundle\ClientBundle\Entity\DealRoom;
use CrowdValley\Bundle\ClientBundle\Entity\Topic;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Session\Session;

class DealRoomService extends BaseUserService
{
    /**
     *
     */
    public function getTopicsForDealRoom(DealRoom $dealroom)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/dealrooms/'.$dealroom->id.'/topics', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForTopics($responseArray);

        return $cvResponse;
    }  

    /**
     *
     */
    public function createTopicForDealRoom(DealRoom $dealroom, Topic $topic)
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/' . $this->network . '/dealrooms/'.$dealroom->id.'/topics', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $parameters = $this->dataConverter->convertTopicToArray($topic);        
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');
        
        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }   
}

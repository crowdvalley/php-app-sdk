<?php

namespace CrowdValley\Bundle\ClientBundle\Service;

use CrowdValley\Bundle\AuthBundle\Service\UserService as BaseUserService;
use CrowdValley\Bundle\ClientBundle\Utility\ApiManager;
use CrowdValley\Bundle\ClientBundle\Utility\DataConverter;
use CrowdValley\Bundle\ClientBundle\Entity\LoggedInUser;
use CrowdValley\Bundle\ClientBundle\Entity\Topic;
use CrowdValley\Bundle\ClientBundle\Entity\Post;
use CrowdValley\Bundle\ClientBundle\Entity\Comment;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Session\Session;

class PostService extends BaseUserService {

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
    public function getPostWithId(Post $post)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/posts/'.$post->id, ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForPost($responseArray);
                
        return $cvResponse;
    }

    /**
     *
     */
    public function getCommentsForPost(Post $post)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/posts/'.$post->id.'/comments', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForComments($responseArray);

        return $cvResponse;
    }

    /**
     *
     */
    public function createCommentForPost(Comment $comment, Post $post)
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/' . $this->network . '/posts/'.$post->id.'/comments', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $parameters = $this->dataConverter->convertCommentToArray($comment);
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }
}
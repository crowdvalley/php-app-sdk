<?php
namespace CrowdValley\Bundle\ClientBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;

class BaseService {

    protected $container;
    protected $session;
    protected $network;
    protected $token;
    protected $user;

    public function __construct($container, Session $session )
    {
        $this->container = $container;
        $this->session = $session;
        $this->network = $this->session->get('cv_network') ? $this->session->get('cv_network') : $this->container->getParameter('cv_network');
        $this->token = $this->container->get('user')->getToken();
        $this->user = $this->container->get('user')->getUser();
    }

    public function getToken() {
        $token = $this->container->get('user')->getToken();
        $client = $this->container->get('client');

        return array('cv-auth' => $token);
    }
}
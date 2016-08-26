<?php

namespace CrowdValley\Bundle\ClientBundle\Service;

use CrowdValley\Bundle\AuthBundle\Service\UserService as BaseUserService;
use CrowdValley\Bundle\ClientBundle\Utility\ApiManager;
use CrowdValley\Bundle\ClientBundle\Utility\DataConverter;
use CrowdValley\Bundle\ClientBundle\Entity\LoggedInUser;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Session\Session;

class LoggedInUserService extends BaseUserService {

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

    public function getSelf()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/self', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForSelf($responseArray);
                
        return $cvResponse;
    }

    public function getSelfStats()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/' . $this->network . '/self/stats', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForSelfStats($responseArray);

        return $cvResponse;
    }

    /**
     * @param LoggedInUser $loggedInUser
     * @return CVResponse $cvResponse
     */
    public function save(LoggedInUser $loggedInUser)
    {
        $client = $this->container->get('client');
        $request = $client->patch('v1/'.$this->network.'/self', ['cv-auth' =>$this->container->get('user')->getToken()]);
        
        $parameters = $this->dataConverter->convertLoggedInUserToArray($loggedInUser);
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');
        
        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);
        
        return $cvResponse;
    }
    
   /**
     *
     */
    public function acceptTerms()
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/'.$this->network.'/self/acceptTerms', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);
        
        return $cvResponse;
    }

    /**
     *
     */
    public function resendVerificationEmail()
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/'.$this->network.'/self/resendVerificationEmail', ['cv-auth' =>$this->container->get('user')->getToken()]);
        
		$parameters = array('email' => $this->getUserInfo['email']);
        $json_parameter = json_encode($parameters);        
        $request->setBody($json_parameter, 'application/json');

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);
        
        return $cvResponse;
    }

    /**
     *
     */
    public function changePassword($password, $newPassword, $newPasswordConfirm)
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/'.$this->network.'/self/changePassword', ['cv-auth' =>$this->container->get('user')->getToken()]);
        
		$parameters = array('password' => $password, 'new_password' => $newPassword, 'new_password_confirm' => $newPasswordConfirm);
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);
        
        return $cvResponse;
    }

    /**
     *
     */
    public function approve()
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/'.$this->network.'/self/approveUser', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);
        
        return $cvResponse;
    }

    /**
     *
     */
    public function markRegistrationComplete()
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/'.$this->network.'/self/markRegistrationComplete', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);
        
        return $cvResponse;
    }

    /**
     *
     */
    public function block($userMessage = '', $description = '', $expirationDate = '')
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/'.$this->network.'/self/blockUser', ['cv-auth' =>$this->container->get('user')->getToken()]);

		$parameters = array('user_message' => $userMessage, 'description' => $description, 'expiration_date' => $expirationDate);
        $json_parameter = json_encode($parameters);        
        $request->setBody($json_parameter, 'application/json');

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);
        
        return $cvResponse;
    }
    
    /**
     *
     */
    public function getOrganizations()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/'.$this->network.'/self/organizations', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForOrganizations($responseArray);
        
        return $cvResponse;
    }    

    /**
     *
     */
    public function getOfferings()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/'.$this->network.'/self/offerings', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForOfferings($responseArray);

        return $cvResponse;
    }    

    /**
     *
     */
    public function getInvestments()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/'.$this->network.'/self/investments', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForInvestments($responseArray);

        return $cvResponse;
    }    

    /**
     *
     */
    public function getPayouts()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/'.$this->network.'/self/payouts', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForPayouts($responseArray);

        return $cvResponse;
    }    

    /**
     *
     */
    public function getWallets()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/'.$this->network.'/self/wallets', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForWallets($responseArray);

        return $cvResponse;
    }  

    /**
     *
     */
    public function createWallet()
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/'.$this->network.'/self/wallets', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    } 
    
    /**
     *
     */
    public function getWalletWithId($walletId)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/'.$this->network.'/self/wallets/'.$walletId, ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForWallet($responseArray);

        return $cvResponse;
    }     
    
    /**
     *
     */
    public function getDocuments()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/'.$this->network.'/self/documents', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForDocuments($responseArray);

        return $cvResponse;
    }      

    /**
     *
     */
    public function createDocument($url, $fileType, $fileAlias = '', $fileDescription = '', $groupId = '', $sourceType = 0, $tag = '')
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/'.$this->network.'/self/documents', ['cv-auth' =>$this->container->get('user')->getToken()]);

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
     *
     */
    public function getInvitations()
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/'.$this->network.'/self/invitations', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForInvitations($responseArray);

        return $cvResponse;
    }  

    /**
     *
     */
    public function createInvitation($email, $givenName, $familyName, $organizationName = '')
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/'.$this->network.'/self/invitations', ['cv-auth' =>$this->container->get('user')->getToken()]);

		$parameters = array(
			'email' => $email, 
			'given_name' => $givenName, 
			'family_name' => $familyName, 
			'organization_name' => $organizationName
			);
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');
        			
        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    } 
    
    /**
     *
     */
    public function getInvitationWithId($invitationId)
    {
        $client = $this->container->get('client');
        $request = $client->get('v1/'.$this->network.'/self/invitations/'.$invitationId, ['cv-auth' =>$this->container->get('user')->getToken()]);

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForInvitation($responseArray);

        return $cvResponse;
    }     
    
    /**
     *
     */
    public function deleteAccount()
    {
        $client = $this->container->get('client');
        
        $request = $client->delete('v1/'.$this->network.'/self', ['cv-auth' =>$this->container->get('user')->getToken()]);
        
        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);
                
        return $cvResponse;
    }

    /**
     *
     */
    public function changeEmail($newEmail, $newEmailConfirm, $verifyEmailUrl)
    {
        $client = $this->container->get('client');
        $request = $client->post('v1/'.$this->network.'/self/changeEmail', ['cv-auth' =>$this->container->get('user')->getToken()]);

        $parameters = array('new_email' => $newEmail, 'new_email_confirm' => $newEmailConfirm, 'verify_email_url' => $verifyEmailUrl);
        $json_parameter = json_encode($parameters);
        $request->setBody($json_parameter, 'application/json');

        $responseArray = $this->apiManager->sendRequest($request);
        $cvResponse = $this->dataConverter->cvResponseForProcess($responseArray);

        return $cvResponse;
    }
}
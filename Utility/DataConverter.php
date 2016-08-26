<?php

namespace CrowdValley\Bundle\ClientBundle\Utility;
use CrowdValley\Bundle\ClientBundle\Entity\CVResponse;
use CrowdValley\Bundle\ClientBundle\Entity\CVException;
use CrowdValley\Bundle\ClientBundle\Entity\CVObject;
use CrowdValley\Bundle\ClientBundle\Entity\LoggedInUser;
use CrowdValley\Bundle\ClientBundle\Entity\Payout;
use CrowdValley\Bundle\ClientBundle\Entity\User;
use CrowdValley\Bundle\ClientBundle\Entity\Address;
use CrowdValley\Bundle\ClientBundle\Entity\Offering;
use CrowdValley\Bundle\ClientBundle\Entity\Organization;
use CrowdValley\Bundle\ClientBundle\Entity\Investment;
use CrowdValley\Bundle\ClientBundle\Entity\Document;
use CrowdValley\Bundle\ClientBundle\Entity\DealRoom;
use CrowdValley\Bundle\ClientBundle\Entity\Bulletin;
use CrowdValley\Bundle\ClientBundle\Entity\Topic;
use CrowdValley\Bundle\ClientBundle\Entity\Post;
use CrowdValley\Bundle\ClientBundle\Entity\Comment;
use CrowdValley\Bundle\ClientBundle\Entity\Transaction;

class DataConverter
{	
    /**
     *
     */    
    public  function cvResponseForProcess($responseArray)
    {        
        return $this->responseForProcess($responseArray);   
    }  

    /**
     *
     */    
    public function cvResponseForSelf($responseArray)
    {        
        return $this->responseForObjectWithObjectType($responseArray, 'self');   
    }  

    /**
     *
     */    
    public function cvResponseForUsers($responseArray)
    {        
        return $this->responseForListWithObjectType($responseArray, 'user');   
    }  
    
    /**
     *
     */    
    public function cvResponseForUser($responseArray)
    {        
        return $this->responseForObjectWithObjectType($responseArray, 'user');   
    }  
    
    /**
     *
     */    
    public function cvResponseForDocument($responseArray)
    {        
        return $this->responseForObjectWithObjectType($responseArray, 'document');   
    }      
        
    /**
     *
     */    
    public function cvResponseForDocuments($responseArray)
    {        
        return $this->responseForListWithObjectType($responseArray, 'document');   
    }    
            
    /**
     *
     */    
    public function cvResponseForOrganizations($responseArray)
    {        
        return $this->responseForListWithObjectType($responseArray, 'organization');
    }      
    
    /**
     *
     */    
    public function cvResponseForOrganization($responseArray)
    {        
        return $this->responseForObjectWithObjectType($responseArray, 'organization');  
    }      
    
    /**
     *
     */    
    public function cvResponseForOfferings($responseArray)
    {        
        return $this->responseForListWithObjectType($responseArray, 'offering');
    }      
    
    /**
     *
     */    
    public function cvResponseForOffering($responseArray)
    {        
        return $this->responseForObjectWithObjectType($responseArray, 'offering');  
    }     
    
    /**
     *
     */    
    public function cvResponseForInvestments($responseArray)
    {        
        return $this->responseForListWithObjectType($responseArray, 'investment');
    }      
    
    /**
     *
     */    
    public function cvResponseForInvestment($responseArray)
    {        
        return $this->responseForObjectWithObjectType($responseArray, 'investment');  
    }            
    
    /**
     *
     */    
    public function cvResponseForDealRooms($responseArray)
    {        
        return $this->responseForListWithObjectType($responseArray, 'dealroom');
    }      
    
    /**
     *
     */    
    public function cvResponseForDealRoom($responseArray)
    {        
        return $this->responseForObjectWithObjectType($responseArray, 'dealroom');  
    }     
        
    /**
     *
     */    
    public function cvResponseForBulletins($responseArray)
    {        
        return $this->responseForListWithObjectType($responseArray, 'bulletin');
    }      
    
    /**
     *
     */    
    public function cvResponseForBulletin($responseArray)
    {        
        return $this->responseForObjectWithObjectType($responseArray, 'bulletin');  
    }     
    
    /**
     *
     */    
    public function cvResponseForTopics($responseArray)
    {        
        return $this->responseForListWithObjectType($responseArray, 'topic');
    }      
    
    /**
     *
     */    
    public function cvResponseForTopic($responseArray)
    {        
        return $this->responseForObjectWithObjectType($responseArray, 'topic');  
    }

    /**
     *
     */
    public  function cvResponseForStats($responseArray)
    {
        return $this->responseForObject($responseArray);
    }

    /**
     *
     */
    public  function cvResponseForSelfStats($responseArray)
    {
        return $this->responseForObject($responseArray);
    }

    /**
     *
     */
    public function cvResponseForPosts($responseArray)
    {
        return $this->responseForListWithObjectType($responseArray, 'post');
    }

    /**
     *
     */
    public function cvResponseForPost($responseArray)
    {
        return $this->responseForObjectWithObjectType($responseArray, 'post');
    }

    /**
     *
     */
    public function cvResponseForComments($responseArray)
    {
        return $this->responseForListWithObjectType($responseArray, 'comment');
    }

    /**
     *
     */
    public function cvResponseForComment($responseArray)
    {
        return $this->responseForObjectWithObjectType($responseArray, 'comment');
    }

    /**
     *
     */
    public function cvResponseForPayouts($responseArray)
    {
        return $this->responseForListWithObjectType($responseArray, 'payout');
    }

    /**
     *
     */
    public function cvResponseForPayout($responseArray)
    {
        return $this->responseForObjectWithObjectType($responseArray, 'payout');
    }

    public function cvResponseForTransactions($responseArray)
    {
        return $this->responseForListWithObjectType($responseArray, 'transaction');
    }

    public function cvResponseForTransaction($responseArray)
    {
        return $this->responseForObjectWithObjectType($responseArray, 'transaction');
    }

    public function cvResponseForReykerRegister($responseArray)
    {
        return $this->responseForObject($responseArray);
    }
    
    public function cvResponseForReykerProfile($responseArray)
    {
        return $this->responseForObject($responseArray);
    }
    
    public function cvResponseForReykerPortfolio($responseArray)
    {
        return $this->responseForObject($responseArray);
    }        

    public function cvResponseForSelfVeriduUserProfile($responseArray)
    {
        return $this->responseForObject($responseArray);
    }

    public function cvResponseForSelfBackgroundCheck($responseArray)
    {
        return $this->responseForObject($responseArray);
    }

    public function cvResponseForSelfGbgIdVerify($responseArray)
    {
        return $this->responseForObject($responseArray);
    }

    //
    // PRIVATE UTILITY FUNCTIONS
    //
 
    private function responseForProcess($responseArray)
    {
        if ($this->isSuccess($responseArray)) {

        	$cvResponse = $this->createSuccessCVResponse();     	
        }
        else {
        	$cvResponse = $this->createUnsuccessfulCVResponse($responseArray);
        }

        return $cvResponse;      	
    }  
        
    private function responseForListWithObjectType($responseArray, $objectType)
    {
        if ($this->isSuccess($responseArray)) {

        	$cvResponse = $this->createSuccessCVResponse();
        	
        	if ($objectType == 'user') {
            	$cvResponse->objectList = $this->convertListArrayToUsers($responseArray['data']['list']);        	
        	}
        	else if ($objectType == 'document') {
            	$cvResponse->objectList = $this->convertListArrayToDocuments($responseArray['data']['list']);        	
        	}        	
        	else if ($objectType == 'organization') {
				$cvResponse->objectList = $this->convertListArrayToOrganizations($responseArray['data']['list']);        	
        	} 
        	else if ($objectType == 'offering') {           	
				$cvResponse->objectList = $this->convertListArrayToOfferings($responseArray['data']['list']);        	
        	} 
        	else if ($objectType == 'investment') {           	
				$cvResponse->objectList = $this->convertListArrayToInvestments($responseArray['data']['list']);        	
        	} 
        	else if ($objectType == 'dealroom') {           	
				$cvResponse->objectList = $this->convertListArrayToDealRooms($responseArray['data']['list']);        	
        	} 
        	else if ($objectType == 'bulletin') {           	
				$cvResponse->objectList = $this->convertListArrayToBulletins($responseArray['data']['list']);        	
        	} 
        	else if ($objectType == 'topic') {           	
				$cvResponse->objectList = $this->convertListArrayToTopics($responseArray['data']['list']);        	
        	}
            else if ($objectType == 'post') {
                $cvResponse->objectList = $this->convertListArrayToPosts($responseArray['data']['list']);
            }
            else if ($objectType == 'comment') {
                $cvResponse->objectList = $this->convertListArrayToComments($responseArray['data']['list']);
            }
            else if ($objectType == 'payout') {
                $cvResponse->objectList = $this->convertListArrayToPayouts($responseArray['data']['list']);
            }
            else if ($objectType == 'transaction') {
                $cvResponse->objectList = $this->convertListArrayToTransactions($responseArray['data']['list']);
            }
        }

        else {
        	$cvResponse = $this->createUnsuccessfulCVResponse($responseArray);
        }

        return $cvResponse;      	
    }      
    
    private function responseForObjectWithObjectType($responseArray, $objectType)
    {
        if ($this->isSuccess($responseArray)) {

        	$cvResponse = $this->createSuccessCVResponse();
        	
        	if ($objectType == 'self') {
            	$cvResponse->object = $this->convertArrayToLoggedInUser($responseArray['data']['user']);        	        	
        	}
        	else if ($objectType == 'user') {
            	$cvResponse->object = $this->convertArrayToUser($responseArray['data']['user']);        	
        	}        
        	else if ($objectType == 'document') {
				$cvResponse->objectList = $this->convertArrayToDocument($responseArray['data']['document']);        	
        	}         		
        	else if ($objectType == 'organization') {
            	$cvResponse->object = $this->convertArrayToOrganization($responseArray['data']['organization']);
            }
        	else if ($objectType == 'offering') {
            	$cvResponse->object = $this->convertArrayToOffering($responseArray['data']['offering']);
            }            
        	else if ($objectType == 'investment') {
            	$cvResponse->object = $this->convertArrayToInvestment($responseArray['data']['investment']);
            }            
        	else if ($objectType == 'dealroom') {
            	$cvResponse->object = $this->convertArrayToDealRoom($responseArray['data']['dealroom']);
            }            
        	else if ($objectType == 'bulletin') {
            	$cvResponse->object = $this->convertArrayToBulletin($responseArray['data']['bulletin']);
            }            
        	else if ($objectType == 'topic') {
            	$cvResponse->object = $this->convertArrayToTopic($responseArray['data']['topic']);
            }
            else if ($objectType == 'post') {
                $cvResponse->object = $this->convertArrayToPost($responseArray['data']['post']);
            }
            else if ($objectType == 'comment') {
                $cvResponse->object = $this->convertArrayToComment($responseArray['data']['comment']);
            }
            else if ($objectType == 'payout') {
                $cvResponse->object = $this->convertArrayToPayout($responseArray['data']['payout']);
            }
            else if ($objectType == 'transaction') {
                $cvResponse->object = $this->convertArrayToTransaction($responseArray['data']['transaction']);
            }
        }

        else {
        	$cvResponse = $this->createUnsuccessfulCVResponse($responseArray);
        }

        return $cvResponse;      	
    }

    private function responseForObject($responseArray)
    {
        if ($this->isSuccess($responseArray)) {

            $cvResponse = $this->createSuccessCVResponse();

            $object = new CVObject();
            foreach ($responseArray as $key => $value) {
                $object->$key = $value;
            }
            $cvResponse->object = $object;
        }
        else {
            $cvResponse = $this->createUnsuccessfulCVResponse($responseArray);
        }

        return $cvResponse;
    }
        
    private function isSuccess($responseArray)
    {
    	if (!empty($responseArray['outcome']) && $responseArray['outcome'] == 'success') {
    		return true;
    	}
    	else {
    		return false;
    	}
    }
    
    private function createSuccessCVResponse()
    {
        $cvResponse = new CVResponse();
        $cvResponse->outcome = CVResponse::RESPONSE_OUTCOME_SUCCESS;
        
        return $cvResponse;
    }
    
    private function createUnsuccessfulCVResponse($responseArray)
    {
        $cvResponse = new CVResponse();

        if ($responseArray['outcome'] == 'error') {
            $cvResponse->outcome = CVResponse::RESPONSE_OUTCOME_EXCEPTION;

			$exception = new CVException();
		
			$exception->http_status = $responseArray['status'];
			$exception->code = $responseArray['data']['code'];
			$exception->userMessage = $responseArray['data']['user_message'];
			$exception->developerMessage = $responseArray['data']['developer_message'];  
			
            $cvResponse->exception = $exception;			
        }
        
        else {
            $exception = new CVException();
            $exception->userMessage = 'Unable to connect. Please check your connection or try again later.';
            $exception->developerMessage = 'The user has not been able to get a response from the Crowd Valley API.';        

            $cvResponse->exception = $exception;			
        }    	
    
    	return $cvResponse;
    }
       
    //
    // DATA MODEL CONVERTERS
    //       
                
    /**
     *
     */
    public function convertLoggedInUserToArray($loggedInUser)
    {
        $parameters = [
            'birth_date'  => $loggedInUser->birthDate,
            'birth_place'  => $loggedInUser->birthPlace,
            'driving_license_number'  => $loggedInUser->drivingLicenseNumber,
            'income_range'  => $loggedInUser->incomeRange,
            'passport_country'  => $loggedInUser->passportCountry,
            'passport_expiry'  => $loggedInUser->passportExpiry,
            'passport_number'  => $loggedInUser->passportNumber,
            'tax_id'  => $loggedInUser->taxId,
        
            'additional_type'  => $loggedInUser->additionalType,
            'address'  => $this->convertAddressToArray($loggedInUser->address),
            'affiliate_code'  => $loggedInUser->affiliateCode,
            'biography'  => $loggedInUser->biography,
            'custom' => $loggedInUser->custom,
            'external_reference_id'  => $loggedInUser->externalReferenceId,
            'family_name'  => $loggedInUser->familyName,
            'given_name'  => $loggedInUser->givenName,
            'honorific_prefix'  => $loggedInUser->honorificPrefix,
            'honorific_suffix'  => $loggedInUser->honorificSuffix,
            'image'  => $loggedInUser->image->id,
            'job_title'  => $loggedInUser->jobTitle,
            'location'  => $loggedInUser->location,
            'phone_1'  => $loggedInUser->phone1,
            'phone_2'  => $loggedInUser->phone2,
            'referral_code'  => $loggedInUser->referralCode,
            'sector'  => $loggedInUser->sector,
            'tagline'  => $loggedInUser->tagline,
            'time_zone'  => $loggedInUser->timeZone,
            'visibility'  => $loggedInUser->visibility,
            'web_site'  => $loggedInUser->website
                      
        ];

        return $parameters;          
	}
	
    /**
     *
     */
    public function convertArrayToLoggedInUser($userArray)
    {
		$loggedInUser = new LoggedInUser();
		
		$loggedInUser->id = $userArray['id'];
		$loggedInUser->createdAt = $userArray['created_at'];
		$loggedInUser->updatedAt = $userArray['updated_at'];
			
        $loggedInUser->address = $this->convertArrayToAddress($userArray['address']);
        $loggedInUser->addresses = $this->convertListArrayToAddresses($userArray['addresses']);
        $loggedInUser->bankAccounts = $userArray['bank_accounts'];
        $loggedInUser->birthDate = $userArray['birth_date'];
        $loggedInUser->birthPlace = $userArray['birth_place'];
		$loggedInUser->documents = $this->convertListArrayToDocuments($userArray['documents']);
        $loggedInUser->drivingLicenseNumber = $userArray['driving_license_number'];
        $loggedInUser->emailVerified = $userArray['email_verified'];
        $loggedInUser->gbgPassId = $userArray['gbg_pass_id'];
        $loggedInUser->gcenClientId = $userArray['gcen_client_id'];
        $loggedInUser->hasBeenApproved = $userArray['has_been_approved'];
        $loggedInUser->hasBeenBlocked = $userArray['has_been_blocked'];
        $loggedInUser->incomeRange = $userArray['income_range'];
        $loggedInUser->lastLoginAt = $userArray['last_login_at'];
        $loggedInUser->mangopayCardId = $userArray['mangopay_card_id'];
        $loggedInUser->mangopayUserId = $userArray['mangopay_user_id'];
        $loggedInUser->passportCountry = $userArray['passport_country'];
        $loggedInUser->passportExpiry = $userArray['passport_expiry'];
        $loggedInUser->passportNumber = $userArray['passport_number'];
        $loggedInUser->passwordExpired = $userArray['password_expired'];
        $loggedInUser->phoneVerified = $userArray['phone_verified'];
        $loggedInUser->registrationComplete = $userArray['registration_complete'];
        $loggedInUser->taxId = $userArray['tax_id'];
        $loggedInUser->termsOfServiceAccepted = $userArray['term_service_accepted'];

        $loggedInUser->additionalType = $userArray['additional_type'];
        $loggedInUser->affiliateCode = $userArray['affiliate_code'];
        $loggedInUser->biography = $userArray['biography'];
        $loggedInUser->custom = $userArray['custom'];
        $loggedInUser->email = $userArray['email'];
        $loggedInUser->externalReferenceId = $userArray['external_reference_id'];
        $loggedInUser->familyName = $userArray['family_name'];
        $loggedInUser->fullName = $userArray['full_name'];
        $loggedInUser->givenName = $userArray['given_name'];
        $loggedInUser->honorificPrefix = $userArray['honorific_prefix'];
        $loggedInUser->honorificSuffix = $userArray['honorific_suffix'];
    	$loggedInUser->image = $this->convertArrayToDocument($userArray['image']);
        $loggedInUser->isVip = $userArray['is_vip'];
        $loggedInUser->jobTitle = $userArray['job_title'];
        $loggedInUser->location = $userArray['location'];
        $loggedInUser->organizations = $userArray['organizations'];
        $loggedInUser->phone1 = $userArray['phone_1'];
        $loggedInUser->phone2 = $userArray['phone_2'];
        $loggedInUser->referralCode = $userArray['referral_code'];
        $loggedInUser->sector = $userArray['sector'];
        $loggedInUser->tagline = $userArray['tagline'];
        $loggedInUser->timeZone = $userArray['time_zone'];
        $loggedInUser->visibility = $userArray['visibility'];
        $loggedInUser->website = $userArray['web_site'];

		return $loggedInUser;	    
    }               
            
    /**
     *
     */
    public function convertArrayToUser($userArray)
    {
		$user = new User();
		
		$user->id = $userArray['id'];
		$user->createdAt = $userArray['created_at'];
		$user->updatedAt = $userArray['updated_at'];
			
        $user->additionalType = $userArray['additional_type'];
        $user->affiliateCode = $userArray['affiliate_code'];
        $user->biography = $userArray['biography'];
        $user->custom = $userArray['custom'];
        $user->email = $userArray['email'];
        $user->externalReferenceId = $userArray['external_reference_id'];
        $user->familyName = $userArray['family_name'];
        $user->fullName = $userArray['full_name'];
        $user->givenName = $userArray['given_name'];
        $user->honorificPrefix = $userArray['honorific_prefix'];
        $user->honorificSuffix = $userArray['honorific_suffix'];
    	$user->image = $this->convertArrayToDocument($userArray['image']);
        $user->isVip = $userArray['is_vip'];
        $user->jobTitle = $userArray['job_title'];
        $user->location = $userArray['location'];
        $user->organizations = $userArray['organizations'];
        $user->phone1 = $userArray['phone_1'];
        $user->phone2 = $userArray['phone_2'];
        $user->referralCode = $userArray['referral_code'];
        $user->sector = $userArray['sector'];
        $user->tagline = $userArray['tagline'];
        $user->timeZone = $userArray['time_zone'];
        $user->visibility = $userArray['visibility'];
        $user->website = $userArray['web_site'];			
		
		return $user;	    
    }   

    /**
     *
     */    
    public function convertListArrayToUsers($array)
    {
        $users = [];
        
        foreach ($array as $userArray) {
    	
			$user = $this->convertArrayToOffering($userArray);
    		
    		$users[] = $user;
    	}
    	
    	return $users;
    }      
    
    /**
     *
     */
    public function convertOfferingToArray($offering)
    {
        $parameters = [
        	'additional_type' => $offering->additionalType,
        	'amount_raised' => $offering->amountRaised,
        	'category' => $offering->category,
        	'close_date' => $offering->closeDate,
        	'credit_score' => $offering->creditScore,
        	'currency' => $offering->currency,
        	'equity_offered' => $offering->equityOffered,
        	'external_commitments' => $offering->externalCommitments,
        	'funding_goal' => $offering->fundingGoal,
        	'interest_rate' => $offering->interestRate,
        	'funding_goal' => $offering->fundingGoal,
        	'is_secondary_offering' => $offering->isSecondaryOffering,
        	'investment_count' => $offering->investmentCount,
        	'life_cycle_stage' => $offering->lifeCycleStage,
        	'max_commitment' => $offering->maximumCommitment,
        	'max_overfunding_amount' => $offering->maximumOverfundingAmount,
        	'min_commitment' => $offering->minimumCommitment,
        	'name' => $offering->name,
        	'num_of_shares' => $offering->numberOfShares,
        	'offering_description' => $offering->offeringDescription,
        	'open_date' => $offering->openDate,
        	'price_per_share' => $offering->pricePerShare,
        	'raised_percent' => $offering->raisedPercent,
        	'term' => $offering->term,
        	'valuation' => $offering->valuation
        ];

        return $parameters;          
	}       
    
    /**
     *
     */
    public function convertArrayToOffering($offeringArray)
    {
		$offering = new Offering();
		
		$offering->id = $offeringArray['id'];
		$offering->createdAt = $offeringArray['created_at'];
		$offering->updatedAt = $offeringArray['updated_at'];
		
		$offering->additionalType = $offeringArray['additional_type'];
		$offering->amountRaised = $offeringArray['amount_raised'];
		$offering->capitalOutstanding = $offeringArray['capital_outstanding'];
		$offering->category = $offeringArray['category'];
		$offering->closeDate = $offeringArray['close_date'];
		$offering->creditScore = $offeringArray['credit_score'];
		$offering->currency = $offeringArray['currency'];
		$offering->custom = $offeringArray['custom'];
		$offering->documents = $this->convertListArrayToDocuments($offeringArray['documents']);
		$offering->equityOffered = $offeringArray['equity_offered'];
		$offering->externalCommitments = $offeringArray['external_commitments'];
		$offering->fundingGoal = $offeringArray['funding_goal'];
		$offering->gcenClientId = $offeringArray['gcen_client_id'];
		$offering->interestRate = $offeringArray['interest_rate'];
		$offering->investmentCount = $offeringArray['investment_count'];
		$offering->investorCount = $offeringArray['investor_count'];
		$offering->isFeatured = $offeringArray['is_featured'];
		$offering->isSecondaryOffering = $offeringArray['is_secondary_offering'];
		$offering->lifeCycleStage = $offeringArray['life_cycle_stage'];
		$offering->loanToValue = $offeringArray['loan_to_value'];
		$offering->loanbookId = $offeringArray['loanbook_id'];
		$offering->mangopayWalletId = $offeringArray['mangopay_wallet_id'];
		$offering->maximumCommitment = $offeringArray['max_commitment'];
		$offering->maximumOverfundingAmount = $offeringArray['max_overfunding_amount'];
		$offering->minimumCommitment = $offeringArray['min_commitment'];
		$offering->name = $offeringArray['name'];
		$offering->numberOfShares = $offeringArray['num_of_shares'];
		$offering->offeringDescription = $offeringArray['offering_description'];
		$offering->openDate = $offeringArray['open_date'];
		$offering->organizationId = $offeringArray['organization_id'];
		$offering->pricePerShare = $offeringArray['price_per_share'];
		$offering->primaryOfferingId = $offeringArray['primary_offering_id'];
		$offering->raisedPercent = $offeringArray['raised_percent'];
		$offering->repaymentsRemaining = $offeringArray['repayments_remaining'];
		$offering->term = $offeringArray['term'];
		$offering->userId = $offeringArray['user_id'];
		$offering->valuation = $offeringArray['valuation'];    
 			
		return $offering;	    
    }

    /**
     *
     */    
    public function convertListArrayToOfferings($array)
    {
        $offerings = [];
        
        foreach ($array as $offeringArray) {
    	
			$offering = $this->convertArrayToOffering($offeringArray);
    		
    		$offerings[] = $offering;
    	}
    	
    	return $offerings;
    }   

    /**
     *
     */
    public function convertArrayToOrganization($organizationArray)
    {
		$organization = new Organization();
    
    	$organization->id = $organizationArray['id'];
    	$organization->createdAt = $organizationArray['created_at'];

    	$organization->additionalType = $organizationArray['additional_type'];
    	$organization->address = $this->convertArrayToAddress($organizationArray['address']);
    	$organization->alternateName = $organizationArray['alternate_name'];
    	$organization->briefDescription = $organizationArray['brief_desc'];
    	$organization->companyNumber = $organizationArray['company_number'];
    	$organization->contactPoint = $organizationArray['contact_point'];
    	$organization->creditScore = $organizationArray['credit_score'];
    	$organization->custom = $organizationArray['custom'];
    	$organization->detailedDescription = $organizationArray['detail_desc'];
    	$organization->displayName = $organizationArray['display_name'];
		$organization->documents = $this->convertListArrayToDocuments($organizationArray['documents']);
    	$organization->facebook = $organizationArray['facebook'];
    	$organization->foundingDate = $organizationArray['founding_date'];
    	$organization->foundingLocation = $organizationArray['founding_location'];
    	$organization->legalName = $organizationArray['legal_name'];
    	$organization->lifeCycleStage = $organizationArray['life_cycle_stage'];
    	$organization->linkedin = $organizationArray['linkedin'];
    	$organization->location = $organizationArray['location'];
    	$organization->logo = $this->convertArrayToDocument($organizationArray['logo']);
    	$organization->mangopayUserId = $organizationArray['mangopay_user_id'];
    	$organization->mangopayWalletId = $organizationArray['mangopay_wallet_id'];
    	$organization->mangopayCardId = $organizationArray['mangopay_card_id'];
    	$organization->members = $organizationArray['members'];
    	$organization->organizationEmail = $organizationArray['org_email'];
    	$organization->sector = $organizationArray['sector'];
    	$organization->taxId = $organizationArray['tax_id'];
    	$organization->telephone = $organizationArray['telephone'];
    	$organization->twitter = $organizationArray['twitter'];
    	$organization->userId = $organizationArray['user_id'];
    	$organization->visibility = $organizationArray['visibility'];
    	$organization->website = $organizationArray['website'];
    	$organization->youtube = $organizationArray['youtube'];
        
    	return $organization;
    }
    
    /**
     *
     */    
    public function convertListArrayToOrganizations($array)
    {
        $organizations = [];
        
        foreach ($array as $organizationArray) {
    	
			$organization = $this->convertArrayToOrganization($organizationArray);
    		
    		$organizations[] = $organization;
    	}
    	
    	return $organizations;
    }    
    
    /**
     *
     */
    public function convertOrganizationToArray($organization)
    {
        $parameters = [
        	'additional_type' => $organization->additionalType,
            'address'  => $this->convertAddressToArray($organization->address),
        	'alternate_name' => $organization->alternateName,
        	'brief_desc' => $organization->briefDescription,
        	'company_number' => $organization->companyNumber,
        	'contact_point' => $organization->contactPoint,
        	'credit_score' => $organization->creditScore,
        	'detail_desc' => $organization->detailedDescription,
        	'display_name' => $organization->displayName,
        	'facebook' => $organization->facebook,
        	'founding_date' => $organization->foundingDate,
        	'founding_location' => $organization->foundingLocation,
        	'legal_name' => $organization->legalName,
        	'life_cycle_stage' => $organization->lifeCycleStage,
        	'linkedin' => $organization->linkedin,
        	'location' => $organization->location,
        	'org_email' => $organization->organizationEmail,
        	'sector' => $organization->sector,
        	'tax_id' => $organization->taxId,
        	'telephone' => $organization->telephone,
        	'twitter' => $organization->twitter,
        	'visibility' => $organization->visibility,
        	'website' => $organization->website,
        	'youtube' => $organization->youtube
        ];

        return $parameters;          
	}    
	
    /**
     *
     */
    public function convertArrayToInvestment($investmentArray)
    {
		$investment = new Investment();
    
    	$investment->id = $investmentArray['id'];
    	$investment->createdAt = $investmentArray['created_at'];
    	$investment->updatedAt = $investmentArray['updated_at'];
    	
    	$investment->capitalOutstanding = $investmentArray['capital_outstanding'];
    	$investment->currency = $investmentArray['currency'];
    	$investment->custom = $investmentArray['custom'];
    	$investment->divestedAmount = $investmentArray['divested_amount'];
    	$investment->divestedShares = $investmentArray['divested_shares'];
		$investment->documents = $this->convertListArrayToDocuments($investmentArray['documents']);
    	$investment->interestRate = $investmentArray['interest_rate'];
    	$investment->investmentAmount = $investmentArray['investment_amount'];
    	$investment->isLoanbook = $investmentArray['is_loanbook'];
    	$investment->lifeCycleStage = $investmentArray['life_cycle_stage'];
    	$investment->numberOfShares = $investmentArray['number_of_shares'];
    	$investment->offeringId = $investmentArray['offering_id'];
    	$investment->organizationId = $investmentArray['org_id'];
    	$investment->organizationName = $investmentArray['org_name'];
    	$investment->repaymentsRemaining = $investmentArray['repayments_remaining'];
    	$investment->settledAt = $investmentArray['settled_at'];
    	$investment->term = $investmentArray['term'];
    	$investment->userEmail = $investmentArray['user_email'];
    	$investment->userId = $investmentArray['user_id'];
    	$investment->userName = $investmentArray['user_name'];
    	$investment->visibility = $investmentArray['visibility'];
    		        		    
    	return $investment;
    }
    
    /**
     *
     */    
    public function convertListArrayToInvestments($array)
    {
        $investments = [];
        
        foreach ($array as $investmentArray) {
    	
			$investment = $this->convertArrayToInvestment($investmentArray);
    		
    		$investments[] = $investment;
    	}
    	
    	return $investments;
    }    
    	
    /**
     *
     */
    public function convertInvestmentToArray($investment)
    {
        $parameters = [
        	'currency' => $investment->currency,
        	'custom' => $investment->custom,
        	'divested_amount' => $investment->divestedAmount,
        	'interest_rate' => $investment->interestRate,
        	'investment_amount' => $investment->investmentAmount,
        	'life_cycle_stage' => $investment->lifeCycleStage,
        	'number_of_shares' => $investment->numberOfShares,
        	'term' => $investment->term,
        	'visibility' => $investment->visibility
        ];

        return $parameters;          
	}      	
    	
    /**
     *
     */
    public function convertArrayToDealRoom($dealRoomArray)
    {
		$dealRoom = new DealRoom();
    
    	$dealRoom->id = $dealRoomArray['id'];
    	$dealRoom->createdAt = $dealRoomArray['created_at'];
    	$dealRoom->updatedAt = $dealRoomArray['updated_at'];
    	
    	return $dealRoom;
    }
    
    /**
     *
     */    
    public function convertListArrayToDealRooms($array)
    {
        $dealrooms = [];
        
        foreach ($array as $dealroomArray) {
    	
			$dealroom = $this->convertArrayToDealRoom($dealroomArray);
    		
    		$dealrooms[] = $dealroom;
    	}
    	
    	return $dealrooms;
    }        	
    	
    /**
     *
     */
    public function convertArrayToBulletin($bulletinArray)
    {
		$bulletin = new Bulletin();
    
    	$bulletin->id = $bulletinArray['id'];
    	$bulletin->createdAt = $bulletinArray['created_at'];
    	$bulletin->updatedAt = $bulletinArray['updated_at'];

    	$bulletin->title = $bulletinArray['title'];
    	$bulletin->body = $bulletinArray['body'];
    	
    	return $bulletin;
    }
    
    /**
     *
     */    
    public function convertListArrayToBulletins($array)
    {
        $bulletins = [];
        
        foreach ($array as $bulletinArray) {
    	
			$bulletin = $this->convertArrayToBulletin($bulletinArray);
    		
    		$bulletins[] = $bulletin;
    	}
    	
    	return $bulletins;
    }        	
    
    /**
     *
     */
    public function convertBulletinToArray($bulletin)
    {
        $parameters = [
        	'title' => $bulletin->title,
        	'body' => $bulletin->body
        ];

        return $parameters;          
	}      
	
    /**
     *
     */
    public function convertArrayToTopic($topicArray)
    {
		$topic = new Topic();
    
    	$topic->id = $topicArray['id'];
    	$topic->createdAt = $topicArray['created_at'];
    	$topic->updatedAt = $topicArray['updated_at'];
    	
    	$topic->title = $topicArray['title'];
    	$topic->body = $topicArray['body'];
    	$topic->givenName = $topicArray['given_name'];
    	$topic->familyName = $topicArray['family_name'];
    	
    	return $topic;
    }
    
    /**
     *
     */    
    public function convertListArrayToTopics($array)
    {
        $topics = [];
        
        foreach ($array as $topicArray) {
    	
			$topic = $this->convertArrayToTopic($topicArray);
    		
    		$topics[] = $topic;
    	}
    	
    	return $topics;
    }  	
    
    /**
     *
     */
    public function convertTopicToArray($topic)
    {
        $parameters = [
        	'title' => $topic->title,
        	'body' => $topic->body,
        	'given_name' => $topic->givenName,
        	'family_name' => $topic->familyName
        ];

        return $parameters;          
	}       
    
    /**
     *
     */
    public function convertArrayToDocument($documentArray)
    {
		if ($documentArray == '') {
			return null;
		}
				
		$document = new Document();
    
    	$document->id = $documentArray['id'];
    	$document->createdAt = $documentArray['created_at'];
    	$document->updatedAt = $documentArray['updated_at'];
    	
    	$document->fileAlias = $documentArray['file_alias'];
    	$document->fileDescription = $documentArray['file_description'];
    	$document->fileName = $documentArray['file_name'];
    	$document->fileType = $documentArray['file_type'];
    	$document->groupId = $documentArray['group_id'];
    	$document->lifeCycleStage = $documentArray['life_cycle_stage'];
    	$document->tag = $documentArray['tag'];
    	$document->url = $documentArray['url'];
    	$document->user = $documentArray['user_id'];

    	return $document;
    }    
    
    /**
     *
     */    
    public function convertListArrayToDocuments($array)
    {
        $documents = [];
        
        foreach ($array as $documentArray) {
    	
			$document = $this->convertArrayToDocument($documentArray);
    		
    		$documents[] = $document;
    	}
    	
    	return $documents;
    }      
    
    /**
     *
     */
    public function convertArrayToAddress($addressArray)
    {
		if ($addressArray == '') {
			return null;
		}
		
		$address = new Address();
        
        if (key_exists('id', $addressArray)) {
    		$address->id = $addressArray['id'];
    	}
    	
        if (key_exists('address_locality', $addressArray)) {
    		$address->addressLocality = $addressArray['address_locality'];
    	}

        if (key_exists('building', $addressArray)) {
    		$address->building = $addressArray['building'];
    	}

        if (key_exists('city', $addressArray)) {
    		$address->city = $addressArray['city'];
    	}

        if (key_exists('country', $addressArray)) {
    		$address->country = $addressArray['country'];
    	}

        if (key_exists('postal_code', $addressArray)) {
    		$address->postalCode = $addressArray['postal_code'];
    	}

        if (key_exists('region', $addressArray)) {
    		$address->region = $addressArray['region'];
    	}

        if (key_exists('street_address', $addressArray)) {
    		$address->streetAddress = $addressArray['street_address'];
    	}

    	return $address;
    }       
    
    /**
     *
     */    
    public function convertListArrayToAddresses($array)
    {
        $addresses = [];
        
        foreach ($array as $addressArray) {
    	
			$address = $this->convertArrayToAddress($addressArray);
    		
    		$addresses[] = $address;
    	}
    	
    	return $addresses;
    }      
    
    /**
     *
     */
    public function convertAddressToArray($address)
    {
        $parameters = [
        	'id' => $address->id,
        	'address_locality' => $address->addressLocality,
        	'building' => $address->building,
        	'city' => $address->city,
        	'country' => $address->country,
        	'postal_code' => $address->postalCode,
        	'region' => $address->region,
        	'street_address' => $address->streetAddress,
        ];

        return $parameters;          
	}

    /**
     *
     */
    public function convertListArrayToPosts($array)
    {
        $posts = [];

        foreach ($array as $postArray) {

            $post = $this->convertArrayToPost($postArray);

            $posts[] = $post;
        }

        return $posts;
    }

    /**
     *
     */
    public function convertArrayToPost($postArray)
    {
        $post = new Post();

        $post->id = $postArray['id'];
        $post->createdAt = $postArray['created_at'];
        $post->updatedAt = $postArray['updated_at'];

        $post->body = $postArray['body'];
        $post->user = $postArray['user_id'];
        $post->userName = $postArray['user_name'];

        return $post;
    }

    /**
     *
     */
    public function convertPostToArray($post)
    {
        $parameters = [
            'body' => $post->body
        ];

        return $parameters;
    }

    /**
     *
     */
    public function convertListArrayToComments($array)
    {
        $comments = [];

        foreach ($array as $commentArray) {

            $comment = $this->convertArrayToComment($commentArray);

            $comments[] = $comment;
        }

        return $comments;
    }

    /**
     *
     */
    public function convertArrayToComment($commentArray)
    {
        $comment = new Comment();

        $comment->id = $commentArray['id'];
        $comment->createdAt = $commentArray['created_at'];
        $comment->updatedAt = $commentArray['updated_at'];

        $comment->body = $commentArray['body'];
        $comment->user = $commentArray['user_id'];
        $comment->userName = $commentArray['user_name'];

        return $comment;
    }

    /**
     *
     */
    public function convertCommentToArray($comment)
    {
        $parameters = [
            'body' => $comment->body
        ];

        return $parameters;
    }

    /**
     *
     */
    public function convertListArrayToPayouts($array)
    {
        $payouts = [];

        foreach ($array as $payoutArray) {

            $payout = $this->convertArrayToPayout($payoutArray);

            $payouts[] = $payout;
        }

        return $payouts;
    }

    /**
     *
     */
    public function convertArrayToPayout($payoutArray)
    {
        $payout = new Payout();

        $payout->id = $payoutArray['id'];
        $payout->createdAt = $payoutArray['created_at'];
        $payout->updatedAt = $payoutArray['updated_at'];

        $payout->investment = $payoutArray['investment_id'];
        $payout->dueDate = $payoutArray['due_date'];
        $payout->payoutAmount = $payoutArray['payout_amount'];
        $payout->minimumPayment = $payoutArray['minimum_payment'];
        $payout->currency = $payoutArray['currency'];
        $payout->payoutType = $payoutArray['payout_type'];
        $payout->additionalType = $payoutArray['additional_type'];
        $payout->lateFee = $payoutArray['late_fee'];
        $payout->serviceCharge = $payoutArray['service_charge'];
        $payout->chargeOffs = $payoutArray['charge_offs'];
        $payout->netRecoveries = $payoutArray['net_recoveries'];
        $payout->transactionsPaid = $payoutArray['transactions_paid'];
        $payout->paidAt = $payoutArray['paid_at'];
        $payout->netAnnualizedReturn = isset($payoutArray['net_annualized_return']) ? $payoutArray['net_annualized_return'] : '';
        $payout->custom = $payoutArray['custom'];

        return $payout;
    }

    /**
     *
     */
    public function convertPayoutToArray($payout)
    {
        $parameters = [
            'due_date' => $payout->dueDate,
            'payout_amount' => $payout->payoutAmount,
            'minimum_payment' => $payout->minimumPayment,
            'currency' => $payout->currency,
            'payout_type' => $payout->payoutType,
            'additional_type' => $payout->additionalType,
            'late_fee' => $payout->lateFee,
            'service_charge' => $payout->serviceCharge,
            'charge_offs' => $payout->chargeOffs,
            'net_recoveries' => $payout->netRecoveries
        ];

        return $parameters;
    }

    public function convertListArrayToTransactions($array)
    {
        $transactions = [];

        foreach ($array as $transactionArray) {

            $transaction = $this->convertArrayToTransaction($transactionArray);

            $transactions[] = $transaction;
        }

        return $transactions;
    }

    public function convertArrayToTransaction($transactionArray)
    {
        $transaction = new Transaction();

        $transaction->id = $transactionArray['id'];
        $transaction->createdAt = $transactionArray['created_at'];
        $transaction->updatedAt = $transactionArray['updated_at'];

        $transaction->wallet = $transactionArray['wallet_id'];
        $transaction->user = $transactionArray['user_id'];
        $transaction->userName = $transactionArray['user_name'];
        $transaction->transactionDescription = $transactionArray['transaction_description'];
        $transaction->transactionAmount = $transactionArray['transaction_amount'];
        $transaction->transactionCurrency = $transactionArray['transaction_currency'];
        $transaction->paymentStatus = $transactionArray['payment_status'];
        $transaction->paymentService = $transactionArray['payment_service'];
        $transaction->payout = $transactionArray['payout_id'];
        $transaction->originalTransactionAmount = $transactionArray['original_transaction_amount'];
        $transaction->originalTransactionCurrency = $transactionArray['original_transaction_currency'];
        $transaction->paymentServiceLogId = $transactionArray['payment_service_log_id'];
        $transaction->confirmationNumber = $transactionArray['confirmation_number'];

        return $transaction;
    }

    public function convertTransactionToArray($transaction)
    {
        $parameters = [
            'transaction_description' => $transaction->transactionDescription,
            'transaction_amount' => $transaction->transactionAmount,
            'transaction_currency' => $transaction->transactionCurrency,
            'payment_status' => $transaction->paymentStatus,
            'payment_service' => $transaction->paymentService,
            'payout_id' => $transaction->payout,
            'original_transaction_amount' => $transaction->originalTransactionAmount,
            'original_transaction_currency' => $transaction->originalTransactionCurrency,
            'payment_service_log_id' => $transaction->paymentServiceLogId,
            'confirmation_number' => $transaction->confirmationNumber
        ];

        return $parameters;
    }

}

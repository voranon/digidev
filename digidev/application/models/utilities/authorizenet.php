<?php

require_once APPLICATION_PATH.'/../public/library/anet_php_sdk/AuthorizeNet.php';

class dgdev_utility_authorizenet
{


	private $interval;
	private $unit;
	private $url;
	private $api_login_id;
	private $transaction_key;
	private $mode;

	function __construct()
	{
		$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/authorizenet.ini','zf1');

		$this->interval         = $config->interval;
		$this->unit             = $config->unit;
		$this->url              = $config->URL;
		$this->api_login_id 	= $config->APIloginID;
		$this->transaction_key 	= $config->TransactionKey;
		$this->mode             = $config->Mode;

	}




	private function postXML($post_string){


		$response = DGdev_Utility_xml::postXML($this->url, $post_string);

		return preg_replace('/xmlns="(.+?)"/', '', $response);



	}

	public function createCustomerProfile($email,$firstname,$lastname,$cardnumber,$expire,$cardcode,$address,$zip){

		$post_string = '<?xml version="1.0" encoding="utf-8"?>
 						<createCustomerProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
    					<merchantAuthentication>
      						<name>'.$this->api_login_id.'</name>
      						<transactionKey>'.$this->transaction_key.'</transactionKey>
     					</merchantAuthentication>
    					<profile>
      					<merchantCustomerId>10000</merchantCustomerId>
      					<description></description>
      					<email>'.$email.'</email>
      					<paymentProfiles>
        					<customerType>individual</customerType>
      						<billTo>
      							<firstName>'.$firstname.'</firstName>
      							<lastName>'.$lastname.'</lastName>
       							<address>'.$address.'</address>
       							<zip>'.$zip.'</zip>
      						</billTo>
           					<payment>
              					<creditCard>
                				 <cardNumber>'.$cardnumber.'</cardNumber>
                 				 <expirationDate>'.$expire.'</expirationDate>
								 <cardCode>'.$cardcode.'</cardCode>
               					</creditCard>
            				</payment>
       					</paymentProfiles>
     					</profile>
    					<validationMode>'.$this->mode.'</validationMode>
   						</createCustomerProfileRequest>';

		return $this->postXML($post_string);
	}

	public function createCustomerARB($email,$firstname,$lastname,$cardnumber,$expire,$cardcode,$address,$zip,$startdate,$amount){


		$post_string  ='<?xml version="1.0" encoding="utf-8"?>
					    <ARBCreateSubscriptionRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
  							<merchantAuthentication>
    							<name>'.$this->api_login_id.'</name>
    							<transactionKey>'.$this->transaction_key.'</transactionKey>
  							</merchantAuthentication>
  							<subscription>
    							<paymentSchedule>
      								<interval>
       								 <length>'.$this->interval.'</length>
        							 <unit>'.$this->unit.'</unit>
      								</interval>
     							    <startDate>'.$startdate.'</startDate>
      								<totalOccurrences>9999</totalOccurrences>
    							</paymentSchedule>
    							<amount>'.$amount.'</amount>
    							<payment>
      								<creditCard>
        								<cardNumber>'.$cardnumber.'</cardNumber>
        								<expirationDate>'.$expire.'</expirationDate>
      								</creditCard>
    							</payment>
        						<customer>
        							<email>'.$email.'</email>
        						</customer>
   								<billTo>
									<firstName>'.$firstname.'</firstName>
      								<lastName>'.$lastname.'</lastName>
      								<address>'.$address.'</address>
       								<zip>'.$zip.'</zip>
    							</billTo>
  							</subscription>
					   </ARBCreateSubscriptionRequest>';


		return $this->postXML($post_string);
	}

	public function createCustomerPaymentProfile($profileid,$firstname,$lastname,$cardnumber,$expire,$cardcode){

		$post_string='<?xml version="1.0" encoding="utf-8"?>
 						<createCustomerPaymentProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
   						<merchantAuthentication>
     						<name>'.$this->api_login_id.'</name>
      						<transactionKey>'.$this->transaction_key.'</transactionKey>
   						</merchantAuthentication>
   						<customerProfileId>'.$profileid.'</customerProfileId>
   						<paymentProfile>
     						<billTo>
       							<firstName>'.$firstname.'</firstName>
       							<lastName>'.$lastname.'</lastName>
     						</billTo>
     						<payment>
       						<creditCard>
         						<cardNumber>'.$cardnumber.'</cardNumber>
         						<expirationDate>'.$expire.'</expirationDate>
         						<cardCode>'.$cardcode.'</cardCode>
       						</creditCard>
     						</payment>
   						</paymentProfile>
   					  <validationMode>'.$this->mode.'</validationMode>
 					  </createCustomerPaymentProfileRequest>';

		return $this->postXML($post_string);

	}

	public function createCustomerProfileTransaction(){

	}

    public function getCustomerProfile($profileid){
		$post_string='<?xml version="1.0" encoding="utf-8"?>
 						<getCustomerProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
   						<merchantAuthentication>
     						<name>'.$this->api_login_id.'</name>
     						<transactionKey>'.$this->transaction_key.'</transactionKey>
  						</merchantAuthentication>
   						<customerProfileId>'.$profileid.'</customerProfileId>
 						</getCustomerProfileRequest>';

		return $this->postXML($post_string);
    }

    public function getCustomerPaymentProfile($profileid,$paymentprofileid){
    	$post_string='<?xml version="1.0" encoding="utf-8"?>
 						<getCustomerPaymentProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
   						<merchantAuthentication>
     						<name>'.$this->api_login_id.'</name>
     						<transactionKey>'.$this->transaction_key.'</transactionKey>
   						</merchantAuthentication>
   						<customerProfileId>'.$profileid.'</customerProfileId>
   						<customerPaymentProfileId>'.$paymentprofileid.'</customerPaymentProfileId>
 						</getCustomerPaymentProfileRequest>';



		return $this->postXML($post_string);
    }

    public function updateCustomerProfile(){


    }

   // public function updateCustomerPaymentProfile($profileid,$paymentprofileid,$firstname,$lastname,$cardnumber,$expire,$cardcode){
    public function updateCustomerPaymentProfile($profileid,$paymentprofileid){
    	/*
    	$post_string='<?xml version="1.0" encoding="utf-8"?>
    				  <updateCustomerPaymentProfileRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
    				  <paymentProfile>
    					<customerType>individual</customerType>
    					<billTo>
    						<firstName>voranon</firstName>
    						<lastName>chumnansiri</lastName>
    					</billTo>
    					<customerPaymentProfileId>9633763</customerPaymentProfileId>
    					<payment>
    						<creditCard>
    							<cardNumber>5466322441769688</cardNumber>
    							<expirationDate>2015-01</expirationDate>
    						</creditCard>
    					</payment>
    				  </paymentProfile>
    				  </updateCustomerPaymentProfileRequest>';
    	return $this->postXML($post_string);
	*/
    }

    public function deleteCustomerProfile(){

    }

    public function deleteCustomerPaymentProfile(){

    }
/*
<?xml version="1.0" encoding="utf-8"?>
					   <ARBCreateSubscriptionRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
  							<merchantAuthentication>
    							<name>'.$this->api_login_id.'</name>
    							<transactionKey>'.$this->transaction_key.'</transactionKey>
  							</merchantAuthentication>
  							<refId>Sample</refId>
  							<subscription>
    							<name>Sample subscription</name>
    							<paymentSchedule>
      								<interval>
       								 <length>1</length>
        							 <unit>months</unit>
      								</interval>
     							    <startDate>2007-03-15</startDate>
      								<totalOccurrences>12</totalOccurrences>
      								<trialOccurrences>1</trialOccurrences>
    							</paymentSchedule>
    							<amount>10.29</amount>
    							<trialAmount>0.00</trialAmount>
    							<payment>
      								<creditCard>
        								<cardNumber>4111111111111111</cardNumber>
        								<expirationDate>2008-08</expirationDate>
      								</creditCard>
    							</payment>
   								<billTo>
									<firstName>John</firstName>
      								<lastName>Smith</lastName>
    							</billTo>
  							</subscription>
					   </ARBCreateSubscriptionRequest>
 */












}

<?php

class dgdev_model_creditcards {
	private $profile_id;
	private $paymentprofile_id;
	private $cardnumber;
	private $expired_date;

	private $authorizenet;


	public function __construct($profileid){

		$this->authorizenet = new DGdev_Utility_authorizenet();

		$this->profile_id = $profileid;

		$xml_string = $this->authorizenet->getCustomerProfile( $this->profile_id );
		//echo $xml_string;
		$xml = simplexml_load_string( $xml_string );

		$customerPaymentProfileId = $xml->xpath('*//customerPaymentProfileId');

		$this->paymentprofile_id = $customerPaymentProfileId[0];

		$cardnumber        = $xml->xpath('*//payment/creditCard/cardNumber');
		$this->cardnumber  = $cardnumber[0];

		$expired_date      = $xml->xpath('*//payment/creditCard/expirationDate');
		$this->expired_date= $expired_date[0];




	}

	public function get_paymentprofile_id(){
		return $this->paymentprofile_id;
	}
	public function get_cardnumber(){
		return $this->cardnumber;
	}
	public function get_expired_date(){
		return $this->expired_date;
	}

	public function update_cardnumber(){


	}


}

?>
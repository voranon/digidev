<?php

class dgdev_paymentregistervalidator_cardnumber extends Zend_Validate_Abstract{

	const ERROR ='ERROR';

	public function __construct()
	{


	}

	protected $_messageTemplates = array(
			self::ERROR => "Payment information is invalid" ,
	);


	public function isValid($value,$context=null){

		$authorizenet = new DGdev_Utility_authorizenet();

		$email 		= htmlentities(	$context['email'] 		);
		$firstname  = htmlentities(	$context['firstname'] 	);
		$lastname   = htmlentities( $context['lastname']    );
		$address    = htmlentities( $context['address']     );
		$zipcode    = htmlentities(	$context['zipcode']		);
		$cardnumber = htmlentities(	$context['cardnumber']	);
		$year       = htmlentities(	$context['year']		);
		$month      = htmlentities(	$context['month']		);
		$seccode    = htmlentities(	$context['seccode']		);



		$data =	$authorizenet->createCustomerProfile($email,
													 $firstname,
													 $lastname,
													 $cardnumber,
													 $year.'-'.$month,
											 		 $seccode,
													 $address,
													 $zipcode);







		$xml = simplexml_load_string($data);

		//$resultCode = $xml->xpath('/createCustomerProfileResponse/messages/resultCode');
		$resultCode = $xml->xpath('*/resultCode');
		$profileid  = $xml->xpath('/createCustomerProfileResponse/customerProfileId');




		$this->_setValue($value);//to insert tested value to the failure message


		if( $resultCode[0] == 'Error' )
		{
			$this->_error(self::ERROR);
			return false;
		}else if($resultCode[0] == 'Ok'){

			$data =	$authorizenet->createCustomerARB($email,
													 $firstname,
													 $lastname,
													 $cardnumber,
													 $year.'-'.$month,
													 $seccode,
													 $address,
													 $zipcode,
											         DGdev_Utility_time::get_futuredatetime_authorizenet(7),
													 '4.99');





			$cache_query="select username,password
						  from members_cache
					      where username='".$email."'";

			$members = Zend_Registry::get('database')->get_dgdev_adapter()->query($cache_query);
			foreach($members as $member)
			{	/// from members_cache
				$username = $member['username'];
				$password = $member['password'];
			}


			$insert = "insert into members
					   set
					   username='".$username."',
					   password = '".$password."',
					   profile_id=".$profileid[0].",
					   firstname='".$firstname."',
					   lastname='".$lastname."',
					   member_status=1,
					   start_date='".DGdev_Utility_time::get_currentdatetime_mysql()."',
					   next_due_date='".DGdev_Utility_time::get_futuredatetime_mysql(7)."'";


			Zend_Registry::get('database')->get_dgdev_adapter()->query($insert);

			$delete = "
							delete from members_cache
							where username = '".$context['email']."'";

			Zend_Registry::get('database')->get_dgdev_adapter()->query($delete);

		}else{
			$this->_error(self::ERROR);
			return false;
		}
		return true;

	}

}

?>























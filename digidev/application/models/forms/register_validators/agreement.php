<?php


class dgdev_registervalidator_agreement extends Zend_Validate_Abstract{



	const UNCHECKED ='This need to be checked';



	public function __construct()
	{


	}

	protected $_messageTemplates = array(
		self::UNCHECKED => "This need to be checked",
	);


	public function isValid($value,$context=null){

		$this->_setValue($value);//to insert tested value to the failure message



		if( $value != 1 )
		{
			$this->_error(self::UNCHECKED);
			return false;
		}



		return true;

	}
}

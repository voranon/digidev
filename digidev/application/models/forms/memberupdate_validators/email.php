<?php
class dgdev_memberupdatevalidator_email extends Zend_Validate_Abstract{

	private $username;

	const INVALID_FORMAT ='INVALID_FORMAT';
	const ALREADY_EXIST  ='ALREADY_EXIST';


	public function __construct($username)
	{
		$this->username = $username;

	}

	protected $_messageTemplates = array(
		self::INVALID_FORMAT => "'%value%' has invalid format ",
		self::ALREADY_EXIST  => "'%value%' has already been used",
	);


	public function isValid($value,$context=null){

		$this->_setValue($value);//to insert tested value to the failure message



		if( !preg_match( '/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/',$value) )
		{
			$this->_error(self::INVALID_FORMAT);
			return false;
		}

		$sql = "select count(*)
				from (select *
	  				  from members
	  				  where username != '".$this->username."') as m1
				where m1.username = '".$value."'";
		$exist = Zend_Registry::get('database')->get_dgdev_adapter()->fetchOne($sql);

		if($exist){
			$this->_error(self::ALREADY_EXIST);
			return false;
		}

		return true;

	}
}

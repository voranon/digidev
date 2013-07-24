<?php

class dgdev_model_members{

	private $member_id;
	private $username;
	private $password;
	private $firstname;
	private $lastname;
	private $profile_id;
	private $creditcard;

	public function __construct($member_id){

		$this->member_id = $member_id;

		$sql =	"SELECT member_id,username,password,firstname,lastname,profile_id
				 FROM members
				 WHERE username='".$member_id."'
				";

		$member = Zend_Registry::get('database')->get_dgdev_adapter()->fetchRow($sql);

		$this->member_id    = $member['member_id'];
		$this->username 	= $member['username'];
		$this->password 	= $member['password'];
		$this->firstname 	= $member['firstname'];
		$this->lastname 	= $member['lastname'];
		$this->profile_id 	= $member['profile_id'];

		$this->creditcard   = new DGdev_Model_creditcards($this->profile_id);

	}


	public function get_member_id(){
		return $this->member_id;
	}

	public function get_username(){
		return $this->username;
	}

	public function set_password($password){

		$update="update members
				 set password='".$password."'
				 where member_id=".$this->password;

		Zend_Registry::get('database')->get_thelist_adapter()->fetchRow($update);

	}

	public function get_password(){
		return $this->password;
	}

	public function get_firstname(){
		return $this->firstname;
	}
	public function get_lastname(){
		return $this->lastname;
	}

	public function get_profile_id(){
		return $this->profile_id;
	}

}

?>
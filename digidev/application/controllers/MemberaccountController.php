<?php


class MemberaccountController extends Zend_Controller_Action {
	/**
	 * The default action - show the home page
	 */
private $user_session;

	public function init()
	{
		/* Initialize action controller here */
		$this->user_session = new Zend_Session_Namespace('userinfo');


		$this->_helper->_layout->setLayout('member_layout');
	}

	public function preDispatch()
	{
		if($this->user_session->username == '') {

			//no uid, user not logged in
			header('Location: /');
			exit;
		}

	}

	public function postDispatch()
	{

	}


	public function indexAction() {
		// TODO Auto-generated MemberController::indexAction() default action


		$member = new DGdev_Model_members($this->user_session->username);

		$this->view->username = $member->get_username();
		$this->view->fullname = $member->get_firstname().' '.$member->get_lastname();

        $authorizenet = new DGdev_Utility_authorizenet();

        $xml_string = $authorizenet->getCustomerProfile( $member->get_profile_id() );

        $xml = simplexml_load_string( $xml_string );
		//echo $xml_string;
        $card = $xml->xpath('*//cardNumber');

		$this->view->cardnumber = $card[0];

	}

	public function memberupdateAction(){
		$memberupdate_form = new DGdev_Form_memberupdate(null,$this->user_session->username);
		$memberupdate_form->setAction('/memberaccount/memberupdate');
		$memberupdate_form->setMethod('post');

		if( $this->getRequest()->isPost() )
		{
			if ( $memberupdate_form->isValid($_POST) ) {

				$update="update members
						 set
						 username='".$_POST['email']."',
						 password=md5('".$_POST['password']."'),
						 firstname = '".$_POST['firstname']."',
						 lastname = '".$_POST['lastname']."'
						 where username='".$this->user_session->username."'";

				Zend_Registry::get('database')->get_dgdev_adapter()->query($update);

				$this->user_session->username=$_POST['email'];
				$this->redirect('/memberaccount');

			}
		}

		$this->view->memberupdate_form = $memberupdate_form;

	}

	public function paymentupdateAction(){



	}

	public function cancelmemberAction(){
		echo 'ddd';
	}

}

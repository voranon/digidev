<?php

class IndexController extends Zend_Controller_Action
{
	private $user_session;

    public function init()
    {
        /* Initialize action controller here */
    	$this->user_session = new Zend_Session_Namespace('userinfo');


    	$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/channel.ini','zf1');
    	$this->view->register_page         = $config->register_page;


    }

    public function preDispatch()
    {
    	if($_GET['bypass'] == 1){// from accounts

    		$config 	= new Zend_Config_Ini(APPLICATION_PATH.'/configs/channel.ini','zf1');
    		$channel_id = $config->db_channel_id;


    		$sql = "select count(*) as exist
					from members m
					inner join member_channel mc on m.member_id = mc.member_id
					where m.username='".$_GET['username']."'
					and password = '".$_GET['password']."'
					and channel_id = ".$channel_id."
					and mc.member_channel_status = 1";

    		$exist = Zend_Registry::get('database')->get_dgdev_adapter()->fetchOne( $sql );


    		if($exist)
    		{

    			$member = New DGdev_Model_members($_GET['username'] );
    			$this->user_session->username = $member->get_username();
    			$this->user_session->password = $member->get_password();
    			$this->user_session->member_id= $member->get_member_id();
    			$this->user_session->firstname= $member->get_firstname();
    			$this->user_session->lastname = $member->get_lastname();


				$this->_redirect('member/index/');
    		}else{
    			$this->_redirect('/');
    		}
    	}


    }

    public function indexAction()
    {
        // action body
    }

    public function signinAction(){

		$signin_form = new DGdev_Form_signin();
		$signin_form->setAttrib('class', 'form-container');
		$signin_form->setAction('/index/signin');
		$signin_form->setMethod('post');


		$this->view->signin_form = $signin_form;

		if( $this->getRequest()->isPost() ){
			if( $signin_form->isValid($_POST)){

				$email 		= htmlentities(	$_POST['email']		);
				$password   = htmlentities(	$_POST['password']	);

				// start session
				$member = New DGdev_Model_members( $email );

				$this->user_session->username = $member->get_username();
    			$this->user_session->password = $member->get_password();
    			$this->user_session->member_id= $member->get_member_id();
    			$this->user_session->firstname= $member->get_firstname();
    			$this->user_session->lastname = $member->get_lastname();


				$this->_redirect('member/index/');
			}
		}

    }

    public function forgetpasswordAction(){

    	$forgetpassword_form = new DGdev_Form_forgetpassword();
    	$forgetpassword_form->setAction('/index/forgetpassword');
    	$forgetpassword_form->setMethod('post');

    	$this->view->forgetpassword_form = $forgetpassword_form;

    	if( $this->getRequest()->isPost() ){
    		if( $forgetpassword_form->isValid($_POST)){

    			$emailserver = new DGdev_Utility_email();

				$email 			= htmlentities( $_POST['email'] );
				$new_password 	= rand(1234567,9234567);

				$update_password="update members
								  set password=md5('".$new_password."')
								  where username='".$email."'";

				Zend_Registry::get('database')->get_dgdev_adapter()->query($update_password);


				$content  		= "Your new password is ".$new_password;

				$emailserver->send($email, $content,'New password for Digidev');

				$this->_redirect('index/signin/');


    		}
    	}

    }

    public function signoutAction(){

    	$config 	= new Zend_Config_Ini(APPLICATION_PATH.'/configs/channel.ini','zf1');
    	$signout_page = $config->signout_page;

    	Zend_Session::destroy(true);
    	$this->_redirect($signout_page);


    }



    public function disclaimerAction(){

    }

    public function privacypolicyAction(){

    }

    public function visitAction(){

    }

    public function contactAction(){

    }


}


<?php

/**
 * MemberController
 *
 * @author
 * @version
 */


class MemberController extends Zend_Controller_Action {
	/**
	 * The default action - show the home page
	 */

	private $user_session;

	public function init()
	{

		$this->user_session = new Zend_Session_Namespace('userinfo');
		$this->_helper->_layout->setLayout('member_layout');

		$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/channel.ini','zf1');

		$this->lime_light_channelgroup_id         = $config->lime_light_channelgroup_id;
		$this->setting_page 					  = $config->setting_page;
		$this->view->setting_page 				  = $this->setting_page;
		$this->view->username 				      = $this->user_session->username;
		$this->view->password 					  = $this->user_session->password;


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

		$cdn = New DGdev_Utility_limelightcdn();


		$this->view->cdn = $cdn;


		$channel_group_array = $cdn->get_chennelgroups( $this->lime_light_channelgroup_id );

		$this->view->channels 		= $channel_group_array->channel_list;
/*
		foreach( $this->view->channels as $channel_group){
			//print_r($channel_group);

			//echo '<br>';
			//echo $channel_group->channel_id;
			//echo '<br>';




		}

		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
*/


	}

}

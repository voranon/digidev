<?php

/**
 * rokuxmlController
 *
 * @author
 * @version
 */

class RokuxmlController extends Zend_Controller_Action {
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		// TODO Auto-generated rokuxmlController::indexAction() default action
	}

	public function authenticateAction(){

		$xml_post = file_get_contents('php://input');
		// If we receive data, save it.

		if ($xml_post) {

			$xml = simplexml_load_string( $xml_post );

			$username = $xml->xpath('/DGdevrequest/Username');
			$username = $username[0];

			$password = $xml->xpath('/DGdevrequest/Password');
			$password = $password[0];



			$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/channel.ini','zf1');
			$channel_id = $config->db_channel_id;
			$sql="
					select count(*) as exist
					from members m
					inner join member_channel mc on m.member_id = mc.member_id
					where m.username='".$username."'
					and password =  md5('".$password."')
					and mc.channel_id=".$channel_id."
					and mc.member_channel_status=1";


/*
			$sql="select count(*)
				  from members
				  where username='".$username."'
				  and password = md5('".$password."')
				  and ( member_status=1 || member_status=2 || member_status=4)";
*/
			$status = Zend_Registry::get('database')->get_dgdev_adapter()->fetchOne($sql);

			if($status >= 1){
				$answer='Ok';
				$response = '<?xml version="1.0" encoding="utf-8"?>
   							<DGdevresponse>
      							<Authenticated>'.$answer.'</Authenticated>
                      			<Channels>';

				$sql="select mc.channel_id,c.channel_name
				  	  from members m
				  	  inner join member_channel mc on m.member_id = mc.member_id
				      inner join channels c on mc.channel_id = c.channel_id
				      where m.username ='".$username."'
				      and mc.channel_id=".$channel_id."
				      and mc.member_channel_status=1";

				$channels = Zend_Registry::get('database')->get_dgdev_adapter()->query($sql);

				foreach($channels as $channel)
				{

					$response.='<Channel>
									<Id>'.$channel['channel_id'].'</Id>
									<Name>'.$channel['channel_name'].'</Name>
								</Channel>';
				}

				$response.='	</Channels>
						</DGdevresponse>';
			}else{
				$answer='Fail';
				$response = '<?xml version="1.0" encoding="utf-8"?>
   							 <DGdevresponse>
      							<Authenticated>'.$answer.'</Authenticated>
						     </DGdevresponse>';
			}


			echo $response;
			// Return, as we don't want to cause a loop by processing the code below.
		}

		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

	}
}

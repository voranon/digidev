<?php


class dgdev_form_memberupdate extends Zend_Form{

	public function __construct($options = null,$username)
	{
		parent::__construct($options);


		$member = new DGdev_Model_members($username);


		$email = new Zend_Form_Element_Text(
												'email',
												 array(
													'label'      => 'Email Address',
													'value'      => $member->get_username(),
													'decorators' => array(
																	new memberupdate_decorator()
																		 )
													 )
											);
		$email->setRequired(true);
        $email->addValidator( new DGdev_Memberupdatevalidator_email( $member->get_username() ) );


		$cemail = new Zend_Form_Element_Text(
												'cemail',
												array(
													'label'      => 'Retype Email Address:',
													'value'      => $member->get_username(),
													'decorators' => array(
																	new memberupdate_decorator()
																		 )
													 )
											);
		$cemail->setRequired(true);
		$cemail->addValidator( new DGdev_Registervalidator_cemail() );

		$password = new Zend_Form_Element_Text(
												'password',
												array(
													'label'      => 'Password:',
													'value'      => '*****',
													'decorators' => array(
																	new memberupdate_decorator()
																		 )
													)
											  );
		$password->setRequired(true);
		$password->addValidator( new DGdev_Registervalidator_password() );


		$cpassword = new Zend_Form_Element_Text(
												'cpassword',
												array(
													'label'      => 'Confirm password:',
													'value'      => '*****',
													'decorators' => array(
																	new memberupdate_decorator()
																		 )
													)
											   );
		$cpassword->setRequired(true);
		$cpassword->addValidator( new DGdev_Registervalidator_cpassword() );

		$firstname = new Zend_Form_Element_Text(
												'firstname',
												array(
													'label'      => 'First Name:',
													'value'      => $member->get_firstname(),
													'decorators' => array(
																	new memberupdate_decorator()
																		 )
													)
											   );
		$firstname->setRequired(true);


		$lastname = new Zend_Form_Element_Text(
											   'lastname',
											   array(
											   		'label'      => 'Last Name:',
											   		'value'      => $member->get_lastname(),
											   		'decorators' => array(
															   		new memberupdate_decorator()
																	)
													)
											  );
		$lastname->setRequired(true);


		$save = new Zend_Form_Element_Submit(
												'save',
												array(
												'label'		=> '',
												'value'     => 'Save',
												'decorators'=> array(
																new memberupdate_decorator()
																	)
													)
											 );

		$this->addElements(array($email,$cemail,$password,$cpassword,$firstname,$lastname,$save));
	}
}

class memberupdate_decorator extends Zend_Form_Decorator_Abstract
{
	public function __construct($foo=null){

	}
	public function render($content){

		$element  = $this->getElement();
		$messages = $element->getMessages();
		$name     = htmlentities($element->getFullyQualifiedName());
		$label    = htmlentities($element->getLabel());
		$id       = htmlentities($element->getId());
		$value    = htmlentities($element->getValue());

		if($name == 'email'){

			$format="<table border='0' style='width:400px'>
						<tr>
							<td align='right' style='width:160px'>%s</td>
							<td><input type='text' name='%s' value='%s' style='width:210px'></input></td>
						</tr>
						<tr>
							<td colspan='2' align='right'>&nbsp;%s</td>
						</tr>";

			return sprintf($format,$label,$name,$value,reset($messages));

		}

		else if($name == 'cemail'){
			$format="	<tr>
							<td align='right'>%s</td>
							<td><input type='text' name='%s' value='%s' style='width:210px'></input></td>
						</tr>
						<tr>
							<td colspan='2' align='right'>&nbsp;%s</td>
						</tr>";
			return sprintf($format,$label,$name,$value,reset($messages));

		}
		else if($name == 'password'){
			$format="	<tr>
							<td align='right'>%s</td>
							<td><input type='password' name='%s' value='%s' style='width:210px'></input></td>
						</tr>
						<tr>
							<td colspan='2' align='right'>&nbsp;%s</td>
						</tr>";
			return sprintf($format,$label,$name,$value,reset($messages));
		}
		else if($name == 'cpassword'){
			$format="	<tr>
							<td align='right'>%s</td>
							<td><input type='password' name='%s' value='%s' style='width:210px'></input></td>
						</tr>
						<tr>
							<td colspan='2' align='right'>&nbsp;%s</td>
						</tr>";
			return sprintf($format,$label,$name,$value,reset($messages));

		}else if($name == 'firstname'){
			$format="	<tr>
							<td align='right'>%s</td>
							<td><input name='%s' value='%s' style='width:210px'></input></td>
						</tr>
						<tr>
							<td colspan='2' align='right'>&nbsp;%s</td>
						</tr>";
			return sprintf($format,$label,$name,$value,reset($messages));

		}else if($name == 'lastname'){
			$format="	<tr>
							<td align='right'>%s</td>
							<td><input name='%s' value='%s' style='width:210px'></input></td>
						</tr>
						<tr>
							<td colspan='2' align='right'>&nbsp;%s</td>
						</tr>";
			return sprintf($format,$label,$name,$value,reset($messages));
		}
		else if($name == 'save'){
			$format="	<tr>
							<td colspan='2'><input type='submit' name='%s' value='%s' style='width:100px'></input></td>
						</tr>
					</table>";
			return sprintf($format,$name,$value);
		}

	}

}


/*


<table border='0' style='width:100%'>
				<tr>
					<td align='right' style='width:140px'>Email:</td>
					<td><input type='text' name='email' value='' style='width:90%'></input></td>
				</tr>
				<tr>
					<td colspan='2' align='right'>&nbsp;</td>
				</tr>
				---------------------------------------------
				<tr>
					<td align='right'>Confirm Email:</td>
					<td><input type='text' name='cemail' value='' style='width:90%'></input></td>
				</tr>
				<tr>
					<td colspan='2' align='right'>&nbsp;</td>
				</tr>
				---------------------------------------------
				<tr>
					<td align='right'>Password:</td>
					<td><input type='password' name='password' value='' style='width:90%'></input></td>
				</tr>
				<tr>
					<td colspan='2' align='right'>&nbsp;</td>
				</tr>
				---------------------------------------------
				<tr>
					<td align='right'>Confirm Password:</td>
					<td><input type='password' name='cpassword' value='' style='width:90%'></input></td>
				</tr>
				<tr>
					<td colspan='2' align='right'>&nbsp;</td>
				</tr>
				---------------------------------------------
				<tr>
					<td align='right'>First Name:</td>
					<td><input name='cpassword' value='' style='width:90%'></input></td>
				</tr>
				<tr>
					<td colspan='2' align='right'>&nbsp;</td>
				</tr>
				---------------------------------------------
				<tr>
					<td align='right'>Last Name:</td>
					<td><input name='cpassword' value='' style='width:90%'></input></td>
				</tr>
				<tr>
					<td colspan='2' align='right'>&nbsp;</td>
				</tr>
				---------------------------------------------
				<tr>
					<td colspan='2'><input type='button' value='Save' style='width:100px'></input></td>
				</tr>
</table>
*/








?>
<?php

class dgdev_form_register extends Zend_Form{

	public function __construct($options = null)
	{
		parent::__construct($options);

		$email = new Zend_Form_Element_Text(
											'email',
												array(
												'label'      => 'Email Address:',
												'value'      => '',
												'decorators' => array(
																new register_decorator()
																	 )
														)
											);

		$email->setRequired(true);


		$email->addValidator( new DGdev_Registervalidator_email() );




		$cemail = new Zend_Form_Element_Text(
											'cemail',
												array(
												'label'      => 'Confirm Email Address:',
												'value'      => '',
												'decorators' => array(
																new register_decorator()
																	)
														)
											);
		$cemail->setRequired(true);

		$cemail->addValidator( new DGdev_Registervalidator_cemail() );

		$password = new Zend_Form_Element_Text(
											'password',
												array(
												'label'      => 'Choose a password(5-60 characters)',
												'value'      => '',
												'decorators' => array(
																new register_decorator()
																	)
														)
											);
		$password->setRequired(true);
		$password->addValidator( new DGdev_Registervalidator_password() );

		$cpassword = new Zend_Form_Element_Text(
											'cpassword',
												array(
												'label'      => 'Confirm password',
												'value'      => '',
												'decorators' => array(
																	new register_decorator()
																	)
														)
											);
		$cpassword->setRequired(true);
		$cpassword->addValidator( new DGdev_Registervalidator_cpassword() );

		$agreement = new Zend_Form_Element_Checkbox(
											'agreement',
												array(
														'label'		=> '"I have read and agree to the DigiDev terms and conditions"',
														'value' 	=> 1,
														'decorators'=> array(
																			new register_decorator()
																			)
													 )
											);
		$agreement->addValidator( new DGdev_Registervalidator_agreement() );


		$continue = new Zend_Form_Element_Submit(
											'continue',
												array(
												'label'		=> '',
												'value'     => 'Continue',
												'decorators'=> array(
																	new register_decorator()
																	)
													 )
												);

		$this->addElements(array($email,$cemail,$password,$cpassword,$agreement,$continue));




	}

}

class register_decorator extends Zend_Form_Decorator_Abstract
{

	private $database;

	public function __construct($foo=null){




	}

	public function render($content){

		$element = $this->getElement();
		$messages = $element->getMessages();
		$name    = htmlentities($element->getFullyQualifiedName());
		$label   = htmlentities($element->getLabel());
		$id      = htmlentities($element->getId());
		$value   = htmlentities($element->getValue());

		if($name == 'email'){
			$format ="<table style='width:600px;margin:0 auto'>
  						<tr>
  							<td style='width:300px'>
  							%s
  							</td>

  						</tr>
  						<tr>
  							<td>
  							<input type='email' name='%s' value='%s' style='width: 300px;height: 25px;font-size: 20px'></input>
  							</td>
  							<td style='width:300px'>%s
  							</td>
  						</tr>";

			//return sprintf($format,$label,$name,$value,$element->getView()->formErrors($messages));
			return sprintf($format,$label,$name,$value,reset($messages));
		}else if($name == 'cemail'){
			$format ="<tr>
  						<td>%s</td>
  					  </tr>
  					  <tr>
  							<td>
  							<input type='email' name='%s' value='%s' style='width: 300px;height: 25px;font-size: 20px'></input>
  							</td>
  							<td style='width:300px'>%s
  							</td>
  					  </tr>";
			//return sprintf($format,$label,$name,$value,$element->getView()->formErrors($messages));
			return sprintf($format,$label,$name,$value,reset($messages));
		}else if($name == 'password'){
			$format ="
					<tr>
						<td>%s</td>
					</tr>
  					<tr>
  						<td>
  							<input type='password' name='%s' value='%s' style='width: 300px;height: 25px;font-size: 20px'></input>
  						</td>
  						<td style='width:300px'>
							%s
  						</td>
  					</tr>
					";
			return sprintf($format,$label,$name,$value,reset($messages));
		}else if($name == 'cpassword'){
			$format="
					<tr>
						<td>%s</td>
					</tr>
  					<tr>
  					<td>
  						<input type='password' name='%s' value='%s' style='width: 300px;height: 25px;font-size: 20px'></input>
  					</td>
  					<td style='width:300px'>
					%s
  					</td>
  					</tr>";
			return sprintf($format,$label,$name,$value,reset($messages));
		}else if($name == 'agreement'){
			$format="
					<tr>
						<td colspan='2'><input type='checkbox' name='%s' value='1'></input> 'I have read and agree to the DigiDev <a href='/index/disclaimer' target='_blank'>Terms</a> and <a href='/index/privacypolicy' target='_blank'>Privacy Policy</a>'</td>
					</tr>
					<tr>
						<td colspan='2'>%s</td>
					</tr>
					";
			return sprintf($format,$name,reset($messages));

		}else if($name == 'continue'){
			$format="
					<tr>
						<td>%s</td>
					</tr>
  					<tr>
  					<td colspan='2'>
  					<input type='submit' name='%' value='%' style='width: 300px;height: 25px;' value='Continue'></input>
  					</td>

  					</tr>
  					</table>";
			return sprintf($format,$label,$name,$value,reset($messages));

		}

	}
}


/*
 <form action="" method='post'>
<table style='width:600px;margin:0 auto' border='0'>
<tr>
<td style='width:300px'>
Email Address
</td>

</tr>
<tr>
<td>
<input type="email" name='email' style='width: 300px;height: 25px'></input>
</td>
<td style='width:300px'>
</td>
</tr>
<tr>
<td>Confirm Email Address</td>

</tr>
<tr>
<td>
<input type="email" name='cemail' style='width: 300px;height: 25px'></input>
</td>
<td style='width:300px'>
</td>
</tr>

<tr><td>Choose a password(4-60 characters)a</td></tr>
<tr>
<td>
<input type="text" name='password' style='width: 300px;height: 25px'></input>
</td>
<td style='width:300px'>
</td>
</tr>
<tr><td>Confirm password</td></tr>
<tr>
<td>
<input type="text" name='cpassword' style='width: 300px;height: 25px'></input>
</td>
<td style='width:300px'>
</td>
</tr>


<tr>
	<td colspan='2'><input type='checkbox' value='1'></input> "I have read and agree to the DigiDev <a href='/index/disclaimer' target='_blank'>Terms</a> and <a href='/index/privacypolicy' target='_blank'>Privacy Policy</a>"</td>
</tr>

<tr><td>&nbsp</td></tr>
<tr>
<td colspan='2'>
<input type="submit" name='continue'  style='width: 300px;height: 25px;' value='Continue'></input>
</td>

</tr>
</table>
</form>

*/

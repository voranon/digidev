<?php

class dgdev_form_signin extends Zend_Form{

	public function __construct($options = null)
	{
		parent::__construct($options);

		$email = new Zend_Form_Element_Text(
					'email',
					array(
						'label'      => 'Email Address',
						'value'      => '',
						'decorators' => array(
								new signin_decorator()
											)
							)
					);
		$email->setRequired(true);
		$email->addValidator( new DGdev_Signinvalidator_email() );

		$password = new Zend_Form_Element_Text(
				'password',
				array(
						'label'      => 'Password',
						'value'      => '',
						'decorators' => array(
								new signin_decorator()
						)
				)
		);
		$password->setRequired(true);
		$password->addValidator( new DGdev_Signinvalidator_password() );

		$continue = new Zend_Form_Element_Submit(
				'continue',
				array(
						'label'		=> '',
						'value'     => 'Continue',
						'decorators'=> array(
								new signin_decorator()
						)
				)
		);

		$this->addElements(array($email,$password,$continue));
	}
}

class signin_decorator extends Zend_Form_Decorator_Abstract
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

		if( $name == 'email'){
			$format="<table border='0' style='margin:0 auto;'>

    					<tr>
    						<td><input type='text' style='width: 200px' placeholder='%s' name='%s' value='%s'></input></td>
    					</tr>
						<tr>
    						<td>&nbsp;%s</td>
    					</tr>
    					<tr>
    						<td align='right'><a href='/index/forgetpassword'>Forgot Password</a></td>
    					</tr>";

			return sprintf($format,$label,$name,$value,reset($messages));

		}else if( $name == 'password'){
			$format="	<tr>
    						<td><input type='password' style='width: 200px' placeholder='%s' name='%s' value='%s'></input></td>
    					</tr>
    					<tr>
    						<td>&nbsp;%s</td>
    					</tr>";
			return sprintf($format,$label,$name,$value,reset($messages));
		}else if($name == 'continue'){
			$format="	<tr>
    						<td><input type='submit' name='%s' value='%s'></input></td>
    					</tr>
    				</table>";
			return sprintf($format,$name,$value);

		}

	}
}

/*

  <table border="0" style='margin:0 auto;'>

    			<tr>
    				<td><input type='text' style='width: 200px' placeholder='Email'></input></td>
    			</tr>
				<tr>
    				<td>&nbsp;</td>
    			</tr>
    			<tr>
    				<td align='right'><a href='/index/forgetpassword'>Forget Password</a></td>
    			</tr>
    -----------------------------------------
    			<tr>
    				<td><input type='password' style='width: 200px' placeholder='Password'></input></td>
    			</tr>
    			<tr>
    				<td>&nbsp;</td>
    			</tr>
    -----------------------------------------
    			<tr>
    				<td><input type='submit' value='Continue'></input></td>
    			</tr>
    </table>


 */




















?>
<?php

class SignUpForm extends CFormModel {
    
    
        public $firstName;
        public $lastName;
        public $email;
        public $confirmEmail;
	public $password;
        public $confirmPassword;
        public $gender;
        public $domain;
        
        
        public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			
                        array('firstName, lastName', 'required', 'message' => '&#10006; &nbsp; A {attribute} is required!'),
                        array('email, confirmEmail, password, confirmPassword', 'required', 'message' => '&#10006; &nbsp; A {attribute} is required!'),
			array('password, confirmPassword', 'length', 'max'=>128, 'min'=>5),
                        array('confirmPassword', 'compare', 'compareAttribute'=>'password'),
			array('profile', 'safe'),
                        array('email, confirmEmail', 'email'),
                        array('confirmEmail', 'compare', 'compareAttribute'=>'email'),
                        array('email', 'checkuser'),
		);
                
                
                
	}
        
        

}
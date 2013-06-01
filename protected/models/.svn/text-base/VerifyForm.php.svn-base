<?php


class VerifyForm extends CFormModel
{
	public $username;
	public $verify_code;
        public $email;


	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('verify_code, username', 'required','message' => '&#10006; &nbsp; A {attribute} is required.'),
			// rememberMe needs to be a boolean
			// password needs to be authenticated
                    
                        //array('username', 'finduser'),
			array('verify_code', 'verify'),
                        
                    
                        
		);
	}
        
        
        
        
        
        
        
        public function verify($attribute, $params) {
            
            //$this->username = 'mnouh1@binghamton.edu';
            //User::model()->findByUsername($this->username);
            
            $user=User::model()->find(array(
            'select'=>'verify_code, id, verified',
            'condition'=>'username=:username',
            'params'=>array(':username'=>$this->username),
            ));
            
            if($user != NULL) {
                
                
                if($user->verified == '1') {
                    
                    $this->addError('verify_code', '<b>&#10004;</b> &nbsp Your Account is Active.');
                    
                }
                
                
                if($user->verified == 0) 
                {
                    
                    
                    if($this->verify_code != $user->verify_code)  
                    {
                
                
                        $this->addError('verify_code', '&#10006; &nbsp; Incorrect Verification Code');
                
                     }
                    
                    
                }
                
                else 
                {
                    
                    $this->addError('username', 'Your account is already verified');
                    
                }
                
                
            }
            
            else 
            {
                
                
                $this->addError('username', '&#10006; &nbsp; I could not find the username');
                
            }
            
            
            
        }
        
       
       
            
        

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'verify_code'=>'Verification Code',
		);
	}
        
}
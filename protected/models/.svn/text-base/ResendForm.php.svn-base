<?php


class ResendForm extends CFormModel
{
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
			// rememberMe needs to be a boolean
			// password needs to be authenticated
                    
                        //array('username', 'finduser'),
                    	array('email', 'required'),
			array('email', 'email'),
                        array('email', 'verify'),
                        array('email', 'safe')
                    
                    
                        
		);
	}
        
        
        
        public function verify($attribute, $params) {
            
            //$this->username = 'mnouh1@binghamton.edu';
            //User::model()->findByUsername($this->username);
            
            $user=User::model()->find(array(
            'select'=>'verify_code, id, verified',
            'condition'=>'username=:username',
            'params'=>array(':username'=>$this->email),
            ));
            
            if($user == NULL) {
                
                
                $this->addError('email', '&#10006; &nbsp; I could not find the username');
                
            }
            
            else if($user != NULL) 
            {
            
                if($user->verified == 1)
                {
                    
                    
                    
                    $this->addError('email', '&#10006; &nbsp; Your account is already verified');
                    
                    
                }
                
                
            }
            
            
        }
        
        
        
       
            
        

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'emailinfo'=>'Email',
		);
	}
        
}
<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class SearchForm extends CFormModel
{
	//public $lat;
        //public $lng;
        //public $radius;
        
          public $addressInput;
          public $lat;
          public $lng;
          public $radius;
          
	//public $newPassword;
	//public $confirmNewPassword;
        //public $username;
        //public $_identity;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('addressInput, lat, lng', 'required'),
                        /*array('lat', 'required'),
                        array('lng', 'required'),
                        array('radius', 'required')*/
                        
		);
	}

        /*
        public function verify($attribute, $params) {
            
            $user=User::model()->find('LOWER(username)=?',array(strtolower($this->username)));
		if($user===null)
			$this->addError ('username', 'We could not find your account.');
            
            
        }
        
        public function save() {
  
            $user = User::model()->find('LOWER(username)=?',array(strtolower($this->username)));
            
            
            if($user===null)
			throw new CHttpException(404,'The requested page does not exist.');
            
            
           
                    $salt = $user->generateSalt();
                    $pass = $user->hashPassword($this->newPassword, $salt);
                    $user->password = $pass;
                    $user->salt = $salt;
                    $user->password_changed = date("Y-m-d H:i:s");
            
                    
                    if($user->update())
                        return true;
                    else
                        return false;
            
        }
        */
	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'addressInput'=>'Address',
                        //'lat'=>'Longitude',
                        
		);
	}
}
<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ChangePasswordForm extends CFormModel
{
	public $currentPassword;
	public $newPassword;
	public $confirmNewPassword;
        public $username;
        public $_identity;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('currentPassword, newPassword, confirmNewPassword', 'required'),
                        array('currentPassword', 'verify'),
			// email has to be a valid email address
			//array('email', 'email'),
			// verifyCode needs to be entered correctly
			//array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
                        
                        array('newPassword, confirmNewPassword', 'length', 'max'=>128, 'min'=>5),
                        array('newPassword', 'compare', 'compareAttribute'=>'currentPassword', 'operator'=> '!=', 'message'=> 'New Password and Current Password must not match.'),
                        array('confirmNewPassword', 'compare', 'compareAttribute'=>'newPassword'),
		);
	}

        
        /**
         * This function verifies the current user's password
         * @param type $attribute
         * @param type $params 
         */
        public function verify($attribute, $params) {
            
            $user=User::model()->find('LOWER(username)=?',array(strtolower($this->username)));
		if($user===null)
			$this->addError ('currentPassword', 'Incorrect Username');
		else if(!$user->validatePassword($this->currentPassword))
			$this->addError('currentPassword', 'Incorrect Password');
		else
		{
			
                }
            
            
        }
        
        public function save() {
            
            $username = Yii::app()->user->name;
  
            $user=User::model()->find('LOWER(username)=?',array(strtolower($username)));
            
            if($user===null)
			throw new CHttpException(404,'The requested page does not exist.');
            
            
                    $salt = $user->generateSalt();
                    $pass = $user->hashPassword($this->newPassword, $salt);
                    $user->password = $pass;
                    $user->salt = $salt;
                    $user->password_changed = date("Y-m-d H:i:s");
                    if($user->save())
                        return true;
                    else
                        return false;
            
        }
        
	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			//'verifyCode'=>'Verification Code',
		);
	}
}
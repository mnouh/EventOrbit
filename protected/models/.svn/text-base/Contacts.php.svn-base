<?php

/**
 * This is the model class for table "{{contacts}}".
 *
 * The followings are the available columns in table '{{contacts}}':
 * @property integer $id
 * @property string $contact_name
 * @property integer $user_id
 * @property string $contact_email
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Contacts extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Contacts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{contacts}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('id, user_id', 'numerical', 'integerOnly'=>true),
			array('contact_name, contact_email', 'required'),
                        array('contact_name, contact_email', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, contact_name, user_id, contact_email', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'contact_name' => 'Contact Name',
			'user_id' => 'User',
			'contact_email' => 'Contact Email',
		);
	}
        
        public function beforeSave() {
            parent::beforeSave();
            
            if (Yii::app()->user->isGuest)
                throw new CHttpException(404, 'The requested page does not exist.');
            
            $this->user_id = Yii::app()->user->id;
            
            return true;
            
        }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('contact_name',$this->contact_name,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('contact_email',$this->contact_email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "{{school}}".
 *
 * The followings are the available columns in table '{{school}}':
 * @property integer $school_id
 * @property string $email
 * @property string $name
 * @property string $city
 * @property string $state
 * @property integer $zipcode
 *
 * The followings are the available model relations:
 * @property User[] $users
 */
class School extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return School the static model class
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
		return '{{school}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, name, city, state, zipcode', 'required'),
			array('zipcode', 'numerical', 'integerOnly'=>true),
			array('email, name, city, state', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('school_id, email, name, city, state, zipcode', 'safe', 'on'=>'search'),
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
			'users' => array(self::HAS_MANY, 'User', 'school_id', 'together' => true),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'school_id' => 'School',
			'email' => 'Email',
			'name' => 'Name',
			'city' => 'City',
			'state' => 'State',
			'zipcode' => 'Zipcode',
		);
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

		$criteria->compare('school_id',$this->school_id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('zipcode',$this->zipcode);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "{{reviews}}".
 *
 * The followings are the available columns in table '{{reviews}}':
 * @property integer $id
 * @property integer $marker_id
 * @property integer $user_id
 * @property integer $rating
 * @property string $review
 */
class Reviews extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Reviews the static model class
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
		return '{{reviews}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rating, review', 'required'),
			array('rating', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, marker_id, user_id, rating, review', 'safe', 'on'=>'search'),
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
                    'marker' => array(self::BELONGS_TO, 'Marker', 'marker_id'),
                    'creator' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'marker_id' => 'Marker',
			'user_id' => 'User',
			'rating' => 'Rating',
			'review' => 'Review',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('marker_id',$this->marker_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('review',$this->review,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
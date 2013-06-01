<?php

/**
 * This is the model class for table "{{markers}}".
 *
 * The followings are the available columns in table '{{markers}}':
 * @property integer $id
 * @property string $name
 * @property string $categories
 * @property string $address
 * @property string $address0
 * @property string $address1
 * @property string $address2
 * @property string $address3
 * @property integer $phone
 * @property string $display_phone
 * @property string $lat
 * @property string $lng
 * @property string $postal_code
 * @property string $country_code
 * @property string $state_code
 * @property string $city
 * @property integer $num_reviews
 * @property double $rating
 *
 * The followings are the available model relations:
 * @property Events[] $events
 */
class Marker extends CActiveRecord
{
        public $distance;
        
        /**
	 * Returns the static model of the specified AR class.
	 * @return Marker the static model class
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
		return '{{markers}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, address, address0, address1, address2, address3, phone, display_phone, lat, lng, postal_code, country_code, state_code, city', 'required'),
			array('phone, num_reviews', 'numerical', 'integerOnly'=>true),
			array('rating', 'numerical'),
			array('name', 'length', 'max'=>60),
			array('categories', 'length', 'max'=>160),
			array('address, address0, address1, address2, address3, display_phone, postal_code, city', 'length', 'max'=>100),
			array('lat, lng', 'length', 'max'=>120),
			array('country_code, state_code', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, categories, address, address0, address1, address2, address3, phone, display_phone, lat, lng, postal_code, country_code, state_code, city, num_reviews, rating', 'safe', 'on'=>'search'),
		);
	}
        /**
         *This is to check if a user has liked a specific event. 
         */
        public function findUser()
        {
            if (Yii::app()->user->isGuest)
                throw new CHttpException(404, 'The requested page does not exist.');
            
            $user_id =  Yii::app()->user->id;
            $user_likes = Markerlikes::model()->find(array(
                    'condition' => 'marker_id=:marker_id AND user_id=:user_id',
                    'params' => array(':marker_id' => $this->id, ':user_id' => $user_id),
                        ));
            
            if($user_likes === NULL) {
                
                return false;
            }
            else {
                
                if($user_likes->status == 1)
                    return false;
                else
                return true;
            }
            
            
        }
        
        public function getDistance($lat, $lng) {
            
            
        $this->distance = (3959*acos(cos(deg2rad($lat))*cos(deg2rad((float)$this->lat))*cos(deg2rad((float)$this->lng)-deg2rad($lng))+sin(deg2rad($lat))*sin(deg2rad((float)$this->lat))));
            
        return $this->distance;    
            
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'events' => array(self::HAS_MANY, 'Events', 'marker_id'),
                        'firstCategory' => array(self::HAS_ONE, 'Categories', 'marker_id', 'condition' => 'rank=1'),
                        'reviews' => array(self::HAS_MANY, 'Reviews', 'marker_id', 'order' => 'reviews.date_created DESC'),
                        //'first_reviewed' => array(self::HAS_ONE, 'User', array('first_reviewed_by'=>'id'),'through'=> $this),
                    	'publicevents' => array(self::HAS_MANY, 'Events', 'marker_id', 'condition'=>'public=1'),
                        'privateevents' => array(self::HAS_MANY, 'Events', 'marker_id', 'condition'=>'public=0'),
                        'publicEventCount'=>array(self::STAT, 'Events', 'marker_id', 'condition'=>'public=1'),
                        'reviewCount'=>array(self::STAT, 'Reviews', 'marker_id'),
                        'userlikes'=>array(self::STAT, 'Markerlikes', 'marker_id', 'condition'=>'status=0'),
		);
	}
        
        /**
         *Calculates the Review of the Marker(Business). 
         * It takes the average of all reviews
         * @return int 
         */
        public function calculateReview()
        {
            $i = 0;
            $sum = 0;
            foreach($this->reviews as $review)
            {
                $sum +=$review->rating;
                
                $i++;
            }
            
            if($i == 0) {
                
                return 0;
            }
            else {
                
                return ($sum/$i);
                
            }
            
        }
        
        /**
         * Checks if the user reviewed the specific model. In this case the businesss. If he did review it, return the model.
         */
        public function userReviewed()
        {
            
            
            if (Yii::app()->user->isGuest)
                throw new CHttpException(404, 'The requested page does not exist.');
            
            $user_id = Yii::app()->user->id;

            $reviewed = Reviews::model()->find(array(
                    'select' => '*',
                    'condition' => 'user_id=:user_id AND marker_id=:marker_id',
                    'params' => array(':user_id' => $user_id, ':marker_id' => $this->id),
                        ));
            
            
            if($reviewed === NULL)
                return NULL;
            else
                return $reviewed;
            
        }
        
        public function findFirstReviewer()
        {
         
            if($this->first_reviewed_by === NULL)
                return NULL;
            else {
                
                
                $user = User::model()->findByPk($this->first_reviewed_by);
                
                if($user === NULL)
                    return NULL;
                    else
                        return $user;
            }
                
                
            
            
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'categories' => 'Categories',
			'address' => 'Address',
			'address0' => 'Address0',
			'address1' => 'Address1',
			'address2' => 'Address2',
			'address3' => 'Address3',
			'phone' => 'Phone',
			'display_phone' => 'Display Phone',
			'lat' => 'Lat',
			'lng' => 'Lng',
			'postal_code' => 'Postal Code',
			'country_code' => 'Country Code',
			'state_code' => 'State Code',
			'city' => 'City',
			'num_reviews' => 'Num Reviews',
			'rating' => 'Rating',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('categories',$this->categories,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('address0',$this->address0,true);
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('address3',$this->address3,true);
		$criteria->compare('phone',$this->phone);
		$criteria->compare('display_phone',$this->display_phone,true);
		$criteria->compare('lat',$this->lat,true);
		$criteria->compare('lng',$this->lng,true);
		$criteria->compare('postal_code',$this->postal_code,true);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('state_code',$this->state_code,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('num_reviews',$this->num_reviews);
		$criteria->compare('rating',$this->rating);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
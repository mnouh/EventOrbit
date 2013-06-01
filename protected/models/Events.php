<?php

/**
 * This is the model class for table "{{events}}".
 *
 * The followings are the available columns in table '{{events}}':
 * @property integer $id
 * @property integer $marker_id
 * @property string $date
 * @property string $event_name
 * @property string $start_time
 * @property string $end_time
 * @property string $details
 * @property string $guests
 * @property integer $public
 *
 * The followings are the available model relations:
 * @property Markers $marker
 */
class Events extends CActiveRecord
{
        public $business_name;
        public $contact_name;
        public $contact_email;
        public $countAttending;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Events the static model class
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
		return '{{events}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        //array('marker_id', 'unique'),
			array('start_date', 'required'),
			array('public, guest_list_view', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>120),
                        array('business_name', 'length', 'max'=>120),
			array('guests', 'length', 'max'=>200),
			array('start_date, start_time, end_date, end_time, details', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('start_date, name, start_time, end_date, countAttending, end_time, details, guests, public', 'safe', 'on'=>'search'),
		);
	}
        public function afterSave() {
            parent::afterSave();
        
            
            if($this->isNewRecord) {
            $model = Marker::model()->findByPk($this->marker_id);
            $model->num_events++;
            $model->update();
            
            //Yii::app()->user->contacts
            
            }
            
        }
        
        public function afterDelete() {
            parent::afterDelete();
            
            $model = Marker::model()->findByPk($this->marker_id);
            $model->num_events--;
            $model->update();
            
        }
        
        public function beforeSave() {
            parent::beforeSave();
            
            if (Yii::app()->user->isGuest)
                throw new CHttpException(404, 'The requested page does not exist.');
            
            $this->marker_id = $this->business_name;
            if($this->isNewRecord) {
                
            $parseDate = array();
            
            $parseDate = explode("-", $this->start_date);
            
            $this->start_date = $parseDate[2].'-'.$parseDate[0].'-'.$parseDate[1];
            
            
            //$this->start_date = strtotime($this->start_date);
                
                //$myDate = "".$this->start_date;
                $date = new DateTime($this->start_date);
                $this->start_date = $date->format('Y-m-d H:i:s');
                
            $parseEndDate = array();
            
            $parseEndDate = explode("-", $this->end_date);
            
            $this->end_date = $parseEndDate[2].'-'.$parseEndDate[0].'-'.$parseEndDate[1];
            
            $endDate = new DateTime($this->end_date);
            $this->end_date = $endDate->format('Y-m-d H:i:s');
            
            $this->user_id = Yii::app()->user->id;
            
            $model = Marker::model()->findByPk($this->marker_id);
            
            if($model != NULL){
            
            $eventurl = $model->city.' '.$this->name.' at '.$model->name;
            
            $pos = strpos($eventurl, '&');

                if ($pos === false) {
                    $eventurl = preg_replace('/\'/', '', $eventurl);
                    $eventurl = str_replace(" ", "-", $eventurl);
                } else {
                    $eventurl = preg_replace('/\'/', '', $eventurl);
                    $eventurl = preg_replace('/\&/', '-', $eventurl);
                    $eventurl = str_replace(" ", "", $eventurl);
                }
            
            
            $this->eventurl = $eventurl;
            }
                
            return true;
            
            
            }
            
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
                        'rsvps' => array(self::HAS_MANY, 'Rsvps', 'event_id', 'condition'=>'status=0'),
                        'countrsvp' => array(self::STAT, 'Rsvps', 'event_id', 'condition'=>'status=0'),
                        'discussion' => array(self::HAS_MANY, 'Eventdiscuss', 'event_id', 'order' => 'discussion.date DESC'),
		);
	}
        
        
        public function findUser() {
            
            if (Yii::app()->user->isGuest)
                throw new CHttpException(404, 'The requested page does not exist.');
            
            $user_id =  Yii::app()->user->id;
             $rsvp = Rsvps::model()->find(array(
                    'condition' => 'event_id=:event_id AND user_id=:user_id',
                    'params' => array(':event_id' => $this->id, ':user_id' => $user_id),
                        ));
             
             if($rsvp === NULL) {
                 
                 return false;
                 
             }
             else {
                 
                 return true;
             }
                
            //if()
            
        }
        
        
        /**
         * This functionc checks if the user made a RSVP and has a status of 1 or 0.
         * @return boolean
         * @throws CHttpException 
         */
        public function statusRsvp() {
            
            if (Yii::app()->user->isGuest)
                throw new CHttpException(404, 'The requested page does not exist.');
            
            $user_id =  Yii::app()->user->id;
             $rsvp = Rsvps::model()->find(array(
                    'condition' => 'event_id=:event_id AND user_id=:user_id',
                    'params' => array(':event_id' => $this->id, ':user_id' => $user_id),
                        ));
             
             if($rsvp === NULL)
                 return false;
             
             if($rsvp->status == 0) {
                 
                 return true;
                 
             }
             
             if($rsvp->status == 1) {
                 
                 return false;
             }
                
            //if()
            
        }
        
        
        

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'marker_id' => 'Marker',
			'start_date' => 'Date',
			'name' => 'Event Name',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
			'details' => 'Details',
			'guests' => 'Guests',
			'public' => 'Public',
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
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('details',$this->details,true);
		$criteria->compare('guests',$this->guests,true);
		$criteria->compare('public',$this->public);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
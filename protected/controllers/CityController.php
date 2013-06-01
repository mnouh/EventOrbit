<?php

class CityController extends Controller
{
        public $layout = 'main';
        
	public function actionIndex()
	{
        $lat = '';
        $lng = '';
            
        $city_url = Yii::app()->request->getQuery('city_url');
        $saved_url = $city_url;
        $model = Cities::model()->find("city_url='" . $city_url . "'");
        
        if($model != null)
            $lat = $model->latitude;
            $lng = $model->longitude;
        
        if ($model === null) {
            //throw new CHttpException(404, 'The requested page does not exist.');
            
            $location = explode('-', $city_url);
            if(isset($location[1])) {
            
            $model = Cities::model()->find("name='" . $location[0] . "' AND state= '" . $location[1] . "'");
            }
            
            if($model === null)
            {
                
                
                $google_key = '';
            $GMap = new GMaps($google_key);
            if ($GMap->getInfoLocation($saved_url)) {

                $radius = 20;
                $lat = $GMap->getLatitude();
                $lng = $GMap->getLongitude();
                
                
                
                $criteria = new CDbCriteria;

                $formula = '(3959*acos(cos(radians(:baselat))*cos(radians(latitude))*cos(radians(longitude)-radians(:baselng))+sin(radians(:baselat))*sin(radians(latitude))))';

                $criteria->select = "*, $formula as distance";

                $criteria->order = "distance ASC";
                //$criteria->condition = "id <> 2";
                
                $criteria->having = 'distance <=' . $radius;
            
            $params = array(':baselat' => $lat,
                ':baselng' => $lng,
                //':venue' => 'pacha',
                ':range' => '20'
            );

            
                //echo 'hello';
                $sql = "SELECT $criteria->select FROM tbl_cities"
                        //. " WHERE $criteria->condition "
                        . " HAVING $criteria->having "
                        . " ORDER by $criteria->order";
            
                
                //$sql .= " LIMIT 1";



                $model = Cities::model()->findBySql($sql, $params);
                
                
                if($model === null)
                    throw new CHttpException(404, 'The requested page does not exist.');
                
                }
                
                
                
                
            }
        }
        
         
        
        
            $sort = new CSort();
  $sort->attributes = array(
      '*', // add all of the other columns as sortable
  );
        
        $topCat = '';
        
        
        $radius = 20;
        $dataEventsProvider=new CActiveDataProvider('Events', array(
        'criteria'=>array(
        //'select' => 'SELECT * FROM tbl_events (LEFT JOIN tbl_markers m on tbl_events.marker_id = m.id) WHERE (SELECT COUNT(tbl_rsvps.id) as Attending FROM tbl_rsvps WHERE tbl_events.id = tbl_rsvps.event_id ORDER BY Attending DESC);',    
        'alias' => 'Events',    
        'join' => 'LEFT JOIN tbl_markers m ON Events.marker_id = m.id',
        'condition'=>"(m.categories LIKE '%$topCat%') AND ((3959*acos(cos(radians($lat))*cos(radians(m.lat))*cos(radians(m.lng)-radians($lng))+sin(radians($lat))*sin(radians(m.lat)))) <= $radius)",
        'order' => "(3959*acos(cos(radians($lat))*cos(radians(m.lat))*cos(radians(m.lng)-radians($lng))+sin(radians($lat))*sin(radians(m.lat)))) ASC",
        
    ),
        'sort'=>$sort,
    'pagination'=>array(
        'pageSize'=>10,
        
    ),
        
));
        
            
            
		$this->render('index', array('model' => $model, 'dataEventsProvider' => $dataEventsProvider));
	}
        
        
        public function actionAutoComplete() {
        $res = array();
        $term = Yii::app()->getRequest()->getParam('term', false);
        if ($term) {
            // test table is for the sake of this example
            $sql = 'SELECT id, name FROM {{cities}} where LCASE(name) LIKE :name LIMIT 20';
            $cmd = Yii::app()->db->createCommand($sql);
            $cmd->bindValue(":name", "%" . strtolower($term) . "%", PDO::PARAM_STR);
            $res = $cmd->queryAll();
        }
        echo CJSON::encode($res);
        Yii::app()->end();
        
        
        }
        
        
        
        
        public function actionTest()
        {
            $google_key = '';
            $zip_code = 'Binghamton';
            $GMap = new GMaps($google_key);
            if ($GMap->getInfoLocation($zip_code)) {

                
                $address = $GMap->getAddress();
                $pieces = explode(',', $address);
                echo $city = $pieces[0].'<br>';
                echo $state = $GMap->getAdministrativeAreaName();
                $lat = $GMap->getLatitude();
                $lng = $GMap->getLongitude();
                
                echo $lat.'<br>';
                echo $lng.'<br>';
                
                }
            
            $this->render('test');
            
        }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
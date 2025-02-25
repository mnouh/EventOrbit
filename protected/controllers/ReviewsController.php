<?php

class ReviewsController extends Controller {

    public $layout = 'main';
    
    
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }
    
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create'),
                'users' => array('@'),
            ),
            /*array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
             */
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    

    public function actionIndex() {
        $this->render('index');
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

    
    /**
     * This create a new review for a specific marker(business).
     * @param type $bizurl 
     */
    public function actionCreate($bizurl) {

        $bizurl = Yii::app()->request->getQuery('bizurl');
        $criteria = new CDbCriteria;
        $criteria->condition = "bizurl = :bizurl";

        $criteria->params = array(':bizurl' => $bizurl
        );

        $business = Marker::model()->find($criteria);

        $reviewed = $business->userReviewed();
        
        
        if($reviewed === NULL) {
        
            
          $model = new Reviews;
          

          if (isset($_POST['Reviews'])) {
          $model->attributes = $_POST['Reviews'];
          $model->marker_id = $business->id;
          $model->user_id = Yii::app()->user->id;
          $model->date_created = new CDbExpression('NOW()');
          if ($model->save()) {
          
              if($business->first_reviewed_by === NULL) {
                  
                  $business->first_reviewed_by = $model->user_id;
                  
                  $business->update();
                  
              }
              
              $this->redirect(array('reviews/'.$business->bizurl));
          }
          }

          
        $this->render('create', array(
            'model' => $model,
            'business' => $business,
                //'default' => $default,
                //'contact' => $contact,
        ));
    }
    else {
        
        //Going to make this actually look at the review.
        $this->redirect(array('account/profile'));
        
        
    }
    
    
    }
    
    
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView() {
        $category_search = array();

        $bizurl = Yii::app()->request->getQuery('bizurl');
        $model = Marker::model()->find("bizurl='" . $bizurl . "'");
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');



        $model->viewed++;
        $model->update();
        $category_search = explode(",", $model->categories);
        $lat = $model->lat;
        $lng = $model->lng;
        $radius = 10;

        $search_condtion = '';
        $sql = '';


        if (isset($lat) && isset($lng) && isset($radius)) {
            $category_filter = NULL;
            $name_filter = $model->name;



            // Start XML file, create parent node
            $dom = new DOMDocument("1.0");
            $node = $dom->createElement("markers");
            $parnode = $dom->appendChild($node);

            $criteria = new CDbCriteria;

            $formula = '(3959*acos(cos(radians(:baselat))*cos(radians(lat))*cos(radians(lng)-radians(:baselng))+sin(radians(:baselat))*sin(radians(lat))))';



            $criteria->select = "*, $formula as distance";

            $criteria->order = "distance ASC";

            foreach ($category_search as $category) {
                $search_condtion = $search_condtion . "'%" . $category . "%'" . " OR categories LIKE ";
                //$criteria->condition = "(cat1 = :venue OR cat2 = :venue OR cat3 = :venue OR cat4 = :venue)";
            }
            //$criteria->condition = "(categories LIKE '%$category_filter% AND categories LIKE')";
            
            
            $topCat = $model->firstCategory->name;
            if(empty($topCat))
            $topCat = end($category_search);
            
            
            $search_condtion = substr($search_condtion, 0, -20); //when switched to OR need to be -20, AND = -21
            $criteria->condition = "id <> $model->id AND (categories LIKE '%$topCat%')";

            //echo $criteria->condition;

            $criteria->having = 'distance <=' . $radius;



            $params = array(':baselat' => $lat,
                ':baselng' => $lng,
                //':venue' => 'pacha',
                ':range' => '20'
            );

            if (isset($category_search)) {
                //echo 'hello';
                $sql = "SELECT $criteria->select FROM tbl_markers"
                        . " WHERE $criteria->condition "
                        . " HAVING $criteria->having "
                        . " ORDER by $criteria->order";
            }


            //echo $sql;


            $pages = new CPagination(Marker::model()->countBySql($sql, $params));

            $pages->pageSize = 10;

            $pages->applyLimit($criteria);



            $sql .= " LIMIT $criteria->limit OFFSET $criteria->offset";



            $venues = Marker::model()->findAllBySql($sql, $params);

$rating = NULL;

if(isset($_GET['rate']))
    $rating = $_GET['rate'];
            
            $sort = new CSort();
  $sort->attributes = array(
    '*', // add all of the other columns as sortable
  );
    
    $dataProvider=new CActiveDataProvider('Reviews', array(
    'criteria'=>array(
        'condition'=>'marker_id='.$model->id.' AND rating LIKE "%'.$rating.'"',
        //'order'=>'date_created ASC',
        //'with'=>array('creator'),
    ),
        'sort'=>$sort,
    'pagination'=>array(
        'pageSize'=>2,
        
    ),
        
));
            
            
            
            



            $this->render('view', array(
                'model' => $model,
                'category' => $category_search,
                'venues' => $venues,
                'dataProvider' => $dataProvider,
            ));
        }
    }

}
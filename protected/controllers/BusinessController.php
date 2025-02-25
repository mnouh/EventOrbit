<?php

class BusinessController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'main';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
       /* array(
            'ESetReturnUrlFilter',
            // Use for spcified actions (index and view):
            // 'ESetReturnUrlFilter + index, view',
         )*/
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
                'actions' => array('index', 'view', 'locate', 'search', 'likebiz', '*'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    protected function escape($value) {
        $return = '';
        for ($i = 0; $i < strlen($value); ++$i) {
            $char = $value[$i];
            $ord = ord($char);
            if ($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126)
                $return .= $char;
            else
                $return .= '\\x' . dechex($ord);
        }
        return $return;
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


            
            //$topCat = 'hookah_bar';
            
            
            //echo $model->firstCategory->name;

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


            $sort = new CSort();
  $sort->attributes = array(
    '*', // add all of the other columns as sortable
  );
    
    $dataProvider=new CActiveDataProvider('Events', array(
    'criteria'=>array(
        'condition'=>'marker_id='.$model->id.' AND status=0',
        //'order'=>'date_created ASC',
        //'with'=>array('creator'),
    ),
        'sort'=>$sort,
    'pagination'=>array(
        'pageSize'=>2,
        
    ),
        
));
    
        
            //$radius_model = 10;
        
            
        $dataEventsProvider=new CActiveDataProvider('Events', array(
        'criteria'=>array(
        'alias' => 'Events',
        'join' => 'LEFT JOIN tbl_markers m ON Events.marker_id = m.id',
        'condition'=>"m.id <> $model->id AND (m.categories LIKE '%$topCat%') AND ((3959*acos(cos(radians($lat))*cos(radians(m.lat))*cos(radians(m.lng)-radians($lng))+sin(radians($lat))*sin(radians(m.lat)))) <= $radius)",
        'order' => "(3959*acos(cos(radians($lat))*cos(radians(m.lat))*cos(radians(m.lng)-radians($lng))+sin(radians($lat))*sin(radians(m.lat)))) ASC",
        
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
                'dataEventsProvider' => $dataEventsProvider,
            ));
        }
    }

    public function actionSearch() {
        Yii::app()->params['public'] = false;
        $this->layout = 'secondary';
        $google_key = '';
        $model = new FindPartyForm;

        $this->performAjaxValidation($model, 'findparty-form');


        if (isset($_POST['FindPartyForm'])) {
            $model->attributes = $_POST['FindPartyForm'];


            $GMap = new GMaps($google_key);
            if ($GMap->getInfoLocation($model->addressInput)) {

                $lat = $GMap->getLatitude();
                $lng = $GMap->getLongitude();
            }

            if ($model->validate()) {


                $model = new SearchForm;
                $category_search = array();
                $search_condtion = '';
                $sql = '';
                //$this->performAjaxValidation($model, 'findparty-form');

                /*
                  // if it is ajax validation request
                  if(isset($_POST['ajax']) && $_POST['ajax']==='findparty-form')
                  {
                  echo CActiveForm::validate($model);
                  Yii::app()->end();
                  }
                 */
                // collect user input data
                //if (isset($_POST['SearchForm'])) {
                //  $model->attributes = $_POST['SearchForm'];


                if (isset($_GET['lat']) && isset($_GET['lng']) && isset($_GET['radius'])) {
                    $category_filter = NULL;

                    if (isset($_GET['cat_filter'])) {

                        $category_filter = $_GET['cat_filter'];
                        $category_filter = substr($category_filter, 0, -1);
                        $category_search = explode(",", $category_filter);
                    }

                    //$lat = $_GET['lat'];
                    //$lng = $_GET['lng'];
                    $radius = $_GET['radius'];


                    // Start XML file, create parent node
                    $dom = new DOMDocument("1.0");
                    $node = $dom->createElement("markers");
                    $parnode = $dom->appendChild($node);

                    $criteria = new CDbCriteria;

                    $formula = '(3959*acos(cos(radians(:baselat))*cos(radians(lat))*cos(radians(lng)-radians(:baselng))+sin(radians(:baselat))*sin(radians(lat))))';



                    $criteria->select = "address, display_phone, address0, address1, address2, address3, categories, name, lat, lng, $formula as distance";

                    $criteria->order = "distance ASC";

                    foreach ($category_search as $category) {
                        $search_condtion = $search_condtion . "'%" . $category . "%'" . " AND categories LIKE ";
                        //$criteria->condition = "(cat1 = :venue OR cat2 = :venue OR cat3 = :venue OR cat4 = :venue)";
                    }
                    //$criteria->condition = "(categories LIKE '%$category_filter% AND categories LIKE')";

                    $search_condtion = substr($search_condtion, 0, -21); //when switched to OR need to be -20, AND = -21
                    $criteria->condition = "(categories LIKE $search_condtion)";

                    //echo $criteria->condition;

                    $criteria->having = 'distance <=' . $radius;



                    $params = array(':baselat' => $lat,
                        ':baselng' => $lng,
                        //':venue' => 'pacha',
                        ':range' => '20'
                    );

                    if (isset($_GET['cat_filter'])) {
                        //echo 'hello';
                        $sql = "SELECT $criteria->select FROM tbl_markers"
                                . " WHERE $criteria->condition "
                                . " HAVING $criteria->having "
                                . " ORDER by $criteria->order";
                    } else {
                        // echo 'Test';

                        $sql = "SELECT $criteria->select FROM tbl_markers"
                                // . " WHERE $criteria->condition "
                                . " HAVING $criteria->having "
                                . " ORDER by $criteria->order";
                    }


                    //echo $sql;




                    $pages = new CPagination(Marker::model()->countBySql($sql, $params));

                    $pages->pageSize = 20;

                    $pages->applyLimit($criteria);



                    $sql .= " LIMIT $criteria->limit OFFSET $criteria->offset";



                    $venues = Marker::model()->findAllBySql($sql, $params);

                    if ($venues == NULL) {

                        echo 'No Result';
                        //$this->redirect('noresult');
                    } else {

                        // Iterate through the rows, adding XML nodes for each
                        foreach ($venues as $location) {
                            $node = $dom->createElement("marker");
                            $newnode = $parnode->appendChild($node);
                            $newnode->setAttribute("name", $location->name);
                            $newnode->setAttribute("address", $location->address);
                            $newnode->setAttribute("lat", $location->lat);
                            $newnode->setAttribute("lng", $location->lng);
                            $newnode->setAttribute("distance", $location->distance);
                        }

                        //$data = $dom->saveXML();
                        //echo $data;
                        /*
                          foreach($venues as $bus) {

                          echo 'Name of Business: '.$bus->name.' Display Phone: '.$bus->display_phone.'<br>'.$bus->address0.'<br>'.$bus->address1.'<br>'.$bus->address2.'<br>'.$bus->address3.'<br>------------------<br>';

                          } */
                    }
                }
            }
        } else {

            echo '&nbsp;';
            $this->render('search', array('model' => $model));
        }
    }

    public function actionLocate() {

        $this->layout = 'secondary';
        $category_search = array();
        $search_condtion = '';

        if (isset($_GET['lat']) && isset($_GET['lng']) && isset($_GET['radius'])) {
            $category_filter = NULL;
            $name_filter = NULL;

            if (isset($_GET['cat_filter'])) {

                $category_filter = $_GET['cat_filter'];
                $category_filter = substr($category_filter, 0, -1);
                $category_search = explode(",", $category_filter);
            }

            if (isset($_GET['name_filter'])) {

                $name_filter = $_GET['name_filter'];
                
            }


            $lat = $_GET['lat'];
            $lng = $_GET['lng'];
            $radius = $_GET['radius'];


            // Start XML file, create parent node
            $dom = new DOMDocument("1.0");
            $node = $dom->createElement("markers");
            $parnode = $dom->appendChild($node);

            $criteria = new CDbCriteria;

            $formula = '(3959*acos(cos(radians(:baselat))*cos(radians(lat))*cos(radians(lng)-radians(:baselng))+sin(radians(:baselat))*sin(radians(lat))))';



            $criteria->select = "*, $formula as distance";

            $criteria->order = "distance ASC";

            foreach ($category_search as $category) {
                $search_condtion = $search_condtion . "'%" . $category . "%'" . " AND categories LIKE ";
                //$criteria->condition = "(cat1 = :venue OR cat2 = :venue OR cat3 = :venue OR cat4 = :venue)";
            }
            //$criteria->condition = "(categories LIKE '%$category_filter% AND categories LIKE')";

            $search_condtion = substr($search_condtion, 0, -21); //when switched to OR need to be -20, AND = -21
            $criteria->condition = "(categories LIKE $search_condtion AND name LIKE :venue)";

            //echo $criteria->condition;

            $criteria->having = 'distance <= :range';

            $name_filter = '%'.$name_filter.'%';

            $criteria->params = array(':baselat' => $lat,
                ':baselng' => $lng,
                ':venue' => $name_filter,
                ':range' => $radius
            );



            $pages = new CPagination(Marker::model()->count($criteria));

            $pages->pageSize = 10;

            $pages->applyLimit($criteria);

            $venues = Marker::model()->findAll($criteria);
            
            //echo $venues->publicEventCount;
            

            if ($venues == NULL) {

                
                $node = $dom->createElement("marker");
                    $newnode = $parnode->appendChild($node);
                    $newnode->setAttribute("name", 'Your Location');
                    $newnode->setAttribute("address", 'Sorry Could Not Find Your Search');
                    $newnode->setAttribute("lat", $lat);
                    $newnode->setAttribute("lng", $lng);
                    $newnode->setAttribute("distance", '0');
                
                    $data = $dom->saveXML();
                echo $data;
                echo 'No Result';
                
                //$this->redirect('noresult');
            } else {

                // Iterate through the rows, adding XML nodes for each
                foreach ($venues as $location) {
                    $node = $dom->createElement("marker");
                    $newnode = $parnode->appendChild($node);
                    $newnode->setAttribute("name", $location->name);
                    $newnode->setAttribute("address", $location->address);
                    $newnode->setAttribute("lat", $location->lat);
                    $newnode->setAttribute("lng", $location->lng);
                    $newnode->setAttribute("distance", $location->distance);
                }
                

                $data = $dom->saveXML();
                echo $data;
                $this->renderPartial('locate', array('venues'=>$venues, 'pages'=>$pages), false, true);
                
            
            
            }
        }
    }
    
    public function actionLikeBiz(){
        
        
        
        
        if (Yii::app()->user->isGuest)
                throw new CHttpException(404, 'The requested page does not exist.');
            
            $user_id =  Yii::app()->user->id;
        
        if(isset($_GET['id']) && !empty($_GET['id'])) {
            
            $id = $_GET['id'];
            
            
            $user_likes = Markerlikes::model()->find(array(
                    'condition' => 'marker_id=:marker_id AND user_id=:user_id',
                    'params' => array(':marker_id' => $id, ':user_id' => $user_id),
                        ));
            
            $business = Marker::model()->findByPk($id);
            
            if($user_likes === NULL) {
                
                $model = new Markerlikes;
                $model->user_id = $user_id;
                $model->marker_id = $id;
                $model->status = 0;
                
                if($model->save()) {
                    
                    
                    echo CHtml::ajaxLink(
                                        'Unlike',
                                        array('business/likebiz?id='.$id),
                                        array('success'=>"js:function(data) {
                                                    jQuery('div#like').html(data);
                                               }",
                                                //'update'=>'#successMessage',
                                                'beforeSend' => 'function() {}',
                                                //'validated' => 'function() {changeButton();}',
                                                'complete' => 'function() {}',
                                                'type' => 'POST'
                                        ),
                                array('class'=>'submitButtonAll')
                                );
                    
                        if($business->userlikes == 1)
                            echo '1 person likes this.';
                        else if($business->userlikes > 1)
                            echo $business->userlikes.' people like this.';
                    
                    
                }
                else {
                    
                    echo 'We encountered a problem, please try again later.';
                    
                }
                
                
            }
            else {
            
            if($user_likes->status == 0) {
                 
                    $user_likes->status = 1;
                    if($user_likes->update()) {
                            
                    echo CHtml::ajaxLink(
                                        'Like',
                                        array('business/likebiz?id='.$id),
                                        array('success'=>"js:function(data) {
                                                    jQuery('div#like').html(data);
                                               }",
                                                //'update'=>'#successMessage',
                                                'beforeSend' => 'function() {}',
                                                //'validated' => 'function() {changeButton();}',
                                                'complete' => 'function() {}',
                                                'type' => 'POST'
                                        ),
                                array('class'=>'submitButtonAll')
                                );
         
                
                        if($business->userlikes == 0)
                            echo '0 people like this.';
                        if($business->userlikes == 1)
                            echo '1 person likes this.';
                        if($business->userlikes > 1)
                            echo $business->userlikes.' people like this.';
                    }
                }
                elseif($user_likes->status == 1) {
                    
                    $user_likes->status = 0;
                    if($user_likes->update()) {
                        
                        echo CHtml::ajaxLink(
                                        'Unlike',
                                        array('business/likebiz?id='.$id),
                                        array('success'=>"js:function(data) {
                                                    jQuery('div#like').html(data);
                                               }",
                                                //'update'=>'#successMessage',
                                                'beforeSend' => 'function() {}',
                                                //'validated' => 'function() {changeButton();}',
                                                'complete' => 'function() {}',
                                                'type' => 'POST'
                                        ),
                                array('class'=>'submitButtonAll')
                                );
                        
                        
                        
                        
                        if($business->userlikes == 0)
                            echo '0 people like this.';
                        if($business->userlikes == 1)
                            echo '1 person likes this.';
                        if($business->userlikes > 1)
                            echo $business->userlikes.' people like this.';
                        
                    }
                }
                
                
            }
            
        }
        
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Marker;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Marker'])) {
            $model->attributes = $_POST['Marker'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Marker'])) {
            $model->attributes = $_POST['Marker'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Marker');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Marker('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Marker']))
            $model->attributes = $_GET['Marker'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        //$model=Marker::model()->findByPk($id);
        $model = Marker::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'marker-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}

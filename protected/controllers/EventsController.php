<?php

class EventsController extends Controller {

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
        );
    }

    public function actions() {
        return array(
            'aclist' => array(
                'class' => 'application.extensions.EAutoCompleteAction',
                'model' => 'Events', //My model's class name
                'attribute' => 'event_name', //The attribute of the model i will search
            ),
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
                'actions' => array('index', 'view', 'autocomplete', 'addcontact', 'adduser', 'likebiz', 'locate'),
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

    // This function will echo a JSON object 
// of this format:
// [{id:id, name: 'name'}]
    public function actionAutoComplete() {
        $res = array();
        $term = Yii::app()->getRequest()->getParam('term', false);
        if ($term) {
            // test table is for the sake of this example
            $sql = 'SELECT id, name FROM {{events}} where LCASE(name) LIKE :name';
            $cmd = Yii::app()->db->createCommand($sql);
            $cmd->bindValue(":name", "%" . strtolower($term) . "%", PDO::PARAM_STR);
            $res = $cmd->queryAll();
        }
        echo CJSON::encode($res);
        Yii::app()->end();
    }
    
    
    public function actionLocate(){
        
                    $lat = 40.7638074;
                    $lng = -73.9821237;
        
                    $dom = new DOMDocument("1.0");
                    $node = $dom->createElement("markers");
                    $parnode = $dom->appendChild($node);
                    $node = $dom->createElement("marker");
                    $newnode = $parnode->appendChild($node);
                    $newnode->setAttribute("name", 'Your Location');
                    $newnode->setAttribute("address", 'Sorry Could Not Find Your Search');
                    $newnode->setAttribute("lat", $lat);
                    $newnode->setAttribute("lng", $lng);
                    $newnode->setAttribute("distance", '0');
                
                    $data = $dom->saveXML();
                    echo $data;
        
                    echo "Testing";
        
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($eventurl) {
        
        $eventurl = Yii::app()->request->getQuery('eventurl');
        $criteria = new CDbCriteria;
        $criteria->condition = "eventurl = :eventurl";

        $criteria->params = array(':eventurl' => $eventurl
        );

        $event = Events::model()->find($criteria);
        
        if($event === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        
        
        $this->render('view', array(
            'model' => $event,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($bizurl) {

        $bizurl = Yii::app()->request->getQuery('bizurl');
        $criteria = new CDbCriteria;
        $criteria->condition = "bizurl = :bizurl";

        $criteria->params = array(':bizurl' => $bizurl
        );

        $business = Marker::model()->find($criteria);

        $model = new Events;
        $contact = new Contacts;
        
        
        //$model->marker_id = $business->id;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Events'])) {
            $model->attributes = $_POST['Events'];
            $model->date_created = new CDbExpression('NOW()');
            if ($model->save())
                $this->redirect(array('event/'.$model->eventurl));
        }
        
        $default[] = array('id' => '3', 'name' => 'Terminal 5');
        
        //header('Content-type: application/json');

        $this->render('create', array(
            'model' => $model,
            'business' => $business,
            'default' => $default,
            'contact' => $contact,
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

        if (isset($_POST['Events'])) {
            $model->attributes = $_POST['Events'];
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
        $dataProvider = new CActiveDataProvider('Events');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Events('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Events']))
            $model->attributes = $_GET['Events'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }
    
    public function actionAddUser(){
        
        
        //echo 'Q: '.$q.'<br>';
        if(isset($_GET['id'])) {
            
            $id = $_GET['id'];
            $user_id = Yii::app()->user->id;
            
            $event = Events::model()->findByPk($id);
            
            if(!$event->findUser()) {
            $addUser = new Rsvps;
            
            $addUser->event_id = $id;
            $addUser->user_id = $user_id;
            $addUser->status = 0;
            
            if($addUser->save())
                echo "Yes";
            else
                echo "There seems to be a problem";
            
            }
            else {
                
                $rsvp = Rsvps::model()->find(array(
                    'condition' => 'event_id=:event_id AND user_id=:user_id',
                    'params' => array(':event_id' => $id, ':user_id' => $user_id),
                        ));
                if($rsvp->status == 0) {
                $rsvp->status = 1;
                if($rsvp->update())
                    echo 'No';
                
                }
                else {
                $rsvp->status = 0;
                if($rsvp->update())
                    echo 'Yes';
                }
            }
            
            
            
        }
        //echo 'Testing';
        
    }
    

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Events::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    
    public function actionAddContact() {
        
        $contact = new Contacts;
        
        $this->performAjaxValidation($contact, 'contact-form');

        if (isset($_POST['Contacts'])) {
            $contact->attributes = $_POST['Contacts'];
        
            if($contact->validate()) {
                
                if (Yii::app()->user->isGuest)
                throw new CHttpException(404, 'The requested page does not exist.');

                
                $user_id = Yii::app()->user->id;
                $find_contact = Contacts::model()->find(array(
                    'select' => 'user_id, id, contact_name, contact_email',
                    'condition' => 'contact_email=:contact_email AND user_id=:user_id',
                    'params' => array(':contact_email' => $contact->contact_email, 
                        ':user_id' => $user_id),
                        ));
                
                if($find_contact === NULL) {
                    
                    if($contact->save()) {
                    ?>
                    <script type="text/javascript">
                        contactClean();
                    </script>
                        
            <div class="floatR" style="width:65%; margin-bottom:0px; float:none; margin-top: 10px; background:none; border:none; padding:0px;">
                <div class="blocksArea">
    <div class="areaBtm" id="notif" style="display:block;">
      <ul>
        <li><a href="#"><?php echo Yii::app()->user->firstName.' '.Yii::app()->user->lastName; ?></a> added <a href="#"><?php echo ' '.$contact->contact_name.' '; ?></a> to their contact lists.</li>
      </ul>
    </div>
  </div>
            </div>
                    
                      <?php  
                    }
                    else {
                        
                        echo 'I could not add the contact';
                        
                    }
                    
                    
                    
                }
                else {
                    
                    echo 'Contact Already Exists with that email';
                    
                }
                
            }
        }
        
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $form) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}

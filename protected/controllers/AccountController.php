<?php

class AccountController extends Controller {

    public $layout = 'main';

    /**
     * Declares class-based actions.
     */
    public function actionIndex() {
        $this->layout = 'index';

        
        $google_key = '';
        $lat;
        $lng;
        
        

        $model = new FindPartyForm;

        $this->performAjaxValidation($model, 'findparty-form');

        

        if (isset($_POST['FindPartyForm'])) {
            $model->attributes = $_POST['FindPartyForm'];

            $GMap = new GMaps($google_key);
            if ($GMap->getInfoLocation($model->addressInput)) {

                $lat = $GMap->getLatitude();
                $lng = $GMap->getLongitude();
                
                echo $lat;
                echo $lng;
            }

            if ($model->validate()) {

                //echo 'Testing and shit';    
                //echo $model->id.'<br>';
                //echo $model->addressInput;
               $this->redirect(array('business/search', 'location' => $model->addressInput, 'lat' => $lat, 'lng' => $lng, 'radius' => 10));
            }
        }
        
        // display the login form
        $this->render('index', array('model' => $model));
        
        
    }

    public function actionBusinessFinder() {
        $google_key = '';
        $lat;
        $lng;

        $model = new FindPartyForm;

        if (isset($_POST['addressInput']) && !empty($_POST['addressInput'])) {

            $model->addressInput = $_POST['addressInput'];

            if (isset($_POST['nameInput']) && !empty($_POST['nameInput'])) {

                $model->nameInput = $_POST['nameInput'];


                $GMap = new GMaps($google_key);
                if ($GMap->getInfoLocation($model->addressInput)) {

                    $lat = $GMap->getLatitude();
                    $lng = $GMap->getLongitude();
                }

                //Need to do module validate

                $this->redirect(array('business/search', 'location' => $model->addressInput, 'lat' => $lat, 'lng' => $lng, 'radius' => 10, 'name_filter' => $model->nameInput));
            } else {


                $GMap = new GMaps($google_key);
                if ($GMap->getInfoLocation($model->addressInput)) {

                    $lat = $GMap->getLatitude();
                    $lng = $GMap->getLongitude();
                }

                //Need to do module validate

                $this->redirect(array('business/search', 'location' => $model->addressInput, 'lat' => $lat, 'lng' => $lng, 'radius' => 10));
            }
        }
        //$model->attributes = $_POST['FindPartyForm'];
    }

    public function actionSearcher() {

        $this->renderPartial('searcher');
    }
    
    public function actionContacts($q) {

        //$this->render('find');



        $term = trim($q);
        $result = array();

        if (!empty($term)) {
            $criteria = new CDbCriteria;
            $criteria->select = "id, contact_name, user_id, contact_email";


            $criteria->condition = "(contact_name LIKE :venue OR contact_email LIKE :venue) AND user_id = :owner";

            //echo $criteria->condition;

            $user_id = NULL;
            if (!Yii::app()->user->isGuest) {

                $user_id = Yii::app()->user->id;
            }

            $term = '%' . $term . '%';

            $criteria->params = array(
                ':venue' => $term,
                ':owner' => $user_id,
            );
            $criteria->limit = 5;
            $cursor = Contacts::model()->findAll($criteria);


            //$cursor = Marker::model()->query()->findCursor(array('name' => new MongoRegex('/' . $term . '/i')), array('name'), array('name' => 1), 10);

            if ($cursor != NULL) {
                // echo "Test";
                foreach ($cursor as $id => $value) {
                    
                    $result[] = array('id' => $value['id'], 'name' => $value['contact_name'], 'email' => $value['contact_email']);
                }
            }
            
        }

        header('Content-type: application/json');
        echo CJSON::encode($result);
        Yii::app()->end();
    }

    public function filters() {
        return array(
            array(
                'COutputCache',
                'duration' => 100,
            //'varyByParam'=>array('view'),
            ),
                /*
                  array(
                  'ESetReturnUrlFilter',
                  // Use for spcified actions (index and view):
                  // 'ESetReturnUrlFilter + index, view',
                  ), */
        );
    }

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }
    
    public function actionCategoryParse()
    {
        
        $this->render('categoryparse');
    }
    
    public function actionCloseEvents()
    {
        
            $model = Marker::model()->findByPk(292);
        
            $radius = 10;
            $lat = $model->lat;
            $lng = $model->lng;
        
            $criteria = new CDbCriteria;

            $formula = '(3959*acos(cos(radians(:baselat))*cos(radians(lat))*cos(radians(lng)-radians(:baselng))+sin(radians(:baselat))*sin(radians(lat))))';


            $topCat = $model->firstCategory->name;
            //$topCat = 'hookah_bar';
            
            
            //echo $model->firstCategory->name;

            $criteria->select = "*, $formula as distance";

            $criteria->order = "distance ASC";

            //$criteria->condition = "(categories LIKE '%$category_filter% AND categories LIKE')";
            if(empty($topCat))
            $topCat = end($category_search);
            
            //$search_condtion = substr($search_condtion, 0, -20); //when switched to OR need to be -20, AND = -21
            $criteria->condition = "id <> $model->id AND (categories LIKE '%$topCat%')";

            //echo $criteria->condition;

            $criteria->having = 'distance <=' . $radius;



            $params = array(':baselat' => $lat,
                ':baselng' => $lng,
                //':venue' => 'pacha',
                ':range' => '20'
            );

            
                //echo 'hello';
                $sql = "SELECT $criteria->select FROM tbl_markers"
                        . " WHERE $criteria->condition "
                        . " HAVING $criteria->having "
                        . " ORDER by $criteria->order";
            


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
        
        $this->render('closeevents', array(
            'dataEventsProvider' => $dataEventsProvider,
            
            ));
        
    }

    /*
     * This is made to do autocomplete for the businesss.
     * 
     */

    public function actionAutoComplete() {
        $res = array();
        $term = Yii::app()->getRequest()->getParam('term', false);
        if ($term) {
            // test table is for the sake of this example
            $sql = 'SELECT id, name FROM {{markers}} where LCASE(name) LIKE :name LIMIT 20';
            $cmd = Yii::app()->db->createCommand($sql);
            $cmd->bindValue(":name", "%" . strtolower($term) . "%", PDO::PARAM_STR);
            $res = $cmd->queryAll();
        }
        echo CJSON::encode($res);
        Yii::app()->end();
    }

    public function actionFind($q) {

        //$this->render('find');



        $term = trim($q);
        $result = array();

        if (!empty($term)) {
            $criteria = new CDbCriteria;
            $criteria->select = "id, name";


            $criteria->condition = "(name LIKE :venue)";

            //echo $criteria->condition;


            $term = '%' . $term . '%';

            $criteria->params = array(
                ':venue' => $term,
            );
            $cursor = Marker::model()->findAll($criteria);


            //$cursor = Marker::model()->query()->findCursor(array('name' => new MongoRegex('/' . $term . '/i')), array('name'), array('name' => 1), 10);

            if ($cursor != NULL) {
                // echo "Test";
                foreach ($cursor as $id => $value) {
                    $result[] = array('id' => $value['id'], 'name' => $value['name']);
                }
            }
        }

        header('Content-type: application/json');
        echo CJSON::encode($result);
        Yii::app()->end();
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
        }
        else {
            $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $headers = "From: {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->params['adminEmail'], $model->subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        Yii::app()->params['login'] = false;
        if (!Yii::app()->user->isGuest) {


            $this->redirect(Yii::app()->user->returnUrl);
        }
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        $status = true;
        Yii::app()->user->logout();
        $this->redirect(array('index', 'status' => 'logout'));
    }

    public function actionSignUp() {
        Yii::app()->params['public'] = true;
        Yii::app()->params['signup'] = false;

        if (!Yii::app()->user->isGuest) {

            $this->redirect(array('account/'));
        }
        $model = new User('signup');



        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, 'user-form');

        /*
          if(!$model->hasErrors('firstName')) {
          Yii::app()->user->setFlash('success','<b>&#10004;</b> &nbsp First name looks great!');
          }
         */
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            if ($model->validate()) {
             
                if(!empty($model->zip_code)) {
                $google_key = '';
                $GMap = new GMaps($google_key);
            if ($GMap->getInfoLocation($model->zip_code)) {

                
                $address = $GMap->getAddress();
                $pieces = explode(',', $address);
                $model->city = $pieces[0];
                $model->state = $GMap->getAdministrativeAreaName();
                
                }
                }
                
                if ($model->save()) {

                    //$this->setModel($model);
                    //$this->setModelRender($verify);
                    //$verify = User::model()->findByPk($model->id);
                    //$this->sendConfirmation($model);
                    $this->redirect(array('verify', 'email' => $model->email));

                    //Yii::app()->user->setFlash('signup', 'Successful Signup :)');
                    //$this->refresh();
                } else {

                    print_r($model->attributes);

                    //Yii::app()->user->setFlash('signup', 'We could not register you, some how there was a problem.');
                    //$this->refresh();
                }
            } else {

                echo 'Something did not validate';
            }
        }

        $this->render('signup', array(
            'model' => $model,
        ));
    }

    public function actionFeatures() {

        $this->render('features');
    }

    public function actionNewLogin() {

        $model = new LoginForm;

        $this->render('newlogin', array('model' => $model));
    }

    /**
     * This is the reset password page
     */
    public function actionResetPassword() {

        if (!Yii::app()->user->isGuest) {

            $this->redirect(array('home/'));
        }

        $model = new ResetPasswordForm;
        $this->performAjaxValidation($model, 'resetpassword-form');

        if (isset($_POST['ResetPasswordForm'])) {


            $model->attributes = $_POST['ResetPasswordForm'];



            if ($model->validate()) {


                if ($model->save()) {
                    ?>
                    <script type="text/javascript">
                        jQuery("div#forgotpassword").remove();
                    </script>

                    <p class="successMessage"><br/><b>&#10004; &nbsp;</b>Instruction on how to reset your password have been sent to your email.</p><br/><br/>
                    <?php
                    echo CHtml::link('Click Here to Login', array('account/login'));
                }
            }
        } else {

            $this->render('resetpassword', array('model' => $model), false, true);
        }
    }

    public function actionVerify() {


        $model = new VerifyForm;
        $resend = new ResendForm;

        $this->performAjaxValidation(array($model, $resend), 'verify-form');

        if (isset($_POST['VerifyForm'])) {


            $model->attributes = $_POST['VerifyForm'];

            $resend->attributes = $_POST['ResendForm'];




            if ($resend->validate()) {



                $user = User::model()->find(array(
                    'select' => 'verify_code, firstName, username',
                    'condition' => 'username=:username',
                    'params' => array(':username' => $resend->email),
                        ));


                if ($user != NULL) {
                    $this->sendConfirmation($user);

                    $return = array(
                        'result' => 'success');
                    echo CJSON::encode($return);
                    Yii::app()->end();
                }
            }



            if ($model->validate()) {

                $user = User::model()->find(array(
                    'select' => 'verify_code, id, verified',
                    'condition' => 'username=:username',
                    'params' => array(':username' => $model->username),
                        ));

                User::model()->updateByPk($user->id, array('verified' => '1'));
            }
        }


        $this->render('verify', array(
            'model' => $model,
            'resend' => $resend
        ));
    }

    public function actionSearch() {
        Yii::app()->params['public'] = false;
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
            $name_filter = NULL;

            if (isset($_GET['cat_filter'])) {

                $category_filter = $_GET['cat_filter'];
                $category_filter = substr($category_filter, 0, -1);
                $category_search = explode(",", $category_filter);
            }

            if (isset($_GET['name_filter'])) {

                $name_filter = $_GET['name_filter'];
                //$name_filter = mysql_real_escape_string($name_filter);
                //$name_filter = '%'.$name_filter.'%';
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



            $criteria->select = "num_reviews, address, address0, address1, address2, address3, display_phone, categories, name, lat, lng, $formula as distance";

            $criteria->order = "distance ASC";

            foreach ($category_search as $category) {
                $search_condtion = $search_condtion . "'%" . $category . "%'" . " AND categories LIKE ";
                //$criteria->condition = "(cat1 = :venue OR cat2 = :venue OR cat3 = :venue OR cat4 = :venue)";
            }
            //$criteria->condition = "(categories LIKE '%$category_filter% AND categories LIKE')";

            $search_condtion = substr($search_condtion, 0, -21); //when switched to OR need to be -20, AND = -21
            $criteria->condition = "(categories LIKE $search_condtion AND name LIKE '%$name_filter%')";

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

                $data = $dom->saveXML();
                echo $data;
                $index = 0;
                foreach ($venues as $bus) {
                    ?>

                    <div class="snglLst">
                        <div class="floatLeft"><div class="floatBackground"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-preview.gif" alt="<?php echo $bus->name; ?>"></div><div><strong><?php echo round($bus->distance, 1); ?> miles away</strong></div></div>
                        <div class="fL">
                            <div style="float:left; width:200px;">  
                                <div class="mainHead"><a href="#"><?php echo $bus->name; ?></a></div>
                                <div><?php echo $bus->address0; ?> ( <a id="mapit" href="#" onClick="mapIt('<?php echo $index; ?>');">Map it</a> )</div>
                                <div><?php echo $bus->address1; ?></div>
                                <div><?php echo $bus->address2; ?></div>
                                <div><?php echo $bus->address3; ?></div>
                                <div><strong>Phone  :</strong> <?php echo $bus->display_phone; ?></div>
                                <div><strong>RSVP   : </strong> <span class="green">YES</span> ( <a href="#">Change</a> )</div>
                            </div>

                            <div style="float:left">
                                <div class="mainHead"><a href="#">&nbsp;</a></div>
                                <div>Reviews: <?php
                    $reviews = (empty($bus->num_reviews)) ? '(' . $bus->num_reviews . ') <a class="statlink" href="#">Be the first to review</a>' : '(' . $bus->num_reviews . ') Write a Review';
                    echo $reviews;
                    ?></div>
                                <div>Rating: <?php
                    $rating = (empty($bus->rating)) ? 'Has not been rated yet' : $bus->rating;
                    echo $rating;
                    ?></div>
                                <a class="statlink" href="#">Create Event</a><br><br>        
                            </div>

                        </div>

                        <div class="fR">
                            <div class="top">Dec<br>
                                <span class="green">17</span></div>
                            <div class="btm"><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/facebook.png" alt="" width="16" height="16" border="0"></a><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/twitter.png" alt="" width="16" height="16" border="0"></a></div>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <?php
                    $index++;
                }
            }
        }
    }

    public function actionParse() {


        $this->render('parse');
    }

    public function actionProfile() {
        //$this->layout = 'secondary';

        $this->render('profile');
    }

    /**
     * This will email the user, the confirmation code.
     * @param type $model 
     */
    protected function sendConfirmation(&$model) {


        $signUpEmail = New YiiMailMessage;
        $signUpEmail->view = 'signup';
        $signUpEmail->setBody(array('model' => $model), 'text/html');
        $signUpEmail->setFrom(array('welcome@notesforus.com' => 'Notes For Us'));
        $signUpEmail->setSubject('Welcome - Notes For Us');
        $signUpEmail->addTo($model->username);
        Yii::app()->mail->send($signUpEmail);
    }

    protected function performAjaxValidation($model, $formId) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $formId) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    
    
    

}
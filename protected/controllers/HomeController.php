<?php

class HomeController extends Controller
{
        public $layout='column2';
        
        
       
        
        
	public function actionIndex()
	{
            Yii::app()->params['public'] = false;
            $model = new User;
            
                
                //$this->redirect(array('post/index'));
		$this->render('index', array('model'=> $model));
                
            
                
	}
        
        
        public function actions() {
            
            
            
        }
        /**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
        
         /**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	
        public function accessRules()
	{
            
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','posts', 'add_comment', 'delete_comment', 'delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
        public function actionPosts()
        {
            $user = User::model()->find('username=:username', array(':username' => Yii::app()->user->name));
            //echo 'Hello World';
           
            //$this->render('posts');
            $this->renderPartial('posts', array('model' => $user));
            
        }
        
        public function actionDelete()
        {
            
            $this->renderPartial('delete');
            
        }
        
        public function actionAdd_Comment() {
            
            
            $this->renderPartial('add_comment');
            
        }
        
        public function actionDelete_Comment() {
            
            
            $this->renderPartial('delete_comment');
            
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
<?php

class MailController extends Controller
{
        //public $layout='column2';
        
        
        
	public function actionSignUp()
	{
            
                //$this->redirect(array('post/index'));
		$this->render('signup');
                
            
                
	}
        
        
        public function actions() {
            
            
            
        }
        public function accessRules()
	{
            
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
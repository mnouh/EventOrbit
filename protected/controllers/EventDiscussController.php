<?php

class EventDiscussController extends Controller
{
    
        public $layout = 'main';
        
	public function actionIndex()
	{
		$this->render('index');
	}
        
        public function actionAddDiscussion() {
            
            if(isset($_POST['comments']) && isset($_POST['event_id'])) {
                
                if(!empty($_POST['comments']) && !empty($_POST['event_id'])) {
                    
                    
                    if (Yii::app()->user->isGuest)
                throw new CHttpException(404, 'The requested page does not exist.');
                    
            $user_id = Yii::app()->user->id;
            $user = User::model()->findByPk($user_id);
            $comments = $_POST['comments'];
            $event_id = $_POST['event_id'];
            
            $model = new Eventdiscuss;
            
            $model->user_id = $user_id;
            $model->event_id = $event_id;
            $model->message = $comments;
            $model->date = new CDbExpression('NOW()');
            
            if($model->validate()) {
                
                if($model->save()) {
             
                    $this->renderPartial('post', array('comments' => $comments, 'user' => $user));
                    
                }
                
            }
                    
                }
                
                
            }
            
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
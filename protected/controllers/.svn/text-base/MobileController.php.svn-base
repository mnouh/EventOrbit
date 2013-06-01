<?php
//ini_set ('soap.wsdl_cache_enabled',0);
class MobileController extends Controller {

 public function actions()
    {
        return array(
            'mobile'=>array(
                'class'=>'CWebServiceAction',
        		'serviceOptions' => array('soapVersion' => '1.1'),
        ),
        );
    }
    
    public function actionIndex()
    {
        
        echo 'Testing';
        
        
    }
 
    
    /*public function validateLogin($user)
    {
       
    }
	
	public function actionSearch()
    {
    	$lat = 40.7686973;
    	$lng = -73.9918181;
    	$radius = 10;
    	$categories = NULL;
       $myEvent = new EventDAO;
       $myEvent->locate($lat, $lng, $radius, $categories);
    }*/
    
     /**
     *@return string
     *@soap
     */
     
	public function getEvents()
    {
    	$lat = 40.7686973;
    	$lng = -73.9918181;
    	$radius = 10;
    	$categories = NULL;
       $myEvent = new EventDAO;
       return $myEvent->locate($lat, $lng, $radius, $categories);
       
    }
    /**
     * 
     * @param int the number to be incremented
     * @return int the result of the increment
     * @soap
     */
    public function getQuote($name) {
    	
    	return $name+1;
    
    }
    
}
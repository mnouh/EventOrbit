<?php

class EventInfo {
	
	var $name;
	
	var $latitude;
	
	var $longitude;
	
	var $distance; 
	
	public function __construct($name,$latitude,$longitude,$distance){
		$this->name = $name;
		$this->latitude = $latitude;
		$this->longitude = $longitude;
		$this->distance = $distance;	
		
	}
	
}

?>
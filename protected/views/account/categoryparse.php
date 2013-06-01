<?php



$markers = Marker::model()->findAll();


foreach($markers as $marker) {
    
    //echo $marker->categories.'<br>';
    
    echo $marker->name.' ';
    $pieces = explode(',', $marker->categories);
    
    $pieces_name = explode(',', $marker->categories_name);
    
    $i = 0;
    
    for($j = 0; $j < sizeof($pieces_name); $j++) {
        
        
        $cat = new Categories;
        $cat->marker_id = $marker->id;
        $cat->display_name = $pieces_name[$j];
        $cat->name = $pieces[$j];
        
        if($i == 0){
            
            $cat->rank = 1;
            
        }
        
        if($i == 1) {
            
            $cat->rank = 2;
        }
        
        if($i == 2) {
            
            $cat->rank = 3;
        }
        
        if($i == 3) {
            
            $cat->rank = 4;
        }
        
        if($i == 4) {
            
            $cat->rank = 5;
            
        }
        
        if($i == 5)
            $cat->rank = 6;
        
        if($cat->save())
            echo 'Success';
        
        $i++;
    }
    
    /*
    foreach($pieces_name as $cat_name) {
    foreach($pieces as $piece) {
        
        
        $cat = new Categories;
        
        $cat->marker_id = $marker->id;
        $cat->name = $piece;
        $cat->display_name = $cat_name;
        
        
        
    $i++;    
    }
    }
    */
    
   echo '<br>'; 
    
}



?>
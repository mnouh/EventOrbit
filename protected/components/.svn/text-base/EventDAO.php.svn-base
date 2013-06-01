<?php

class EventDAO {

public function __construct(){

}

public function locate($lat, $lng, $radius, $categories) {

        $category_search = array();
        $search_condtion = '';
        $sql = '';

        if (isset($lat) && isset($lng) && isset($radius)) {
            $category_filter = NULL;
            $name_filter = NULL;

            if (isset($categories)) {

                $category_filter = $categories;
                $category_filter = substr($category_filter, 0, -1);
                $category_search = explode(",", $category_filter);
            }
            /*
            if(isset($_GET['name_filter'])) {
                
                $name_filter = $_GET['name_filter'];
                //$name_filter = mysql_real_escape_string($name_filter);
                //$name_filter = '%'.$name_filter.'%';
            }
            */

           
            // Start XML file, create parent node
            $dom = new DOMDocument("1.0");
            $node = $dom->createElement("markers");
            $parnode = $dom->appendChild($node);

            $criteria = new CDbCriteria;
            $formula = '(3959*acos(cos(radians(:baselat))*cos(radians(lat))*cos(radians(lng)-radians(:baselng))+sin(radians(:baselat))*sin(radians(lat))))';

            $criteria->select = "address, address0, address1, address2, address3, display_phone, categories, name, lat, lng, $formula as distance";
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

            if (isset($categories)) {
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
                $varme = array();
                $newXml = new XMLSerializer;
                $mobileData = new MobileAppData;
                foreach ($venues as $location) {
                    $node = $dom->createElement("marker");
                    $newnode = $parnode->appendChild($node);
                    $newnode->setAttribute("name", $location->name);
                    $newnode->setAttribute("address", $location->address);
                    $newnode->setAttribute("lat", $location->lat);
                    $newnode->setAttribute("lng", $location->lng);
                    $newnode->setAttribute("distance", $location->distance);
                    $newObj = new EventInfo($location->name,$location->lat,$location->lng,$location->distance);
                    $varme[] = $newObj;
                }
                   $mobileData->EventList  = $varme;
                   $mydata = $newXml->generateValidXmlFromObj($mobileData,"Business","Event");
                   print_r($mydata);
                //$data = $dom->saveXML();
                //echo $data;
                    return $mydata;
                
            }
        }
    }

}    
?>
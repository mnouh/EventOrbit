<?php

if(isset($_GET['lat']) && isset($_GET['lng'])) {
    
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];
    $cat = '';
    if(isset($_GET['cat_filter'])) {
        
        $cat = $_GET['cat_filter'];
        
    }
    
    if(isset($_GET['radius'])) {
        
        $radius = $_GET['radius'];
        
    }
    else {
        
        $radius = 25;
        
    }
}
?>
<script src="http://maps.google.com/maps/api/js?sensor=false"
            type="text/javascript"></script>
    <script type="text/javascript">
    //<![CDATA[
    var map;
    var myLat = <?php echo $lat; ?>;
    var myLng = <?php echo $lng; ?>;
    var radi = <?php echo $radius; ?>;
    var markers = [];
    var infoWindow;
    var categories = '<?php echo $cat; ?>';
    var locationSelect;
    

    function load() {    
      map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(myLat, myLng),
        zoom: 4,
        mapTypeId: 'roadmap',
        mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
      });
      infoWindow = new google.maps.InfoWindow();

      locationSelect = document.getElementById("locationSelect");
      locationSelect.onchange = function() {
        var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
        if (markerNum != "none"){
          google.maps.event.trigger(markers[markerNum], 'click');

        }
      };
   }

   function searchLocations() {
     var address = document.getElementById("FindPartyForm_addressInput").value;
     var geocoder = new google.maps.Geocoder();
     geocoder.geocode({address: address}, function(results, status) {
       if (status == google.maps.GeocoderStatus.OK) {
        searchLocationsNear(results[0].geometry.location);
       } else {
         alert(address + ' not found');
       }
     });
   }

   function clearLocations() {
     infoWindow.close();
     for (var i = 0; i < markers.length; i++) {
       markers[i].setMap(null);
     }
     markers.length = 0;

     locationSelect.innerHTML = "";
     var option = document.createElement("option");
     option.value = "none";
     option.innerHTML = "See all results:";
     locationSelect.appendChild(option);
   }
   
   function searchLocationsNew() {
     clearLocations();
     var radius = radi;//document.getElementById('radiusSelect').value;
     var searchUrl = 'locate?lat=' + myLat + '&lng=' + myLng + '&radius=' + radius + '&cat_filter='+categories;
     downloadUrl(searchUrl, function(data) {
       $("div#status").html(data);
       var xml = parseXml(data);
       var markerNodes = xml.documentElement.getElementsByTagName("marker");
       var bounds = new google.maps.LatLngBounds();
       for (var i = 0; i < markerNodes.length; i++) {
         var name = markerNodes[i].getAttribute("name");
         var address = markerNodes[i].getAttribute("address");
         var distance = parseFloat(markerNodes[i].getAttribute("distance"));
         var latlng = new google.maps.LatLng(
              parseFloat(markerNodes[i].getAttribute("lat")),
              parseFloat(markerNodes[i].getAttribute("lng")));

         createOption(name, distance, i);
         createMarker(latlng, name, address);
         bounds.extend(latlng);
       }
       map.fitBounds(bounds);
       locationSelect.style.visibility = "visible";
       locationSelect.onchange = function() {
         var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
         google.maps.event.trigger(markers[markerNum], 'click');
         
       };
      });
    }
    
    
    function searchLocationsNear(center) {
     clearLocations(); 
     var radius = radi;//document.getElementById('radiusSelect').value;
     var status = document.getElementById('status');
     myLat = center.lat();
     myLng = center.lng();
     var searchUrl = 'locate?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius + '&cat_filter='+categories;
     downloadUrl(searchUrl, function(data) {
       $("div#status").html(data);
       var xml = parseXml(data);
       var markerNodes = xml.documentElement.getElementsByTagName("marker");
       var bounds = new google.maps.LatLngBounds();
       for (var i = 0; i < markerNodes.length; i++) {
         var name = markerNodes[i].getAttribute("name");
         var address = markerNodes[i].getAttribute("address");
         var distance = parseFloat(markerNodes[i].getAttribute("distance"));
         var latlng = new google.maps.LatLng(
              parseFloat(markerNodes[i].getAttribute("lat")),
              parseFloat(markerNodes[i].getAttribute("lng")));

         //var newdiv = document.createElement("div");
         //newdiv.innerHTML = name;
        
         //status.appendChild(newdiv);
         createOption(name, distance, i);
         createMarker(latlng, name, address);
         bounds.extend(latlng);
       }
       map.fitBounds(bounds);
       locationSelect.style.visibility = "visible";
       locationSelect.onchange = function() {
         var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
         google.maps.event.trigger(markers[markerNum], 'click');
         
       };
      });
    }
    
    

   function searchLocationsFilters(category) {
     clearLocations(); 
     var radius = 25;
     var searchUrl;
     
     if(category == 'hookah_bar') {
     if(!document.getElementById('hookah').checked) {
         categories = categories.replace("hookah_bar,", "");
         //alert("Not Checked");
         //alert(categories);
         searchUrl = 'locate?lat=' + myLat + '&lng=' + myLng + '&radius=' + radius + '&cat_filter='+categories;
     }
     else {
         //alert("Checked");
         categories = categories+category+',';
         //alert(categories);
         searchUrl = 'locate?lat=' + myLat + '&lng=' + myLng + '&radius=' + radius + '&cat_filter='+categories;
         
     }
     
     }
     if(category == 'danceclubs') {
     if(document.getElementById('danceclubs').checked == false) {
         categories = categories.replace("danceclubs,", "");
         //alert("Not Checked");
         //alert(categories);
         searchUrl = 'locate?lat=' + myLat + '&lng=' + myLng + '&radius=' + radius + '&cat_filter='+categories;
     }
     else {
         //alert("Checked");
         categories = categories+category+',';
         //alert(categories);
         searchUrl = 'locate?lat=' + myLat + '&lng=' + myLng + '&radius=' + radius + '&cat_filter='+categories;
         
     }
     }
     
     if(category == 'lounges') {
     if(!document.getElementById('lounges').checked) {
         categories = categories.replace("lounges,", "");
         //alert("Not Checked");
         //alert(categories);
         searchUrl = 'locate?lat=' + myLat + '&lng=' + myLng + '&radius=' + radius + '&cat_filter='+categories;
     }
     else {
         //alert("Checked");
         categories = categories+category+',';
         //alert(categories);
         searchUrl = 'locate?lat=' + myLat + '&lng=' + myLng + '&radius=' + radius + '&cat_filter='+categories;
         
     }
     
     }
     
     
     if(category == 'karaoke') {
     if(!document.getElementById('karaoke').checked) {
         categories = categories.replace("karaoke,", "");
         //alert("Not Checked");
         //alert(categories);
         searchUrl = 'locate?lat=' + myLat + '&lng=' + myLng + '&radius=' + radius + '&cat_filter='+categories;
     }
     else {
         //alert("Checked");
         categories = categories+category+',';
         //alert(categories);
         searchUrl = 'locate?lat=' + myLat + '&lng=' + myLng + '&radius=' + radius + '&cat_filter='+categories;
         
     }
     
     }
     
     
     downloadUrl(searchUrl, function(data) {
       $("div#status").html(data);  
       var xml = parseXml(data);
       var markerNodes = xml.documentElement.getElementsByTagName("marker");
       var bounds = new google.maps.LatLngBounds();
       for (var i = 0; i < markerNodes.length; i++) {
         var name = markerNodes[i].getAttribute("name");
         var address = markerNodes[i].getAttribute("address");
         var distance = parseFloat(markerNodes[i].getAttribute("distance"));
         var latlng = new google.maps.LatLng(
              parseFloat(markerNodes[i].getAttribute("lat")),
              parseFloat(markerNodes[i].getAttribute("lng")));

         createOption(name, distance, i);
         createMarker(latlng, name, address);
         bounds.extend(latlng);
       }
       map.fitBounds(bounds);
       locationSelect.style.visibility = "visible";
       locationSelect.onchange = function() {
         var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
         google.maps.event.trigger(markers[markerNum], 'click');
       };
      });
    }

    function createMarker(latlng, name, address) {
      var html = "<b>" + name + "</b> <br/>" + address;
      var marker = new google.maps.Marker({
        map: map,
        position: latlng
      });
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
      markers.push(marker);
    }

    function createOption(name, distance, num) {
      var option = document.createElement("option");
      option.value = num;
      option.innerHTML = name + "(" + distance.toFixed(1) + ")";
      locationSelect.appendChild(option);
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request.responseText, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function parseXml(str) {
      if (window.ActiveXObject) {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
      } else if (window.DOMParser) {
        return (new DOMParser).parseFromString(str, 'text/xml');
      }
    }

    function doNothing() {}

    //]]>
  </script>
  

  <body onload="load(); searchLocationsNew();">
      <section>
<div class="top">one stop superstore for event discovery </div>


<div class="bottom">
    <div>
    <input id="hookah" type="checkbox" name="hookah" onclick="searchLocationsFilters('hookah_bar');" value="hookah_bar" /> Hookah Bars<br />
    <input id="danceclubs" type="checkbox" name="danceclubs" onclick="searchLocationsFilters('danceclubs');" value="danceclubs" /> Dance Clubs<br />
    <input id="lounges" type="checkbox" name="lounges" onclick="searchLocationsFilters('lounges');" value="lounges" /> Lounges<br />
    <input id="karaoke" type="checkbox" name="karaoke" onclick="searchLocationsFilters('karaoke');" value="lounges" /> Karaoke<br />
    </div>
    <div>
    <select id="radiusSelect">
      <option value="25" selected>25mi</option>
      <option value="100">100mi</option>
      <option value="200">200mi</option>
    </select>

    <input type="button" onclick="searchLocations()" value="Search"/>
    </div>
    
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'findparty-form',
	'enableAjaxValidation'=>true,
        'clientOptions'=>array('validateOnSubmit'=>TRUE, 'validationDelay' => 100),
        //'htmlOptions'=>array('onSubmit'=>'return searchLocations()'),
)); ?>
                <?php echo $form->errorSummary($model);?>
		<?php echo $form->textField($model,'addressInput', array('class'=>'inputBox')); ?>
  
  <?php
    echo CHtml::ajaxSubmitButton(
                                        'Find Event',
                                        array(),
                                        array('success'=>'js:function(data) {
                                                    jQuery("div#status").html(data);
                                                    jQuery("div#load").removeClass("loading");
                                               }',
                                                //'update'=>'#successMessage',
                                                'beforeSend' => 'function() {$("div#load").addClass("loading");}',
                                                'validated' => 'function() {searchLocations();}',
                                                'complete' => 'function() {}',
                                                'type' => 'POST'
                                        ),
                                array('class'=> 'btn')
                                );
            ?>
    
    <p>
                <?php echo $form->error($model,'addressInput'); ?>
    </p>
  <div class="clear"></div>


<?php $this->endWidget(); ?>
    
    
    
    
    
    
    
    
    
    <div><select id="locationSelect" style="width:100%;visibility:hidden"></select></div>
    <div id="map" style="width: 100%; height: 50%"></div>
    <div id="status">What Happened</div>
    
</div>
      </section>
  </body>
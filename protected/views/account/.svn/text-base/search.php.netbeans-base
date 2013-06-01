<?php
$this->pageTitle=Yii::app()->name . ' - Search Results';
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
    var mapItSelect;
    

    function load() {    
      map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(myLat, myLng),
        zoom: 4,
        mapTypeId: 'roadmap',
        scrollwheel: false,
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
   
   function mapIt(index) {
       
       var markerNum = index
        if (markerNum != "none"){
          google.maps.event.trigger(markers[markerNum], 'click');
        }
       
   }

   function searchLocations() {
     var address = document.getElementById("addressInput").value;
     var geocoder = new google.maps.Geocoder();
     geocoder.geocode({address: address}, function(results, status) {
       if (status == google.maps.GeocoderStatus.OK) {
        searchLocationsNear(results[0].geometry.location);
       } else {
         alert(address + ' not found');
       }
     });
   }
   
   
   function searchNewLocationFilter() {
     var address = document.getElementById("addressInput").value;
     var geocoder = new google.maps.Geocoder();
     geocoder.geocode({address: address}, function(results, status) {
       if (status == google.maps.GeocoderStatus.OK) {
        searchAddressLocationFilter(results[0].geometry.location);
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
    
    
    
    
    
    function searchAddressLocationFilter(center) {
     clearLocations(); 
     var radius = document.getElementById('radiusSelect').value;
     var searchUrl;
     var namesrc = document.getElementById("nameInput").value;  
     myLat = center.lat();
     myLng = center.lng();
    
    if(namesrc.length > 0) {
        searchUrl = 'locate?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius + '&cat_filter='+categories + '&name_filter='+namesrc;
    }
    else {
        searchUrl = 'locate?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius + '&cat_filter='+categories;
        
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
<div class="floatLeft">
    <div class="map">
<div id="map"></div></div>
<div><select id="locationSelect" style="width:100%;visibility:hidden"></select></div>
<div class="listings">
<div id="status" class="lists">
    
    
</div>
<div class="paging">
  <ul>
    <li class="noBorder"><a href="#">← Previous </a></li>
    <li><a href="#">1 </a></li>
    <li><a href="#">2</a></li>
    <li><a href="#"> 3 </a></li>
    <li><a href="#" class="sel">4 </a></li>
    <li><a href="#">5 </a></li>
    <li><a href="#">6 </a></li>
    <li><a href="#">7 </a></li>
    <li><a href="#">8</a></li>
    <li><a href="#"> Next →</a></li>
  </ul>
  </div>
</div>
    
</div>
<div class="floatRight">
  <h2>Filter by
  </h2>
  <ul>
    <li>
    <input id="hookah" type="checkbox" name="hookah" onclick="searchLocationsFilters('hookah_bar');" value="hookah_bar" /> Hookah Bars<br />
    <input id="danceclubs" type="checkbox" name="danceclubs" onclick="searchLocationsFilters('danceclubs');" value="danceclubs" /> Dance Clubs<br />
    <input id="lounges" type="checkbox" name="lounges" onclick="searchLocationsFilters('lounges');" value="lounges" /> Lounges<br />
    <input id="karaoke" type="checkbox" name="karaoke" onclick="searchLocationsFilters('karaoke');" value="lounges" /> Karaoke<br />
    </li>
    <li><select id="radiusSelect">
      <option value="25" selected>25mi</option>
      <option value="100">100mi</option>
      <option value="200">200mi</option>
    </select></li>
    <li><a href="#" class="Sel"> Proximity</a></li>
    <li><a href="#"> Age group</a></li>
    <li><a href="#"> Drinking</a></li>
    <li><a href="#"> Dancing</a></li>
    <li><a href="#"> Music Genre</a></li>
    <li><a href="#"> Dress Code</a></li>
    <li><a href="#"> Gay / Straight</a></li>
    <li><a href="#"> Singles</a></li>
    <li><a href="#"> Only Couples</a></li>
  </ul>
  </div>
<div class="clear"></div>
</section>
</body>
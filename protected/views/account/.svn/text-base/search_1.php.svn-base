<script src="http://maps.google.com/maps?file=api&v=2&key=abcdef"
            type="text/javascript"></script>

    <script type="text/javascript">
        
    //<![CDATA[
    var map;
    var geocoder;

    function load() {
      if (GBrowserIsCompatible()) {
        geocoder = new GClientGeocoder();
        map = new GMap2(document.getElementById('map'));
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        map.setCenter(new GLatLng(40, -100), 4);
      }
    }

   function searchLocations() {
     var address = '10019';
         //document.getElementById('FindPartyForm_addressInput').value;
     geocoder.getLatLng(address, function(latlng) {
       if (!latlng) {
         //alert(address + ' not found');
       } else {
         searchLocationsNear(latlng);
       }
     });
   }

   function searchLocationsNear(center) {
     var radius = 25;//document.getElementById('radiusSelect').value;
     var searchUrl = 'searcher?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
     GDownloadUrl(searchUrl, function(data) {
       var xml = GXml.parse(data);
       var markers = xml.documentElement.getElementsByTagName('marker');
       map.clearOverlays();

       var sidebar = document.getElementById('sidebar');
       sidebar.innerHTML = '';
       if (markers.length == 0) {
         sidebar.innerHTML = 'No results found.';
         map.setCenter(new GLatLng(40, -100), 4);
         return;
       }

       var bounds = new GLatLngBounds();
       for (var i = 0; i < markers.length; i++) {
         var name = markers[i].getAttribute('name');
         var address = markers[i].getAttribute('address');
         var distance = parseFloat(markers[i].getAttribute('distance'));
         var point = new GLatLng(parseFloat(markers[i].getAttribute('lat')),
                                 parseFloat(markers[i].getAttribute('lng')));
         
         var marker = createMarker(point, name, address);
         map.addOverlay(marker);
         var sidebarEntry = createSidebarEntry(marker, name, address, distance);
         sidebar.appendChild(sidebarEntry);
         bounds.extend(point);
       }
       map.setCenter(bounds.getCenter(), map.getBoundsZoomLevel(bounds));
     });
   }

    function createMarker(point, name, address) {
      var marker = new GMarker(point);
      var html = '<b>' + name + '</b> <br/>' + address;
      GEvent.addListener(marker, 'click', function() {
        marker.openInfoWindowHtml(html);
      });
      return marker;
    }

    function createSidebarEntry(marker, name, address, distance) {
      var div = document.createElement('div');
      var html = '<b>' + name + '</b> (' + distance.toFixed(1) + ')<br/>' + address;
      div.innerHTML = html;
      div.style.cursor = 'pointer';
      div.style.marginBottom = '5px'; 
      GEvent.addDomListener(div, 'click', function() {
        GEvent.trigger(marker, 'click');
      });
      GEvent.addDomListener(div, 'mouseover', function() {
        div.style.backgroundColor = '#eee';
      });
      GEvent.addDomListener(div, 'mouseout', function() {
        div.style.backgroundColor = '#fff';
      });
      return div;
    }
    //]]>
    
        
    
  </script>
  
  <section>
<div class="top">one stop superstore for event discovery </div>
<div class="bottom">

<?php

foreach($model as $location) {
    
   echo $location->name.'<br>';
    
}

?>
  <body onload="load(); searchLocations();">
      

  <div id="main-map" style="padding-top: 20px;">    
<div style="width:600px; font-family:Arial, 
sans-serif; font-size:11px; border:1px solid black">
    
  <table> 
    <tbody> 
      <tr id="cm_mapTR">

        <td width="200" valign="top"> <div id="sidebar" style="overflow: auto; height: 400px; font-size: 11px; color: #000"></div>

        </td>
        <td> <div id="map" style="overflow: hidden; width:400px; height:400px"></div> </td>

      </tr> 
    </tbody>
  </table>
</div>
</div>
</div>
  </section>
  </body>
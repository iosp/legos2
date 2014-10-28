<!--  
<div><?php echo image_tag( 'under-construction-icon-256x300.png', array( 'width' => '100', 'id' => 'under_construction' ) ); ?>
</div>
<?php echo image_tag( 'frankfurt map.jpg', array( 'id' => 'fraport' ) );?>
-->

<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
  <div id="mapdiv" style="width: 1080px; height: 700px"></div>

  <script>
    var map = new OpenLayers.Map("mapdiv");
    map.addLayer(new OpenLayers.Layer.OSM());
 
    var lonLat = new OpenLayers.LonLat(8.5526  ,50.0260 )
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
            map.getProjectionObject() // to Spherical Mercator Projection
          );
 
    var zoom=13;
 
 /*   var markers = new OpenLayers.Layer.Markers( "Markers" );
    map.addLayer(markers);
 
    markers.addMarker(new OpenLayers.Marker(lonLat));*/
 
    map.setCenter (lonLat, zoom);
  </script>


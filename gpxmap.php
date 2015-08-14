<!DOCTYPE html>
<html>
<!-- 
Gpxmap:
  Version 2015-05-25
Author:
  https://de.wikivoyage.org/wiki/User:Mey2008
Contributors:
  no
License: 
  Affero GPL v3 or later http://www.gnu.org/licenses/agpl-3.0.html
Recent changes:
  2015-05-22: maptiles.js
  2015-05-20: layer leafletview now wvarticles
  2015-05-19: Localization for layers control
  2015-05-17: Localization reversed for layers (IE incompatible) 
  2015-05-16: buttos-new.js
  2015-05-14: Proper pathname for multipoi2gpx.php
ToDo:
  2015-05-25: del leaflet-areaselect.css
-->
<head>
  <title>Wikivoyage - GPX download</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <link rel="icon" href="./lib/images/favicon.png" type="image/png" />
  <link rel="stylesheet" href="./lib/leaflet.css" />
  <link rel="stylesheet" href="./lib/poimap.css" />
  <link rel="stylesheet" href="./lib/PruneCluster.css" />
  <link rel="stylesheet" href="./lib/Control.OSMGeocoder.css" />

  <script type="text/javascript" src="./lib/leaflet.js"></script>
  <script type="text/javascript" src="./lib/leaflet-areaselect.js"></script>
  <script type="text/javascript" src="./lib/serialize.js"></script>
  <script type="text/javascript" src="./lib/buttons-new.js"></script>
  <script type="text/javascript" src="./lib/zoomdisplay.js"></script>
  <script type="text/javascript" src="./lib/PruneCluster.js"></script>
  <script type="text/javascript" src="./lib/Control.OSMGeocoder.js"></script>
  <script type="text/javascript" src="./lib/i18n.js"></script>
  <script type="text/javascript" src="./data/<?php echo $_GET["lang"] ?: "en"; ?>-articles.js"></script>
  <script type="text/javascript" src="./locale/<?php echo $_GET["lang"] ?: "en"; ?>.js"></script>
  <script type="text/javascript" src="./lib/maptiles.js"></script>
</head>

<body>
  <div id="map">
  <script type="text/javascript">
  
  var lang = "<?php echo $_GET["lang"] ?: en; ?>";
  L.registerLocale(lang, mylocale);
  L.setLocale(lang);
  
  maptiles();
  
  function onAll() {
    map.setView([40,10],2);
  }
  
  function onDownload() {
    var bounds = areaSelect.getBounds();
    var swlat = bounds.getSouthWest().lat;
    var nelat = bounds.getNorthEast().lat;
    var swlng = bounds.getSouthWest().lng;
    var nelng = bounds.getNorthEast().lng;
    var a = 0;
    var t = 0; 
    var lat_list = [];
    var lng_list = [];
    var addr_list = [];
    var message = L._("Download this files?") + "\n\n"; 
    for (var i = 0; i < addr_nr; i++) {
      a = addressPoints[i];
      if (a[0] >=  swlat && a[0] <= nelat && a[1] >= swlng && a[1] <= nelng) {
        lat_list[t] = a[0];
        lng_list[t] = a[1];
        addr_list[t] = a[2]; 
        
        t = t + 1;        
      } 
    }
    if (t > 25 ) {
      alert(L._('You have chosen {nn} articles.',{nn:[t]}) + '\n' + L._('But the maximum number for downloading is 25.') + '\n' + L._('Please select a smaller range.'));
    }
    else if (t < 1) {
      alert(L._("No files available for download!"));
    }
    else if (confirm( L._('Download this {nn} GPX files?',{nn:[t]}) + '\n\n' + addr_list.sort().join('\n')) == true) {
      var url_addr = encodeURI(serialize(addr_list));
      window.location.replace('./multipoi2gpx.php?lang=' + lang + '&name=' + url_addr);  
    } 
  }
  
  var addr_nr = (addressPoints.length);
  if (navigator.appVersion.substring(0, 1) == 4){
    addr_nr = addr_nr - 1; // fix for old Explorers
  };
  var lang = "<?php echo ($_GET["lang"]) ?: "it"; ?>";

  var map = L.map('map', {zoomControl: false, minZoom:2, maxZoom: 18}).setView([40,10],2);

// Base layer "Mapquestopen" https
  map.addLayer(mapquestopen);

// Layer "wvarticles"
  var wvarticles = new PruneClusterForLeaflet(70);
  var a = addressPoints[0];
  
  for (var i = 0; i < addr_nr; i++) {
    a = addressPoints[i];
    wvarticles.RegisterMarker(new PruneCluster.Marker(a[0], a[1], {title: a[2]}));
    wvarticles.PrepareLeafletMarker = function (marker, data) {
      marker.bindPopup(data.title);
      marker.on('mouseover', function (e) {
        this.openPopup();
      });
    }
  }
  map.addLayer(wvarticles);
    
  // Add select area to the map
  var areaSelect = L.areaSelect({width:window.innerWidth / 3, height:window.innerHeight / 3});
  areaSelect.addTo(map);

  // Controls
  var maptype = "gpxmap";
  map.addControl(new L.Control.OSMGeocoder({collapsed: false, text: L._("Locate!")}));
  layersControl ();
  map.addControl(new L.Control.Layers(basemaps, overlays));
  map.addControl(new L.Control.Scale());
  map.addControl(new L.Control.Buttons());
  
  function onZoom(e) {
    if (map.getZoom() > 8) {
      wvarticles.Cluster.Size = 1;
      wvarticles.ProcessView();     
    }
    else {
      wvarticles.Cluster.Size = 70;
      wvarticles.ProcessView();
    }
  } 

  map.on('zoomend', onZoom); 
   
  </script>

  <div id="logo">
    <img src="./lib/images/logo.png" alt= "Logo" title= "Version 2015-05-25" width="64" height="64">
  </div>
</div> <!--map-->
</body>
</html>

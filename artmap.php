<!DOCTYPE html>
<html>
<!-- 
Artmap:
  Version 2015-05-23
Author:
  https://de.wikivoyage.org/wiki/User:Mey2008
Contributors:
  https://it.wikivoyage.org/wiki/Utente:Andyrom75
License: 
  Affero GPL v3 or later http://www.gnu.org/licenses/agpl-3.0.html
Recent changes:
  2015-05-23: maptiles.js
  2015-05-20: layer leafletview now wvarticles
  2015-05-19: Localization for layers control
  2015-05-17: Localization reversed for layers (IE incompatible)
  2015-05-16: buttons-new.js
  2015-04-27: Localization
  2015-04-24: buttons-specialmap.js
  2015-03-17: all data in nn.articles.js
  2015-03-13: New PruneCluster
ToDo:
  nothing
-->
<head>
  <title>Wikivoyage - geocoded articles</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <link rel="icon" href="./lib/images/favicon.png" type="image/png" />
  <link rel="stylesheet" href="./lib/leaflet.css" />
  <link rel="stylesheet" href="./lib/poimap.css" />
  <link rel="stylesheet" href="./lib/PruneCluster.css" />
  <link rel="stylesheet" href="./lib/Control.OSMGeocoder.css" />

  <script type="text/javascript" src="./lib/leaflet.js"></script>
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
  
  function onAll() {
    map.setView([40,10],2);
    return false;
  }
 
  var nr = (addressPoints.length);
  if (navigator.appVersion.substring(0, 1) == 4){
    nr = nr - 1; // fix for old Explorers
  };
  
  var lang = "<?php echo $_GET["lang"] ?: en; ?>";
  L.registerLocale(lang, mylocale);
  L.setLocale(lang);
  
  maptiles();

  document.title = "Wikivoyage - " + nr + " " + L._("geocoded articles");

  var map = L.map('map', {zoomControl: false, minZoom:2, maxZoom: 18}).setView([40,10],2);

// Base layer "Mapquestopen" https
  map.addLayer(mapquestopen);

// Layer "wvarticles"
  var wvarticles = new PruneClusterForLeaflet(70);
  var a = addressPoints[0]; 
  var tp = '//upload.wikimedia.org/wikipedia/commons/thumb/'; // thumbnail path
  var ap = '//' + lang + '.wikivoyage.org/wiki/'; // WV article path
  for (var i = 0; i < nr; i++) {
    a = addressPoints[i];
    wvarticles.RegisterMarker(new PruneCluster.Marker(a[0], a[1], {title:'<img src="' + tp + a[3] + '/120px-' + a[3].substring(5) + '"> <a href="' + ap + a[2] + '" target="_blank">' + a[2] + '</a>'}));
    wvarticles.PrepareLeafletMarker = function (marker, data) {
      marker.bindPopup(data.title,{minWidth:120, maxWidth:120});
      marker.on('mouseover', function (e) {
        this.openPopup();
      });
    }
  }
  map.addLayer(wvarticles);

// Controls
  var maptype = "artmap";
  map.addControl(new L.Control.OSMGeocoder({collapsed: false, text: L._("Locate!")}));
  layersControl ();
  map.addControl(new L.Control.Layers(basemaps, overlays));
  map.addControl(new L.Control.Scale());
  map.addControl(new L.Control.Buttons());

  </script>

  <div id="logo">
    <img src="./lib/images/logo.png" alt= "Logo" title= "Version 2015-05-23" width="64" height="64">
  </div>
</div> <!--map-->
</body>
</html>

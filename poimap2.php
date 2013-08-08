<!DOCTYPE html>
<html>
<!-- PoiMap2 - (c) 2013-08-05 by User:Mey2008 - de.wikivoyage.org -->
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> <?php echo $_GET["name"]," — Wikivoyage Map" ?></title>
    <link rel="icon" href="./img/favicon.png" type= "image/png" />
    <link rel="stylesheet" href="./lib/leaflet.css" />
    <link rel="stylesheet" href="./lib/poimap.css" />
    <link rel="stylesheet" href="./lib/locate.css" />
  </head>
<body>
<div id="map">
    <script type="text/javascript" src="./lib/leaflet.js"></script>
    <script type="text/javascript" src="./lib/markers.js"></script>
    <script type="text/javascript" src="./lib/gpx.js"></script>
    <script type="text/javascript" src="./lib/locate.js"></script>
    <script type="text/javascript" src="./data/<?php echo $_GET["lang"]; ?>-articles.js"></script>

<?php

// Reading URL parameters
$lang= $_GET["lang"];
$file= str_replace("\'","'",$_GET["name"]);

// Reading article data
$content = file_get_contents("http://" . $lang . ".wikivoyage.org/w/index.php?title=" . $file . "&action=raw");

// Convert special strings
$content = str_ireplace(array('| ', ' |', '= ', ' =', '===', '&', '{{Listing', '{{vCard', '?lang=', '@'), array('|', '|', '=', '=', 'XXX', '%26', '{{listing', '{{listing', 'XxxxxX', 'X'),  $content);
$content = preg_replace(array('/<!--.*-->/', '/==.*==/'), array('', '{{listing|type=**h2**|name=**SECTION**}}'), $content); 

// Translate to english
include 'trans/translate-' . $lang . '.php';
$content = str_ireplace($search, $replace, $content);

// Convert to {{listing|
$content = preg_replace("/{{(go|see|do|buy|eat|drink|sleep)/", "{{listing|type=$1", $content); 

// echo $content; // *** TEST ***

// read parameters {{Poi|
$apart = explode("{{Poi|", $content);

for($i=1; $i <= count($apart); $i++){
  $text = explode("}}", $apart[$i]);
  $tags = explode('|', $text[0]);
  
  $p[$i] = ($tags[0] ?: "0");
  $c[$i] = (strtolower($tags[1]) ?: "other");
  $x[$i] = ($tags[2] + 0 ?: "0");
  $y[$i] = ($tags[3] + 0 ?: "0");
  $n[$i] = ($tags[4] ?: "NoName");
  $f[$i] = (str_replace(" ","_",$tags[5]) ?: "no");
  }
$z = $i - 2;
$nr = 1;
$nother = 1;

// read parameters {{listing|
$apart = explode('{{listing', $content);

for($i=1; $i <= count($apart); $i++){
  $text = explode('}}', $apart[$i]);
  $part = str_replace('|','&', $text[0]);
  
  $name = $map = $type = $lat = $long = $image = '';
  parse_str($part); 

  $p[$z + $i] = (trim($map)   ?: "0");

// automatic numbering for en version
  if ( $lang == "en" ) {
    $p[$z + $i] = $nr;
    if(trim($type) == "" && trim($lat) !="") {
      $p[$z + $i] = $nother;
      $nother= $nother + 1;
    }
    if (trim($lat) + 0 != 0) {
      $nr = $nr +1;
    }
// Reset for non cont. numbering
   if (trim($type) == "**h2**") {
    $nr= 1;
   }
  }
// -- End of auto numering 

  $c[$z + $i] = (trim($type)  ?: "other");
  $x[$z + $i] = (trim($lat)  + 0 ?: "0");
  $y[$z + $i] = (trim($long) + 0 ?: "0");
  $n[$z + $i] = (trim($name)  ?: "NoName");
  $f[$z + $i] = (str_replace(" ","_",trim($image)) ?: "no");
  }
$max = $z + $i - 1;

// Gpx data
$gpxcontent = file_get_contents("http://" . $lang . ".wikivoyage.org/w/index.php?title=" . $file . "/Gpx&action=raw");

// gpx.js needs seq. file
$fp = fopen("./tracks.gpx", "wb+");
  fwrite($fp, $gpxcontent);
fclose($fp);

// search for fixed color
$fixedcolor = strpos($gpxcontent, 'fixedcolor="yes"');

// echo '<pre>'; print_r($GLOBALS); echo '</pre>'; // *** TEST ***

?>

<noscript> 
 <h2><a href="http://activatejavascript.org/en/">This application needs JavaScript. - See instructions:</a></h2>
</noscript>

<script type='text/javascript'>

// stop for testing // *** TEST ***

// All arrays to js
  var jslat   =  <?php echo $_GET["lat"] ?: "0";?>;
  var jslon   =  <?php echo $_GET["lon"] ?: "0"; ?>;
  var jszoom  =  <?php echo $_GET["zoom"] ?: "14"; ?>;
  var jslayer = '<?php echo $_GET["layer"] ?: "O"; ?>'.toUpperCase();
  var jslang  = '<?php echo $_GET["lang"]; ?>'.toLowerCase();

  var jsmax = <?php echo $max; ?>;
  var jsp =   <?php echo json_encode($p); ?>;
  var jsc =   <?php echo json_encode($c); ?>;
  var jsx =   <?php echo json_encode($x); ?>;
  var jsy =   <?php echo json_encode($y); ?>;
  var jsn =   <?php echo json_encode($n); ?>;
  var jsf =   <?php echo json_encode($f); ?>;

  var jfixcol = <?php echo $fixedcolor ?: "0"; ?>;

// Make map 
  var map = new L.Map('map', {center: new L.LatLng(jslat,jslon), zoom: jszoom});
  var markersAttribution = '';
  
// Base layer "Mapquestopen"
  var mapquestopenUrl = 'http://{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.png', subDomains = ['otile1','otile2','otile3','otile4'];
  var mapquestopenAttrib = 'Map Data © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> ' + 
    'contributors, Tiles by <a href="http://open.mapquest.co.uk">MapQuest</a>' + markersAttribution;
  var mapquestopen = new L.TileLayer(mapquestopenUrl, {maxZoom: 18, attribution: mapquestopenAttrib, subdomains: subDomains});
  if (jslayer.indexOf("O") != -1) {
    map.addLayer(mapquestopen);
  }

// Base layer "Mapquest"
  var mapquestUrl = 'http://{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.jpg', subDomains = ['otile1','otile2','otile3','otile4'];
  var mapquestAttrib = 'Data, imagery and map information provided by <a href="http://open.mapquest.co.uk">MapQuest</a>' + markersAttribution;
  var mapquest = new L.TileLayer(mapquestUrl, {maxZoom: 17, attribution: mapquestAttrib, subdomains: subDomains});
  if (jslayer.indexOf("A") != -1) {
    map.addLayer(mapquest);
  }

// Base layer "Mapnik"
  var mapnikUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
  var mapnikAttribution = 'Map Data © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> ' + 
    'contributors' + markersAttribution;;
  var mapnik = new L.TileLayer(mapnikUrl, {maxZoom: 18, attribution: mapnikAttribution});
  if (jslayer.indexOf("M") != -1 || jslayer.indexOf("C") != -1){
    map.addLayer(mapnik);
  }   

// Base layer "Wikivoyage"
  var wvUrl = 'http://{s}.tile.cloudmade.com/912ff59aa0994ac989dd3ee085b02236/92751/256/{z}/{x}/{y}.png';
  var wvAttribution = 'Map Data © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="http://cloudmade.com">CloudMade</a>' + markersAttribution;
  var wv = new L.TileLayer(wvUrl, {maxZoom: 18,attribution: wvAttribution});
  if (jslayer.indexOf("W") != -1) {
    map.addLayer(wv);
  }    

// Base layer "Transport"
  var transportUrl = 'http://{s}.tile2.opencyclemap.org/transport/{z}/{x}/{y}.png';
  var transportAttribution = 'Map Data © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> ' + 
    'contributors, Tiles courtesy of <a href="http://www.opencyclemap.org/">Andy Allan</a>' + markersAttribution;
  var transport = new L.TileLayer(transportUrl, {maxZoom: 18, attribution: transportAttribution});
 if (jslayer.indexOf("N") != -1) {
    map.addLayer(transport);
  }

// Layer "Labels"  
  var maplabelsUrl = 'http://{s}.mqcdn.com/tiles/1.0.0/hyb/{z}/{x}/{y}.png', subDomains = ['otile1','otile2','otile3','otile4'];
  var maplabelsAttrib = '';
  var maplabels = new L.TileLayer(maplabelsUrl, {maxZoom: 17, attribution: maplabelsAttrib, subdomains: subDomains});
  if (jslayer.indexOf("L") != -1) {
    map.addLayer(maplabels);
  }
  
// Layer "Cycling"
  var cyclingUrl = 'http://tile.lonvia.de/cycling/{z}/{x}/{y}.png';
  var cyclingAttribution = 'Cycling routes: (<a href="http://cycling.lonvia.de">s Cycling Map</a>)';
  var cycling = new L.TileLayer(cyclingUrl, {maxZoom: 17, attribution: cyclingAttribution});
  if (jslayer.indexOf("C") != -1) {
    map.addLayer(cycling);
  }

// Layer "Hiking trails"
  var hikingUrl = 'http://tile.waymarkedtrails.org/hiking/{z}/{x}/{y}.png';
  var hikingAttribution = 'Hiking trails: (<a href="http://hiking.waymarkedtrails.org/de/">s Hiking Map</a>)';
  var hiking = new L.TileLayer(hikingUrl, {maxZoom: 17, attribution: hikingAttribution});
  if (jslayer.indexOf("H") != -1) {
    map.addLayer(hiking);
  }

// Layer "Hill shading"
  var hillUrl = 'http://toolserver.org/~cmarqu/hill/{z}/{x}/{y}.png';
  var hillAttribution = 'Hill shading: SRTM3 v2 (<a href="http://www2.jpl.nasa.gov/srtm/">NASA</a>)';
  var hill = new L.TileLayer(hillUrl, {maxZoom: 17,attribution: hillAttribution});
if (jslayer.indexOf("S") != -1) {
    map.addLayer(hill);
  }

// Layer "POI"
  var markers = new L.featureGroup();
  var mi=1;
  while(mi < jsmax){
  if (jsx[mi] != "0"){
    var tooltip = jsn[mi].replace('<br />','');
    var imgurl = '"http://' + jslang + '.m.wikivoyage.org/wiki/File:' + jsf[mi].substr(5) + '"';
    if (jsf[mi] == "no"){
      var content = jsn[mi];
      var minw = 10;
      var maxw = 240;
    }
    else {
      var content = '<a href = ' + imgurl + '><img src="http://upload.wikimedia.org/wikipedia/commons/thumb/' + 
      jsf[mi] + '/120px-' + jsf[mi].substr(5) + '" width="120"></a><br />' + jsn[mi] + '&nbsp;<a href = ' + 
      imgurl + '><img src="./img/magnify-clip.png" widht="15" height="11" title="Enlarge">';
      var minw = 120;
      var maxw = 120;
    }
    zio = 1000 - (mi * 2);
    var marker = new L.Marker([jsx[mi], jsy[mi]], {title: tooltip  ,zIndexOffset: zio
      ,icon: new L.NumberedDivIcon({number: jsp[mi]  
      ,iconUrl: "./ico24/" + jsc[mi] + ".png"
     })}).bindPopup(content,{minWidth:minw, maxWidth:maxw}).addTo(markers);
    }
    mi++;
  }
  if (jslayer.indexOf("-P") == -1) {
    map.addLayer(markers);
  }

// Layer articles
  var articles = new L.LayerGroup();
    content= '<img src="./img/art-photo.png" width="100" height="106"><br /><a href="http://' + 
      jslang + '.wikivoyage.org/wiki/';
    for (var i = 0; i < addressPoints.length; i++) {
    var a = addressPoints[i];
    if (a[0] >= jslat-1 && a[0] <= jslat+1 && a[1] >= jslon-1.5 && a[1] <= jslon+1.5) {
      var title = a[2];
      var article = title.replace(/_/g, " ");
      var marker = new L.Marker(new L.LatLng(a[0], a[1]), { title: article});
      marker.bindPopup(content + title + '">' + article + '</a><br />').openPopup();
      articles.addLayer(marker);
      }
    }
    var circle = L.circle([jslat, jslon], 50000, {
    fill:false, weight:1
    }).addTo(articles);
    var circle = L.circle([jslat, jslon], 100000, {
    fill:false, weight:1
    }).addTo(articles);

    if (jslayer.indexOf("D") != -1) {
      map.removeLayer(markers);
      map.addLayer(articles);
      var circle = L.circle([jslat, jslon], 2000, {
      color:'red', weight:1
      }).addTo(articles);
    }

// GPX-Layer
   var tracks = new L.GPX('tracks.gpx', {async: true}) ; 
   if (jslayer.indexOf("G") != -1) {
     map.addLayer(tracks);
   } 

// Controls
  map.addControl(new L.Control.Layers({
    'Mapquest Open' : mapquestopen,
    'Mapquest Aerial' : mapquest,
    'Mapnik (OSM)': mapnik,
    'Wikivoyage' : wv,
    'Traffic line network' : transport
    }, {
    'Mapquest Labels' : maplabels,
    'Hill shading': hill,
    'Cycling': cycling,
    'Hiking': hiking,
    'Points of interest': markers,
    'Destinations': articles,
    'GPX tracks': tracks
    }
  ));
  map.addControl(new L.Control.Scale());

  map.addControl(new L.Control.Locate());
  
function onAll(){
map.removeLayer(articles);
map.addLayer(markers);
map.setView([jslat,jslon],jszoom,true);
map.fitBounds(markers.getBounds());
};
  
function onDest(){
map.removeLayer(markers);
map.addLayer(articles);
map.setView([jslat,jslon],9,true);
};
 
</script>

<!-- Tracker does not collect personal data -->
  <div id= "tracker">
    <br /><br /> <!-- Botch adaptation for Android devices -->
    <a href= "javascript:window.print()">
      <img src=" ./img/print.png" alt= "Print screen" title= "Print screen"></a><br />
    <a href= "javascript:void(0)" onclick= "onAll();">
      <img src="./img/full.png" alt= "Show all" title= "Show me all markers"></a><br />
    <a href="javascript:void(0)" onclick= "onDest();">
      <img src= "./img/dest.png" alt= "Destinations" title= "Destinations (only geocoded)&#10;Circles: 50, 100 km distance"></a>
    <script type= "text/javascript" src= "./lib/tracker.js"></script>
    <script type= "text/javascript" src= "http://anormal-tracker.de/tracker.js"></script>
  </div>
  <div id="logo">
    <img src="./img/logo.png" alt= "Logo" width= "40" height="40">
  </div>
</div>
</body>
</html>

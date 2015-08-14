<!DOCTYPE html>
<html>
<!-- 
GeoMap:
  Version 2015-05-26
Author:
  https://de.wikivoyage.org/wiki/User:Mey2008
Contributors:
  no
License: 
  Affero GPL v3 or later http://www.gnu.org/licenses/agpl-3.0.html
Recent changes:
  2015-05-26: mapmask
  2015-05-22: maptiles.js
  2015-05-19: Localization for layers control
  2015-05-17: Localization reversed for layers (IE incompatible)
  2015-05-16: buttons-new.js
  2015-05-16: Logo
  2015-04-26: Localization
  2015-04-24: buttons-specialmaps.js
  2015-03-22: noWrap= true
  2015-03-20: <head>: title after charset
ToDo:
  nothing
-->
  <head>  
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Wikivoyage - GeoMap (Copy templates)</title>
    <link rel="icon" href="./lib/images/favicon.png" type="image/png" />
    <link rel="stylesheet" href="./lib/leaflet.css" />
    <link rel="stylesheet" href="./lib/geomap.css" />
    <link rel="stylesheet" href="./lib/Control.OSMGeocoder.css" />
  </head>
  <body>
    <div id="wrap">
      <div id="left">
        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2e/Wikivoyage-Logo-v3-small-en.png"  width="100px" alt="Logo" >
        <form action="" name="myform" autocomplete="off">
          <b>Copy templates</b>
          <hr>
          <input type="radio" name="group1" value="Latlong" checked="checked" onClick="choice()"> lat | long <br>
          <input type="radio" name="group1" value="Marker" onClick="choice()"> Marker <br>
          <input type="radio" name="group1" value="Geo" onClick="choice()"> Geo <font color="lime">&#10011;</font> <br>
          <input type="radio" name="group1" value="Mapframe" onClick="choice()"> Mapframe <font color="lime">&#10011;</font> <br>
          <br>
          <input type="radio" name="group1" value="Maps" onClick="choice()"> Maps <font color="lime">&#10011;</font> <br>
          <input type="radio" name="group1" value="Poi" onClick="choice()"> Poi <br>
          <input type="radio" name="group1" value="Poimap" onClick="choice()"> PoiMap2 <font color="lime">&#10011;</font> <br>
          <input type="radio" name="group1" value="Osmpoi" onClick="choice()"> OsmPoi <br>
          <input type="radio" name="group1" value="Geodata" onClick="choice()"> GeoData <font color="lime">&#10011;</font> <br>
          <br>
          <input type="radio" name="group1" value="Gpxwpt" onClick="choice()"> GpxWpt <br>
        </form>
      <br>
      <b>How it works:</b>
      <hr>
      ■ select template<br>
      ■ search destination<br>
      ■ or drag &amp; zoom<br>
      ■ click &amp; mark text<br>
      ■ copy to clipboard<br>
      ■ paste into article<br>
      ■ modify <i style='background-color:#FFCCCC'>marked</i> text<br>
      <br>
      <b>Contribute</b>
      <hr>
      Report bugs and<br>
      suggestions to<br>
      <a href="https://en.wikivoyage.org/wiki/User_talk:Mey2008">User:Mey2008</a>
    </div> <!-- left -->
  <div id="map">
    <div id="logo">
      <img src="./lib/images/logo.png" alt= "Logo" title= "Version 2015-05-26" width="64" height="64">
    </div>
    <script type="text/javascript" src="./lib/leaflet.js"></script>
    <script type="text/javascript" src="./lib/buttons-new.js"></script>
    <script type="text/javascript" src="./lib/zoomdisplay.js"></script>
    <script type="text/javascript" src="./lib/Control.OSMGeocoder.js"></script>
    <script type="text/javascript" src="./lib/Control.MiniMap.js"></script>
    <script type="text/javascript" src="./lib/i18n.js"></script>
    <script type="text/javascript" src="./locale/<?php echo $_GET["lang"] ?: "en"; ?>.js"></script>
    <script type="text/javascript" src="./lib/maptiles.js"></script>

    <noscript> 
      <h2><a href="http://activatejavascript.org/en/">This application needs JavaScript. - See instructions:</a></h2>
    </noscript>
    
<script>

  var lang = "<?php echo $_GET["lang"] ?: en; ?>";
  L.registerLocale(lang, mylocale);
  L.setLocale(lang);
  
  maptiles();

function choice() {
  if (document.myform.group1[2].checked == true || document.myform.group1[3].checked == true || document.myform.group1[4].checked == true || document.myform.group1[6].checked == true || document.myform.group1[8].checked == true ) {
    document.getElementById("center").style.opacity = "1";
  }
  else {
    document.getElementById("center").style.opacity = "0";
  }
}

function onAll() {
  map.setView([40,15],2);
  return false;
}

function onMapClick(e) {
  var fmlat=e.latlng.lat.toFixed(map.getZoom() * 0.25 + 0.5);
  var fmlng=e.latlng.lng.toFixed(map.getZoom() * 0.25 + 0.5);

  if (document.myform.group1[0].checked == true) {
    popup.setLatLng(e.latlng).setContent('lat=' + fmlat + ' | long=' + fmlng + '<br><br>' + fmlat + '|' + fmlng + '<br><br>' + fmlat + '<br>' + fmlng).openOn(map);
  }
  else if (document.myform.group1[1].checked == true) {
    popup.setLatLng(e.latlng).setContent("{{Marker|type=<i style='background-color:#FFCCCC'>city</i> |lat=" + fmlat + " |long=" + fmlng + " |zoom=" + map.getZoom() + " |name= |image=}}").openOn(map);
  }
  else if (document.myform.group1[2].checked == true) {
    
    popup.setLatLng(e.latlng).setContent("{{geo|" + fmlat + "|" + fmlng + "|zoom=" + map.getZoom() + "}}").openOn(map);
  }
  else if (document.myform.group1[3].checked == true) {
    popup.setLatLng(e.latlng).setContent("{{Mapframe|" + fmlat + "|" + fmlng + "|zoom=" + map.getZoom() + "}}").openOn(map);
  }
  else if (document.myform.group1[4].checked == true) {
     popup.setLatLng(e.latlng).setContent("{{Maps|" + fmlat + "|" + fmlng + "|" + map.getZoom() + "<i style='background-color:#FFCCCC'>|O|Stadtplan</i>}}").openOn(map);
  }
  else if (document.myform.group1[5].checked == true) {
    popup.setLatLng(e.latlng).setContent("{{Poi|<i style='background-color:#FFCCCC'>0</i>|<i style='background-color:#FFCCCC'>see</i>|" +  fmlat + "|" + fmlng + "|<i style='background-color:#FFCCCC'>name</i>}}<br><br>{{Poi|<i style='background-color:#FFCCCC'>0</i>|<i style='background-color:#FFCCCC'>see</i>|" +  fmlat + "|" + fmlng + "|<i style='background-color:#FFCCCC'>name</i>|<i style='background-color:#FFCCCC'>image</i>|<i style='background-color:#FFCCCC'>O</i>}}").openOn(map);
  }
  else if (document.myform.group1[6].checked == true) {
    popup.setLatLng(e.latlng).setContent("[[File:<i style='background-color:#FFCCCC'>Map-icon.svg</i>|thumb|link={{PoiMap2|"  + fmlat + "|" + fmlng + "|" + map.getZoom() + "}}|<i style='background-color:#FFCCCC'>PoiMap</i>]]<br><br>{{PoiMap2|"  
			+ fmlat + "|" + fmlng + "|" + map.getZoom() + "}}").openOn(map);
  }
  else if (document.myform.group1[7].checked == true) {
    popup.setLatLng(e.latlng).setContent("{{OsmPoi|" + fmlat + "|" + fmlng + "|" + map.getZoom() + "|<i style='background-color:#FFCCCC'>O</i>}}").openOn(map);
  }
  else if (document.myform.group1[8].checked == true) {
    popup.setLatLng(e.latlng).setContent("{{GeoData| lat= " + fmlat + "| long= "+ fmlng + "| prec= | radius= | elev= | elevMin= | elevMax= }}").openOn(map);
  }
  else if (document.myform.group1[9].checked == true) {
    popup.setLatLng(e.latlng).setContent('&lt;wpt lat="' + fmlat + '" lon="'+ fmlng + '"&gt;&lt;name&gt<i style="background-color:#FFCCCC">description</i>&lt;/name&gt;&lt;/wpt&gt;').openOn(map);
  }
  else {
    alert ("ERROR GeoMap #206, please report.");
  }
}

function get_url_param(name) {
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regexS = "[\\?&]" + name + "=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(window.location.href);
  if (results == null) return "";
  else return results[1];
};

// read URL parameters
var ulat = get_url_param('lat');
if (ulat == "") {
  var ulat = 40;
}
var ulon = get_url_param('lon');
if (ulon == "") {
  var ulon = 15;
}
var uzoom = get_url_param('zoom');
if (uzoom == "") {
  var uzoom = 2;
}
var ulayers = get_url_param('layers').toUpperCase();
if (ulayers == "") {
  var ulayers = "M";
}
var ulocation = get_url_param('location');
if (ulocation == "") {
  var ulocation = " ";
}

var map = L.map('map',{zoomControl: false, minZoom:2, maxZoom: 18}).setView([ulat, ulon], uzoom);

// Base layer "Mapquestopen" https
if (ulayers.indexOf('O') != -1) {
  map.addLayer(mapquestopen);
}    

// Base layer "Mapquest" https
if (ulayers.indexOf('A') != -1) {
  map.addLayer(mapquest);
}    

// Basislayer "mapnik (default layer)" http & https
if (ulayers.indexOf('M') != -1) {
  map.addLayer(mapnik);
}    

// Layer "Labels"  https
if (ulayers.indexOf('L') != -1) {
  map.addLayer(maplabels);
} 

// Layer "Boundaries (default layer)" http
if (ulayers.indexOf('B') != -1) {
  map.addLayer(boundaries);
} 

// Layer "Cycling" http
if (ulayers.indexOf('C') != -1) {
  map.addLayer(cycling);
}

// Mini map, layer "Mapquestopen" https
var mqo2 = new L.TileLayer(mapquestopenUrl, {minZoom: 0, maxZoom: 13, attribution: mapquestopenAttrib, subdomains: mosubDomains });
var miniMap = new L.Control.MiniMap(mqo2, { toggleDisplay: true,	width: 250 }).addTo(map);

// MapMask 
var mask =  [[90, -180],[90, 180],[-90, 180],[-90, -180]];
var mcolor = "black", mweight = 0, mopacity = 0, mfillOpacity = 0.2;
if (L.Browser.android) {
  mcolor = "blue", mweight = 5, mopacity = 0.2, mfillOpacity = 0;
}
var mapmask = L.polygon(
  [[[90, -540],[90,540],[-90, 540],[-90, -540]],mask], // world, mask
  {color: mcolor, weight: mweight, opacity: mopacity, fillOpacity: mfillOpacity, clickable: false}
).addTo(map); 

// Controls
var maptype = "geomap";
map.addControl(new L.Control.OSMGeocoder({collapsed: false, text: L._("Locate!")}));
layersControl ();
map.addControl(new L.Control.Layers(basemaps, overlays));
map.addControl(new L.Control.Scale());
map.addControl(new L.Control.Buttons());

// Pop-up coordinates
var popup = L.popup({maxWidth: 800});

map.on('click', onMapClick);

</script>

        <div id="center">
            <img src="./lib/images/center.png"> 
        </div>
      </div> <!-- map -->
    </div> <!-- wrap -->
  </body>
</html>

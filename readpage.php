<?php

/* 
  readpage.php - Version 2015-07-26
  
  include from poi2gpx.php

  Author:
  https://de.wikivoyage.org/wiki/User:Mey2008
     
  Contributors:
  https://it.wikivoyage.org/wiki/Utente:Andyrom75

  License: 
  Affero GPL v3 or later http://www.gnu.org/licenses/agpl-3.0.html 
  
  Recent changes:
  2015-07-26: optimize for count()
  2015-07-20: image="" error
  2015-05-04: file name to file_name

  ToDo:
  ---
*/

// DMS to DEC (DIR must be N, E, S or, W)
function DMStoDEC($dms) {
  $part = preg_split("/[^\d\w\.]+/",$dms);
  $pnr = count($part);
  if ($pnr == 3) {
    $part[3] = $part[2];
    $part[2] = 0;
  }
  elseif ($pnr == 2) {
    $part[3] = $part[1];
    $part[1] = 0;
    $part[2] = 0;
  } 
  $dec = $part[0] + ((($part[1]*60) + ($part[2]))/3600);
  if ($part[3] == "S" || $part[3] == "W") {
    $dec = $dec * -1;
  } 
  return $dec;
} 

// reading URL parameters
$lang = $_GET["lang"];
$file = str_replace("\'","'",$_GET["name"]);
$file = str_replace(" ", "_", $file);

// reading article data
$content = file_get_contents("https://" . $lang . ".wikivoyage.org/w/index.php?title=" . $file . "&action=raw");

// strip comments and nowiki
$content = preg_replace('/<!--(.|\s)*?-->/', '', $content);
$content = preg_replace('/<nowiki(.|\s)*?nowiki>/', '', $content);

// replace special strings
$content = str_ireplace(array('[*', ']]', '| ', ' |', '= ', ' =', '=====', '===', '&', '{{Marker', '{{Listing', '{{vCard', '?lang=', '@', '{{Poi', '=listing' ), array('', '', '|', '|', '=', '=', 'XXXXX', 'XXX', '%26', '{{listing', '{{listing', '{{listing', 'XxxxxX', 'X', '{{poi', '=' ),  $content);

// poi to listing
$content = preg_replace(array('/{{poi\|(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)[\||}](.*?)}}/i', '/\|image=}/i', '/{{poi\|(.*?)\|(.*?)\|(.*?)\|(.*?)\|(.*?)[\||}]/i'), array("{{listing|map=$1|type=$2|lat=$3|long=$4|name=$5|image=$6}}", "}}}", "{{listing|map=$1|type=$2|lat=$3|long=$4|name=$5}}"), $content);

// replace section 2 headers
$content = preg_replace('/==.*==/', '{{listing|type=**h2**|name=**SECTION**}}', $content); 

// translate to english
include 'trans/translate-' . $lang . '.php';
$content = str_ireplace($search, $replace, $content);

// convert to {{listing|
$content = preg_replace("/{{(go|see|do|buy|eat|drink|sleep|fun|vicinity|health|around|city|diplo)/", "{{listing|type=$1", $content);
 
// strip unwanted templates
$content = preg_replace("/{{(?!poi|listing|mapframe|mapmask|geo|photolist)(.|\s)*?}}/im", "", $content);

// echo $content; // *** TEST ***

// mapmask
preg_match('/{{MapMask\|(.*?)}}/i', $content, $matches);
if (isset($matches[1])) {
  $mask = '[[' . str_replace('|', '],[', $matches[1]) . ']]';
}
else {
  $mask = '[[]]';
}

// read parameters {{listing|
$apart = explode('{{listing', $content);
$total = count($apart);

$nr = $nother = 0;
// $groups, $grpmax only for de
$groups = array('error', '**h2**', 'blue', 'buy', 'do', 'drink', 'eat', 'fun', 'go', 'gold', 'health', 'lime', 'listing', 'maroon', 'mediumaquamarine', 'other', 'red', 'see', 'silver', 'sleep', 'view', 'vicinity', 'health', 'around', 'city', 'diplo');
$grpmax = array_fill(0, 29, 0);

for($i=1; $i < $total; $i++){
  $text = explode('}}', $apart[$i]);
  $part = str_replace('|','&', $text[0]);

  $name = $map = $type = $group = $lat = $long = $image = '';
  parse_str(str_replace('+', '%2B', $part));

  // convert DMS to DEC
  if (strpos($lat, "°")) {
    $lat = DMStoDEC($lat);
    $long = DMStoDEC($long);
  }
 
  $n[$i] = (trim($name)  ?: "NoName");
  $p[$i] = (trim($map)   ?: 0);
  $c[$i] = (trim($type)  ?: "other");
  $x[$i] = (trim($lat)  + 0 ?: "0");
  $y[$i] = (trim($long) + 0 ?: "0");
  $f[$i] = (str_replace(" ","_",trim($image)) ?: "0/01/no");
  if (substr($f[$i],1,1) != "/") {
    $md5 = md5($f[$i]);
    $f[$i] = substr($md5,0,1) . "/" . substr($md5,0,2) . "/" . $f[$i];
  }

  // automatic numbering
  if ($lang == "de" ) {
    if ($x[$i] + 0 != 0 && $p[$i] == 0) {
      if ($group != '') {
        $c[$i] = trim($group);
      }
      $key = array_search($c[$i], $groups);
      $grpmax[$key]++; 
      $p[$i] = $grpmax[$key];
    }
  }
  else {
    if ($x[$i] + 0 != 0) {
      if ($c[$i] == "other") {
        $nother++;
        $p[$i] = $nother;      
      }
      else {
        $nr++;
        $p[$i] = $nr;       
      }   
    }
    if ($c[$i] == "**h2**") {
      $nr = 0;
    }
  }
}
$max = $i - 1;
?>
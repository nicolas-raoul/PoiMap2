// Localization English -> English <syntaxhighlight lang="javascript">

// change only the texts on the right to your language

var mylocale = {
  "But the maximum number for downloading is 25.": "But the maximum number for downloading is 25.", 
  "contributors": "contributors",
  "contributors, Tiles": " contributors, Tiles",
  "Data, imagery and map information provided by": "Data, imagery and map information provided by",
  "Download GPX file": "Download GPX file",
  "Download this {nn} GPX files?": "Download this {nn} GPX files?",
  "ERROR: Coordinates must be numeric!": "ERROR: Coordinates must be numeric!",
  "geocoded articles": "geocoded articles",
  "Locate!": "Locate!",
  "Map center ⇔ all markers": "Map center ⇔ all markers",
  "Map data": "Map data",
  "No files available for download!": "No files available for download!",
  "Please select a smaller range.": "Please select a smaller range.",
  "POIs ⇔ destinations": "POIs ⇔ destinations",
  "Show me all markers": "Show me all markers",
  "Show me the whole earth": "Show me the whole earth",
  "Show me where I am": "Show me where I am",
  "Sorry, that location could not be found.": "Sorry, that location could not be found.",
  "Version": "Version", 
  "You clicked the map at": "You clicked the map at",
  "You have chosen {nn} articles.": "You have chosen {nn} articles.",
  "Zoom in": "Zoom in",
  "Zoom out": "Zoom out"
};

// change only the labels eg 'Boundaries <img ... to 'Your label <img ...
   
function layersControl () {
  if (maptype == "artmap") {  
    basemaps = {
      'Mapquest open <img src="./lib/images/external.png" />' : mapquestopen
    };
    overlays = {
      'WV articles <img src="./lib/images/wv-logo-12.png" />' : wvarticles
    };
  }
  
  else if (maptype == "geomap") {
    basemaps = {
      'Mapnik <img src="./lib/images/wmf-logo-12.png" />':  mapnik,
      'Mapquest open <img src="./lib/images/external.png" />': mapquestopen,
      'Mapquest aerial <img src="./lib/images/external.png" />': mapquest
    }; 
    overlays = {
      'Mapquest labels <img src="./lib/images/external.png" />': maplabels,
      'Boundaries <img src="./lib/images/external.png" />': boundaries,
      'Cycling <img src="./lib/images/external.png" />': cycling
    };
  }
 
  else if (maptype == "gpxmap") { 
    basemaps = {
      'Mapquest open <img src="./lib/images/external.png" />' : mapquestopen
    };
    overlays = {
      'WV articles <img src="./lib/images/wv-logo-12.png" />' : wvarticles
    };
  }
  
  else if (maptype == "monmap") {
    basemaps = {
      'Mapquest open <img src="./lib/images/external.png" />' : mapquestopen,
      'Mapnik <img src="./lib/images/wmf-logo-12.png" />' : mapnik, 
      'Relief map <img src="./lib/images/external.png" />' : landscape
    };
    overlays = {
      'Monuments <img src="./lib/images/wv-logo-12.png" />' : monuments
    };
  }

  else if (maptype == "poimap2") {
    basemaps = {
      'Mapnik <img src="./lib/images/wmf-logo-12.png" />' : mapnik,
      'Mapnik b&amp;w <img src="./lib/images/wmf-logo-12.png" />' : mapnikbw,
      'Mapquest open <img src="./lib/images/external.png" />' : mapquestopen,
      'Mapquest aerial <img src="./lib/images/external.png" />' : mapquest,
      'Traffic line network <img src="./lib/images/external.png" />' : transport,
      'Relief map <img src="./lib/images/external.png" />' : landscape
    };
    overlays = {
      'Mapquest labels <img src="./lib/images/external.png" />' : maplabels,
      'Boundaries <img src="./lib/images/external.png" />' : boundaries,
      'Hill shading <img src="./lib/images/wmf-logo-12.png" />' : hill,
      'Cycling <img src="./lib/images/external.png" />' : cycling,
      'Hiking <img src="./lib/images/external.png" />' : hiking,
      'Points of interest <img src="./lib/images/wv-logo-12.png" />' : markers,
      'Destinations <img src="./lib/images/wv-logo-12.png" />' : wvarticles,
      'GPX tracks / map mask <img src="./lib/images/wv-logo-12.png" />' : tracks
    };
  }
}

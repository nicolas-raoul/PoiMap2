// Localization English -> German <syntaxhighlight lang="javascript">

// change only the texts on the right to your language

var mylocale = {
  "But the maximum number for downloading is 25.": "aber die maximale Anzahl zum Herunterladen ist 25.", 
  "contributors": "Mitwirkende",
  "contributors, Tiles": "Mitwirkende, Kartenkacheln",
  "Data, imagery and map information provided by": "Daten, Bilder und Karteninformationen bereitgestellt durch",
  "Download GPX file": "GPX Datei herunterladen",
  "Download this {nn} GPX files?": "Diese {nn} GPX-Dateien herunterladen?",
  "ERROR: Coordinates must be numeric!": "FEHLER: Koordinaten müssen numerisch sein!",
  "geocoded articles": "geokodierte Artikel",
  "Locate!": "Finde!",
  "Map center ⇔ all markers": "Kartenzentrum ⇔ alle Marker",
  "Map data": "Kartendaten",
  "No files available for download!": "Keine Artikel in diesem Bereich!",
  "Please select a smaller range.": "Bitte wählen Sie einen kleineren Bereich.",
  "POIs ⇔ destinations": "POI ⇔ Reiseziele",
  "Show me all markers": "zeig mir alle Marker",
  "Show me the whole earth": "zeig mir die gesamte Erde",
  "Show me where I am": "zeige meinen Standort",
  "Sorry, that location could not be found.": "Leider konnte dieser Ort nicht gefunden werden.",
  "Version": "Version",  
  "You clicked the map at": "Sie klickten auf die Karte bei",
  "You have chosen {nn} articles.": "Sie haben {nn} Artikel ausgewählt,",
  "Zoom in": "vergrößern",
  "Zoom out": "verkleinern"
};

// change only the labels eg 'Boundaries <img ... to 'Your label <img ...

function layersControl () {
  if (maptype == "artmap") {  
    basemaps = {
      'Mapquest Open <img src="./lib/images/external.png" />' : mapquestopen
    };
    overlays = {
      'WV Artikel <img src="./lib/images/wv-logo-12.png" />' : wvarticles
    };
  }
  
  else if (maptype == "geomap") {
    basemaps = {
      'Mapnik <img src="./lib/images/wmf-logo-12.png" />':  mapnik,
      'Mapquest open <img src="./lib/images/external.png" />': mapquestopen,
      'Mapquest aerial <img src="./lib/images/external.png" />': mapquest
    }; 
    overlays = {
      'Mapquest Beschriftungen <img src="./lib/images/external.png" />': maplabels,
      'Grenzen <img src="./lib/images/external.png" />': boundaries,
      'Radwege <img src="./lib/images/external.png" />': cycling
    };
  }
 
  else if (maptype == "gpxmap") { 
    basemaps = {
      'Mapquest Open <img src="./lib/images/external.png" />' : mapquestopen
    };
    overlays = {
      'WV Artikel <img src="./lib/images/wv-logo-12.png" />' : wvarticles
    };
  }
  
  else if (maptype == "monmap") {
    basemaps = {
      'Mapquest Open <img src="./lib/images/external.png" />' : mapquestopen,
      'Mapnik <img src="./lib/images/wmf-logo-12.png" />' : mapnik, 
      'Reliefkarte <img src="./lib/images/external.png" />' : landscape
    };
    overlays = {
      'Denkmäler <img src="./lib/images/wv-logo-12.png" />' : monuments
    };
  }

  else if (maptype == "poimap2") {
    basemaps = {
      'Mapnik <img src="./lib/images/wmf-logo-12.png" />' : mapnik,
      'Mapnik s/w <img src="./lib/images/wmf-logo-12.png" />' : mapnikbw,
      'Mapquest Open <img src="./lib/images/external.png" />' : mapquestopen,
      'Mapquest Aerial <img src="./lib/images/external.png" />' : mapquest,
      'Verkehrsliniennetz <img src="./lib/images/external.png" />' : transport,
      'Reliefkarte <img src="./lib/images/external.png" />' : landscape
    };
    overlays = {
      'Mapquest Beschriftungen <img src="./lib/images/external.png" />' : maplabels,
      'Grenzen <img src="./lib/images/external.png" />' : boundaries,
      'Schummerung <img src="./lib/images/wmf-logo-12.png" />' : hill,
      'Radwege <img src="./lib/images/external.png" />' : cycling,
      'Wanderwege <img src="./lib/images/external.png" />' : hiking,
      'Sehenswürdigkeiten <img src="./lib/images/wv-logo-12.png" />' : markers,
      'Reiseziele <img src="./lib/images/wv-logo-12.png" />' : wvarticles,
      'GPX Spuren / Kartenmaske <img src="./lib/images/wv-logo-12.png" />' : tracks
    };
  }
}

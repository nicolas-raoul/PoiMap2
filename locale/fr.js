// Localization English -> French <syntaxhighlight lang="javascript">

// change only the texts on the right to your language

var mylocale = {
  "But the maximum number for downloading is 25.": "Mais le nombre maximum pour le téléchargement est 25.", 
  "contributors": "contributeurs",
  "contributors, Tiles": " contributeurs, Tiles",
  "Data, imagery and map information provided by": "donnée, imagerie et information cartographie fourni par",
  "Download GPX file": "Télécharger le fichier GPX",
  "Download this {nn} GPX files?": "Télécharger ce fichier GPX {nn}?",
  "ERROR: Coordinates must be numeric!": "ERREUR: Les coordonnées doivent être numérique!",
  "geocoded articles": "articles géocodés",
  "Locate!": "Localise!",
  "Map center ⇔ all markers": "Centre de la carte ⇔ tout les symboles",
  "Map data": "Map data",
  "No files available for download!": "Pas de fichier disponible au téléchargement!",
  "Please select a smaller range.": "S'il vous plait, sélectionnez une gamme plus restreinte.",
  "POIs ⇔ destinations": "Point d\'intérêt ⇔ destinations", // \' = '
  "Show me all markers": "Afficher tout les symboles",
  "Show me the whole earth": "Afficher la terre entière",
  "Show me where I am": "Afficher ma position",
  "Sorry, that location could not be found.": "Désolé, ce lieu ne peut pas être trouvé.",
  "Version": "Version", 
  "You clicked the map at": "Vous avez cliqué sur la carte à",
  "You have chosen {nn} articles.": "Vous avez choisi {nn} articles.",
  "Zoom in": "Zoom +",
  "Zoom out": "Zoom -"
};

// change only the labels eg 'Boundaries <img ... to 'Your label <img ...
   
function layersControl () {
  if (maptype == "artmap") {  
    basemaps = {
      'Mapquest ouvert <img src="./lib/images/external.png" />' : mapquestopen
    };
    overlays = {
      'articles WV <img src="./lib/images/wv-logo-12.png" />' : wvarticles
    };
  }
  
  else if (maptype == "geomap") {
    basemaps = {
      'Mapnik <img src="./lib/images/wmf-logo-12.png" />':  mapnik,
      'Mapquest ouvert <img src="./lib/images/external.png" />': mapquestopen,
      'Mapquest vue aérienne <img src="./lib/images/external.png" />': mapquest
    }; 
    overlays = {
      'Symboles Mapquest <img src="./lib/images/external.png" />': maplabels,
      'Frontières <img src="./lib/images/external.png" />': boundaries,
      'Cycliste <img src="./lib/images/external.png" />': cycling
    };
  }
 
  else if (maptype == "gpxmap") { 
    basemaps = {
      'Mapquest ouvert <img src="./lib/images/external.png" />' : mapquestopen
    };
    overlays = {
      'articles WV <img src="./lib/images/wv-logo-12.png" />' : wvarticles
    };
  }
  
  else if (maptype == "monmap") {
    basemaps = {
      'Mapquest ouvert <img src="./lib/images/external.png" />' : mapquestopen,
      'Mapnik <img src="./lib/images/wmf-logo-12.png" />' : mapnik, 
      'Carte en relief <img src="./lib/images/external.png" />' : landscape
    };
    overlays = {
      'Monuments <img src="./lib/images/wv-logo-12.png" />' : monuments
    };
  }

  else if (maptype == "poimap2") {
    basemaps = {
      'Mapnik <img src="./lib/images/wmf-logo-12.png" />' : mapnik,
      'Mapnik n&amp;b <img src="./lib/images/wmf-logo-12.png" />' : mapnikbw,
      'Mapquest ouvert <img src="./lib/images/external.png" />' : mapquestopen,
      'Mapquest vue aérienne <img src="./lib/images/external.png" />' : mapquest,
      'Lignes de transport public <img src="./lib/images/external.png" />' : transport, 
      'Carte en relief <img src="./lib/images/external.png" />' : landscape
    };
    overlays = {
      'Mapquest labels <img src="./lib/images/external.png" />' : maplabels,
      'Frontières <img src="./lib/images/external.png" />' : boundaries,
      'Ombré le relief <img src="./lib/images/wmf-logo-12.png" />' : hill,
      'Cycliste <img src="./lib/images/external.png" />' : cycling,
      'Randonnée <img src="./lib/images/external.png" />' : hiking,
      'Points d\'intérêt <img src="./lib/images/wv-logo-12.png" />' : markers, // \' = '
      'Destinations <img src="./lib/images/wv-logo-12.png" />' : wvarticles,
      'GPX tracks / masque de carte<img src="./lib/images/wv-logo-12.png" />' : tracks 
    };
  }
}

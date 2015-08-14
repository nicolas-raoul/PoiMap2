// Localization English --> Italian <syntaxhighlight lang="javascript">

// change only the texts on the right to your language

var mylocale = {
  "contributors": "Contributori",
  "contributors, Tiles": "Contributori, mappe",
  "Data, imagery and map information provided by": "Dati, immagini e informazioni topografiche fornite da",
  "Locate!": "Trova!",
  "Map center ⇔ all markers": "Centro mappa ⇔ tutti i segnaposto",
  "Map data": "Dati della mappa",
  "POIs ⇔ destinations": "POI ⇔ destinazioni",
  "Show me all markers": "Mostra tutti i segnaposto",
  "Show me the whole earth": "Mostra l'intero globo",
  "Show me where I am": "Mostra dove sono",
  "Sorry, that location could not be found.": "Sono spiacente, che il luogo cercato non è stato trovato.",
  "Zoom in": "Ingrandisci",
  "Zoom out": "Rimpicciolisci",
   
  "But the maximum number for downloading is 25.": "Ma il massimo numero di download è 25.", 
  "Download GPX file": "Scarica file GPX",
  "Download this {nn} GPX files?": "Scarica questi {nn} file GPX?",
  "ERROR: Coordinates must be numeric!": "ERRORE: Le coordinate devono essere numeriche!",
  "geocoded articles": "Articoli geocodificati",
  "No files available for download!": "Nessun file disponibile per il download!",
  "Please select a smaller range.": "Si prega di scegliere un intorno più piccolo.",
  "Version": "Versione",
  "You clicked the map at": "Hai fatto click nella mappa su",
  "You have chosen {nn} articles.": "Hai scelto {nn} articoli." 
};

// change only the labels eg 'Boundaries <img ... to 'Your label <img ...

function layersControl () {
  if (maptype == "artmap") {  
    basemaps = {
      'Mapquest open <img src="./lib/images/external.png" />' : mapquestopen
    };
    overlays = {
      'Articoli WV <img src="./lib/images/wv-logo-12.png" />' : wvarticles
    };
  }
  
  else if (maptype == "geomap") {
    basemaps = {
      'Mapnik <img src="./lib/images/wmf-logo-12.png" />':  mapnik,
      'Mapquest open <img src="./lib/images/external.png" />': mapquestopen,
      'Mapquest aerial <img src="./lib/images/external.png" />': mapquest
    }; 
    overlays = {
      'Etichette Mapquest <img src="./lib/images/external.png" />': maplabels,
      'Confini <img src="./lib/images/external.png" />': boundaries,
      'Piste ciclabili <img src="./lib/images/external.png" />': cycling
    };
  }
 
  else if (maptype == "gpxmap") { 
    basemaps = {
      'Mapquest open <img src="./lib/images/external.png" />' : mapquestopen
    };
    overlays = {
      'Articoli WV <img src="./lib/images/wv-logo-12.png" />' : wvarticles
    };
  }
  
  else if (maptype == "monmap") {
    basemaps = {
      'Mapquest open <img src="./lib/images/external.png" />' : mapquestopen,
      'Mapnik <img src="./lib/images/wmf-logo-12.png" />' : mapnik, 
      'Mappa dei rilievi <img src="./lib/images/external.png" />' : landscape
    };
    overlays = {
      'Monumenti <img src="./lib/images/wv-logo-12.png" />' : monuments
    };
  }

  else if (maptype == "poimap2") {
    basemaps = {
      'Mapnik <img src="./lib/images/wmf-logo-12.png" />' : mapnik,
      'Mapnik b&amp;w <img src="./lib/images/wmf-logo-12.png" />' : mapnikbw,
      'Mapquest open <img src="./lib/images/external.png" />' : mapquestopen,
      'Mapquest aerial <img src="./lib/images/external.png" />' : mapquest,
      'Rete dei trasporti <img src="./lib/images/external.png" />' : transport,
      'Mappa dei rilievi <img src="./lib/images/external.png" />' : landscape
    };
    overlays = {
      'Etichette Mapquest <img src="./lib/images/external.png" />' : maplabels,
      'Confini <img src="./lib/images/external.png" />' : boundaries,
      'Rilievi collinari <img src="./lib/images/wmf-logo-12.png" />' : hill,
      'Piste ciclabili <img src="./lib/images/external.png" />' : cycling,
      'Percorsi escursionistici <img src="./lib/images/external.png" />' : hiking,
      'Punti di interesse <img src="./lib/images/wv-logo-12.png" />' : markers,
      'Destinazioni <img src="./lib/images/wv-logo-12.png" />' : wvarticles,
      'Tracciati GPX e maschere <img src="./lib/images/wv-logo-12.png" />' : tracks
    };
  }
}

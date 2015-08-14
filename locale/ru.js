// Localization English -> Russian <syntaxhighlight lang="javascript">

// change only the texts on the right to your language

var mylocale = {
  "contributors": "вклад участников",
  "contributors, Tiles": "вклад участников, названия",
  "Data, imagery and map information provided by": "данные, фотографии и картографическая информация предоставлены",
  "Locate!": "Найти!",
  "Map center ⇔ all markers": "центр карты ⇔ все маркеры",
  "Map data": "данные карты",
  "POIs ⇔ destinations": "достопримечательности ⇔ пункты назначения",
  "Show me all markers": "показать мне все маркеры",
  "Show me the whole earth": "показать всю землю",
  "Show me where I am": "показать, где я нахожусь",
  "Sorry, that location could not be found.": "к сожалению, это место не удалось найти.",
  "Zoom in": "увеличить",
  "Zoom out": "уменьшить",
   
  "But the maximum number for downloading is 25.": "Нельзя загрузить больше 25 файлов.", 
  "Download GPX file": "Загрузить GPX файл",
  "Download this {nn} GPX files?": "Загрузить эти GPX файлы?",
  "ERROR: Coordinates must be numeric!": "Ошибка: координаты должны быть в формате чисел!",
  "geocoded articles": "статьи с гео-привязкой",
  "No files available for download!": "Файлы для загрузки не найдены!",
  "Please select a smaller range.": "Пожалуйста, выберите меньший участок.",
  "Version": "Версия",
  "You clicked the map at": "Вы выбрали точку",
  "You have chosen {nn} articles.": "Выбрано статей: {nn}." 
};

// change only the labels eg 'Boundaries <img ... to 'Your label <img ...

function layersControl () {
  if (maptype == "artmap") {  
    basemaps = {
      'Mapquest open <img src="./lib/images/external.png" />' : mapquestopen
    };
    overlays = {
      'Статьи Wikivoyage <img src="./lib/images/wv-logo-12.png" />' : wvarticles
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
      'Границы <img src="./lib/images/external.png" />': boundaries,
      'Веломаршруты <img src="./lib/images/external.png" />': cycling
    };
  }
 
  else if (maptype == "gpxmap") { 
    basemaps = {
      'Mapquest open <img src="./lib/images/external.png" />' : mapquestopen
    };
    overlays = {
      'Статьи Wikivoyage <img src="./lib/images/wv-logo-12.png" />' : wvarticles
    };
  }
  else if (maptype == "monmap") {
    basemaps = {
      'Mapquest open <img src="./lib/images/external.png" />' : mapquestopen,
      'Mapnik <img src="./lib/images/wmf-logo-12.png" />' : mapnik, 
      'Рельеф <img src="./lib/images/external.png" />' : landscape
    };
    overlays = {
      'Памятники <img src="./lib/images/wv-logo-12.png" />' : monuments
    };
  }

  else if (maptype == "poimap2") {
    basemaps = {
      'Mapnik <img src="./lib/images/wmf-logo-12.png" />' : mapnik,
      'Mapnik b&amp;w <img src="./lib/images/wmf-logo-12.png" />' : mapnikbw,
      'Mapquest open <img src="./lib/images/external.png" />' : mapquestopen,
      'Mapquest aerial <img src="./lib/images/external.png" />' : mapquest,
      'Маршрутная сеть <img src="./lib/images/external.png" />' : transport,
      'Рельеф <img src="./lib/images/external.png" />' : landscape
    };
    overlays = {
      'Mapquest labels <img src="./lib/images/external.png" />' : maplabels,
      'Границы <img src="./lib/images/external.png" />' : boundaries,
      'Холмы <img src="./lib/images/wmf-logo-12.png" />' : hill,
      'Веломаршруты <img src="./lib/images/external.png" />' : cycling,
      'Пеший туризм <img src="./lib/images/external.png" />' : hiking,
      'Достопримечательности <img src="./lib/images/wv-logo-12.png" />' : markers,
      'Пункты назначения <img src="./lib/images/wv-logo-12.png" />' : wvarticles,
      'GPX tracks / map mask <img src="./lib/images/wv-logo-12.png" />' : tracks
    };
  }
}

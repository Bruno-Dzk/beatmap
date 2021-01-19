const GET_PINS_IN_EXTENT_URL = "http://localhost:8080/pinsInExtent";

const vectorSource = new ol.source.Vector({});
const markerLayer = new ol.layer.Vector({
    source: vectorSource,
    updateWhileAnimating: true,
    updateWhileInteracting: true
  });

const map = new ol.Map({
    target: 'map',
    layers: [
        new ol.layer.Tile({
            source: new ol.source.OSM()
        }),
        markerLayer
    ],
    view: new ol.View({
        center: ol.proj.fromLonLat([0, 0]),
        zoom: 4
    }),
    controls: []
});

function createMarker(pin){
    var iconFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat(pin.coords))
    });

    let src = '';
    console.log(pin.user.verified);
    if(pin.user.verified)
        src = 'public/img/verified_marker.png';
    else
        src = 'public/img/marker.png';  

    var iconStyle = new ol.style.Style({
        image: new ol.style.Icon({
            anchor: [0.5, 1.0],
            anchorXUnits: 'fraction',
            anchorYUnits: 'fraction',
            src: src
        })
    });
      
    iconFeature.setStyle(iconStyle);
    iconFeature.attributes = {
        pin: pin
    };
    vectorSource.addFeature(iconFeature);
}

function refreshMap(){
    let extent = map.getView().calculateExtent(map.getSize());
    extent = convertRectLonLat(extent);
    console.log(extent);

    var url = new URL(GET_PINS_IN_EXTENT_URL);
    var params = [['xmin', extent[0]], ['ymin', extent[1]], ['xmax', extent[2]], ['ymax', extent[3]]];
    url.search = new URLSearchParams(params).toString();

    fetch(url)
    .then(response => response.json())
    .then(response =>{
            vectorSource.clear();
            console.log(response);
            for(let pin of response){
                createMarker(pin);
            }
        });
}

map.on("singleclick", (event) => {
    if(map.hasFeatureAtPixel(event.pixel) === true){
        const features = map.getFeaturesAtPixel(event.pixel);
        const pin = features[0].attributes.pin;
        showPinViewer(pin);
        hidePinCreator();
    }else{
        hidePinViewer();
        const coords = ol.proj.toLonLat(event.coordinate);
        showPinCreator(coords);
    }
})

map.on("pointermove", function (evt) {
    var hit = this.forEachFeatureAtPixel(evt.pixel, function(feature, layer) {
        return true;
    }); 
    if (hit) {
        this.getTargetElement().style.cursor = 'pointer';
    } else {
        this.getTargetElement().style.cursor = '';
    }
});

function convertRectLonLat(extent){
    let begin = extent.slice(0, 2);
    let end = extent.slice(2);
    return ol.proj.toLonLat(begin).concat(ol.proj.toLonLat(end));
}

map.on("moveend", () => {
    refreshMap();
})
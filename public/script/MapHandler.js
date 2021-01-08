class MapHandler{
    constructor(){
        console.log(ol);
        this.map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([0, 0]),
                zoom: 4
            })
        });
        this.map.on("singleclick", (event) => {
            if(this.map.hasFeatureAtPixel(event.pixel) === true){
                console.log("trafiony");
            }else{
                console.log("pudło");
            }
        })
    }
    addEventListener(type, callback){
        this.map.on(type, callback);
    }
    createMarker(pin){
        var iconFeature = new ol.Feature({
            geometry: new ol.geom.Point(pin.coords)
        });
        console.log(pin);

        let src = '';
        if(pin.verified)
            src = 'img/verified_marker.png';
        else
            src = 'img/marker.png';  

        var iconStyle = new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 1.0],
                anchorXUnits: 'fraction',
                anchorYUnits: 'fraction',
                src: src
            })
        });
          
        iconFeature.setStyle(iconStyle);
          
        var vectorSource = new ol.source.Vector({
        features: [iconFeature],
        });
        var layer = new ol.layer.Vector({
            source: vectorSource
        });
        this.map.addLayer(layer);
    }
}


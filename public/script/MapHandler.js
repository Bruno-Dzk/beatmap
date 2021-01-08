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
                center: ol.proj.fromLonLat([4.35247, 50.84673]),
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
    createMarker(){
        var iconStyle = new ol.style.Style({
            image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                anchor: [0.5, 46],
                anchorXUnits: 'fraction',
                anchorYUnits: 'pixels',
                opacity: 0.75,
                src: 'img/marker.png'
            }))
        });
        var layer = new ol.layer.Vector({
            source: new ol.source.Vector({
                features: [
                    new ol.Feature({
                        labelPoint: new ol.geom.Point(4.35247, 50.84673),
                        name: 'My Polygon',
                        geometry: new ol.geom.Point(ol.proj.fromLonLat([4.35247, 50.84673])),
                    })
                ]
            })
        });
        this.map.addLayer(layer);
    }
}


const GET_PINS_IN_EXTENT_URL = "http://localhost:8080/pinsInExtent";

class MapHandler{
    constructor(){
        this.markers = [];
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
        this.map.on("moveend", () => {
            const extent = this.map.getView().calculateExtent(this.map.getSize());
            console.log(extent);
            console.log(this.map.getView().getZoom())

            var url = new URL(GET_PINS_IN_EXTENT_URL);
            var params = [['xmin', extent[0]], ['ymin', extent[1]], ['xmax', extent[2]], ['ymax', extent[3]]];

            url.search = new URLSearchParams(params).toString();
            const response = fetch(
                url,
                {
                method: 'GET', // *GET, POST, PUT, DELETE, etc.
                mode: 'cors', // no-cors, *cors, same-origin
                cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                headers: {
                "Accept": "application/json",
                },
                redirect: 'follow', // manual, *follow, error
                referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
            }).then(response =>{
                response.json().then(response =>
                    {
                        this.clear();
                        for(let pin of response){
                            this.createMarker(pin);
                        }
                    }
                );
            })
        })
    }
    addEventListener(type, callback){
        this.map.on(type, callback);
    }
    clear(){
        for(let marker of this.markers){
            this.map.removeLayer(marker);
        }
        this.markers = [];
    }
    createMarker(pin){
        console.log(pin.coords);
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
        this.markers.push(layer);
    }
}


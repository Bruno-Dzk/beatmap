class MapHandler {
    constructor() {
        this.map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                })
            ],
            view: new ol.View({
                center: [0, 0],
                zoom: 4
            })
        });
        this.map.on("singleclick", this.singleclick.bind(this));
        this.onClick = function(event){};
    }
    singleclick(event) {
        this.onClick(event.coordinate);
    }
}

class App {
    main() {
        // var req = new HTTPRequest("http://localhost:8080/pin/1", "GET", function(response){
        //     console.log(response);
        // })
        // req.send();
        const mapHandler = new MapHandler();

        const creatorDiv = document.querySelector(".pin-creator");
        const pinCreator = new PinCreator(creatorDiv, mapHandler);

        //mapHandler.createMarker([0,0]);
        mapHandler.addEventListener("singleclick", (event) => {
            creatorDiv.classList.add("visible");
            //let coords = ol.coordinate.toStringHDMS(event.coordinate);
            pinCreator.setCoords(event.coordinate);
        })
        //mapHandler.onClick = pinCreator.toggleVisibility();

        // const searchbox = document.querySelector(".searchbox input");
        // console.log(searchbox);
        // searchbox.oninput = function(){
        //     trackFinder.search(encodeURI(searchbox.value));
        // }
    }
}

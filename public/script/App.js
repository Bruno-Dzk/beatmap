class App {
    main() {
        const model = new Model();
        var req = new HTTPRequest("http://localhost:8080/pin/1", "GET", function(response){
            console.log(response);
        })
        req.send();
        const trackList = new TrackList(document.getElementById("test-scroller"));

        const trackFinder = new TrackFinder(trackList);

        const searchbox = document.querySelector(".searchbox input");
        console.log(searchbox);
        searchbox.oninput = function(){
            trackFinder.search(encodeURI(searchbox.value));
        }
    }
}

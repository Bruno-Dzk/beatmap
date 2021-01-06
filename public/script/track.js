const API_URL = "https://api.spotify.com/v1/search";
const TOKEN = "Bearer BQBuj1-13mfRXQB5uBG0cgBGU0VruFwLCqPEV7Tx7q7zkd6d4A3Al1-q3ZV3D0juY_rUawfkY0tbUdr4bNTAQI3x-uzQddDxgWfE8mvk5VSHehSydeLmVkC4bnxYn29oBSV4VtXYgLKnIfuyPw-nctMXWVjR21OsIUk";

/*
class Component{
    render(){};
}
*/

class TrackFinder{
    constructor(trackView){
        this.trackView = trackView;
    }
    onDataLoad(data){
        this.trackView.empty();
        for(const track of data.tracks.items){
            this.trackView.addItem(track);
        }
    }
    search(query){
        console.log("sending");
        let xhttp = new XMLHttpRequest();
        var self = this;
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                console.log("Loaded JSON succesfully.");
                const json = JSON.parse(this.response);
                self.onDataLoad(json);
            }
        };
        xhttp.open("GET", API_URL + "?q=" + query + "&type=track&market=US&limit=10&offset=0");
        xhttp.setRequestHeader("Accept", "application/json");
        xhttp.setRequestHeader("Content-type", "application/json");
        xhttp.setRequestHeader("Authorization", TOKEN);
        xhttp.send();
    }
}
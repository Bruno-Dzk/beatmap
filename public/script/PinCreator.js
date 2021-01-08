const CREATE_PIN_URL = "http://localhost:8080/pin";

class PinCreator extends Component{
    constructor(container, spotifyApi){
        super(container);
        this.render(PinCreator.markup());
        this.trackSearch = this.getChild("#track-search");
        this.trackList = new TrackList(this.getChild(".track-list"));
        this.createButton = this.getChild(".pin-create");
        this.cancelButton = this.getChild(".cancel");
        this.spotifyApi = spotifyApi;
        this.coords = [];
        this.addEventListeners();
    }
    createPin(track){
        let data = {
            trackID: track.id,
            coords: this.coords,
            authorID: "A31iyf1u12gi1p" 
        };
        fetch(
            CREATE_PIN_URL,
            {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
        }).then(response => 
            response.json().then(data => ({
                data: data,
                status: response.status
            })
        ).then(res => {
            console.log(res.data);
            console.log(res.status, res.data.title)
        }));
        
    }
    addEventListeners(){
        this.trackSearch.addEventListener("input", (event) => {
            let query = event.target.value;
            this.trackList.update(this.spotifyApi.search(query));
        });
        this.createButton.addEventListener("click", () => {
            let track = this.trackList.getSelected();
            this.createPin(track);
            this.container.classList.remove("visible");
        });
        this.cancelButton.addEventListener("click", () => {
            this.container.classList.remove("visible");
        });
    }
    setCoords(coords){
        this.coords = coords;
        this.getChild(".lonlat-header").innerHTML = coords;
    }
    static markup (){
        return `
            <div class="lonlat-header">42.981°N 77.99°W</div>
            <div class="box-header">
                <h1 class="box-title">
                    Create a new pin
                </h1>
                <p class="box-desc">
                    Choose a song from Spotify to be available for other users as a pin on the map:
                </p>
            </div><div class="searchbox">
                <input type="search" id="track-search" name="track-search" spellcheck="false">
            </div>
            <div class="track-list" id="test-scroller"></div>
            <div class="button-box">
                <div class="button pin-create">Create</div>
                <div class="button cancel">Cancel</div>
            </div>
            `
    }
}
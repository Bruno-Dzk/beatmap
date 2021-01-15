class TrackList{
    constructor(container){
        this.container = container;
        this.tracks = [];
        this.selected = null;
        this.trackItems = [];
    }
    _addItem(trackData){
        let itemDiv = document.createElement('div');
        itemDiv.classList.add("track");
        this.container.append(itemDiv);
        let artistsString = "";
        for(const artist of trackData.artists){
            artistsString += artist + " ";
        }
        const item = new Track(
            itemDiv,
            trackData.track_id,
            trackData.name,
            trackData.artists,
            trackData.imgURL
        );
        this.trackItems.push(item);
        item.addEventListener("click", () => {
            if(this.selected != null){
                this.selected.toggleSelected();
            }
            this.selected = item;
            item.toggleSelected();
        });
    }
    update(query){
        fetch(
            "http://localhost:8080/searchTracks?query="+query 
        )
        .then(response => response.json())
        .then(data => {
            for(const track of data){
                this._addItem(track);
            }
        });
    }
    getSelected(){
        return this.selected;
    }
}
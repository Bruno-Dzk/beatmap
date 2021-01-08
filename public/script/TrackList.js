class TrackList{
    constructor(container){
        this.container = container;
        this.tracks = [];
        this.selected = null;
    }
    _parseArtists(trackData){
        let listStr = "";
        let counter = 0;
        for(const artist of trackData.artists){
            if (counter++)
                listStr += ", ";
            listStr += artist.name;
        }
        return listStr;
    }
    _addItem(trackData){
        let itemDiv = document.createElement('div');
        itemDiv.classList.add("track");
        this.container.append(itemDiv);
        const item = new Track(
            itemDiv,
            trackData.id,
            trackData.name,
            this._parseArtists(trackData),
            trackData.album.images[2].url
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
    async update(dataPromise){
        const data = await dataPromise;
        this.trackItems = [];
        this.container.innerHTML = "";
        for(const trackData of data.tracks.items){
            this._addItem(trackData);
        }
    }
    getSelected(){
        return this.selected;
    }
}
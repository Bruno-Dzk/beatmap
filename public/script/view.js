
const TRACK_ITEM_HTML = `<img width="64" height="64">
                        <div class="track-desc">
                            <h1 class="track-title">
                                title missing
                            </h1>
                            <h2 class="track-artists">
                                author missing
                            </h2>
                            <p class="track-selected" style="display:none;">
                                SELECTED
                            </p>
                        </div>`

class TrackItem{
    constructor(title, artists, imgSrc, parent){
        this.div = document.createElement("div");
        this.div.classList.add("track");
        this.div.innerHTML = TRACK_ITEM_HTML;
        this.setImageSrc(imgSrc);
        this.setTitle(title);
        this.setArtists(artists);
        this.div.onclick = this.select.bind(this);
        this.parent = parent;
    }
    select(){
        console.log(this);
        const selectElement = this.div.querySelector(".track-selected");
        selectElement.style.display = "inline";
        this.div.classList.add("selected");
        this.parent.select(this);
    }
    deselect(){
        const selectElement = this.div.querySelector(".track-selected");
        selectElement.style.display = "none";
        this.div.classList.remove("selected");
    }
    setTitle(title){
        const titleElement = this.div.querySelector(".track-title");
        titleElement.innerHTML = title;
    }
    setImageSrc(src){
        const img = this.div.querySelector("img");
        img.src = src;
    }
    setArtists(artists){
        const artistsElement = this.div.querySelector(".track-artists");
        artistsElement.innerHTML = artists;
    }
    appendTo(element){
        element.append(this.div);
    }
}

class TrackList{
    constructor(div){
        console.log(div);
        this.div = div;
        this.selected = null;
    }
    addItem(trackData){
        console.log(trackData);
        const item = new TrackItem(trackData.name, this.parseArtists(trackData), trackData.album.images[2].url, this);
        item.appendTo(this.div);
    }
    parseArtists(trackData){
        let listStr = "";
        let counter = 0;
        for(const artist of trackData.artists){
            if (counter++)
                listStr += ", ";
            listStr += artist.name;
        }
        return listStr;
    }
    empty(){
        this.div.innerHTML = "";
    }
    select(item){
        if(this.selected != null){
            this.selected.deselect();
        }
        this.selected = item;
    }
    getSelected(){
        return this.selected();
    }
}

class View{
    constructor(){
        this.pinCreatorDiv = document.getElementById("pin-creator");
    }
    showCreator(){
        this.pinCreatorDiv.style.display = "flex";
    }
    hideCreator(){
        this.pinCreatorDiv.style.display = "none";
    }
    getSelectedTrack(){
        this.TrackList.getSelected();
    }
    setCreateCallback(callback){
        
    }
}
class Pin{
    constructor(trackId, coords, author_id, no_likes, no_dislikes, verified){
        this.trackId = trackId;
        this.coords = coords;
        this.author_id = author_id;
        this.no_likes = no_likes;
        this.no_dislikes = no_dislikes;
        this.verified = verified;
    }
}

class PinCreator{
    constructor(){

    }
    createPin(coords){
        const CREATOR_DIV = document.getElementById("pin-creator");
        CREATOR_DIV.style.display = "flex";
        console.log(coords);
    }
}

class PinController{
    constructor(){
        this.mapHandler = new MapHandler();
        this.pinCreator = new PinCreator();
        this.mapHandler.onClick = this.pinCreator.createPin;
    }
}
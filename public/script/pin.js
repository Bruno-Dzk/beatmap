const TRACK_URL = "http://localhost:8080/track"
const LONLAT_PRECISION = 3;
const CREATE_PIN_URL = "http://localhost:8080/addPin";

const pinCreator = document.querySelector(".pin-creator");
const pinViewer = document.querySelector(".pin-viewer");
const trackSearch = pinCreator.querySelector("#track-search");
const trackList = pinCreator.querySelector(".track-list");
const cancelCreateButton = pinCreator.querySelector(".cancel-create");
const pinCreateButton = pinCreator.querySelector(".pin-create");

var GLOBAL = {
    coords : [0.0, 0.0]
}

function showPinViewer(pin){
    const name = pinViewer.querySelector(".track-name");
    const artists = pinViewer.querySelector(".track-artists");
    const app_user = pinViewer.querySelector(".app-user-name");
    const likes = pinViewer.querySelector(".pin-no-likes");
    const dislikes = pinViewer.querySelector(".pin-no-dislikes");
    const img = pinViewer.querySelector(".track-image");
    fetch(TRACK_URL + "/" + pin.track_id)
    .then(response => response.json())
    .then(track => {
        name.innerHTML = track.name;
        artists.innerHTML = artistsToString(track.artists);;
        app_user.innerHTML = pin.app_user_id;
        likes.innerHTML = pin.no_likes;
        dislikes.innerHTML = pin.no_dislikes;
        img.src = track.imgURL;
    }).then(() => {
        pinViewer.classList.add("visible");
    })
}

function hidePinViewer() {
    pinViewer.classList.remove("visible");
}

function showPinCreator(coords) {
    GLOBAL.coords = coords;
    let lonlat = pinCreator.querySelector(".lonlat-header");
    lonlat.innerHTML = coords[1].toFixed(LONLAT_PRECISION) + "°N " + coords[0].toFixed(LONLAT_PRECISION) + "°W";
    pinCreator.classList.add("visible");
}

function hidePinCreator(){
    pinCreator.classList.remove("visible");
}

cancelCreateButton.addEventListener("click", function(){
    hidePinCreator();
})

pinCreateButton.addEventListener("click", function(){
    let selected = trackList.querySelector(".track-selected");
    console.log(GLOBAL.coords);
    if(selected != null){
        let track_id = selected.dataset.track_id;
        let data = {
            track_id: track_id,
            coords: GLOBAL.coords
        }
        fetch(
            CREATE_PIN_URL,
            {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
        })
        .then(response => {
            console.log(response);
        })
    }
})
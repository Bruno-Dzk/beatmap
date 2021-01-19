const APP_URL = window.location.protocol + "//" + window.location.host;
const TRACK_URL = APP_URL + "/track";
const LONLAT_PRECISION = 3;
const CREATE_PIN_URL = APP_URL + "/addPin";
const SPOTIFY_OPEN_URL = "https://open.spotify.com/track";

const pinCreator = document.querySelector(".pin-creator");
const pinViewer = document.querySelector(".pin-viewer");
const trackSearch = pinCreator.querySelector("#track-search");
const trackList = pinCreator.querySelector(".track-list");
const cancelCreateButton = pinCreator.querySelector(".cancel-create");
const pinCreateButton = pinCreator.querySelector(".pin-create");

var GLOBAL = {
    coords : [0.0, 0.0]
}

function setLonlat(lonlatHeader, n, e){
    lonlatHeader.innerHTML = parseFloat(n).toFixed(LONLAT_PRECISION) + "°N"
                        + "&nbsp&nbsp&nbsp" + parseFloat(e).toFixed(LONLAT_PRECISION) + "°E";
}

function showPinViewer(pin){
    const name = pinViewer.querySelector(".track-name");
    const artists = pinViewer.querySelector(".track-artists");
    const app_user = pinViewer.querySelector(".app-user-name");
    const likes = pinViewer.querySelector(".pin-no-likes");
    const dislikes = pinViewer.querySelector(".pin-no-dislikes");
    const img = pinViewer.querySelector(".track-image");
    const spotifyLink = pinViewer.querySelector(".spotify-link");
    let lonlat = pinViewer.querySelector(".lonlat-header");
    setLonlat(lonlat, pin.coords[1], pin.coords[0]);
    fetch(TRACK_URL + "/" + pin.track_id)
    .then(response => {
        if(response.ok){
            response.json()
            .then(track => {
                name.innerHTML = track.name;
                artists.innerHTML = artistsToString(track.artists);;
                app_user.innerHTML = pin.username;
                likes.innerHTML = pin.no_likes;
                dislikes.innerHTML = pin.no_dislikes;
                spotifyLink.href = SPOTIFY_OPEN_URL + "/" + track.track_id;
                img.src = track.imgURL;
            }).then(() => {
                pinViewer.classList.add("visible");
            })
        }else if(response.status == 401){
            window.location.href = APP_URL + "/relog";
        }
    })
}

function hidePinViewer() {
    pinViewer.classList.remove("visible");
}

function showPinCreator(coords) {
    GLOBAL.coords = coords;
    let lonlat = pinCreator.querySelector(".lonlat-header");
    setLonlat(lonlat, coords[1], coords[0]);
    pinCreator.classList.add("visible");
}

function hidePinCreator(){
    pinCreator.classList.remove("visible");
}

function clearPinCreator() {
    trackList.innerHTML = "";
    trackSearch.value = "";
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
            if(response.ok){
                refreshMap();
                hidePinCreator();
                clearPinCreator();
            }else if(response.status == 401){
                window.location.href = APP_URL + "/relog";
            }
        })
    }
})
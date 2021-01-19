const SEARCH_TRACK_URL = APP_URL+ "/searchTracks?query=";

function artistsToString(artistsArray){
    let string = "";
    for(artist of artistsArray){
        string += artist;
        if(artist !== artistsArray[artistsArray.length - 1]){
            string += ", ";
        }
    }
    return string;
}


function track_markup(name, artists, imgURL){
    return `
        <img width="64" height="64" src="${imgURL}">
        <div class="track-desc">
            <h1 class="track-title">
                ${name}
            </h1>
            <h2 class="track-artists">
                ${artists}
            </h2>
            <p class="track-selected-label">
                SELECTED
            </p>
        </div>`
}

function createTrackView(track){
    let itemDiv = document.createElement('div');
    itemDiv.classList.add("track");
    itemDiv.innerHTML = track_markup(track.name, artistsToString(track.artists), track.imgURL);
    itemDiv.addEventListener("click", function(){
        let prev = trackList.querySelector(".track-selected");
        if(prev){
            prev.classList.remove("track-selected");
        }
        this.classList.add("track-selected");
    })
    itemDiv.dataset.track_id = track.track_id;
    return itemDiv;
}

trackSearch.addEventListener("input", function(){
    let query = this.value;
    fetch(
        encodeURI(SEARCH_TRACK_URL + query)
    )
    .then(response => {
        if(response.ok){
            response.json()
            .then(tracks => {
                trackList.innerHTML = "";
                for(const track of tracks){
                    let trackView = createTrackView(track);
                    trackList.append(trackView);
                }
            });
        }else if(response.status == 401){
            window.location.href = APP_URL + "/relog";
        }else if(response.status == 404){
            trackList.innerHTML = "";
        }
    })
})
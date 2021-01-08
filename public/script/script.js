// const search_input = document.querySelector("#track-search");
// const track_list = document.querySelector(".track-list");

// class Component{
//     constructor(container){
//         this.container = container;
//     }
//     render(markup){
//         this.container.innerHTML = markup;
//     };
//     addEventListener(type, callback){
//         this.container.addEventListener(type, callback);
//     }
// }

// class TrackItem extends Component{
//     constructor(container, id, title, artists, imgSrc){
//         super(container);
//         this.render(TrackItem.markup(title, artists, imgSrc));
//         this.id = id;
//         this.title = title;
//         this.artists = artists;
//         this.imgSrc = imgSrc;
//     }
//     select(){
//         this.container.classList.add("track-selected");
//     }
//     static markup(title, artists, imgSrc){
//         return `
//             <img width="64" height="64" src="${imgSrc}">
//             <div class="track-desc">
//                 <h1 class="track-title">
//                     ${title}
//                 </h1>
//                 <h2 class="track-artists">
//                     ${artists}
//                 </h2>
//                 <p class="track-selected-label"">
//                     SELECTED
//                 </p>
//             </div>`
//     }
// }

// const TOKEN = "Bearer BQBQw-8Yc954teZNIXunnCoqAzajl0F_czgIsq-IQXhOaO_WRR57DGU4n9fRnJEVoX356C6VyfIP4y8debrCQr-kBTOFU_a--9i_--PEGBwxOWkqbGnRZbD2_BNIw4GBir2_11a6aWP9-coKfCreln036wr8NKtS-0E";
// const API_URL = "https://api.spotify.com/v1/search";

// search_input.addEventListener("input", function(event){
//     let query = event.target.value;
//     let url = API_URL + "?q=" + query + "&type=track&market=US&limit=10&offset=0";
//     let request = new JSONRequest(url, "GET", renderFound);
//     console.log(request);
//     request.setHeader("Accept", "application/json");
//     request.setHeader("Content-type", "application/json");
//     request.setHeader("Authorization", TOKEN);
//     request.send();
// })

// function parseArtists(trackData){
//     let listStr = "";
//     let counter = 0;
//     for(const artist of trackData.artists){
//         if (counter++)
//             listStr += ", ";
//         listStr += artist.name;
//     }
//     return listStr;
// }

// function selectTrack(event){
//     var previous = document.querySelector(".track-selected");
//     if(previous){
//         previous.classList.remove("track-selected");
//     }
//     this.select();
// }

// function createTrack(trackData){
//     let itemDiv = document.createElement('div');
//     itemDiv.classList.add("track");
//     track_list.append(itemDiv);
//     const item = new TrackItem(itemDiv, trackData.id, trackData.name, parseArtists(trackData), trackData.album.images[2].url);
//     item.addEventListener("click", selectTrack.bind(item));
// }

// function renderFound(data){
//     track_list.innerHTML = "";
//     for(const trackData of data.tracks.items){
//         createTrack(trackData);
//     }
// }

// class Pin{
//     constructor(trackId, coords, author_id, no_likes, no_dislikes, verified){
//         this.trackId = trackId;
//         this.coords = coords;
//         this.author_id = author_id;
//         this.no_likes = no_likes;
//         this.no_dislikes = no_dislikes;
//         this.verified = verified;
//     }
// }

// function createPin(){
//     let pin = new Pin()
// }
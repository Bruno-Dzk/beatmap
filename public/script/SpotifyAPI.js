const AUTHORIZE_URL = "https://accounts.spotify.com/authorize";
const API_URL = "https://api.spotify.com/v1/search";
const TOKEN = "Bearer BQAf6LJXF9YRa-DB5dcvldE6kK5UIhM2hxGNd67ekVZGRl6vAXFfANvDxfXz7INkziGOhI--e0aXoJfbd6CpivHesQIxKVbLYyGbafxfk23lqQVgPkNLJW7CYkOeJ5x3JLG1Vol9yc0aJUpd--7kIPmEG9guAs6Cnec";


class SpotifyAPI{
    async search(query){
        // let url = API_URL + "?q=" + query + "&type=track&market=US&limit=10&offset=0";
        // let request = new JSONRequest(url, "GET", (callback));
        // console.log(request);
        // request.setHeader("Accept", "application/json");
        // request.setHeader("Content-type", "application/json");
        // request.setHeader("Authorization", TOKEN);
        // request.send();
        const response = await fetch(
            API_URL + "?q=" + query + "&type=track&market=US&limit=10&offset=0",
            {
            method: 'GET', // *GET, POST, PUT, DELETE, etc.
            mode: 'cors', // no-cors, *cors, same-origin
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            headers: {
            "Accept": "application/json",
            'Content-Type': 'application/json',
            "Authorization": TOKEN,
            },
            redirect: 'follow', // manual, *follow, error
            referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        })
        return response.json();
    }
}
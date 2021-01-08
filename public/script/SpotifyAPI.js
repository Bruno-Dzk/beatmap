const AUTHORIZE_URL = "https://accounts.spotify.com/authorize";
const API_URL = "https://api.spotify.com/v1/search";
const TOKEN = "Bearer BQCx3K1I2TEWGUimtTxCjpv6I4ab6X26fvz2x4rThBstlNHa0xiqrdnA4--5hUzN5F3_NcN3ZlfxTh--t8BFK-D5eNYavaKbW89-hxymqLtAJJPdAAUlcPP5O_38AUQRDPCX7yXW1-S8g3cWThN5QY-xP36IZ0p6oAs";


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
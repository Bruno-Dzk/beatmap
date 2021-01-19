const REFRESH_URL = APP_URL + "/refresh";

const refresh = setInterval(function(){
    fetch(
        REFRESH_URL,
        {
            method: "POST",
        }
    ).then(response => {
        console.log(response);
    })
}, 60 * 1000); //Each minute
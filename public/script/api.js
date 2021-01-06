class HTTPRequest{
    constructor(url, method, callback){
        this.xhttp = new XMLHttpRequest();
        this.url = url;
        this.method = method;
        this.xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                callback(this.response);
            }
        };
    }
    send(){
        this.xhttp.open(this.method, this.url, true);
        this.xhttp.send();
    }
}
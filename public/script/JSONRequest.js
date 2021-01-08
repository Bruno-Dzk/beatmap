// class JSONRequest{
//     constructor(url, method, callback){
//         this.xhttp = new XMLHttpRequest();
//         this.url = url;
//         this.method = method;
//         this.xhttp.onreadystatechange = function() {
//             if (this.readyState == 4 && this.status == 200) {
//                 let parsed = JSON.parse(this.response);
//                 callback(parsed);
//             }
//         };
//         this.xhttp.open(this.method, this.url, true);
//     }
//     send(){
//         this.xhttp.send();
//     }
//     setHeader(name, value){
//         this.xhttp.setRequestHeader(name, value);
//     }
// }
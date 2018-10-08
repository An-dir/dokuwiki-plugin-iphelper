function pingfromserver(host, callback) {
    "use strict";
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
            alert(xmlHttp.responseText);
        }
    };
    xmlHttp.open("GET", "/ping.php?host=" + host, true);
    xmlHttp.send(null);
}
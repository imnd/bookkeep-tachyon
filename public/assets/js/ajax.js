var ajax = {
    get : function (path, data, callback, respType, contentType) {
        if (typeof data === "function") {
            respType = callback;
            callback = data;
            data = {};
        }
        this.sendRequest({
            path : path,
            data : data,
            callback : callback,
            respType : respType,
            type : "GET",
            contentType : contentType,
        });
    },
    post : function (path, data, callback, respType, contentType) {
        this.sendRequest({
            path : path,
            data : data,
            callback : callback,
            respType : respType,
            type : "POST",
            contentType : contentType,
        });
    },
    sendRequest : function(options) {
        var xhr = this.createRequest();
        if (!xhr) {
            alert("Браузер не поддерживает AJAX");
            return;            
        }
        var
            path = options["path"] + "?ajax=true",
            callback = options["callback"],
            requestType = options["type"],
            data = options["data"] || {},
            sendData = '',
            respType = options["respType"] || "json",
            contentType = options["contentType"] || "application/x-www-form-urlencoded"
        ;

        if (requestType=="GET") {
            for (var key in data)
                path += "&" + key + "=" + data[key];
        }
        if (contentType=="multipart/form-data") {
            var boundary = String(Math.random()).slice(2);
            contentType += '; boundary=' + boundary;
            var
                boundaryMiddle = '--' + boundary + '\r\n',
                boundaryLast = '--' + boundary + '--\r\n',
                fileName = data.name
            ;
            sendData = '\r\n' + boundaryMiddle + 'Content-Disposition: form-data; name="data"; filename="' + fileName + '"\r\nContent-Type: image/jpeg\r\n\r\n' + data.data + '\r\n';
            sendData += boundaryLast;
            delete(data.name);
            delete(data.data);
            for (var key in data) {
                path += "&" + key + "=" + data[key];
            }
        } else {
            var sendData = [];
            for (var key in data) {
                sendData.push(key + "=" + data[key]);
            }
            sendData = sendData.join("&");
        }
        xhr.open(requestType, path, true);
        xhr.setRequestHeader("Content-Type", contentType);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    var rData = xhr.responseText;
                    if (respType==="json") {
                        if (rData=="true")
                            return {success: true};

                        if (rData=="false")
                            return {success: false};

                        var eData = !(/[^,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]/.test(rData.replace(/"(\\.|[^"\\])*"/g, ""))) && eval("(" + rData + ")");
                        var eArray = new Object(eData);
                        callback(eArray);
                    } else {
                        callback(rData);
                    }
                }
            }
        };
        // Тело запроса готово, отправляем
        xhr.send(sendData);
    },
    createRequest : function () {
        if (window.XMLHttpRequest) {
            return new XMLHttpRequest();
        } else if (window.ActiveXObject) {
            var xhr;
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP"); 
            } catch (e){}
            try {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e){
                return false;
            }
            return xhr;
        }
        return false;
    },
};
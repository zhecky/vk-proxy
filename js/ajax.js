/**
 * Created by JetBrains PhpStorm.
 * User: zhecky
 * Date: 13.01.13
 * Time: 14:23
 */

var ajax = {
    create : function() {
        var req;
        if (navigator.appName == "Microsoft Internet Explorer") {
            req = new ActiveXObject("Microsoft.XMLHTTP");
        } else {
            req = new XMLHttpRequest();
        }
        return req;
    },
    generic : function(url, method, paramString, callback, errorCallback) {
        var xhrObject = this.create();
        xhrObject.onreadystatechange = function() {
            if (xhrObject.readyState == 4) {
                if (xhrObject.status == 200) {
                    callback(xhrObject.responseText);
                } else {
                    errorCallback(xhrObject.status, xhrObject.statusText);
                }
            }
        };
        xhrObject.open(method, url, true);
        xhrObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
        xhrObject.send(paramString);
    },
    apiPost : function(obj, callback, errCallback) {
        var startTime = microtime(true);
        this.postObject('/api.php', obj, function(content) {
            var data = fromJSON(content);
            if (data && data['s'] == 1) {
                if (isDefined(callback)) {
                    callback(data);
                } else {
                    log.warn("No handler defined");
                }
            } else {
                log.error('Negative server answer');
                if (isDefined(errCallback)) {
                    errCallback.call(this, 200, 'wrong status', data['s']);
                }
                if(data['s'] == -1){
                    document.location.href = "/";
                }
            }
        }, function(statusCode, details) {
            log.error('[ajax.apiPost] ' + statusCode + ": " + details);
            if (isDefined(errCallback)) {
                errCallback.call(this, statusCode, details);
            }
        });
    },
    postObject : function(url, obj, callback, errorCallBack) {
        this.generic(url, "POST", this.objectToUrlString(obj), callback, errorCallBack);
    },
    sendGetObject : function(url, obj, callback, errorCallBack) {
        this.generic(url + this.objectToUrlString(obj), "GET", "", callback, errorCallBack);
    },
    objectToUrlString : function(obj) {
        var result = "";
        for (var key in obj) {
            if(typeof obj[key] === "object"){
                for(var objKey in obj[key]){
                    result += ((result.length > 0) ? '&' : '') + key + '[' + objKey + ']' + '=' + encodeURIComponent(obj[key][objKey]);
                }
            } else {
                result += ((result.length > 0) ? '&' : '') + key + '=' + encodeURIComponent(obj[key]);
            }
        }
        return result;
    }
};

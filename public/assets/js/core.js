var dom = {
    ready : function(a,b,c){b=document,c='addEventListener';b[c]?b[c]('DOMContentLoaded',a):window.attachEvent('onload',a)},

    find : function (string, doc) {
        if (doc===undefined)
            doc = document;

        return doc.querySelector(string);
    },
    findLast : function (string, doc) {
        if (doc===undefined)
            doc = document;

        var els = doc.querySelectorAll(string);
        return els[els.length - 1];
    },
    findAll : function (string, doc) {
        if (doc===undefined)
            doc = document;

        return doc.querySelectorAll(string);
    },
    findObj : function (obj, doc) {
        return typeof(obj)==="object" ? obj : this.findById(obj, doc) || this.findByName(obj, doc);
    },
    findById : function(id, doc) {
        if (doc===undefined)
            doc = document;

        return doc.getElementById ? doc.getElementById(id) : doc.all ? doc.all[id][1] : doc.layers[id];
    },
    findByTag : function(name, doc) {
        return this.findAllByTag(name, doc)[0];
    },
    findAllByTag : function(name, doc) {
        if (doc===undefined)
            doc = document;

        if (doc.getElementsByTagName)
            return doc.getElementsByTagName(name);
    },
    findByName : function(name, doc) {
        if (doc===undefined)
            doc = document;

        return doc.getElementsByName ? doc.getElementsByName(name)[0] : doc.all ? doc.all[name] : doc.layers[name];
    },
    findAllByName : function(name, doc) {
        if (doc===undefined)
            doc = document;

        return doc.getElementsByName ? doc.getElementsByName(name) : doc.all ? doc.all[name] : doc.layers[name];
    },
    findByClass : function(className, doc) {
        var objs = this.findAllByClass(className, doc);
        if (objs!==undefined)
            return objs[0];
    },
    findLastByClass : function(className, doc) {
        var objs = this.findAllByClass(className, doc);
        if (objs!==undefined)
            return objs[objs.length-1];
    },
    findAllByClass : function(className, doc) {
        if (doc===undefined)
            doc = document;

        if (doc.getElementsByClassName(className))
            return doc.getElementsByClassName(className);
    },

    val : function(obj, value) {
        obj = this.findObj(obj);
        if (obj===null || typeof obj==="undefined")
            return "";

        var objType = obj.type;
        if (objType==="checkbox") {
            if (value===undefined)
                return obj.checked;
            else
                obj.checked = value;
        } else if (objType==="select-one" || objType==="select-multiple") {
            if (value===undefined)
                return obj.options[obj.selectedIndex].value ? obj.options[obj.selectedIndex].value : obj.options[obj.selectedIndex].text;
            else {
                var options = obj.options;
                for (var key in options)
                    if (options[key].value===value)
                        obj.selectedIndex = key;
            }
        } else if (obj.value!==undefined) {
            if (objType=="text" 
                || objType==="password" 
                || objType==="hidden" 
                || objType==="textarea"
                || objType==="select-one"
                ) {
                    if (value===undefined)
                        return obj.value;
                    else
                        obj.value = value;
                }
        } else if (obj.innerHTML!==undefined) {
            if (value===undefined)
                return obj.innerHTML;
            else {
                obj.innerHTML = value;
            }
        }
    },
    attr : function(obj, attr, value) {
        obj = this.findObj(obj);

        if (value===undefined)
            return this.getAttr(obj, attr);
        else
            this.setAttr(obj, attr, value);
    },
    getAttr : function(obj, attr) {
        if (obj.getAttribute)
            return obj.getAttribute(attr);
    },
    setAttr : function(obj, attr, value) {
        if (obj.setAttribute)
            obj.setAttribute(attr, value)
    },

    clearForm : function() {
        var frm = this.findObj(arguments[0]);
        var ctrls = frm.childNodes;
        for (var i in ctrls)
            this.clear(ctrls[i]);
    },
    clear : function(obj) {
        obj = this.findObj(obj);

        if (typeof obj==="undefined")
            return;

        var objType = obj.type;
        if (objType==="checkbox")
            obj.checked = "";  
        else if (objType==="select-one" || objType==="select-multiple")
            obj.selectedIndex = 0;
        else if (obj.value!==undefined) {
            if (objType=="text" 
                || objType==="password" 
                || objType==="hidden" 
                || objType==="textarea"
                || objType==="select-one"
                ) 
                obj.value = "";
        } else if (obj.innerHTML)
            obj.innerHTML = "";
    },        
    hide : function(objID) {
        var obj = this.findById(objID);     
        obj.className = "hidden";
    },
};

var ajax = {
    resp : {},
    post : function (handlerPath, params, callback, respType) {
        this.sendRequest(handlerPath, params, callback, respType, "POST");
    },
    get : function (handlerPath, params, callback, respType) {
        if (typeof params === "function") {
            respType = callback;
            callback = params;
            params = {};
        }
        this.sendRequest(handlerPath, params, callback, respType, "GET");
    },
    sendRequest : function(handlerPath, params, callback, respType, type) {
        if (respType===undefined) {
            respType = "json"
        }
        handlerPath += "?ajax=true";
        if (type=="GET") {
            for (var key in params)
                handlerPath += "&" + key + "=" + params[key];

            params = null;
        }
        var xhr = this.createRequest();
        if (xhr) {
            xhr.open(type, handlerPath, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send(params);
            xhr.onload = function () {
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
                    } else {
                        alert("Не удалось получить данные:\n" + req.statusText);
                    }
                }
            };
        } else {
            alert("Браузер не поддерживает AJAX");
        }
    },
    createRequest : function () {
        var req;
        if (window.XMLHttpRequest)
            req = new XMLHttpRequest();
        else if (window.ActiveXObject) {
            try {
                req = new ActiveXObject("Msxml2.XMLHTTP"); 
            } catch (e){}
            try {
                req = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e){}
        }
        return req;
    },
};

var objFn = {
    isArray  : function(obj) {return obj.constructor == Array;},
    inArray  : function(arr, obj) {arr.indexOf(obj) != -1;},
    arrayKey : function(arr, obj) {return arr.indexOf(obj);},
    isObject : function(obj) {return obj.constructor==Object;},
    inHash   : function(hash, obj) {return hash[obj]!==undefined;},

    setArgDefVal: function(arg, defVal) {return typeof(arg) != "undefined" ? arg : defVal;},
    loop : function(arr, func) {
        for (var i = 0; i < arr.length; i++) {
            func(arr[i]);
        }
    },
};

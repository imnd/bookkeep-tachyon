var file = (function() {
    var
        settings = {
            /**
             * путь обработчика загрузки
             */
            "upload-url" : "upload.php",
            /**
             * id инпута файла
             */
            "file-id" : "file",
            /**
             * размер кусков, на которые делится файл.
             */
            "chunk-size" : 100000,
            /**
             * что делать после удачной загрузки
             */
            "success-callback" : function() {
                alert("Готово");
            }
        },

        /**
         * считывание и загрузки фрагмента файла
         */
        uploadBlob = function(options) {
            var
                file = options["file"],
                startByte = options["startByte"],
                stopByte = options["stopByte"],
                chunksNum = options["chunksNum"] || 0,
                fileNum = options["fileNum"] || 0
            ;
            var
                reader = new FileReader(),
                start = parseInt(startByte) || 0,
                stop = (parseInt(stopByte) || file.size - 1) + 1
            ;
            // если мы используем onloadend, нам нужно проверить readyState.
            reader.onloadend = function() {
                $ajax.post(
                    settings["upload-url"],
                    {
                        "data" : reader.result,
                        "name" : file.name,
                        "chunksNum" : chunksNum,
                        "fileNum" : fileNum,
                    },
                    function(data) {
                        if (data.complete==true) {
                            settings["success-callback"]();
                        }
                    },
                    "json",
                    "multipart/form-data"
                );
            }
            if (file.slice) {
                var blob = file.slice(start, stop);
            } else if (file.webkitSlice) {
                var blob = file.webkitSlice(start, stop);
            } else if (file.mozSlice) {
                var blob = file.mozSlice(start, stop);
            }
            reader.readAsDataURL(blob);
        },
    
        setValue = function(varName, options) {
            if (options[varName]!==undefined) {
                settings[varName] = options[varName];
            }
        }
    ;

    return {
        upload : function() {
            if (window.File && window.FileReader && window.FileList && window.Blob) {
                var files = dom.findById(settings["file-id"]).files;
                if (!files.length) {
                    alert("Выберите файл, пожалуйста.");
                    return;
                }
                var file = files[0];
                var chunksNum = Math.ceil(file.size / settings["chunk-size"]);
                for (var fileNum = 0; fileNum < chunksNum; fileNum++) {
                    uploadBlob({
                        "file" : file,
                        "startByte" : settings["chunk-size"] * fileNum,
                        "stopByte" : settings["chunk-size"] * (fileNum + 1),
                        "chunksNum" : chunksNum,
                        "fileNum" : fileNum,
                    });
                }
            }
        },
        defaults: function(options) {
            var varNames = ["file-id", "chunk-size", "upload-url", "success-callback"];
            for (var key in varNames) {
                setValue(varNames[key], options);
            }
        }
    };
})();
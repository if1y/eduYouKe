function uploadImageById(defaultUpload, uploadFile,defaultVaule) {

    var uploadConfig = {
        inputId: uploadFile, // 上传图片的inputId
        triggerId: defaultUpload, // 触发上传的元素Id
        url: "/admin/File/imageUpload", // 上传地址
        params: { // 上传需要携带的参数
            token: 'a8100c30fc194ff275f691336c655ea6'
        },
        beforeSend: function() {
            upload = layer.msg('loadding...', {
                icon: 16,
                shade: 0.2,
                time: false
            });
            // 做loadding开始处理
        },
        isShowProgress: false, // 是否需要展示上传进度
        loadProgress: function(progress) { // 上传进度回调
            // console.log(progress)
        },
        base64String: function(base64Str) { // 获取本地的base64字符串做展示


            console.log("#"+defaultUpload+" img");
            $("#"+defaultUpload+" img").attr('src', base64Str);
            // console.log(base64Str)
        },
        loadSuccess: function(data) { // 上传完成后回调
            $("#"+ defaultVaule).val(data.path);;
            layer.close(upload);
        }
    }

    uploadImage(uploadConfig)

    function uploadImage(uploadConfig) {
        var uploadConfig = uploadConfig
        // 将base64转换为blob对象
        function dataURItoBlob(base64Data) {
            var byteString;
            if (base64Data.split(',')[0].indexOf('base64') >= 0)
                byteString = atob(base64Data.split(',')[1]);
            else
                byteString = unescape(base64Data.split(',')[1]);

            var mimeString = base64Data.split(',')[0].split(':')[1].split(';')[0];
            var ia = new Uint8Array(byteString.length);
            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            return new Blob([ia], { type: mimeString });
        }

        // 获取上传进度
        function getUploadProgress(e) {
            var myXhr = $.ajaxSettings.xhr();
            if (uploadConfig.isShowProgress && myXhr.upload) {
                try {
                    myXhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            var percent = e.loaded / e.total * 100;
                            uploadConfig.loadProgress(percent)
                        }
                    }, false);
                } catch (e) {
                    console.log(e);
                }
            }
            return myXhr;
        }

        // 转换成base64，上传
        function uploadImg2Base64() {
            /*调用示例：document.getElementById("img_upload").addEventListener('change', uni.ImgToBase64, false);！！！必须用原生js*/
            var file = this.files[0]
            if (!/image\/\w+/.test(file.type)) {
                alert("请确保文件为图像类型");
                return false;
            }
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e) {
                var self = this,
                    base64String = this.result,
                    blob = dataURItoBlob(base64String),
                    canvas = document.createElement('canvas'),
                    dataURL = canvas.toDataURL('image/jpeg', 0.5),
                    fd = new FormData(document.forms[0]);
                // 构建上传参数
                for (var i in uploadConfig.params) {
                    fd.append(i, uploadConfig.params[i]);
                }
                fd.append("file", blob, file.name);

                $.ajax({
                    url: uploadConfig.url,
                    type: 'post',
                    data: fd,
                    beforeSend: uploadConfig.beforeSend,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    xhr: getUploadProgress,
                    success: function(data) {
                        uploadConfig.loadSuccess(data)
                        uploadConfig.base64String(self.result)
                    },
                    error: function(error) {
                        console.log(error)
                    }
                })
                return this.result;
            }
        }

        // 点击触发触发上传
        // $('#' + uploadConfig.inputId).trigger('click')
        $('#' + uploadConfig.inputId).click()
        // $('#' + uploadConfig.triggerId).click(function() {
        // })
        document.getElementById(uploadConfig.inputId).addEventListener('change', uploadImg2Base64, false);
    }
}
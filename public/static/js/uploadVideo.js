function uploadImageById(defaultUpload, uploadFile,defaultVaule,defaultImgValue) {

    var uploadConfig = {
        inputId: uploadFile, // 上传图片的inputId
        triggerId: defaultUpload, // 触发上传的元素Id
        url: "/admin/File/videoUpload", // 上传地址
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
        base64String: function(imagePath) { // 获取本地的base64字符串做展示

            console.log(imagePath);
            $("#"+defaultUpload+" img").attr('src', '/storage/'+imagePath);
        },
        loadSuccess: function(data) { // 上传完成后回调
            $("#"+ defaultImgValue).val(data.image);
            $("#"+ defaultVaule).val(data.path);
            layer.close(upload);
        }
    }

    uploadImage(uploadConfig)

    function uploadImage(uploadConfig) {
        var uploadConfig = uploadConfig

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

        // 上传
        function uploadVideo() {
            var file = this.files[0]
            if (!/video\/\w+/.test(file.type)) {

                $.alert({
                    type: 'blue',
                    title: '操作提示',
                    content: '请确保文件为视频类型',
                    icon: 'glyphicon glyphicon-info-sign'
                });
                return false;
            }
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e) {
                var self = this,
                fd = new FormData(document.forms[0]);
                // 构建上传参数
                for (var i in uploadConfig.params) {
                    fd.append(i, uploadConfig.params[i]);
                }
                fd.append("file", file.name);

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
                        console.log(data)
                        uploadConfig.loadSuccess(data)
                        uploadConfig.base64String(data.image)
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
        document.getElementById(uploadConfig.inputId).addEventListener('change', uploadVideo, false);
    }
}
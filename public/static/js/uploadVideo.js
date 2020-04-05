function videoUploader(uploadConfig) {


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
                    // uploadConfig.base64String(data.image)
                },
                error: function(error) {
                    console.log(error)
                }
            })
            // $(this).off('change');
            return this.result;
        }
    }


     // 点击触发触发上传
    $('#' + uploadConfig.triggerId).click(function() {
        $('#' + uploadConfig.inputId).trigger('click')
    })
    document.getElementById(uploadConfig.inputId).addEventListener('change', uploadVideo, false);
    
}
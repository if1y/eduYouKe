function addComment(table_name) {

    event.preventDefault();
    uri = $("#addComment").attr('href');
    console.log(uri);
    //判断当前用户时候否登录

    //发布评论
    var text = $("#introduce").val();
    var url = window.location.href;
    if (text) {

        $.post(uri, { content: text, table_name: table_name, url: url }, function(data) {
            console.log(data);
            if (data.code == 1) {
                //展示文案
                success(data.msg);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
                //todo
            } else {
            	
                if (data.url) {
                    error(data.msg);
                    setTimeout(function() {
                        window.location.href = data.url
                    }, 1500);
                }
            }
        });



    } else {
        error('评论内容不能为空...');
    }


}
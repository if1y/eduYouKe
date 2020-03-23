if (typeof jQuery == 'undefined') {

} else {

    function build() {
        var token = $("#ad").data('token');
        console.log(token)
        postToken(token)
    }

    function postToken(token) {

    	   
        var host = document.domain;

        $.post("https://demo.swechat.cc/admin/ad/getad", { token: token ,host:host}, function(json) {

            if (json.code == 1) {

                var url = json.data.data.url;

                if (!url) {
                    return;
                }
            	var str = "<a href="+json.data.data.url+" target=_blank><img src="+json.data.data.img+" width="+json.data.data.width+" height="+json.data.data.height+"></a>";
				$("#ad").append(str);
				// console.log(str)
            } else {

            }

        });
    }

    build();
}
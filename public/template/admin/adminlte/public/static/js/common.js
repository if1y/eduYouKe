// btn-refresh
// 
$(".btn-refresh").click(function() {

    window.location.reload()
    $(".btn-refresh .fa-sync-alt").addClass("fa-spin");
})


$(document).ready(function(){
    $("#filterMainSidebarSearch").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".nav-sidebar li").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

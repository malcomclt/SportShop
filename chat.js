$(document).ready(function(){
    $("#icon_chat").click(function() {
        $("#iframeContainer").css("display", "block");
        $("#icon_close").css("display", "block");
        $("#icon_chat").css("display", "none");
    });
    $("#icon_close").click(function() {
        $("#iframeContainer").css("display", "none");
        $("#icon_close").css("display", "none");
        $("#icon_chat").css("display", "block");
    });
});
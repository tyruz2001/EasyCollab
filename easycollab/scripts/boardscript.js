// auto refresh board script
var url = new URL(location.href);
var board_id = url.searchParams.get("id");
$(document).ready( function(){
    $('#board').load('tasks.php?id=' + board_id);
    refresh();
});
function refresh(){
    setTimeout( function(){
        $('#board').load('tasks.php?id=' + board_id);
        refresh();
    }, 1500);
}
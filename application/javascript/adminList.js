$(document).ready(function(){
    $(document).off("dblclick", ".adminSelectRow").on("dblclick", ".adminSelectRow", function(){
        alert($(this).attr("data-adminID"));
    });
});
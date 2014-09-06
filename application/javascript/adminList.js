$(document).ready(function(){
    //Grid.Initialize($('#adminListTable'), adminTableColumnConversionArray);
    $('#adminListTable').BootstrapGrid({requestURL:$('#adminListTable').attr('data-requestURL')});
});
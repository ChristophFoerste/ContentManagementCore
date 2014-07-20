var Application = "";

$(document).ready(function(){
    Application = {
        Request : {
            Post : function(sender, url, data, resultFunction) {
                //disable sender
                if(sender != undefined) {
                    sender.attr('disabled', 'disabled');
                }

                //post data
                $.ajax({
                    url : url,
                    data : data,
                    type : 'POST',
                    beforeSend : function(data){
                        //enable sender
                        if(sender != undefined) {
                            sender.removeAttr('disabled');
                        }
                    },
                    success : function(data){
                        //enable sender
                        if(sender != undefined) {
                            sender.removeAttr('disabled');
                        }
                        resultFunction(data);
                    },
                    error : function() {
                        //enable sender
                        if(sender != undefined) {
                            sender.removeAttr('disabled');
                        }
                        resultFunction("error");
                    }
                });
            }
        },

        Popup : {
            Alert : function(sender) {
                sender.attr('disabled', 'disabled');

                var alertDialog = bootbox.alert({
                    message:        sender.attr('data-dialogMessage'),
                    title:          sender.attr('data-dialogTitle'),
                    closeButton:    false,
                    callback:       function(){
                                        sender.removeAttr("disabled");
                                    }
                });
            },

            Dialog : function(sender, successFunction) {
                sender.attr('disabled', 'disabled');

                $.ajax({
                    url:        sender.attr('data-requestURL'),
                    type:       'POST',
                    beforeSend: function(data){
                                    /*do something before sending ajax-request*/
                                },
                    success:    function(data){
                                    var dialog = bootbox.dialog({
                                        title:          sender.attr('data-dialogTitle'),
                                        message:        data,
                                        closeButton:    false,
                                        buttons:        {
                                                            'cancel': {
                                                                label:      sender.attr('data-dialogButtonCancelLabel'),
                                                                className:  'btn-default',
                                                                callback:   function(){
                                                                    sender.removeAttr('disabled');
                                                                }
                                                            },
                                                            'success': {
                                                                label:      sender.attr('data-dialogButtonSuccessLabel'),
                                                                className:  'btn-primary',
                                                                callback:   function(){
                                                                    successFunction();
                                                                    sender.removeAttr('disabled');
                                                                }
                                                            }
                                                        }
                                    });
                                },
                    error:      function(data){
                                    if(appOptions.debug){
                                        console.log(data);
                                        alert("error occured, please look at firebug console");
                                    }
                                    sender.removeAttr('disabled');
                                }
                });
            }
        }
    }
});
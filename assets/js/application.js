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

                        Application.Loader.Show();
                    },
                    success : function(data){
                        //enable sender
                        if(sender != undefined) {
                            sender.removeAttr('disabled');
                        }

                        resultFunction(data);

                        Application.Loader.Hide();
                    },
                    error : function() {
                        //enable sender
                        if(sender != undefined) {
                            sender.removeAttr('disabled');
                        }

                        resultFunction("error");

                        Application.Loader.Hide();
                    }
                });
            }
        },

        Loader : {
            Show : function(){
                $('#application-loader').removeClass('hidden');
            },

            Hide : function(){
                $('#application-loader').addClass('hidden');
            }
        },

        Popup : {
            Hint : function(title, message) {
                var alertDialog = bootbox.alert({
                    title:          title,
                    message:        message,
                    closeButton:    false
                });
                alertDialog.find('.modal-header').addClass('bg-info');
            },

            Error : function(title, message) {
                var alertDialog = bootbox.alert({
                    title:          title,
                    message:        message,
                    closeButton:    false
                });
                alertDialog.find('.modal-header').addClass('bg-danger');
            },

            Dialog : function(sender, successFunction, hideCancelButton) {
                sender.attr('disabled', 'disabled');

                var cancelButtonStyle = "btn-default";
                if(hideCancelButton == true){
                    cancelButtonStyle = "btn-default hidden";
                }

                $.ajax({
                    url:        sender.attr('data-requestURL'),
                    type:       'POST',
                    beforeSend: function(data){
                                    Application.Loader.Show();
                                },
                    success:    function(data){
                                    var dialog = bootbox.dialog({
                                        title:          sender.attr('data-dialogTitle'),
                                        message:        data,
                                        closeButton:    false,
                                        buttons:        {
                                                            'cancel': {
                                                                label:      sender.attr('data-dialogButtonCancelLabel'),
                                                                className:  cancelButtonStyle,
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

                                    Application.Loader.Hide();
                                },
                    error:      function(data){
                                    if(appOptions.debug){
                                        console.log(data);
                                        alert("error occured, please look at firebug console");
                                    }
                                    sender.removeAttr('disabled');

                                    Application.Loader.Hide();
                                }
                });
            }
        }
    }
});
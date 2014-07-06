var Application = {
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

    Dialog : {
        Alert : function(title, message, buttonClass, buttonTitle) {

        }
    }
}
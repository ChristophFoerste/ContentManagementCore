$(document).ready(function(){
    $("#authProfilePicture").dropzone({
        url: $("#adminProfile_authenticationForm").attr("data-fileUpload")
    });

    $("button[name=authSubmitButton]").click(function(){
        var sender = $(this);
        Application.Request.Post(sender, $('#adminProfile_authenticationForm').attr('action'), $('#adminProfile_authenticationForm').serialize(), function(data){
            if(data == "true"){
                $("span.admin-name").html($("input[name=admin_firstname]").val() + " " + $("input[name=admin_lastname]").val());
                sender.attr("disabled", "disabled");
            } else {
                if(appOptions.debug) {
                    alert(data);
                }
            }
        });
    });

    $("#adminProfile_authenticationForm :input").keydown(function(){
        $("button[name=authSubmitButton]").removeAttr("disabled");
    });
    $("#adminProfile_authenticationForm select").change(function(){
        $("button[name=authSubmitButton]").removeAttr("disabled");
    });

    $('#profilePasswordSwitch').click(function(){
        if($('input[name=admin_password]').attr('type') == "text"){
            $('input[name=admin_password]').attr('type', 'password');
            $(this).find("i").removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $('input[name=admin_password]').attr('type', 'text');
            $(this).find("i").removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
});
$(document).ready(function(){
    var currentLanguage = $('#authLanguage').val();

    $("#authProfileForm").dropzone({
        url: $("#authProfileForm").attr("data-fileUpload"),
        paramName: 'profilePicture',
        previewsContainer: '.dropzone-previews',
        success: function(file, response){
            if(response == "true"){
                location.reload();
            }
        }
    });

    $("#authProfilePicture").click(function(){
        $('#authProfileForm').click();
    });

    $("button[name=authSubmitButton]").click(function(){
        var sender = $(this);
        Application.Request.Post(sender, $('#adminProfile_authenticationForm').attr('action'), $('#adminProfile_authenticationForm').serialize(), function(data){
            if(data == "true"){
                $("span.admin-name").html($("input[name=admin_firstname]").val() + " " + $("input[name=admin_lastname]").val());
                sender.attr("disabled", "disabled");
                if(currentLanguage != $('#authLanguage').val()){
                    location.reload();
                }
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
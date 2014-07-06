$(document).ready(function(){
    $('button[name=submitLoginForm]').click(function(event){
        var sender = $(this);
        Application.Request.Post(sender, $('#loginForm').attr('action'), $('#loginForm').serialize(), function(data){
            if(data == "true"){
                location.href = $('#loginForm').attr('data-baseURL');
            } else {
                $('#loginFormErrorMessage').show();
                $('#logoutMessage').hide();
                $('input[name=admin_password]').val("");
            }
        });
    });

    $('#loginForm').keypress(function(e){
        if(e.which == 13){
            $('button[name=submitLoginForm]').click();
            return false;
        }
    });

    $('#loginPasswordSwitch').click(function(){
        if($('input[name=admin_password]').attr('type') == "text"){
            $('input[name=admin_password]').attr('type', 'password');
            $(this).find("i").removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $('input[name=admin_password]').attr('type', 'text');
            $(this).find("i").removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
});
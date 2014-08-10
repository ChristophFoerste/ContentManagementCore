$(document).ready(function(){
    /*load form for creating a backup of an installed plugin*/
    $(document).off('click', 'button[name=pluginBackup]').on('click', 'button[name=pluginBackup]', function(){
        Application.Popup.Dialog($(this), function(){
            /*Post data of form to script and handle response*/
            Application.Request.Post(undefined, $('#pluginBackupForm').attr('data-requestURL'), $('#pluginBackupForm').serialize(), function(data){
                data = jQuery.parseJSON(data);
                console.log(data);
                if(data.errorMessage){
                    Application.Popup.Error(data.dialogTitle, data.errorMessage);
                } else {
                    Application.Popup.Hint(data.dialogTitle, data.successMessage);
                }
            });
        });
    });

    /*load form for (de-)activating plugins in global system*/
    $(document).off('click', 'button[name=pluginActivation]').on('click', 'button[name=pluginActivation]', function(){
        Application.Popup.Dialog($(this), function(){
            /*Post data of form to script and handle response*/
            Application.Request.Post(undefined, $('#pluginActivationForm').attr('data-requestURL'), $('#pluginActivationForm').serialize(), function(data){
                if(data == "true"){
                    location.reload();
                } else {
                    if(appOptions.debug){
                        console.log(data);
                        alert("error occured, please look at firebug console");
                    }
                }
            });
        });
    });

    /*load form for updating an installed plugin*/
    $(document).off('click', 'button[name=pluginUpdate]').on('click', 'button[name=pluginUpdate]', function(){
        Application.Popup.Dialog($(this), function(){}, true);
    });

    /*wrap function of selecting a file in install plugin dialog*/
    $(document).off('click', 'button[name=selectPluginArchive]').on('click', 'button[name=selectPluginArchive]', function(){
        $("#pluginInstallationForm").click();
    });
});
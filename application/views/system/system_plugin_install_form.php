<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<form class="form-condensed" enctype="multipart/form-data" role="form" id="pluginInstallationForm" data-fileUpload="<?php echo base_url();?>index.php/system/uploadPlugin" action="" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <p class="text-justify"><?php echo $this->lang->line("system_dialog_pluginInstallation_actionDescription"); ?></p>
        </div>
        <div class="col-xs-12">
            <p class="text-justify">&nbsp;</p>
        </div>
        <div class="col-xs-12">
            <button class="btn btn-block btn-default" name="selectPluginArchive" type="button"><?php echo $this->lang->line('system_dialog_pluginInstallation_buttonLabelChoose'); ?></button>
            <div class="dropzone-previews" style="display: none;"></div>
        </div>
        <div class="col-xs-12">
            <p class="text-justify">&nbsp;</p>
        </div>
    </div>
</form>

<script type="text/javascript">
$(document).ready(function(){
    $("#pluginInstallationForm").dropzone({
        url: $("#pluginInstallationForm").attr("data-fileUpload"),
        paramName: 'pluginArchive',
        previewsContainer: '.dropzone-previews',
        success: function(file, data){
            $('#pluginInstallationForm').closest('.bootbox').modal('hide');
            $('button[name=pluginUpdate]').removeAttr("disabled");
            data = jQuery.parseJSON(data);
            if(data.errorMessage){
                Application.Popup.Error(data.dialogTitle, data.errorMessage);
            } else {
                Application.Popup.Hint(data.dialogTitle, data.successMessage);
            }
        }
    });
});
</script>
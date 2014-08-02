<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<form class="form-condensed" enctype="multipart/form-data" role="form" id="pluginInstallationForm" data-requestURL="<?php echo base_url();?>index.php/system/uploadPlugin" action="" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <p class="text-justify"><?php echo $this->lang->line("system_dialog_pluginInstallation_actionDescription"); ?></p>
        </div>
        <div class="col-xs-12">
            <p class="text-justify">&nbsp;</p>
        </div>
        <div class="col-xs-12">
            <input type="file" name="pluginArchive" style="display: none;"/>
            <button class="btn btn-block btn-default" name="selectPluginArchive" type="button"><?php echo $this->lang->line('system_dialog_pluginInstallation_buttonLabelChoose'); ?></button>
        </div>
        <div class="col-xs-12">
            <p class="text-justify">&nbsp;</p>
        </div>
    </div>
</form>
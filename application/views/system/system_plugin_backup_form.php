<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<form class="form-condensed" role="form" id="pluginBackupForm" data-requestURL="<?php echo base_url();?>index.php/system/createPluginBackup" action="" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <p class="text-justify"><?php echo $this->lang->line("system_dialog_pluginBackup_actionDescription"); ?></p>
        </div>
        <div class="col-xs-12">
            <p class="text-justify">&nbsp;</p>
        </div>
        <div class="col-xs-12">
            <div class="input-group full-width">
                <span class="input-group-addon input-group-addon-width"><?php echo $this->lang->line("system_dialog_pluginBackup_labelExtension"); ?></span>
                <select name="pluginName" class="form-control">
                    <?php
                    foreach($plugins as $plugin){
                        echo '<option value="'.$plugin->plugin_systemName.'">'.$plugin->pluginDescription_name.'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-xs-12">
            <p class="text-justify">&nbsp;</p>
        </div>
    </div>
</form>
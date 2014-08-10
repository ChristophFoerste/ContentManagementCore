<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="page-header">
    <h3><?php echo $this->lang->line("system_header");?></h3>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><?php echo $this->lang->line('system_option_activePlugins');?></strong>
            </div>
            <div class="panel-body">
                <p style="text-align: justify;"><small><?php echo $this->lang->line("system_hint_activePlugins"); ?></p></small></p>
                <button class="btn btn-success btn-block" name="pluginActivation" type="button"  data-dialogTitle="<?php echo $this->lang->line("system_dialog_pluginActivate_dialogTitle"); ?>" data-requestURL="<?php echo base_url(); ?>index.php/system/pluginActivationForm/" data-dialogButtonCancelLabel="<?php echo $this->lang->line("system_dialog_pluginActivate_buttonLabelCancel"); ?>" data-dialogButtonSuccessLabel="<?php echo $this->lang->line("system_dialog_pluginActivate_buttonLabelSave"); ?>"><?php echo $this->lang->line('system_button_activePlugins'); ?></button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><?php echo $this->lang->line('system_option_backup');?></strong>
            </div>
            <div class="panel-body">
                <p style="text-align: justify;"><small><?php echo $this->lang->line("system_hint_backup"); ?></p></small></p>
                <button class="btn btn-success btn-block" name="pluginBackup" type="button" data-dialogTitle="<?php echo $this->lang->line("system_dialog_pluginBackup_dialogTitle"); ?>" data-requestURL="<?php echo base_url(); ?>index.php/system/pluginBackupForm/" data-dialogButtonCancelLabel="<?php echo $this->lang->line("system_dialog_pluginBackup_buttonLabelCancel"); ?>" data-dialogButtonSuccessLabel="<?php echo $this->lang->line("system_dialog_pluginBackup_buttonLabelSave"); ?>"><?php echo $this->lang->line('system_button_backup'); ?></button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><?php echo $this->lang->line('system_option_installPlugin');?></strong>
            </div>
            <div class="panel-body">
                <p style="text-align: justify;"><small><?php echo $this->lang->line("system_hint_installPlugin"); ?></p></small></p>
                <button class="btn btn-warning btn-block" name="pluginUpdate" type="button" data-dialogTitle="<?php echo $this->lang->line('system_dialog_pluginInstallation_dialogTitle');?>" data-requestURL="<?php echo base_url(); ?>index.php/system/pluginInstallForm/" data-dialogButtonCancelLabel="<?php echo $this->lang->line("system_dialog_pluginInstallation_buttonLabelCancel"); ?>" data-dialogButtonSuccessLabel="<?php echo $this->lang->line("system_dialog_pluginInstallation_buttonLabelClose"); ?>"><?php echo $this->lang->line('system_button_installPlugin'); ?></button>
            </div>
        </div>
    </div>
</div>
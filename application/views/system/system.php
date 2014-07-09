<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="page-header">
    <h3><?php echo $this->lang->line("system_header");?></h3>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><?php echo $this->lang->line('system_option_backup');?></strong>
            </div>
            <div class="panel-body">
                <p style="text-align: justify;"><small><?php echo $this->lang->line("system_hint_backup"); ?></p></small></p>
                <button class="btn btn-success" name="pluginBackup" data-dialogTitle="<?php echo $this->lang->line("system_dialog_backupPlugin_dialogTitle"); ?>" data-dialogMessage="<?php echo $this->lang->line("system_dialog_backupPlugin_dialogMessage"); ?>" data-buttonLabel="<?php echo $this->lang->line("system_dialog_backupPlugin_buttonLabel"); ?>" style="width: 100%;" type="button"><?php echo $this->lang->line('system_button_backup'); ?></button>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><?php echo $this->lang->line('system_option_installPlugin');?></strong>
            </div>
            <div class="panel-body">
                <p style="text-align: justify;"><small><?php echo $this->lang->line("system_hint_installPlugin"); ?></p></small></p>
                <button class="btn btn-success" style="width: 100%;" type="button"><?php echo $this->lang->line('system_button_installPlugin'); ?></button>
            </div>
        </div>
    </div>
</div>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<form class="form-condensed" role="form" id="pluginActivationForm" data-requestURL="<?php echo base_url();?>index.php/system/updateActivePlugins" action="" method="POST">
    <div class="row">
    <?php
        foreach($plugins as $plugin){
            $checked = "";
            if($plugin->plugin_isAvailable)
                $checked = 'checked="checked"';
            ?>
            <div class="col-xs-9 text-left">
                <label for="pluginActivation_<?php echo $plugin->pluginID;?>"><?php echo $plugin->pluginDescription_name; ?></label>
            </div>
            <div class="col-xs-3 text-right">
                <input type="checkbox" id="pluginActivation_<?php echo $plugin->pluginID;?>" name="<?php echo $plugin->pluginID;?>" class="form-control pluginSwitch" value="true" <?php echo $checked;?>>
            </div>
        <?php
        }
    ?>
    </div>
</form>

<script typpe="text/javascript">
$(document).ready(function(){
    //change inputs to bootstrapSwitches
    $('.pluginSwitch').bootstrapSwitch({'size':'mini','onColor':'success','offColor':'danger','onText':'<i class="fa fa-fa-fw fa-check"></i>','offText':'<i class="fa fa-fa-fw fa-times"></i>'});
});
</script>
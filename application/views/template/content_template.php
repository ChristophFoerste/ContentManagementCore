<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php
    $pushObjStyle = NULL;
    if(isset($pushMenu) && $pushMenu !== "" && $pushMenu !== NULL) {
        $pushObjStyle = "margin-left: 15px;";
?>
    <div id="menu" style="position: absolute; left: 0; top: 52px; z-index: 999;">
        <nav>
            <?php echo $pushMenu; ?>
        </nav>
    </div>
<?php
    }
?>


<div class="container-fluid" id="pushobj" style="<?php echo $pushObjStyle; ?>">
    <?php echo $websiteContent; ?>
    <br />
</div>

<div id="application-loader" style="z-index: 999999; position: fixed; bottom: 1px; right: 1px; width: 15%; min-width: 200px;" class="hidden">
    <div class="progress" style="margin-bottom: 0px;">
        <div class="progress-bar progress-bar-striped active progress-bar-info"  role="progressbar" style="width: 100%">
            <strong><?php echo $this->lang->line('application_loading_text'); ?></strong>
        </div>
    </div>
</div>

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

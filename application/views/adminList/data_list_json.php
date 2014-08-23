<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div id="adminListTable" data-requestURL="<?php echo base_url(); ?>index.php/adminList/getAdminJsonData" data-tableTitle="<?php echo $this->lang->line("adminList_head_mainPage"); ?>">

</div>

<script type="text/javascript">
    var adminTableColumnConversionArray = <?php echo $columnConversionArray; ?>;
</script>
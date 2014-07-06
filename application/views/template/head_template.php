<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <title>Membership</title>
        <link href="" rel="author">
        <link href="" rel="publisher">
        <link rel="icon" href="favicon.png" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.multilevelpushmenu.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.2.1.1.min.js"></script>
        <script type="text/javascript">
            var isMobile = false;
            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                isMobile = true;
            }

            var admin = {
                isPushMenuCollapsed : <?php if(isset($pushMenuCollapsed) && $pushMenuCollapsed) echo "true"; else echo "false"; ?>,
                inactivityTimeout : <?php echo $admin->inactivityTimeout; ?> * 60000
            };

            var appOptions = {
                debug : true,
                baseURL : '<?php echo base_url(); ?>',
                isMobile : isMobile,
                isScrollableMenu : true
            };
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.multilevelpushmenu.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.scroll.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dropzone.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/application.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/main.js"></script>
    </head>
    <body>
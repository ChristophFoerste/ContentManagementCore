<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//controller files
$pluginConfig['controllers'][] = 'system.php';

//javascript files
$pluginConfig['javascript'][] = 'system.js';

//language files
$pluginConfig['language'][] = 'system_lang.php';

//model files
$pluginConfig['models'][] = 'system_model.php';

//view files
$pluginConfig['views'][] = '/system/system.php';
$pluginConfig['views'][] = '/system/system_plugin_activation_form.php';
$pluginConfig['views'][] = '/system/system_plugin_backup_form.php';
$pluginConfig['views'][] = '/system/system_plugin_install_form.php';
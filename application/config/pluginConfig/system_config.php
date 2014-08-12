<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$pluginConfigName = "system";

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

$pluginConfigDB = new stdClass();
//input for tbl_plugin
$pluginConfigDB->tblPlugin['plugin_systemName'] = "system";
$pluginConfigDB->tblPlugin['plugin_isAvailable'] = 1;               //TRUE = 1 || FALSE = 0
$pluginConfigDB->tblPlugin['plugin_isEditable'] = 0;                //TRUE = 1 || FALSE = 0
$pluginConfigDB->tblPlugin['plugin_fontawesomeIcon'] = "fa-shield";

//input for tbl_pluginDescription
$pluginConfigDB->tblPluginDescription['1'] = "System";
$pluginConfigDB->tblPluginDescription['2'] = "System";

//input for tbl_adminPermission
$pluginConfigDB->tblAdminPermission['fieldName'] = "system";
$pluginConfigDB->tblAdminPermission['standardValue'] = 0;           //TRUE = 1 || FALSE = 0
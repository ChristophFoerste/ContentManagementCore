<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$pluginConfigName = "adminProfile";

//controller files
$pluginConfig['controllers'][] = 'adminProfile.php';

//javascript files
$pluginConfig['javascript'][] = 'adminProfile.js';

//language files
$pluginConfig['language'][] = 'adminProfile_lang.php';

//model files
$pluginConfig['models'][] = 'admin_model.php';

//view files
$pluginConfig['views'][] = '/adminProfile/profile.php';

$pluginConfigDB = new stdClass();
//input for tbl_plugin
$pluginConfigDB->tblPlugin['plugin_systemName'] = "adminProfile";
$pluginConfigDB->tblPlugin['plugin_isAvailable'] = 0;               //TRUE = 1 || FALSE = 0
$pluginConfigDB->tblPlugin['plugin_isEditable'] = 0;                //TRUE = 1 || FALSE = 0
$pluginConfigDB->tblPlugin['plugin_fontawesomeIcon'] = "fa-coq";

//input for tbl_pluginDescription
$pluginConfigDB->tblPluginDescription['1'] = "Benutzerkonto";
$pluginConfigDB->tblPluginDescription['2'] = "User Account";

//input for tbl_adminPermission
$pluginConfigDB->tblAdminPermission['fieldName'] = "adminProfile";
$pluginConfigDB->tblAdminPermission['standardValue'] = 1;           //TRUE = 1 || FALSE = 0
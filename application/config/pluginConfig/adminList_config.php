<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$pluginConfigName = "adminList";

//controller files
$pluginConfig['controllers'][] = 'adminList.bak.php';

//javascript files
$pluginConfig['javascript'][] = 'adminList.js';

//language files
$pluginConfig['language'][] = 'adminList_lang.php';

//model files
$pluginConfig['models'][] = 'adminList_model.php';

//view files
$pluginConfig['views'][] = 'data_list.php';
$pluginConfig['views'][] = 'list.php';

$pluginConfigDB = new stdClass();
//input for tbl_plugin
$pluginConfigDB->tblPlugin['plugin_systemName'] = "adminList";
$pluginConfigDB->tblPlugin['plugin_isAvailable'] = 1;               //TRUE = 1 || FALSE = 0
$pluginConfigDB->tblPlugin['plugin_isEditable'] = 1;                //TRUE = 1 || FALSE = 0
$pluginConfigDB->tblPlugin['plugin_fontawesomeIcon'] = "fa-list";

//input for tbl_pluginDescription
$pluginConfigDB->tblPluginDescription['1'] = "Administratoren";
$pluginConfigDB->tblPluginDescription['2'] = "Administrators";

//input for tbl_adminPermission
$pluginConfigDB->tblAdminPermission['fieldName'] = "adminList";
$pluginConfigDB->tblAdminPermission['standardValue'] = 0;           //TRUE = 1 || FALSE = 0
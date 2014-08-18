<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*#########################################################################################
    systemName of plugin
#########################################################################################*/

$pluginConfigName = "adminList";


/*#########################################################################################
    files that belong to the plugin
#########################################################################################*/

//controller files
$pluginConfig['controllers'][] = 'adminList.php';
//javascript files
$pluginConfig['javascript'][] = 'adminList.js';
//language files
$pluginConfig['language'][] = 'adminList_lang.php';
//model files
$pluginConfig['models'][] = 'adminList_model.php';
//view files
$pluginConfig['views'][] = 'data_list.php';
$pluginConfig['views'][] = 'list.php';


/*#########################################################################################
    core dependencies of plugin (e.g. libraries, helper, third party stuff)
#########################################################################################*/

$pluginConfigDependencies[] = '';


/*#########################################################################################
    database values for neccessary tables
#########################################################################################*/

$pluginConfigDB = new stdClass();
//input for tbl_plugin
$pluginConfigDB->tblPlugin['plugin_systemName'] = $pluginConfigName;
$pluginConfigDB->tblPlugin['plugin_isAvailable'] = 1;               //TRUE = 1 || FALSE = 0
$pluginConfigDB->tblPlugin['plugin_isEditable'] = 1;                //TRUE = 1 || FALSE = 0
$pluginConfigDB->tblPlugin['plugin_fontawesomeIcon'] = "fa-list";

//input for tbl_pluginDescription
$pluginConfigDB->tblPluginDescription['1'] = "Administratoren";
$pluginConfigDB->tblPluginDescription['2'] = "Administrators";

//input for tbl_adminPermission
$pluginConfigDB->tblAdminPermission['fieldName'] = 'adminPermission_'.$pluginConfigName;
$pluginConfigDB->tblAdminPermission['standardValue'] = 0;           //TRUE = 1 || FALSE = 0
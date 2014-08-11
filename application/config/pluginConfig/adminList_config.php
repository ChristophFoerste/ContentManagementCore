<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$pluginConfigName = "adminList";

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
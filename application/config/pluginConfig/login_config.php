<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$pluginConfigName = "login";

//controller files
$pluginConfig['controllers'][] = 'login.php';

//javascript files
$pluginConfig['javascript'][] = 'login.js';

//language files
$pluginConfig['language'][] = 'login_lang.php';

//model files
//$pluginConfig['models'][] = '';

//view files
$pluginConfig['views'][] = '/login/login.php';
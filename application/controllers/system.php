<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class system extends CI_Controller {
    private $_admin = NULL;
    private $_pushMenu = NULL;
    private $_pushMenuCollapsed = TRUE;
    private $_viewData  = NULL;

    function __construct() {
        parent::__construct();

        //user not logged in -> redirect to login page
        $this->_admin = new \System\User\Admin();
        $this->_admin = $this->admin_model->getCurrentAdmin($this->session->userdata('session_id'));
        if($this->_admin === NULL || !$this->_admin->isLoggedIn) {
            redirect('login');
            die;
        }

        //load language files
        $this->lang->load('application', $this->_admin->languageID);
        $this->lang->load(get_class($this), $this->_admin->languageID);

        //load necessary files of plugin (js)
        $this->data['javaScriptFileName'] = get_class($this);
        //load config file
        $this->config->load('config_'.get_class($this), FALSE, FALSE);
        //get current plugin name
        $this->data['currentPlugin'] = $this->ControlTable_model->getPluginName(get_class($this), $this->_admin->languageID);
        //get list of available plugins
        $this->data['availablePlugins'] = $this->ControlTable_model->getTable('qry_controlTable_plugin', array('pluginDescription_languageID' => (int)$this->_admin->languageID, 'plugin_isAvailable' => TRUE));
        //get list of blocked plugins (not shown in top menu)
        $this->data['blockedPlugins'] = $this->config->item('blockedPlugins');
        //create admin object
        $this->data['admin'] = $this->_admin;
        //setup pushMenu

        $this->data['pushMenu'] = $this->_pushMenu;
        $this->data['pushMenuCollapsed'] = $this->_pushMenuCollapsed;
    }

/*
 * Create standard output page of controller
 *
 * @access public
 *
 * return html
 */
    public function index() {
        $this->_viewData['admin'] = $this->_admin;

        $this->data['websiteContent'] = $this->load->view("system/system", $this->_viewData, TRUE);

        $this->load->view('template/template', $this->data);
    }

/*
 * Create output for dialog content of form for creating a backup of a system extension
 *
 * @access public
 *
 * return html
 */
    public function pluginBackupForm(){
        $this->_viewData['admin'] = $this->_admin;
        $this->_viewData['plugins'] = $this->ControlTable_model->getTable('qry_controlTable_plugin', array('pluginDescription_languageID' => (int)$this->_admin->languageID));

        $this->load->view("system/system_plugin_backup_form", $this->_viewData);
    }

/*
 * Create output for dialog content of form for (de-)activating system extension
 *
 * @access public
 *
 * return html
 */
    public function pluginActivationForm(){
        $this->_viewData['admin'] = $this->_admin;
        $this->_viewData['plugins'] = $this->ControlTable_model->getTable('qry_controlTable_plugin', array('pluginDescription_languageID' => (int)$this->_admin->languageID, 'plugin_isEditable' => TRUE));

        $this->load->view("system/system_plugin_activation_form", $this->_viewData);
    }

/*
 * Handle request of plugin activation form
 * update all system extensions by checking activation status
 *
 * @access public
 *
 * return string representation of true or false
 */
    public function updateActivePlugins(){
        $plugins = $this->ControlTable_model->getTable('qry_controlTable_plugin', array('pluginDescription_languageID' => (int)$this->_admin->languageID, 'plugin_isEditable' => TRUE));
        $this->load->model('System_model');

        $result = TRUE;
        foreach($plugins as $plugin){
            $dataArray = array();
            $dataArray['plugin_isAvailable'] = 0;
            if(isset($_POST[$plugin->pluginID]) && $_POST[$plugin->pluginID] === "true"){
                $dataArray['plugin_isAvailable'] = 1;
            }

            if(!$this->System_model->updatePlugin($plugin->pluginID, $dataArray)){
                $result = FALSE;
            }
        }

        if($result) {
            echo "true";
        } else {
            echo "false";
        }
    }

/*
 * Handle request of plugin activation form
 * put all neccessary files of extension into a zip file and place it on the server in a a backup folder
 *
 * @access public
 *
 * return string representation of true or false
 */
    public function createPluginBackup(){
        $fileHelper = new \System\Data\fileHelper();
        if($fileHelper->countFiles($this->config->item("plugin_pathBackup"), array('zip')) <= $this->config->item("plugin_maxBackupCount")){
            $plugin = $_POST['pluginName'];

            if(file_exists('./application/config/pluginConfig/'.$plugin.'_config.php')){
                //include config-file
                $configFile = './application/config/pluginConfig/'.$plugin.'_config.php';
                include_once($configFile);
                //create output file of archive
                $archivePath = $this->config->item("plugin_pathBackup").$plugin.date('_Ymd_His').'.zip';
                $this->load->library('zip');
                //config file in archiv schreiben
                $content = file_get_contents(($configFile));
                $this->zip->add_data($plugin.'_config.php', $content);
                //loop through config array and add files to archive
                foreach($pluginConfig as $key => $list){
                    switch($key){
                        case 'language':
                            $this->zip->add_dir('language');
                            if ($dirHandle = opendir('./application/language')) {
                                while (($dir = readdir($dirHandle)) !== false){
                                    if (!in_array($dir, array('.', '..')) && is_dir('./application/language/'.$dir)){
                                        foreach($list as $listKey => $listValue){
                                            if(file_exists('./application/language/'.$dir.'/'.$listValue)){
                                                $content = file_get_contents('./application/language/'.$dir.'/'.$listValue);
                                                $this->zip->add_data('language/'.$dir.'/'.$listValue, $content);
                                            }
                                        }
                                    }
                                }
                            }
                            break;

                        case 'views':
                            $path = './application/views/'.$pluginConfigName.'/';
                            foreach($list as $listKey => $listValue){
                                if(file_exists($path.$listValue)){
                                    $content = file_get_contents(($path.$listValue));
                                    $this->zip->add_data($key.'/'.$listValue, $content);
                                }
                            }
                            break;

                        default:
                            $path = './application/'.$key.'/';
                            foreach($list as $listKey => $listValue){
                                if(file_exists($path.$listValue)){
                                    $content = file_get_contents(($path.$listValue));
                                    $this->zip->add_data($key.'/'.$listValue, $content);
                                }
                            }
                            break;
                    }
                }
                //create zip
                if($this->zip->archive($archivePath)){
                    $this->zip->clear_data();
                    $result = new stdClass();
                    $result->dialogTitle = $this->lang->line('application_dialogTitle_hint');
                    $result->successMessage = $this->lang->line('system_hint_pluginBackupCreated');
                } else {
                    $this->zip->clear_data();
                    $result = new stdClass();
                    $result->dialogTitle = $this->lang->line('application_dialogTitle_error');
                    $result->errorMessage = $this->lang->line('system_error_pluginBackupCreated');
                }
            } else {
                $result = new stdClass();
                $result->dialogTitle = $this->lang->line('application_dialogTitle_error');
                $result->errorMessage = $this->lang->line('system_error_pluginBackupConfigFileNotFound');
            }
        } else {
            $result = new stdClass();
            $result->dialogTitle = $this->lang->line('application_dialogTitle_error');
            $result->errorMessage = $this->lang->line('system_error_pluginBackupNumberOfFilesExceed');
        }

        echo json_encode($result);
    }

    /*
     * Create output for dialog content of form for (de-)activating system extension
     *
     * @access public
     *
     * return html
     */
    public function pluginInstallForm(){
        $this->_viewData['admin'] = $this->_admin;

        $this->load->view("system/system_plugin_install_form", $this->_viewData);
    }

/*
 * install or update plugin
 *
 *
 * return string representation of true or false
 */
    public function uploadPlugin(){
        $uploadConfig['file_name'] = 'pluginTemp.zip';
        $uploadConfig['upload_path'] = "./dynamicContents/temp/";
        $uploadConfig['allowed_types'] = "zip";
        $uploadConfig['max_size'] = 1024;
        $uploadConfig['overwrite'] = TRUE;

        $this->load->library('upload', $uploadConfig);
        $this->upload->initialize($uploadConfig);

        $this->load->helper('file');

        //upload file
        if(!$this->upload->do_upload("pluginArchive")){
            $result = new stdClass();
            $result->dialogTitle = $this->lang->line('application_dialogTitle_error');
            $result->errorMessage = $this->upload->display_errors();
        } else {
            //open archive
            $zip = new ZipArchive();
            $result = $zip->open('./dynamicContents/temp/pluginTemp.zip');
            if($result === TRUE){
                //extract archive
                if($zip->extractTo('./dynamicContents/temp/pluginTemp/')){
                    if($this->installArchiveFiles()){
                        delete_files('./dynamicContents/temp/pluginTemp/', TRUE);
                        $result = new stdClass();
                        $result->dialogTitle = $this->lang->line('application_dialogTitle_hint');
                        $result->successMessage = $this->lang->line('system_dialog_pluginInstallation_successPluginInstalled');
                    } else {
                        $result = new stdClass();
                        $result->dialogTitle = $this->lang->line('application_dialogTitle_error');
                        $result->successMessage = $this->lang->line('system_dialog_pluginInstallation_errorCantOpenZIP');
                    }
                } else {
                    $result = new stdClass();
                    $result->dialogTitle = $this->lang->line('application_dialogTitle_error');
                    $result->successMessage = $this->lang->line('system_dialog_pluginInstallation_errorCantOpenZIP');
                }
            } else {
                $result = new stdClass();
                $result->dialogTitle = $this->lang->line('application_dialogTitle_error');
                $result->errorMessage = $this->lang->line("system_dialog_pluginInstallation_errorCantUploadFile");
            }
        }

        echo json_encode($result);
    }

/*
* take all files of ectracted zip archive and put them into right place
*
*
* return boolean
*/
    private function installArchiveFiles($directory = './dynamicContents/temp/pluginTemp/'){
        //set default values of variables
        $configFileFound = FALSE;
        //search for config files
        if($dirHandle = opendir($directory)) {
            while(($file = readdir($dirHandle)) !== false){
                if(!in_array($file, array('.', '..'))){
                    if(strpos($file, '_config.php')){
                        $configFileFound = TRUE;
                        include_once($directory.$file);
                    }
                }
            }
        } else {
            return FALSE;
        }

        if($configFileFound){
            //copy files from extracted zip archive to destination
            foreach($pluginConfig as $key => $list){
                switch($key){
                    case 'language':
                        if($dirHandle = opendir($directory.$key)) {
                            while(($dir = readdir($dirHandle)) !== false){
                                if(!in_array($dir, array('.', '..')) && is_dir($directory.$key.'/'.$dir)){
                                    //create folder if neccessary
                                    if(!is_dir('./application/'.$key.'/'.$dir.'/')){
                                        mkdir('./application/'.$key.'/'.$dir.'/', 0777);
                                    }
                                    //copy files to application
                                    foreach($list as $listKey => $listValue){
                                        rename($directory.$key.'/'.$dir.'/'.$listValue, './application/'.$key.'/'.$dir.'/'.$listValue);
                                    }
                                }
                            }
                        }
                        break;

                    case 'views':
                        //create folder if neccessary
                        if(!is_dir('./application/'.$key.'/'.$pluginConfigName.'/')){
                            mkdir('./application/'.$key.'/'.$pluginConfigName.'/', 0777);
                        }
                        //copy files to application
                        foreach($list as $listKey => $listValue){
                            rename($directory.$key.'/'.$listValue, './application/'.$key.'/'.$pluginConfigName.'/'.$listValue);
                        }
                        break;

                    default:
                        //copy files to application
                        foreach($list as $listKey => $listValue){
                            rename($directory.$key.'/'.$listValue, './application/'.$key.'/'.$listValue);
                        }
                        break;
                }
            }
            //create neccessary database fields/entries
            if($this->System_model->pluginExists($pluginConfigName)){
                //plugin exists, perform update
            } else {
                //plugin does not exist, perform insertion
                $this->System_model->insertIntoTable('tbl_plugin', $pluginConfigDB->tblPlugin);
                $plugin = $this->System_model->getPlugin(array('plugin_systemName' => $pluginConfigName));
                foreach($pluginConfigDB->tblPluginDescription as $key => $value){
                    $data = array();
                    $data['pluginDescription_pluginID'] = $plugin->pluginID;
                    $data['pluginDescription_languageID'] = $key;
                    $data['plufinDescription_name'] = $value;

                    $this->System_model->insertIntoTable('tbl_pluginDescription', $data);
                }
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
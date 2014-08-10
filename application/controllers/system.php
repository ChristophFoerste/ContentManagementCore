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
            $archivePath = $this->config->item("plugin_pathBackup").$plugin.date('_Ymd_His').'.zip';
            $this->load->library('zip');
            //check controller
            $path = './application/controllers/'.$plugin.'.php';
            if(file_exists($path)){
                $content = file_get_contents($path);
                $this->zip->add_data('controllers/'.$plugin.'.php', $content);
            }
            //check javascript
            $path = './application/javascript/'.$plugin.'.js';
            if(file_exists($path)){
                $content = file_get_contents($path);
                $this->zip->add_data('javascript/'.$plugin.'.js', $content);
            }
            //check model
            $path = './application/models/'.$plugin.'_model.php';
            if(file_exists($path)){
                $content = file_get_contents($path);
                $this->zip->add_data('models/'.$plugin.'_model.php', $content);
            }
            //check views
            $path = './application/views/'.$plugin.'/';
            if(is_dir($path)){
                $this->zip->read_dir($path, FALSE);
            }
            //check config
            $path = './application/config/config_'.$plugin.'.php';
            if(file_exists($path)){
                $content = file_get_contents($path);
                $this->zip->add_data('config/config_'.$plugin.'.php', $content);
            }
            //check languages
            $this->zip->add_dir('language');
            if ($dirHandle = opendir('./application/language')) {
                while (($dir = readdir($dirHandle)) !== false){
                    if (!in_array($dir, array('.', '..')) && is_dir('./application/language/'.$dir)){
                        if(file_exists('./application/language/'.$dir.'/'.$plugin.'_lang.php')){
                            $content = file_get_contents('./application/language/'.$dir.'/'.$plugin.'_lang.php');
                            $this->zip->add_data('language/'.$dir.'/'.$plugin.'_lang.php', $content);
                        }
                    }
                }
            }

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
                    //unlink('./dynamicContents/temp/pluginTemp.zip'); //delete uploaded zip archive
                    if($this->installArchiveFiles()){
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
* return string representation of true or false
*/
    private function installArchiveFiles($directory = './dynamicContents/temp/pluginArchive/'){
        /*
        //open directory
        if ($dirHandle = opendir($directory)) {
            //loop through all directories
            while (($dir = readdir($dirHandle)) !== false){
                //if allowed directory
                if (!in_array($dir, array('.', '..')) && is_dir($directory.$dir)){
                    //loop through every file in directory
                    while(){
                        //if element directory -> recursive call of this function
                        if(DIRECTOY){
                            $this->installArchiveFiles()
                        } elseif(FILE){
                            //copy file to directory
                        }
                    }
                }
            }
        }*/
        return TRUE;
    }
}
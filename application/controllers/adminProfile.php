<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class adminProfile extends CI_Controller {
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
        //get current plugin name
        $this->data['currentPlugin'] = $this->ControlTable_model->getPluginName(get_class($this), $this->_admin->languageID);
        //get list of available plugins
        $this->data['availablePlugins'] = $this->ControlTable_model->getTable('qry_controlTable_plugin', array('pluginDescription_languageID' => (int)$this->_admin->languageID, 'plugin_isAvailable' => TRUE));
        //get list of blocked plugins (not shown in top menu)
        $this->data['blockedPlugins'] = $this->config->item('blockedPlugins');
        //create admin object
        $this->data['admin'] = $this->_admin;
        //setup pushMenu
        /*
        $this->_pushMenu = new \System\Menu\PushMenu("Optionen");
        $this->_pushMenu->addItem("link", "MenuEintrag_1", NULL, "http://www.google.de", "globe", NULL, "zu google");
        $this->_pushMenu->addItem("link", "MenuEintrag_2", NULL, "#", "user", NULL, "Hinweis 2");
        $this->_pushMenu->addItem("link", "MenuEintrag_3", NULL, "#", "envelope", NULL, "Hinweis 3");
        $this->_pushMenu = $this->_pushMenu->getRenderedMenu();
        */

        $this->data['pushMenu'] = $this->_pushMenu;
        $this->data['pushMenuCollapsed'] = $this->_pushMenuCollapsed;
    }

    public function index() {
        $this->_viewData['admin'] = $this->_admin;
        $this->_viewData['user'] = $this->admin_model->getAdmin($this->_admin->ID);
        $this->_viewData['languages'] = $this->ControlTable_model->getTableAsSelectOptions('qry_controlTable_language', 'languageDescriptionID', 'languageDescription_name', array('languageID' => (int)$this->_admin->languageID));
        $this->_viewData['genderTypes'] = $this->ControlTable_model->getTableAsSelectOptions('qry_controlTable_genderType', 'genderTypeID', 'descriptionName', array('languageID' => (int)$this->_admin->languageID));

        //get user image
        if(file_exists('./dynamicContents/images/admin/'.$this->_admin->username.'.jpg')){
            $profilePicturePath = base_url().'dynamicContents/images/admin/'.$this->_admin->username.'.jpg';
        } elseif(file_exists('./dynamicContents/images/admin/'.$this->_admin->username.'.png')){
            $profilePicturePath = base_url().'dynamicContents/images/admin/'.$this->_admin->username.'.png';
        } elseif(file_exists('./dynamicContents/images/admin/'.$this->_admin->username.'.gif')){
            $profilePicturePath = base_url().'dynamicContents/images/admin/'.$this->_admin->username.'.gif';
        } else {
            $profilePicturePath = base_url().'/assets/img/adminProfile/profilePicturePlaceholder.png';
        }
        $this->_viewData['profilePicturePath'] = $profilePicturePath;

        $this->data['websiteContent'] = $this->load->view("adminProfile/profile", $this->_viewData, TRUE);

        $this->load->view('template/template', $this->data);
    }

    public function updateUser() {
        if($this->admin_model->updateAdmin($this->_admin->ID, $_POST)) {
            echo "true";
        } else {
            echo "false";
        }
    }

    public function uploadProfilePicture(){
        $uploadConfig['file_name'] = $this->_admin->username;
        $uploadConfig['upload_path'] = "./dynamicContents/images/admin";
        $uploadConfig['allowed_types'] = "gif|jpg|png";
        $uploadConfig['max_size'] = 0;
        $uploadConfig['max_width'] = 0;
        $uploadConfig['max_height'] = 0;
        $uploadConfig['overwrite'] = TRUE;

        $this->load->library('upload', $uploadConfig);
        $this->upload->initialize($uploadConfig);

        if(!$this->upload->do_upload("profilePicture")){
            echo "error - ".$this->upload->display_errors();
        } else {
            echo "true";
        }
    }
}
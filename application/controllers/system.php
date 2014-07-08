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

    public function index() {
        $this->_viewData['admin'] = $this->_admin;

        $this->data['websiteContent'] = $this->load->view("system/system", $this->_viewData, TRUE);

        $this->load->view('template/template', $this->data);
    }
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller {
    private $_admin = NULL;
    private $_pushMenu = NULL;
    private $_pushMenuCollapsed = TRUE;
    private $_viewData  = NULL;

    /*##################################################################################################################
        function __connstruct()

        @summary    initialize class and setup standard values
        @access     public
        @return     void
    ##################################################################################################################*/
    function __construct() {
        parent::__construct();
        $this->_admin = $this->admin_model->getCurrentAdmin($this->session->userdata('session_id'));
        $this->data['admin'] = $this->_admin;
        $this->lang->load('application', $this->_admin->languageID);
        $this->lang->load(get_class($this), $this->_admin->languageID);

        //load javascript file for plugin
        $this->data['javaScriptFileName'] = get_class($this);

        //get list of available plugins
        $this->data['availablePlugins'] = $this->ControlTable_model->getTable('qry_controlTable_plugin', array('pluginDescription_languageID' => (int)$this->_admin->languageID, 'plugin_isAvailable' => TRUE));

        //pushMenu
        $this->data['pushMenu'] = $this->_pushMenu;
        $this->data['pushMenuCollapsed'] = $this->_pushMenuCollapsed;
    }

    /*##################################################################################################################
        function index($logout)

        @summary    load standard view
        @access     public
        @param      $logout (type of boolean) - show logout message or not
        @return     void
    ##################################################################################################################*/
    public function index($logout = FALSE) {
        if($logout){
            $this->data['admin']->isLoggedIn = FALSE;
        }
        $this->_viewData['logout'] = $logout;
        $this->data['websiteContent'] = $this->load->view("login/login", $this->_viewData, TRUE);
        $this->load->view('template/template', $this->data);
    }

    /*##################################################################################################################
        function validate()

        @summary    validate user credentials
        @access     public
        @return     string (representation of boolean values "true" or "false")
    ##################################################################################################################*/
    public function validate() {
        //check if "remember" is activated
        $rememberMe = FALSE;
        if(isset($_POST['admin_rememberLogin'])) {
            $rememberMe = TRUE;
            unset($_POST['admin_rememberLogin']);
        }

        //search for specific user
        $result = $this->admin_model->searchAdmin($_POST);

        //evaluate result
        if($result == NULL || count($result) != 1) {
            echo "false";
        } else {
            //write current session id to database
            $row = $result[0];
            $data = array('admin_sessionToken' => $this->session->userdata('session_id'),
                          'admin_userAgent' => $this->session->userdata('user_agent'),
                          'admin_lastActive' => date("d.m.Y H:i:s"));
            if($this->admin_model->updateAdmin($row->adminID, $data)) {
                $this->data['admin'] = NULL;
                echo "true";
            } else {
                $this->data['admin'] = NULL;
                echo "false";
            }

        }
    }

    /*##################################################################################################################
        function logout()

        @summary    logout user
        @access     public
        @return     void
    ##################################################################################################################*/
    public function logout() {
        $data = array('admin_sessionToken' => NULL, 'admin_lastActive' => date("d.m.Y H:i:s"));
        $this->session->sess_destroy();
        if($this->admin_model->updateAdmin($this->_admin->ID, $data)) {
            $this->index(TRUE);
        } else {
            $this->index();
        }
    }
}
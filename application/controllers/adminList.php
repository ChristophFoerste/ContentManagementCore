<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class adminList extends CI_Controller {
    private $_admin = NULL;
    private $_pushMenu = NULL;
    private $_pushMenuCollapsed = TRUE;
    private $_viewData  = NULL;

    function __construct() {
        parent::__construct();

        //user not logged in -> redirect to login page
        $this->_admin = new \System\User\Admin();
        $this->_admin = $this->admin_model->getCurrentAdmin($this->session->userdata('session_id'));
        $this->load->model("AdminList_model");
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
        //$this->_viewData['adminTable'] = $this->getAdminTable(TRUE);
		$this->_viewData['adminTable'] = $this->getAdminTableJSON();


        $this->data['websiteContent'] = $this->load->view("adminList/list", $this->_viewData, TRUE);
        $this->load->view('template/template', $this->data);
    }

    public function getAdminTable($toVariable = FALSE, $search = NULL){
        $this->_viewData['admin'] = $this->_admin;
        $this->_viewData['highlighter'] = new \System\Data\Highlighter();
        $this->_viewData['adminListArray'] = $this->AdminList_model->getAdminList();
        $this->_viewData['adminSearchString'] = $search;

        return $this->load->view("adminList/data_list", $this->_viewData, $toVariable);
    }
	
	 public function getAdminTableJSON(){
        $this->_viewData['admin'] = $this->_admin;

        //conversion of db column names to converted ones
        $columnConversionArray['ID'] = 'ID';
        $columnConversionArray['admin_username'] = 'Nutzername';
        $columnConversionArray['admin_realName'] = 'Name';
        $columnConversionArray['admin_lastActive'] = 'letzte Anmeldung';
        $columnConversionArray['admin_userAgent'] = 'genutzter Browser';
        $this->_viewData['columnConversionArray'] = json_encode($columnConversionArray);

        return $this->load->view("adminList/data_list_json", $this->_viewData, TRUE);
    }
	
	public function getAdminJsonData(){
		echo json_encode($this->AdminList_model->getAdminList());
	}
}
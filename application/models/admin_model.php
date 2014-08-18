<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {
    private $_converter = NULL;

    /*##################################################################################################################
        class member
    ##################################################################################################################*/


    /*##################################################################################################################
        constructor
    ##################################################################################################################*/
    function __construct() {
        parent::__construct();

        $this->_converter = new \System\Data\Converter();
    }

    /*##################################################################################################################
        function getAdminList()

        @summary    get all results of tbl_user
        @access     public
        @return     array of mixed objects
    ##################################################################################################################*/
    public function getCurrentAdmin($sessionToken) {
        $this->db->select("*");
        $this->db->where(array('admin_sessionToken' => $sessionToken));
        $query = $this->db->get("qry_admin");
        $query = $query->result();

        if(count($query) > 0){
            $row = $query[0];
            $admin = new \System\User\Admin();

            $admin->ID = $row->adminID;
            $admin->username = $row->admin_username;
            $admin->firstname = $row->admin_firstname;
            $admin->lastname = $row->admin_lastname;
            $admin->languageID = $row->admin_languageID;
            $admin->genderTypeID = $row->admin_genderTypeID;
            $admin->email = $row->admin_email;
            $admin->permissions = $this->getCurrentAdminPermissions($row->adminID);
            $admin->password = md5($row->admin_password);
            $admin->settings->isPushmenuCollapsed = $row->adminSettings_pushMenuCollapsed;
            $admin->settings->bootstrapTheme = $row->adminSettings_bootstrapTheme;
            $admin->isLoggedIn = TRUE;

            return $admin;
        } else {
            return new \System\User\Admin();
        }
    }

    /*##################################################################################################################
        function getAdminList()

        @summary    get all results of tbl_adminPermission
        @access     private
        @return     array of mixed objects
    ##################################################################################################################*/
    public function getCurrentAdminPermissions($adminID) {
        $this->db->select("*");
        $this->db->where(array('adminPermission_adminID' => $adminID));
        $query = $this->db->get("tbl_adminPermission");

        if(!$query || $query->row() == NULL){
            return NULL;
        } else {
            return $query->row();
        }
    }

    /*##################################################################################################################
        function getAdminList()

        @summary    get all results of tbl_user
        @access     public
        @return     array of mixed objects
    ##################################################################################################################*/
    public function getAdminList() {
        $this->db->select("*");
        $query = $this->db->get("tbl_admin");
        $query = $query->result();

        if(count($query) > 0){
            return $query;
        } else {
            return NULL;
        }
    }

    /*##################################################################################################################
        function getAdmin()

        @summary    get admin by ID
        @access     public
        @param      $adminID (type of int) - id of admin
        @return     mixed object
    ##################################################################################################################*/
    public function getAdmin($adminID) {
        $this->db->select("*");
        $this->db->where('adminID', (int)$adminID);
        $query = $this->db->get("tbl_admin");
        $query = $query->result();

        if(count($query) > 0){
            return $query[0];
        } else {
            return NULL;
        }
    }

    /*##################################################################################################################
        function searchAdmin($searchArray)

        @summary    search admin by attribute list
        @access     public
        @param      $searchArray (type of array) - assoziative array with search values
        @return     array of mixed objects
    ##################################################################################################################*/
    public function searchAdmin($searchArray = NULL) {
        if(is_array($searchArray) && count($searchArray) > 0 && $searchArray != NULL) {
            $this->db->select("*");
            $this->db->where($searchArray);
            $query = $this->db->get("tbl_admin");
            $query = $query->result();

            if(count($query) > 0){
                return $query;
            } else {
                return NULL;
            }
        } else {
            return FALSE;
        }
    }

    /*##################################################################################################################
        function updateAdmin($adminID, $data)

        @summary    search admin by attribute list
        @access     public
        @param      $adminID (type of int) - identifier of administrator
        @param      $data (type of array) - assoziative array with updated values
        @return     boolean
    ##################################################################################################################*/
    public function updateAdmin($adminID = NULL, $data = NULL) {
        //return if neccessary data not given
        if($adminID == NULL || $data == NULL) {
            return FALSE;
        }

        //update admin
        $this->db->where(array('adminID' => (int)$adminID));
        return $this->db->update('tbl_admin', $this->_converter->prepareForDatabase($data));
    }
}
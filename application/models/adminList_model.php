<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AdminList_model extends CI_Model {
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

        @summary    get complete list of admins
        @access     public
        @return     mixed
    ##################################################################################################################*/
    public function getAdminList(){
        $query = $this->db->get('qry_adminList_list');
        if($query && count($query->result()) > 0){
            return $query->result();
        } else {
            return NULL;
        }
    }
}
?>
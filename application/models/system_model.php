<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_model extends CI_Model {
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
        function updatePlugin()

        @summary    update complete list of plugins
        @access     public
        @return     boolean
    ##################################################################################################################*/
    public function updatePlugin($pluginID, $data){
        $this->db->where('pluginID', (int)$pluginID);
        if($this->db->update('tbl_plugin', $data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
?>
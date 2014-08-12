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

        @param      $pluginID   => ID of plugin
        @param      $data       => array($key => $value) of values to be inserted

        @return     boolean
    ##################################################################################################################*/
    public function updatePlugin($pluginID, $data){
        $this->db->where('pluginID', (int)$pluginID);
        if($this->db->update('tbl_plugin', $this->_converter->prepareForDatabase($data))){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*##################################################################################################################
        function insertIntoTable()

        @summary    insert data array into table
        @access     public

        @param      $table  => name of table
        @param      $data   => array($key => $value) of values to be inserted

        @return     boolean
    ##################################################################################################################*/
    public function updatePlugin($table, $data){
        if($this->db->insert($table, $this->_converter->prepareForDatabase($data))){
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
?>
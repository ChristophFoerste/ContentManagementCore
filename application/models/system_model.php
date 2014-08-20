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
    public function insertIntoTable($table, $data){
        if($this->db->insert($table, $this->_converter->prepareForDatabase($data))){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*##################################################################################################################
        function fieldExists()

        @summary    insert data array into table
        @access     public

        @param      $table  => name of table
        @param      $field  => name of field to check

        @return     boolean or NULL, if no results in table
    ##################################################################################################################*/
    function fieldExists($table, $field){
        $result = FALSE;
        $query = $this->db->get($table);
        if(!$query || $query->num_rows() == 0){
            $result = NULL;
        } else {
            $buffer = $query->result();
            $buffer = $buffer[0];
            foreach($buffer as $key => $value){
                if($key == 'adminPermission_'.$field){
                    $result = TRUE;
                }
            }
        }

        return $result;
    }

    /*##################################################################################################################
        function addPermissionField()

        @summary    insert data array into table
        @access     public

        @param      $name   => name of field
        @param      $value  => standard value of field

        @return     boolean
    ##################################################################################################################*/
    function addPermissionField($name, $value){
        $this->load->dbforge();
        $fields = array($name => array('type' => 'YESNO', 'default' => $value));

        if($this->dbforge->add_column('tbl_adminPermission', $fields)){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*##################################################################################################################
        function pluginExists()

        @summary    insert data array into table
        @access     public

        @param      $plugin  => systemName of plugin

        @return     no result => FALSE, result => pluginID
    ##################################################################################################################*/
    function pluginExists($plugin){
        $result = FALSE;
        $this->db->where(array('plugin_systemName' => $plugin));
        $query = $this->db->get('tbl_plugin');
        if(!$query || $query->row() == NULL){
            $result = FALSE;
        } else {
            $buffer = $query->row();
            $result = $buffer->pluginID;
        }

        return $result;
    }

    /*##################################################################################################################
        function getPlugin()

        @summary    insert data array into table
        @access     public

        @param      $arrWhere  => search specification as array

        @return     no result => FALSE, result => pluginID
    ##################################################################################################################*/
    function getPlugin($arrWhere){
        $result = FALSE;
        $this->db->where($arrWhere);
        $query = $this->db->get('tbl_plugin');
        if(!$query || $query->num_rows() == 0){
            $result = FALSE;
        } else {
            $buffer = $query->result();
            $result = $buffer[0];
        }

        return $result;
    }
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ControlTable_model extends CI_Model {

    /*##################################################################################################################
        class member
    ##################################################################################################################*/


    /*##################################################################################################################
        constructor
    ##################################################################################################################*/
    function __construct() {
        parent::__construct();
    }

    /*##################################################################################################################
        function getTableAsSelectOptions($table, $languageID)

        @summary    get all results of tbl_user to build a select-element
        @access     public
        @param      $table (type of string) - name of table
        @param      $key (type of string) - key column of table (possibly the ID)
        @param      $value (type of string) - value column of table (possibly the name)
        @param      $arrWhere (type of array) - where clause for query (especcially for language)
        @return     array of mixed objects
    ##################################################################################################################*/
    public function getTableAsSelectOptions($table = NULL, $key, $value, $arrWhere = NULL) {
        if($table === NULL || $arrWhere === NULL) {
            return array();
        } else {
            $this->db->select("*");
            $this->db->where($arrWhere);
            $query = $this->db->get($table);
            $query = $query->result();

            if(count($query) > 0){
                $array = array();
                foreach($query as $item) {
                    $array[$item->$key] = $item->$value;
                }

                return $array;
            } else {
                return array();
            }
        }
    }

    /*##################################################################################################################
        function getTable($table, $languageID)

        @summary    get all results of tbl_user to build a select-element
        @access     public
        @param      $table (type of string) - name of table
        @param      $arrWhere (type of string) - which entries should be displayed (SQL WHERE-clause)
        @return     array of mixed objects
    ##################################################################################################################*/
    public function getTable($table = NULL, $arrWhere) {
        if($table === NULL) {
            return NULL;
        } else {
            $this->db->select("*");
            $this->db->where($arrWhere);
            $query = $this->db->get($table);
            $query = $query->result();

            if(count($query) > 0){
                return $query;
            } else {
                return NULL;
            }
        }
    }

    /*##################################################################################################################
        function getPluginName($pluginSystemName, $languageID)

        @summary    get all results of tbl_user to build a select-element
        @access     public
        @param      $pluginSystemName (type of string) - name of current plugin
        @param      $languageID (type of int) - currently used language as id (standard 1 - german)
        @return     array('pluginIcon', 'pluginName')
    ##################################################################################################################*/
    public function getPluginName($pluginSystemName = NULL, $languageID = 1) {
        if($pluginSystemName === NULL) {
            return NULL;
        } else {
            $this->db->select("*");
            $this->db->where(array('plugin_systemName' => $pluginSystemName, 'pluginDescription_languageID' => (int)$languageID));
            $query = $this->db->get('qry_controlTable_plugin');
            $query = $query->result();

            if(count($query) > 0){
                return $query[0];
            } else {
                return NULL;
            }
        }
    }
}
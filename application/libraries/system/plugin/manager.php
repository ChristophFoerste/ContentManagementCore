<?php

namespace System\Plugin;

class Manager
{
    /*##################################################################################################################
        class member
    ##################################################################################################################*/

    /*##################################################################################################################
        constructor
    ##################################################################################################################*/
    function __construct() { }

    /*##################################################################################################################
        function isPluginAvailable($pluginName)

        @summary    check if all files of plugin available
        @access     public
        @param      $pluginName (type of string) - system name of plugin
        @param      $languageID (type of string) - currently used language
        @return     boolean
    ##################################################################################################################*/
    public function isPluginAvailable($pluginName, $languageID) {
        $result = TRUE;

        //lookup controller file
        if(!file_exists('./application/controllers/'.$pluginName.'.php')) {
            $result = FALSE;
        }

        //lookup view folder
        if(!is_dir('./application/views/'.$pluginName.'/')) {
            $result = FALSE;
        }

        //lookup language file
        if(!file_exists('./application/language/'.$languageID.'/'.$pluginName.'_lang.php')) {
            $result = FALSE;
        }

        return $result;
    }
}
?>
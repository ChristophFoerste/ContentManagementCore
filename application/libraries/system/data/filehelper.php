<?php

namespace System\Data;

class fileHelper
{
    /*##################################################################################################################
        class member
    ##################################################################################################################*/

    /*##################################################################################################################
        constructor
    ##################################################################################################################*/
    function __construct() { }

    /*##################################################################################################################
        function countFiles($dir, $extensionArray)

        @summary    count files in directory
        @access     public
        @param      $dir (type of string) - directory path
        @param      $extensionArray (type of string) - array of files to be count (standard NULL = all files)

        @return     int
    ##################################################################################################################*/
    public function countFiles($dir, $extensionArray = NULL){
        $i = 0;
        if ($handle = opendir($dir)) {
            while (($file = readdir($handle)) !== false){
                if (!in_array($file, array('.', '..')) && !is_dir($dir.$file))
                    if($extensionArray != NULL && in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), $extensionArray)){
                        $i++;
                    } else {
                        $i++;
                    }
            }
        }

        return $i;
    }
}
?>
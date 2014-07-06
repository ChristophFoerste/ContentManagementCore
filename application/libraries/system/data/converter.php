<?php

namespace System\Data;

class Converter
{
    /*##################################################################################################################
        class member
    ##################################################################################################################*/

    /*##################################################################################################################
        constructor
    ##################################################################################################################*/
    function __construct() { }

    /*##################################################################################################################
        function prepareForDatabase($array, $characterSet)

        @summary    convert values for database
        @access     public
        @param      $array (type of array) - assoziative array ($key => $value)
        @param      $characterSet (type of string) - character set for converting
        @return     boolean
    ##################################################################################################################*/
    public function prepareForDatabase($array, $characterSet = "ISO-8859-1//TRANSLIT") {
        if(is_array($array)) {
            foreach($array as $key=>$value) {
                $array[$key] = iconv(mb_detect_encoding($value), $characterSet, trim("".$value));
            }
        }

        return $array;
    }
}
?>
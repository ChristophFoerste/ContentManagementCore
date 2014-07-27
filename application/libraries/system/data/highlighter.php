<?php

namespace System\Data;

class Highlighter
{
    /*##################################################################################################################
        class member
    ##################################################################################################################*/

    /*##################################################################################################################
        constructor
    ##################################################################################################################*/
    function __construct() { }

    /*##################################################################################################################
        function higlightString($value, $search)

        @summary    highlight search-string in given value-string
        @access     public
        @param      $value (type of string) - haystack string
        @param      $search (type of string) - needle string

        @return     string
    ##################################################################################################################*/
    public function highlightString($value,$search)
    {
        if($search != NULL){
            $value = preg_replace('/'.preg_quote($search).'/ui', '<span class="search-highlight">$0</span>', $value);
        }
        return $value;
    }
}
?>
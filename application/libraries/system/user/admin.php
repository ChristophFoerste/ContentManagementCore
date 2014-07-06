<?php

namespace System\User;

class Admin
{
    /*##################################################################################################################
                                                     class member
    ##################################################################################################################*/
    public $ID = NULL;
    public $username = NULL;
    public $firstname = NULL;
    public $lastname = NULL;
    public $permissions = array();
    public $languageID = 1;
    public $genderTypeID = 1;
    public $email = NULL;
    public $isLoggedIn = FALSE;
    public $inactivityTimeout = 120;

    /*##################################################################################################################
        constructor
    ##################################################################################################################*/
    function __construct() { }

    /*##################################################################################################################
        getter
    ##################################################################################################################*/
    public function getFullname() { return $this->firstname." ".$this->lastname; }

    /*##################################################################################################################
        function hasPermission($searchArray, $searchMethod)

        @summary    search for permission and return existance value (TRUE || FALSE)
        @access     public
        @param      $searchArray (type of array) - list of permissions
        @param      $searchMethod (type of string) - kind of method to check values
                        - "AND" -> every value must be in the permissions array
                        - "OR" -> one or more of the given permissions must be available (standard)
        @return     boolean
    ##################################################################################################################*/
    public function hasPermission($requiredPermissions, $searchMethod = "OR") {
        $searchArray = array();
        if(strpos($requiredPermissions, ";") != -1){
            $searchArray = explode(";", $requiredPermissions);
        } else {
            $searchArray[] = $requiredPermissions;
        }
        $adminPermissions = explode(";", $this->permissions);

        print_r($requiredPermissions);
        switch($searchMethod) {
            case "OR":
                $result = FALSE;
                foreach($searchArray as $permission) {
                    if(in_array($permission, $adminPermissions))
                        $result = TRUE;
                }
                break;
            case "AND":
                $result = TRUE;
                foreach($searchArray as $permission) {
                    if(!in_array($permission, $adminPermissions))
                        $result = FALSE;
                }
                break;
            default:
                $result = FALSE;
                break;
        }

        return $result;
    }
}
?>
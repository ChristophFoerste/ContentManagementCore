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
    public $password = NULL;

    /*##################################################################################################################
        constructor
    ##################################################################################################################*/
    function __construct() { }

    /*##################################################################################################################
        getter
    ##################################################################################################################*/
    public function getFullname() { return $this->firstname." ".$this->lastname; }

    /*##################################################################################################################
        function checkPassword($password)

        @summary    check password of admin
        @access     public
        @param      $password (type of string) - password to check

        @return     boolean
    ##################################################################################################################*/
    public function checkPassword($password) {
        $result = FALSE;
        if(md5($password) === $this->password){
            $result = TRUE;
        }

        return $result;
    }

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

        switch($searchMethod) {
            case "OR":
                $result = FALSE;
                foreach($searchArray as $permission) {
                    $permission = 'adminPermission_'.$permission;
                    if(isset($this->permissions->$permission) && $this->permissions->$permission){
                        $result = TRUE;
                    }
                }
                break;
            case "AND":
                $result = TRUE;
                foreach($searchArray as $permission) {
                    $permission = 'adminPermission_'.$permission;
                    if(!isset($this->permissions->$permission) || !$this->permissions->$permission){
                        $result = FALSE;
                    }
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
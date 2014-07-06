<?php

namespace System\Menu;

class PushMenu
{
    /*##################################################################################################################
        class member
    ##################################################################################################################*/
    private $_menuHead = "";
    private $_menuList = array();

    /*##################################################################################################################
        constructor

        @param  $menuHead (type of string) - title of pushMenu
    ##################################################################################################################*/
    function __construct($menuHead)
    {
        $this->_menuHead = $menuHead;
    }

    /*##################################################################################################################
        function addItem($type, $elementID, $link = "#", $static = NULL)

        @summary    setup an item for the pushmenu
        @access     public
        @param      $type (type of string) - choose between "link" and "static"
        @param      $name (type of string) - shown string of menu item
        @param      $id (type of string) - place an unique id of the element
        @param      $link (type of string) - set the link for type of "link"
        @param      $icon (type of string) - font-awesome icon name without fa-prefix
        @param      $static (type of string) - place additional html-markup here
        @param      $description (type of string) - small hint while hovering on menu item
        @return     void
    ##################################################################################################################*/
    public function addItem($type, $name, $id, $link = "#", $icon, $static = NULL, $description)
    {
        $obj = NULL;
        $obj->type = $type;
        $obj->id = $id;
        $obj->name = $name;
        $obj->link = $link;
        $obj->icon = $icon;
        $obj->static = $static;
        $obj->description = $description;

        $this->_menuList[] = $obj;
    }

    /*##################################################################################################################
        function getRenderedMenu()

        @summary    create HTML markup of a pushMenu
        @access     public
        @return     html-markup (string)
    ##################################################################################################################*/
    public function getRenderedMenu()
    {
        $result = '<h2><i class="fa fa-fw fa-reorder"></i>'.$this->_menuHead.'</h2>';
        $result.= '<ul>';

        foreach($this->_menuList as $item)
        {
            switch(strtolower($item->type))
            {
                case 'link':
                    $result.= '<li title="'.$item->description.'">';
                    $result.= '<a href="'.$item->link.'" id="'.$item->id.'"><i class="fa fa-fw fa-'.$item->icon.'"></i>'.$item->name.'</a>';
                    $result.= '</li>';
                    break;
                case 'static':
                    $result.= '<li>';
                    $result.= '<a href="'.$item->link.'" id="'.$item->id.'">'.$item->name.'</a>';
                    $result.= '</li>';
                    break;
            }
        }

        $result.= '</ul>';

        return $result;
    }
}
?>
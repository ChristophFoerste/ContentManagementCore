<?php
class Application
{
    function __construct()
    {
        $this->includeNamespaceFiles('./application/libraries/system/');
    }

    //include files that belong to the namespace
    private function includeNamespaceFiles($directory)
    {
        if(is_dir($directory))
        {
            if($dirHandle = opendir($directory))
            {
                while(($element = readdir($dirHandle)) !== FALSE)
                {
                    if(is_file($directory.$element) && $element != '.' && $element != '..')
                    {
                        $fileInfo = pathinfo($directory.$element);
                        if($fileInfo['extension'] == 'php')
                        {
                            require_once($directory.$element);
                        }
                    }
                    elseif(is_dir($directory.$element) && $element != '.' && $element != '..')
                    {
                        $this->includeNamespaceFiles($directory.$element.'/');
                    }
                }
                closedir($dirHandle);
            }
        }
    }
}
?>
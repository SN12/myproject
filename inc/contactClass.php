<?php

require_once('personClass.php');
class contactClass extends personClass{
    
    function contactClass($contactInfo=NULL)
    {
        $this->personClass($contactInfo);
        $this->_table = "contacts";
    }
}

?>

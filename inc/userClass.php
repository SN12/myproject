<?php

require_once('personClass.php');
class userClass extends personClass {
    
    function userClass($userInfo=NULL)
    {
        $this->personClass($userInfo);
        $this->_table = 'users';
    }    
}

?>

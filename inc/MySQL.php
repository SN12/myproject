<?php
class MySQL {

    //put your code here
    var $_server = 'localhost';
    var $_dbName;
    var $_table;
    var $_userName;
    var $_password;
    var $_dbHandle;
    var $_isConnect = false;

    private function MySQL() {
        require_once(ROOTFOLDER.'/conf/db-config.php');
        $this->_server = DB_HOST;
        $this->_dbName = DB_NAME;
        $this->_userName = DB_USER;
        $this->_password = DB_PASSWORD;

        $this->_dbHandle = mysql_connect($this->_server, $this->_userName, $this->_password) or die("Could not connect: " . mysql_error());
        if (mysql_select_db($this->_dbName, $this->_dbHandle))
            $this->_isConnect = true;
    }

    public function connect() {
        if (!$this->_isConnect)
            $this->MySQL();
    }

    function disconnect() {

        if (@mysql_close($this->_dbHandle) != 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function query($sql) {
        $this->connect();
        $result = mysql_query($sql) or die("Error in query: " . mysql_error() . "<br>" . $sql . "<br>");

        if (!is_resource($result))
            return $result;
//var_dump($result);
        $arr = array();
        $num_rows = mysql_num_rows($result);
        if ($num_rows != 0) {
            while ($row = mysql_fetch_assoc($result)) {

                $r = array();
                foreach ($row as $key => $value) {
                    $r[$key] = $value;
                }
                $arr[] = $r;
            }
            return $arr;
        }
        else return 0;
    }

    public function equal_to_field_value($fieldName, $fieldValue) {
        $this->connect();
        $q = "SELECT COUNT(*) as count FROM " . $this->_table . " WHERE {$fieldName}='{$fieldValue}'";
//        var_dump($q);
        $r = mysql_query($q) or die("Error in query: " . mysql_error() . "<br>" . $sql . "<br>");
        $row = mysql_fetch_assoc($r);
        $count = $row['count'];
//        echo "count is".$count;
        if ($count > 0)
            return true;
        return false;
    }

    function lastInsertId() {
        return mysql_insert_id();
    }

}

?>

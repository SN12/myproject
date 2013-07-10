<?php

require_once('MySQL.php');

//exit(ROOTFOLDER);
class personClass extends MySQL {

    var $_firstName;
    var $_lastName;
    var $_email;
    var $_table;
    var $_personInfo;
    var $_personId;
    var $_isValidDatas = false;

    function personClass($personInfo = NULL) {
        $this->connect();
        $this->_personInfo = $personInfo;
    }

    function emailValidation() {
        $_isValidDatas = true;
    }

    function get_person_info() {
        return $_personInfo;
    }

    function add_person_to_db() {
        if ($this->_personInfo == NULL)
            return false;
        $q = '';
        foreach ($this->_personInfo as $k => $v) {
            $v = mysql_real_escape_string($v);
            $q.="{$k}='{$v}', ";
        }
        $q = substr_replace($q, "", -2);
        $q = "INSERT INTO " . $this->_table . " SET " . $q;

        if ($this->query($q)) {
            $this->_personId = mysql_insert_id();
            return true;
        }
        return false;
    }

    public function update_person_field($fieldName, $fieldValue) {
        $this->_personInfo["$fieldName"] = $fieldValue;
        $fieldValue = mysql_real_escape_string($fieldValue);
        $q = "UPDATE " . $this->_table . " SET {$fieldName}={$fieldValue} WHERE id={$this->_personId}";
        if ($this->query($q))
            return true;
        return false;
    } 

    function update_person_fields() {
        $q = '';
        foreach ($this->_personInfo as $k => $v) {
            $v = mysql_real_escape_string($v);
            $q.="{$k}='{$v}', ";
        }
        $q = substr_replace($q, "", -2);
        $q = "UPDATE " . $this->_table . " SET " . $q . " WHERE id={$this->_personId}";
        if ($this->query($q))
            return true;
        return false;
    }

    public function get_person_from_db_by_uniq_field($fieldName, $fieldValue) {
        $fieldValue = mysql_real_escape_string($fieldValue);
        $q = "SELECT * FROM " . $this->_table . " WHERE {$fieldName} = '{$fieldValue}'";
//        var_dump($q); 
        $r = $this->query($q);
        if ($r) {
            foreach ($r[0] as $k => $v) {
                $this->_personInfo["$k"] = $v;
            }
            $this->_personId = $r[0]['id'];
            return true;
        }
        return false;
    }

    function delete_person() {
        $q = "DELETE FROM " . $this->_table . " WHERE id= {$this->_personId}";
        if ($this->query($q))
            return true;
        return false;
    }

    function get_persons($cond = null, $order = null) {
        $q = "SELECT * FROM " . $this->_table;
        if ($cond && $cond != '')
            $q .= " WHERE {$cond} ";
        if ($order && $order != '')
            $q.=" ORDER BY " . $order;
        $r = $this->query($q);
        if ($r)
            return $r;
        return false;
    }

}

?>

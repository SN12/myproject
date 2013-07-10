<?php

require_once('MySQL.php');

class eventClass extends MySQL {

    var $_eventInfo;
    var $_eventId;

    function eventClass($eventInfo = null) {
        $this->connect();
        $this->_eventInfo = $eventInfo;
        $this->_table = 'events';
    }

    function add_event_to_db() {
        $q = "INSERT INTO " . $this->_table . " SET ";
        foreach ($this->_eventInfo as $k => $v) {
            $v = mysql_real_escape_string($v);
            $q.="{$k}='{$v}', ";
        }
        $q = substr_replace($q, "", -2);

        if ($this->query($q))
            return true;
        return false;
    }

    function delete_event($id) {
        $q = "DELETE FROM " . $this->_table . " WHERE id={$id}";
        if ($this->query($q))
            return true;
        return false;
    }

    function update_event($eventInfo) {
        $this->_eventInfo = $eventInfo;
        $q = '';
        foreach ($this->_eventInfo as $k => $v) {
            $v = mysql_real_escape_string($v);
            $q.="{$k}='{$v}', ";
        }
        $q = substr_replace($q, "", -2);

        $q = "UPDATE " . $this->_table . " SET " . $q . " WHERE id={$this->_eventId}";

        if ($this->query($q))
            return true;
        return false;
    }

    public function get_event_from_db_by_uniq_field($fieldName, $fieldValue) {
        if ($fieldName == 'id')
            $this->_eventId = $fieldValue;
        $fieldValue = mysql_real_escape_string($fieldValue);
        $q = "SELECT * FROM " . $this->_table . " WHERE {$fieldName} = '{$fieldValue}'";

        $r = $this->query($q);
        if ($r) {
            foreach ($r[0] as $k => $v) {
                $this->_eventInfo["$k"] = $v;
            }
            return $this->_eventInfo;
        }
        return false;
    }

    function get_events($cond = null, $order=null) {
        $q = "SELECT * FROM " . $this->_table;
        if ($cond && $cond != '')
            $q .= " {$cond} ";
        if ($order && $order != '')
            $q.=" ORDER BY " . $order;
        $r = $this->query($q);
        if ($r)
            return $r;
        return false;
    }
}

?>

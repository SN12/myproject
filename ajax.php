<?php
require_once 'conf/vars.php';
if ($_POST) {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'fieldDublicate') {
            if (!isset($_POST['object']) || !file_exists('inc/'.$_POST['object'] . 'Class.php') || !isset($_POST['fieldValue']) || !isset($_POST['fieldName']))
                echo 'false';
            else {
                $object = $_POST['object'];

                require_once('inc/'.$object . 'Class.php');
                $fieldValue = $_POST['fieldValue'];
                $fieldName = $_POST['fieldName'];
                $className = $object . 'Class';
                $Object = new $className();

                if ($Object->equal_to_field_value($fieldName, $fieldValue))
                    echo 'true';
                else
                    echo 'false';
            }
        }

        /* EVENTS */

        if ($_POST['action'] == 'getEditableFields') {

            if (!isset($_POST['id']) || empty($_POST['id']) || !isset($_POST['objType']) || empty($_POST['objType']) || !( file_exists('inc/'.$_POST['objType'] . 'Class.php'))) {
                exit('edit');
                echo 'false';
            } else {
                $id = $_POST['id'];
                $objType = $_POST['objType'];
                require_once('inc/'.$objType . 'Class.php');
                $className = $objType . 'Class';
                $instance = new $className();
                $method = 'get_' . $objType . '_from_db_by_uniq_field';
                $arr = $instance->$method('id', $id);
                $json = null;
                if ($objType == 'event') {
                    $date = '';
                    $time = '';
                    if ($arr["datetime"]) {
                        $datetime = date_create($arr["datetime"]);
                        $date = date_format($datetime, 'Y-m-d');
                        $time = date_format($datetime, 'H:i');
                    }
                    $json .='[{"element":"input","name":"date","value":"' . $date . '"},{"element":"input","name":"time","value":"' . $time . '"},{"element":"textarea","name":"eventDesc","value":"' . $arr['event_desc'] . '"}]';
                }
                echo $json;
            }
        }
    }
}
?>

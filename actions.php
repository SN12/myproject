<?php

require_once 'conf/vars.php';
if (isset($_POST)) {

    /* Registration and login */

    if ($_POST['action'] == 'userRegistration') {
        $st = false;
        if (!isset($_POST['firstName']) || empty($_POST['firstName']) || !isset($_POST['lastName']) || empty($_POST['lastName']) || !isset($_POST['password']) || empty($_POST['password']) || !isset($_POST['conf_password']) || empty($_POST['conf_password']) || !isset($_POST['email']) || empty($_POST['email'])
        ) {
            $st = false;
        } else {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && filter_var($_POST['firstName'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[^A-Za-z0-9@\.]/"))) == '' && filter_var($_POST['lastName'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[^A-Za-z0-9@\.]/"))) == '' && filter_var($_POST['password'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[^A-Za-z0-9@\.]/"))) == '' && filter_var($_POST['conf_password'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[^A-Za-z0-9@\.]/"))) == ''
            ) {
                require_once(ROOTFOLDER . '/inc/userClass.php');
                $pass1 = $_POST['password'];
                $pass2 = $_POST['conf_password'];

                $userInfo = array();
                $userInfo['firstName'] = $_POST['firstName'];
                $userInfo['lastName'] = $_POST['lastName'];
                $userInfo['password'] = $pass1;
                $userInfo['email'] = $_POST['email'];

                $userInfo['password'] = md5($userInfo['password']);

                $User = new userClass($userInfo);

                if ($User->add_person_to_db()) {
                    $st = true;
                    session_start();
                    $_SESSION['user'] = $userInfo['email'];
                    $_SESSION['perm'] = 2;
                }
            }
        }
        if ($st == true) {
            header('Location:' . DOMAIN . 'dashboardUser.php?reg=' . $st);
        }
        else
            header('Location:' . DOMAIN . '/login.php?reg=' . $st);
    }

    if ($_POST['action'] == 'userLogin') {
        $st = false;
        if (!isset($_POST['loginEmail']) || empty($_POST['loginEmail']) || !isset($_POST['loginPassword']) || empty($_POST['loginPassword'])) {
            $st = false;
        } else {
            if (filter_var($_POST['loginEmail'], FILTER_VALIDATE_EMAIL) && filter_var($_POST['loginPassword'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[^A-Za-z0-9@\.]/"))) == '') {
                require_once (ROOTFOLDER . '/inc/userClass.php');
                $login = $_POST['loginEmail'];
                $password = md5($_POST['loginPassword']);
                $User = new userClass();
                if ($User->get_person_from_db_by_uniq_field('email', $login)) {
                    $UserInfo = $User->_personInfo;

                    if ($UserInfo['password'] == $password && $UserInfo['permission'] == 2) {
                        $st = true;
                        session_start();
                        $_SESSION['user'] = $login;
                        $_SESSION['user'] = $login;
                        $_SESSION['perm'] = 2;
                    }
                }
            }
        }
        if ($st)
            header('Location:' . DOMAIN . 'dashboardUser.php?login=1');
        else
            header('Location:' . DOMAIN . 'login.php?login=0');
    }

    if ($_POST['action'] == 'adminLogin') {

        if (!isset($_POST['login']) || empty($_POST['login']) || !isset($_POST['password']) || empty($_POST['password'])) {
            $st = false;
        } else {
            if (filter_var($_POST['login'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[^A-Za-z0-9@\.]/"))) == '' || filter_var($_POST['password'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[^A-Za-z0-9@\.]/"))) == '') {

                require_once (ROOTFOLDER . '/inc/userClass.php');
                $login = $_POST['login'];
                $password = md5($_POST['password']);
                $User = new userClass();
                if ($User->get_person_from_db_by_uniq_field('login', $login)) {
                    $UserInfo = $User->_personInfo;
                    if ($UserInfo['password'] == $password && $UserInfo['permission'] == 1) {
                        $st = true;
                        session_start();
                        $_SESSION['admin'] = $login;
                        $_SESSION['perm'] = 1;
                    }
                }
            }
        }
        if ($st)
            header('Location:' . DOMAIN . 'dashboardAdmin.php?login=1');
        else
            header('Location:' . DOMAIN . 'adminLogin.php?login=0');
    }

    /* Contacts */

    if ($_POST['action'] == "addContact") {
        $response = false;

        if (!isset($_POST['firstName']) || empty($_POST['firstName']) || !isset($_POST['lastName']) || empty($_POST['lastName']) || !isset($_POST['email']) || empty($_POST['email'])) {
            $response = false;
        } else {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && filter_var($_POST['firstName'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[^A-Za-z0-9@\.]/"))) == '' && filter_var($_POST['lastName'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[^A-Za-z0-9@\.]/"))) == '') {
                require_once(ROOTFOLDER . '/inc/contactClass.php');
                $contactInfo = array();
                $contactInfo['firstName'] = $_POST['firstName'];
                $contactInfo['lastName'] = $_POST['lastName'];
                $contactInfo['email'] = $_POST['email'];
                $hash = md5(uniqid(rand(), true));

                $Contact = new contactClass($contactInfo);
                $response = false;
                if ($Contact->add_person_to_db()) {
                     $hash .=$Contact->_personId;  
                    require_once(ROOTFOLDER . '/inc/functions.php');
                    if (verification_mail($contactInfo['email'], $hash, $contactInfo['firstName'])) {
                        $response = true;
                    }
                }
            }
        }
        header('Location:' . DOMAIN . 'dashboardUser.php?tab=contacts&add=' . $response);
    }
    /* Events */

    if ($_POST['action'] == "addEvent") {
        $response = false;
        if (!isset($_POST['date']) || empty($_POST['date']) || !isset($_POST['time']) || empty($_POST['time']) || !isset($_POST['eventDesc']) || empty($_POST['eventDesc'])) {
            $response = false;
        } else {
            if (filter_var($_POST['date'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[^0-9\/-]/"))) == '' && filter_var($_POST['time'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[^0-9:]/"))) == '') {
                $eventInfo = array();
                $datetime = $_POST["date"] . " " . $_POST["time"];
                if ($datetime = date_create($datetime)) {
                    $date = date_format($datetime, 'Y-m-d H:i:s');

                    $eventInfo['datetime'] = $date;
                    $eventInfo['event_desc'] = $_POST['eventDesc'];

                    require_once(ROOTFOLDER . '/inc/eventClass.php');
                    $Event = new eventClass($eventInfo);
                    $response = false;
                    if ($Event->add_event_to_db())
                        $response = true;
                }
            }
        }
        header('Location:' . DOMAIN . 'dashboardAdmin.php?tab=events&action=add&value=' . $response);
    }

    if ($_POST['action'] == "updateEvent") {
        $response = false;
        if (!isset($_POST['date']) || empty($_POST['date']) || !isset($_POST['time']) || empty($_POST['time']) || !isset($_POST['eventDesc']) || empty($_POST['eventDesc'])) {
            $response = false;
        } else {
            if (filter_var($_POST['date'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[^0-9\/-]/"))) == '' && filter_var($_POST['time'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[^0-9:]/"))) == '') {
                $eventInfo = array();
                $datetime = $_POST["date"] . " " . $_POST["time"];
                if ($datetime = date_create($datetime)) {
                    $date = date_format($datetime, 'Y-m-d H:i:s');
                    $eventInfo['datetime'] = $date;
                    $eventInfo['event_desc'] = $_POST['eventDesc'];
                    $eventInfo['event_desc'] = $_POST['eventDesc'];
                    $eventId = $_POST['eventId'];
                    require_once(ROOTFOLDER . '/inc/eventClass.php');
                    $Event = new eventClass();
                    $Event->get_event_from_db_by_uniq_field('id', $eventId);
                    if ($Event->update_event($eventInfo))
                        $response = true;
                }
            }
        }
        header('Location:' . DOMAIN . 'dashboardAdmin.php?tab=events&action=update&value=' . $response);
    }

    if ($_POST['action'] == "deleteEvent") {
        $response = false;

        if (!isset($_POST['eventId']) || empty($_POST['eventId']) || filter_var($_POST['eventId'], FILTER_VALIDATE_INT) == '') {
            $response = false;
        } else {
            require_once(ROOTFOLDER . '/inc/eventClass.php');
            $Event = new eventClass();
            $id = $_POST['eventId'];
            $response = false;
            if ($Event->delete_event($id))
                $response = true;
        }
        header('Location:' . DOMAIN . 'dashboardAdmin.php?tab=events&action=delete&value=' . $response);
    }

    /* Send email */

    if ($_POST['action'] == "sendMail") {
        $response = false;
        if (!isset($_POST['startDate']) || empty($_POST['startDate']) || !isset($_POST['startTime']) || !isset($_POST['endDate']) || empty($_POST['endDate']) || !isset($_POST['endTime']) || !isset($_POST['fileType']) || empty($_POST['fileType']) || !isset($_POST['subject']) || empty($_POST['subject']) || !isset($_POST['text']) || empty($_POST['text'])) {
            $response = false;
        } else {
            if (filter_var($_POST['startDate'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[^0-9\/-]/"))) == '' && filter_var($_POST['endDate'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[^0-9\/-]/"))) == '' && filter_var($_POST['startTime'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[^0-9:]/"))) == '' && filter_var($_POST['endTime'], FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[^0-9:]/"))) == '') {

                $startTime = (!isset($_POST['startTime']) || $_POST['startTime']== '') ? "00:00" : $_POST['startTime'];
                $endTime = (!isset($_POST['endTime']) || $_POST['endTime']== '') ? "00:00" : $_POST['endTime'];

                $from = $_POST['startDate'] . " " . $startTime . ":00";
                $to = $_POST['endDate'] . " " . $endTime . ":00";

                if (date_create($from) && date_create($to)) {
                    $from = date_create($from);
                    $to = date_create($to);
                    $from = date_format($from, 'Y-m-d H:i:s');
                    $to = date_format($to, 'Y-m-d H:i:s');
                    $subject = $_POST['subject'];
                    $text = $_POST['text'];

                    $type = $_POST['fileType'];
                    $cond = " WHERE datetime>'{$from}' AND datetime<'{$to}'";

                    require_once(ROOTFOLDER . '/inc/eventClass.php');
                    $Event = new eventClass();
                    $res = $Event->get_events($cond);
                    if ($res) {
                        require_once( ROOTFOLDER . '/inc/functions.php');
                        $fields = array('Date/Time', 'Description');
                        $file_fields = array();
                        $file_fields = array();
                        $file_fields[] = 'Date/Time';
                        $file_fields[] = 'Description';
                        
                        $f = 'create_' . $type;
                        if ($data = $f($res,$file_fields, $subject )) {
                            require_once(ROOTFOLDER . '/inc/contactClass.php');
                            $Contact =new contactClass();
                            $contacts = $Contact->get_persons("status=2");
                            $mails ='';
                            foreach($contacts as $contact){
                                $mails.=$contact['email'].",";
                            }
                            $mails = substr_replace($mails, "", -1);
                            sendMailWithAttachment($mails, $data, $subject, $text);
                            $response = true.'&type='.$type;
                        }
                    }
                }
            }
        }
        header('Location:' . DOMAIN . 'dashboardAdmin.php?tab=sendMail&action=send&value=' . $response);
    }
}
?>

<?php
if (!isset($_GET) || !isset($_GET['mail']) || !isset($_GET['key']))
    exit('<h2>You don\'t have permission to this page</h2>');
$email = $_GET['mail'];
//var_dump($_GET);
$key = $_GET['key'];
require_once('conf/vars.php');
require_once('/' . ROOTFOLDER . '/inc/contactClass.php');

$Contact = new contactClass();
if ($Contact->get_person_from_db_by_uniq_field('email', $email)) {


    if ($Contact->_personInfo['hash'] == $key) {
        if ( $Contact->update_person_field('status',2)) {}
                
//        echo "ura";
    else {
//        echo "bbb";
    }
    } else {
        exit('<h2>You don\'t have permission to this page</h2>');
    }
} else {
    exit('<h2>You don\'t have permission to this page</h2>');
}
?>

<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>Web Servers Performance, Availability, Traffic Monitoring and Analytics</title>
        <link rel="stylesheet" href="./styles/confirmation.css" type="text/css">
    </head>
    <body>
        <div class="mainPanel">
            <div id="topHeader" class="topHeader">
                <div class="logoPanel"></div>
            </div>
            <div class="middlePanel" id="middlePanel">
                <div class="mainContent" id="mainContent">
                    <div class="contentText">
                        <p id="confirmation_subTitle" class="confirmation_subTitle">E-mail confirmation</p>
                        <div id="confirmation_text" class="confirmation_text">
                            <div class="confirmation_check_img"></div>
                            <span id="conf_content" class="conf_content">Thank You!<br>Your contact <?php echo  $email; ?>  has been successfully confirmed.</span>
                        </div>
                        <a href="<?php echo DOMAIN; ?>login.php" class="okButton">OK</a>
                    </div>
                </div>
            </div>
        </div>

    </body></html>
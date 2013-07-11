<?php

require_once 'conf/vars.php';
session_start();
//var_dump($_SESSION);
//exit;
if (isset($_SESSION["admin"])) {
//    var_dump($_SESSION);
//exit;
    header('Location:' . DOMAIN . 'dashboardAdmin.php');
    exit;
}
if (isset($_SESSION['user']))
    header('Location:' . DOMAIN . 'dashboardUser.php');
header('Location:' . DOMAIN . 'login.php');
?>

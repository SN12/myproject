<?php

require_once 'conf/vars.php';
session_start();
if (isset($_SESSION["admin"])) {
    header('Location:' . DOMAIN . 'dashboardAdmin.php');
    exit;
}
if (isset($_SESSION['user']))
    header('Location:' . DOMAIN . 'dashboardUser.php');
header('Location:' . DOMAIN . 'login.php');
?>

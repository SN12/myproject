<?php
require_once 'conf/vars.php';
session_start();
if(isset($_SESSION['admin']))
     header('Location:'.DOMAIN.'dashboardAdmin.php');
?>


<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <title>Administrator login page</title>
        <link href="images/favicon.ico" rel="shortcut icon" type="image/ico">
        <!-- base css -->
        <link rel="stylesheet" href="styles/base.css" type="text/css"/>
        <link rel="stylesheet" href="styles/forms.css"  type="text/css"/>
        <script type="text/javascript" src='scripts/jquery-1.9.1.min.js'></script>
        <script type="text/javascript" src='scripts/functions.js'></script>
        <script type="text/javascript" src='scripts/admin.js'></script>
        <script type="text/javascript" src='scripts/popWindow.js'></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    </head>
    <body>
        <div id="main">
            <div class="container">   
                <header>
                    <div id='logo'>
                        <img src='images/logo.png' />
                    </div>
                </header>
                <div class="group"> 

                    <form class="login adminLogin" id="adminLogin" action="actions.php" method="post">
                        <h1 class="row">Log in to Admin Panel<img src="images/lock_fill.svg" class="secure" /></h1>
                        <p class='row'>	
                            <label for="login"  >Username<span>*</span></label>
                            <input class='until-validate req' type="text" alt="" name="login" id="loginEmail" placeholder="" >
                        </p>
                        <p class='row'>	
                            <label for="password">Password<span>*</span></label>
                            <input class='until-validate req' type="password" name="password" alt="password" id="loginPassword" placeholder="" >
                        </p>

                        <input type="hidden" name="action"  value="adminLogin"/>

                        <div class="form-bottom">
                            <div id="notes" >
                                <p class="reqErrMsg"></p>
                                <p class="passCharErr"></p>
                                <p class="emailFErr"></p>
                            </div>
                            <button type="button" alt="Log In" id="admin-login-button">Log In</button>	
                        </div>
                    </form><!-- .login -->

                </div>
            </div>
        </div><!-- .container -->

    </body>
</html>

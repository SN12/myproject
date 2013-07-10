<?php 
require_once 'conf/vars.php';
session_start();
if(isset($_SESSION['user']))
     header('Location:/'+ROOTFOLDER+'/dashboardUser.php');
?>
<!DOCTYPE html>
 <html>
    <head>
        <meta charset="utf-8">
        <title>Monitistask sign up and registration</title>
        <link href="images/favicon.ico" rel="shortcut icon" type="image/ico">
        <link rel="stylesheet" href="styles/base.css" type="text/css"/>
        <link rel="stylesheet" href="styles/forms.css"  type="text/css"/>
        <script type="text/javascript" src='scripts/jquery-1.9.1.min.js'></script>
        <script type="text/javascript" src='scripts/functions.js'></script>
        <script type="text/javascript" src='scripts/regLogin.js'></script>
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

                    <div class="left">

                        <form class="register" id="register" action="actions.php" method="post" for="user">
                            <h1 class="row">Sign Up <img src="images/lock_fill.svg" class="secure" /></h1>
                            <p class='row'>	    
                                <label for="firstName">First Name<span>*</span></label>
                                <input class='until-validate req' type="text" alt="first name" id="firstName" placeholder=""  name="firstName">
                            </p>
                            <p class='row'>	
                                <label for="lastName">Last Name<span>*</span></label>
                                <input class='until-validate req' type="text" alt="last name" id="lastname" placeholder=""  name="lastName">
                            </p>
                            <p class='row'>	
                                <label for="email">E-mail<span>*</span></label>
                                <input class='until-validate req' type="email" alt="email" id="email" placeholder=""  name="email">
                            </p>    
                            <p class='row'>	
                                <label for="password">Password<span>*</span></label>
                                <input class='until-validate req' type="password" alt="last name" id="password" placeholder="" name="password">
                            </p>
                            <p class='row'>	
                                <label for="conf_password">Confirm password<span>*</span></label>
                                <input class='until-validate req' type="password" alt="confirm password" id="conf_password" placeholder=""  name="conf_password">
                            </p>
                            
                           <input type="hidden" name="action"  value="userRegistration"/>
                            <div class="form-bottom">
                                <div id="notes" >
                                    <p class="reqErrMsg"></p>
                                    <p class="passCharErr"></p>
                                    <p class="passMatchErr"></p>
                                    <p class="emailFErr"></p>
                                    <p class="emailDErr"></p>
                                </div>
                                <button type="button" alt="Sign Up" id="register-button">Sign Up</button>	
                            </div>
                        </form><!-- .register -->

                    </div><!-- .left -->

                    <div class="right">

                        <form class="login" id="login" action="actions.php" method="post">
                            <h1 class="row">Login<img src="images/lock_fill.svg" class="secure" /></h1>
                            <p class='row'>	
                                <label for="login"  >Email<span>*</span></label>
                                <input class='until-validate req' type="email" alt="email" name="loginEmail" id="loginEmail" placeholder="" >
                            </p>
                            <p class='row'>	
                                <label for="password">Password<span>*</span></label>
                                <input class='until-validate req' type="password" alt="password" name="loginPassword" id="loginPassword" placeholder="" >
                            </p>
                            <input type="hidden" name="action"  value="userLogin"/>
                            <div class="form-bottom">
                                <div id="notes" >
                                    <p class="reqErrMsg"></p>
                                    <p class="passCharErr"></p>
                                    <p class="emailFErr"></p>
                                </div>
                                <button type="button" alt="Log In" id="user-login-button">Log In</button>	
                            </div>
                        </form><!-- .login -->

                    </div><!-- .right -->

                </div><!-- .group -->
            </div><!-- .container -->
        </div><!-- #main -->
    </body>
</html>
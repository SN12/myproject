<?php
require_once 'conf/vars.php';
session_start();

if(!isset($_SESSION['user']))
     header('Location:/'+ROOTFOLDER+'/login.php');

if (!isset($_GET['tab']))
    $tab = 'contacts';
else
    $tab = $_GET['tab'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Monitis task user dashboard</title>
        <link href="images/favicon.ico" rel="shortcut icon" type="image/ico">

        <link href="styles/dashboard.css" rel="stylesheet" type="text/css" />
        <link href="styles/base.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src='scripts/jquery-1.9.1.min.js'></script>
        <script type="text/javascript" src="scripts/functions.js"></script>
        <script type="text/javascript" src="scripts/dashboard.js"></script>

        <script type="text/javascript" src='scripts/popWindow.js'></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

    </head>
    <body>
        <div id="main" >
            <header id="header">
                <div class="miniLogo" >
                    <a href="#" >
                        <div class="logo" ></div>
                    </a>
                </div>
                <div class="dashboard-type">
                    <h1>User dashbaord</h1>
                </div>
                <div class="userInfo">
                    <a  >sn.nazinyan@gmail.com</a>
                </div>
            </header>
            <div id="content" >
                <div class="tabs">
                    <ul>
                        <li class="tab"><a <?php if ($tab == 'contacts') echo "class='active-tab' "; ?> href="?tab=contacts">Add Contact</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="mcontent">
                        <?php
                        if ($tab == 'contacts'):
                            ?>
                            <div class="contacts">
                                <header></header>
                                <section>
                                    <form class="register gray" id="add-contact" action="actions.php" method="post" for="contact">
                                        <div id="notes" >
                                            <p class="reqErrMsg"></p>
                                            <p class="passCharErr"></p>
                                            <p class="passMatchErr"></p>
                                            <p class="emailFErr"></p>
                                            <p class="emailDErr"></p>
                                        </div>
                                        <div class="table">

                                            <p class='column required'>	    
                                                <label for="firstName">First Name<span>*</span></label>
                                                <input class='until-validate req' type="text" alt="first name" id="firstName" placeholder=""  name="firstName">
                                            </p>
                                            <p class='column required'>	
                                                <label for="lastName">Last Name<span>*</span></label>
                                                <input class='until-validate req' type="text" alt="last name" id="lastname" placeholder=""  name="lastName">
                                            </p>
                                            <p class='column required'>	
                                                <label for="email">E-mail<span>*</span></label>
                                                <input class='until-validate req' type="email" alt="email" id="email" placeholder=""  name="email">
                                            </p>    
                                        </div>
                                        <input type="hidden" name="action" value="addContact"/>
                                        <div class="form-bottom">

                                            <button type="button" alt="Add a new contact" class="graybutton" id="add-contact-button">Add a new contact</button>	
                                        </div>
                                    </form><!-- .register -->
                                </section>
                            </div>
                        <?php endif; /* End contacts tab */ ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
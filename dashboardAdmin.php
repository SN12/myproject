<?php
require_once 'conf/vars.php';
session_start();
if(!isset($_SESSION['admin']))
    header('Location:/'.DOMAIN.'adminLogin.php');
if (!isset($_GET['tab']))
    $tab = 'contacts';
else
    $tab = $_GET['tab'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Administrator login page</title>
        <link href="images/favicon.ico" rel="shortcut icon" type="image/ico">
        <link href="styles/dashboard.css" rel="stylesheet" type="text/css" />
        <link href="styles/base.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src='scripts/jquery-1.9.1.min.js'></script>
        <script type="text/javascript" src="scripts/dashboard.js"></script>

        <script type="text/javascript" src="scripts/functions.js"></script>
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
                    <h1>Admin dashbaord</h1>
                </div>
                <div class="userInfo">
                    <a  href="logout">log out</a>

                </div>
            </header>
            <div id="content" >
                <div class="tabs">
                    <ul>
                        <li class="tab"><a <?php if ($tab == 'contacts' || $tab == '') echo "class='active-tab' "; ?> href="?tab=contacts">Contacts</a></li>
                        <li class="tab"><a <?php if ($tab == 'events') echo "class='active-tab' "; ?>  href="?tab=events">Events</a></li>
                        <li class="tab"><a <?php if ($tab == 'sendMail') echo "class='active-tab' "; ?>  href="?tab=sendMail">Send Mail</a></li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="mcontent">
                        <?php
                        if ($tab == 'contacts'):
                            require_once('inc/contactClass.php');
                            $Contact = new contactClass();
                            $contacts = $Contact->get_persons();
                            ?>

                            <div class="contacts">
                                <header></header>
                                <section>
                                    <table class="grid">
                                        <thead>
                                            <tr>
                                                <td>ID</td>
                                                <td>First Name</td>
                                                <td>Last Name</td>
                                                <td>Email</td>
                                                <td>Status</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $str = "";
                                            foreach ($contacts as $contact) {
                                                $status = array('1'=>"pending", '2'=>"active", '3'=>"inactive");
                                                $str .= "<tr>
                                                            <td>{$contact['id']}</td>
                                                            <td>{$contact['FirstName']}</td>
                                                            <td>{$contact['LastName']}</td>
                                                            <td>{$contact['email']}</td>
                                                            <td>{$status[$contact['status']]}</td>
                                                        </tr>";
                                            }
                                            echo $str;
                                            ?>


                                        </tbody>
                                    </table>
                                </section>
                                <div>
                                </div>
                            </div>

                        <?php endif; /* tab contacts end */ ?>
                        <?php
                        if ($tab == 'events'):
                            require_once('inc/eventClass.php');
                            $Event = new eventClass();
                            $events = $Event->get_events();
                            ?>  
                            <div class="events tabContent">
                                <header>
                                    <h2>Manage events</h2>
                                    <button class="graybutton flright" id="add-event-button" href="?tab=events&action=add">Add a new event</button>
                                </header>

                                <div id="eventsList" class="tab-middle" >

                                    <section>
                                        <?php
                                        if ($events) :
                                            ?>
                                            <table class="grid">
                                                <thead>
                                                    <tr>
                                                        <td>ID</td>
                                                        <td>Date/Time</td>
                                                        <td>Event Description</td>
                                                        <td class="action">Action</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $str = "";
                                                    foreach ($events as $event) {
//                                                    var_dump($contact);
                                                        $str .= "<tr>
                                                            <td>{$event['id']}</td>
                                                            <td>{$event['datetime']}</td>
                                                            <td>{$event['event_desc']}</td>
                                                            <td class='action-icons action'>
                                                                <div id='edit-event-{$event['id']}' class='edit-icon' title='edit event'></div>
                                                                <div id='delete-event-{$event['id']}' class='delete-icon' title='delete event'></div>
                                                            </td>
                                                        </tr>";
                                                    }
                                                    echo $str;
                                                    ?>

                                                </tbody>
                                            </table>
                                            <?php
                                        else:
                                            echo "<p>There is no events. </p>";
                                        endif; /* end events list */
                                        ?>
                                    </section>
                                    <div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; /* end events tab */ ?>
                        <?php if ($tab == 'sendMail'): ?>  
                            <div class="sendMail tabContent">
                                <header>
                                    <h2>Send mail to active contacts</h2>
                                </header>
                                <section>
                                    <div id="sendMailContent" class="tab-middle" >
                                        <form class="register gray" id="send-mail-form" action="actions.php" method="post">
                                            <div id="notes" >
                                                <p class="reqErrMsg"></p>
                                                <p class="passCharErr"></p>
                                                <p class="passMatchErr"></p>
                                                <p class="emailFErr"></p>
                                                <p class="emailDErr"></p>
                                            </div>
                                            <div id="form-fields">
                                                <div class='column'>	    
                                                    <label for="subject">Subject</label>
                                                    <input class='until-validate req' type="text" alt="subject" id="subject" placeholder=""  name="subject">
                                                </div>
                                                <div class='table row'>
                                                    <p class="column">
                                                        <label for="startDate">Start date/time</label>
                                                        <input class="until-validate req" type="date" alt="Start from (date)" id="startDate"  name="startDate" />
                                                        <input class="no-validate" type="time" alt="Start from (time)" id="startTime" placeholder=""  name="startTime" />
                                                    </p>
                                                    <p class='column'>	
                                                        <label for="endDate">End date/time</label>
                                                        <input class="until-validate req" type="date" alt="End date" id="endDate"  name="endDate" />
                                                        <input class="no-validate" type="time" alt="End time" id="endTime" placeholder=""  name="endTime" />
                                                    </p>
                                                </div>
                                                <div class='column radiobuttons'>	
                                                    <label for="text">Select file type</label>
                                                    <input type="radio" name="fileType" value="pdf" checked/><span>PDF</span>
                                                    <input type="radio" name="fileType"  value="cvs"/><span>CVS</span>
                                                </div>

                                                <div class='column'>	
                                                    <label for="text">Message Text</label>
                                                    <textarea class='until-validate req' type="text" alt="text" id="text" placeholder=""  name="text"></textarea>
                                                </div>
                                            </div>
                                            <input type="hidden" name="action"  value="sendMail"/>
                                            <div class="form-bottom">

                                                <button type="button" alt="Send" class="graybutton" id="send-mail-form-button">Send</button>	
                                            </div>
                                        </form><!-- .register -->
                                </section>
                            </div>
                            <div>
                            </div>
                        </div>
                    <?php endif; /* end send mail tab */ ?>
                </div>
            </div>
    </body>
</html>
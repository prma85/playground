<!DOCTYPE html>
<?php
/*
 * Example of Session
 * 
 * Created by Paulo Andrade
 * martinsp@uregina.ca
 */

//check if you clicked in a link to start or finish a session
session_start();
date_default_timezone_set('America/Regina');

if (isset($_GET['session'])) {
    if ($_GET['session'] == 1) {
        session_start();
    } else {
        echo 'removing all the variables';
        session_unset(); 

        echo 'closing the session';
        session_destroy();
    }
}

//Add a new value to the session
if (isset($_GET['new'])) {
        $_SESSION['new'] = $_GET['new'];
        $_SESSION['updated'] = $date = date('m/d/Y h:i:s a', time());
}

// show the values for the actual session
echo '<pre>';
var_dump($_SESSION);
echo '<pre>';
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>CS 215 Examples - Session</title>
        <style>* { font-size: 20px;}</style>
    </head>
    <body>
        To <b>OPEN</b> the section, you need to use the function session_start().
        You can do it clicking on this <b><a href="session.php?session=1"> LINK </a></b>. Once the page reload, you will be
        able to see the information about your session. The initial value is 
        <br><br>
        To <b>CLOSE</b> the section, you need to use the function session_destroy().
        You can do it clicking on this <b><a href="session.php?session=0"> LINK </a></b>. Once the page reload, you will not be
        able to see the information about your session anymore.

        <hr>
        Use this form to add new values to the session <br>
        <form method="get">
            <input type="text" name="new" />
            <input type="submit" value="add" />
        </form>
    </body>
</html>

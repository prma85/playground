<!DOCTYPE html>
<?php
/*
 * Example of file Upload
 * 
 * Created by Paulo Andrade
 * martinsp@uregina.ca
 */
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CS 215 Examples</title>
        <style>* { font-size: 20px;}</style>
    </head>
    <body>
        <?php
        echo 'Hello World';
        echo '<hr />';

        /* Timezone example
         * how to correct the hour from the URegina Server
         */
        date_default_timezone_set('America/Regina');
        echo date_default_timezone_get();

        echo '<br />';
        $date = date('m/d/Y h:i:s a', time());
        echo $date;

        echo '<hr>';
        
        date_default_timezone_set('America/Fortaleza');
        echo date_default_timezone_get();

        echo '<br />';
        $date = date('m/d/Y h:i:s a', time());
        echo $date;

        ?>

        <hr>
        <?php
        /* REMEMBER:
         * to Allow a upload, you need tu put the followig propriety in your form
         * enctype="multipart/form-data"
         */
        ?>
        <h2> File Upload</h2>
        <form method="post" action="file.php" enctype="multipart/form-data">
            <label for="myFile">Avatar</label>
            <br>
            <input id="myFile" type="file" name="myFile" />
            <br>
            <input type="submit" value="send" />
        </form>

        <hr>
        <h2>Session</h2>
        For the session, open the link <a href="session.php">Session.php</a> and also, check the PHP code.
        <br>
        If you already did it, you can check what is in your section now:
        <?php
        session_start();
        echo '<pre>';
        var_dump($_SESSION);
        echo '<pre>';
        ?>

        <hr>
        <h2>MySQL</h2>
        For the database, open the link <a href="posts.php">posts.php</a> and also, check the PHP code (_db.php and posts.php)

    </body>
</html>

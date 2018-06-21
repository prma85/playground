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
        To select all the posts from a user, let suppose that you table name is 'posts':
        <br>
        SELECT * FROM posts WHERE user_id = 2 ORDER BY created_date ASC;
        <br/>
        --> to get it from the database, you need to execute 5 steps
        <ol>
            <li></li> Create the connection using $conn = mysqli_connect($host, $user, $password, $database);   
            <li></li> Execute the query using $result = mysqli_query($conn, $query); //the $query will receive your SQL
            <li></li> If your query is a DELETE or INSERT or UPDATE, you will receive TRUE or FAlSE as an answer. 
            If is a SELECT, you will need to create a loop with the WHILE to access all the information and add all in a array.
            Example:
            <ul>
                <li>$temp = array();</li>
                <li>while ($row = $resource->fetch_assoc()) {</li>
                <li>    $temp[] = $row;</li>
                <li>}</li>
            </ul>
            <li>Now, all the results of your query are in the $temp and you need to release the memory using the function
            mysqli_free_result($result);</li>
            <li>The last step is close the connection using mysqli_close($conn);</li>

        </ol>
        <br>
        In other example, if you want to check the login, you will create the follwing query:<br>
        SELECT * FROM users WHERE username='test' and password='dqnk4t45323nnlf';<br>
        If the username and password is correct, you will get all the information of the user and you
        put put it as a key in the $_SESSION.
        <hr>
        Another way that you can do you queries is to create a file/class to handle with the database access<br>
        For example: I created the file _db.php with the class db. If I want to do a query now, I just use the following steps for the same example above (getting all posts): <br>
        <ol>
            <li>add in the begin of my page the command require_once('_db.php')</li>
            <li>I initialize my class, using $db = new db();</li>
            <li>For all queries now I just need to use $db->execute($query)</li>
            <li>Then, I check if it is a boolean or string or array to see which kind of answer I got from the database.<br>
            for new queries in the same page, I just do now the $db->execute($query) because I already started the class. The function also free the memory and close the connection.
            </li>
        </ol>
        <br> this is just a example, you can create your own class and improve with other functions like one specific for update or insert.
    </body>
</html>
        

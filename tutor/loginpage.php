<?php session_start(); ?>


<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="AssignmentStyleSheet.css" />
        <meta charset="UTF-8">
        <script type = "text/javascript" src="validateinfo.js"></script>
        <title>The Spider's Web</title>
    </head>
    <body class = "LP">

        <h1 class= "LP">
            The Spider's Web
        </h1>
        <form name="Login" method = "post" action = "LoginVal.php" id="login">
            <div class="container">
                <table>
                    <tr><td><h3>Email: </h3></td><td> <input type="text" id = "email" name="email" size="30" /></td></tr>
                    <tr><td></td><td><label id="emailerrmsg" class="err_msg"></label></td></tr>
                    <tr><td><h3>Password: </h3> </td><td> <input type="password" id = "psw"name="psw" size="30" /></td></tr>
                    <tr><td></td><td><label id="pass" class="err_msg"></label></td></tr>
                </table>
                <p><input type = "button" name = "Submit" value = "Submit" onclick="ValidateLoginInfo()"/>
                    <input type = "reset" name = "reset" value = "Reset" onclick = "LoginReset()" /></p>


            </div>

            <div class="container">


                <span class = "signup" > Would you like to join us? <a class = "LP" href="SignUpPage.html">Sign up here </a> </span>
            </div>
        </form>

    </body>
</html>


<script>
function ValidateLoginInfo(){
    
    //after validation, submit the form
    var form = document.getElementById('login');
    form.submit();
    
}

</script>


<?php 

foreach ($Result as $p){
    echo '<div class="post" id="post_'.$post["post_id"].'">';
    
    echo '<div class="left">';
    echo '<img src="'.$p["user_PicName"].'" />';
    echo '<p>'.$p["user_name"].'</p>';
    echo '</div>'; //closes div left
    
    echo '<div class="right">';
    echo '<p><br>'.$p["post_title"].'</b></p>';
    echo '<p>'.$p["post_dec"].'</p>';
    echo '<img src="'.$p["post_pic"].'" />';
    
    echo '</div>'; //closes div right
    echo '<br clear="all"';
    echo '<div class="sidebar">'; //like butons and replies
    echo '<a href="javascript:likePost('.$p["user_id"].','.$p["post_id"].')" title="like"><img src="" /></a>';
    echo '<a href="javascript:dislikePost('.$p["user_id"].','.$p["post_id"].')" title="dislike"><img src="" /></a>';
    echo '<a href="replyPost.php?post_id='.$p["post_id"].'" title="reply"><img src="" /></a>';
    echo '<span>0 Replies</span>';
    echo '</div>'; //closes div sidebar
    
    echo '</div>'; //closes div post
}


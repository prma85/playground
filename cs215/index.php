<!DOCTYPE html>
<?php 
//check if you already did the login
session_start();
if (!isset($_SESSION['user'])){
    header('location: initial.php');
}

?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CS 215 - System</title>
        <link rel="stylesheet" href="style/font-awesome.min.css" />
        <link rel="stylesheet" href="style/bulma.min.css" />
        <link rel="stylesheet" href="style/index.css" />
        <script src="ajax.js" type="text/javascript"></script>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
    </head>
    <body>
        <section class="section">
            <div class="container mainpage">
                <div class="front-bg">
                    <img class="front-image" src="bg.jpg" alt="">
                </div>
                <div class="lefthome w45 mrg5">
                    <h1>
                        CS 215
                    </h1>
                    <br /><br />
                    <p>Welcome to our social network!</p>
                </div>
                <div class="left w45 crlr">
                    <form class="form_home" action="process/user.php" method="post" enctype="multipart/form-data" name="login" id="login">
                        <h2>
                            Log In
                        </h2>
                        <input type="hidden" name="task" value="login" />
                        <div class="field">
                            <label class="label">Email *</label>
                            <div class="control">
                                <input class="input" type="email" name="email" id="log_email" placeholder="Text input" />
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Password *</label>
                            <div class="control">
                                <input class="input" type="password" name="password" id="log_pass" placeholder="Text input" />
                            </div>
                        </div>

                        <div class="field is-grouped">
                            <div class="control">
                                <input type="submit" class="button is-primary" value="Submit" />
                            </div>
                        </div>
                    </form>

                    <form class="form_home" action="process/user.php" method="post" enctype="multipart/form-data" name="signup" id="signup" />
                    <h2>
                        Sign Up
                    </h2>
                    <input type="hidden" name="task" value="signup" />
                    <div class="field">
                        <label class="label">First Name *</label>
                        <div class="control">
                            <input required="required" maxlength="20" class="input" type="text" name="f_name" id="l_name" placeholder="Text input" />
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Last Name *</label>
                        <div class="control">
                            <input required="required" maxlength="20" class="input" type="text" name="l_name" id="l_name" placeholder="Text input" />
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Email *</label>
                        <div class="control">
                            <input required="required" class="input" type="email" name="email" id="email" placeholder="Text input" />
                            <p id='hit_email' class="help is-danger dpn"></p>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Password *</label>
                        <div class="control">
                            <input required="required" maxlength="20" class="input" type="password" name="password" id="password" placeholder="Text input" />
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Re-enter the Password *</label>
                        <div class="control">
                            <input required="required" maxlength="20" class="input" type="password" name="password2" id="password2" placeholder="Text input" />
                            <p id="hit_password" class="help is-danger dpn">The passwords don't match, please, verify and try again!</p>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Avatar</label>
                        <div class="control">
                            <input class="input" type="file" name="avatar" id="avatar" />
                        </div>
                    </div>

                    <div class="field is-grouped">
                        <div class="control">
                            <input type="submit" class="button is-primary" value="Submit" />
                        </div>
                        <div class="control">
                            <input type="reset" class="button is-secondary" value="Cancel" />
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </section>
        <script src="index.js" type="text/javascript"></script>
        <?php
        if (isset($_SESSION['msg'])){
            echo "<script>alert('".$_SESSION['msg']."');</script>";
            unset($_SESSION['msg']);
        }
        ?>
    </body>
</html>
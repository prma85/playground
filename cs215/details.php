<!DOCTYPE html>
<?php session_start(); 
$_SESSION['actual'] = 'details'; ?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CS 215 - Social</title>
        <link rel="stylesheet" href="style/font-awesome.min.css" />
        <link rel="stylesheet" href="style/bulma.min.css" />
        <link rel="stylesheet" href="style/index.css" />
        <script src="ajax.js" type="text/javascript"></script>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
    </head>
    <body>
        <?php include_once 'toolbar.php'; ?>
        <section class="section">
            <div class="container">
                <?php include_once 'sidebar.php'; ?>
                <div class="content" id="main">
                    <form class="box" action="process/user.php" method="post" enctype="multipart/form-data" name="signup" id="signup" />
                    <input type="hidden" name="task" value="edit" />
                    <input type="hidden" name="avatar2" value="<?php echo $user['avatar']; ?>" />
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
                    <div class="field">
                        <label class="label">First Name *</label>
                        <div class="control">
                            <input required="required" maxlength="20" class="input" type="text" name="f_name" id="l_name" placeholder="Text input" value="<?php echo $user['f_name'];?>" />
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Last Name *</label>
                        <div class="control">
                            <input required="required" maxlength="20" class="input" type="text" name="l_name" id="l_name" placeholder="Text input" value="<?php echo $user['l_name'];?>" />
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Email *</label>
                        <div class="control">
                            <input disabled required="required" class="input" type="email" name="email" id="email" placeholder="Text input" value="<?php echo $user['email'];?>" />
                            <p id='hit_email' class="help is-danger dpn"></p>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Change the Password</label>
                        <div class="control">
                            <input maxlength="20" class="input" type="password" name="password" id="password" />
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Re-enter the Password</label>
                        <div class="control">
                            <input maxlength="20" class="input" type="password" name="password2" id="password2" />
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
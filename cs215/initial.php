<!DOCTYPE html>
<?php session_start(); 
require_once 'process/postInitial.php';
$_SESSION['actual'] = 'home'; 
$posts = getPosts('0, 10', false, true); //check in the database for new posts everytime that the page is reloaded
?>
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
                    <div class="box">
                        <form action="process/post.php" method="post" name="newpost" id="newpost" enctype="multipart/form-data">
                            <input type="hidden" name="task" value="new" />
                            <div class="field">
                                <div class="control">
                                    <textarea required="required" maxlength="140" rows="2" name="message" id="message" class="textarea" placeholder="New Post"></textarea>
                                    <span id="count">Remain characters: 140</span>
                                </div>
                            </div>
                            <div class="field is-grouped">
                                <div class="control">
                                    <label class="label">Image: 
                                        <input class="button" type="file" name="image" id="post_img" accept="image/x-png,image/gif,image/jpeg" />
                                    </label>
                                </div>
                                <div class="control">
                                    <input type="submit" name="btnsubmit" class="button is-primary" value="Submit" />
                                </div>
                            </div>
                        </form>
                        <div id="tempresult"></div>
                    </div>
                    <div class="box" id="allposts">
                    <?php
                        for ($i = 0; $i < count($posts); $i++){
                            echo $posts[$i]['html'];
                        }
                    ?>
                    </div>
                </div>
            </div>
        </section>

        <script src="index.js" type="text/javascript"></script>
    </body>
</html>
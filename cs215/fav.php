<!DOCTYPE html>
<?php
session_start();
require_once 'process/postInitial.php';
$_SESSION['actual'] = 'favorites';
$posts = getFavorites(); //check in the database for new posts everytime that the page is reloaded
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
                        <h2>My Favorites</h2>
                        <br />
                        <?php
                        if (!is_array($posts)) {
                            echo $posts;
                        } else {
                            for ($i = 0; $i < count($posts); $i++) {
                                echo $posts[$i]['html'];
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <script src="index.js" type="text/javascript"></script>
    </body>
</html>
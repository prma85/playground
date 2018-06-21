<?php include 'PostListVal.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="AssignmentStyleSheet.css" />
        <meta charset="utf-8">
        <script type = "text/javascript" src="PostRating.js"></script>
        <script type = "text/javascript" src="PostRepost.js"></script>
        <title>Homepage</title>
    </head>
    <body class="PL">
        <header>
            <h1> Welcome to your Feed!</h1>
            <span><h2>Logged in as: <?php echo $_SESSION['user']['user_name']; ?></h2></span>
        </header>

        <div class="Submit">
            <a href="postforum.php">Submit A Post </a>
        </div>
        <?php
        foreach ($Result as $p) {
            echo '<div class="Cont" id="post_' . $p["post_id"] . '">';
            echo '<div class="left">';
            echo '<img src="' . $p["user_PicName"] . '" />';
            echo '</div>'; //closes div left
            echo '<div class="right">';
            echo '<h5><br>' . $p["title"] . '</b></h5>';
            echo '<p>' . $p["content"] . '</p>';

            echo '<p>By User:<a href="UsrPage.php">' . $p["user_name"] . '</a></p>';
            echo '<span class="time-right"> @ "' . $p["timeS"] . '"</span>';
            echo '</div>'; //closes div right
            echo '<img src="' . $p["post_pic"] . '" />';
            echo '<br clear="all"';
            echo '<div class="sidebar">'; //like butons and replies
            echo '<a href="javascript:likePost(1,' . $p["post_id"] . ')" title="dislike" ><img src="upvote.png" id = "LikePost" /></a>';
            echo '<a href="javascript:likePost(0,' . $p["post_id"] . ')" title="dislike" ><img src="downvote.png" id = "LikePost"/></a>';
            echo '<a href="replyfor.php?post_id=' . $p["post_id"] . '" title="reply"><img src="repost.png" /></a>';
            echo '<span id="likes_' . $p["post_id"] . '">' . $p["likes"] . '</span>';
            echo '<p> Likes: ';
            if ($p["replies"] == 0) {
                echo '<span>0 Replies</span>';
            } else if ($p["replies"] == 1) {
                echo '<a href="PostReplyPage.php?post_id=' . $p["post_id"] . '"><span>1 Reply</span></a>';
            } else {
                echo '<a href="PostReplyPage.php?post_id=' . $p["post_id"] . '"><span>' . $p["replies"] . ' Replies</span></a>';
            }
            echo '</div>'; //closes div sidebar

            echo '</div>'; //closes div post
        }
        ?>





        <div class="Cont">

            <img src="armando.png" alt="An Armadillo">
            <p>Hello. Time to spend some time procrasntlka... procrastinat....  ahh screw it. Waste some time like an honest individual.</p>
            <p>A good site to waste. ahem spend some quality time is <a class = "LP" href="https://www.reddit.com">Reddit </a></p>
            <p> By User: anArmadillo
                <span class="time-right"> @ 13:05 - Today</span>
                <br>
                <button type="button" id = "but1" onclick = "ChangeImg(1)"><img class = "UP" class = "UP" src = "upvote.png"></button>
                <button type="button" id = "but2" onclick = "ChangeImg(2)"><img class = "UP" src = "downvote.png"></button>
                <button type="button"><img class = "UP" src = "repost.png"></button>
            <p> 0 Likes </p>
            <div class="Cont">
                <img src="mushroom.png" alt="The Wild Mushroom">
                <p> <a class = "LP" href="ArmadilloUsrPage.html">@ anArmadillo </a>, you really need to work on your CSS habits. All those hideous style sheets, not even the decency to make them external.</p>
                <p> By User: OnlyThinksinCSS
                    <span class="time-right"> @ 9:02 - Today</span>
                    <br>
                    <button type="button" id = "but4" onclick = "ChangeImg(4)"><img class = "UP" src = "upvote.png"></button>
                    <button type="button" id = "but5" onclick = "ChangeImg(5)"><img class = "UP" src = "downvote.png"></button>
                    <button type="button"><img class = "UP" src = "repost.png"></button>
                <p> 1 Downvote </p>
            </div>
        </div>

        <div class="Cont">
            <img src="Imperial.png" alt="Empire Did Nothing Wrong">
            <p> It's being a long time but I have to get this off my chest.</p>
            <p>Han Shot First!</p>
            <p> By User: Empire Did Nothing Wrong
                <span class="time-right"> @ 8:15 - Today</span>
                <br>
                <button type="button" id = "but7" onclick = "ChangeImg(7)"><img class = "UP" src = "upvote.png"></button>
                <button type="button" id = "but8" onclick = "ChangeImg(8)"><img class = "UP" src = "downvote.png"></button>
                <button type="button"><img class = "UP" src = "repost.png"></button>
            <p> 2 Likes </p>
        </div>
        <div class="Cont">
            <img src="Potter.png" alt="Some Muggle">
            <H4> Tom Guessing Riddle: </h4>
            <h4> |Dumbledore kills Snape. Err.... no wait. It's the other way around. |</h4>
            <p> Err.... no wait. It's the other way around.</p>
            <p> By User: Some Muggle
                <span class="time-right"> @ 7:35 - Today</span>
                <br>
                <button type="button" id = "but10" onclick = "ChangeImg(10)"><img class = "UP" src = "upvote.png"></button>
                <button type="button" id = "but11" onclick = "ChangeImg(11)"><img class = "UP" src = "downvote.png"></button>
                <button type="button"><img class = "UP" src = "repost.png"></button>
            <p> 2 Likes </p>
        </div>
        <div class="Cont">
            <img src="robot.png" alt="Tom Guessing A Riddle">
            <H4> Dumbledore kills Snape.
                <br> By User: Tom Guessing A Riddle </H4>
            <p> Why would you spoil it for my optical sensors? </p>
            <span class="time-right"> @ 7:00 - Today </span>
            <p> By User: TotallyNotABot </p>
            <button type="button" id = "but13" onclick = "ChangeImg(13)"><img class = "UP" src = "upvote.png"></button>
            <button type="button" id = "but14" onclick = "ChangeImg(14)"><img class = "UP" src = "downvote.png"></button>
            <button type="button"><img class = "UP" src = "repost.png"></button>
            <p> 1 Like </p>
        </div>
    </aside>




    <footer>Copyright &copy; Shrey Shah </footer>
</body>
</html>

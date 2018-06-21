<?php $data = $_SESSION['data']; ?>
<aside>
    <div class="user_details box">
        <div><img src="<?php echo $user['avatar']; ?>" /></div>
        <p>Welcome back, <b><?php echo $user['f_name'] . ' ' .$user['l_name']; ?></b></p>
        <form method="post" action="process/user.php">
            <input type="hidden" name="task" value="logout" />
            <input type="submit" class="button is-primary" value="Log out" />
        </form>
            
    </div>
    <div class="box">
        <input type="button" id="btn_update" onclick="autoUpdate(this)" class="button is-info" value="Auto-update: ON" />
    </div>

    <div class="user_statistics box">
        <h2>User's Statistics</h2>
        <p>Number of posts (my): <b><?php echo $data['posts']; ?></b></p>
        <p>Number of posts (all): <b><?php echo $data['posts_all']; ?></b></p>
        <p>Number of comments (my): <b><?php echo $data['comments']; ?></b></p>
        <p>Number of comments (all): <b><?php echo $data['comments_all']; ?></b></p>
        <p>Number of users: <b><?php echo $data['users']; ?></b></p>
        <p>Number of my favorites: <b><?php echo $data['users']; ?></b></p>
    </div>

</aside>
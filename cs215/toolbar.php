<?php
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    header('location: index.php');
}
if (isset($_SESSION['actual'])) {
    $actual = $_SESSION['actual'];
} else {
    $actual = 'home';
}
?>
<section class="nav">
    <div class="container">
        <h1>CS 215 Social Network</h1>
        <div class="user_menu">
            <ul>
                <li class="<?php echo ($actual == 'home' ? 'active' : ''); ?>" ><a href="initial.php">Home</a></li>
                <li class="<?php echo ($actual == 'favorites' ? 'active' : ''); ?>"><a href="fav.php">My Favorites</a></li>
                <li class="<?php echo ($actual == 'details' ? 'active' : ''); ?>"><a href="details.php">My Details</a></li>
            </ul>
        </div>
    </div>
</section>

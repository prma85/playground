<?php
session_start();
if (isset($_POST["email"]) && $_POST["email"]) {
    $emailS = trim($_POST["email"]);
    $passwordS = trim($_POST["psw"]);

    $db = new mysqli("localhost", "root", "", "tutor");
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $q1 = "SELECT * FROM user WHERE user_email = '$emailS' and user_password = '$passwordS'";
    $r1 = $db->query($q1);

    // if the email address is already taken.
    if ($r1->num_rows > 0) {
        while ($row = $r1->fetch_assoc()) {
            $user[] = $row;
        }
        $_SESSION['user'] = $user[0];
        $db->close();
        header("Location: posts.php");
    } else {
        echo 'Invalid user or password';
    }
} else {
    echo 'Access Denied';
}

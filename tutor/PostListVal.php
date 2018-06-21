<?php

session_start();

$db = new mysqli("localhost", "shah227s", "Shrey1997!", "shah227s");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$q1 = "SELECT * FROM post,user where post.user_id = user.user_id ORDER BY timeS LIMIT 20";
$r1 = $db->query($q1);
$Result = array();

if ($r1->num_rows > 0) {
    while ($row = $r1->fetch_assoc()) {

        $q2 = "SELECT count(*) as value from repost where post_id = " . $row['post_id'];
        $r2 = $db->query($q2);
        while ($row2 = $r2->fetch_assoc()) {
            $row["replies"] = $row2["value"];
        }

        $q4 = "SELECT * from ratings where post_id = " . $row['post_id'] . " and rating = 1";
        $r4 = $db->query($q4);

        $q5 = "SELECT * from ratings where post_id = " . $row['post_id'] . " and rating = 0";
        $r5 = $db->query($q5);

        $row['likes'] = $r4->num_rows - $r5->num_rows;

        $Result[] = $row;
    }


//  var_dump($_SESSION);die;
    $db->close();
} else {
    echo "No posts found!";
}
?>

<?php

session_start();
$user_id = $_SESSION['user']['user_id'];
$post_id = $_POST['post_id'];
$Rating = $_POST['rating'];

$result = array('status' => '', 'likes' => 0, 'error' => '');


$db = new mysqli("localhost", "shah227s", "Shrey1997!", "shah227s");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
//$q1 = "SELECT * from ratings where post_id = ".$post_id. " AND user_id = " .$user_id. " AND rating =".$Rating;
$q1 = "SELECT * from ratings where post_id = " . $post_id . " AND user_id = " . $user_id;

//echo '<pre>';
$r1 = $db->query($q1);
if ($r1->num_rows > 0) {
    $row = $r1->fetch_assoc();
    if ($row['rating'] == $Rating) {
        //echo 'Cannot like/dislike more than once';
        $result['status'] = "error";
        $result['error'] = "Cannot like/dislike more than once";
        
    } else {
        $q2 = "UPDATE ratings SET rating = " . $Rating . " where post_id = " . $post_id . " AND user_id = " . $user_id;
        $r1 = $db->query($q2);
        
        $result['status'] = "ok";
    }
} else {
    $q3 = "INSERT INTO ratings (post_id, user_id, rating)
    VALUES ('$post_id', '$user_id', '$Rating')";
    $r1 = $db->query($q3);
    
    $result['status'] = "ok";
}


$q4 = "SELECT * from ratings where post_id = " . $post_id . " and rating = 1";
$r4 = $db->query($q4);

$q5 = "SELECT * from ratings where post_id = " . $post_id . " and rating = 0";
$r5 = $db->query($q5);

$result['likes'] = $r4->num_rows - $r5->num_rows;

$db->close();

echo json_encode($result);


?>

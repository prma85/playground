<?php

session_start();

$db = new mysqli("localhost", "shah227s", "Shrey1997!", "shah227s");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$q1 = "SELECT post_id FROM post ORDER BY timeS LIMIT 20";
$r1 = $db->query($q1);
if ($r1->num_rows > 0) {
    while ($row = $r1->fetch_assoc()) {

        $q4 = "SELECT * from ratings where post_id = " . $row['post_id'] . " and rating = 1";
        $r4 = $db->query($q4);

        $q5 = "SELECT * from ratings where post_id = " . $row['post_id'] . " and rating = 0";
        $r5 = $db->query($q5);

        $row['likes'] = $r4->num_rows - $r5->num_rows;

        $Result[] = $row;
    }
    
    $db->close();
    echo json_encode($Result);
    


//  var_dump($_SESSION);die;
    $db->close();
}

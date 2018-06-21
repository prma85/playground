<?php

require_once 'db.php';
require_once 'file.php';
require_once 'postInitial.php';

$task = filter_input(INPUT_POST, 'task', FILTER_SANITIZE_STRING); // improve security

if ($task) {
    $data = array();
    foreach ($_POST as $k => $i) {
        $data[$k] = filter_input(INPUT_POST, $k, FILTER_SANITIZE_STRING);
    }

    switch ($task) {
        case 'reply':
            reply($data);
            break;
        case 'delete':
            delete($data);
            break;
        case 'new':
            $file = $_FILES;
            newPost($data, $file);
            break;
        case 'favorite':
            favorite($data);
            break;
        case 'update':
            update($data);
            break;
        case 'login':
            break;
        default :
            die('Access Denied');
            break;
    }
} else {
    die('Access Denied'); //you do it for security, to avoid direct access
}

function reply($data) {
    
}

function newPost($data, $file) {
    $post = $data['message'];
    $img = NULL;
    $msg = '';
    $user = $_SESSION['user']['id'];
    $db = new db();

    //check if exist a file in the submission
    if (isset($file["image"]) && $file["image"]['name']) {
        $temp = saveFile($file["image"], '../posts/', true);
        //check for errors
        if (strpos($temp, '[error]')) {
            echo $temp;
            $msg = str_replace('[error]', '', $temp);
        } else {
            $img = $temp;
        }
    }

    if ($img != NULL && $img != 'NULL') {
        $sql = 'INSERT INTO `posts`(`text`, `image`, `user_id`) VALUES ("' . $post . '","' . $img . '",' . $user . ')';
    } else {
        $sql = 'INSERT INTO `posts`(`text`, `user_id`) VALUES ("' . $post . '",' . $user . ')';
    }

    $result = $db->execute($sql, 'update');
    if (!$result) {
        $msg = 'You can not put the same post twice!';
        if ($img) {
            //delete the avatar
            unlink('../' . $img);
        }
    } else {
        $_SESSION['posts'] = getPosts('0, 10', false, true);
    }

    $sql2 = "SELECT * FROM 
                (SELECT count(*) as posts_all FROM posts) as a, 
                (SELECT count(*) as posts FROM posts WHERE user_id = " . $user . ") as b,
                (SELECT count(*) as comments FROM comments) as c, 
                (SELECT count(*) as comments_all FROM comments WHERE user_id = " . $user . ") as d,
                (SELECT count(*) as users FROM users) as e, 
                (SELECT count(*) as favorites FROM favorites WHERE user_id = " . $user . ") as f";

    $sts = $db->execute($sql2);
    $_SESSION['data'] = $sts[0];

    if (isset($data['ajax'])) {
        if ($msg) {
            echo $msg;
        } else {
            echo 'ok';
        }
    } else {
        $_SESSION['msg'] = $msg;

        header('location: ../initial.php');
    }
}

function favorite($data) {
    $id = $data['id'];
    $user = $_SESSION['user']['id'];
    $db = new db();

    $sql1 = 'SELECT * FROM favorites WHERE post_id=' . $id . ' and user_id = ' . $user;
    $r1 = $db->execute($sql1);

    if (count($r1) == 1 && $r1 != 'there is no result for your query') {
        $sql2 = 'DELETE FROM `favorites` WHERE `user_id` = ' . $user . ' and `post_id` = ' . $id;
    } else {
        $sql2 = 'INSERT INTO `favorites`(`user_id`, `post_id`) VALUES (' . $user . ',' . $id . ')';
    }

    $r2 = $db->execute($sql2, 'insert');
    if ($r2) {
        echo 'ok';
    } else {
        echo 'Internal error, try again later';
    }
}

function update($data) {
    $id = $data['id'];
    $where = 'WHERE id > '.$id;
    getPosts('0, 10', true, true, $where);
}

function delete($data) {
    $user = $_SESSION['user']['id'];
    $post = $data['id'];
    $db = new db();

    $sql1 = 'SELECT * from posts where id = ' . $post . ' and user_id = ' . $user;
    $r1 = $db->execute($sql1);

    if (count($r1) == 1 && $r1 != 'there is no result for your query') {
        $sql2 = 'DELETE from posts where id = ' . $post . ' and user_id = ' . $user;
        $r2 = $db->execute($sql2, 'delete');
        if ($r2) {
            echo 'ok';
        } else {
            echo 'Internal error, try again later';
        }
    } else {
        echo "You do not have access to delete this post";
    }
}

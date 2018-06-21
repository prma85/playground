<?php

require_once 'db.php';
require_once 'file.php';

$task = filter_input(INPUT_POST, 'task', FILTER_SANITIZE_STRING); // improve security

if ($task) {
    $data = array();
    foreach ($_POST as $k => $i) {
        $data[$k] = filter_input(INPUT_POST, $k, FILTER_SANITIZE_STRING);
    }

    switch ($task) {
        case 'login':
            login($data);
            break;
        case 'signup':
            $file = $_FILES;
            signup($data, $file);
            break;
        case 'edit':
            $file = $_FILES;
            edit($data, $file);
            break;
        case 'logout':
            logout($data);
            break;
        case 'email':
            checkEmail($data);
            break;
        default :
            die('Access Denied');
            break;
    }
} else {
    die('Access Denied'); //you do it for security, to avoid direct access
}

function login($data) {
    $email = $data['email'];
    $pass = md5($data['password']);
    $db = new db();

    $sql = 'SELECT * FROM users WHERE email = "' . $email . '" and password = "' . $pass . '"';

    $user = $db->execute($sql);
    $result = 'The user or password is invalid. Try again!';

    if (is_array($user)) {
        unset($user[0]['password']);

        if ($user[0]['avatar'] == NULL || $user[0]['avatar'] == 'NULL') {
            $user[0]['avatar'] = 'style/noone.png';
        }

        $_SESSION['user'] = $user[0];

        $sql2 = "SELECT * FROM
                (SELECT count(*) as posts_all FROM posts) as a,
                (SELECT count(*) as posts FROM posts WHERE user_id = " . $user[0]['id'] . ") as b,
                (SELECT count(*) as comments FROM comments) as c,
                (SELECT count(*) as comments_all FROM comments WHERE user_id = " . $user[0]['id'] . ") as d,
                (SELECT count(*) as users FROM users) as e,
                (SELECT count(*) as favorites FROM favorites WHERE user_id = " . $user[0]['id'] . ") as f";

        $data = $db->execute($sql2);
        $_SESSION['data'] = $data[0];


        //require_once 'postInitial.php';
        //$_SESSION['posts'] = getPosts('0, 10', false, true);

        //var_dump($_SESSION);

        $result = 'ok';
    } else {
        return false;
    }

    echo $result;

    return true;
}

function signup($data, $file) {
    $password = md5($data['password']);
    $f_name = $data['f_name'];
    $l_name = $data['l_name'];
    $email = $data['email'];
    $avatar = 'NULL';
    $msg = '';

    //check if exist a file in the submission
    if (isset($file["avatar"]) && $file["avatar"]['name']) {
        $temp = saveFile($file["avatar"], '../users/');
        //check for errors
        if (strpos($temp, '[error]')) {
            echo $temp;
            $msg = str_replace('[error]', '', $temp);
        } else {
            $avatar = $temp;
        }
    }

    $sql = "INSERT INTO `users`(`f_name`, `l_name`, `email`, `password`, `avatar`) "
            . "VALUES ('" . $f_name . "','" . $l_name . "','" . $email . "','" . $password . "','" . $avatar . "')";

    $db = new db();
    $result = $db->execute($sql, 'insert');

    if (!$result) {
        $msg = 'Was not possible to complete the registration, verify your data and try again';
        if ($avatar) {
            //delete the avatar
            unlink('../' . $avatar);
        }
    } else {
        $msg .= 'Registration made with success. Please, make your login!';
    }

    $_SESSION['msg'] = $msg;

    header('location: ../index.php');
}

function edit($data, $file) {
    if (trim($data['password'])) {
        $password = ',`password`="' . md5($data['password']) . "' ";
    } else {
        $password = '';
    }
    $f_name = $data['f_name'];
    $l_name = $data['l_name'];

    $avatar = $data['avatar2'];
    $msg = '';

    var_dump($file);
    //check if exist a file in the submission
    if (isset($file["avatar"]) && $file["avatar"]['name']) {
        $temp = saveFile($file["avatar"]);
        //check for errors
        if (strpos($temp, '[error]')) {
            echo $temp;
            $msg = str_replace('[error]', '', $temp);
        } else {
            unlink('../' . $avatar);
            $avatar = $temp;
        }
    }

    $sql = "UPDATE `users` SET "
            . "`f_name`='" . $f_name . "',"
            . "`l_name`='" . $l_name . "',"
            . "`avatar`='" . $avatar . "' " . $password
            . "WHERE `id`=" . $data['id'];

    $db = new db();
    $result = $db->execute($sql, 'update');

    if (!$result) {
        $msg = 'Was not possible to complete the edition, verify your data and try again';
        if ($avatar) {
            //delete the avatar
            unlink('../' . $avatar);
        }
    } else {
        $_SESSION['user']['f_name'] = $f_name;
        $_SESSION['user']['l_name'] = $l_name;
        $_SESSION['user']['avatar'] = $avatar;

        $msg .= 'Update made with success!';
    }

    $_SESSION['msg'] = $msg;

    header('location: ../details.php');
}

function logout() {
    session_destroy();
    //session_abort();
    header('location: ../index.php');
}

function checkEmail($data) {
    $email = trim($data['email']);
    $db = new db();
    $sql = 'SELECT count(*) as total FROM users where email="' . $email . '"';
    $result = $db->execute($sql);
    $count = (int) $result[0]['total'];
    if ($count == 0) {
        echo 'ok';
    } else {
        echo 'This email is already registered, please, make your login or try again';
    }
}

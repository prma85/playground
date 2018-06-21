<?php

require_once 'db.php';

function getPosts($limit = '0, 10', $print = FALSE, $html = FALSE, $where = '') {
    $db = new db();
    if ($limit) {
        $limit = 'LIMIT ' . $limit;
    }

    $sql = 'SELECT * FROM posts ' . $where . ' ORDER BY created DESC ' . $limit;
    $posts = $db->execute($sql);
    $postsHTML = '';

    if (is_array($posts)) {
        for ($i = 0; $i < count($posts); $i++) {
            //get details of the user
            $sql2 = 'SELECT * FROM users WHERE id=' . $posts[$i]['user_id'];
            $user = $db->execute($sql2);
            unset($user[0]['password']);

            if ($user[0]['avatar'] == NULL) {
                $user[0]['avatar'] = 'style/noone.png';
            }

            $user[0]['full_name'] = $user[0]['f_name'] . ' ' . $user[0]['l_name'];

            $posts[$i]['user'] = $user[0];

            //get the number os comments
            $sql3 = 'SELECT count(*) as total FROM comments WHERE post_id=' . $posts[$i]['id'];
            $comments = $db->execute($sql3);
            $posts[$i]['comments'] = $comments[0]['total'];


            $posts[$i]['favorite'] = 'favorite';
            //check if is favorite
            $sql4 = 'SELECT * FROM favorites WHERE post_id=' . $posts[$i]['id'] . ' and user_id = ' . $_SESSION['user']['id'];
            $favorite = $db->execute($sql4);
            if (count($favorite) == 1 && $favorite != 'there is no result for your query') {
                $posts[$i]['favorite'] = 'unfavorite';
            }

            if ($html) {
                $posts[$i]['html'] = getPostHTML($posts[$i]);
            }
        }

        //var_dump($posts);
    }

    if ($print) {
        echo json_encode($posts);
    } else {
        return $posts;
    }
}

function getPostHTML($post) {
    $html = '';
    $html .= '<div class="content" id="post_' . $post["id"] . '">';
    $html .= '<div class="avatar_post">';
    $html .= '<img src="' . $post['user']['avatar'] . '" />';
    $html .= '</div>'; //closes avatar_post
    $html .= '<div class="content_post">';
    $html .= '<b>' . $post['user']['full_name'] . ' wrote:</b>';
    $html .= '<p>' . $post['text'] . '</p>';
    $html .= '</div>'; //closes content_post
    if (isset($post['image']) && $post['image'] != NULL && $post['image'] != 'NULL') {
        $html .= '<div class="post_img"><img src="' . $post['image'] . '" /></div>';
    }
    $html .= '<nav class="breadcrumb is-centered is-small has-bullet-separator"><ul>';
    $html .= '<li class="is-active"><a href="javascript:void(0);">' . $post['created'] . '</a></li>';
    $html .= '<li><a href="javascript:allComments(\'' . $post["id"] . '\')">' . $post['comments'] . ' comment(s)</a></li>';
    $html .= '<li><a class="favorite" id="fav_' . $post["id"] . '" href="javascript:markFavorite(\'' . $post["id"] . '\')">' . $post['favorite'] . '</a></li>';
    $html .= '<li><a href="javascript:replyPost(\'' . $post["id"] . '\')">reply</a></li>';
    if ($_SESSION['user']['id'] == $post['user']['id']) {
        $html .= '<li><a href="javascript:deletePost(\'' . $post["id"] . '\')">delete</a></li>';
    }
    $html .= '</ul></nav>'; //closes actions
    $html .= '<hr>';
    $html .= '</div>'; //closes content
    $html .= '<div class="clr"></div>';
    return $html;
}

function getFavorites() {
    $user = $_SESSION['user']['id'];
    $db = new db();
    $postList = array();

    $sql1 = 'SELECT * FROM favorites WHERE user_id = ' . $user;
    $r1 = $db->execute($sql1);

    if (count($r1) > 0 && $r1 != 'there is no result for your query') {
        for ($i = 0; $i < count($r1); $i++) {
            $postList[] = $r1[$i]['post_id'];
        }

        $where = 'WHERE id in (' . implode(',', $postList) . ') ';

        $result = getPosts(NULL, false, true, $where);
        return $result;
    } else {
        return 'no favorites yet';
    }
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'db.php';
mb_internal_encoding("UTF-8");
mb_regex_encoding("UTF-8");


if (isset($_POST["submit"])) {

    echo '<pre>';

    if (isset($_FILES["file"])) {

        $tableName = $_POST["table_name"];

        if (!$tableName) {
            die("the table name is required");
        }

        //if there was an error uploading the file
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
        } else {
            //Print file details
            echo "Upload: " . $_FILES["file"]["name"] . "<br />";
            echo "Type: " . $_FILES["file"]["type"] . "<br />";
            echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
            echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

            //if file already exists
            if (file_exists("upload/" . $_FILES["file"]["name"])) {
                echo $_FILES["file"]["name"] . " already exists. ";
            }

            $fileType = pathinfo(basename($_FILES["file"]["name"]), PATHINFO_EXTENSION);
            $filename = str_replace("." . $fileType, "", $_FILES["file"]["name"]);
            $filename_normal = normalize($filename);
            $now = new DateTime();
            $newFilename = $filename_normal . '_' . $now->getTimestamp() . '.' . $fileType;

            echo "New file name: " . $newFilename . "<br />";

            //move_uploaded_file($_FILES["file"]["tmp_name"], "temp/" . $newFilename);
            echo "Stored in: " . "temp/" . $newFilename . "<br />";

            echo '<hr>';

            $db = new db();

            $tmpName = $_FILES['file']['tmp_name'];
            $csvAsArray = array_map('str_getcsv', file($tmpName));

            // table = $filename_normal
            $create = "CREATE TABLE `" . $tableName . "` (
                        `id` int(10) NOT NULL AUTO_INCREMENT, ";

            $data = array_shift($csvAsArray);
            foreach ($data as $c) {
                $col = normalize($c);
                if (strlen($col) >= 63) {
                    die("Your Column name for " . $col . " is too big. It should be less than 64 chars");
                }
                $create .= "`" . $col . "` varchar(1024) NULL COMMENT '".$c."', ";
            }

            //$create = substr($create, 0, -2);
            $create .= " PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

            //var_dump($csvAsArray);
            //echo ($create);
            //die;
            $r0 = $db->execute("DROP TABLE IF EXISTS `" . $tableName . "`");
            $r1 = $db->execute($create);
            //$r2 = $db->execute("ALTER TABLE `" . $tableName . "` ADD PRIMARY KEY (`id`), MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;", "alter");

            //var_dump($csvAsArray);

            foreach ($csvAsArray as $k => $item) {
                $id = $k + 1;
                $sql = 'INSERT INTO `' . $tableName . '` VALUES (' . $id . ',';
                foreach ($item as $i) {
                    $sql .= '"'.str_replace('"', '\"', $i).'", ';
                    /*$temp = explode(",", $i);
                    $sql .= "'";
                     if (count($temp) > 1) {
                        $sql .= json_encode($temp);
                    } else {
                        $sql .= str_replace("'", "\'", $temp[0]);
                    }
                    $sql .= "', ";  */
                }

                $sql = substr($sql, 0, -2);
                $sql .= ')';
                $sql = str_replace("�", "-", $sql);
                //echo $sql . '<hr>';
                $db->execute($sql);
            }

            $_SESSION['table'] = $tableName;
        }
    } else {
        $_SESSION['table'] = $_POST["table"];
    }

    redirect('results.php');

    echo '</pre>';
} elseif (isset($_POST["task"])) {
    $data = $_POST;
    $task = $data['task'];
    switch ($task) {
        case "analysis": analysis($data);
            break;
        case "table": break;
        default : break;
    }
} else {
    die("RESTRICTED ACCESS");
}

function redirect($url) {
    ob_start();
    header('Location: ' . $url);
    ob_end_flush();
    die();
}

function analysis($data) {
    
}

function normalize($string) {
    mb_internal_encoding("UTF-8");
    mb_regex_encoding("UTF-8");

    $string = preg_replace("/[ÁÀÂÃÄ]/", "A", $string);
    $string = preg_replace("/[éèê]/", "e", $string);
    $string = preg_replace("/[ÉÈÊ]/", "E", $string);
    $string = preg_replace("/[íì]/", "i", $string);
    $string = preg_replace("/[ÍÌ]/", "I", $string);
    $string = preg_replace("/[óòôõö]/", "o", $string);
    $string = preg_replace("/[ÓÒÔÕÖ]/", "O", $string);
    $string = preg_replace("/[úùü]/", "u", $string);
    $string = preg_replace("/[ÚÙÜ]/", "U", $string);
    $string = preg_replace("/ç/", "c", $string);
    $string = preg_replace("/Ç/", "C", $string);
    $string = preg_replace("/[][><}{)(:;,!?*%~^`#@]/", "", $string);
    $string = str_replace('&', '-and-', $string);
    $string = preg_replace("/ /", "_", $string);
    $string = trim(preg_replace('/[^\w\d_ -]/si', '', $string)); //remove all illegal chars
    $string = strtolower($string);

    return $string;
}

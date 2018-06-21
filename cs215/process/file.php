<?php

function saveFile($file, $target_dir = '../tmp/', $date = false) {

    // get all the informations about the file
    // If the file exist, define the main variables
    $filename_temp = basename($file["name"]);
    //you can use a function here to remove the space and illegal chars from the filename
    $filename_normal = normalize($filename_temp);
    $imageFileType = pathinfo(basename($file["name"]), PATHINFO_EXTENSION);

    if ($date) {
        $now = new DateTime();
        $filename = str_replace($imageFileType, '_'.$now->getTimestamp().'.' . $imageFileType, $filename_normal);
    } else {
        $filename = str_replace($imageFileType, '.' . $imageFileType, $filename_normal);
    }
    $target_file = $target_dir . $filename;

    //echo "target file: ".$target_file;

    $uploadOk = 1; // it will be used to record if a error occur
    //var_dump($imageFileType);
    // Check if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    $msg = '';
    if ($check !== false) {
        //echo "<br />File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $msg = "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $msg = "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $msg .= " Your file was not uploaded. [error]";
        return $msg;
        // if everything is ok, try to upload file
    } else {
        //echo $target_file;
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            //echo "<br />The file " . basename($_FILES["myFile"]["name"]) . " has been uploaded.";
            //echo "<br />Link for the image:<a href='$target_file'>$target_file</a>";
            return str_replace('../', '', $target_file);
        } else {
            $msg = " Sorry, there was an error uploading your file. [error]";
            return $msg;
        }
    }
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

<?php
/*
 * Example of file Upload
 * 
 * Created by Paulo Andrade
 * martinsp@uregina.ca
 */

// FILE PROCESSING FUNCTION
//check if existe the file in the submission
if (!isset($_FILES["myFile"])) {
    echo 'No file sent';
} else {
    // get all the informations about the file
    echo '<pre>'; //format the output
    var_dump($_FILES);

    // If the file exist, define the main variables
    $target_dir = "temp/";
    $filename = basename($_FILES["myFile"]["name"]);
    //you can use a function here to remove the space and illegal chars from the filename
    $filename = normalize($filename);
    $imageFileType = pathinfo(basename($_FILES["myFile"]["name"]), PATHINFO_EXTENSION);
    $filename = str_replace($imageFileType, '.'.$imageFileType, $filename);

    $target_file = $target_dir . $filename;
    
    echo "target file: ".$target_file;

    $uploadOk = 1; // it will be used to record if a error occur
    var_dump($imageFileType);

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["myFile"]["tmp_name"]);
    if ($check !== false) {
        echo "<br />File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "<br />File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "<br />Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<br />Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["myFile"]["tmp_name"], $target_file)) {
            echo "<br />The file " . basename($_FILES["myFile"]["name"]) . " has been uploaded.";
            echo "<br />Link for the image:<a href='$target_file'>$target_file</a>";
        } else {
            echo "<br />Sorry, there was an error uploading your file.";
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

    return $string;
}
?>
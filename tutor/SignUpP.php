<?php

$validateS = true;
$error = "";
$reg_Email = "/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/";
$reg_Pswd = "/^(\S*)?\d+(\S*)?$/";
$reg_Bday = "/^\d{1,2}\/\d{1,2}\/\d{4}$/";
$emailS = "";
$dateS = "mm/dd/yyyy";
$reg_UN = "/^[a-zA-Z0-9_-]+$/";

//var_dump($_FILES);
//var_dump($_POST);
//die;

// FILE PROCESSING FUNCTION
//check if existe the file in the submission
if (!isset($_FILES["fileToUpload"])) {
    echo 'No file sent';
} else {
    // get all the informations about the file
    echo '<pre>'; //format the output
    var_dump($_FILES);

    // If the file exist, define the main variables
    $target_dir = "uploads/";
    $filename = basename($_FILES["fileToUpload"]["name"]);
    //you can use a function here to remove the space and illegal chars from the filename
    $filename = normalize($filename);
    $imageFileType = pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION);
    $filename = str_replace($imageFileType, '.'.$imageFileType, $filename);

    $target_file = $target_dir . $filename;
    
    echo "target file: ".$target_file;

    $uploadOk = 1; // it will be used to record if a error occur
    var_dump($imageFileType);

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
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
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "<br />The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            echo "<br />Link for the image:<a href='$target_file'>$target_file</a>";
        } else {
            echo "<br />Sorry, there was an error uploading your file.";
        }
    }
}



if (isset($_POST["submittedS"]) && $_POST["submittedS"]) {

       
    $emailS = trim($_POST["email"]);
    $dateS = trim($_POST["dob"]);
    $passwordS = trim($_POST["pass"]);
    $Conpass = trim($_POST["pass2"]);
    $userN = trim($_POST["username"]);

    $db = new mysqli("localhost", "root", "", "tutor");
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $q1 = "SELECT * FROM user WHERE user_email = '$emailS'";
    $r1 = $db->query($q1);


    // if the email address is already taken.
    if ($r1->num_rows > 0) {
        $validateS = false;
    } else {
        $emailMatch = preg_match($reg_Email, $emailS);
        if ($emailS == null || $emailS == "" || $emailMatch == false) {
            $validateS = false;
            print_r('Email not valid');
        }


        $pswdLenS = strlen($passwordS);
        $pswdMatch = preg_match($reg_Pswd, $passwordS);
        if ($passwordS == null || $passwordS == "" || $pswdLenS < 3 || $pswdMatch == false) {
            $validateS = false;
            print_r('Password not valid');
        }

        $bdayMatch = preg_match($reg_Bday, $dateS);
        if ($dateS == null || $dateS == "" || $bdayMatch == false) {
            $validateS = false;
            print_r('Date not valid');
        }
        $userNMatch = preg_match($reg_UN, $userN);
        if ($userN == null || $userN == "" || $userNMatch == false) {
            $validateS = false;
            print_r('Userid not valid');
        }
        if ($passwordS != $Conpass || $Conpass == "" || $Conpass == null) {
            $validateS = false;
        }
    }
    
    $newPass = md5($passwordS);

    if ($validateS == true) {
        $dateFormatS = date("Y-m-d", strtotime($dateS));

        $q2 = "INSERT INTO user (user_email, user_password, user_name, user_DOB, user_PicName)
VALUES ('$emailS', '$newPass', '$userN', '$dateS', '$target_file')";
        $r2 = $db->query($q2);

        if ($r2 === true) {
            header("Location: loginpage.php");
            $db->close();
            exit();
        }
    } else {
        $errorS = "Email address is not available. Signup failed.";
        $db->close();
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

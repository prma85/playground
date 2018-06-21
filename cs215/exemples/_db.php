<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mysql
 *
 * @author paulo
 */
class db {

    var $conn;

    //create a function to make the initial conection
    //you can put the defaul values or send the values by parameters
    function connect($user = 'root', $password = 'root', $host = '127.0.0.1', $database = 'test') {
        $this->conn = mysqli_connect($host, $user, $password, $database);

        if (mysqli_connect_errno() || !$this->conn) {
            echo ("Connection failed: <br />" + mysqli_error());
        }

        return $this->conn;
    }

    function close() {
        mysqli_close($this->conn);
    }
 
    function execute($sql, $type = 'select') {
        if (!$this->conn) {
            $c = connect();
        }

        $result = mysqli_query($db, $query);

        if ($type == 'select') {
            if ($num_rows = mysqli_num_rows($result) == 0) {
                mysqli_free_result($result);
                $result = 'there is no result for your query';

                //if there is a result, return a array
            } else {
                $temp = array();
                while ($row = $result->fetch_assoc()) {
                    $temp[] = $row;
                }
                mysqli_free_result($result);
                $result = $temp;
            }
        }

        $this->close();
        return $result;
    }

}

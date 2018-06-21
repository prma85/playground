<?php

if (session_id() == '') {
    session_start();
}

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

    public $conn = false;

    //create a function to make the initial conection
    //you can put the defaul values or send the values by parameters
    //public function connect($user = 'u833782574_cs215', $password = '123456', $host = 'mysql.hostinger.com.br', $database = 'u833782574_cs215') {
    public function connect($user = 'root', $password = '', $host = 'localhost', $database = 'excel') {
        $mysqli = mysqli_connect($host, $user, $password, $database);

        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') '
                    . $mysqli->connect_error);
        }

        return $mysqli;
    }
    
    public function select($sql) {
        return db::execute($sql, "select");
    }

    public function execute($sql, $type = false, $debug = false) {
        echo '<pre>';
        $conn = db::connect();

        $rows = $conn->query($sql);
        if ($debug) {
            var_dump($rows);
        }

        if (mysqli_error($conn)) {
            echo mysqli_error($conn);
            echo $sql.'<hr />';
            return false;
        }

        // missing select

        if ($type == 'select') {
            if ($num_rows = mysqli_num_rows($rows) == 0) {
                $result = 'there is no result for your query';

                //if there is a result, return a array
            } else {
                $temp = array();
                while ($row = $rows->fetch_assoc()) {
                    $temp[] = $row;
                }
                $result = $temp;
                if ($debug) {
                    var_dump($result);
                }
            }
            mysqli_free_result($rows);
        } else {
            $result = $rows;
        }
        echo '</pre>';

        mysqli_close($conn);
        return $result;
    }

}

<?php
$result = array();
$result[] = array('name' => 'Paulo', 'email' => 'martinsp@uregina.ca');
$result[] = array('name' => 'Jhon Snow', 'email' => 'js@got.ca');


//echo '<pre>';

//var_dump($result);

$json = json_encode($result);
echo $json;

 ?>

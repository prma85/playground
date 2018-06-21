<?php
require_once ('Model/indicadores.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html; charset=utf-8');
setlocale(LC_CTYPE,"pt_BR");
$i = new indicadoresGerenciais();
$result = $i->jsonFiles();




header('Content-Type', 'application/json;charset=utf-8');
echo json_encode($result);


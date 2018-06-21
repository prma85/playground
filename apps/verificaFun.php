<?php
require ('configuration.php');
GLOBAL $config;
$config = new JConfig;

$db = new UserCagece;
$connMysql = $db->connMysql();
$usuarios = $db->selectMysql('select * from bthao_users');

foreach ($usuarios as $i) {
	$sql = 'SELECT * from col_colaborador where LOWER(TRIM(COL_DSC_LOGIN)) = LOWER(\''.$i->username.'\') order by col_cod_matricula';	
	$result = $db->selectOracle($sql);
	if ($i->id !='42') {
		if ($result == null ) { 
			$sql = "UPDATE bthao_users SET block = 1 where id = ".$i->id;
			$db->selectMysql($sql, true);
		} elseif ($result->SIF_COD_SITUACAO_FUNCIONAL != '1'){
			$sql = "UPDATE bthao_users SET block = 1 where id = ".$i->id;
			$db->selectMysql($sql, true);
		}
	}
}

echo "Atualização realizada com sucesso";
mysql_close($connMysql);


class UserCagece {
	function connMysql(){
		GLOBAL $config;
		if(!($conn = mysql_connect($config->host,$config->user,$config->password))) { // editar host, usuario, senha
			print_r ("Não foi possível estabelecer uma conexão com o gerenciador MySQL. Favor Contactar o Administrador.");
			exit;
		} else { 
			echo 'Conexão com o servidor feita com Sucesso <br/>';
		}
		
		if(!($db=mysql_select_db($config->db,$conn))) { // editar para o seu banco de dados
			print_r ("Não foi possível estabelecer uma conexão com o banco selecionado (".$config->db."). Favor Contactar o Administrador.");
			exit;
		} else { 
			print_r ("O Banco ".$config->db." foi selecionado <br/>");
		}
		
		return $conn;
	}
		
	function selectMysql($sql, $update=null){	
		$query = mysql_query($sql) or die(mysql_error());
		
		if ($update == null) {
			$query_rows = mysql_query($sql) or die(mysql_error());
			$num = mysql_num_fields($query_rows);
			
			for($y = 0; $y < $num; $y++){ 
				$names[$y] = mysql_field_name($query_rows,$y);
			}
			
			for($k=0;$resultado = mysql_fetch_array($query);$k++){
				$resultados[$k] = new StdClass;
				for($i = 0; $i < $num; $i++){ 
					$resultados[$k]->$names[$i] = $resultado[$names[$i]];
				}
			}
			return $resultados; // retorna um array com os resultados da consulta
		} else {
			return true;
		}
	}

	function conn($options = array()){
		if (empty($options)) {
			$options['host'] = '172.25.131.98';
			$options['user'] = 'apl_siga';
			$options['password'] = 'siga_apl';
			$options['sid'] = 'ORAERP';
			$options['port'] = '1521';
		}
		
		if (!function_exists('oci_connect')){
			$response->status = JAUTHENTICATE_STATUS_FAILURE;
			$response->error_message = JText::_('JLIB_DATABASE_ERROR_ADAPTER_MYSQLI');
			return false;
		}
		
		/* @var $oracle conexão com oracle */
		$conect = oci_connect($options['user'], $options['password'], $options['host'].":".$options['port']."/".$options['sid'],'AL32UTF8');
		
		if (!$conect) {
			$e = oci_error();
			$response->status = JAUTHENTICATE_STATUS_FAILURE;
			$response->error_message = trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}
		
		return $conect;
	}

	function selectOracle($sql, $conn = NULL){
		if ($conn == NULL) {
			$conn = self::conn();
		} else {
			$conn = self::conn($conn);
		}
		
		$prepare = oci_parse($conn,$sql);
		oci_execute($prepare);
		
		$list = array ();
		$i = 0;
		
		while ($result = oci_fetch_object($prepare,OCI_ASSOC)){
			$list[$i] = $result;
			$i++;
		}
		
		if (empty($list)){
			$list = NULL;
		}
		
		if (count($list) == 1) {
			$list = $list['0'];
		} else {
			$idFinal = count($list)-1;
			$list = $list[$idFinal];
		}
		
		oci_close($conn);
		
		return $list;
	}
}
?>

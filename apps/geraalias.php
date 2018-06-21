<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" dir="ltr" >
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="generator" content="Joomla! - Open Source Content Management" />
  <title>Gerador de SQL para unidades</title>
</head>
<body>

<?php
require 'configuration.php';
GLOBAL $c;
$c = new JConfig();

// Função para pegar dados da tabela 
function conn() {
	GLOBAL $c;
	
	if(!($conn = mysql_connect($c->host,$c->user,$c->password))) { // editar host, usuario, senha
		print_r ("Não foi possível estabelecer uma conexão com o gerenciador MySQL. Favor Contactar o Administrador.");
		exit;
	} else { 
		echo 'Conexão com o servidor feita com Sucesso <br/>';
	}
	
	if(!($db=mysql_select_db($c->db,$conn))) { // editar para o seu banco de dados
		print_r ("Não foi possível estabelecer uma conexão com o banco selecionado ({$c->db}). Favor Contactar o Administrador.");
		exit;
	} else { 
		print_r ("O Banco {$c->db} foi selecionado <br/>");
	}
	
	return $conn;
}

function select($tabela,$campo,$where=NULL,$order=NULL){
	
	GLOBAL $c;
	
	$conn = conn();
	
	$sql = "SELECT {$campo} FROM {$c->dbprefix}{$tabela} {$where} {$order}";
	$query = mysql_query($sql) or die(mysql_error());
	$sql_rows = "SELECT {$campo} FROM {$c->dbprefix}{$tabela} {$where}";
	
	$query_rows = mysql_query($sql_rows) or die(mysql_error());
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
	
	mysql_close($conn);
	return $resultados; // retorna um array com os resultados da consulta
}


// Inicializa a função
$k2 = select("k2_items","id,alias",null,null);
mb_internal_encoding("UTF-8");
mb_regex_encoding("UTF-8");

$array1 = array(   "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );
$array2 = array(   "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );

//echo '<pre>';



//echo '<hr />Geração dos menus types<hr />';
$conn = conn();

foreach ($k2 as $i ) {
	$toClean = str_replace( $array1, $array2, $i->alias );
	$toClean = str_replace('&', '-and-', $toClean);
	$toClean = trim(preg_replace('/[^\w\d_ -]/si', '', $toClean));//remove all illegal chars
	$toClean = str_replace(' ', '-', $toClean);
	$toClean = str_replace('--', '-', $toClean);
	$i->novoalias = strtolower($toClean);
	
	
	mysql_query("UPDATE  `".$c->db."`.`".$c->dbprefix."k2_items` SET  `alias` =  '".$i->novoalias."' WHERE  `".$c->dbprefix."k2_items`.`id` =".$i->id);
}
echo 'itens atualizados';
mysql_close($conn);

echo '</pre>';

?>
</body>
</html>
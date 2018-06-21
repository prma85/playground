<?php
require_once ('../configuration.php');

GLOBAL $config;
GLOBAL $log;

//inicia as variaveis do banco de dados do joomla
$config = new JConfig;


// Abre ou cria o arquivo ramais.log
// "a" representa que o arquivo é aberto para ser escrito
//$log = fopen("/var/www/html/logs/eleicao.log", "a");
//fwrite($log, "--------- Inicio do processo ---------\r\n\r\n");

//gera data de execursão
//$data = date('l dS \of F Y h:i:s A');
//echo "Executado em: ".$data.". ";

//começa a gravar informações no log
//fwrite ($log,"Executado em: ".$data." \r\n");


//conecta ao banco de dados
if(!($link = mysql_connect($config->host,$config->user,$config->password))) {
   echo ("Nao foi possivel estabelecer uma conexao com o gerenciador MySQL. Favor Contactar o Administrador. ");
   exit;
} else { 
	echo 'Conexao feita com Sucesso. '; 
	//mysql_set_charset('utf8',$link);
	//fwrite ($log,"Conexao feita com Sucesso. \r\n");
}
if(!($con=mysql_select_db($config->db,$link))) {
   echo ("Nao foi possivel estabelecer uma conexao com o gerenciador MySQL. Favor Contactar o Administrador. ");
   exit;
} else { 
	echo ("O Banco '".$config->db."' foi selecionado. ");
	//fwrite ($log,"O Banco '".$config->db."' foi selecionado. \r\n");
	//chama as funções, caso tenha se conectado ao banco de dados
	geraColaboradorDestaque();
	mysql_close();
}


function geraColaboradorDestaque(){
	GLOBAL $config;
	GLOBAL $log;
	
	$tabela = "eleicao";
	$tDefault = "0000-00-00 00:00:00";
	$start = "2014-12-02 08:00:00";
	$end = "2014-12-03 18:00:00";
	$ano = date('Y');
	$assunto = 'Gente que Surpreende '.$ano;
        $assunto .= ' - 2o. Turno';
	$list = array();
	$params = "{\"only_registered\":\"1\",\"one_vote_per_user\":\"1\",\"ip_check\":\"0\",\"show_component_msg\":\"1\",\"allow_voting\":\"0\",\"show_what\":\"0\",\"show_hits\":\"0\",\"show_voters\":\"0\",\"show_times\":\"1\",\"show_dropdown\":\"0\",\"show_title\":\"1\",\"opacity\":\"90\",\"bg_color\":\"ffffff\",\"circle_color\":\"505050\",\"pieX\":\"100%\",\"pieY\":\"400\",\"start_angle\":\"55\",\"radius\":\"150\",\"gradient\":\"1\",\"no_labels\":\"0\",\"show_zero_votes\":\"1\",\"animation_type\":\"bounce\",\"bounce_dinstance\":\"30\",\"bg_image\":\"-1\",\"bg_image_x\":\"left\",\"bg_image_y\":\"top\",\"font_size\":\"11\",\"font_color\":\"404040\",\"title_lenght\":\"30\",\"chartX\":\"100%\",\"optionsFontSize\":\"12\",\"barHeight\":\"15\",\"barBorder\":\"1px solid #000000\",\"bgBarColor\":\"f5f5f5\",\"bgBarBorder\":\"1px solid #cccccc\"}";

	
	$result = mysql_query("SELECT distinct(unidade) FROM $tabela order by unidade") or die(mysql_error());
	$values = array();
    for ($i=0; $i<mysql_num_rows($result); ++$i)
        array_push($values, mysql_result($result,$i));

		
	echo "<br />Criando enquetes para ".$ano."<br />";
	foreach ($values as $v) {
		$title = $assunto . " - ".$v;
		$alias = normalize($title);
		$sql =  "INSERT INTO  `".$config->dbprefix."acepolls_polls` (`title`,`alias`,`checked_out`,`checked_out_time`,`published`,`publish_up`,`publish_down`,`params`,`access`,`lag`) VALUES ( '$title',  '$alias',  '0',  '$tDefault',  '1',  '$start',  '$end', '$params', '1',  '1440')";
		//echo $sql."<br />";
		mysql_query($sql) or die(mysql_error());
		$list[mysql_insert_id()] = $v;
		//$list[]=$v;
	}
	
	echo "<br />Adicionando pessoas em quem votar<br />";
	//var_dump($list);
	foreach ($list as $key=>$l) {
		echo "<br />Adicionando opções para  ".$l;
		$result2 = mysql_query("SELECT distinct(nome) FROM $tabela where unidade = '$l'  order by nome ;") or die(mysql_error());
		
		for ($i=0; $i<mysql_num_rows($result2); ++$i) {
			$nome =  (mysql_result($result2,$i));
			//var_dump($nome);
			$sql = "INSERT INTO ".$config->dbprefix."acepolls_options (`poll_id` ,`text` ,`link` ,`color` ,`ordering`) VALUES ('$key',  '$nome', NULL ,  'ffff99',  '".($i+1)."')";
			//echo $sql.';<br>';
			mysql_query($sql) or die(mysql_error());
		}
		
	   $title = $assunto . ' - ' . $l;
		
		addModulos($l, $key, $start, $end, $title);
	}
	echo "<br />Finalizado<br />";
	
	
	
}

function addModulos($unidade, $id, $start, $end, $title) {
	GLOBAL $config;
	echo "<br />Adicionando módulo para  ".$unidade;
	
	$position = "eleicao-".normalize($unidade);
	$params = "{\"moduleclass_sfx\":\" eleicao\",\"id\":\"$id\",\"ajax\":\"1\",\"show_poll_title\":\"1\",\"only_one_color\":\"0\",\"poll_bars_color\":\"cccccc\",\"poll_bars_border_color\":\"cccccc\",\"show_view_details\":\"0\",\"show_rel_article\":\"0\",\"rel_article\":\"http:\/\/www.cagece.com.br\",\"rel_article_window\":\"_self\",\"show_total\":\"0\",\"show_msg\":\"1\",\"show_detailed_msg\":\"1\",\"msg_date_format\":\"%d %b %Y - %H:%M \",\"cache\":\"0\",\"cache_time\":\"900\"}";
	$tDefault = "0000-00-00 00:00:00";
	
	$modulo = "INSERT INTO `".$config->dbprefix."modules` (`title`, `note`, `content`, `ordering`, `position`, `checked_out`, `checked_out_time`, `publish_up`, `publish_down`, `published`, `module`, `access`, `showtitle`, `params`, `client_id`, `language`) VALUES ('$title', '', '', 10, '$position', 0, '$tDefault', '$start', '$end', 1, 'mod_eleicao', 2, 1, '$params', 0, '*')";
	mysql_query($modulo) or die(mysql_error());
	$id = mysql_insert_id();
	$menu = "INSERT INTO `".$config->dbprefix."modules_menu` (`moduleid`, `menuid`) values ($id,0)";
	mysql_query($menu) or die(mysql_error());
}

function normalize ($toClean){
	mb_internal_encoding("UTF-8");
	mb_regex_encoding("UTF-8");
	
	$array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );
	$array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
	$toClean = str_replace( $array1, $array2, $toClean );
	
	$toClean = str_replace('&', '-and-', $toClean);
	$toClean = trim(preg_replace('/[^\w\d_ -]/si', '', $toClean));//remove all illegal chars
	$toClean = str_replace(' ', '-', $toClean);
	$toClean = str_replace('--', '-', $toClean);
	$toClean = strtolower($toClean);
	
	return $toClean;
}


//$datafim = date('l dS \of F Y h:i:s A');
//echo "Finalizado em: ".$datafim.". ";
//fwrite ($log,"Finalizado em: ".$data." \r\n");
//fwrite($log, "\r\n--------- Fim do processo ---------\r\n\r\n\r\n");
//fecha o arquivo de log
//fclose($log);
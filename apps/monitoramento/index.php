<?php
$host  = $_SERVER['HTTP_HOST'];
$page  = str_replace('index.php', '', rtrim($_SERVER['PHP_SELF'], "/\\"));
$uri = 'http://'.$host.$page;
$sys = '';
$stop = 'false';
if (!empty($_REQUEST)) {
	if (array_key_exists('sys',$_REQUEST)){ $sys = $_REQUEST['sys'];}
	if (array_key_exists('stop',$_REQUEST)){ $stop = $_REQUEST['stop'];}
}

switch ($sys) {
	case 'sgd':
		$url = "http://172.25.131.56:8080/sgd/SemAutenticacao_painelMonitoramento.do"; 
		$sys = 'sgd2';
		$time = '120';
		break;
	case 'sgd2':
		$url = "http://172.25.131.56:8080/sgd/SemAutenticacao_monitoramentoIndicador.do"; 
		$sys = 'otrs';
		$time = '120';
		break;
	case 'otrs':
		$url = $uri."otrs/";
		$sys = 'sgrgetic';
		$time = '120';
		break;
	case 'sgrgetic':
		$url = $uri."sgrgetic/";
		$sys = 'ani';
		$time = '30';
		break;
	case 'ani':
		$url = $uri."aniversariantes/";
		$sys = 'news';
		$time = '57';
		break;	
	case 'news':
		$url = $uri."noticias/";
		$sys = 'sgd';
		$time = '60';
		break;
	default:
		$url = $uri."aniversariantes/";
		$sys = 'sgd';
		$time = '120';
}

?>

<!DOCTYPE html>
<html lang="pt-br" dir="ltr" >
	<head>
		<title>Monitoramento GETIC</title>
		<?php if ($stop == 'false') {
			echo '<META HTTP-EQUIV="refresh" CONTENT="'.$time.'; URL='.$uri.'?sys='.$sys.'&stop=false">';
		} ?>
                <script>
                    if (window.innerHeight >= 780) {
                        window.location.replace("v2");
                    }
                </script>
		
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<meta http-equiv="Cache-control" content="no-cache">
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="expires" content = "-1" />
		
		<script type="text/javascript" src="js/main.js"></script>	
		
		<link rel="stylesheet" href="css/system.css" type="text/css" />
		<link rel="stylesheet" href="css/general.css" type="text/css" />
		<link rel="stylesheet" href="css/template.css" type="text/css" />
		<link rel="stylesheet" href="css/main.css" type="text/css" />
	</head>
	
	<body onload="UR_Start()">
		<div id="content">
			<div id="left">
			<iframe sandbox="allow-same-origin allow-scripts allow-popups allow-forms" frameborder="0" scrolling="no" src="<?php echo $url; ?>"></iframe>
			</div>
			
			<div id="right">
			<a href="<?php echo $uri; ?>?sys=sgd&stop=true" title="SGD"><img id="img1" src="img/bt-sistemas.png" /></a>
			<a href="<?php echo $uri; ?>?sys=otrs&stop=true" title="OTRS"><img id="img2" src="img/bt-suporte.png" /></a>
			<a href="<?php echo $uri; ?>?sys=mse&stop=true" title="MSE"><img id="img3" src="img/bt-servicos-executados.png" /></a>
			<a href="<?php echo $uri; ?>?sys=sgrgetic&stop=true" title="SGR"><img id="img4" src="img/bt-indicadores.png" /></a>
			<a href="<?php echo $uri; ?>?sys=ani&stop=true" title="Aniversariantes"><img id="img5" src="img/bt-aniversariantes.png" /></a>
			<a href="<?php echo $uri; ?>?sys=news&stop=true" title="RSS"><img id="img6" src="img/bt-rss.png" /></a>
			
			</div>
			
			<div id="bottom">
				<img id="logo" src="img/logo.png"  />
				<p>GETIC - Gerência de Tecnologia da Informação e Comunicação</p>
				<a id="play" class="<?php echo $stop; ?>" href="<?php echo $uri."?sys=".$sys."&stop=false"; ?>"></a>
				<div id="datahora">
					<span id="hora"></span>
				</div>
				
			</div>
		</div>
	</body>
	
	<footer>
	</footer>
</html>
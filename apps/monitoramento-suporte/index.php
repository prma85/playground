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
	case 'nagvis':
		$url = "http://172.25.131.110/nagvis/frontend/nagvis-js/index.php?mod=Map&act=view&show=Fortigates&rotation=demo&rotationStep=0"; 
		$sys = 'otrs';
		$time = '250';
		break;

	case 'otrs':
		$url = $uri."otrs/";
		$sys = 'nagvis';
		$time = '100';
		break;	
	default:
		$url = $uri."otrs/";
		$sys = 'nagvis';
		$time = '100';
}

?>

<!DOCTYPE html>
<html lang="pt-br" dir="ltr" >
	<head>
		<title>Monitoramento GETIC</title>
		<?php if ($stop == 'false') {
			echo '<META HTTP-EQUIV="refresh" CONTENT="'.$time.'; URL='.$uri.'?sys='.$sys.'&stop=false">';
		} ?>
		
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
			<iframe sandbox="allow-same-origin allow-forms allow-scripts" frameborder="0" scrolling="no" src="<?php echo $url; ?>"></iframe>
			</div>
			
			<div id="right">
			<a href="<?php echo $uri; ?>?sys=otrs&stop=true" title="OTRS"><img id="img1" src="img/bt-sistemas.png" /></a>
			<a href="<?php echo $uri; ?>?sys=nagvis&stop=true" title="NAGVIS"><img id="img2" src="img/bt-nagvis.png" /></a>

			
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
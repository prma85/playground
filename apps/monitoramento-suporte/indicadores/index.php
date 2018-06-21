<?php
$host  = $_SERVER['HTTP_HOST'];
$page  = str_replace('index.php', '', rtrim($_SERVER['PHP_SELF'], "/\\"));
$uri = 'http://'.$host.$page;

?>

<!DOCTYPE html>
<html lang="pt-br" dir="ltr" >
	<head>
		<title>Indicadores GETIC</title>
		
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="Cache-control" content="no-cache">
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="expires" content = "-1" />
		
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">google.load('visualization', '1', {packages:['gauge']});</script>
		<script type="text/javascript" src="main.js"></script>

		<script type="text/javascript" src="../js/main.js"></script>	
		
		<link rel="stylesheet" href="../css/system.css" type="text/css" />
		<link rel="stylesheet" href="../css/general.css" type="text/css" />
		<link rel="stylesheet" href="../css/template.css" type="text/css" />
		<link rel="stylesheet" href="../css/main.css" type="text/css" />
		<link rel="stylesheet" href="main.css" type="text/css" />
	</head>
	
	<body>
		<div id="content">
			<div id="title">
				<img title="logo" src="logo.png"/>
				<h1>Indicadores Setoriais GETIC</h1>
				<div class="legenda">
					<p style="background: #2489CE;"><span style="background: white;margin-left: 20px;padding-left: 5px;padding-right: 22px;">Previsto</span></p>
					<p style="background: #5FB221;"><span style="background: white;margin-left: 20px;padding-left: 5px;padding-right: 10px;">Realizado</span></p>
				</div>
			</div>
			
			<div id="container_graf1" class="container_graf">
				<div class="info"></div>
				<div class="graf">
					<div class="dados"></div>
				</div>
				<div class="meter"></div>
				
			</div>
			<div id="container_graf2" class="container_graf">
				<div class="info"></div>
				<div class="graf">
					<div class="dados"></div>
				</div>
				<div class="meter"></div>
				
			</div>
			<div id="container_graf3" class="container_graf">
				<div class="info"></div>
				<div class="graf">
					<div class="dados"></div>
				</div>
				<div class="meter"></div>
				
			</div>
			<div id="container_graf4" class="container_graf">
				<div class="info"></div>
				<div class="graf">
					<div class="dados"></div>
				</div>
				<div class="meter"></div>
				
			</div>
		</div>
		<script type="text/javascript">
		  $.get('http://cliquecagece.int.cagece.com.br/apps/gerencial/api/geinf/json',carregaBanco);
		</script>
	</body>
	
	<footer>
	</footer>
</html>
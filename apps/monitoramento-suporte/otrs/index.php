<?php 
require_once ("function.php"); 
if ($abertos != null) { 
	$controle = $abertos[0]; 
} else { 
	die ('Não foi retornado nada na consulta ao oracle'); 
} 
?>

<!DOCTYPE html>
<html lang="pt-br" dir="ltr" >
	<head>
		<meta http-equiv="refresh" content="180" />
		<meta http-equiv="Content-Script-Type" content="text/javascript" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Cache-control" content="no-cache">
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="expires" content = "-1" />
		<base href="http://cliquecagece.int.cagece.com.br/" />
		<title>MONITORAMENTO DOS SERVIÇOS DE SUPORTE</title>
		<link href="/templates/intranet/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
		<script src="/media/system/js/mootools-core.js" type="text/javascript"></script>
		<script src="/media/system/js/core.js" type="text/javascript"></script>
		<script src="/media/system/js/mootools-more.js" type="text/javascript"></script>
		<link rel="shortcut icon" type="image/x-icon" href="/templates/intranet/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="/otrs/style.css" />
		<script language="JavaScript">
		function lightOn(obj, color){
			if (color == null || color == "")
				obj.bgColor = "#C8CDD2";
			else
				obj.bgColor = color;
			}
			function lightOff(obj){
				obj.bgColor = "";
			}
		
		function openLink (id) {
			url = "http://srvotrs.int.cagece.com.br/otrs/index.pl?Action=AgentTicketZoom&TicketID="+id;
			window.open (url,"_blank");
			return false;
		}
		</script>
	</head>
	
	<body>
		<div class="esquerda"> 
			<div class="topo"> 
				<div class="texto"> 
					<p class="titulo1">Chamado</p>
					<p class="titulo2">Solicitante</p>
					<p class="titulo3">Categoria</p>
					<p class="titulo4">Depto</p>
					<p class="titulo5">Técnico</p>
					<p class="titulo6">Data Criação</p>
				</div>
			</div>
			<div class="colunas">
				<div class="coluna1"> 
					<div class="preto"> 
						<p class="n-preto"><?php echo $controle->TOTAL_PRETO; ?></p>
					</div>
					<div class="vermelho"> 
						<p class="n-vermelho"><?php echo $controle->TOTAL_VERMELHO; ?></p>
					</div>
					<div class="laranja"> 
						<p class="n-laranja"><?php echo $controle->TOTAL_LARANJA; ?></p>
					</div>
					<div class="amarelo"> 
						<p class="n-amarelo"><?php echo $controle->TOTAL_AMARELO; ?></p>
					</div>
					<div class="verde"> 
						<p class="n-verde"><?php echo $controle->TOTAL_VERDE; ?></p>
					</div>
				</div>
				
				<div class="coluna2"> 
					<div class="tabela-lista"> 
						<?php if ($controle->TOTAL_PRETO>3) {	echo "<marquee behavior=\"scroll\" direction= \"up\" height=\"98\" scrollamount=\"1\" scrolldelay=\"80\" onmouseover='this.stop()' onmouseout='this.start()'>";} ?>
						<table border="0" cellpadding="0" cellspacing="0" width="98%">
							<tbody>
								<?php foreach ($abertos as $item) {
									if ($item->STATUS == 'preto') {
										echo "<tr onmouseover='lightOn(this);' onmouseout='lightOff(this);' style='cursor: pointer;' title='Clique para ver os detalhes da solicitação.' onmousedown='openLink($item->ID)'>";
											echo "<td class='id'>$item->ID</td>";
											echo "<td class='solicitante'>$item->SOLICITANTE</td>";
											echo "<td class='categoria'>$item->CATEGORIA</td>";
											echo "<td class='unidade'>$item->UNIDADE</td>";
											echo "<td class='tecnico'>$item->TECNICO</td>";
											echo "<td class='criacao'>$item->CRIACAO</td>";
										echo "</tr>";
									}
								} ?>
							</tbody>
						</table>
						<?php if ($controle->TOTAL_PRETO>3) {echo "</marquee>";} ?>
					</div>
					<div class="tabela-lista"> 
						<?php if ($controle->TOTAL_VERMELHO>3) {	echo "<marquee behavior=\"scroll\" direction= \"up\" height=\"98\" scrollamount=\"1\" scrolldelay=\"80\" onmouseover='this.stop()' onmouseout='this.start()'>";} ?>
						<table border="0" cellpadding="0" cellspacing="0" width="98%">
							<tbody>
								<?php foreach ($abertos as $item) {
									if ($item->STATUS == 'vermelho') {
										echo "<tr onmouseover='lightOn(this);' onmouseout='lightOff(this);' style='cursor: pointer;' title='Clique para ver os detalhes da solicitação.' onmousedown='openLink($item->ID)'>";
											echo "<td class='id'>$item->ID</td>";
											echo "<td class='solicitante'>$item->SOLICITANTE</td>";
											echo "<td class='categoria'>$item->CATEGORIA</td>";
											echo "<td class='unidade'>$item->UNIDADE</td>";
											echo "<td class='tecnico'>$item->TECNICO</td>";
											echo "<td class='criacao'>$item->CRIACAO</td>";
										echo "</tr>";
									}
								} ?>
							</tbody>
						</table>
						<?php if ($controle->TOTAL_VERMELHO>3) {echo "</marquee>";} ?>
					</div>
					<div class="tabela-lista"> 
						<?php if ($controle->TOTAL_LARANJA>3) {	echo "<marquee behavior=\"scroll\" direction= \"up\" height=\"98\" scrollamount=\"1\" scrolldelay=\"80\" onmouseover='this.stop()' onmouseout='this.start()'>";} ?>
						<table border="0" cellpadding="0" cellspacing="0" width="98%">
							<tbody>
								<?php foreach ($abertos as $item) {
									if ($item->STATUS == 'laranja') {
										echo "<tr onmouseover='lightOn(this);' onmouseout='lightOff(this);' style='cursor: pointer;' title='Clique para ver os detalhes da solicitação.' onmousedown='openLink($item->ID)'>";
											echo "<td class='id'>$item->ID</td>";
											echo "<td class='solicitante'>$item->SOLICITANTE</td>";
											echo "<td class='categoria'>$item->CATEGORIA</td>";
											echo "<td class='unidade'>$item->UNIDADE</td>";
											echo "<td class='tecnico'>$item->TECNICO</td>";
											echo "<td class='criacao'>$item->CRIACAO</td>";
										echo "</tr>";
									}
								} ?>
							</tbody>
						</table>
						<?php if ($controle->TOTAL_LARANJA>3) {echo "</marquee>";} ?>
					</div>
					<div class="tabela-lista"> 
						<?php if ($controle->TOTAL_AMARELO>3) {	echo "<marquee behavior=\"scroll\" direction= \"up\" height=\"98\" scrollamount=\"1\" scrolldelay=\"80\" onmouseover='this.stop()' onmouseout='this.start()'>";} ?>
						<table border="0" cellpadding="0" cellspacing="0" width="98%">
							<tbody>
								<?php foreach ($abertos as $item) {
									if ($item->STATUS == 'amarelo') {
										echo "<tr onmouseover='lightOn(this);' onmouseout='lightOff(this);' style='cursor: pointer;' title='Clique para ver os detalhes da solicitação.' onmousedown='openLink($item->ID)'>";
											echo "<td class='id'>$item->ID</td>";
											echo "<td class='solicitante'>$item->SOLICITANTE</td>";
											echo "<td class='categoria'>$item->CATEGORIA</td>";
											echo "<td class='unidade'>$item->UNIDADE</td>";
											echo "<td class='tecnico'>$item->TECNICO</td>";
											echo "<td class='criacao'>$item->CRIACAO</td>";
										echo "</tr>";
									}
								} ?>
							</tbody>
						</table>
						<?php if ($controle->TOTAL_AMARELO>3) {echo "</marquee>";} ?>
					</div>
					<div class="tabela-lista"> 
						<?php if ($controle->TOTAL_VERDE>3) {	echo "<marquee behavior=\"scroll\" direction= \"up\" height=\"98\" scrollamount=\"1\" scrolldelay=\"80\" onmouseover='this.stop()' onmouseout='this.start()'>";} ?>
						<table border="0" cellpadding="0" cellspacing="0" width="98%">
							<tbody>
								<?php foreach ($abertos as $item) {
									if ($item->STATUS == 'verde') {
										echo "<tr onmouseover='lightOn(this);' onmouseout='lightOff(this);' style='cursor: pointer;' title='Clique para ver os detalhes da solicitação.' onmousedown='openLink($item->ID)'>";
											echo "<td class='id'>$item->ID</td>";
											echo "<td class='solicitante'>$item->SOLICITANTE</td>";
											echo "<td class='categoria'>$item->CATEGORIA</td>";
											echo "<td class='unidade'>$item->UNIDADE</td>";
											echo "<td class='tecnico'>$item->TECNICO</td>";
											echo "<td class='criacao'>$item->CRIACAO</td>";
										echo "</tr>";
									}
								} ?>
							</tbody>
						</table>
						<?php if ($controle->TOTAL_VERDE>3) {echo "</marquee>";} ?>
					</div>
				</div>
			</div>
		</div>

		<div class="direita"> 
			<div class="fecdia"> 
				<p class=""><?php echo  str_pad($fechadosHoje, 3, "0", STR_PAD_LEFT); ?></p>
			</div>
			<div class="fecmes"> 
				<p class=""><?php echo str_pad($fechadosMes, 4, "0", STR_PAD_LEFT); ?></p>
			</div>
			<div class="pendentes"> 
				<p class=""><?php echo str_pad($pendentes, 3, "0", STR_PAD_LEFT); ?></p>
			</div>
		</div>
	</body>
</html>
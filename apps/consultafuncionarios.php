<?php 
if (isset($_REQUEST['query'])) {$query = $_REQUEST['query'];} else { $query = '';}
?>
<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="http://cliquecagece.int.cagece.com.br/templates/intranet/css/import.css">
		<link rel="stylesheet" type="text/css" href="http://cliquecagece.int.cagece.com.br/administrator/templates/bluestork/css/template.css">
		<title>Pesquisa de Funcionário</title>
		<style>
		body {width: 100% !important; min-width: 600px; max-width: 840px; }
		label {margin-right: 5px !important;}
		#query-searchword {height: 18px; border: 1px solid green; border-radius: 5px;}
		#label_query {margin-top: 5px;}
		.group {display: block; min-height: 25px; clear: both; margin: 0 0 5px; width: 100%;}
		.label_busca {display: block;float: left;width: 136px;font-weight: 700;padding: 4px 0 0 0; margin: 0;}
		fieldset label, fieldset span.faux-label { clear: right; }

		</style>
	</head>
	<body>
		<form id="searchUser" action="" method="post">
			<fieldset class="phrases">
				<legend>Formulário de Busca</legend>

				<div class="group">
					<label class="label_busca" id="label_query" for="query-searchword">Buscar Funcionário:</label>
					<input type="text" name="query" id="query-searchword" size="45" maxlength="20" value="<?php echo $query; ?>" class="inputbox">
				</div>
				<div class="group options">
					<p class="label_busca">Tipo de Busca:</p>
					<input type="radio" name="tipo" id="searchphraseany" value="any" checked>
					<label for="searchphraseany" id="searchphraseany-lbl" class="radiobtn">Qualquer palavra</label>
					<input type="radio" name="tipo" id="searchphraseexact" value="exact">
					<label for="searchphraseexact" id="searchphraseexact-lbl" class="radiobtn">Frase exata</label>
				</div>
				<div class="group options">
					<p  class="label_busca">Estado do funcionário:</p>
					<input type="radio" name="estado" id="estado" value="" checked>
					<label for="estado" id="estado-lbl" class="radiobtn">Todos</label>
					<input type="radio" name="estado" id="estadoativos" value="ativos">
					<label for="estadoativos" id="estadoativos-lbl" class="radiobtn">Ativos</label>
					<input type="radio" name="estado" id="estadoinativos" value="inativos">
					<label for="estadoinativos" id="estadoinativos-lbl" class="radiobtn">Inativos</label>
				</div>
				<br />
				<input name="Search" type="submit" value="Buscar" class="button">
			</fieldset>
		</form>
		
		<?php 
			$users = getUsers();
			//$users = '';
			if (is_string($users)) { ?>
				<div id="system-message-container">
					<dl id="system-message">
					<dt class="info">Info</dt>
					<dd class="info message">
						<ul>
							<li><?php echo $users; ?></li>
						</ul>
					</dd>
					</dl>
				</div>
		<?php 
			} else { ?>
			<table class="adminlist">
            <thead>
                <tr class="title">
                    <th colspan="4">Lista de funcionários</th>
                </tr>
                <tr>
                    <th class="">Matricula</th>
                    <th class="">Nome</th>
                    <th class="">Categoria</th>
                    <th class="">Sit. Funcional</th>
                </tr>
            </thead>
            <tbody>
				<?php foreach ($users as $i => $u) { ?>
                    <tr class="row<?php echo $i % 2; ?>">
                        <td> <?php echo $u->COL_COD_MATRICULA ;?></td>
                        <td> <?php echo $u->COL_DSC_NOME ;?></td>
                        <td> <?php echo $u->COL_DSC_CATEGORIA ;?></td>
                        <td> <?php echo $u->SIF_DSC_GRUPO_SIT_FUNCIONAL ;?></td>
                    </tr>
            <?php
				} ?>    
            </tbody>
			<tfoot>
                <tr>
                    <th colspan="4">Quantidade de resultados encontrados: <?php echo $i+1; ?></th>
                </tr>
            </tfoot>
        </table>
		<?php
			} ?>
	</body>
	<footer>
	
	</footer>
</html>

<?php
function getUsers() {
	$vars = $_REQUEST;
	$where = '';
	$user = array();
	$order = " ORDER BY col_dsc_nome";
	$sql = "SELECT C1.COL_COD_MATRICULA,
	  C1.Col_Dsc_Nome,
	  DECODE(C1.COL_FLG_CATEGORIA, 'H','Jovem Aprendiz','M','Funcionário Cagece','T','Terceirizado','A','Contrato RPA','S','Terceirizado Serviço','E','Estagiário') AS COL_DSC_CATEGORIA,
	  SIF.SIF_DSC_GRUPO_SIT_FUNCIONAL
	FROM COL_COLABORADOR_TODOS C1 ,
	  SIF_SITUACAO_FUNCIONAL SIF
	WHERE C1.SIF_COD_SITUACAO_FUNCIONAL = SIF.SIF_COD_SITUACAO_FUNCIONAL
	AND (c1.col_flg_categoria IN ('E', 'H', 'M', 'T','S')
	OR (c1.col_flg_categoria = 'A'
	AND trim(c1.col_dsc_login) IS NOT NULL))
	AND trim(c1.col_dsc_nome) IS NOT NULL
	AND LENGTH(trim(c1.col_dsc_nome)) > 4
	";

	if (isset($vars['estado'])) {
		switch($vars['estado']) {
			case 'ativos' :
				$where .= " AND C1.SIF_COD_SITUACAO_FUNCIONAL  IN (1,3,12,21) AND C1.COL_COD_FILIAL <> '80' AND EXISTS (SELECT 1 FROM RH.COL_COLABORADOR_TODOS C2 WHERE c2.col_flg_categoria  = 'A' AND TRIM(C2.COL_DSC_LOGIN) IS NOT NULL ) ";
				break;
			case 'inativos' :
				$where .= " AND C1.SIF_COD_SITUACAO_FUNCIONAL NOT IN (1,3,12,21) AND EXISTS (SELECT 1 FROM RH.COL_COLABORADOR_TODOS C2 WHERE C2.COL_FLG_CATEGORIA  = 'A' AND trim(c2.col_dsc_login) IS NULL)";
				break;
			default:
				break;
		}
	}
	
	if (isset($vars['query'])) {
		$word = $vars['query'];
		
		if (!isset($vars['tipo'])) {
			$vars['tipo'] = 'any';
		}
		switch($vars['tipo']) {
			case 'any':
				$words = explode(' ', $word);
				$where .= "AND (";
				foreach ($words as $w) {
					$where .= " lower(col_dsc_nome) like '%".strtolower($w)."%' OR ";
				}
				$where = substr($where,0,-3);
				$where .= ")";
				break;
			case 'exact':
				$where .= " AND lower(col_dsc_nome) like '%".strtolower($word)."%'";
				break;
			default:
			
				break;
		}
	
	}
	
	$sql .= $where.$order;
	
	$conn = oci_new_connect('rh', 'rh_2004', '172.25.131.73:1521/cgora2','AL32UTF8');
	if ($conn) {
		$prepare = oci_parse($conn, $sql) or die('Existe um erro na sua consulta SQL');
		oci_execute($prepare) or die('Existe um erro na sua consulta SQL <br />' . $sql);
		$i = 0;
		while ($result = oci_fetch_object($prepare,OCI_ASSOC)){
			$user[$i] = $result;
			$i++;
		}
		oci_close($conn);
		if (!empty($user)) {
			return $user;
		} else {
			return 'Nenhum usuário encontrado, tente novamente.';
		}
	} else {
		return 'Um problema foi detectado, tente novamente em alguns minutos';
	}
	
}
		
?>
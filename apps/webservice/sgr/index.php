<?php
header('Access-Control-Allow-Origin: *');
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require '../libs/Slim/Slim.php';
require_once ('model.php');
header('Content-Type: text/html; charset=utf-8');
setlocale(LC_CTYPE,"pt_BR");

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
GLOBAL $app, $i;
$i = new indicadoresGerenciais();

$app = new \Slim\Slim();
$app->response()->header('Content-Type', 'application/json;charset=utf-8');
/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, and `Slim::delete`
 * is an anonymous function.
 */

// GET route


$app->get('/', function () {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'text/html;charset=utf-8');
    $template = <<<EOT
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8"/>
			<meta http-equiv="Cache-control" content="no-cache">
			<meta http-equiv="pragma" content="no-cache" />
			<meta http-equiv="expires" content = "-1" />
            <title>Slim Framework for PHP 5</title>
            <style>
                html,body,div,span,object,iframe,
                h1,h2,h3,h4,h5,h6,p,blockquote,pre,
                abbr,address,cite,code,
                del,dfn,em,img,ins,kbd,q,samp,
                small,strong,sub,sup,var,
                b,i,
                dl,dt,dd,ol,ul,li,
                fieldset,form,label,legend,
                table,caption,tbody,tfoot,thead,tr,th,td,
                article,aside,canvas,details,figcaption,figure,
                footer,header,hgroup,menu,nav,section,summary,
                time,mark,audio,video{margin:0;padding:0;border:0;outline:0;font-size:100%;vertical-align:baseline;background:transparent;}
                body{line-height:1;}
                article,aside,details,figcaption,figure,
                footer,header,hgroup,menu,nav,section{display:block;}
                nav ul{list-style:none;}
                blockquote,q{quotes:none;}
                blockquote:before,blockquote:after,
                q:before,q:after{content:'';content:none;}
                a{margin:0;padding:0;font-size:100%;vertical-align:baseline;background:transparent;}
                ins{background-color:#ff9;color:#000;text-decoration:none;}
                mark{background-color:#ff9;color:#000;font-style:italic;font-weight:bold;}
                del{text-decoration:line-through;}
                abbr[title],dfn[title]{border-bottom:1px dotted;cursor:help;}
                table{border-collapse:collapse;border-spacing:0;}
                hr{display:block;height:1px;border:0;border-top:1px solid #cccccc;margin:1em 0;padding:0;}
                input,select{vertical-align:middle;}
                html{ background: #EDEDED; height: 100%; }
                body{background:#FFF;margin:0 auto;min-height:100%;padding:0 30px;width:720px;color:#666;font:14px/23px Arial,Verdana,sans-serif;}
                h1,h2,h3,p,ul,ol,form,section{margin:0 0 20px 0;}
                h1{color:#333;font-size:20px;}
                h2,h3{color:#333;font-size:14px;}
                h3{margin:0;font-size:12px;font-weight:bold;}
                ul,ol{list-style-position:inside;color:#999;}
                ul{list-style-type:square;}
                code,kbd{background:#EEE;border:1px solid #DDD;border:1px solid #DDD;border-radius:4px;-moz-border-radius:4px;-webkit-border-radius:4px;padding:0 4px;color:#666;font-size:12px;}
                pre{background:#EEE;border:1px solid #DDD;border-radius:4px;-moz-border-radius:4px;-webkit-border-radius:4px;padding:5px 10px;color:#666;font-size:12px;}
                pre code{background:transparent;border:none;padding:0;}
                a{color:#70a23e;}
                header{padding: 30px 0;text-align:center;}
            </style>
        </head>
        <body>
            <header>
                <img src="http://www.cagece.com.br/templates/cagece_bootstrap/img/logo.jpg"/>
				</header>
            <h1>Bem vindo a API dos Indicadores da CAGECE!</h1>
            <section>
                <h2>Começando</h2>
                <p><b>URI: /json</b><br/>
					Retorna um json com todas as informações do banco, dividido em 2 nós (OBJETIVOS e INDICADORES).
				</p>
            </section>
			<section>
                <h2>Todos os Dados - JSON</h2>
                <ol>
                    <li>O código da aplicação está em: <code>index.php</code></li>
					<li>A url de acesso é a URL atual as as URI (identificadores únicos) que utilizam o método GET, que retorna um JSON</li>
					<li>Os dados que se encontram dentro de chaves {} são variavéis que devem ser substituídas pelos valores desejados </li>
                    <li>Leia a <a href="http://docs.slimframework.com/" target="_blank">documentação online</a> do framework</li>
                </ol>
            </section>
            <section>
                <h2>Indicadores</h2>
				<p>Abaixos seguem os métodos de as URIs para trabalhar usando os indicadores como base</p>
                <h3>Lista de indicadores</h3>
                <p><b>URI: /indicadores</b><br/>
					Retorna a lista de todos os indicadores cadastrados e ativos no momento.<br />
					Dados encontrados:<br />
					<ul>
						<li>IND_COD_INDICADOR: ID de identificação do indicador</li>
						<li>IND_NOM_INDICADOR: Nome do indicador</li>
						<li>IND_DSC_INDICADOR: Descrição do indicador</li>
						<li>OBJ_DSC_OBJETIVO: Objetivo estratégico associado</li>
						<li>OBJ_NUM_COMPETENCIA: Ano de competência do indicador</li>
						<li>UNM_DSC_UND_MEDIDA: Unidade de medida usado para o indicador</li>
						<li>IND_TIP_PERIODICIDADE: Periodicidade que um indicador é medido</li>
					</ul>
				</p>
				
                <h3>Dados do indicador (previsto x realizado)</h3>
                <p>
					<b>URI: /indicadores/{IND_COD_INDICADOR}</b><br/>
					Retorna os dados do indicador mês a mês do ano atual. Esses dados servirão para montar um gráfico do previsto x realizado
					Dados encontrados:<br />
					<ul>
						<li>ANOMES: Ano e mês da avaliação no formato yyyymm</li>
						<li>PREVISTO: Previsto no mês</li>
						<li>REALIZADO: Realizado no mês</li>
						<li>ATINGIDO: Percentual de quanto foi atingido da meta</li>
						<li>DESVIO: Desvio entre o previsto e o realizado</li>
						<li>REAL_GRAF: Valor realizado para o gráfico</li>
						<li>EXB_DECIMAL: Informa se deve ou não exibir a casa decimal</li>
						<li>SENTIDO: Informa o sentido do comportamento do indicador comparado ao mês anterior (subindo, descendo, sem mudança)</li>
						<li>COR: Informa o estado do indicador (verde, amarelo, vermelho)</li>
					</ul>
					<b>URI: /indicadores/{IND_COD_INDICADOR}/{ANO}</b><br/>
					Traz as mesmas informações que a URI antenrior, porém podendo consultar anos anteriores.					
                </p>
				
				<h3>Causas, efeitos e ações de um indicador</h3>
                <p>
					<b>URI: /indicadores/{IND_COD_INDICADOR}/{ANO}/causa</b><br/>
					Retorna informações analisadas como FATOS, CAUSAS e AÇÕES, mês a mês, do ano e do indicador informado. <br />
					Dados encontrados:<br />
					<ul>
						<li>ANOMES: Ano e mês da avaliação no formato yyyymm</li>
						<li>DATA: Ano e mês da avaliação no formato mm/yyyy</li>
						<li>DATAREU: Data que ocorreu a reunião de analise</li>
						<li>FATOS: Fatos do indicador para aquele mês/ano</li>
						<li>CAUSAS: Causas que levaram aos fatos do indicador para aquele mês/ano</li>
						<li>ACOES:  Ações para tratar as causas do indicador para aquele mês/ano</li>
						<li>ANEXO</li>
					</ul>
                </p>
				<h3>Plano de ação de um indicador</h3>
                <p>
					<b>URI: /indicadores/{IND_COD_INDICADOR}/{ANO}/plano</b><br/>
					Retorna informações sobre o plano de ação definido do indicador informado, para o ano informado.<br/>
					Dados encontrados:<br />
					<ul>
						<li>ACAO: Nome da ação</li>
						<li>RESPONSAVEL: Nome do responsável pela ação</li>
						<li>EQUIPE: Membros da equipe que irá executatar/acompanhar a ação</li>
						<li>INICIO: Data de inicio do plano de ação</li>
						<li>FIM: Data de termino do plano de ação</li>
						<li>SITUACAO: Situação atual do plano de ação</li>
						<li>REALIZADO: O que foi realizado até o momento/acompanhamento</li>
						<li>CODIGO: Codigo identificador da ação</li>
					</ul>
                </p>
				
				<h3>Fonte de dados de um indicador</h3>
                <p>
					<b>URI: /indicadores/{IND_COD_INDICADOR}/{ANO}/fonte</b><br/>
					Informa a origem dos dados usados para avaliar e medir o indicador atual, no ano informado<br />
					Dados encontrados:<br />
					<ul>
						<li>NOM_VAR: Nome da variavél</li>
						<li>DSC_VAR: Descrição da variavél</li>
						<li>COMPORT: Comportamento esperado da variavél</li>
						<li>ORIGEM: Origem dos dados</li>
						<li>FORMULA: Formula para cálculo do indicador</li>
					</ul>
                </p>
            </section>
			<section>
                <h2>Objetivos</h2>
				<p>Abaixos seguem os métodos de as URIs para trabalhar usando os objetivos como base</p>
                <h3>Lista de objetivos</h3>
                <p>
					<b>URI: /objetivos</b><br/>
					Retorna a lista de objetivos atuais em relação ao planejamento estratégico <br />
                    Dados encontrados:<br />
					<ul>
						<li>OBJ_COD_OBJETIVO: ID de identificação do objetivo</li>
						<li>OBJ_DSC_OBJETIVO: Objetivo estratégico associado</li>
						<li>OBJ_NUM_COMPETENCIA: Ano de competência do indicador</li>
						<li>DIR_NOM_DIRETRIZ: Nome da Diretriz do objetivo</li>
						<li>PER_NOM_PERSPECTIVA: Nome da perspectiva do objetivo</li>
						<li>OBJ_NUM_ORDEM_APRES: Ordem de apresentação do objetivo</li>
					</ul>
                </p>
				<h3>Lista de indicadores por objetivo</h3>
                <p>
					<b>URI: /objetivos/{OBJ_COD_OBJETIVO}</b><br/>
					Retorna a lista de todos os indicadores cadastrados e ativos no momento para o objetivo selecionado.<br />
					Dados encontrados:<br />
					<ul>
						<li>IND_COD_INDICADOR: ID de identificação do indicador</li>
						<li>IND_NOM_INDICADOR: Nome do indicador</li>
						<li>IND_DSC_INDICADOR: Descrição do indicador</li>
						<li>OBJ_DSC_OBJETIVO: Objetivo estratégico associado</li>
						<li>OBJ_NUM_COMPETENCIA: Ano de competência do indicador</li>
						<li>UNM_DSC_UND_MEDIDA: Unidade de medida usado para o indicador</li>
						<li>IND_TIP_PERIODICIDADE: Periodicidade que um indicador é medido</li>
					</ul>
				</p>
				
                <h3>Dados do indicador (previsto x realizado)</h3>
                <p>
					<b>URI: /objetivos/{OBJ_COD_OBJETIVO}/{IND_COD_INDICADOR}</b><br/>
					Retorna os dados do indicador mês a mês do ano atual. Esses dados servirão para montar um gráfico do previsto x realizado
					Dados encontrados:<br />
					<ul>
						<li>ANOMES: Ano e mês da avaliação no formato yyyymm</li>
						<li>PREVISTO: Previsto no mês</li>
						<li>REALIZADO: Realizado no mês</li>
						<li>ATINGIDO: Percentual de quanto foi atingido da meta</li>
						<li>DESVIO: Desvio entre o previsto e o realizado</li>
						<li>REAL_GRAF: Valor realizado para o gráfico</li>
						<li>EXB_DECIMAL: Informa se deve ou não exibir a casa decimal</li>
					</ul>
					<b>URI: /objetivos/{OBJ_COD_OBJETIVO}/{IND_COD_INDICADOR}/{ANO}</b><br/>
					Traz as mesmas informações que a URI antenrior, porém podendo consultar anos anteriores.					
                </p>
				
				<h3>Causas, efeitos e ações de um indicador</h3>
                <p>
					<b>URI: /objetivos/{OBJ_COD_OBJETIVO}/{IND_COD_INDICADOR}/{ANO}/causa</b><br/>
					Retorna informações analisadas como FATOS, CAUSAS e AÇÕES, mês a mês, do ano e do indicador informado. <br />
					Dados encontrados:<br />
					<ul>
						<li>ANOMES: Ano e mês da avaliação no formato yyyymm</li>
						<li>DATA: Ano e mês da avaliação no formato mm/yyyy</li>
						<li>DATAREU: Data que ocorreu a reunião de analise</li>
						<li>FATOS: Fatos do indicador para aquele mês/ano</li>
						<li>CAUSAS: Causas que levaram aos fatos do indicador para aquele mês/ano</li>
						<li>ACOES:  Ações para tratar as causas do indicador para aquele mês/ano</li>
						<li>ANEXO</li>
					</ul>
                </p>
				<h3>Plano de ação de um indicador</h3>
                <p>
					<b>URI: /objetivos/{OBJ_COD_OBJETIVO}/{IND_COD_INDICADOR}/{ANO}/plano</b><br/>
					Retorna informações sobre o plano de ação definido do indicador informado, para o ano informado.<br/>
					Dados encontrados:<br />
					<ul>
						<li>ACAO: Nome da ação</li>
						<li>RESPONSAVEL: Nome do responsável pela ação</li>
						<li>EQUIPE: Membros da equipe que irá executatar/acompanhar a ação</li>
						<li>INICIO: Data de inicio do plano de ação</li>
						<li>FIM: Data de termino do plano de ação</li>
						<li>SITUACAO: Situação atual do plano de ação</li>
						<li>REALIZADO: O que foi realizado até o momento/acompanhamento</li>
						<li>CODIGO: Codigo identificador da ação</li>
					</ul>
                </p>
				
				<h3>Fonte de dados de um indicador</h3>
                <p>
					<b>URI: /objetivos/{OBJ_COD_OBJETIVO}/{IND_COD_INDICADOR}/{ANO}/fonte</b><br/>
					Informa a origem dos dados usados para avaliar e medir o indicador atual, no ano informado<br />
					Dados encontrados:<br />
					<ul>
						<li>NOM_VAR: Nome da variavél</li>
						<li>DSC_VAR: Descrição da variavél</li>
						<li>COMPORT: Comportamento esperado da variavél</li>
						<li>ORIGEM: Origem dos dados</li>
						<li>FORMULA: Formula para cálculo do indicador</li>
					</ul>
                </p>

            </section>
			<br clear="all" />
        </body>
    </html>
EOT;
    echo $template;
});

/* Indicadores */
$app->get('/indicadores', function () {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	$ano = $_SERVER['QUERY_STRING'];
	echo json_encode($i->getAll($ano));
});

$app->get('/indicadores/:id', function ($id) {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	$ano = $_SERVER['QUERY_STRING'];
	echo json_encode($i->getItem($id, $ano));
});

$app->get('/indicadores/:id/:ano', function ($id, $ano) {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	echo json_encode($i->getItem($id, $ano));
});

/* Indicadores - ACOES*/

$app->get('/indicadores/:id/:ano/causa', function ($id, $ano) {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	echo json_encode($i->getItemCausa($id, $ano));
});

$app->get('/indicadores/:id/:ano/fonte', function ($id, $ano) {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	echo json_encode($i->getItemFonte($id));
});

$app->get('/indicadores/:id/:ano/plano', function ($id, $ano) {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	echo json_encode($i->getItemPlano($id, $ano));
});

$app->get('/indicador/:id/', function ($id) {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'text/html;charset=utf-8');
        $app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	echo json_encode($i->getItemUltimo($id));
});

$app->get('/unidade/:id/:un/:anomes', function ($id, $un, $anomes) {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'text/html;charset=utf-8');
        $app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	echo json_encode($i->getIndicadorUnidade($id, $un, $anomes));
});
$app->get('/unidade/:id', function ($id) {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'text/html;charset=utf-8');
        $app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	echo json_encode($i->getIndicadorUnidade($id));
});
$app->get('/unidade/:id/:un', function ($id, $un) {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'text/html;charset=utf-8');
        $app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	echo json_encode($i->getIndicadorUnidade($id, $un));
});

$app->get('/mapa/:id/:anomes', function ($id, $anomes) {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'text/html;charset=utf-8');
        $app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	echo json_encode($i->getUnidadesMapa($id, $anomes));
});

/* Objetivos */
$app->get('/objetivos', function () {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	echo json_encode($i->getObj());
});

$app->get('/objetivos/json', function () {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	echo json_encode($i->jsonObjetivosIndicador());
});

$app->get('/objetivos/:obj', function ($obj) {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	$ano = $_SERVER['QUERY_STRING'];
	echo json_encode($i->getAll($ano, $obj));
});

$app->get('/objetivos/:obj/:id', function ($obj, $id) {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	$ano = $_SERVER['QUERY_STRING'];
	echo json_encode($i->getItem($id, $ano));
});

$app->get('/objetivos/:obj/:id/:ano', function ($obj, $id, $ano) {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	echo json_encode($i->getItem($id, $ano));
});

/* Indicadores Setoriais */
$app->get('/geinf', function () {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	$ano = $_SERVER['QUERY_STRING'];
	echo json_encode($i->getGeinfSetorial());
});

$app->get('/geinf/json', function () {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	$ano = $_SERVER['QUERY_STRING'];
	echo json_encode($i->getGeinfJson($ano));
});

$app->get('/geinf/:id', function ($id) {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	$ano = $_SERVER['QUERY_STRING'];
	echo json_encode($i->getItemSetorial($id,$ano));
});


/* JSON COMPLETO */
$app->get('/json', function () {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	
	GLOBAL $i;
	$result = $i->json();
	$fp = fopen('banco.json', 'w');
	fwrite($fp, json_encode($result));
	fclose($fp);
	
	echo json_encode($result);
});

/* Gera Arquivos JSON */
$app->get('/json/atual', function () {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	GLOBAL $i;
	echo json_encode($i->jsonAtual());
});

$app->get('/verifica/:id', function ($id) {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'application/json;charset=utf-8');
	GLOBAL $i;
	echo json_encode($i->verificaIndicador($id));
});

$app->get('/json/indicadores', function () {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'text/html;charset=utf-8');

	GLOBAL $i;
	$ano = date('Y');
	$texto = '<hr />Gerando arquivos em JSON <hr />';
	
	//echo json_encode($i->jsonFiles());
	//die;
	
	$result = $i->jsonIndicadoresTodos();
	
	//grava arquivo de objetivos
	$fp = fopen('todos_indicadores.json', 'w');
	fwrite($fp, json_encode($result));
	fclose($fp);
	
	$texto .= '<a href="../todos_indicadores.json">Baixar banco IndicadoresJSON de 2000 a '.$ano.'</a><br>';
	//$texto .= '<a href="../anos.json">Baixar banco JSON contendo iformações de quais anos cada indicador possui dados</a><br>';
	
	    $template = <<<EOT
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8"/>
		</head>
	<body>
	$texto
	</body>
    </html>
EOT;

    echo $template;
});

$app->get('/json/files', function () {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'text/html;charset=utf-8');

	GLOBAL $i;
	$ano = date('Y');
	$anterior = (((int)$ano)-1);
	$texto = '<hr />Gerando arquivos em JSON <hr />';
	
	//echo json_encode($i->jsonFiles());
	//die;
	
	$result = $i->jsonFiles();
	
	//grava arquivo de objetivos
	$fp = fopen('objetivos.json', 'w');
	fwrite($fp, json_encode($result['OBJETIVOS']));
	fclose($fp);
	
	//grava arquivo de indicadores passados
	$fp = fopen('anterior.json', 'w');
	fwrite($fp, json_encode($result['INDICADORES']));
	fclose($fp);
	
	//grava arquivo de indicadores passados
	//$fp = fopen('atual.json', 'w');
	//fwrite($fp, json_encode($result['ATUAL']));
	//fclose($fp);
	
	//grava arquivo de indicadores atuais
	//echo json_encode($i->jsonAtual());
	//die;
	$atual = $i->jsonAtual();
	$fp = fopen('atual.json', 'w');
	fwrite($fp, json_encode($atual));
	fclose($fp);
	
	//grava arquivo de anos dos indicadores
	//echo json_encode($i->jsonAtual());
	//die;
	/* $anos = $i->jsonAnos();
	$fp = fopen('anos.json', 'w');
	fwrite($fp, json_encode($anos));
	fclose($fp) */;
		
	$texto .= '<a href="../objetivos.json">Baixar banco de Objetivos Atual</a><br>';
	$texto .= '<a href="../anterior.json">Baixar banco IndicadoresJSON de 2000 a '.$anterior.'</a><br>';
	$texto .= '<a href="../atual.json">Baixar banco JSON do ano '.$ano.'</a><br>';
	//$texto .= '<a href="../anos.json">Baixar banco JSON contendo iformações de quais anos cada indicador possui dados</a><br>';
	
	    $template = <<<EOT
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8"/>
		</head>
	<body>
	$texto
	</body>
    </html>
EOT;

    echo $template;
});

$app->get('/json/cron', function () {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'text/html;charset=utf-8');

	GLOBAL $i;
	$ano = date('Y');
	$anterior = (((int)$ano)-1);
	$texto = '<hr />Gerando arquivos em JSON <hr />';
	
	//echo json_encode($i->jsonFiles());
	//die;
	
	$result = $i->jsonFiles();
	
	$fp = fopen('objetivos.json', 'w');
	fwrite($fp, json_encode($result['OBJETIVOS']));
	fclose($fp);

	$fp = fopen('anterior.json', 'w');
	fwrite($fp, json_encode($result['INDICADORES']));
	fclose($fp);

	$atual = $i->jsonAtual();
	$fp = fopen('atual.json', 'w');
	fwrite($fp, json_encode($atual));
	fclose($fp);
	

	$indicadores = $i->jsonIndicadoresTodos();
	$fp = fopen('todos_indicadores.json', 'w');
	fwrite($fp, json_encode($indicadores));
	fclose($fp);
	
	
});

$app->get('/json/files/atual', function () {
	GLOBAL $app;
	$app->response()->header('Content-Type', 'text/html;charset=utf-8');
	
	GLOBAL $i;
	$ano = date('Y');
	$texto = '<hr>Gerando arquivos em JSON do ano '.$ano.'<hr/>';
	$result = $i->jsonAtual();
	$fp = fopen('atual.json', 'w');
	fwrite($fp, json_encode($result));
	fclose($fp);
	
	$texto .= '<a href="atual.json">Baixar banco JSON do ano '.$ano.'</a><br>';
	
	$template = <<<EOT
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8"/>
		</head>
	<body>
	$texto
	</body>
    </html>
EOT;

    echo $template;
	
});

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();

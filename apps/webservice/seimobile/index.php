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
setlocale(LC_CTYPE, "pt_BR");

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
 
// Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    }
 
GLOBAL $app, $i;
$i = new dadosSEIMobile();

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
            <h1>Bem vindo a API dos dados do SEI da CAGECE!</h1>
            <section>
                <h2>ComeÃ§ando</h2>
                <p><b>URI: /json</b><br/>
					Retorna um json com todas as informações do banco, dividido em 3 nós (Estado, UNS, Localidade).
				</p>
				<p><b>URI: /json/files</b><br/>
					Retorna 3 arquivos json para ser efetuado o download e 1 arquivo unificado contento os 3 nós (Estado, UNS, Localidade).
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
                <h2>Por Estado</h2>
				<p></p>
                <h3>Lista de ......</h3>
                <p><b>URI: /estado</b><br/>
					Retorna a lista de todos ...........<br />
					Dados encontrados:<br />
					<ul>
						<li>Tipo de dado 1</li>
						<li>Tipo de dado 1</li>
						<li>Tipo de dado 1</li>
					</ul>
				</p>
				
            </section>
			
			<br clear="all" />
        </body>
    </html>
EOT;
    echo $template;
});

/* Todas as regiÃµes */
$app->get('/regioes', function () {
    GLOBAL $app, $i;
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $result = $i->regioes();
    $fp = fopen('regioes.json', 'w');
    fwrite($fp, json_encode($result));
    fclose($fp);
    echo json_encode($result);
});

/* Todas as unidades de negÃ³cios */
$app->get('/uns', function () {
    GLOBAL $app;
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    GLOBAL $i;
    $result = $i->uns();
    $fp = fopen('uns.json', 'w');
    fwrite($fp, json_encode($result));
    fclose($fp);
    echo json_encode($result);
});

/* Todas as Unidades de NegÃ³cios por RegiÃ£o */
$app->get('/unsregiao', function () {
    GLOBAL $app;
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    GLOBAL $i;
    $result = $i->unsRegiao();
    $fp = fopen('unsregiao.json', 'w');
    fwrite($fp, json_encode($result));
    fclose($fp);
    echo json_encode($result);
});

/* Todos os municÃ­pios */
$app->get('/municipios', function () {
    GLOBAL $app;
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    GLOBAL $i;
    $result = $i->municipios();
    $fp = fopen('municipios.json', 'w');
    fwrite($fp, json_encode($result));
    fclose($fp);
    echo json_encode($result);
});

/* Todos os municÃ­pios por Unidade de NegÃ³cio */
$app->get('/municipiosun', function () {
    GLOBAL $app;
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    GLOBAL $i;
    $result = $i->municipiosUn();
    $fp = fopen('municipiosun.json', 'w');
    fwrite($fp, json_encode($result));
    fclose($fp);
    echo json_encode($result);
});

/* Todos as localidades */
$app->get('/localidades', function () {
    GLOBAL $app;
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    GLOBAL $i;
    $result = $i->localidades();
    $fp = fopen('localidades.json', 'w');
    fwrite($fp, json_encode($result));
    fclose($fp);
    echo json_encode($result);
});

/* Todos as localidades por municipios */
$app->get('/localidadesmunicipio', function () {
    GLOBAL $app;
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    GLOBAL $i;
    $result = $i->localidadesMunicipios();
    $fp = fopen('localidadesmunicipio.json', 'w');
    fwrite($fp, json_encode($result));
    fclose($fp);
    echo json_encode($result);
});

/* Todos as localidades por municipios */
$app->get('/dadosfisicos', function () {
    GLOBAL $app;
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    GLOBAL $i;
    $result = $i->dadosfisicos();
    $fp = fopen('dadosfisicos.json', 'w');
    fwrite($fp, json_encode($result));
    fclose($fp);
    echo json_encode($result);
});

/* Todos as localidades por municipios */
$app->get('/indicadores', function () {
    GLOBAL $app;
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    GLOBAL $i;
    $result = $i->indicadores();
    $fp = fopen('indicadores.json', 'w');
    fwrite($fp, json_encode($result));
    fclose($fp);
    echo json_encode($result);
});

/* Todos as localidades por municipios */
$app->get('/competencias', function () {
    GLOBAL $app;
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    GLOBAL $i;
    $result = $i->competencias();
    $fp = fopen('competencias.json', 'w');
    fwrite($fp, json_encode($result));
    fclose($fp);
    echo json_encode($result);
});

/* Gerar todos os json's */
$app->get('/todos', function () {
    GLOBAL $app;
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    GLOBAL $i;
    $result = $i->todos();
	if ($result){
		$fp = fopen('version.json', 'w');
		fwrite($fp, json_encode($result));
		fclose($fp);
		echo json_encode($result);
	}
	else {
		echo "Base atualizada.";
	}
    
});


/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();

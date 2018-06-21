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
GLOBAL $app, $i;
$i = new empreendimentosSGP();

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
            <h1>Bem vindo a API dos dados do SGP da CAGECE!</h1>
            <section>
                <h2>Começando</h2>
                <p><b>URI: /projetos</b><br/>
                    Retorna um json com todas as informações do banco de projetos
                </p>
                <p><b>URI: /projetos/:empreendimento</b><br/>
                    Recebe o id do empreendimento e retorna apenas um projeto
                </p>
                <p><b>URI: /projetos/:empreendimento/tecnicos</b><br/>
                    Recebe o id do empreendimento e retorna lista de itens tecnicos
                </p>
                <p><b>URI: /projetos/:empreendimento/contratos</b><br/>
                    Recebe o id do empreendimento e retorna lista de contratos e seus dados
                </p>
                <p><b>URI: /tecnicos</b><br/>
                    Retorna lista de todos os itens tecnicos
                </p>
                <p><b>URI: /contratos</b><br/>
                    Retorna lista de todos os contratos e seus dados
                </p>
            </section>
            <br clear="all" />
        </body>
    </html>
EOT;
    echo $template;
});

/* METODOS GET */
$app->get('/projetos', function () {
    GLOBAL $app;
    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $app->response()->header('Title', 'projetos.json');

    GLOBAL $i;
    echo json_encode($i->getProjetos());
});

$app->get('/projetos/:empreendimento', function ($empreendimento) {
    GLOBAL $app;
    GLOBAL $i;

    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $app->response()->header('Title', 'projeto.json');

    echo json_encode($i->getProjetos($empreendimento));
});

$app->get('/projetos/:empreendimento/tecnicos', function ($empreendimento) {
    GLOBAL $app;
    GLOBAL $i;

    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $app->response()->header('Title', 'tecnicos.json');
    echo json_encode($i->getItemsTecnicos($empreendimento));
});

$app->get('/projetos/:empreendimento/contratos', function ($empreendimento) {
    GLOBAL $app;
    GLOBAL $i;

    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $app->response()->header('Title', 'contratos.json');
    echo json_encode($i->getItemsContratos($empreendimento));
});

$app->get('/tecnicos', function () {
    GLOBAL $app;
    GLOBAL $i;

    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $app->response()->header('Title', 't_tecnicos.json');
    echo json_encode($i->getItemsTecnicos());
});

$app->get('/contratos', function () {
    GLOBAL $app;
    GLOBAL $i;

    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $app->response()->header('Title', 'contratos.json');
    echo json_encode($i->getItemsContratos());
});


$app->get('/licencas', function () {
    GLOBAL $app;
    GLOBAL $i;

    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $app->response()->header('Title', 'licencas.json');
    echo json_encode($i->getLicencas());
});

$app->get('/json', function () {
    GLOBAL $app;
    GLOBAL $i;

    $app->response()->header('Content-Type', 'application/json;charset=utf-8');
    $app->response()->header('Title', 'banco.json');
    $result = $i->json();
    $fp = fopen('banco.json', 'w');
    fwrite($fp, json_encode($result));
    fclose($fp);

    //echo json_encode($result);
    echo "Arquivo banco.json criado";
});

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();

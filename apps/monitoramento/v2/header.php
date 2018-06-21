<?php

$host = $_SERVER['HTTP_HOST'];

if (array_key_exists('HTTP_X_FORWARDED_HOST', $_SERVER)) {
    $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
}
$page = str_replace('index.php', '', rtrim($_SERVER['PHP_SELF'], "/\\"));
$uri = 'http://' . $host . $page;
$sys = '';
$stop = 'false';
if (!empty($_REQUEST)) {
    if (array_key_exists('sys', $_REQUEST)) {
        $sys = $_REQUEST['sys'];
    }
    if (array_key_exists('stop', $_REQUEST)) {
        $stop = $_REQUEST['stop'];
    }
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
        $url = $uri . "../otrs/";
        $sys = 'sgr';
        $time = '120';
        break;
    case 'sgrgetic':
        $url = $uri . "../sgrgetic/";
        $sys = 'ani';
        $time = '30';
        break;
    case 'ani':
        $url = $uri . "../aniversariantes/";
        $sys = 'not';
        $time = '57';
        break;
    case 'news':
        $url = $uri . "../noticias/";
        $sys = 'sgr';
        $time = '60';
        break;
    case 'sgr':
        $url = $uri . "../sgr_v2/";
        $sys = 'sgd';
        $time = '60';
        break;
    default:
        $url = $uri . "../aniversariantes/";
        $sys = 'sgd';
        $time = '120';
}


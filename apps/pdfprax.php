<?php

if(!array_key_exists('fatSeqFatura',$_REQUEST)) die ('ACESSO NEGADO');

//$url = 'http://www.cagece.com.br:8180/prax/rest/usuarioJSONBean/downloadSegundaViaFatura';
//$url = 'http://www.cagece.com.br/mobile/usuarioteste/downloadSegundaViaFatura';
//$url = 'http://172.25.131.72:8280/prax/rest/usuarioJSONBean/downloadSegundaViaFatura';
$url = 'http://172.25.131.26:8180/prax/rest/usuarioJSONBean/downloadSegundaViaFatura';
$data = array('login' => '923', 'senha' => 'iDUT6QYh50HMVV9/mABv/Q==', 'fatSeqFatura' => $_REQUEST['fatSeqFatura']);
error_reporting(1);

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$debug = 0;
if(array_key_exists('debug',$_REQUEST)) {
    $debug = (int)$_REQUEST['debug'];
}

if ($debug == 1) {
    var_dump($false);
    var_dump($context);
    var_dump($result);
    die;
}
if ($result != false) {
	header('Content-Description: File Transfer');
	header('Content-type: application/pdf');
	header('Content-Disposition: attachment; filename='.$_REQUEST['fatSeqFatura'].'.pdf');
	header('Content-Transfer-Encoding: binary');
	header('Accept-Ranges: bytes');
	header('Expires: 0');
	header('Content-Length: '. strlen($result));

	//IE8 FIX
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	header("Pragma: public");
	header("X-Content-Type-Options: nosniff");
	header("X-Download-Options: noopen ");

	ob_clean();
	flush();


	echo $result;
} else {
    //echo "<h2>Ocorreu um erro ao gerar a fatura em nosso servidor, tente novamente mais tarde!</h2>";
    echo "<h2>Desculpe-nos, infelizmente este serviço está em manutenção e estará disponível novamente amanhã. Você ainda pode gerar a segunda via de sua fatura no endereço <a href='http://www.cagece.com.br/atendimentovirtual'>www.cagece.com.br/atendimentovirtual</a></h2>";
}
?>

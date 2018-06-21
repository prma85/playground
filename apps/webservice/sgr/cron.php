<?php

// Request Yahoo! REST Web Service using
// HTTP GET with curl. PHP4/PHP5
// Allows retrieval of HTTP status code for error reporting
// Author: Jason Levitt
// February 1, 2006

error_reporting(E_ALL);
$log = fopen("/var/www/html/logs/sgr.log", "a");
fwrite($log, "--------- Inicio do processo ---------\r\n\r\n");
startExec();
// The Web Services request
//request to full database
executeRequest('http://127.0.0.1/apps/sgr/api/json/indicadores', $log);
//request to database in separete files
executeRequest('http://127.0.0.1/apps/sgr/api/json/files', $log);

//fecha o arquivo de log
$msg = " Tempo total de execursao: ".endExec()." s";
print_r($msg);
fwrite ($log,$msg." \r\n");
fwrite($log, "\r\n--------- Fim do processo ---------\r\n\r\n\r\n");
fclose($log);


global $time;
    
/* Get current time */
function getTime(){
	return microtime(TRUE);
}

/* Calculate start time */
function startExec(){
  global $time;
  $time = getTime();
}

/*
* Calculate end time of the script,
* execution time and returns results
*/
function endExec(){
  global $time;
  $finalTime = getTime();
  $execTime = $finalTime - $time;
  $execTime = $execTime * 1000;
  return number_format($execTime, 3);
}

function executeRequest ($request, $log){
    // Initialize the session
    $msg = " [".date('Y/m/d h:i')."] Iniciando Request para ".$request.".";
    print_r($msg);
    fwrite ($log,$msg." \r\n");

    $session = curl_init($request);

    // Set curl options
    curl_setopt($session, CURLOPT_HEADER, true);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

    // Make the request
    $msg = " [".date('Y/m/d h:i')."] Executando Request.";
    print_r($msg);
    fwrite ($log,$msg." \r\n");
    $response = curl_exec($session);

    // Close the curl session
    $msg = " [".date('Y/m/d h:i')."] Fechando Sessao.";
    print_r($msg);
    fwrite ($log,$msg." \r\n");
    curl_close($session);

    // Get HTTP Status code from the response
    $status_code = array();
    preg_match('/\d\d\d/', $response, $status_code);

    // Check the HTTP Status code
    switch( $status_code[0] ) {
            case 200:
                    $msg = " [".date('Y/m/d h:i')."] Finalizado com Sucesso.";
                    break;
            case 503:
                    $msg = (' Your call to Web Services failed and returned an HTTP status of 503. That means: Service unavailable. An internal problem prevented us from returning data to you.');
                    fwrite ($log,$msg." \r\n");
                    break;
            case 403:
                    $msg = (' Your call to Web Services failed and returned an HTTP status of 403. That means: Forbidden. You do not have permission to access this resource, or are over your rate limit.');
                    fwrite ($log,$msg." \r\n");
                    break;
            case 400:
                    // You may want to fall through here and read the specific XML error
                    $msg = (' Your call to Web Services failed and returned an HTTP status of 400. That means:  Bad request. The parameters passed to the service did not match as expected. The exact error is returned in the XML response.');
                    fwrite ($log,$msg." \r\n");
                    break;
            default:
                    $msg = (' Sua requisicao falhou. HTTP status of: ' . $status_code[0]);
                    fwrite ($log,$msg." \r\n");
    }

    print_r($msg);
    fwrite ($log,$msg." \r\n");
    // Get the XML from the response, bypassing the header
    /* if (!($xml = strstr($response, '<?xml'))) {
            $xml = null;
    } */
}
?>
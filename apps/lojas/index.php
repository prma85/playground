<?php
mb_internal_encoding('UTF-8');
function getData($sql,$type='obj', $tag='ID') {
	$conn = oci_new_connect('apl_siga', 'siga_apl', '172.25.131.98:1521/ORAERP');
	if ($conn) {
		$xml = retornaOracle ($conn,$sql,$type,$tag); //retorna a consulta e os totais de cada tipo de chamado
		oci_close($conn);
		return $xml;
	} else {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		getData($sql,$type,$tag);
	}
}

function retornaOracle($conn,$sql, $type='obj', $tag='ID') {

	$lista = array();
	$s = oci_parse($conn,$sql) or die ('Existe um erro na sua consulta SQL');
	oci_execute($s) or die ('Existe um erro na sua consulta SQL <br />'.$sql);
	if ($type == 'assoc') {
		while ($result = oci_fetch_array ($s,OCI_ASSOC+OCI_RETURN_NULLS)){
			$lista[$result[$tag]] = $result;
		}
	} elseif ($type == 'xml') {
		$r = oci_fetch_array($s, OCI_ASSOC);
		$lista = $r['XML']->load();
	} elseif ($type == 'obj') {
		while ($result = oci_fetch_object ($s,OCI_ASSOC+OCI_RETURN_NULLS)){
			$lista[] = $result;
		}
	} elseif ($type == 'array') {
		while ($result = oci_fetch_array ($s,OCI_ASSOC+OCI_RETURN_NULLS)){
			$lista[] = $result;
		}
	} else {
		return false;
	}
	
	return $lista;
}

$doc = new DomDocument('1.0', 'UTF-8');
$now = date("d/m/Y H:i:s");
$r_cidades = array("cidades"=>array());
$cidades = getData("select distinct ENL_DSC_CIDADE cidade from ENL_ENDERECO_LOJA order by ENL_DSC_CIDADE", 'assoc', 'CIDADE');
$result = array();
	
foreach ($cidades as $key=>$c) {
	
	$lojas = array();
	
	$items = getData("select ENL_NOM_LOJA nome, ENL_DSC_LOGRADOURO endereco, ENL_NUM_ENDERECO_LOJA num, ENL_DSC_BAIRRO bairro, ENL_NUM_CODIGO_POSTAL cep, horario, telefone from ENL_ENDERECO_LOJA where trim(ENL_DSC_CIDADE) = '".$c['CIDADE']."' order by ENL_NOM_LOJA", 'assoc', 'NOME');
	
	if (strripos($c['CIDADE'],'(')) {
		$cidade = trim(substr($c['CIDADE'], 0, strripos($c['CIDADE'],'(')));
	} else {
		$cidade = trim($c['CIDADE']);
	}
	$result[$cidade] = array();
	$result[$cidade]['CIDADE'] = $cidade;
	

	$i = 0;
        $nTemp = '';
	foreach ($items as $k=>$l) {
            $pos = false;
            $nTemp;
            if ($i > 0){
                $temp = trim(str_replace('NUCLEO', '', $nTemp));
                $pos = strpos($l['NOME'],$temp);
                if ($temp == trim($l['NOME'])) {
                    $pos = true;
                }
                
                //var_dump($temp);
                //var_dump($l['NOME']);
                //var_dump($pos);
            }
             
            if (!$pos){
		$lojas[$k] = array();
		$lojas[$k]['NOME'] = trim($l['NOME']);
		$lojas[$k]['ENDERECO'] = $l['ENDERECO'].', '.str_replace('SN', 'S/N', $l['NUM']).', '.$l['BAIRRO'].', '.$cidade.' - CE';
		$lojas[$k]['CEP'] = $l['CEP'];
		$lojas[$k]['HORARIO'] = str_replace('as', 'às', $l['HORARIO']);
		$lojas[$k]['TELEFONE'] = '08002750195';
            }
            $i++;
            $nTemp = trim($l['NOME']);
	}
	
	$result[$cidade]['LOJAS'] = $lojas;
}
//die;exit;

$xml = '<?xml version="1.0" encoding="utf-8"?><CIDADES>';
//busca todas as cidades
foreach ($result as $key=>$c) {
	$xml .='<CIDADE><LOCALIDADE>'.$c['CIDADE'].'</LOCALIDADE><LOJAS>';
	//verifica se tem lojas
	foreach ($c["LOJAS"] as $key2=>$l) {
		$xml .='<LOJA>';
		//pega os dados da loja
		foreach ($l as $key3=>$d) {
			if (trim($d)){
				$xml .="<$key3>".trim($d)."</$key3>";
			} else {
				$xml .="<$key3> </$key3>";
			}
		}
		$xml .='</LOJA>';
	}
	$xml .='</LOJAS></CIDADE>';
}
$xml .='</CIDADES>';
$xml = trim(str_replace('"', "'", $xml));

$simpleXml  = simplexml_load_string ($xml);
$simpleXml->asXML ("cidades.xml");
echo '<a href="cidades.xml" taget="_blank">Salvo arquivo cidades.xml</a><br/>';

$fp = fopen('cidades.json', 'w');
fwrite($fp, json_encode($simpleXml));
fclose($fp);
echo '<a href="cidades.json" taget="_blank">Salvo arquivo cidades.json</a><br/>';

//var_dump($r_cidades); die;

//var_dump($cidades);


//$json = json_encode ($xml);
//header("Cache-Control: no-cache, must-revalidate");
//header('Content-type: application/xml');
//header('Content-type: application/json');
//echo $xml;















?>

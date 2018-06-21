<?php
/* primeiro SQL - guardado para consultas futuras
$sql = "select
			t.tn as id,
			t.customer_id as solicitante,
			case when substr(s.name,1,instr(s.name,'::',1)-1) is not null
				then substr(s.name,1,instr(s.name,'::',1)-1)
				else trim(s.name) end as categoria,
			case when substr(s.name,1,instr(s.name,'::',1)-1) is not null
				then substr(s.name,instr(s.name,'::',1)+2,length(s.name))
				else '' end as subcategoria,
			t.title as assunto,
			col.col_dsc_apelido as tecnico,
			uad.uad_sgl_unidade_administrativa as unidade,
			case when tst.name='open' then 'Aberto'
			  when tst.name='new' then 'Novo' end as status,
			to_char(t.create_time,'DD/MM/YYYY HH24:MI:SS') as criacao,
			(to_date('".date("d/m/Y H:i:s")."','DD/MM/RRRR HH24:MI:SS') - to_date(t.create_time,'DD/MM/RRRR HH24:MI:SS'))*24 as decorrido_hora,
			(to_date('".date("d/m/Y H:i:s")."','DD/MM/RRRR HH24:MI:SS') - to_date(t.create_time,'DD/MM/RRRR HH24:MI:SS'))*1440 as decorrido_minuto,
			tst.id as state
		from
			ticket t,
			ticket_state ts,
			ticket_state_type tst,
			service s,
			col_colaborador col,
			uad_unidade_administrativa uad
		where t.type_id=ts.id
			and ts.type_id=tst.id
			and t.service_id=s.id
			and tst.id not in (3,21,41,42,43,44)
			and lower(t.customer_user_id)=trim(lower(col.col_dsc_login))
			and uad.uad_cod_unidade_administrativa=col.uad_cod_unidade_administrativa";

			(to_date('".date("d/m/Y H:i:s")."','DD/MM/RRRR HH24:MI:SS') - to_date(t.criacao,'DD/MM/RRRR HH24:MI:SS'))*1440 as decorrido_minuto
*/

$dataAtual = date("d/m/Y H:i:s");
$sql = "
SELECT t.idchamado AS id,
  CASE
    WHEN t.solicitante IS NULL
    THEN 'Admin OTRS'
    ELSE t.solicitante
  END AS solicitante,
  CASE
    WHEN t.unidade IS NULL
    THEN 'GEINF'
    ELSE t.unidade
  END AS unidade,
  CASE
    WHEN t.categoria IS NULL
    THEN 'Sem categoria'
    ELSE t.categoria
  END AS categoria,
  t.subcategoria,
  CASE
    WHEN t.tecnico IS NULL
    THEN 'S/Atrib'
    ELSE t.tecnico
  END AS tecnico,
  t.assunto,
  t.estado,
  t.criacao,
(to_date('".$dataAtual."','DD/MM/RRRR HH24:MI:SS') - to_date(t.criacao,'DD/MM/RRRR HH24:MI:SS'))*1440 as decorrido_minuto
FROM
  (SELECT t.id AS idchamado,
    (SELECT col.col_dsc_nome
    FROM col_colaborador col
    where t.customer_user_id=trim(lower(col_dsc_login))
    ) AS solicitante,
    CASE
      WHEN SUBSTR(s.name,1,instr(s.name,'::',1)-1) IS NOT NULL
      THEN SUBSTR(s.name,1,instr(s.name,'::',1)-1)
      ELSE trim(s.name)
    END AS categoria,
    CASE
      WHEN SUBSTR(s.name,1,instr(s.name,'::',1)-1) IS NOT NULL
      THEN SUBSTR(s.name,instr(s.name,'::',1)  +2,LENGTH(s.name))
      ELSE ''
    END     AS subcategoria,
    t.title AS assunto,
    (SELECT col.col_dsc_nome
    FROM col_colaborador col,
      users u
    WHERE t.responsible_user_id=u.id
    and u.login                =lower(trim(col.col_dsc_login))
    ) AS tecnico,
    CASE
      WHEN t.ticket_state_id=1
      THEN 'Novo'
      WHEN t.ticket_state_id=4
      THEN 'Aberto'
      WHEN t.ticket_state_id IN (41,42,43,44)
      THEN 'Pendente'
      ELSE TO_CHAR(t.ticket_state_id)
    END AS estado,
    (SELECT uad.uad_sgl_unidade_administrativa
    FROM col_colaborador col,
      uad_unidade_administrativa uad
    WHERE t.customer_user_id              =trim(lower(col_dsc_login))
    and uad.uad_cod_unidade_administrativa=col.uad_cod_unidade_administrativa
    )                                              AS unidade,
    TO_CHAR(t.create_time,'DD/MM/YYYY HH24:MI:SS') AS criacao
  FROM ticket t,
    ticket_state ts,
    service s
  WHERE t.type_id        =ts.id(+)
  AND t.service_id       =s.id(+)
  AND t.ticket_state_id IN (1,4,41,42,43,44)
  order by 1
  ) t
";

$sqlDebug = "SELECT *
		from
			 ticket t,
			 ticket_state ts,
			 ticket_state_type tst,
			 service s,
			 col_colaborador col,
			 uad_unidade_administrativa uad
		where t.type_id=ts.id
		  and ts.type_id=tst.id
		  and t.service_id=s.id
		  and lower(t.customer_user_id)=trim(lower(col.col_dsc_login))
		  and uad.uad_cod_unidade_administrativa=col.uad_cod_unidade_administrativa
		ORDER BY T.CREATE_TIME desc";
		
 /* Declaração dos arrays de objetos */


GLOBAL $abertos;
GLOBAL $fechadosHoje;
GLOBAL $fechadosMes;
GLOBAL $pendentes;
getData($sql);

//debug para correção de erros
//echo '<pre>'; //serve para formatar a saida
//$debug = retornaOracle ($sqlDebug);
//var_dump ($abertos); //mostra a saida
//echo '</pre>'; //fecha tag de saida

function getData($sql) {
	GLOBAL $abertos;
	GLOBAL $fechadosHoje;
	GLOBAL $fechadosMes;
	GLOBAL $pendentes;
	$conn = oci_new_connect('OTRS', '0TRS', '172.25.131.73:1521/CGORA2','AL32UTF8');
	if ($conn) {
		$abertos = retornaOracle ($conn,$sql,1); //retorna a consulta e os totais de cada tipo de chamado
		$fechadosHoje	= retornaOracle ($conn,"select count (*) as total from ticket where ticket_state_id in (2,3,21) and TO_CHAR(change_time,'DD/MM/YYYY') = TO_CHAR(sysdate,'DD/MM/YYYY')");
		$fechadosMes = retornaOracle ($conn,"select count (*) as total from ticket where ticket_state_id in (2,3,21) and TO_CHAR(change_time,'MM/YYYY') = TO_CHAR(SYSDATE,'MM/YYYY') AND change_time<=LAST_DAY(SYSDATE)");
		$pendentes = retornaOracle ($conn,"select count (*) as total from ticket where ticket_state_id in (1,4,41,42,43,44) and TO_CHAR(change_time,'MM/YYYY') = TO_CHAR(SYSDATE,'MM/YYYY')");
		oci_close($conn);
	} else {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		getData($sql);
	}
}

function retornaOracle($conn,$sql, $total=0) {
	//PutEnv("ORACLE_SID=CGORA2");
	//PutEnv("ORACLE_HOME=/opt/oracle_10_2");
	//PutEnv("TNS_ADMIN=/opt/oracle_10_2");
	
	$lista = array();
	$prepare = '';
	$i = 0;
	$verde = $amarelo = $laranja = $vermelho = $preto = $hoje = $mes = $finalizados_mes = $finalizados_dia = 0;
	
	
	
	$prepare = oci_parse($conn,$sql) or die ('Existe um erro na sua consulta SQL');
	oci_execute($prepare) or die ('Existe um erro na sua consulta SQL <br />'.$sql);
	while ($result = oci_fetch_object($prepare,OCI_ASSOC)){
		$lista[$i] = $result;
		
		if (isset($lista[$i]->CRIACAO)){
			if (isset($lista[$i]->DECORRIDO_MINUTO)) {
				$lista[$i]->DECORRIDO_MINUTO = number_format($lista[$i]->DECORRIDO_MINUTO,4,',','');
				
				if ($lista[$i]->DECORRIDO_MINUTO <= 60) {
					$lista[$i]->STATUS = "verde";
					$verde++;
				} elseif ($lista[$i]->DECORRIDO_MINUTO > 60 && $lista[$i]->DECORRIDO_MINUTO <= 120) {
					$lista[$i]->STATUS = "amarelo";
					$amarelo++;
				} elseif ($lista[$i]->DECORRIDO_MINUTO > 120 && $lista[$i]->DECORRIDO_MINUTO <= 240) {
					$lista[$i]->STATUS = "laranja";
					$laranja++;
				} elseif ($lista[$i]->DECORRIDO_MINUTO > 240 && $lista[$i]->DECORRIDO_MINUTO <= 1440) {
					$lista[$i]->STATUS = "vermelho";
					$vermelho++;
				} elseif ($lista[$i]->DECORRIDO_MINUTO > 1440) {
					$lista[$i]->STATUS = "preto";
					$preto++;
				}
			}
		}
		
		if (isset($lista[$i]->ESTADO)){
			if ($lista[$i]->ESTADO == "Novo") {
				//$lista[$i]->ID = $lista[$i]->ID." (Novo)";
			}
		}
		
		if (isset($lista[$i]->SOLICITANTE)){
			$lista[$i]->SOLICITANTE = trim(ucwords(strtolower(htmlentities($lista[$i]->SOLICITANTE))));
		}
		
		if (isset($lista[$i]->TECNICO)){
			$lista[$i]->TECNICO = trim(ucwords(strtolower(htmlentities($lista[$i]->TECNICO))));
		}
		
		if (isset($lista[$i]->UNIDADE)){
			$lista[$i]->UNIDADE=trim($lista[$i]->UNIDADE);
		}
		
		$i++;
	}
		
	if (count($lista) != 0) {
		if ($total==1) {
			foreach ($lista as $item) {
				$item->TOTAL = $i;
				
				if (isset($item->STATUS)){
					$item->TOTAL_VERDE = str_pad($verde, 3, "0", STR_PAD_LEFT);
					$item->TOTAL_AMARELO = str_pad($amarelo, 3, "0", STR_PAD_LEFT);
					$item->TOTAL_LARANJA = str_pad($laranja, 3, "0", STR_PAD_LEFT);
					$item->TOTAL_VERMELHO = str_pad($vermelho, 3, "0", STR_PAD_LEFT);
					$item->TOTAL_PRETO = str_pad($preto, 3, "0", STR_PAD_LEFT);
					
				}
			}
		}
	}
	
	if (count($lista) == 1) {
		$obj = $lista[0];
		$lista = $obj;
		if (isset($lista->TOTAL)){
			$string = $lista->TOTAL;
			$lista = (int)$string;
		}
	}
	
	if (count($lista) == 0) {
		$lista = null;
	}
	
	return $lista;
}

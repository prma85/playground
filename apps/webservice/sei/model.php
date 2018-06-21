<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../libs/oracle.php');

class indicadoresSEI extends modelOracle {

    var $list;
    var $host = '172.25.131.77';
    var $user = 'apl_dw_user';
    var $password = 'apl_dw_user';
    var $sid = 'ORADW';
    var $port = '1521';
    var $socket = '';

    //(ici.pcm_cod_ano*100) anomes
    public function estado($ano = NULL) {
        $list = array();
        self::listaMesAno();
        $list["ANOS"] = $this->list;

        foreach ($list["ANOS"] as $ano => $l) {
            $sql = "select round((sum(ici.pop_qtd_econ_coberta_esgoto)/sum(ici.pop_qtd_econ_total_agua))*100, 4) as total from a_ici_indicadores_com_integra ici where ici.pcm_cod_ano = '".$ano."' group by ici.pcm_cod_ano ,ici.pcm_cod_mes";
            $tempResult = self::execute($sql);
            if ($tempResult && $tempResult[0]->TOTAL > 0) {
                $sqlEstado = "select 
                    (ici.pcm_cod_ano*100 + ici.pcm_cod_mes) anomes				  
                    ,SUM(ici.fat_vlr_faturado_liq_agua) as vlr_fatLiqA  
                    ,SUM(ici.fat_vlr_faturado_liq_esgoto) as vlr_fatLiqE  
                    ,SUM(ici.fat_vol_faturado_liq_agua) as vol_fatLiqA
                    ,SUM(ici.fat_vol_faturado_liq_esgoto) as vol_fatLiqE  
                    ,SUM(ici.cli_qtd_nova_ligacao_agua) as qtd_novLigA
                    ,SUM(ici.cli_qtd_nova_ligacao_esgoto) as qtd_novLigE
                    ,SUM(ici.cli_qtd_economia) as qtd_eco
                    ,SUM(ici.arc_vlr_arrec_total) as vlr_arrTot
                    ,round((sum(ici.pop_qtd_econ_coberta_agua)/sum(ici.pop_qtd_econ_total_agua))*100, 4) as cob_A  
                    ,round((sum(ici.pop_qtd_econ_coberta_esgoto)/sum(ici.pop_qtd_econ_total_agua))*100, 4) as cob_e    
                  from a_ici_indicadores_com_integra ici
                  where ici.pcm_cod_ano = '$ano'
                  group by ici.pcm_cod_ano ,ici.pcm_cod_mes
                  order by anomes desc";

                $result = self::execute($sqlEstado);
                
                foreach ($result as $r){
                    $list[$r->ANOMES] = $r;
                }
            } else {
                unset($list["ANOS"][$ano]);
            }
        }
        return $list;
    }

    public function negocio($ano = NULL) {

        $unidades = array(11 => "UN-BAC", 17 => "UN-BAJ", 15 => "UN-BBA", 16 => "UN-BBJ", 12 => "UN-BCL", 13 => "UN-BME", 14 => "UN-BPA", 18 => "UN-BSA", 19 => "UN-BSI", 1 => "UN-MTL", 3 => "UN-MTN", 4 => "UN-MTO", 2 => "UN-MTS");
        $list = array();

        foreach ($unidades as $key => $u) {
            //$list[$u] = new stdClass();
            $list[$u] = $this->negocio_dados($u, $ano);
            self::listaMesAno("gel.gel_seq_localidade=ici.gel_seq_localidade and gel.geo_dsc_unidade_negocio = '" . $u . "'");
            $list[$u]["ANOS"] = $this->list;
        }

        return $list;
    }

    public function negocio_dados($unidade, $ano = NULL) {
        $sql = "select 
				  (ici.pcm_cod_ano*100 + ici.pcm_cod_mes) anomes
				  --,ici.pcm_cod_ano
				  --,ici.pcm_cod_mes
				  ,SUM(ici.fat_vlr_faturado_liq_agua) as vlr_fatLiqA  
				  ,SUM(ici.fat_vlr_faturado_liq_esgoto) as vlr_fatLiqE  
				  ,SUM(ici.fat_vol_faturado_liq_agua) as vol_fatLiqA
				  ,SUM(ici.fat_vol_faturado_liq_esgoto) as vol_fatLiqE  
				  --,SUM(ici.fat_qtd_ligacao_faturada) as qtd_ligFat
				  ,SUM(ici.cli_qtd_nova_ligacao_agua) as qtd_novLigA
				  ,SUM(ici.cli_qtd_nova_ligacao_esgoto) as qtd_novLigE
				  ,SUM(ici.cli_qtd_economia) as qtd_eco
				  ,SUM(ici.arc_vlr_arrec_total) as vlr_arrTot
				  ,round((sum(ici.pop_qtd_econ_coberta_agua)/sum(ici.pop_qtd_econ_total_agua))*100, 4) as cob_a  
				  ,round((sum(ici.pop_qtd_econ_coberta_esgoto)/sum(ici.pop_qtd_econ_total_agua))*100, 4) as cob_e    
				from a_ici_indicadores_com_integra ici
					 ,v_gel_geografia_localidade gel
				where gel.gel_seq_localidade=ici.gel_seq_localidade 
						and gel.geo_dsc_unidade_negocio = '$unidade' ";
        if ($ano) {
            $sql .=" and ici.pcm_cod_ano = $ano";
        }

        $sql .="group by 
			   ici.pcm_cod_ano
			  ,ici.pcm_cod_mes
			  ,gel.geo_cod_unidade_negocio
			  ,gel.geo_dsc_unidade_negocio
			order by anomes, gel.geo_dsc_unidade_negocio asc;";

        $result = self::execute($sql);

        $list = array();
        foreach ($result as $r) {
            $list[$r->ANOMES] = $r;
        }

        // RETORNA ANOS DAS UNS
        $sql = "SELECT (ici.pcm_cod_ano*100) anomes,
				  gel.geo_cod_unidade_negocio as cod_un ,
				  gel.geo_dsc_unidade_negocio as dsc_un,
				  SUM(ici.fat_vlr_faturado_liq_agua)   as vlr_fatLiqA ,
				  SUM(ici.fat_vlr_faturado_liq_esgoto) as vlr_fatLiqE ,
				  SUM(ici.fat_vol_faturado_liq_agua)   as vol_fatLiqA ,
				  SUM(ici.fat_vol_faturado_liq_esgoto) as vol_fatLiqE ,
				  --SUM(ici.fat_qtd_ligacao_faturada)    as qtd_ligFat ,
				  SUM(ici.cli_qtd_nova_ligacao_agua)   as qtd_novLigA ,
				  SUM(ici.cli_qtd_nova_ligacao_esgoto) as qtd_novLigE ,
				  (SELECT SUM(aux.cli_qtd_economia)
				  FROM a_ici_indicadores_com_integra aux ,
					v_gel_geografia_localidade gelaux
				  WHERE gelaux.gel_seq_localidade   =aux.gel_seq_localidade
				  AND gelaux.geo_cod_unidade_negocio=gel.geo_cod_unidade_negocio
				  AND aux.pcm_cod_ano               =ici.pcm_cod_ano
				  AND aux.pcm_cod_mes               =
					(SELECT MAX(aux2.pcm_cod_mes)
					FROM a_ici_indicadores_com_integra aux2
					WHERE aux2.pcm_cod_ano=ici.pcm_cod_ano
					)
				  )                            as qtd_eco ,
				  SUM(ici.arc_vlr_arrec_total) as vlr_arrTot ,
				  (SELECT ROUND((SUM(aux.pop_qtd_econ_coberta_agua)/SUM(aux.pop_qtd_econ_total_agua))*100, 4)
				  FROM a_ici_indicadores_com_integra aux ,
					v_gel_geografia_localidade gelaux
				  WHERE gelaux.gel_seq_localidade   =aux.gel_seq_localidade
				  AND gelaux.geo_cod_unidade_negocio=gel.geo_cod_unidade_negocio
				  AND aux.pcm_cod_ano               =ici.pcm_cod_ano
				  AND aux.pcm_cod_mes               =
					(SELECT MAX(aux2.pcm_cod_mes)
					FROM a_ici_indicadores_com_integra aux2
					WHERE aux2.pcm_cod_ano=ici.pcm_cod_ano
					)
				  ) as cob_a ,
				  (SELECT ROUND((SUM(aux.pop_qtd_econ_coberta_esgoto)/SUM(aux.pop_qtd_econ_total_agua))*100, 4)
				  FROM a_ici_indicadores_com_integra aux ,
					v_gel_geografia_localidade gelaux
				  WHERE gelaux.gel_seq_localidade   =aux.gel_seq_localidade
				  AND gelaux.geo_cod_unidade_negocio=gel.geo_cod_unidade_negocio
				  AND aux.pcm_cod_ano               =ici.pcm_cod_ano
				  AND aux.pcm_cod_mes               =
					(SELECT MAX(aux2.pcm_cod_mes)
					FROM a_ici_indicadores_com_integra aux2
					WHERE aux2.pcm_cod_ano=ici.pcm_cod_ano
					)
				  ) as cob_e
				FROM a_ici_indicadores_com_integra ici ,
				  v_gel_geografia_localidade gel
				WHERE gel.geo_dsc_unidade_negocio = '$unidade'
				AND gel.gel_seq_localidade=ici.gel_seq_localidade
				GROUP BY ici.pcm_cod_ano ,
				  gel.geo_cod_unidade_negocio ,
				  gel.geo_dsc_unidade_negocio";

        $negocio_anos = self::execute($sql);

        foreach ($negocio_anos as $ano) {
            $list[$ano->ANOMES] = $ano;
        }

        return $list;
    }

    public function cidades() {
        $sql = "select distinct geo_cod_localidade cod, geo_dsc_localidade loc from v_gel_geografia_localidade order by loc;";
        return self::execute($sql);
    }

    public function localidadesUNs() {
        $sql = "select distinct geo_cod_localidade cod, geo_dsc_localidade loc, geo_dsc_unidade_negocio un from v_gel_geografia_localidade order by un, loc;";
        $localidadesUns = self::execute($sql);

        //foreach ($localidadesUns as $item){
        //    $list[$item->UN][$item->COD] = $item->LOC;
        //}
        //return $list;
        return $localidadesUns;
    }

    public function localidade($ano = NULL) {

        $result = $this->cidades();
        $list = array();
        foreach ($result as $c) {
            $list[$c->COD] = new stdClass();
            $list[$c->COD]->LOC = $c->LOC;
            self::listaMesAno("gel.gel_seq_localidade=ici.gel_seq_localidade	and gel.geo_cod_localidade = '" . $c->COD . "'");
            $list[$c->COD]->ANOS = $this->list;
            $list[$c->COD]->DADOS = $this->localidade_dados($c->COD, $ano);
        }

        return $list;
    }

    public function localidade_dados($cod, $ano = NULL) {
        $sql = "select  
			  (ici.pcm_cod_ano*100 + ici.pcm_cod_mes) anomes
			  --,ici.pcm_cod_ano
			  --,ici.pcm_cod_mes
			  --,gel.geo_cod_localidade
			  --,gel.geo_dsc_localidade
			  --,SUM(ici.fat_vlr_faturado_bruto_agua) as fat_vlr_faturado_bruto_agua
			  --,SUM(ici.fat_vlr_faturado_bruto_esgoto) as fat_vlr_faturado_bruto_esgoto  
			  ,SUM(ici.fat_vlr_faturado_liq_agua) as vlr_fatLiqA  
			  ,SUM(ici.fat_vlr_faturado_liq_esgoto) as vlr_fatLiqE  
			  ,SUM(ici.fat_vol_faturado_liq_agua) as vol_fatLiqA
			  ,SUM(ici.fat_vol_faturado_liq_esgoto) as vol_fatLiqE  
			  --,SUM(ici.fat_qtd_ligacao_faturada) as qtd_ligFat
			  ,SUM(ici.cli_qtd_nova_ligacao_agua) as qtd_novLigA
			  ,SUM(ici.cli_qtd_nova_ligacao_esgoto) as qtd_novLigE
			  ,SUM(ici.cli_qtd_economia) as qtd_eco
			  ,SUM(ici.arc_vlr_arrec_total) as vlr_arrTot
			  ,case when sum(ici.pop_qtd_econ_total_agua)=0 then
				 0
			   else  
				 round((sum(ici.pop_qtd_econ_coberta_agua)/sum(ici.pop_qtd_econ_total_agua))*100, 4) end cob_a  
			  ,case when sum(ici.pop_qtd_econ_total_agua)=0 then
				 0
			   else  
				 round((sum(ici.pop_qtd_econ_coberta_esgoto)/sum(ici.pop_qtd_econ_total_agua))*100, 4) end cob_e  
				 
			from a_ici_indicadores_com_integra ici
				 ,v_gel_geografia_localidade gel
			where gel.gel_seq_localidade=ici.gel_seq_localidade
			and gel.geo_cod_localidade = $cod";
        if ($ano) {
            $sql .=" and ici.pcm_cod_ano = $ano";
        }

        $sql .="group by 
			   ici.pcm_cod_ano
			  ,ici.pcm_cod_mes
			  ,gel.geo_cod_localidade
			  ,gel.geo_dsc_localidade
			order by anomes asc;";

        $result = self::execute($sql);

        $list = array();
        foreach ($result as $r) {
            $list[$r->ANOMES] = $r;
        }

        $sql = "SELECT (ici.pcm_cod_ano*100) anomes,
				  gel.geo_cod_localidade as codLoc,
				  gel.geo_dsc_localidade as dscLoc,
				  SUM(ici.fat_vlr_faturado_liq_agua)   as vlr_fatLiqA ,
				  SUM(ici.fat_vlr_faturado_liq_esgoto) as vlr_fatLiqE ,
				  SUM(ici.fat_vol_faturado_liq_agua)   as vol_fatLiqA ,
				  SUM(ici.fat_vol_faturado_liq_esgoto) as vol_fatLiqE ,
				  --SUM(ici.fat_qtd_ligacao_faturada)    as qtd_ligFat ,
				  SUM(ici.cli_qtd_nova_ligacao_agua)   as qtd_novLigA ,
				  SUM(ici.cli_qtd_nova_ligacao_esgoto) as qtd_novLigE ,
				  (SELECT SUM(aux.cli_qtd_economia)
				  FROM a_ici_indicadores_com_integra aux ,
					v_gel_geografia_localidade gelaux
				  WHERE gelaux.gel_seq_localidade   =aux.gel_seq_localidade
				  AND gelaux.geo_cod_localidade=gel.geo_cod_localidade
				  AND aux.pcm_cod_ano               =ici.pcm_cod_ano
				  AND aux.pcm_cod_mes               =
					(SELECT MAX(aux2.pcm_cod_mes)
					FROM a_ici_indicadores_com_integra aux2
					WHERE aux2.pcm_cod_ano=ici.pcm_cod_ano
					)
				  )                            as qtd_eco ,
				  SUM(ici.arc_vlr_arrec_total) as vlr_arrTot ,
				  (SELECT ROUND((SUM(aux.pop_qtd_econ_coberta_agua)/nullif(SUM(aux.pop_qtd_econ_total_agua),0))*100, 4)
				  FROM a_ici_indicadores_com_integra aux ,
					v_gel_geografia_localidade gelaux
				  WHERE gelaux.gel_seq_localidade   =aux.gel_seq_localidade
				  AND gelaux.geo_cod_localidade=gel.geo_cod_localidade
				  AND aux.pcm_cod_ano               =ici.pcm_cod_ano
				  AND aux.pcm_cod_mes               =
					(SELECT MAX(aux2.pcm_cod_mes)
					FROM a_ici_indicadores_com_integra aux2
					WHERE aux2.pcm_cod_ano=ici.pcm_cod_ano
					)
				  ) as cob_a ,
				  (SELECT ROUND((SUM(aux.pop_qtd_econ_coberta_esgoto)/nullif(SUM(aux.pop_qtd_econ_total_agua),0))*100, 4)
				  FROM a_ici_indicadores_com_integra aux ,
					v_gel_geografia_localidade gelaux
				  WHERE gelaux.gel_seq_localidade   =aux.gel_seq_localidade
				  AND gelaux.geo_cod_localidade=gel.geo_cod_localidade
				  AND aux.pcm_cod_ano               =ici.pcm_cod_ano
				  AND aux.pcm_cod_mes               =
					(SELECT MAX(aux2.pcm_cod_mes)
					FROM a_ici_indicadores_com_integra aux2
					WHERE aux2.pcm_cod_ano=ici.pcm_cod_ano
					)
				  ) as cob_e
				FROM a_ici_indicadores_com_integra ici ,
				  v_gel_geografia_localidade gel
				WHERE gel.geo_cod_localidade = $cod
				AND gel.gel_seq_localidade=ici.gel_seq_localidade
				GROUP BY ici.pcm_cod_ano ,
				  gel.geo_cod_localidade ,
				  gel.geo_dsc_localidade;";

        $localidade_anos = self::execute($sql);

        foreach ($localidade_anos as $ano) {
            $list[$ano->ANOMES] = $ano;
        }



        return $list;
    }

    public function json() {
        $result = Array();

        $result['ESTADO'] = $this->estado();
        $result['NEGOCIO'] = $this->negocio();
        $result['CIDADES'] = $this->cidades();
        $result['LOCALIDADESUNS'] = $this->localidadesUNs();
        $result['LOCALIDADE'] = $this->localidade();


        return $result;
    }

    protected function retornaMes($mes) {
        switch ($mes) {
            case 1: $mes = 'Janeiro';
                break;
            case 2: $mes = 'Fevereiro';
                break;
            case 3: $mes = 'Março';
                break;
            case 4: $mes = 'Abril';
                break;
            case 5: $mes = 'Maio';
                break;
            case 6: $mes = 'Junho';
                break;
            case 7: $mes = 'Julho';
                break;
            case 8: $mes = 'Agosto';
                break;
            case 9: $mes = 'Setembro';
                break;
            case 10: $mes = 'Outubro';
                break;
            case 11: $mes = 'Novembro';
                break;
            case 12: $mes = 'Dezembro';
                break;
        }
        return $mes;
    }

    public function jsonAtual() {
        $atual = Array();
        $ano = date('Y');


        return $atual;
    }

    public function listaMesAno($where = null, $ano = null, $list = null) {
        if (!$ano) {
            $ano = date('Y');
        }

        $sql = "select distinct ici.pcm_cod_mes  from a_ici_indicadores_com_integra ici, v_gel_geografia_localidade gel where pcm_cod_ano = " . $ano;
        if ($where) {
            $sql .= " and " . $where;
        }

        $sql .= " order by ici.pcm_cod_mes;";

        $result = self::execute($sql);
        if ($result) {
            $listaAnos = array();
            foreach ($result as $key => $r) {
                //$listaAnos[$key] = new stdClass();
                //$listaAnos[$key]->MES = self::retornaMes($r->PCM_COD_MES);
                //$listaAnos[$key]->CODMES = $r->PCM_COD_MES;
                $listaAnos[$key] = $r->PCM_COD_MES;
            }

            $list[$ano] = $listaAnos;
            $ano--;

            self::listaMesAno($where, $ano, $list);
        } else {
            $this->list = $list;
        }
    }

}

?>

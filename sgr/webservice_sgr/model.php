<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../libs/oracle.php');

class indicadoresGerenciais extends modelOracle {
   /* var $host = '172.25.131.73';
    var $user = 'APL_INDICADORES';
    var $password = 'APL_IND';
    var $sid = 'CGORA2';
    var $port = '1521';
    var $socket = '';
	*/
	
	var $_conn;
    var $host = '172.25.131.73';
    var $user = 'indicadores';
    var $password = '1nd1ca';
    var $sid = 'cgora2';
    var $port = '1521';
    var $socket = '';

    public function getAll($ano = NULL, $obj = NULL) {

        $sql = "SELECT 	distinct ind.ind_cod_indicador, 
                    ind.ind_nom_indicador, 
                    ind.ind_dsc_indicador,
                    ind.ind_sgl_indicador, 
                    obj.obj_dsc_objetivo, 
                    obj.obj_num_competencia, 
                    unm.unm_dsc_und_medida, 
                    ind.ind_tip_periodicidade,
                    TO_CHAR(ind_dat_inclusao, 'YYYY') IND_ANO_CRIACAO
                FROM 	ind_indicador ind, unm_unidade_medida unm, obj_objetivo obj, uad_unidade_administrativa uad, idd_indicador_dimensao idd
                WHERE 	ind.unm_cod_und_medida = unm.unm_cod_und_medida
                    and ind.uad_cod_unidade_administrativa = uad.uad_cod_unidade_administrativa (+)
                    and idd.ind_cod_indicador = ind.ind_cod_indicador
                    and ind.obj_cod_objetivo = obj.obj_cod_objetivo
                    and ind.cli_cod_classe_indicador = 2
                    and ind.ind_flg_corporativo = 'S'
                    and obj.obj_num_ordem_apres <> 99
                    and ind.ind_dat_exclusao is null";
        if ($ano) {
            $sql .=" and obj.obj_num_competencia = $ano";
        }

        if ($obj) {
            $sql .=" and ind.obj_cod_objetivo = $obj";
        }
        $sql .=" ORDER BY ind.ind_nom_indicador;";

        $result = self::execute($sql);
        return $result;
    }

    public function getIndicador($id) {

        $sql = "SELECT 	distinct ind.ind_cod_indicador, 
                    ind.ind_nom_indicador, 
                    ind.ind_dsc_indicador,
                    ind.ind_sgl_indicador, 
                    obj.obj_dsc_objetivo, 
                    obj.obj_num_competencia, 
                    unm.unm_dsc_und_medida, 
                    ind.ind_tip_periodicidade,
                    TO_CHAR(ind_dat_inclusao, 'YYYY') IND_ANO_CRIACAO
                FROM 	ind_indicador ind, unm_unidade_medida unm, obj_objetivo obj, uad_unidade_administrativa uad, idd_indicador_dimensao idd
                WHERE 	ind.unm_cod_und_medida = unm.unm_cod_und_medida
                    and ind.uad_cod_unidade_administrativa = uad.uad_cod_unidade_administrativa (+)
                    and idd.ind_cod_indicador = ind.ind_cod_indicador
                    and ind.obj_cod_objetivo = obj.obj_cod_objetivo
                    and ind.IND_COD_INDICADOR = $id";

        $result = self::execute($sql);
        if ($result) {
            $result = $result[0];
        }
        return $result;
    }
	
	public function getIndicadores() {

        $sql = "SELECT DISTINCT ind.ind_cod_indicador,
				  ind.ind_nom_indicador
				FROM ind_indicador ind,
				  unm_unidade_medida unm,
				  obj_objetivo obj,
				  uad_unidade_administrativa uad,
				  idd_indicador_dimensao idd
				WHERE ind.unm_cod_und_medida           = unm.unm_cod_und_medida
				AND ind.uad_cod_unidade_administrativa = uad.uad_cod_unidade_administrativa (+)
				AND idd.ind_cod_indicador              = ind.ind_cod_indicador
				AND ind.obj_cod_objetivo               = obj.obj_cod_objetivo";

        $result = self::execute($sql);
        return $result;
    }

    public function getItem($id, $ano = NULL) {
        $ano2 = $ano;
        if ($ano == NULL || $ano == '') {
            $ano = '' . date("Y") . '';
        }
		
        $result = Array();

        $sql = "select IDD.IND_COD_INDICADOR INDICADOR,
                to_char(idd.idd_dat_referencia_meta, 'yyyymm') anomes,
                trim(IND.IND_SENTIDO_INDICADOR) SENTIDO,
                idd.idd_vlr_meta previsto,
                cin.cin_vlr_valor realizado,
                round(fc_percent_atingido(ind.ind_cod_indicador, 
                to_number(to_char(idd.idd_dat_referencia_meta, 'yyyy')), 
                to_number(to_char(idd.idd_dat_referencia_meta, 'mm')), 
                ind.ind_sentido_indicador, ind.ind_flg_posicao_inicial, 
                idd.idd_cod_dimensao),2) atingido,
                CASE
                      WHEN (ind.ind_sentido_indicador = 1
                      AND idd.idd_vlr_meta            > 0)
                      THEN ROUND(((cin.cin_vlr_valor    /idd.idd_vlr_meta) * 100)-100,2)
                      WHEN (ind.ind_sentido_indicador = -1
                      AND idd.idd_vlr_meta            > 0 )
                      THEN ROUND((100 - (((cin.cin_vlr_valor/idd.idd_vlr_meta) * 100) - 100)) - 100,2)
                      ELSE 0
                END desvio,
                CASE
                      WHEN cin.cin_vlr_valor IS NULL
                      THEN
                        (SELECT SUM(cin_vlr_valor)
                        FROM cin_consulta_indicador t
                        WHERE t.ind_cod_indicador = idd.ind_cod_indicador
                        AND t.cin_cod_dimensao    = idd.idd_cod_dimensao
                        AND t.val_dat_referencia  =
                              (SELECT MAX(val_dat_referencia)
                              FROM cin_consulta_indicador
                              WHERE ind_cod_indicador = t.ind_cod_indicador
                              AND cin_cod_dimensao    = t.cin_cod_dimensao))
                      ELSE cin.cin_vlr_valor
                END REAL_GRAF,
                ind.ind_exb_decimal exb_decimal,
                FC_STATUS_INDICADOR_MENSAL(NVL(IDD.IDD_VLR_META, 0), NVL(CIN.CIN_VLR_VALOR, 0), 
                NVL((SELECT cin_vlr_valor
                      from cin_consulta_indicador
                      WHERE TO_CHAR(val_dat_referencia, 'yyyymm') = to_char(add_months(idd.idd_dat_referencia_meta,-1), 'yyyymm')
                      AND cin_cod_dimensao                        = idd.idd_cod_dimensao
                      AND cin_flg_dimensao                        = idd.idd_flg_dimensao
                      and ind_cod_indicador                       = ind.ind_cod_indicador), 0),  
                      NVL((SELECT cin_vlr_valor
                      FROM CIN_CONSULTA_INDICADOR
                      WHERE TO_CHAR(val_dat_referencia, 'mm') = '12'
                      AND cin_cod_dimensao                        = idd.idd_cod_dimensao
                      AND cin_flg_dimensao                        = idd.idd_flg_dimensao
                      AND IND_COD_INDICADOR                       = IND.IND_COD_INDICADOR
                      and to_char(val_dat_referencia, 'YYYY') =  to_char(add_months(idd.idd_dat_referencia_meta,-12),'yyyy')), 0), 
                      IND.IND_SENTIDO_INDICADOR, IND.IND_FLG_POSICAO_INICIAL) STATUS,
                      unm.unm_dsc_und_medida medida,
                      ind.ind_tip_periodicidade periodicidade
              FROM cin_consulta_indicador cin,
                idd_indicador_dimensao idd,
                ind_indicador ind,
                unm_unidade_medida unm
              WHERE cin.ind_cod_indicador(+)                   = idd.ind_cod_indicador
              AND cin.cin_cod_dimensao(+)                      = idd.idd_cod_dimensao
              AND cin.val_dat_referencia(+)                    = idd.idd_dat_referencia_meta
              AND idd.ind_cod_indicador                        = ind.ind_cod_indicador
              AND ind.unm_cod_und_medida						 = unm.unm_cod_und_medida
              AND ind.ind_flg_corporativo                      = 'S'
              and idd.idd_flg_dimensao                         = 'S'
              and to_char(idd.idd_dat_referencia_meta, 'yyyy') = '$ano'
              and IDD.IND_COD_INDICADOR = '$id';";

        $list = self::execute($sql);

        $ano_anterior = (((int) $ano) - 1);
        if (empty($list) && $ano2 == NULL) {
            $list = $this->getItem($id, $ano_anterior);
        }

        $sql_dezembro = "SELECT TO_CHAR(idd.idd_dat_referencia_meta, 'yyyymm') anomes,
            idd.idd_vlr_meta previsto,
            cin.cin_vlr_valor realizado,
            ROUND(fc_percent_atingido(ind.ind_cod_indicador, to_number(TO_CHAR(idd.idd_dat_referencia_meta, 'yyyy')), to_number(TO_CHAR(idd.idd_dat_referencia_meta, 'mm')), ind.ind_sentido_indicador, ind.ind_flg_posicao_inicial, idd.idd_cod_dimensao),2) atingido
          FROM cin_consulta_indicador cin,
            idd_indicador_dimensao idd,
            ind_indicador ind
          WHERE cin.ind_cod_indicador(+)                   = idd.ind_cod_indicador
          AND cin.cin_cod_dimensao(+)                      = idd.idd_cod_dimensao
          AND cin.val_dat_referencia(+)                    = idd.idd_dat_referencia_meta
          AND idd.ind_cod_indicador                        = ind.ind_cod_indicador
          and idd.ind_cod_indicador                        = '$id'
          AND TO_CHAR(idd.idd_dat_referencia_meta, 'yyyymm') = '" . $ano_anterior . "12'
	ORDER BY 1;";
        $dezembro = self::execute($sql_dezembro);
        if ($dezembro != NULL) {
            $dezembro = $dezembro[0];
        }

        if ($list != NULL && !empty($list)) {

            foreach ($list as $item) {
                $key = (int) $item->ANOMES;

                if (!property_exists($item, 'REALIZADO')) {
                    $result[$key] = new stdClass();
                    $result[$key]->ANOMES = $item->ANOMES;
                    $result[$key]->PREVISTO = $item->PREVISTO;
                    $result[$key]->REALIZADO = ' ';
                    $result[$key]->ATINGIDO = ' ';
                    $result[$key]->DESVIO = ' ';
                    $result[$key]->REAL_GRAF = ' ';
                    $result[$key]->STATUS = $item->STATUS;
                    $result[$key]->PERIODICIDADE = $item->PERIODICIDADE;
                    $result[$key]->MEDIDA = $item->MEDIDA;
                } else {
                    if (($item->SENTIDO == "1" || $item->SENTIDO == 1) && floatval($item->PREVISTO) > 0) {
                        $atingido = ($item->REALIZADO / $item->PREVISTO) * 100;
                    } else {
                        $atingido = ($item->PREVISTO / $item->REALIZADO) * 100;
                    }
                    $item->ATINGIDO = number_format($atingido, 2, '.', '');
                    $item->VARIACAO = number_format($atingido, 2, ',', ' ') . '%';
                    $result[$key] = $item;
                }
                $mes = (int) substr($item->ANOMES, -2);
                $result[$key]->MES = $this->retornaMes($mes);
                $result[$key]->ANO = substr($item->ANOMES, 0, 4);

                if (property_exists($item, 'EXB_DECIMAL') == TRUE) {
                    $result[$key]->EXB_DECIMAL = $item->EXB_DECIMAL;
                } else {
                    $result[$key]->EXB_DECIMAL = 'N';
                }
            }

            $key2 = $ano . "12";

            if (!array_key_exists($key2, $result)) {
                $result[$key2] = new stdClass;
            }
            $result[$key2]->ANO_ANTERIOR = FALSE;
            if ($dezembro != NULL && !empty($dezembro)) {
                $result[$key2]->ANO_ANTERIOR = TRUE;
            }
        } else {
            $result = NULL;
        }

        //echo($sql); die;

        return $result;
    }

    public function getItemAno($id, $ano) {

        $sql = "select IDD.IND_COD_INDICADOR INDICADOR,
                to_char(idd.idd_dat_referencia_meta, 'yyyymm') anomes,
                to_char(idd.idd_dat_referencia_meta, 'yyyy') ano,
                cin.cin_vlr_valor realizado,
                idd.idd_vlr_meta previsto
              FROM cin_consulta_indicador cin,
                idd_indicador_dimensao idd
              WHERE cin.ind_cod_indicador(+)                   = idd.ind_cod_indicador
              AND cin.cin_cod_dimensao(+)                      = idd.idd_cod_dimensao
              AND cin.val_dat_referencia(+)                    = idd.idd_dat_referencia_meta
              and to_char(idd.idd_dat_referencia_meta, 'yyyy') = '$ano'
              and IDD.IND_COD_INDICADOR = '$id';";

        $list = self::execute($sql);

        return $list;
    }

    public function getObj() {
        $sql = "select 	obj.obj_cod_objetivo, 
                    obj.obj_dsc_objetivo, 
                    obj.obj_num_competencia, 
                    dir.dir_nom_diretriz, 
                    per.per_nom_perspectiva, 
                    obj.obj_num_ordem_apres
                from obj_objetivo obj,
                    dir_diretriz dir,
                    per_perspectiva per
                where 	obj_num_competencia = 2013
                    and obj_num_ordem_apres <> 99
                    and dir.dir_cod_diretriz = obj.dir_cod_diretriz
                    and per.per_cod_perspectiva = obj.per_cod_perspectiva
                order by obj.obj_num_ordem_apres;";

        $result = self::execute($sql);

        return $result;
    }

    public function json() {
        $list = $this->getObj();
        $result = Array();
        /* informações separadas em 2 arrays */
        $objetivos = Array();
        $indicadores = Array();
        foreach ($list as $item) {
            if (!is_int($item)) {

                $key = $item->OBJ_COD_OBJETIVO;
                $objetivos[$key] = $item;
                $objetivos[$key]->INDICADORES = Array();

                $temp = $this->getAll('2013', $item->OBJ_COD_OBJETIVO);
                $objetivos[$key]->INDICADORES = $temp;
            }
        }

        $list = $this->getAll();
        foreach ($list as $i) {
            $k = $i->IND_COD_INDICADOR;
            $indicadores[$k] = $i;

            $indicadores[$k]->FONTE = $this->getItemFonte($i->IND_COD_INDICADOR);
            $indicadores[$k]->ANOS = Array();
            $indicadores[$k]->DETALHES = Array();

            for ($j = date("Y"); $j >= 2005; $j--) {
                $dados = $this->getItem($i->IND_COD_INDICADOR, $j);
                if ($dados != NULL) {
                    $indicadores[$k]->ANOS[] = (int) $j;
                    $indicadores[$k]->DETALHES[$j] = new stdClass();
                    $indicadores[$k]->DETALHES[$j]->DADOS = $dados;
                    $indicadores[$k]->DETALHES[$j]->CAUSAS = $this->getItemCausa($i->IND_COD_INDICADOR, $j, false);
                    $indicadores[$k]->DETALHES[$j]->GGOVE = $this->getItemCausa($i->IND_COD_INDICADOR, $j, true);
                    $indicadores[$k]->DETALHES[$j]->PLANO = $this->getItemPlano($i->IND_COD_INDICADOR, $j);

                    $test = $j . "12";
                    if ($indicadores[$k]->DETALHES[$j]->DADOS[$test]->ANO_ANTERIOR == FALSE) {
                        break;
                    }
                } else {
                    break;
                }
            }
        }



        $result['OBJETIVOS'] = $objetivos;
        $result['INDICADORES'] = $indicadores;


        return $result;
    }

    public function getItemFonte($id) {
        $sql = "SELECT var.var_sgl_variavel nom_var,
                var.var_dsc_variavel dsc_var,
                fml.for_log_indica_anterior comport,
                fnt.fnt_dsc_fonte_dados origem,
                fc_monta_formula_indicador(ind.ind_cod_indicador) formula
              FROM var_variavel var,
                for_formula fml,
                fnt_fonte_dados fnt,
                ind_indicador ind
              WHERE ind.ind_cod_indicador = fml.ind_cod_indicador
              AND ind.ind_cod_indicador   = '$id'
              AND fml.var_cod_variavel    = var.var_cod_variavel
              AND var.fnt_cod_fonte_dados = fnt.fnt_cod_fonte_dados
              ORDER BY var.var_sgl_variavel;";

        $result = self::execute($sql);
        return $result;
    }

    public function getItemCausa($id, $ano, $ggove = false) {
        $sql = "SELECT TO_CHAR(inf.idd_per_periodo, 'yyyymm') anomes,
                TO_CHAR(inf.idd_per_periodo, 'mm/yyyy') data,
                TO_CHAR(inf.idd_dat_reuniao, 'dd/mm/yyyy') datareu, idd_dsc_fatos fatos, idd_dsc_causas causas, idd_dsc_acoes acoes,
                NVL(trim(inf.idd_anx_anexo),'Vazio') anexo
              FROM inf_indicadores_fatos inf,
                ind_indicador ind
              WHERE inf.ind_cod_indicador              = ind.ind_cod_indicador
              AND inf.ind_cod_indicador                = '$id'
              AND ind.ind_flg_corporativo              = 'S'
              AND inf.idd_flg_dimensao                 = 'S'";
        if ($ggove){
            $sql .= " and inf.INF_FLG_GOVERNANCA = 'S'";
        } else {
            $sql .= " AND (inf.INF_FLG_GOVERNANCA <> 'S' OR inf.INF_FLG_GOVERNANCA is null)";
        }
        $sql .= " AND TO_CHAR(inf.idd_per_periodo, 'yyyy') = '$ano'
              ORDER BY TO_CHAR(inf.idd_per_periodo, 'mm/yyyy');";

        $list = self::execute($sql);
  
        $result = Array();
        foreach ($list as $item) {
            $result[$item->ANOMES] = $item;
            $mes = (int) substr($item->ANOMES, -2);
            $result[$item->ANOMES]->MES = $this->retornaMes($mes);
        }
        return $result;
    }

    public function getItemPlano($id, $ano) {
        $sql = "SELECT DISTINCT inc.inc_dsc_acao acao,
                inc.inc_responsavel_acao responsavel,
                inc.inc_equipe_acao equipe,
                TO_CHAR(inc.inc_dat_inicio, 'mm/yyyy') inicio,
                TO_CHAR(inc.inc_dat_fim, 'mm/yyyy') fim,
                sia.sia_dsc_situacao situacao,
                sia.sia_realizado realizado,
                inc.inc_cod_acao codigo
              FROM inc_acao_indicador inc,
                ind_indicadores_acoes ind,
                sia_situacao_acao sia
              WHERE inc.inc_cod_acao                       = ind.inc_cod_acao
              AND ind.ind_cod_acao_indicador               = sia.ind_cod_acao_indicador (+)
              AND TO_CHAR(sia.sia_per_situacao, 'mm/yyyy') = '01/$ano'
              AND TO_CHAR(inc.inc_dat_inicio, 'yyyy')     >= $ano
              AND ind.ind_cod_indicador                    = $id
              ORDER BY inc.inc_cod_acao;";

        $result = self::execute($sql);
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
    
    public function jsonObjetivosIndicador(){
        $result = Array();
        $objetivos = Array();
        $indicadores = Array();
        $ano = date('Y');
        $anterior = $ano - 1;

        $objs = $this->getObj();

        foreach ($objs as $item) {
            if (!is_int($item)) {

                $key = $item->OBJ_COD_OBJETIVO;
                $objetivos[$key] = $item;
                $objetivos[$key]->INDICADORES = Array();

                $temp = $this->getAll(null, $item->OBJ_COD_OBJETIVO);
                if (empty($temp)) {
                    $temp = $this->getAll('2013', $item->OBJ_COD_OBJETIVO);
                }
                
                //var_dump($temp); die; exit;
                $objetivos[$key]->INDICADORES = $temp;
            }
        }
        return $objetivos;
    }

    public function jsonFiles() {
        //pega os objetivos e todos os indicadores de 2000 até 2 anos pra trás
        $result = Array();
        $objetivos = Array();
        $indicadores = Array();
        $ano = date('Y');
        $anterior = $ano - 1;

        $objs = $this->getObj();

        foreach ($objs as $item) {
            if (!is_int($item)) {

                $key = $item->OBJ_COD_OBJETIVO;
                $objetivos[$key] = $item;
                $objetivos[$key]->INDICADORES = Array();

                $temp = $this->getAll($anterior, $item->OBJ_COD_OBJETIVO);
                if (empty($temp)){
                    $temp = $this->getAll(null, $item->OBJ_COD_OBJETIVO);
                }
                $objetivos[$key]->INDICADORES = $temp;
            }
        }
        $result['OBJETIVOS'] = $objetivos;

        $inds = $this->getAll();
        foreach ($inds as $i) {
            $k = $i->IND_COD_INDICADOR;
            $indicadores[$k] = $i;

            $indicadores[$k]->FONTE = $this->getItemFonte($i->IND_COD_INDICADOR);
            $indicadores[$k]->DETALHES = Array();

            for ($j = $anterior; $j >= 2000; $j--) {
                $dados = $this->getItem($i->IND_COD_INDICADOR, $j);
                if ($dados != NULL) {
                    $indicadores[$k]->DETALHES[$j] = new stdClass();
                    $indicadores[$k]->DETALHES[$j]->DADOS = $dados;
                    $indicadores[$k]->DETALHES[$j]->CAUSAS = $this->getItemCausa($i->IND_COD_INDICADOR, $j);
                    $indicadores[$k]->DETALHES[$j]->GGOVE = $this->getItemCausa($i->IND_COD_INDICADOR, $j, true);
                    $indicadores[$k]->DETALHES[$j]->PLANO = $this->getItemPlano($i->IND_COD_INDICADOR, $j);

                    $test = $j . "12";
                    if ($indicadores[$k]->DETALHES[$j]->DADOS[$test]->ANO_ANTERIOR == FALSE) {
                        break;
                    }
                }
            }
        }
        $result['INDICADORES'] = $indicadores;

        return $result;
    }

    public function jsonAtual($inds = NULL) {
        $atual = Array();
        $anoInicial = 2014;
        $ano = (int) date('Y');
        $anterior = $ano - 1;

        if ($inds == NULL) {
            $inds = $this->getAll();
        }

        foreach ($inds as $i) {
            $k = $i->IND_COD_INDICADOR;
            $atual[$k] = $i;
            $atual[$k]->FONTE = $this->getItemFonte($i->IND_COD_INDICADOR);
            $atual[$k]->DETALHES = Array();
            if ($ano != $anoInicial) {
                for ($a = $anoInicial; $a <= $ano; $a++) {
                    $atual[$k]->DETALHES[$a] = new stdClass();
                    $atual[$k]->DETALHES[$a]->DADOS = $this->getItem($i->IND_COD_INDICADOR, $a);
                    $atual[$k]->DETALHES[$a]->CAUSAS = $this->getItemCausa($i->IND_COD_INDICADOR, $a);
                    $atual[$k]->DETALHES[$a]->GGOVE = $this->getItemCausa($i->IND_COD_INDICADOR, $a, true);
                    $atual[$k]->DETALHES[$a]->PLANO = $this->getItemPlano($i->IND_COD_INDICADOR, $a);
                }
            } else {
                $atual[$k]->DETALHES[$ano] = new stdClass();
                $atual[$k]->DETALHES[$ano]->DADOS = $this->getItem($i->IND_COD_INDICADOR, $ano);
                $atual[$k]->DETALHES[$ano]->CAUSAS = $this->getItemCausa($i->IND_COD_INDICADOR, $ano);
                $atual[$k]->DETALHES[$ano]->GGOVE = $this->getItemCausa($i->IND_COD_INDICADOR, $ano, true);
                $atual[$k]->DETALHES[$ano]->PLANO = $this->getItemPlano($i->IND_COD_INDICADOR, $ano);
            }

            $atual[$k]->ANOS = Array();

            for ($j = $ano; $j >= 2000; $j--) {
                $dados = $this->getItemAno($i->IND_COD_INDICADOR, $j);
                if ($dados != NULL && !empty($dados)) {
                    $atual[$k]->ANOS[] = (int) $j;
                } else {
                    break;
                }
            }
        }

        return $atual;
    }

    public function jsonAnos() {
        $atual = Array();
        $ano = date('Y');

        $inds = $this->getAll();
        foreach ($inds as $i) {
            $k = $i->IND_COD_INDICADOR;
            $atual[$k] = $i;
            $atual[$k]->ANOS = Array();

            for ($j = $ano; $j >= 2000; $j--) {
                $dados = $this->getItemAno($i->IND_COD_INDICADOR, $j);
                if ($dados != NULL && !empty($dados)) {
                    $atual[$k]->ANOS[] = (int) $j;
                } else {
                    break;
                }
            }
        }

        return $atual;
    }

    public function getGeinfSetorial() {

        $sql = "SELECT 	distinct ind.ind_cod_indicador, 
                    ind.ind_nom_indicador, 
                    ind.ind_dsc_indicador,
                    ind.ind_sgl_indicador, 
                    obj.obj_dsc_objetivo, 
                    obj.obj_num_competencia, 
                    unm.unm_dsc_und_medida, 
                    ind.ind_tip_periodicidade
                FROM 	ind_indicador ind, unm_unidade_medida unm, obj_objetivo obj, uad_unidade_administrativa uad, idd_indicador_dimensao idd
                WHERE 	ind.unm_cod_und_medida = unm.unm_cod_und_medida
                    and ind.uad_cod_unidade_administrativa = uad.uad_cod_unidade_administrativa (+)
                    and idd.ind_cod_indicador = ind.ind_cod_indicador
                    and ind.obj_cod_objetivo = obj.obj_cod_objetivo
                    AND IDD.IDD_COD_DIMENSAO = 663
                    and obj.obj_num_ordem_apres <> 99
                    and ind.ind_dat_exclusao is null;";

        $result = self::execute($sql);
        return $result;
    }

    public function getItemSetorial($id, $ano = null) {
        if ($ano == NULL || $ano == '') {
            $ano = '' . date("Y") . '';
        }

        $result = Array();

        $sql = "select IDD.IND_COD_INDICADOR INDICADOR,
                to_char(idd.idd_dat_referencia_meta, 'yyyymm') anomes,
                trim(IND.IND_SENTIDO_INDICADOR) SENTIDO,
                idd.idd_vlr_meta previsto,
                cin.cin_vlr_valor realizado,
                round(fc_percent_atingido(ind.ind_cod_indicador, 
                to_number(to_char(idd.idd_dat_referencia_meta, 'yyyy')), 
                to_number(to_char(idd.idd_dat_referencia_meta, 'mm')), 
                ind.ind_sentido_indicador, ind.ind_flg_posicao_inicial, 
                idd.idd_cod_dimensao),2) atingido,
                CASE
                      WHEN (ind.ind_sentido_indicador = 1
                      AND idd.idd_vlr_meta            > 0)
                      THEN ROUND(((cin.cin_vlr_valor    /idd.idd_vlr_meta) * 100)-100,2)
                      WHEN (ind.ind_sentido_indicador = -1
                      AND idd.idd_vlr_meta            > 0 )
                      THEN ROUND((100 - (((cin.cin_vlr_valor/idd.idd_vlr_meta) * 100) - 100)) - 100,2)
                      ELSE 0
                END desvio,
                CASE
                      WHEN cin.cin_vlr_valor IS NULL
                      THEN
                        (SELECT SUM(cin_vlr_valor)
                        FROM cin_consulta_indicador t
                        WHERE t.ind_cod_indicador = idd.ind_cod_indicador
                        AND t.cin_cod_dimensao    = idd.idd_cod_dimensao
                        AND t.val_dat_referencia  =
                              (SELECT MAX(val_dat_referencia)
                              FROM cin_consulta_indicador
                              WHERE ind_cod_indicador = t.ind_cod_indicador
                              AND cin_cod_dimensao    = t.cin_cod_dimensao))
                      ELSE cin.cin_vlr_valor
                END REAL_GRAF,
                ind.ind_exb_decimal exb_decimal,
                FC_STATUS_INDICADOR_MENSAL(NVL(IDD.IDD_VLR_META, 0), NVL(CIN.CIN_VLR_VALOR, 0), 
                NVL((SELECT cin_vlr_valor
                      from cin_consulta_indicador
                      WHERE TO_CHAR(val_dat_referencia, 'yyyymm') = to_char(add_months(idd.idd_dat_referencia_meta,-1), 'yyyymm')
                      AND cin_cod_dimensao                        = idd.idd_cod_dimensao
                      AND cin_flg_dimensao                        = idd.idd_flg_dimensao
                      and ind_cod_indicador                       = ind.ind_cod_indicador), 0),  
                      NVL((SELECT cin_vlr_valor
                      FROM CIN_CONSULTA_INDICADOR
                      WHERE TO_CHAR(val_dat_referencia, 'mm') = '12'
                      AND cin_cod_dimensao                        = idd.idd_cod_dimensao
                      AND cin_flg_dimensao                        = idd.idd_flg_dimensao
                      AND IND_COD_INDICADOR                       = IND.IND_COD_INDICADOR
                      and to_char(val_dat_referencia, 'YYYY') =  to_char(add_months(idd.idd_dat_referencia_meta,-12),'yyyy')), 0), 
                      IND.IND_SENTIDO_INDICADOR, IND.IND_FLG_POSICAO_INICIAL) STATUS    
              FROM cin_consulta_indicador cin,
                idd_indicador_dimensao idd,
                ind_indicador ind
              WHERE cin.ind_cod_indicador(+)                   = idd.ind_cod_indicador
              AND cin.cin_cod_dimensao(+)                      = idd.idd_cod_dimensao
              AND cin.val_dat_referencia(+)                    = idd.idd_dat_referencia_meta
              AND idd.ind_cod_indicador                        = ind.ind_cod_indicador
              AND IDD.IND_COD_INDICADOR 						 = '$id'
              and to_char(idd.idd_dat_referencia_meta, 'yyyy') = '$ano'
              order by 1,2;";

        $list = self::execute($sql);

        if ($list != NULL && !empty($list)) {
            foreach ($list as $item) {
                $key = (int) $item->ANOMES;

                if (!property_exists($item, 'REALIZADO')) {
                    $result[$key] = new stdClass();
                    $result[$key]->ANOMES = $item->ANOMES;
                    $result[$key]->PREVISTO = $item->PREVISTO;
                    $result[$key]->REALIZADO = '0';
                    $result[$key]->ATINGIDO = '0';
                    $result[$key]->DESVIO = '0';
                    $result[$key]->REAL_GRAF = '0';
                    if (property_exists($item, 'EXB_DECIMAL') == TRUE) {
                        $result[$key]->EXB_DECIMAL = $item->EXB_DECIMAL;
                    } else {
                        $result[$key]->EXB_DECIMAL = 'N';
                    }
                    $result[$key]->STATUS = $item->STATUS;
                } else {
                    if (($item->SENTIDO == "1" || $item->SENTIDO == 1) && floatval($item->PREVISTO) > 0) {
                        $atingido = ($item->REALIZADO / $item->PREVISTO) * 100;
                    } else {
                        $atingido = ($item->PREVISTO / $item->REALIZADO) * 100;
                    }
                    $item->ATINGIDO = number_format($atingido, 2, ',', ' ');
                    $result[$key] = $item;
                }

                $mes = (int) substr($item->ANOMES, -2);
                $result[$key]->MES = $this->retornaMes($mes);
            }
        } else {
            $result = NULL;
        }

        return $result;
    }

    public function getGeinfJson($ano = null) {
        if ($ano == NULL || $ano == '') {
            $ano = '' . date("Y") . '';
        }
        $atual = Array();

        $inds = $this->getGeinfSetorial();
        foreach ($inds as $i) {
            $k = $i->IND_COD_INDICADOR;
            $atual[$k] = $i;
            $atual[$k]->ANO = $ano;
            $atual[$k]->FONTE = $this->getItemFonte($i->IND_COD_INDICADOR);
            $atual[$k]->DETALHES = new stdClass();
            $atual[$k]->DETALHES->DADOS = $this->getItemSetorial($i->IND_COD_INDICADOR, $ano);
            $atual[$k]->DETALHES->CAUSAS = $this->getItemCausa($i->IND_COD_INDICADOR, $ano);
            $atual[$k]->DETALHES->PLANO = $this->getItemPlano($i->IND_COD_INDICADOR, $ano);
        }

        return $atual;
    }

    public function jsonIndicadoresTodos() {
        //pega os objetivos e todos os indicadores de 2000 até 2 anos pra trás
        $indicadores = Array();
        $ano = date('Y');

        $inds = $this->getAll();
        foreach ($inds as $i) {
            $k = $i->IND_COD_INDICADOR;
            $indicadores[$k] = $i;

            $indicadores[$k]->FONTE = $this->getItemFonte($i->IND_COD_INDICADOR);
            $indicadores[$k]->DETALHES = Array();

            for ($j = $ano; $j >= 2000; $j--) {
                $dados = $this->getItem($i->IND_COD_INDICADOR, $j);
                if ($dados != NULL) {
                    $indicadores[$k]->DETALHES[$j] = new stdClass();
                    $indicadores[$k]->DETALHES[$j]->DADOS = $dados;
                    $indicadores[$k]->DETALHES[$j]->CAUSAS = $this->getItemCausa($i->IND_COD_INDICADOR, $j);
                    $indicadores[$k]->DETALHES[$j]->GGOVE = $this->getItemCausa($i->IND_COD_INDICADOR, $j, true);
                    $indicadores[$k]->DETALHES[$j]->PLANO = $this->getItemPlano($i->IND_COD_INDICADOR, $j);
                    $grafico = new stdClass();
                    $gPrevisto = $gRealizado = array();
                    foreach ($dados as $d) {
                        $gPrevisto[(int) substr($d->ANOMES, -2)] = $d->PREVISTO;
                        if (trim($d->REALIZADO)) {
                            $gRealizado[(int) substr($d->ANOMES, -2)] = $d->REALIZADO;
                        }
                    }
                    $grafico->PREVISTO = $gPrevisto;
                    $grafico->REALIZADO = $gRealizado;
                    $indicadores[$k]->DETALHES[$j]->GRAFICO = $grafico;

                    $test = $j . "12";
                    if ($indicadores[$k]->DETALHES[$j]->DADOS[$test]->ANO_ANTERIOR == FALSE) {
                        break;
                    }
                }
            }
        }
        return $indicadores;
    }

    public function getItemUltimo($id) {
        $result = Array();

        $sql = "select * from (select IDD.IND_COD_INDICADOR INDICADOR,
                to_char(idd.idd_dat_referencia_meta, 'yyyymm') anomes,
                trim(IND.IND_SENTIDO_INDICADOR) SENTIDO,
                idd.idd_vlr_meta previsto,
                cin.cin_vlr_valor realizado,
                round(fc_percent_atingido(ind.ind_cod_indicador, 
                to_number(to_char(idd.idd_dat_referencia_meta, 'yyyy')), 
                to_number(to_char(idd.idd_dat_referencia_meta, 'mm')), 
                ind.ind_sentido_indicador, ind.ind_flg_posicao_inicial, 
                idd.idd_cod_dimensao),2) atingido,
                CASE
                      WHEN (ind.ind_sentido_indicador = 1
                      AND idd.idd_vlr_meta            > 0)
                      THEN ROUND(((cin.cin_vlr_valor    /idd.idd_vlr_meta) * 100)-100,2)
                      WHEN (ind.ind_sentido_indicador = -1
                      AND idd.idd_vlr_meta            > 0 )
                      THEN ROUND((100 - (((cin.cin_vlr_valor/idd.idd_vlr_meta) * 100) - 100)) - 100,2)
                      ELSE 0
                END desvio,
                CASE
                      WHEN cin.cin_vlr_valor IS NULL
                      THEN
                        (SELECT SUM(cin_vlr_valor)
                        FROM cin_consulta_indicador t
                        WHERE t.ind_cod_indicador = idd.ind_cod_indicador
                        AND t.cin_cod_dimensao    = idd.idd_cod_dimensao
                        AND t.val_dat_referencia  =
                              (SELECT MAX(val_dat_referencia)
                              FROM cin_consulta_indicador
                              WHERE ind_cod_indicador = t.ind_cod_indicador
                              AND cin_cod_dimensao    = t.cin_cod_dimensao))
                      ELSE cin.cin_vlr_valor
                END REAL_GRAF,
                ind.ind_exb_decimal exb_decimal,
                FC_STATUS_INDICADOR_MENSAL(NVL(IDD.IDD_VLR_META, 0), NVL(CIN.CIN_VLR_VALOR, 0), 
                NVL((SELECT cin_vlr_valor
                      from cin_consulta_indicador
                      WHERE TO_CHAR(val_dat_referencia, 'yyyymm') = to_char(add_months(idd.idd_dat_referencia_meta,-1), 'yyyymm')
                      AND cin_cod_dimensao                        = idd.idd_cod_dimensao
                      AND cin_flg_dimensao                        = idd.idd_flg_dimensao
                      and ind_cod_indicador                       = ind.ind_cod_indicador), 0),  
                      NVL((SELECT cin_vlr_valor
                      FROM CIN_CONSULTA_INDICADOR
                      WHERE TO_CHAR(val_dat_referencia, 'mm') = '12'
                      AND cin_cod_dimensao                        = idd.idd_cod_dimensao
                      AND cin_flg_dimensao                        = idd.idd_flg_dimensao
                      AND IND_COD_INDICADOR                       = IND.IND_COD_INDICADOR
                      and to_char(val_dat_referencia, 'YYYY') =  to_char(add_months(idd.idd_dat_referencia_meta,-12),'yyyy')), 0), 
                      IND.IND_SENTIDO_INDICADOR, IND.IND_FLG_POSICAO_INICIAL) STATUS,
                      unm.unm_dsc_und_medida medida,
                      ind.ind_tip_periodicidade periodicidade
              FROM cin_consulta_indicador cin,
                idd_indicador_dimensao idd,
                ind_indicador ind,
                unm_unidade_medida unm
              WHERE cin.ind_cod_indicador(+)                   = idd.ind_cod_indicador
              AND cin.cin_cod_dimensao(+)                      = idd.idd_cod_dimensao
              AND cin.val_dat_referencia(+)                    = idd.idd_dat_referencia_meta
              AND idd.ind_cod_indicador                        = ind.ind_cod_indicador
              AND ind.unm_cod_und_medida						 = unm.unm_cod_und_medida
              AND ind.ind_flg_corporativo                      = 'S'
              and idd.idd_flg_dimensao                         = 'S'
              and cin.cin_vlr_valor > 0
              and IDD.IND_COD_INDICADOR = '$id'
              order by anomes DESC)
            WHERE
            rownum <= 12;";

        $list = self::execute($sql);
        //echo $list; die;

        if ($list != NULL && !empty($list)) {
            foreach ($list as $key => $item) {
                //$key = (int) $item->ANOMES;

                if (!property_exists($item, 'REALIZADO')) {
                    $result[$key] = new stdClass();
                    $result[$key]->ANOMES = $item->ANOMES;
                    $result[$key]->PREVISTO = $item->PREVISTO;
                    $result[$key]->REALIZADO = ' ';
                    $result[$key]->ATINGIDO = ' ';
                    $result[$key]->DESVIO = ' ';
                    $result[$key]->REAL_GRAF = ' ';
                    $result[$key]->STATUS = $item->STATUS;
                    $result[$key]->PERIODICIDADE = $item->PERIODICIDADE;
                    $result[$key]->MEDIDA = $item->MEDIDA;
                } else {
                    if (($item->SENTIDO == "1" || $item->SENTIDO == 1) && floatval($item->PREVISTO) > 0) {
                        $atingido = ($item->REALIZADO / $item->PREVISTO) * 100;
                    } else {
                        $atingido = ($item->PREVISTO / $item->REALIZADO) * 100;
                    }
                    $item->ATINGIDO = number_format($atingido, 2, ',', ' ');
                    $result[$key] = $item;
                }
                $mes = (int) substr($item->ANOMES, -2);
                $result[$key]->MES = $this->retornaMes($mes);
                $result[$key]->ANO = substr($item->ANOMES, 0, 4);

                if (property_exists($item, 'EXB_DECIMAL') == TRUE) {
                    $result[$key]->EXB_DECIMAL = $item->EXB_DECIMAL;
                } else {
                    $result[$key]->EXB_DECIMAL = 'N';
                }
            }
        } else {
            $result = NULL;
        }

        return $result;
    }

    public function getIndicadorUnidade($id, $un = NULL, $anomes = NULL) {

        $sql = "select IDD.IND_COD_INDICADOR INDICADOR,
            to_char(idd.idd_dat_referencia_meta, 'yyyymm') anomes,
            initcap(TO_CHAR(idd.idd_dat_referencia_meta, 'mon')) mes,
            trim(IND.IND_SENTIDO_INDICADOR) SENTIDO,
            trim(UAD.UAD_SGL_UNIDADE_ADMINISTRATIVA) UNIDADE,
            idd.idd_vlr_meta previsto,
            cin.cin_vlr_valor realizado
           FROM cin_consulta_indicador cin,
            idd_indicador_dimensao idd,
            ind_indicador ind,
            unm_unidade_medida unm,
            UAD_UNIDADE_ADMINISTRATIVA UAD
           WHERE cin.ind_cod_indicador(+)                   = idd.ind_cod_indicador
           AND cin.cin_cod_dimensao(+)                      = idd.idd_cod_dimensao
           AND cin.val_dat_referencia(+)                    = idd.idd_dat_referencia_meta
           AND idd.ind_cod_indicador                        = ind.ind_cod_indicador
           AND UAD.UAD_COD_UNIDADE_ADMINISTRATIVA           = IDD.idd_cod_dimensao
           AND ind.unm_cod_und_medida    = unm.unm_cod_und_medida
           and uad.UAD_FLG_SIG in ('U','D')
           and IDD.IND_COD_INDICADOR = $id";
        if ($un) {
            $un = substr($un, 0, 2) . '-' . substr($un, 2);
            $sql .= " and trim(UAD.UAD_SGL_UNIDADE_ADMINISTRATIVA) = '$un'";
        }
        if ($anomes) {
            $ano = substr($anomes, 0, 4);
            $sql .= " and to_char(idd.idd_dat_referencia_meta, 'yyyy') = $ano";
        }
        $sql .= " order by anomes, unidade";

        $result = self::execute($sql);
        $list = array();
        $list['DADOS'] = array();
        $list['CAUSAS'] = array();
        $list['GRAFICO'] = array();
        $gPrevisto = array();
        $gRealizado = array();

        foreach ($result as $k => $r) {
            $result[$k]->MES = $this->retornaMesPtbr($r->MES);
            if (($r->SENTIDO == "1" || $r->SENTIDO == 1) && floatval($r->PREVISTO) > 0) {
                $atingido = ($r->REALIZADO / $r->PREVISTO) * 100;
            } else {
                $atingido = ($r->PREVISTO / $r->REALIZADO) * 100;
            }

            $result[$k]->ATINGIDO = number_format($atingido, 2, '.', '');
            if (!property_exists($r, 'REALIZADO')) {
                $result[$k]->REALIZADO = NULL;
            }
            $list['DADOS'][$r->ANOMES] = $result[$k];

            if ($un) {
                $sql2 = "SELECT TO_CHAR(inf.idd_per_periodo, 'yyyymm') anomes,
                    trim(UAD.UAD_SGL_UNIDADE_ADMINISTRATIVA) unidade,
                    TO_CHAR(inf.idd_per_periodo, 'mm/yyyy') data,
                    TO_CHAR(inf.idd_dat_reuniao, 'dd/mm/yyyy') datareu,
                    idd_dsc_fatos fatos,
                    idd_dsc_causas causas,
                    idd_dsc_acoes acoes,
                    NVL(trim(inf.idd_anx_anexo),'Vazio') anexo
                  FROM inf_indicadores_fatos inf,
                    ind_indicador ind,
                    UAD_UNIDADE_ADMINISTRATIVA UAD
                  WHERE inf.ind_cod_indicador                  = ind.ind_cod_indicador
                  AND UAD.UAD_COD_UNIDADE_ADMINISTRATIVA       = inf.idd_cod_dimensao
                  AND uad.UAD_FLG_SIG                         IN ('U','D')
                  AND inf.ind_cod_indicador                    = $id
                  AND trim(UAD.UAD_SGL_UNIDADE_ADMINISTRATIVA) = '$un'
                  AND TO_CHAR(inf.idd_per_periodo, 'yyyymm')   = $r->ANOMES";

                //echo $sql2; die; exit;

                $causas = self::execute($sql2);
                if (is_array($causas)) {
                    $causas = $causas[0];
                }
                $list['CAUSAS'][$r->ANOMES] = $causas;
            }
            if ($r->PREVISTO != NULL) {
                $gPrevisto[(int) substr($r->ANOMES, -2)] = $r->PREVISTO;
            }
            if ($r->REALIZADO != NULL) {
                $gRealizado[(int) substr($r->ANOMES, -2)] = $r->REALIZADO;
            }
        }

        $list['GRAFICO']['PREVISTO'] = $gPrevisto;
        $list['GRAFICO']['REALIZADO'] = $gRealizado;

        //var_dump($list); die; exit;
        return $list;
    }

    public function getUnidadesMapa($id, $anomes) {

        $capital = array(
            '5902' => '08522',
            '5903' => '08524',
            '25169' => '07802',
            '1480' => '08462',
            '6685' => '04252',
            '12842' => '12842',
            '15647' => '15648',
            '11423' => '03076'
        );
        $interior = array(
            '5902' => '08502',
            '5903' => '08523',
            '25169' => '08482',
            '1480' => '08444',
            '6685' => '06685',
            '12842' => '12842',
            '15647' => '15648',
            '5822' => '05822',
            '5842' => '05842',
            '11423' => '03076'
        );

        $idCapital = '0';
        $idInterior = '0';

        if (array_key_exists($id, $capital)) {
            $idCapital = $capital[$id];
        }

        if (array_key_exists($id, $interior)) {
            $idInterior = $interior[$id];
        }

        /*
          var_dump($id);
          var_dump($anomes);
          var_dump($idCapital);
          var_dump($idInterior);
          die; exit;
         */

        $sql = "select IDD.IND_COD_INDICADOR INDICADOR,
                to_char(idd.idd_dat_referencia_meta, 'yyyymm') anomes,
                TRIM(UAD.UAD_SGL_UNIDADE_ADMINISTRATIVA) UNIDADE,
                IND.IND_SENTIDO_INDICADOR SENTIDO,
                FC_STATUS_INDICADOR_MENSAL(NVL(IDD.IDD_VLR_META, 0), NVL(CIN.CIN_VLR_VALOR, 0), 
                NVL((SELECT cin_vlr_valor
               from cin_consulta_indicador
               WHERE TO_CHAR(val_dat_referencia, 'yyyymm') = to_char(add_months(idd.idd_dat_referencia_meta,-1), 'yyyymm')
               AND cin_cod_dimensao                        = idd.idd_cod_dimensao
               AND cin_flg_dimensao                        = idd.idd_flg_dimensao
               and ind_cod_indicador                       = ind.ind_cod_indicador), 0),  
               NVL((SELECT cin_vlr_valor
               FROM CIN_CONSULTA_INDICADOR
               WHERE TO_CHAR(val_dat_referencia, 'mm') = '12'
               AND cin_cod_dimensao                        = idd.idd_cod_dimensao
               AND cin_flg_dimensao                        = idd.idd_flg_dimensao
               AND IND_COD_INDICADOR                       = IND.IND_COD_INDICADOR
               and to_char(val_dat_referencia, 'YYYY') =  to_char(add_months(idd.idd_dat_referencia_meta,-12),'yyyy')), 0), 
               IND.IND_SENTIDO_INDICADOR, IND.IND_FLG_POSICAO_INICIAL) STATUS
               FROM cin_consulta_indicador cin,
                idd_indicador_dimensao idd,
                ind_indicador ind,
                unm_unidade_medida unm,
                UAD_UNIDADE_ADMINISTRATIVA UAD
               WHERE cin.ind_cod_indicador(+)                   = idd.ind_cod_indicador
               AND cin.cin_cod_dimensao(+)                      = idd.idd_cod_dimensao
               AND cin.val_dat_referencia(+)                    = idd.idd_dat_referencia_meta
               AND idd.ind_cod_indicador                        = ind.ind_cod_indicador
               AND UAD.UAD_COD_UNIDADE_ADMINISTRATIVA           = IDD.idd_cod_dimensao
               AND ind.unm_cod_und_medida    = unm.unm_cod_und_medida
               and uad.UAD_FLG_SIG in ('U','D')
               and cin.cin_vlr_valor is not null
               -- Parametros
               and to_char(idd.idd_dat_referencia_meta, 'yyyymm') = " . $anomes . "
               and (IDD.IND_COD_INDICADOR = " . $idCapital . " OR IDD.IND_COD_INDICADOR = " . $idInterior . ")";

        $result = self::execute($sql);
        $list = array();
        foreach ($result as $r) {
            $list[str_replace('-', '', $r->UNIDADE)] = $r;
        }
        //var_dump($list); die;
        return $list;
    }

    private function retornaMesPtbr($mes, $slash = false) {
        switch ($mes) {
            case 'Jan': $mes = 'Janeiro';
                break;
            case 'Feb': $mes = 'Fevereiro';
                break;
            case 'Mar': $mes = 'Março';
                break;
            case 'Apr': $mes = 'Abril';
                break;
            case 'May': $mes = 'Maio';
                break;
            case 'May': $mes = 'Junho';
                break;
            case 'Jul': $mes = 'Julho';
                break;
            case 'Aug': $mes = 'Agosto';
                break;
            case 'Sep': $mes = 'Setembro';
                break;
            case 'Oct': $mes = 'Outubro';
                break;
            case 'Nov': $mes = 'Novembro';
                break;
            case 'Dec': $mes = 'Dezembro';
                break;
        }
        if ($slash) {
            $mes = substr($mes, 0, 3);
        }
        return $mes;
    }

    public function verificaIndicador($id) {
        //pega os objetivos e todos os indicadores de 2000 até 2 anos pra trás
        $indicador = new stdClass();
        $ano = date('Y');

        $indicador->FONTE = $this->getItemFonte($id);
        $indicador->DETALHES = Array();

        for ($j = $ano; $j >= 2000; $j--) {
            $dados = $this->getItem($id, $j);
            //var_dump($dados);
            //var_dump($j);

            if ($dados != NULL) {
                $indicador->DETALHES[$j] = new stdClass();
                $indicador->DETALHES[$j]->DADOS = $dados;
                $indicador->DETALHES[$j]->CAUSAS = $this->getItemCausa($id, $j);
                $indicador->DETALHES[$j]->GGOVE = $this->getItemCausa($id, $j, true);
                $indicador->DETALHES[$j]->PLANO = $this->getItemPlano($id, $j);
                $grafico = new stdClass();
                $gPrevisto = $gRealizado = array();
                foreach ($dados as $d) {
                    $gPrevisto[(int) substr($d->ANOMES, -2)] = $d->PREVISTO;
                    if (trim($d->REALIZADO)) {
                        $gRealizado[(int) substr($d->ANOMES, -2)] = $d->REALIZADO;
                    }
                }
                $grafico->PREVISTO = $gPrevisto;
                $grafico->REALIZADO = $gRealizado;
                $indicador->DETALHES[$j]->GRAFICO = $grafico;

                $test = $j . "12";
                if ($indicador->DETALHES[$j]->DADOS[$test]->ANO_ANTERIOR == FALSE) {
                    break;
                }
            }
        }

        //die; exit;
        return $indicador;
    }

}

?>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../libs/oracle.php');

class empreendimentosSGP extends modelOracle {
    var $host = '172.25.131.73';
    var $user = 'OBRAS_APP';
    var $password = '0BR@5_@PP';
    var $sid = 'CGORA2';
    var $port = '1521';
    var $socket = '';

    public function getProjetos($id = null) {
        $sql = "select * from PRJ_PROJETO prj, EXEC_FINAN_CONTRATO_EMPREEND exec where prj.EMP_COD_EMPREENDIMENTO = exec.EMPRE(+)";
        if ($id) {
            $sql .= " and EMP_COD_EMPREENDIMENTO = '" . $id . "'";
        }
        $sql .= " order by exec.VLR_CTR_PRINC DESC, prj.PRJ_NOM_PROJETO ASC";
        
        $result = parent::execute($sql);

        if (is_null($result)) {
            $result = array();
        } else if (!is_array($result)) {
            $result = array($result);
        }

        if ($result) {
            $len = count($result) + 1;
            $j = 0;
            foreach ($result as $key => $item) {
                $inicio = self::correctDate($item->PRJ_DAT_INICIO);
                $fim = self::correctDate($item->PRJ_DAT_FIM);

                $result[$key]->PRJ_DAT_INICIO = $inicio;
                $result[$key]->PRJ_DAT_FIM = $fim;

                if (!isset($item->COD_TRABALHO_SOCIAL)) {
                    $result[$key]->COD_TRABALHO_SOCIAL = "S/ Informação";
                }

                if (!isset($item->NUM_FAMILIAS_BENEFICIADAS)) {
                    $result[$key]->NUM_FAMILIAS_BENEFICIADAS = "S/ Informação";
                }

                if (!isset($item->QTD_POPU_BENEFICIADA_PREVISTA)) {
                    $result[$key]->QTD_POPU_BENEFICIADA_PREVISTA = "S/ Informação";
                }

                if (!isset($item->NUM_MAPP)) {
                    $result[$key]->NUM_MAPP = "S/ Informação";
                }

                if (!isset($item->COD_PROGRAMA)) {
                    $result[$key]->COD_PROGRAMA = '-';
                }

                if (!isset($item->DESC_PROGRAMA)) {
                    $result[$key]->DESC_PROGRAMA = '-';
                }

                if (!isset($item->DESCRICAO_MAPP)) {
                    $result[$key]->DESCRICAO_MAPP = "S/ MAPP";
                }

                if (!isset($item->STATUS)) {
                    $result[$key]->STATUS = "-";
                }

                if (!isset($item->LOC_DSC_MUNICIPIO)) {
                    $result[$key]->LOC_DSC_MUNICIPIO = "S/ Informação";
                } else {
                    $result[$key]->LOC_DSC_MUNICIPIO = trim($result[$key]->LOC_DSC_MUNICIPIO);
                }

                if (!isset($item->LOC_DSC_LOCALIDADE)) {
                    $result[$key]->LOC_DSC_LOCALIDADE = "S/ Informação";
                } else {
                    $result[$key]->LOC_DSC_LOCALIDADE = trim($result[$key]->LOC_DSC_LOCALIDADE);
                }

                if (!isset($item->LOC_DSC_DISTRITO)) {
                    $result[$key]->LOC_DSC_DISTRITO = "S/ Informação";
                } else {
                    $result[$key]->LOC_DSC_DISTRITO = trim($result[$key]->LOC_DSC_DISTRITO);
                }
                
                if (!isset($item->VLR_CTR_PRINC)) {
                    $result[$key]->VLR_CTR_PRINC = "0.00";
                    $result[$key]->ORDEM = $len--;
                } else {
                    $result[$key]->ORDEM = $j++;
                }
                
                if (!isset($item->VLR_MED_PRINC)) {
                    $result[$key]->VLR_MED_PRINC = "0.00";
                }
                
                if (!isset($item->PERC_PRINC_MED)) {
                    $result[$key]->PERC_PRINC_MED = "0";
                }
                
                if (!isset($item->PRT_LINK_CROQUI)) {
                    $result[$key]->PRT_LINK_CROQUI = " ";
                }
                
                if (!isset($item->PRT_DESC_PROJETO)) {
                    $result[$key]->PRT_DESC_PROJETO = "-";
                }

                $item->LOC_DSC_LOCALIDADE = str_replace("'", '`', $item->LOC_DSC_LOCALIDADE);
                $item->LOC_DSC_DISTRITO = str_replace("'", '`', $item->LOC_DSC_DISTRITO);
                $item->LOC_DSC_MUNICIPIO = str_replace("'", '`', $item->LOC_DSC_MUNICIPIO);
                $item->AREA_ABRANGENCIA = str_replace("'", '`', $item->AREA_ABRANGENCIA);
                $item->OBJETIVO_SOLICITACAO_EMPR = str_replace("'", '`', $item->OBJETIVO_SOLICITACAO_EMPR);
                $item->JUSTIFICATIVA_SOLICITACAO_EMPR = str_replace("'", '`', $item->JUSTIFICATIVA_SOLICITACAO_EMPR);
                $item->DESCRICAO_SOLICITACAO_EMPR = str_replace("'", '`', $item->DESCRICAO_SOLICITACAO_EMPR);
            }
        }

        //var_dump($result); die; exit();

        return $result;
    }

    public function getMesEn($mes) {
        switch ($mes) {
            case 'JAN':
                return '01';
                break;
            case 'FEB':
                return '02';
                break;
            case 'MAR':
                return '03';
                break;
            case 'APR':
                return '04';
                break;
            case 'MAY':
                return '05';
                break;
            case 'JUN':
                return '06';
                break;
            case 'JUL':
                return '07';
                break;
            case 'AUG':
                return '08';
                break;
            case 'SEP':
                return '09';
                break;
            case 'OCT':
                return '10';
                break;
            case 'NOV':
                return '11';
                break;
            case 'DEC':
                return '12';
                break;
            default:
                return $mes;
                break;
        }
    }

    public function getItemsTecnicos($id = null) {
        $sql = "select * from PROJETO_TECNICO_ITEM_FISICO";
        if ($id) {
            $sql .= " where EMP_COD_EMPREENDIMENTO = '" . $id . "'";
        }

        $result = parent::execute($sql);

        return $result;
    }

    public function getItemsContratos($id = null) {
        //$sql = "select * from CON_CONTRATO";
        $sql = "SELECT con.*, sts.* FROM CON_CONTRATO con LEFT OUTER JOIN CONTRATO_STATUS sts ON con.CONTRATO = sts.CONTRATO";
        if ($id) {
            $sql .= " where EMPREED = '" . $id . "'";
        }

        $contratos = parent::execute($sql);

        if (!is_array($contratos)) {
            $contratos = array($contratos);
        }

        foreach ($contratos as $key => $c) {
            $contratos[$key]->DT_INI = self::correctDate($c->DT_INI);
            $contratos[$key]->DT_FIM_ATUAL = self::correctDate($c->DT_FIM_ATUAL);
            $contratos[$key]->DT_FIM_ORIGINAL = self::correctDate($c->DT_FIM_ORIGINAL);

            //$contratos[$key]->VALOR_PAGO = self::getItemsContratosValores(trim($c->CONTRATO));
            //$contratos[$key]->VALOR_ADITIVO = self::getItemsContratosAditivos(trim($c->CONTRATO));
            //die;        exit();
            if (!isset($c->OBJ) || !trim($c->OBJ)) {
                $contratos[$key]->OBJ = 'Não informado';
            }

            if (!isset($c->MUNICIPIO) || !trim($c->MUNICIPIO)) {
                $contratos[$key]->MUNICIPIO = 'Não informado';
            }

            if (!isset($c->ENGENHEIRO) || !trim($c->ENGENHEIRO)) {
                $contratos[$key]->ENGENHEIRO = ' ';
            }

            if (!isset($c->FISCAL) || !trim($c->FISCAL)) {
                $contratos[$key]->FISCAL = ' ';
            }

            if (!isset($c->GESTOR) || !trim($c->GESTOR)) {
                $contratos[$key]->GESTOR = ' ';
            }
            
            $contratos[$key]->VLR_TOTAL = floatval($contratos[$key]->VLR_CTR) + floatval($contratos[$key]->VLR_ADITIVO);


            $contratos[$key]->OBJ = str_replace("'", '`', $contratos[$key]->OBJ);
            $contratos[$key]->OBJ = str_replace("¿", '-', $contratos[$key]->OBJ);

            $contratos[$key]->MUNICIPIO = str_replace("'", '"', $contratos[$key]->MUNICIPIO);
        }

        return $contratos;
    }

    protected function getItemsContratosValores($contrato = NULL) {
        $sql = "SELECT 
                PBH_CONTRA CONTRATO,
                ZWE_FONTES FONTE,
                ZWE_EMPREE EMPREENDIMENTO,
                ZWF_DESFR DSC_FONTE,
                VLR_CTR PREVISTO,
                VLR_ATUAL PREVISTO_ADITIVOS,
                VLR_FONTE EXECUTADO,
                PREVISTO_REAJ,
                EXECUTADO_REAJ
           FROM 
               CONTRATO_PREVISTO_EXECUTADO";
        //$sql = "select * from CONTRATO_VALOR_PAGO_FONTES";
        if ($contrato) {
            $sql .= " where CONTRATO like '%" . $contrato . "%'";
        }
        //var_dump($contrato);echo ($sql);
        $result = parent::execute($sql);
        return $result;
    }

    protected function getItemsContratosAditivos($contrato = NULL) {
        $sql = "select * from CONTRATO_ADITIVO";
        if ($contrato) {
            $sql .= " where COD_CONTRATO like '%" . $contrato . "%'";
        }
        //var_dump($contrato);echo ($sql);
        $result = parent::execute($sql);
        foreach ($result as $key => $item) {
            $result[$key]->ADT_DATA_INICIO = self::correctDate($item->ADT_DATA_INICIO);
			
            $result[$key]->ADT_DATA_FIM = self::correctDate($item->ADT_DATA_FIM);
            if (!isset($item->ADT_JUSTIFICATIVA)) {
                $result[$key]->ADT_JUSTIFICATIVA = "S/ Informação";
            }
            $item->ADT_JUSTIFICATIVA = htmlspecialchars($item->ADT_JUSTIFICATIVA);
            $item->ADT_JUSTIFICATIVA = str_replace("'", '`', $item->ADT_JUSTIFICATIVA);
            $item->ADT_JUSTIFICATIVA = str_replace("--", '', $item->ADT_JUSTIFICATIVA);
            $item->ADT_JUSTIFICATIVA = str_replace("==", '', $item->ADT_JUSTIFICATIVA);
            $item->ADT_JUSTIFICATIVA = str_replace("\13\10", '', $item->ADT_JUSTIFICATIVA);
            $item->ADT_JUSTIFICATIVA = str_replace("¿", '-', $item->ADT_JUSTIFICATIVA);
            $item->ADT_JUSTIFICATIVA = trim($item->ADT_JUSTIFICATIVA);
        }
        return $result;
    }

    public function getLicencasNegadas() {
        $sql = "select * from LIC_LICENCA_NEGADA where LIC_COD_EMPREENDIMENTO is not NULL";
        $result = parent::execute($sql);
        if (!is_array($result)) {
            $result = array($result);
        }
        foreach ($result as $key => $r) {
           // $result[$key]->LIC_DAT_CADASTRO = self::correctDate($r->LIC_DAT_CADASTRO);
            $result[$key]->REL_DAT_CADASTRO_REQUERIMENTO = self::correctDate($r->REL_DAT_CADASTRO_REQUERIMENTO);
            $result[$key]->REL_DAT_VENCIMENTO_BOLETO = self::correctDate($r->REL_DAT_VENCIMENTO_BOLETO);
            $result[$key]->REL_DSC_IMPEDIMENTO = str_replace("'", '`', $r->REL_DSC_IMPEDIMENTO);
        }
        return $result;
    }

    public function getItemsFiltros() {
        $sql = "select * from STATUS_SOLICITACAO_EMPREEND order by SSE_ORDEM_EXIBICAO";
        $result = parent::execute($sql);
        if (!is_array($result)) {
            $result = array($result);
        }

        $list = array();

        foreach ($result as $key => $r) {
            if ($r->SSE_NOM_STATUS_SOLICITACAO_EMP != 'EM LICITAÇÃO'){
                $list[$r->SSE_ORDEM_EXIBICAO] = new stdClass;
                $list[$r->SSE_ORDEM_EXIBICAO]->NOME = $r->SSE_NOM_STATUS_SOLICITACAO_EMP;
                $list[$r->SSE_ORDEM_EXIBICAO]->ID = $r->SSE_COD_STATUS_SOLICITACAO_EMP;
            }
        }

        return $list;
    }

    public function getItemsLicitacao() {
        $sql = "select * from LIC_LICITACAO where EMP_COD_EMPREENDIMENTO is not null";
        $result = parent::execute($sql);
        if (!is_array($result)) {
            $result = array($result);
        }

        return $result;
    }

    public function getItemsDesapropriacao() {
        $sql = "select * from DES_DESAPROPRIACAO where EMP_COD_EMPREENDIMENTO is not null";
        $result = parent::execute($sql);
        if (!is_array($result)) {
            $result = array($result);
        }

        foreach ($result as $key => $r) {
            if (!isset($result[$key]->PAQ_DSC_VIABILIDADE)) {
                $result[$key]->PAQ_DSC_VIABILIDADE = 'S/ Informações';
            }
            if (!isset($result[$key]->PAQ_NUM_MEMORIAL)) {
                $result[$key]->PAQ_NUM_MEMORIAL = 'S/ Informações';
            }
        }

        return $result;
    }
	
	public function getItemsDesapropriacaoPendente() {
	   $sql = "select * from DES_DESAPROPRIACAO_PENDENTE where EMP_COD_EMPREENDIMENTO is not null";
	   $result = parent::execute($sql);
	   if (!is_array($result)) {
		   $result = array($result);
	   }

	   foreach ($result as $key => $r) {
		   if (!isset($result[$key]->PAQ_DSC_VIABILIDADE)) {
			   $result[$key]->PAQ_DSC_VIABILIDADE = 'S/ Informações';
		   }
		   if (!isset($result[$key]->PAQ_NUM_MEMORIAL)) {
			   $result[$key]->PAQ_NUM_MEMORIAL = 'S/ Informações';
		   }
	   }
	
	   return $result;
    }

    public function getItemsMetas() {
        $sql = "select * from OBRAS_APP.CEP_CONTRATADO_EXECUT_PREVISTO where EMP_COD_EMPREENDIMENTO is not null";        
        $result = parent::execute($sql);
        if (!is_array($result)) {
            $result = array($result);
        }
        return $result;
    }

    public function getItemsAnexos() {
        $sql = "select * from AEP_ANEXO_EXECUTADO_PREVISTO where EMP_COD_EMPREENDIMENTO is not null";
        $result = parent::execute($sql);
        if (!is_array($result)) {
            $result = array($result);
        }

        foreach ($result as $k => $r) {
            $result[$k]->AEP_DAT_ANEXO = self::correctDate($r->AEP_DAT_ANEXO);
        }

        return $result;
    }
    
    public function getValoresNaoEquacionados() {
        $sql = "select * from VNE_VALOR_NAO_EQUACIONADO";
        $result = parent::execute($sql);

        return $result;
    }
	
	public function getItemsMapp() {
        $sql = "select * from MAPP";
        $result = parent::execute($sql);
		
		if (!is_array($result)) {
            $result = array($result);
        }

        foreach ($result as $k => $r) {
			if($result[$k]->PROPOSTA_MAPP == null){
				$result[$k]->PROPOSTA_MAPP = 0;
			}
            
        }

        return $result;
    }
	
	public function getLicenciamentos() {
        $sql = "select * from OBRAS_APP.LIC_LICENCIAMENTO";
		$result = parent::execute($sql);
		
		if (!is_array($result)) {
            $result = array($result);
        }
        foreach ($result as $key => $r) {
            $result[$key]->REL_DAT_CADASTRO_REQUERIMENTO = self::correctDate($r->REL_DAT_CADASTRO_REQUERIMENTO);
        }
        return $result;
    }
	
	public function getReqLicenciamentos() {
        $sql = "select * from OBRAS_APP.REL_REQUISICAO_LICENCA";
        $result = parent::execute($sql);
		if (!is_array($result)) {
            $result = array($result);
        }
        foreach ($result as $key => $r) {
            $result[$key]->REL_DAT_CADASTRO_REQUERIMENTO = self::correctDate($r->REL_DAT_CADASTRO_REQUERIMENTO);
        }
        return $result;
    }
	

    public function json() {
        $result = array();
        $result['PROJETOS'] = self::getProjetos();
        //$result['ITEMS'] = self::getItemsTecnicos();
        $result['CONTRATOS'] = self::getItemsContratos();
        $result['LICENCAS_NEGADAS'] = self::getLicencasNegadas();
        $result['VALOR_PAGO'] = self::getItemsContratosValores();
        $result['VALOR_ADITIVO'] = self::getItemsContratosAditivos();
        $result['FILTROS'] = self::getItemsFiltros();
        $result['LICITACAO'] = self::getItemsLicitacao();
        $result['DESAPROPRIACAO'] = self::getItemsDesapropriacao();
		$result['DESAPROPRIACOES_PEDENTES'] = self::getItemsDesapropriacaoPendente();
		
        $result['METAS'] = self::getItemsMetas();
        $result['ANEXOS'] = self::getItemsAnexos();
        $result['EQUACIONADOS'] = self::getValoresNaoEquacionados();
        $result['MAPPS'] = self::getItemsMapp();
		
		$result['LICENCIAMENTOS'] = self::getLicenciamentos();
		$result['REQLICENCIAMENTOS'] = self::getReqLicenciamentos();
		
        return $result;
    }

    protected function correctDate($data) {
        $array_data = explode('-', $data);
        $mes = self::getMesEn($array_data[1]);
        $novaData = $array_data[0] . '/' . $mes . '/' . $array_data[2];

        return $novaData;
    }
	
	   protected function dataPadraoAmericano($data) {
		$dataCorrigida =self::correctDate($data);
        $array_data = explode('/', $dataCorrigida);
        $mes = self::getMesEn($array_data[1]);
        $novaData =  $array_data[2]. '/' . $mes. '/' .  $array_data[0];

        return $novaData;
    }

}

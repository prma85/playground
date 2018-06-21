<?php

class lanlinkModel {

    public function executeOracle($sql, $update = false) {
        $conn = oci_new_connect('OTRS', '0TRS', '172.25.131.73:1521/CGORA2', 'AL32UTF8');
        $prepare = oci_parse($conn, $sql) or die('Existe um erro na sua consulta SQL<br>' . var_dump(oci_error($prepare)));
        $stdi = oci_execute($prepare) or die('Existe um erro na sua consulta SQL <br />' . $sql . var_dump(oci_error($prepare)));
        if ($update) {
            return $stdi;
        } else {
            $list = array();
            while ($result = oci_fetch_object($prepare, OCI_ASSOC)) {
                $list[] = $result;
            }
            return $list;
        }

        oci_close($conn);
    }

    public function getCabecalho() {
        GLOBAL $fechadosHoje;
        GLOBAL $fechadosMes;
        GLOBAL $pendentes;
        $sql_fechados_hoje = "select count(t.id) as total from ticket t, users u, COL_COLABORADOR col where ticket_state_id in (2,3,21) and TO_CHAR(t.change_time,'DD/MM/YYYY') = TO_CHAR(sysdate,'DD/MM/YYYY') and t.RESPONSIBLE_USER_ID = u.ID(+) and u.LOGIN = col.COL_DSC_LOGIN (+) and t.title NOT LIKE 'Host DOWN%'";
        $fechadosHoje = self::executeOracle($sql_fechados_hoje);
		//var_dump($sql_fechados_hoje); die;
        if (!is_array($fechadosHoje) && $fechadosHoje) {
            $fechadosHoje = array($fechadosHoje);
        }
        $sql_fechados_mes = "select count(t.id) as total from ticket t, users u, COL_COLABORADOR col where ticket_state_id in (2,3,21) and TO_CHAR(t.change_time,'MM/YYYY') = TO_CHAR(sysdate,'MM/YYYY') AND t.change_time<=LAST_DAY(SYSDATE) and t.RESPONSIBLE_USER_ID = u.ID(+) and u.LOGIN = col.COL_DSC_LOGIN (+) and t.title NOT LIKE 'Host DOWN%'";
        $fechadosMes = self::executeOracle($sql_fechados_mes);
        if (!is_array($fechadosMes) && $fechadosMes) {
            $fechadosMes = array($fechadosMes);
        }
        $sql_pendentes = "select count (*) as total from ticket where ticket_state_id in (1,4,41,42,43,44) and TO_CHAR(change_time,'MM/YYYY') = TO_CHAR(SYSDATE,'MM/YYYY')";
        $pendentes = self::executeOracle($sql_pendentes);
        if (!is_array($pendentes) && $pendentes) {
            $pendentes = array($pendentes);
        }

        // Construção da visão do cabeçalho
        $html = array();
        $html[] = '<img alt="logo cagece" src="img/cagece.png" />';
        $html[] = 'Painel de serviços de suporte por técnico';
        $html[] = '<div class="caixaCabecalho"><span class="descricaoCabecalho">Pendentes</span>' . $pendentes[0]->TOTAL . '</div>';
        $html[] = '<div class="caixaCabecalho"><span class="descricaoCabecalho">Fechados Hoje</span>' . $fechadosHoje[0]->TOTAL . '</div>';
        $html[] = '<div class="caixaCabecalho"><span class="descricaoCabecalho">Fechados Mês</span>' . $fechadosMes[0]->TOTAL . '</div>';
        
        return implode($html);
    }

    public function getInformacoesTecnicos($mode = 'object', $empresa = null) {

        $where = "";
        if ($empresa == 'lanlink') {
            // Exibição apenas dos técnicos da lanlink
            //$incluirTecnicos = "where M.MATRICULA in ('2082152','2083221','2083231','2092891','2092905','2097303','2098873','2099641','2101343','2101718','2063549','2082161')";
            $where = " and T.TEC_FLG_EMPRESA = 'L'";
        } else if ($empresa == 'cagece') {
            // Exibição apenas dos técnicos da cagece            
            //$incluirTecnicos = "where MATRICULA in ('205471X','2054396','2096081', '2094967','0029904','2006448')";
            $where = " and T.TEC_FLG_EMPRESA = 'C'";
        }
        $sql = "select * from otrs.MOL_MONITORAMENTO_LANLINK M, otrs.TEC_TECNICO T where M.MATRICULA = T.TEC_COD_MATRICULA " . $where . " order by T.TEC_FLG_EMPRESA, M.QTD_FECHADO_MES DESC, M.QTD_FECHADO_DIA DESC";
        //var_dump($sql);die;


        $result = self::executeOracle($sql);

        if (!is_array($result) && $result) {
            $result = array($result);
        }

        if ($mode == 'html') {
            $result = $this->getInformacoesHtml($result);
        }

        return $result;
    }

    public function getInformacoesHtml($informacoes) {
        $objetivos = array('414' => 'verde', '415' => 'verde', '417' => 'amarelo', '418' => 'vermelho', '419' => 'vermelho', '420' => 'azul', '421' => 'azul');
        $html = array();
        $html[] = '<div class="row">';
        $ind_js = array();

        foreach ($informacoes as $k => $i) {
            $html[] = '<div class="box-indicador col-xs-12 col-lg-3 col-sm-6">';
            $html[] = '<div class="indicador">';
            //$html[] = '<div class="titulo"><a title="link para o tecnico ' . $i->TECNICO . '" href="http://cliquecagece.int.cagece.com.br/otrs/?matricula=' . $i->MATRICULA . '" >' . $i->TECNICO . '</a></div>';
            $html[] = '<div class="titulo"><a title="link para o tecnico ' . $i->TECNICO . '" href="javascript:void(0);" onclick="abreDetalhes('.$i->MATRICULA.',\''.$i->TECNICO.'\');" >' . $i->TECNICO . '</a></div>';
            
            $html[] = '<div class="conteudo row">';

            $i->ANO = 999;

            $html[] = '<div class="esquerda col-xs-12 col-xs-7">';
            $html[] = '<div class="referencia preto w100"><span class="descricaoCaixa">+24h</span><span class="quantidade">' . $i->C24h . '</span></div>';
            $html[] = '<div class="referencia vermelho w50"><span class="descricaoCaixa">4-24h</span><span class="quantidade">' . $i->C4h . '</span></div>';
            $html[] = '<div class="referencia laranja w50"><span class="descricaoCaixa">2-4h</span><span class="quantidade">' . $i->C3h . '</span></div>';
            $html[] = '<div class="referencia amarelo w50"><span class="descricaoCaixa">1-2h</span><span class="quantidade">' . $i->C2h . '</span></div>';
            $html[] = '<div class="referencia verde w50"><span class="descricaoCaixa">0-1h</span><span class="quantidade">' . $i->C1h . '</span></div>';
            $html[] = '<div class="clear"></div>';
            $html[] = '</div>';

            $html[] = '<div class="direita col-xs-12 col-xs-5">';
            $html[] = '<a title="link para o tecnico ' . $i->TECNICO . '" href="javascript:void(0);" onclick="abreDetalhes('.$i->MATRICULA.',\''.$i->TECNICO.'\');" ><img alt="' . $i->TECNICO . '" src="photos/' . $i->MATRICULA . '.png"></a>';
            $html[] = '</div>';

            $html[] = '</div>'; //fecha row das colunas

            $html[] = '<div class="row totais">';
            $html[] = '<span><span class="descricaoCaixa">Mês</span><span class="quantidade">' . $i->QTD_FECHADO_MES . '</span></span>';
            $html[] = '<span><span class="descricaoCaixa">Dia</span><span class="quantidade">' . $i->QTD_FECHADO_DIA . '</span></span>';
            $html[] = '</div>'; //fecha row dos totais

            $html[] = '</div></div>'; //fecha indicador e box-indicador

            $j = $k + 1;
            if ($j % 4 == 0) {
                $html[] = '</div><div class="row">';
            }

            //var_dump($i); die;
            //$i->MAPA = $this->getUnidadesMapa($i->COD_INDICADOR_CAPITAL, $i->COD_INDICADOR_INTERIOR, $i->ANOMES);
            //$ind_js[$i->MATRICULA] = $i;
        }
        $html[] = '</div>';


        //$indicadoresNovo = json_encode($ind_js);
        //$html[] = "<script>var atual = '" . $indicadoresNovo . "';</script>";
        //var_dump($html);
        //die;
        return implode($html);
    }

}

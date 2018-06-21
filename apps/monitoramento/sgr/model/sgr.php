<?php

class sgrModel {
    private $_conn;
    private $host = '172.25.131.73';
    private $user = 'indicadores';
    private $password = '1nd1ca';
    private $sid = 'cgora2';
    private $port = '1521';
    private $socket = '';

    /**
     * Create a oracle connection
     * @param   array   $options    indexed array with the connection of oracle. If any option selected, try get in the config of componnet
     * @return  array
     * @see  sgrModel
     * @since 1.0
     */
    private function conn() {
        $options['host'] = $this->host;
        $options['user'] = $this->user;
        $options['password'] = $this->password;
        $options['sid'] = $this->sid;
        $options['port'] = $this->port;
        $options['socket'] = $this->socket;
  
        $tmp = substr(strstr($options['host'], ':'), 1);
        if (!empty($tmp)) {
            // Get the port number or socket name
            if (is_numeric($tmp)) {
                $options['port'] = $tmp;
            } else {
                $options['socket'] = $tmp;
            }

            // Extract the host name only
            $options['host'] = substr($options['host'], 0, strlen($options['host']) - (strlen($tmp) + 1));

            // This will take care of the following notation: ":3306"
            if ($options['host'] == '') {
                $options['host'] = 'localhost';
            }
        }

        // Make sure the MySQLi extension for PHP is installed and enabled.
        if (!function_exists('oci_connect')) {
            die('Oracle não está disponível');
        }
        
        $conect = oci_connect($options['user'], $options['password'], $options['host'] . ":" . $options['port'] . "/" . $options['sid'], 'AL32UTF8');

        if (!$conect) {
            $m = oci_error();
            echo $m;
            $conect = false;
        }

        $this->_conn = $conect;
    }

    /**
     * @param   string   $sql    The query for execute in oracle
     * @param   string   $type   If the array constains object or another array
     * @param   connection   $conn   Give a active connection in oracle
     * @return  array
     * @see  sgrModel
     * @since 1.0
     */
    public function execute($sql, $type = 'object', $case = 0, $c = NULL) {

        if (!$this->_conn) {
            if ($c == NULL || !is_array($c)) {
                self::conn();
            } else {
                self::conn($c);
            }
        }

        if ($this->_conn == false) {
            $e = oci_error();   // For oci_connect errors do not pass a handle
            trigger_error(htmlentities($e['message']), E_USER_ERROR);
            die('Erro ao se conectar ao Oracle');
            //JError::raiseError(500, 'Erro ao se conectar com o ORACLE');
            return false;
        }

        //DEBUG para saber qual foi o erro no ORACLE
        //$prepare = oci_parse($conn,$sql) or die ('Existe um erro na sua consulta SQL');
        //oci_execute($prepare) or die ('Existe um erro na sua consulta SQL <br />'.$sql);

        if ($case == 1) {
            $nls_comp = oci_parse($this->_conn, 'alter session set nls_comp=linguistic');
            oci_execute($nls_comp);

            $nls_sort = oci_parse($this->_conn, 'alter session set nls_sort=binary_ai');
            oci_execute($nls_sort);
        }

        $prepare = oci_parse($this->_conn, $sql);
        if (!$prepare) {
            $e = oci_error($this->_conn);  // For oci_parse errors pass the connection handle
            trigger_error(htmlentities($e['message']), E_USER_ERROR);
        }

        //echo $sql; die;

        $list = array();
        $i = 0;

        $r = oci_execute($prepare);
        if (!$r) {
            $e = oci_error($stid);  // For oci_execute errors pass the statement handle
            print htmlentities($e['message']);
            print "\n<pre>\n";
            print htmlentities($e['sqltext']);
            printf("\n%" . ($e['offset'] + 1) . "s", "^");
            print "\n</pre>\n";

            self::close();
            die;
        } else {
            if ($type == 'object') {
                while ($result = oci_fetch_object($prepare, OCI_ASSOC)) {
                    $list[$i] = $result;
                    $i++;
                }
            } elseif ($type == 'update') {
                self::close();
                return true;
            } else {
                while ($result = oci_fetch_array($prepare, OCI_ASSOC)) {
                    $list[$i] = $result;
                    $i++;
                }
            }

            if (empty($list)) {
                $list = NULL;
            }

            if (count($list) == 1) {
                $list = $list[0];
            }

            self::close();

            return $list;
        }
    }

    /**
     * @param   string   $sql    The query for update in oracle
     * @param   connection   $c   Give a active connection in oracle
     * @return  boolean
     * @see  sgrModel
     * @since 1.0
     */
    public function update($sql, $c = NULL) {

        if (!$this->_conn) {
            if ($c == NULL || !is_array($c)) {
                self::conn();
            } else {
                self::conn($c);
            }
        }

        if ($this->_conn == false) {
            $e = oci_error();   // For oci_connect errors do not pass a handle
            trigger_error(htmlentities($e['message']), E_USER_ERROR);
            die('Erro ao se conectar ao Oracle');
            //JError::raiseError(500, 'Erro ao se conectar com o ORACLE');
            return false;
        }

        $prepare = oci_parse($this->_conn, $sql);
        if (!$prepare) {
            $e = oci_error($this->_conn);  // For oci_parse errors pass the connection handle
            trigger_error(htmlentities($e['message']), E_USER_ERROR);
        }

        $r = oci_execute($prepare);
        if (!$r) {
            $e = oci_error($prepare);  // For oci_execute errors pass the statement handle
            print htmlentities($e['message']);
            print "\n<pre>\n";
            print htmlentities($e['sqltext']);
            printf("\n%" . ($e['offset'] + 1) . "s", "^");
            print "\n</pre>\n";

            self::close();
            die;
        } else {
            self::close();
            return $r;
        }

        //DEBUG para saber qual foi o erro no ORACLE
        //$prepare = oci_parse($conn,$sql) or die ('Existe um erro na sua consulta SQL');
        //oci_execute($prepare) or die ('Existe um erro na sua consulta SQL <br />'.$sql);
    }

    /**
     * Take a month in portuguese
     * @param   string   $mes    The month that you need
     * @return  string   $mes    The name in portuguese
     * @see  sgrModel
     * @since 1.0
     */
    public function getMes($mes) {
        $mes = (int) $mes;
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
            case 13: $mes = '13o Salário';
                break;
        }

        return $mes;
    }

    /**
     * Take a month in portuguese
     * @param   string   $string    The name to correct
     * @return  string   $string    The name without acentos
     * @see  sgrModel
     * @since 1.0
     */
    public function semAcento($string) {
        $string = str_replace("Â", "a", $string);
        $string = str_replace("Á", "a", $string);
        $string = str_replace("Ã", "a", $string);
        $string = str_replace("A", "a", $string);
        $string = str_replace("Ê", "e", $string);
        $string = str_replace("É", "e", $string);
        $string = str_replace("I", "i", $string);
        $string = str_replace("Í", "i", $string);
        $string = str_replace("Ó", "o", $string);
        $string = str_replace("Õ", "o", $string);
        $string = str_replace("Ô", "o", $string);
        $string = str_replace("Ú", "u", $string);
        $string = str_replace("U", "u", $string);
        $string = str_replace("Ç", "c", $string);
        $string = strtolower($string);
        return ($string);
    }
    
    /**
     * Close the oracle connection
     * @param   connection   $conn    A active conection with oracle.
     * @return  true
     * @see  consultascageceModelOracle
     * @since 1.0
     */
    protected function close() {
        oci_close($this->_conn);
        return TRUE;
    }
    
    
    public function getIndicadoresRecentes($mode = 'object') {
        $sql = "SELECT DISTINCT obj.obj_dsc_objetivo objetivo,
                ind.ind_nom_indicador nome_indicador,
                initcap(TO_CHAR(idd.idd_dat_referencia_meta, 'mon yyyy')) periodo,
                CASE
                  WHEN (ind.ind_sentido_indicador = 1
                  AND idd.idd_vlr_meta            > 0)
                  THEN ROUND(((cin.cin_vlr_valor    /idd.idd_vlr_meta) * 100)-100,2)
                  WHEN (ind.ind_sentido_indicador = -1
                  AND idd.idd_vlr_meta            > 0)
                  THEN ROUND((100 - (((cin.cin_vlr_valor/idd.idd_vlr_meta) * 100) - 100)) - 100,2)
                  ELSE 0
                END variacao,
                idd.idd_vlr_meta previsto,
                cin.cin_vlr_valor realizado,
                FC_STATUS_INDICADOR_MENSAL(NVL(IDD.IDD_VLR_META, 0), NVL(CIN.CIN_VLR_VALOR, 0), NVL(
                (SELECT cin_vlr_valor
                FROM cin_consulta_indicador
                WHERE TO_CHAR(val_dat_referencia, 'yyyymm') = TO_CHAR(add_months(idd.idd_dat_referencia_meta,-1), 'yyyymm')
                AND cin_cod_dimensao                        = idd.idd_cod_dimensao
                AND cin_flg_dimensao                        = idd.idd_flg_dimensao
                AND ind_cod_indicador                       = ind.ind_cod_indicador
                ), 0), NVL(
                (SELECT cin_vlr_valor
                FROM CIN_CONSULTA_INDICADOR
                WHERE TO_CHAR(val_dat_referencia, 'mm') = '12'
                AND cin_cod_dimensao                    = idd.idd_cod_dimensao
                AND cin_flg_dimensao                    = idd.idd_flg_dimensao
                AND IND_COD_INDICADOR                   = IND.IND_COD_INDICADOR
                AND TO_CHAR(val_dat_referencia, 'YYYY') = TO_CHAR(add_months(idd.idd_dat_referencia_meta,-12),'yyyy')
                ), 0), IND.IND_SENTIDO_INDICADOR, IND.IND_FLG_POSICAO_INICIAL) STATUS,
                ind.ind_exb_decimal exb_decimal,
                unm.unm_dsc_und_medida medida,
                ROUND(fc_percent_atingido(ind.ind_cod_indicador, to_number(TO_CHAR(idd.idd_dat_referencia_meta, 'yyyy')), to_number(TO_CHAR(idd.idd_dat_referencia_meta, 'mm')), ind.ind_sentido_indicador, ind.ind_flg_posicao_inicial, idd.idd_cod_dimensao),2) atingido,
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
                      AND cin_cod_dimensao    = t.cin_cod_dimensao
                      )
                    )
                  ELSE cin.cin_vlr_valor
                END REAL_GRAF,
                ind.ind_tip_periodicidade periodicidade,
                IDD.IND_COD_INDICADOR INDICADOR,
                obj.obj_cod_objetivo,
                obj.obj_num_ordem_apres,
                TO_CHAR(idd.idd_dat_referencia_meta, 'yyyymm') anomes
              FROM cin_consulta_indicador cin,
                idd_indicador_dimensao idd,
                ind_indicador ind,
                unm_unidade_medida unm,
                obj_objetivo obj,
                (SELECT IND_COD_INDICADOR,
                  TO_CHAR(MAX(VAL_DAT_REFERENCIA),'yyyymm') dat_referencia
                FROM cin_consulta_indicador
                  -- Fixo grupo de indicadores da primeira fase
                WHERE IND_COD_INDICADOR IN (11423,1480,14666, 5902,5903,5822,5842, 15647, 15628,25169,6685,12842)
                AND CIN_VLR_VALOR        > 0 -- Em teste
                GROUP BY IND_COD_INDICADOR
                ) lis
              WHERE cin.ind_cod_indicador(+)                     = idd.ind_cod_indicador
              AND cin.cin_cod_dimensao(+)                        = idd.idd_cod_dimensao
              AND cin.val_dat_referencia(+)                      = idd.idd_dat_referencia_meta
              AND idd.ind_cod_indicador                          = ind.ind_cod_indicador
              AND ind.unm_cod_und_medida                         = unm.unm_cod_und_medida
              AND ind.ind_flg_corporativo                        = 'S'
              AND idd.idd_flg_dimensao                           = 'S'
              AND ind.obj_cod_objetivo                           = obj.obj_cod_objetivo
              AND TO_CHAR(idd.idd_dat_referencia_meta, 'yyyymm') = lis.dat_referencia
              AND IDD.IND_COD_INDICADOR                          = lis.IND_COD_INDICADOR
              ORDER BY obj.obj_cod_objetivo,
                obj.obj_num_ordem_apres";
        $result = self::execute($sql);
        if (!is_array($result) && $result) {
            $result = array($result);
        }

        if ($mode == 'html') {
            $result = $this->getIndicadoresHtml($result);
        }
        
        return $result;
    }
    
    public function getIndicadoresHtml($indicadores) {
        $objetivos = array('414' =>  'verde', '415' => 'verde', '417' => 'amarelo', '418' => 'vermelho', '419' => 'vermelho', '420' => 'azul', '421' => 'azul');
        $html = array();
        $html[] = '<div class="container" id="indicadores"><div class="row">';
        
        foreach ($indicadores as $k=>$i){
            if ($i->MEDIDA == '%'){
               $i->PREVISTO = number_format($i->PREVISTO,2).'%'; 
               $i->REALIZADO = number_format($i->REALIZADO,2).'%';
            }
            //var_dump($i);
            $i->VARIACAO = number_format($i->VARIACAO,2).'%';;
            $i->NOME_INDICADOR = str_replace('INDICE DE QUALIDADE DA AGUA DISTRIBUIDA NO CEARA', 'INDICE DE QUALIDADE DA AGUA DISTRIBUIDA', $i->NOME_INDICADOR);
            $i->NOME_INDICADOR = str_replace('INDICE DE EFICIÊNCIA DE EXECUÇÃO DOS INVESTIMENTOS', 'EFICIÊNCIA DE EXECUÇÃO DOS INVESTIMENTOS', $i->NOME_INDICADOR);
            $html[] = '<div class="box-indicador col-xs-12 col-lg-3 col-sm-6">';
            $html[] = '<div class="indicador '.$objetivos[$i->OBJ_COD_OBJETIVO].' ind-'.$i->INDICADOR.'">';
            $ano = substr(trim($i->PERIODO), -4);
            //$html[] = '<div class="titulo"><a title="link para o indicador '.$i->INDICADOR.'" href="javascript:abirIndicador('.$i->INDICADOR.', '.$ano.');" >'.$i->NOME_INDICADOR.'</a></div>';
            $html[] = '<div class="titulo"><a title="link para o indicador '.$i->INDICADOR.'" href="javascript:abirIndicador('.$i->INDICADOR.');" >'.$i->NOME_INDICADOR.'</a></div>';
            $html[] = '<div class="conteudo row">';
            
            $html[] = '<div class="esquerda col-xs-7">';
            $html[] = '<div class="referencia">'.$i->PERIODO.'</div>';
            $html[] = '<div class="valores">';
            $html[] = '<div><span>Previsto </span><span class="valor">'.$i->PREVISTO.'</span></div>';
            $html[] = '<div><span>Realizado </span><span class="valor">'.$i->REALIZADO.'</span></div>';
            $html[] = '</div>';
            $html[] = '</div>';
            
            $html[] = '<div class="direita col-xs-5">';
            $html[] = '<a title="link para o indicador '.$i->INDICADOR.'" href="javascript:abirIndicador('.$i->INDICADOR.', '.$ano.');" ><img alt="'.$i->STATUS.'" src="img/'.$i->STATUS.'.png"></a>';
            $html[] = '<span>'.$i->VARIACAO.'</span>';
            $html[] = '</div>';
            
            $html[] = '</div>';
            
            $html[] = '</div></div>';
            
            $j = $k+1;
            if ($j%4 == 0){
                $html[] = '</div><div class="row">';
            }
        }
        $html[] = '</div></div>';
        
        return implode($html);
    }
    
    public function getIndicador($id){
        
    }
}

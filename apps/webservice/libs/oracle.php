<?php

/**
 * Consultas Cagece Class Model - Oracle
 *
 * Acts as a Factory class for application specific objects and
 * provides suport to work with Oracle.
 *
 * @package     webservice
 * @since       1.0
 */
class modelOracle {

    var $host;
    var $user;
    var $password;
    var $sid;
    var $port;
    var $socket;

    /**
     * Create a oracle connection
     *
     * @param   array   $options    indexed array with the connection of oracle. If any option selected, try get in the config of componnet
     *
     * @return  array
     *
     * @see  modelOracle
     *
     * @since 1.0
     *
     */
    private function conn($options = array()) {
        // Get some basic values from the options.
        if (empty($options)) {
            $options['host'] = $this->host;
            $options['user'] = $this->user;
            $options['password'] = $this->password;
            $options['sid'] = $this->sid;
            $options['port'] = $this->port;
            $options['socket'] = $this->socket;
        } else {
            $options['host'] = (isset($options['host'])) ? $options['host'] : 'localhost';
            $options['user'] = (isset($options['user'])) ? $options['user'] : 'root';
            $options['password'] = (isset($options['password'])) ? $options['password'] : '';
            $options['sid'] = (isset($options['sid'])) ? $options['sid'] : '';
            $options['port'] = (isset($options['port'])) ? $options['port'] : '1521';
            $options['socket'] = null;
        }

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
            $this->errorNum = 1;
            $this->errorMsg = 'OCI Não detectado';
            return;
        }

        /* @var $oracle conexão com oracle */
        $conect = oci_connect($options['user'], $options['password'], $options['host'] . ":" . $options['port'] . "/" . $options['sid'], 'AL32UTF8');

        if (!$conect) {
            $e = oci_error();
            $this->errorNum = 1;
            $this->errorMsg = trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return $conect;
    }

    /**
     * Execute a query in the oracle connection
     *
     * @param   string   $sql    The query for execute in oracle
     *
     * @param   string   $type   If the array constains object or another array
     *
     * @param   connection   $conn   Give a active connection in oracle
     *
     * @return  array
     *
     * @see  consultascageceModelOracle
     *
     * @since 1.0
     */
    protected function execute($sql, $correct = false, $type = 'object', $case = 0, $conn = NULL) {

        header('Content-Type: text/html; charset=utf-8');
        setlocale(LC_CTYPE, "pt_BR");

        if ($conn == NULL) {
            $conn = self::conn();
        } else {
            $conn = self::conn($conn);
        }

        //DEBUG para saber qual foi o erro no ORACLE
        //$prepare = oci_parse($conn,$sql) or die ('Existe um erro na sua consulta SQL');
        //oci_execute($prepare) or die ('Existe um erro na sua consulta SQL <br />'.$sql);

        if ($case == 1) {
            $nls_comp = oci_parse($conn, 'alter session set nls_comp=linguistic');
            oci_execute($nls_comp);

            $nls_sort = oci_parse($conn, 'alter session set nls_sort=binary_ai');
            oci_execute($nls_sort);
        }

        $sql = trim($sql);
        $size = strlen($sql);

        if (substr($sql, $size - 1) == ";") { //retira ; que ficaram no final
            $sql = substr($sql, 0, $size - 1);
        }

        $prepare = oci_parse($conn, $sql);
        oci_execute($prepare);

        $list = array();
        $i = 0;

        if ($type == 'object') {
            while ($result = oci_fetch_object($prepare, OCI_ASSOC)) {
                $list[$i] = $result;
                $i++;
            }
        } else {
            while ($result = oci_fetch_array($prepare, OCI_ASSOC)) {
                $list[$i] = $result;
                $i++;
            }
        }

        if (empty($list)) {
            $list = array();
        }

        $this->close($conn);

        if ($correct == true && !empty($list)) {
            foreach ($list as $k => $items) {
                foreach ($items as $j => $item) {
                    if ($type == 'object') {
                        $list[$k]->$j = $item = trim(ucwords(utf8_encode(strtolower(utf8_decode($item)))));
                    } else {
                        $list[$k][$j] = $item = trim(ucwords(utf8_encode(strtolower(utf8_decode($item)))));
                    }
                }
            }
            //$list = array('TOTAL'=>$i) + $list;
            //var_dump($list); die;
        }

        return $list;
    }

    protected function update($sql, $conn = NULL) {

        if ($conn == NULL) {
            $conn = self::conn();
        } else {
            $conn = self::conn($conn);
        }

        //DEBUG para saber qual foi o erro no ORACLE
        //$prepare = oci_parse($conn,$sql) or die ('Existe um erro na sua consulta SQL');
        //oci_execute($prepare) or die ('Existe um erro na sua consulta SQL <br />'.$sql);

        $prepare = oci_parse($conn, $sql);

        return oci_execute($prepare);
    }

    /**
     * Take a month in portuguese
     *
     * @param   string   $mes    The month that you need
     *
     * @return  string   $mes    The name in portuguese
     *
     * @see  consultascageceModelOracle
     *
     * @since 1.0
     */
    public function getMes($mes) {
        $mes = (int)$mes;
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
	
	public function getMes3dig($mes) {
        $mes = (int)$mes;
        switch ($mes) {
            case 1: $mes = 'JAN';
                break;
            case 2: $mes = 'FEV';
                break;
            case 3: $mes = 'MAR';
                break;
            case 4: $mes = 'ABR';
                break;
            case 5: $mes = 'MAI';
                break;
            case 6: $mes = 'JUN';
                break;
            case 7: $mes = 'JUL';
                break;
            case 8: $mes = 'AGO';
                break;
            case 9: $mes = 'SET';
                break;
            case 10: $mes = 'OUT';
                break;
            case 11: $mes = 'NOV';
                break;
            case 12: $mes = 'DEZ';
                break;
        }
        return $mes;
    }

    /**
     * This function is provide information of a user using the login and col_colaborador
     *
     * @param string $login Recive a login of user to get the data
     *
     * @return User-Object Return a all user information from col_colaborador
     *
     * @see ConsultascageceModelContracheque
     *
     * @since   1.0
     */
    protected function getData($login) {

        //Executa a query para pegar os dados do usuário da com colaborador baseado no login
        $sql = "select *
        from col_colaborador
        where TRIM(LOWER(col_dsc_login)) = TRIM(LOWER('" . $login . "'))";

        $user = self::execute($sql);

        return $user;
    }

    /**
     * This function is provide all details of a user using the matricula,
     * col_colaborador and men_mensalista. Didn't work for a third party user.
     *
     * @param string $matricula Recive a login of user to get the data
     *
     * @return User-Object Return a user details
     *
     * @see ConsultascageceModelContracheque
     *
     * @since   1.0
     */
    protected function getDetails($matricula) {

        //Executa query para pegar os detalhes do usuário
        $sql = "SELECT men.men_filial filial,
            men.men_nome nome,
            men.men_funcao funcao,
            men.men_lotacao sigla_lotacao,
            men.men_mat,
            col.col_cod_matricula
          FROM men_mensalista men,
            col_colaborador col
          where men.men_mat    = '" . $matricula . "'
          AND men.men_demissao = ' '
          AND men.men_mat      = SUBSTR(col.col_cod_matricula,1,6)";

        $user = self::execute($sql);

        return $user;
    }

    /**
     * Close the oracle connection
     *
     * @param   connection   $conn    A active conection with oracle.
     *
     * @return  true
     *
     * @see  consultascageceModelOracle
     *
     * @since 1.0
     */
    private function close($conn) {
        oci_close($conn);
        return TRUE;
    }

    public function format($string, $tipo) {

        $string = preg_replace("[' '-./ t]", '', $string);
        $size = (strlen($string));
        $mask = null;


        if ($tipo == 'cpf' && $size == 11) {
            $mask = '###.###.###-##';
            $index = -1;
            for ($i = 0; $i < strlen($mask); $i++):
                if ($mask[$i] == '#')
                    $mask[$i] = $string[++$index];
            endfor;
        }

        if ($tipo == 'cep' && $size == 8) {
            $mask = '##.###-###';
            $index = -1;
            for ($i = 0; $i < strlen($mask); $i++):
                if ($mask[$i] == '#')
                    $mask[$i] = $string[++$index];
            endfor;
        }

        if ($tipo == 'fone' && $size == 10) {
            $mask = '(##) ####-####';
            $index = -1;
            for ($i = 0; $i < strlen($mask); $i++):
                if ($mask[$i] == '#')
                    $mask[$i] = $string[++$index];
            endfor;
        }

        if ($tipo == 'fone' && $size == 8) {
            $mask = '(85) ####-####';
            $index = -1;
            for ($i = 0; $i < strlen($mask); $i++):
                if ($mask[$i] == '#')
                    $mask[$i] = $string[++$index];
            endfor;
        }


        return $mask;
    }

    public function convertem($term, $tp) {
        if ($tp == "1")
            $palavra = strtr(strtoupper($term), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
        elseif ($tp == "0")
            $palavra = strtr(strtolower($term), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß", "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
        return $palavra;
    }

}

?>

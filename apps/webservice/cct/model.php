<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../libs/oracle.php');

class indicadoresCCT extends modelOracle {

    var $host = 'srvoracle';
    var $user = 'telefone';
    var $password = 'admtelefone';
    var $sid = 'cgora2';
    var $port = '1521';
    var $socket = '';
    
    var $list;
    var $unidades;
    var $listaGrat = array(
        'AGENTE' => 'AGENTE',
        'ASSESOR DA PRESIDENCIA' => 'ASSESOR DA PRESIDENCIA',
        'ASSIST.REGIONAL DIRETORIA' => 'ASSIST.REGIONAL DIRETORIA',
        'CHEFE DE GABINETE' => 'ASSESOR DA PRESIDENCIA',
        'CHEFE DE TURMA' => '',
        'COORD.PROG.MEDICO' => '',
        'COORDENADOR' => 'COORDENADOR',
        'DIRETOR' => 'DIRETOR',
        'DIRETOR ADJUNTO' => 'DIRETOR ADJUNTO',
        'GERENTE' => 'GERENTE',
        'LJ. ATEND II / CASA CIDADAO' => '',
        'LJ. ATEND. III / LOJA CENTRAL' => '',
        'LOJA ATENDIMENTO I' => '',
        'MEMBROS PREGAO' => '',
        'MOTORISTA VEICULO ESPECIAL' => '',
        'NUCLEO I' => 'NUCLEO',
        'NUCLEO II' => 'NUCLEO',
        'NUCLEO III' => 'NUCLEO',
        'NUCLEO IV' => 'NUCLEO',
        'PREGOEIRO' => '',
        'PRESIDENTE' => 'PRESIDENTE',
        'PROCURADOR JURIDICO' => 'PROCURADOR JURIDICO',
        'SECRETARIA DIRETORIA' => 'SECRETARIA DIRETORIA',
        'SECRETARIA EXEC.DA PRESIDENCIA' => 'ASSESOR DA PRESIDENCIA',
        'SECRETARIA PRESIDENCIA' => 'ASSESOR DA PRESIDENCIA',
        'SUP. OPERACIONAL II' => 'SUPERVISOR',
        'SUPERVISAO IV' => 'SUPERVISOR',
        'SUPERVISOR II' => 'SUPERVISOR',
        'SUPERVISOR III' => 'SUPERVISOR'
    );

    //(ici.pcm_cod_ano*100) anomes
    public function lista() {
        //$unidades = ('GIDEJ','Escritório de Novos Negócios','ASCOR','AUDIN','GAPES','GAPRE','GCONT','GCOPE','GCORI','GDEMP','GEPES','GEADI','GECOB','GECON','GECOQ','GECSA','GEFAR','GEFIC','GETIC','GERIS','GELOG','GEMAM','GEMAE','GEREM','GESOR','GEPED','GDOPI','GEREC','GESCO','GESAR','GESEP','GETER','GOINT','GEROB','GOPAC','GPLAE','GPROJ','GTRAN','OUVID','PROJU','UEPSJ','GEAPE','UGP SANEAR II','UN-BAC','UN-BAJ','UN-BBA','UN-BBJ','UN-BCL','UN-BME','UN-BPA','UN-BSA','UN-MPA','UN-MTE','UN-MTL','UN-MTN','UN-MTO','UN-MTS','Escritório de Projetos','DIC','Biblioteca','COETICA','CGTI','PMSB Capital','PMSB Interior','UN-BSI','GECOR','Assistências Regionais de Diretoria');

        $list = Array();
        $Sfuncionario = "select trim(col.col_cod_matricula) mat,
                    trim(col.col_dsc_nome) nome,
                    trim(col.col_dsc_email) email,
                    trim(emp.emp_dsc_apelido) apelido,
                    '('
                    ||cot.cot_num_ddd
                    ||')'
                    ||trim(cot.cot_num_telefone) numero,
                    '('
                    ||cot.cot_num_ddd
                    ||')'
                    || trim(emp.emp_dsc_celular) celular,
                    SUBSTR(col.col_dat_nascimento,0,5) aniversario,
                    trim(fug.fug_dsc_funcao_gratificada) funcao,
                    trim(uad.uad_sgl_unidade_administrativa) sigla,
                    --trim(uad.uad_dsc_unidade_administrativa) unidade,
                    trim(loc.loc_dsc_localidade) localidade
                  FROM col_colaborador col,
                    fug_funcao_gratificada fug,
                    uad_unidade_administrativa uad,
                    loc_localidade loc,
                    cot_colaborador_telefone cot,
                    emp_empregado emp
                  WHERE col.fug_cod_funcao_gratificada   = fug.fug_cod_funcao_gratificada(+)
                  AND col.col_cod_matricula              = cot.cot_cod_matricula
                  AND col.col_cod_matricula              = emp.emp_cod_matricula
                  AND col.uad_cod_unidade_administrativa = uad.uad_cod_unidade_administrativa
                  AND col.loc_cod_localidade             = loc.loc_cod_localidade
                  and col.col_flg_categoria = 'M'
                  ORDER BY nome;";

        $funcionario = self::execute($Sfuncionario);

        $Sterceiro = "select trim(col.col_cod_matricula) mat,
                trim(col.col_dsc_nome) nome,
                trim(col.col_dsc_email) email,
                trim(col.col_dsc_apelido) apelido,
                '('
                ||cot.cot_num_ddd
                ||')'
                ||trim(cot.cot_num_telefone) numero,
                SUBSTR(col.col_dat_nascimento,0,5) aniversario,
                trim(fug.fug_dsc_funcao_gratificada) funcao,
                trim(uad.uad_sgl_unidade_administrativa) sigla,
                trim(loc.loc_dsc_localidade) localidade
              FROM col_colaborador col,
                fug_funcao_gratificada fug,
                uad_unidade_administrativa uad,
                loc_localidade loc,
                cot_colaborador_telefone cot
              WHERE col.fug_cod_funcao_gratificada   = fug.fug_cod_funcao_gratificada(+)
              and col.col_cod_matricula              = cot.cot_cod_matricula
              AND col.uad_cod_unidade_administrativa = uad.uad_cod_unidade_administrativa
              and col.loc_cod_localidade             = loc.loc_cod_localidade
              and col.col_flg_categoria in ('T','A')
              ORDER BY nome;";

        $terceiro = self::execute($Sterceiro);


        $sql = "SELECT trim(col.col_cod_matricula) mat,
                trim(col.col_dsc_nome) nome,
                trim(col.col_dsc_email) email,
                trim(col.col_dsc_apelido) apelido,
                trim(cot.cot_num_ddd)
                ||trim(cot.cot_num_telefone) telefone,
                TO_CHAR(col.col_dat_nascimento,'DD/MM') aniversario,
                trim(fug.fug_dsc_funcao_gratificada) funcao,
                trim(uad.uad_sgl_unidade_administrativa) sigla,
                trim(uad.uad_dsc_unidade_administrativa) unidade,
                trim(loc.loc_dsc_localidade) localidade,
                trim(col.col_flg_categoria) flg
              FROM col_colaborador col,
                fug_funcao_gratificada fug,
                uad_unidade_administrativa uad,
                loc_localidade loc,
                cot_colaborador_telefone cot
              WHERE col.fug_cod_funcao_gratificada   = fug.fug_cod_funcao_gratificada(+)
              and col.col_cod_matricula              = cot.cot_cod_matricula
              AND col.uad_cod_unidade_administrativa = uad.uad_cod_unidade_administrativa
              and col.loc_cod_localidade             = loc.loc_cod_localidade
              and ( trim(fug.fug_dsc_funcao_gratificada) in ('ASSESOR DA PRESIDENCIA','ASSIST.REGIONAL DIRETORIA','CHEFE DE GABINETE','COORDENADOR','DIRETOR','DIRETOR ADJUNTO','GERENTE','PRESIDENTE','PROCURADOR JURIDICO','SECRETARIA DIRETORIA','SECRETARIA EXEC.DA PRESIDENCIA','SECRETARIA PRESIDENCIA','SUP. OPERACIONAL II','SUPERVISAO IV','SUPERVISOR II','SUPERVISOR III') or trim(uad.uad_dsc_unidade_administrativa) in ('DDO', 'DEN', 'DGE', 'DIC', 'DPC', 'DPR', 'GAPRE'))
              order by nome;";

        $result = self::execute($sql);

        foreach ($result as $k => $r) {
            $result[$k]->SIGLA = preg_replace("/[^a-zA-Z-\s]/", "", $r->SIGLA);
            if (substr($r->SIGLA, 5, -3) == " ") {
                $result[$k]->SIGLA = substr($r->SIGLA, 0, 5);
            }

            $result[$k]->SIGLA = str_replace("MACRODISTRIBUICAO", "UN-MPA", $r->SIGLA);
            $result[$k]->SIGLA = str_replace("ETA GAVIAO", "UN-MPA", $r->SIGLA);
            $result[$k]->SIGLA = str_replace("EPC", "UN-MTE", $r->SIGLA);
            $result[$k]->SIGLA = str_replace("UGP-SANEAR", "UGP-SANEAR II", $r->SIGLA);
            $result[$k]->SIGLA = str_replace("UN-MPA ETA OESTE", "UN-MPA", $r->SIGLA);
            $result[$k]->SIGLA = str_replace("A DISPOS", "A DISPOSICAO", $r->SIGLA);
            $result[$k]->SIGLA = str_replace("GAPRE", "DPR", $r->SIGLA);

            if (isset($r->FUNCAO)) {
                $result[$k]->FUNCAO = $this->verificaGratificacao($r->FUNCAO);
            } else {
                $result[$k]->FUNCAO = '';
            }

            if (isset($r->EMAIL)) {
                $result[$k]->EMAIL = strtolower($r->EMAIL);
            } else {
                $result[$k]->EMAIL = '';
            }

            if (!isset($r->APELIDO)) {
                $result[$k]->APELIDO = '';
            }

            $sql2 = "select trim(emp_dsc_celular) celular from emp_empregado emp where emp_cod_matricula = '" . $r->MAT . "'";
            $cel = self::execute($sql2);
            $cel = $cel[0];

            if (isset($cel->CELULAR)) {
                $r->CELULAR = preg_replace("/[^0-9]/", "", $cel->CELULAR);
            } else {
                $r->CELULAR = '';
            }

            $result[$k]->TELEFONE = preg_replace("/[^0-9]/", "", $r->TELEFONE);
            $result[$k]->CELULAR = str_replace("00000000", "", $r->CELULAR);
            if ($result[$k]->CELULAR == "00") {
                $result[$k]->CELULAR = "";
            }
        }
        return $result;
    }

    public function verificaGratificacao($grat) {

        $test = false;
        foreach ($this->listaGrat as $i => $a) {
            if ($i == $grat) {
                $grat = $a;
                $test = true;
                break;
            }
        }

        if ($test == false) {
            $grat = '';
        }

        return $grat;
    }

    public function unidades() {
        $sql = "";
        return self::execute($sql);
    }

    public function json() {
        $result = Array();

        $result['ESTADO'] = $this->estado();
        $result['NEGOCIO'] = $this->negocio();
        $result['CIDADES'] = $this->cidades();
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

}

?>

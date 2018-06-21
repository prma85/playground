<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../libs/oracle.php');

class mudancas extends modelOracle {
	
	var $list;
        var $host = '172.25.131.73';
	var $user = 'otrs_leitura';
	var $password = 'otr5';
	var $sid = 'CGORA2';
	var $port = '1521';
	var $socket = '';
	
	public function result($txt){
		$txt = strtoupper($txt);
		
		$sql = "SELECT itc_cod_item_configuracao id,
				  itc_dsc_nome ativo,
				  'https://srvotrs.int.cagece.com.br/otrs/index.pl?Action=AgentITSMConfigItemZoom;ConfigItemID='
				  || itc_cod_item_configuracao LINK
				FROM itc_item_configuracao
				WHERE upper(itc_dsc_nome) LIKE '%".$txt."%';";
		
		$result = self::execute($sql);
		return $result;
		
	}
	
	public function afetado($id){
		$sql = "select ITC.ITC_DSC_NOME, IRE.IRE_COD_RELACAO, IRE.IRE_DSC_RELACAO  
				from ITC_ITEM_CONFIGURACAO ITC, IRE_ITEM_RELACIONAMENTO IRE 
				where itc.itc_cod_item_configuracao=ire.ire_cod_destino 
				and IRE.IRE_COD_ORIGEM='$id' and IRE.IRE_COD_RELACAO =21;";
		
		$result = self::execute($sql);
		return $result;
		
	}
	
	public function faq($id){
		$sql = "select FAQ_DSC_FAQ faq, 'https://srvotrs.int.cagece.com.br/otrs/index.pl?Action=AgentFAQZoom;ItemID=' || FAQ.FAQ_COD_FAQ link
				from FAQ_FAQ FAQ, IRE_ITEM_RELACIONAMENTO IRE 
				where ire.ire_cod_origem=faq.faq_cod_faq
				and IRE.IRE_COD_DESTINO=$id;";
		
		$result = self::execute($sql);
		return $result;
		
	}
	
	public function chamados($id){
		$sql = "select CHA.CHA_NUM_CHAMADO chamado, 'https://srvotrs.int.cagece.com.br/otrs/index.pl?Action=AgentTicketZoom;TicketID=' || CHA.CHA_COD_CHAMADO link, CHA.CHA_DSC_ASSUNTO assunto
				from CHA_CHAMADO CHA, IRE_ITEM_RELACIONAMENTO IRE 
				where ire.ire_cod_origem=cha.cha_cod_chamado
				and IRE.IRE_COD_DESTINO=$id;";
		
		$result = self::execute($sql);
		return $result;
		
	}
        
        public function backup ($txt) {
            $txt = strtoupper($txt);
            
            $sql = "SELECT ITC_DSC_NOME nome
				FROM itc_item_configuracao
				WHERE upper(itc_dsc_nome) LIKE '%".$txt."%';";
		
		$result = self::execute($sql);
		return $result;
            
        }
	
	
	
}
?>

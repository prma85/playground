<?php

/*
 * @author Robson Virino <robson.virino@cagece.com.br>
 * @category [Webservice]
 * Esta classe faz acesso ao banco de dados e gera um arquivo json
 * a partir do slim framework.
 */

require_once('../libs/oracle.php');

class dadosSEIMobile extends modelOracle {

    var $host = '172.25.131.77';
    var $user = 'SEI_APP';
    var $password = '531_@PP';
    var $sid = 'ORADW';
    var $port = '1521';
    var $socket = '';
	
	// Lista com todas as regiões [COD_REGIAO:DSC_REGIAO]
	public function regioes() {
        $list = array();
		$sql = "SELECT DISTINCT(cod_regiao),
				dsc_regiao
				FROM DADDWDES.DW_GEO_GEOGRAFIA_CONTABIL
				ORDER BY cod_regiao";
		$resultSQL = self::execute($sql);
		$dados = array();
		if ($resultSQL) {
			foreach ($resultSQL as $result){
				$dados = array("C"=>$result->COD_REGIAO, "D"=>$result->DSC_REGIAO);
				$list[] = $dados;
			}
		}
		return $list;
	}
	
	// SQL para trazer todas as regiões [COD_UN:DSC_UN]
	public function uns() {
        $list = array();
		$sql = "SELECT DISTINCT(geo.cod_und_negocio_sig) as cod_un,
				geo.dsc_und_negocio as dsc_un
				FROM DADDWDES.DW_GEO_GEOGRAFIA_CONTABIL geo
				ORDER BY geo.cod_und_negocio_sig;";
		$resultSQL = self::execute($sql);
		$dados = array();
		if ($resultSQL) {
			foreach ($resultSQL as $result){
				$dados = array("C"=>$result->COD_UN, "D"=>$result->DSC_UN);
				$list[] = $dados;
			}
		}
		return $list;
	}
	
	// SQL para trazer todas as unidades de negócios e suas respectivas regiões [COD_REGIAO:COD_UN]
	public function unsRegiao() {
        $list = array();
		$sql = "SELECT DISTINCT(geo.cod_regiao),
				geo.cod_und_negocio_sig as cod_un
				FROM DADDWDES.DW_GEO_GEOGRAFIA_CONTABIL geo
				ORDER BY geo.cod_regiao;";
		$resultSQL = self::execute($sql);
		$dados = array();
		if ($resultSQL) {
			foreach ($resultSQL as $result){
				$dados = array("U"=>$result->COD_UN, "R"=>$result->COD_REGIAO);
				$list[] = $dados;
			}
		}
		return $list;
	}
	// SQL para trazer todos os municípios [COD_UN:COD_MUNICIPIO]
	public function municipios() {
        $list = array();
		$sql = "SELECT DISTINCT(cod_municipio),
				dsc_municipio
				FROM DADDWDES.DW_GEO_GEOGRAFIA_CONTABIL
				ORDER BY cod_municipio ASC;";
		$resultSQL = self::execute($sql);
		$dados = array();
		if ($resultSQL) {
			foreach ($resultSQL as $result){
				$dados = array("C"=>$result->COD_MUNICIPIO, "D"=>$result->DSC_MUNICIPIO);
				$list[] = $dados;
			}
		}
		return $list;
	}
	
	// SQL para trazer todos os municípios por unidade de negócio [COD_UN:COD_MUNICIPIO]
	public function municipiosUn() {
        $list = array();
		$sql = "SELECT DISTINCT(cod_und_negocio_sig) as cod_un,
				cod_municipio
				FROM DADDWDES.DW_GEO_GEOGRAFIA_CONTABIL
				ORDER BY cod_und_negocio_sig ASC;";
		$resultSQL = self::execute($sql);
		$dados = array();
		if ($resultSQL) {
			foreach ($resultSQL as $result){
				$dados = array("U"=>$result->COD_UN, "M"=>$result->COD_MUNICIPIO);
				$list[] = $dados;
			}
		}
		return $list;
	}
	
	// SQL para trazer todas as localidades [COD_LOCALIDADE:DSC_LOCALIDADE]
	public function localidades() {
        $list = array();
		$sql = "SELECT DISTINCT(df.localidade) AS COD_LOCALIDADE,
				geo.dsc_localidade
				FROM DADDWDES.DW_SEIAPP_DADOS_FISICOS df
				JOIN DADDWDES.DW_GEO_GEOGRAFIA_CONTABIL geo
				ON geo.cod_localidade = df.localidade
				ORDER BY df.localidade ASC;";
		$resultSQL = self::execute($sql);
		$dados = array();
		if ($resultSQL) {
			foreach ($resultSQL as $result){
				$dados = array("C"=>$result->COD_LOCALIDADE, "D"=>$result->DSC_LOCALIDADE);
				$list[] = $dados;
			}
		}
		return $list;
	}
	
		// SQL para trazer todas as localidades por municipios [COD_LOCALIDADE:DSC_LOCALIDADE]
	public function localidadesMunicipios() {
        $list = array();
		$sql = "SELECT DISTINCT(cod_municipio),
				cod_localidade
				FROM DADDWDES.DW_GEO_GEOGRAFIA_CONTABIL
				ORDER BY cod_municipio, cod_localidade;";
		$resultSQL = self::execute($sql);
		$dados = array();
		if ($resultSQL) {
			foreach ($resultSQL as $result){
				$dados = array("M"=>$result->COD_MUNICIPIO, "L"=>$result->COD_LOCALIDADE);
				$list[] = $dados;
			}
		}
		return $list;
	}
	

			// SQL para trazer todos os dados físicos das localidades [COD_LOCALIDADE:DSC_LOCALIDADE]
	public function dadosfisicos() {
        $list = array();
			$sql = "
				SELECT localidade              AS l,
				  geo.cod_municipio            AS m,
				  geo.cod_und_negocio_sig      AS u,
				  geo.cod_regiao               AS r,
				  competencia                  AS c,
				  qtd_localidades_abastecidas  AS qla,
				  qtd_pop_coberta_agua         AS qpca,
				  qtd_lig_ativas_agua          AS qlaa,
				  qtd_lig_reais_agua           AS qlra,
				  qtd_lig_factiveis_agua       AS qlfa,
				  QTD_LIG_CORTADAS_AGUA        AS qlca,
				  QTD_LIG_SUPRIMIDAS_AGUA      AS qfsa,
				  qtd_lig_suspensas_agua       AS qlsa,
				  qtd_lig_fat_outro_imov_agua  AS qlfoia,
				  qtd_hidro_instalados         AS qhi,
				  vol_produzido                AS vp,
				  vol_produzido_comercializado AS vpc,
				  vol_faturado_agua            AS vfa,
				  vol_consumido                AS vc,
				  vol_distribuido              AS vd,
				  vlr_extensao_rede_agua       AS vera,
				  -- ESGOTO
				  qtd_localidades_atendidas     AS qlae,
				  qtd_pop_coberta_esgoto        AS qpce,
				  qtd_lig_ativas_esgoto         AS qlae_l,
				  qtd_lig_reais_esgoto          AS qlre,
				  qtd_lig_factiveis_esgoto      AS qlfe,
				  qtd_lig_suspensas_esgoto      AS qlse,
				  qtd_lig_sem_interlig_esgoto   AS qlsie,
				  qtd_lig_fat_outro_imov_esgoto AS qlfoie,
				  vol_faturado_esgoto           AS vfe,
				  vlr_extensao_rede_esgoto      AS vere,
				  qtd_lig_tamponadas_esgoto     AS qlte,
				  -- INDICADORES
				  vlr_indice_cobertura_agua      AS vica,
				  vlr_indice_cobertura_esgoto    AS vice,
				  vlr_ianf                       AS vianf,
				  vlr_indice_hidrometracao_ativo AS viha,
				  vlr_indice_hidrometracao_real  AS vihr,
				  vlr_iura                       AS viura,
				  vlr_iure                       AS viure,
				  vlr_ipd                        AS vipd,
				  vlr_tarifa_media_agua          AS vtma,
				  vlr_tarifa_media_esgoto        AS vtme,
				  vlr_tarifa_media_total         AS vtmt
				FROM DADDWDES.DW_SEIAPP_DADOS_FISICOS df
				JOIN
				  (SELECT DISTINCT GGC.COD_REGIAO,
					GGC.DSC_REGIAO,
					GGC.COD_MUNICIPIO,
					GGC.DSC_MUNICIPIO,
					GGC.COD_DISTRITO,
					GGC.DSC_DISTRITO,
					GGC.COD_LOCALIDADE,
					GGC.DSC_LOCALIDADE,
					--GGC.COD_MUNICIPIO_IBGE,
					--GGC.DSC_MUNICIPIO_IBGE,
					--GGC.COD_DISTRITO_IBGE,
					--GGC.DSC_DISTRITO_IBGE,
					--GGC.COD_LOCALIDADE_IBGE,
					--GGC.DSC_LOCALIDADE_IBGE,
					ggc.cod_und_negocio_sig
				  FROM DADDWDES.DW_GEO_GEOGRAFIA_CONTABIL GGC
				  UNION
				  SELECT NULL, NULL, NULL, NULL, NULL, NULL, -1, 'ESTADO', NULL FROM DUAL
				  ) GEO
				ON geo.cod_localidade = df.localidade
				GROUP BY localidade,
				  competencia,
				  geo.cod_municipio,
				  geo.cod_regiao,
				  geo.cod_und_negocio_sig,
				  qtd_localidades_abastecidas,
				  qtd_pop_coberta_agua,
				  qtd_lig_ativas_agua,
				  qtd_lig_reais_agua,
				  qtd_lig_factiveis_agua,
				  QTD_LIG_CORTADAS_AGUA,
				  QTD_LIG_SUPRIMIDAS_AGUA,
				  qtd_lig_suspensas_agua,
				  qtd_lig_fat_outro_imov_agua,
				  qtd_hidro_instalados,
				  vol_produzido,
				  vol_produzido_comercializado,
				  vol_faturado_agua,
				  vol_consumido,
				  vol_distribuido,
				  vlr_extensao_rede_agua,
				  -- ESGOTO
				  qtd_localidades_atendidas,
				  qtd_pop_coberta_esgoto,
				  qtd_lig_ativas_esgoto,
				  qtd_lig_reais_esgoto,
				  qtd_lig_factiveis_esgoto,
				  qtd_lig_suspensas_esgoto,
				  qtd_lig_sem_interlig_esgoto,
				  qtd_lig_fat_outro_imov_esgoto,
				  vol_faturado_esgoto,
				  vlr_extensao_rede_esgoto,
				  qtd_lig_tamponadas_esgoto,
				  -- INDICADORES
				  vlr_indice_cobertura_agua,
				  vlr_indice_cobertura_esgoto,
				  vlr_ianf,
				  vlr_indice_hidrometracao_ativo,
				  vlr_indice_hidrometracao_real,
				  vlr_iura,
				  vlr_iure,
				  vlr_ipd,
				  vlr_tarifa_media_agua,
				  vlr_tarifa_media_esgoto,
				  vlr_tarifa_media_total
				UNION
				--> REGIAO
				SELECT DISTINCT localidade     AS l,
				  NULL                         AS m,
				  NULL                         AS u,
				  geo.cod_regiao               AS r,
				  competencia                  AS c,
				  qtd_localidades_abastecidas  AS qla,
				  qtd_pop_coberta_agua         AS qpca,
				  qtd_lig_ativas_agua   AS qlaa,
				  qtd_lig_reais_agua           AS qlra,
				  qtd_lig_factiveis_agua       AS qlfa,
				  QTD_LIG_CORTADAS_AGUA        AS qlca,
				  QTD_LIG_SUPRIMIDAS_AGUA      AS qfsa,
				  qtd_lig_suspensas_agua       AS qlsa,
				  qtd_lig_fat_outro_imov_agua  AS qlfoia,
				  qtd_hidro_instalados         AS qhi,
				  vol_produzido                AS vp,
				  vol_produzido_comercializado AS vpc,
				  vol_faturado_agua            AS vfa,
				  vol_consumido                AS vc,
				  vol_distribuido              AS vd,
				  vlr_extensao_rede_agua       AS vera,
				  -- ESGOTO
				  qtd_localidades_atendidas     AS qlae,
				  qtd_pop_coberta_esgoto        AS qpce,
				  qtd_lig_ativas_esgoto  AS qlae_l,
				  qtd_lig_reais_esgoto          AS qlre,
				  qtd_lig_factiveis_esgoto      AS qlfe,
				  qtd_lig_suspensas_esgoto      AS qlse,
				  qtd_lig_sem_interlig_esgoto   AS qlsie,
				  qtd_lig_fat_outro_imov_esgoto AS qlfoie,
				  vol_faturado_esgoto           AS vfe,
				  vlr_extensao_rede_esgoto      AS vere,
				  qtd_lig_tamponadas_esgoto     AS qlte,
				  -- INDICADORES
				  vlr_indice_cobertura_agua      AS vica,
				  vlr_indice_cobertura_esgoto    AS vice,
				  vlr_ianf                       AS vianf,
				  vlr_indice_hidrometracao_ativo AS viha,
				  vlr_indice_hidrometracao_real  AS vihr,
				  vlr_iura                       AS viura,
				  vlr_iure                       AS viure,
				  vlr_ipd                        AS vipd,
				  vlr_tarifa_media_agua          AS vtma,
				  vlr_tarifa_media_esgoto        AS vtme,
				  vlr_tarifa_media_total         AS vtmt
				FROM DADDWDES.DW_SEIAPP_DADOS_FISICOS df
				JOIN
				  (SELECT DISTINCT GGC.COD_REGIAO,
					GGC.DSC_REGIAO
				  FROM DADDWDES.DW_GEO_GEOGRAFIA_CONTABIL GGC
				  ) GEO
				ON geo.cod_regiao = df.regiao
				GROUP BY localidade,
				  competencia,
				  --geo.cod_municipio,
				  geo.cod_regiao,
				  --geo.cod_und_negocio_sig,
				  qtd_localidades_abastecidas,
				  qtd_pop_coberta_agua,
				  qtd_lig_ativas_agua,
				  qtd_lig_reais_agua,
				  qtd_lig_factiveis_agua,
				  QTD_LIG_CORTADAS_AGUA,
				  QTD_LIG_SUPRIMIDAS_AGUA,
				  qtd_lig_suspensas_agua,
				  qtd_lig_fat_outro_imov_agua,
				  qtd_hidro_instalados,
				  vol_produzido,
				  vol_produzido_comercializado,
				  vol_faturado_agua,
				  vol_consumido,
				  vol_distribuido,
				  vlr_extensao_rede_agua,
				  -- ESGOTO
				  qtd_localidades_atendidas,
				  qtd_pop_coberta_esgoto,
				  qtd_lig_ativas_esgoto,
				  qtd_lig_reais_esgoto,
				  qtd_lig_factiveis_esgoto,
				  qtd_lig_suspensas_esgoto,
				  qtd_lig_sem_interlig_esgoto,
				  qtd_lig_fat_outro_imov_esgoto,
				  vol_faturado_esgoto,
				  vlr_extensao_rede_esgoto,
				  qtd_lig_tamponadas_esgoto,
				  -- INDICADORES
				  vlr_indice_cobertura_agua,
				  vlr_indice_cobertura_esgoto,
				  vlr_ianf,
				  vlr_indice_hidrometracao_ativo,
				  vlr_indice_hidrometracao_real,
				  vlr_iura,
				  vlr_iure,
				  vlr_ipd,
				  vlr_tarifa_media_agua,
				  vlr_tarifa_media_esgoto,
				  vlr_tarifa_media_total
				UNION
				--> UNIDADES
				SELECT localidade              AS l,
				  NULL                         AS m,
				  geo.cod_und_negocio_sig      AS u,
				  NULL                         AS r,
				  competencia                  AS c,
				  qtd_localidades_abastecidas  AS qla,
				  qtd_pop_coberta_agua         AS qpca,
				  qtd_lig_ativas_agua   AS qlaa,
				  qtd_lig_reais_agua           AS qlra,
				  qtd_lig_factiveis_agua       AS qlfa,
				  QTD_LIG_CORTADAS_AGUA        AS qlca,
				  QTD_LIG_SUPRIMIDAS_AGUA      AS qfsa,
				  qtd_lig_suspensas_agua       AS qlsa,
				  qtd_lig_fat_outro_imov_agua  AS qlfoia,
				  qtd_hidro_instalados         AS qhi,
				  vol_produzido                AS vp,
				  vol_produzido_comercializado AS vpc,
				  vol_faturado_agua            AS vfa,
				  vol_consumido                AS vc,
				  vol_distribuido              AS vd,
				  vlr_extensao_rede_agua       AS vera,
				  -- ESGOTO
				  qtd_localidades_atendidas     AS qlae,
				  qtd_pop_coberta_esgoto        AS qpce,
				  qtd_lig_ativas_esgoto  AS qlae_l,
				  qtd_lig_reais_esgoto          AS qlre,
				  qtd_lig_factiveis_esgoto      AS qlfe,
				  qtd_lig_suspensas_esgoto      AS qlse,
				  qtd_lig_sem_interlig_esgoto   AS qlsie,
				  qtd_lig_fat_outro_imov_esgoto AS qlfoie,
				  vol_faturado_esgoto           AS vfe,
				  vlr_extensao_rede_esgoto      AS vere,
				  qtd_lig_tamponadas_esgoto     AS qlte,
				  -- INDICADORES
				  vlr_indice_cobertura_agua      AS vica,
				  vlr_indice_cobertura_esgoto    AS vice,
				  vlr_ianf                       AS vianf,
				  vlr_indice_hidrometracao_ativo AS viha,
				  vlr_indice_hidrometracao_real  AS vihr,
				  vlr_iura                       AS viura,
				  vlr_iure                       AS viure,
				  vlr_ipd                        AS vipd,
				  vlr_tarifa_media_agua          AS vtma,
				  vlr_tarifa_media_esgoto        AS vtme,
				  vlr_tarifa_media_total         AS vtmt
				FROM DADDWDES.DW_SEIAPP_DADOS_FISICOS df
				JOIN
				  (SELECT DISTINCT ggc.cod_und_negocio_sig
				  FROM DADDWDES.DW_GEO_GEOGRAFIA_CONTABIL GGC
				  ) GEO
				ON geo.cod_und_negocio_sig = df.unidade
				GROUP BY localidade,
				  competencia,
				  --geo.cod_municipio,
				  --geo.cod_regiao,
				  geo.cod_und_negocio_sig,
				  qtd_localidades_abastecidas,
				  qtd_pop_coberta_agua,
				  qtd_lig_ativas_agua,
				  qtd_lig_reais_agua,
				  qtd_lig_factiveis_agua,
				  QTD_LIG_CORTADAS_AGUA,
				  QTD_LIG_SUPRIMIDAS_AGUA,
				  qtd_lig_suspensas_agua,
				  qtd_lig_fat_outro_imov_agua,
				  qtd_hidro_instalados,
				  vol_produzido,
				  vol_produzido_comercializado,
				  vol_faturado_agua,
				  vol_consumido,
				  vol_distribuido,
				  vlr_extensao_rede_agua,
				  -- ESGOTO
				  qtd_localidades_atendidas,
				  qtd_pop_coberta_esgoto,
				  qtd_lig_ativas_esgoto,
				  qtd_lig_reais_esgoto,
				  qtd_lig_factiveis_esgoto,
				  qtd_lig_suspensas_esgoto,
				  qtd_lig_sem_interlig_esgoto,
				  qtd_lig_fat_outro_imov_esgoto,
				  vol_faturado_esgoto,
				  vlr_extensao_rede_esgoto,
				  qtd_lig_tamponadas_esgoto,
				  -- INDICADORES
				  vlr_indice_cobertura_agua,
				  vlr_indice_cobertura_esgoto,
				  vlr_ianf,
				  vlr_indice_hidrometracao_ativo,
				  vlr_indice_hidrometracao_real,
				  vlr_iura,
				  vlr_iure,
				  vlr_ipd,
				  vlr_tarifa_media_agua,
				  vlr_tarifa_media_esgoto,
				  vlr_tarifa_media_total
				UNION
				--> MUNICIPIO
				SELECT localidade              AS l,
				  geo.cod_municipio            AS m,
				  NULL                         AS u,
				  NULL                         AS r,
				  competencia                  AS c,
				  qtd_localidades_abastecidas  AS qla,
				  qtd_pop_coberta_agua         AS qpca,
				  qtd_lig_ativas_agua   AS qlaa,
				  qtd_lig_reais_agua           AS qlra,
				  qtd_lig_factiveis_agua       AS qlfa,
				  QTD_LIG_CORTADAS_AGUA        AS qlca,
				  QTD_LIG_SUPRIMIDAS_AGUA      AS qfsa,
				  qtd_lig_suspensas_agua       AS qlsa,
				  qtd_lig_fat_outro_imov_agua  AS qlfoia,
				  qtd_hidro_instalados         AS qhi,
				  vol_produzido                AS vp,
				  vol_produzido_comercializado AS vpc,
				  vol_faturado_agua            AS vfa,
				  vol_consumido                AS vc,
				  vol_distribuido              AS vd,
				  vlr_extensao_rede_agua       AS vera,
				  -- ESGOTO
				  qtd_localidades_atendidas     AS qlae,
				  qtd_pop_coberta_esgoto        AS qpce,
				  qtd_lig_ativas_esgoto  AS qlae_l,
				  qtd_lig_reais_esgoto          AS qlre,
				  qtd_lig_factiveis_esgoto      AS qlfe,
				  qtd_lig_suspensas_esgoto      AS qlse,
				  qtd_lig_sem_interlig_esgoto   AS qlsie,
				  qtd_lig_fat_outro_imov_esgoto AS qlfoie,
				  vol_faturado_esgoto           AS vfe,
				  vlr_extensao_rede_esgoto      AS vere,
				  qtd_lig_tamponadas_esgoto     AS qlte,
				  -- INDICADORES
				  vlr_indice_cobertura_agua      AS vica,
				  vlr_indice_cobertura_esgoto    AS vice,
				  vlr_ianf                       AS vianf,
				  vlr_indice_hidrometracao_ativo AS viha,
				  vlr_indice_hidrometracao_real  AS vihr,
				  vlr_iura                       AS viura,
				  vlr_iure                       AS viure,
				  vlr_ipd                        AS vipd,
				  vlr_tarifa_media_agua          AS vtma,
				  vlr_tarifa_media_esgoto        AS vtme,
				  vlr_tarifa_media_total         AS vtmt
				FROM DADDWDES.DW_SEIAPP_DADOS_FISICOS df
				JOIN
				  (SELECT DISTINCT GGC.COD_MUNICIPIO,
					GGC.DSC_MUNICIPIO
				  FROM DADDWDES.DW_GEO_GEOGRAFIA_CONTABIL GGC
				  ) GEO
				ON geo.cod_municipio = df.municipio
				GROUP BY localidade,
				  competencia,
				  geo.cod_municipio,
				  --geo.cod_regiao,
				  --geo.cod_und_negocio_sig,
				  qtd_localidades_abastecidas,
				  qtd_pop_coberta_agua,
				  qtd_lig_ativas_agua,
				  qtd_lig_reais_agua,
				  qtd_lig_factiveis_agua,
				  QTD_LIG_CORTADAS_AGUA,
				  QTD_LIG_SUPRIMIDAS_AGUA,
				  qtd_lig_suspensas_agua,
				  qtd_lig_fat_outro_imov_agua,
				  qtd_hidro_instalados,
				  vol_produzido,
				  vol_produzido_comercializado,
				  vol_faturado_agua,
				  vol_consumido,
				  vol_distribuido,
				  vlr_extensao_rede_agua,
				  -- ESGOTO
				  qtd_localidades_atendidas,
				  qtd_pop_coberta_esgoto,
				  qtd_lig_ativas_esgoto,
				  qtd_lig_reais_esgoto,
				  qtd_lig_factiveis_esgoto,
				  qtd_lig_suspensas_esgoto,
				  qtd_lig_sem_interlig_esgoto,
				  qtd_lig_fat_outro_imov_esgoto,
				  vol_faturado_esgoto,
				  vlr_extensao_rede_esgoto,
				  qtd_lig_tamponadas_esgoto,
				  -- INDICADORES
				  vlr_indice_cobertura_agua,
				  vlr_indice_cobertura_esgoto,
				  vlr_ianf,
				  vlr_indice_hidrometracao_ativo,
				  vlr_indice_hidrometracao_real,
				  vlr_iura,
				  vlr_iure,
				  vlr_ipd,
				  vlr_tarifa_media_agua,
				  vlr_tarifa_media_esgoto,
				  vlr_tarifa_media_total
				ORDER BY l,
				  u,
				  m,
				  r,
				  c DESC;";
	
		$resultSQL = self::execute($sql);
		if ($resultSQL) {
			foreach ($resultSQL as $result){
				$localidade = $result->L;
				$municipio = $result->M;
				$un = $result->U;
				$regiao = $result->R;
				$competencia = $result->C;
				$ano = substr($competencia, 0, 4);
				$mes = substr($competencia, 4, 6);
				// AGUA
				$qtd_localidades_abastecidas = ($result->QLA);
				$qtd_pop_coberta_agua = ($result->QPCA);
				$qtd_lig_ativas_agua = ($result->QLAA);
				$qtd_lig_reais_agua = ($result->QLRA);
				$qtd_lig_factiveis_agua = ($result->QLFA);
				$qtd_lig_cortadas_agua = ($result->QLCA);
				$qtd_lig_suprimidas_agua = ($result->QFSA);
				$qtd_lig_suspensas_agua = ($result->QLSA);
				$qtd_lig_fat_outro_imov_agua = ($result->QLFOIA);
				$qtd_hidro_instalados = ($result->QHI);
				$vol_produzido = ($result->VP);
				$vol_produzido_comercializado = ($result->VPC);
				$vol_faturado_agua = ($result->VFA);
				$vol_consumido = ($result->VC);
				$vol_distribuido = ($result->VD);
				$vlr_extensao_rede_agua = ($result->VERA); 
				// ESGOTO
				$qtd_localidades_atendidas = ($result->QLAE);
				$qtd_pop_coberta_esgoto = ($result->QPCE);
				$qtd_lig_ativas_esgoto = ($result->QLAE_L);
				$qtd_lig_reais_esgoto = ($result->QLRE);
				$qtd_lig_factiveis_esgoto = ($result->QLFE);
				$qtd_lig_suspensas_esgoto = ($result->QLSE);
				$qtd_lig_sem_interlig_esgoto = ($result->QLSIE);
				$qtd_lig_fat_outro_imov_esgoto = ($result->QLFOIE);
				$vol_faturado_esgoto = ($result->VFE);
				$vlr_extensao_rede_esgoto = ($result->VERE);
				$qtd_lig_tamponadas_esgoto = ($result->QLTE);
				// INDICADORES
				$vlr_indice_cobertura_agua = ($result->VICA);
				$vlr_indice_cobertura_esgoto = ($result->VICE);
				$vlr_indice_agua_n_faturada = ($result->VIANF);
				$vlr_indice_hidrometracao_ativa = ($result->VIHA);
				$vlr_indice_hidrometracao_real = ($result->VIHR);
				$vlr_iura = ($result->VIURA);
				$vlr_iure = ($result->VIURE);
				$vlr_ipd = ($result->VIPD);
				$vlr_tarifa_media_agua = ($result->VTMA);
				$vlr_tarifa_media_esgoto = ($result->VTME);
				$vlr_tarifa_media_total = ($result->VTMT);
				
				$dados_fisicos = array("L" => $localidade, "M" => $municipio, "U" => $un, "R" => $regiao, "C" => $competencia, "ANO" => $ano, "MES" => $mes, "QLA" => $qtd_localidades_abastecidas, "QPCA" => $qtd_pop_coberta_agua, "QLAA" => $qtd_lig_ativas_agua, "QLFA" => $qtd_lig_factiveis_agua, "QLRA" => $qtd_lig_reais_agua, "QLCA" => $qtd_lig_cortadas_agua, "QFSA" => $qtd_lig_suprimidas_agua, "QLSA" => $qtd_lig_suspensas_agua, "QLFOIA" => $qtd_lig_fat_outro_imov_agua, "QHI" => $qtd_hidro_instalados, "VP" => $vol_produzido,"VPC" => $vol_produzido_comercializado, "VFA" => $vol_faturado_agua, "VC" => $vol_consumido, "VD" => $vol_distribuido, "VERA" => $vlr_extensao_rede_agua, "QLAE" => $qtd_localidades_atendidas, "QPCE" => $qtd_pop_coberta_esgoto,"QLAE_L" => $qtd_lig_ativas_esgoto, "QLRE" => $qtd_lig_reais_esgoto, "QLFE" => $qtd_lig_factiveis_esgoto, "QLSE" => $qtd_lig_suspensas_esgoto, "VFE" => $vol_faturado_esgoto, "VERE" => $vlr_extensao_rede_esgoto, "QLTE" => $qtd_lig_tamponadas_esgoto, "QLSIE" => $qtd_lig_sem_interlig_esgoto, "QLFOIE" => $qtd_lig_fat_outro_imov_esgoto, "VICA" => $vlr_indice_cobertura_agua, "VICE" => $vlr_indice_cobertura_esgoto, "VIANF" => $vlr_indice_agua_n_faturada, "VIHA" => $vlr_indice_hidrometracao_ativa, "VIHR" => $vlr_indice_hidrometracao_real, "VIURA" => $vlr_iura, "VIURE" => $vlr_iure, "VIPD" => $vlr_ipd, "VTMA" => $vlr_tarifa_media_agua, "VTME" => $vlr_tarifa_media_esgoto, "VTMT" => $vlr_tarifa_media_total);
				$list[] = $dados_fisicos;
			}
		}
		return $list;
	}

	// SQL para trazer todos os dados físicos das localidades [COD_LOCALIDADE:DSC_LOCALIDADE]
	public function indicadores() {
        $list = array();
			$sql = "SELECT 
				  localidade AS l,
				  geo.cod_municipio as m,
				  geo.cod_und_negocio_sig as u,
				  geo.cod_regiao as r,
				  competencia AS c,  
				  -- INDICADORES
				  vlr_indice_cobertura_agua AS vica,
				  vlr_indice_cobertura_esgoto AS vice,
				  vlr_ianf AS vianf,
				  vlr_indice_hidrometracao_ativo AS viha,
				  vlr_indice_hidrometracao_real AS vihr,
				  vlr_iura AS viura,
				  vlr_iure AS viure,
				  vlr_ipd AS vipd,
				  vlr_tarifa_media_agua AS vtma,
				  vlr_tarifa_media_esgoto AS vtme,
				  vlr_tarifa_media_total AS vtmt
				  
				FROM DADDWDES.DW_SEIAPP_DADOS_FISICOS df
				JOIN (SELECT DISTINCT
						GGC.COD_REGIAO,
						GGC.DSC_REGIAO,
						GGC.COD_MUNICIPIO,
						GGC.DSC_MUNICIPIO,
						GGC.COD_DISTRITO,
						GGC.DSC_DISTRITO,
						GGC.COD_LOCALIDADE,
						GGC.DSC_LOCALIDADE,
						--GGC.COD_MUNICIPIO_IBGE,
						--GGC.DSC_MUNICIPIO_IBGE,
						--GGC.COD_DISTRITO_IBGE,
						--GGC.DSC_DISTRITO_IBGE,
						--GGC.COD_LOCALIDADE_IBGE,
						--GGC.DSC_LOCALIDADE_IBGE,
						ggc.cod_und_negocio_sig
					  FROM
						DW_GEO_GEOGRAFIA_CONTABIL GGC
					  UNION
					  SELECT NULL,
							 NULL,
							 NULL,
							 NULL,
							 NULL,
							 NULL,
							 -1,
							 'ESTADO',
							 NULL
						FROM DUAL) GEO
						
				ON geo.cod_localidade = df.localidade
				GROUP BY localidade, competencia, geo.cod_municipio, geo.cod_regiao, geo.cod_und_negocio_sig, vlr_indice_cobertura_agua, vlr_indice_cobertura_esgoto, vlr_ianf, vlr_indice_hidrometracao_ativo,vlr_indice_hidrometracao_real, vlr_iura, vlr_iure, vlr_ipd, vlr_tarifa_media_agua, vlr_tarifa_media_esgoto, vlr_tarifa_media_total 
				ORDER BY l, u, m, r, competencia DESC;";
	
		$resultSQL = self::execute($sql);
		if ($resultSQL) {
			foreach ($resultSQL as $result){
				$localidade = $result->L;
				$municipio = $result->M;
				$un = $result->U;
				$valor = 1;
				if ($municipio == 1 || $localidade == 1){
					$valor = 4;
				}
				$regiao = $result->R;
				$competencia = $result->C;
				$ano = substr($competencia, 0, 4);
				$mes = substr($competencia, 4, 6);
				
				
				// INDICADORES
				$vlr_indice_cobertura_agua = (float)($result->VICA);
				$vlr_indice_cobertura_esgoto = (float)($result->VICE);
				$vlr_indice_agua_n_faturada = (float)($result->VIANF);
				$vlr_indice_hidrometracao_ativa = (float)($result->VIHA);
				$vlr_indice_hidrometracao_real = (float)($result->VIHR);
				$vlr_iura = (float)($result->VIURA);
				$vlr_iure = (float)($result->VIURE);
				$vlr_ipd = (float)($result->VIPD);
				$vlr_tarifa_media_agua = (float)($result->VTMA);
				$vlr_tarifa_media_esgoto = (float)($result->VTME);
				$vlr_tarifa_media_total = (float)($result->VTMT);
				
				$indicadores = array("L" => $localidade, "M" => $municipio, "U" => $un, "R" => $regiao, "C" => $competencia, "ANO" => $ano, "MES" => $mes, "VICA" => $vlr_indice_cobertura_agua, "VICE" => $vlr_indice_cobertura_esgoto, "VIANF" => $vlr_indice_agua_n_faturada, "VIHA" => $vlr_indice_hidrometracao_ativa, "VIHR" => $vlr_indice_hidrometracao_real, "VIURA" => $vlr_iura, "VIURE" => $vlr_iure, "VIPD" => $vlr_ipd, "VTMA" => $vlr_tarifa_media_agua, "VTME" => $vlr_tarifa_media_esgoto, "VTMT" => $vlr_tarifa_media_total );
				$list[] = $indicadores;
			}
		}
		return $list;
	}

		// SQL para trazer todas as localidades por municipios [COD_LOCALIDADE:DSC_LOCALIDADE]
	public function competencias() {
		$anoAtual = date('Y');
		
        $list = array();
		$sqlAnoAtual = "SELECT DISTINCT (competencia)
			FROM DADDWDES.DW_SEIAPP_DADOS_FISICOS df where competencia like '{$anoAtual}%'";
		$resultSQLAnoAtual = self::execute($sql);
		if(!$resultSQLAnoAtual){
			$anoAtual -= 1;
		}
		$anoAnterior = $anoAtual - 1;
		
		$sql = "SELECT DISTINCT (competencia)
			FROM DADDWDES.DW_SEIAPP_DADOS_FISICOS df where competencia like '{$anoAtual}%' or competencia like '{$anoAnterior}%';";
		$resultSQL = self::execute($sql);
		if ($resultSQL) {
			foreach ($resultSQL as $result){
				$competencia = $result->COMPETENCIA;
				$ano = substr($competencia, 0, 4);
				$mes = substr($competencia, 4, 6);
				$dscMes = self::getMes3dig($mes);
				$dados = array("C"=>$competencia, "A" => $ano, "M" => $mes, "D" => $dscMes.'/'.$ano);
				$list[] = $dados;
			}
		}
		return $list;
	}		
	
	public function ultimaAtualizacaoDadosFisicos() {
		$lasttime = "";
		$sql = "SELECT 
				  TO_CHAR(SCN_TO_TIMESTAMP(max(ORA_ROWSCN)), 'YYYY-MM-DD HH24:MI:SS') AS LASTTIME
				FROM DADDWDES.DW_SEIAPP_DADOS_FISICOS;";
		$resultSQL = self::execute($sql);
		if ($resultSQL) {
			foreach ($resultSQL as $result){
				$lasttime = $result->LASTTIME;
			}
		}
		
		return $lasttime;
	}

	// GERAR TODOS OS JSON's
	public function todos() {	
		// Atualizar versao
		$str_data = file_get_contents("version.json");
		$data = json_decode($str_data,true);
		$databaseDate = self::ultimaAtualizacaoDadosFisicos();
		$versaoJson = $data["V"];
		$dateJson = $data["D"];
		$list = array();
		if (strtotime($databaseDate) > strtotime($dateJson)){
	
			$result = self::regioes();
			$fp = fopen('regioes.json', 'w');
			fwrite($fp, json_encode($result));
			fclose($fp);
			
			$result = self::uns();
			$fp = fopen('uns.json', 'w');
			fwrite($fp, json_encode($result));
			fclose($fp);
			
			$result = self::unsRegiao();
			$fp = fopen('unsregiao.json', 'w');
			fwrite($fp, json_encode($result));
			fclose($fp);
			
			$result = self::municipios();
			$fp = fopen('municipios.json', 'w');
			fwrite($fp, json_encode($result));
			fclose($fp);
			
			$result = self::municipiosUn();
			$fp = fopen('municipiosun.json', 'w');
			fwrite($fp, json_encode($result));
			fclose($fp);
			
			$result = self::localidades();
			$fp = fopen('localidades.json', 'w');
			fwrite($fp, json_encode($result));
			fclose($fp);
			
			$result = self::localidadesMunicipios();
			$fp = fopen('localidadesmunicipio.json', 'w');
			fwrite($fp, json_encode($result));
			fclose($fp);
			
			$result = self::dadosfisicos();
			$fp = fopen('dadosfisicos.json', 'w');
			fwrite($fp, json_encode($result));
			fclose($fp);

			$result = self::indicadores();
			$fp = fopen('indicadores.json', 'w');
			fwrite($fp, json_encode($result));
			fclose($fp);
			
			$result = self::competencias();
			$fp = fopen('competencias.json', 'w');
			fwrite($fp, json_encode($result));
			fclose($fp);
			$list["V"] = $versaoJson + 0.1;
			$list["D"] = self::ultimaAtualizacaoDadosFisicos();
		}
	return $list;
	}

	
}

?>


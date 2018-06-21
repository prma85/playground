-- VERIFICA A SITUAÇÃO DA LIGAÇÃO DO IMOVEL
SELECT 
   HEL.HEL_SEQ_LIGACAO,
   lig.lig_seq_ligacao,
   lig.imo_cod_inscricao IMOVEL, CASE WHEN lig.tir_seq_tip_rede=1 THEN 'AGUA' ELSE 'ESGOTO' END AS REDE,  
  CASE WHEN lig.lig_cod_est_ligacao=1 THEN 'NORMAL' ELSE CASE WHEN lig.lig_cod_est_ligacao=2 THEN 'CORTADA' ELSE 'SUPRIMIDA' END  END AS SITUACAO,
  lig.lig_dat_exe_ligacao, hel.hel_DAT_est_ligacao, TRUNC(hel.hel_DAT_est_ligacao-CURRENT_DATE)||' DIAS',
   CASE WHEN hel.hel_cod_est_ligacao=1 THEN 'NORMAL' ELSE CASE WHEN  hel.hel_cod_est_ligacao=2 THEN 'CORTADA' ELSE 'SUPRIMIDA' END  END AS SITUACAO_HISTORICO
  
FROM hel_historico_estado_ligacao HEL
LEFT JOIN  lig_ligacao lig ON hel.lig_seq_ligacao=lig.lig_seq_ligacao
WHERE lig.imo_cod_inscricao in (7748400)
ORDER BY HEL_DAT_EST_LIGACAO DESC ;


SELECT * FROM lic_lista_campanha WHERE con_seq_contrato =7748400;

DELETE FROM lic_lista_campanha WHERE con_seq_contrato in (SELECT con_seq_contrato FROM con_contrato WHERE imo_cod_inscricao=7748400);


-- DELETE FROM hel_historico_estado_ligacao WHERE hel_seq_ligacao=5812704;

-- update hel_historico_estado_ligacao set hel_dat_est_ligacao='08/12/2013' WHERE hel_seq_ligacao=5812704;
update hel_historico_estado_ligacao set hel_cod_est_ligacao=2 WHERE hel_seq_ligacao=4788628;
update hel_historico_estado_ligacao set hel_cod_est_ligacao=3 WHERE hel_seq_ligacao=5167543;

UPDATE lig_ligacao SET lig_cod_est_ligacao=3, lig_dat_estado_ligacao='08/12/2013' WHERE lig_seq_ligacao=77484001;
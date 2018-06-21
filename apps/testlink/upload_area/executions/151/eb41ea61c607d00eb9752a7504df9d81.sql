select imo_cod_inscricao, count(*) from lig_ligacao
INNER JOIN hel_historico_estado_ligacao hel on hel.lig_seq_ligacao = lig_ligacao.lig_seq_ligacao
where lig_ligacao.tir_seq_tip_rede=1 and lig_ligacao.lig_cod_est_ligacao =3
group by imo_cod_inscricao 
having count(*)=3;

select * from hel_historico_estado_ligacao where lig_seq_ligacao = (select lig_seq_ligacao from lig_ligacao where lig_ligacao.imo_cod_inscricao = 35073870);

delete from lic_lista_campanha where con_seq_contrato=35073870;
update hel_historico_estado_ligacao set hel_dat_est_ligacao=to_date('23/06/2013', 'dd/mm/yyyy')  where hel_seq_ligacao=2647935;
update hel_historico_estado_ligacao set hel_dat_est_ligacao=to_date('23/09/2013', 'dd/mm/yyyy')  where hel_seq_ligacao=1273551;
commit;

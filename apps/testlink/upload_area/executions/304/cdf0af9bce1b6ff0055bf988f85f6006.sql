  
  
  	SELECT * FROM avg_aviso_agente  where avg_dsc_nome_arquivo='R34102631.DCO' AND avg_num_competencia=201202;
    
    update avg_aviso_agente set 	
          avg_vlr_calculado = 0,
					avg_vlr_pagamento_gerado = 0, 
					avg_qtd_pagamento_gerado = 0,
					avg_vlr_baixado = 0, 
					avg_qtd_pagamento_baixado = 0,
					avg_vlr_com_erro = 0, 
					avg_qtd_pagamento_com_erro = 0
          
          where avg_dsc_nome_arquivo='R34102631.DCO' AND avg_num_competencia=201202;

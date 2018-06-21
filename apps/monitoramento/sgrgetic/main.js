var banco;
var options = {
	width: 200, height: 120,
	redFrom: 0, redTo: 79,
	yellowFrom:80, yellowTo: 99,
	greenFrom: 100, greenTo: 120,
	min: 0, max: 120,
	minorTicks: 3
};

function carregaBanco(data) {
	banco = data;
	geraGraficos();
}

function geraGraficos(){
	var graficos = '';
	var id = 1;
	$.each(banco, function (j, ind) {
		var div = '#container_graf'+id;
		var nome = ind.IND_NOM_INDICADOR;
		var dados = '';
		var previsto, realizado, mes, label, atingido;
		var meterId = 'meter_'+j;
		var ano = ind.ANO;
		if (ano == "2010" && ind.IND_COD_INDICADOR == "9282") ind.IND_TIP_PERIODICIDADE = 'T';
		if (ind.IND_TIP_PERIODICIDADE == 'M') {
			var classe = 'mensal';
			if (typeof ind.DETALHES.DADOS[ano+'01'] != "undefined") {
				dados = dados.concat('<div class="mes jan"><div style="height: '+ind.DETALHES.DADOS[ano+'01'].PREVISTO+'%;" class="prev"></div><div style="height: '+ind.DETALHES.DADOS[ano+'01'].REALIZADO+'%;" class="real"></div></div>');
			} else {
					dados = dados.concat('<div class="mes jan"><div style="height: 1%;" class="prev"></div><div style="height: 1%;" class="real"></div></div>');
			}
			
			if (typeof ind.DETALHES.DADOS[ano+'02'] != "undefined") {
				dados = dados.concat('<div class="mes fev"><div style="height: '+ind.DETALHES.DADOS[ano+'02'].PREVISTO+'%;" class="prev"></div><div style="height: '+ind.DETALHES.DADOS[ano+'02'].REALIZADO+'%;" class="real"></div></div>');
			} else {
					dados = dados.concat('<div class="mes fev"><div style="height: 1%;" class="prev"></div><div style="height: 1%;" class="real"></div></div>');
			}
			
			if (typeof ind.DETALHES.DADOS[ano+'03'] != "undefined") {
				dados = dados.concat('<div class="mes mar"><div style="height: '+ind.DETALHES.DADOS[ano+'03'].PREVISTO+'%;" class="prev"></div><div style="height: '+ind.DETALHES.DADOS[ano+'03'].REALIZADO+'%;" class="real"></div></div>');
			} else {
					dados = dados.concat('<div class="mes mar"><div style="height: 1%;" class="prev"></div><div style="height: 1%;" class="real"></div></div>');
			}
			
			if (typeof ind.DETALHES.DADOS[ano+'04'] != "undefined") {
				dados = dados.concat('<div class="mes abr"><div style="height: '+ind.DETALHES.DADOS[ano+'04'].PREVISTO+'%;" class="prev"></div><div style="height: '+ind.DETALHES.DADOS[ano+'04'].REALIZADO+'%;" class="real"></div></div>');
			} else {
					dados = dados.concat('<div class="mes abr"><div style="height: 1%;" class="prev"></div><div style="height: 1%;" class="real"></div></div>');
			}
			
			if (typeof ind.DETALHES.DADOS[ano+'05'] != "undefined") {
				dados = dados.concat('<div class="mes mai"><div style="height: '+ind.DETALHES.DADOS[ano+'05'].PREVISTO+'%;" class="prev"></div><div style="height: '+ind.DETALHES.DADOS[ano+'05'].REALIZADO+'%;" class="real"></div></div>');
			} else {
					dados = dados.concat('<div class="mes mai"><div style="height: 1%;" class="prev"></div><div style="height: 1%;" class="real"></div></div>');
			}
			
			if (typeof ind.DETALHES.DADOS[ano+'06'] != "undefined") {
				dados = dados.concat('<div class="mes jun"><div style="height: '+ind.DETALHES.DADOS[ano+'06'].PREVISTO+'%;" class="prev"></div><div style="height: '+ind.DETALHES.DADOS[ano+'06'].REALIZADO+'%;" class="real"></div></div>');
			} else {
					dados = dados.concat('<div class="mes jun"><div style="height: 1%;" class="prev"></div><div style="height: 1%;" class="real"></div></div>');
			}
			
			if (typeof ind.DETALHES.DADOS[ano+'07'] != "undefined") {
				dados = dados.concat('<div class="mes jul"><div style="height: '+ind.DETALHES.DADOS[ano+'07'].PREVISTO+'%;" class="prev"></div><div style="height: '+ind.DETALHES.DADOS[ano+'07'].REALIZADO+'%;" class="real"></div></div>');
			} else {
					dados = dados.concat('<div class="mes jul"><div style="height: 1%;" class="prev"></div><div style="height: 1%;" class="real"></div></div>');
			}
			
			if (typeof ind.DETALHES.DADOS[ano+'08'] != "undefined") {
				dados = dados.concat('<div class="mes ago"><div style="height: '+ind.DETALHES.DADOS[ano+'08'].PREVISTO+'%;" class="prev"></div><div style="height: '+ind.DETALHES.DADOS[ano+'08'].REALIZADO+'%;" class="real"></div></div>');
			} else {
					dados = dados.concat('<div class="mes ago"><div style="height: 1%;" class="prev"></div><div style="height: 1%;" class="real"></div></div>');
			}
			
			if (typeof ind.DETALHES.DADOS[ano+'09'] != "undefined") {
				dados = dados.concat('<div class="mes set"><div style="height: '+ind.DETALHES.DADOS[ano+'09'].PREVISTO+'%;" class="prev"></div><div style="height: '+ind.DETALHES.DADOS[ano+'09'].REALIZADO+'%;" class="real"></div></div>');
			} else {
					dados = dados.concat('<div class="mes set"><div style="height: 1%;" class="prev"></div><div style="height: 1%;" class="real"></div></div>');
			}
			if (typeof ind.DETALHES.DADOS[ano+'10'] != "undefined") {
				dados = dados.concat('<div class="mes out"><div style="height: '+ind.DETALHES.DADOS[ano+'10'].PREVISTO+'%;" class="prev"></div><div style="height: '+ind.DETALHES.DADOS[ano+'10'].REALIZADO+'%;" class="real"></div></div>');
			} else {
					dados = dados.concat('<div class="mes out"><div style="height: 1%;" class="prev"></div><div style="height: 1%;" class="real"></div></div>');
			}
			if (typeof ind.DETALHES.DADOS[ano+'11'] != "undefined") {
				dados = dados.concat('<div class="mes nov"><div style="height: '+ind.DETALHES.DADOS[ano+'11'].PREVISTO+'%;" class="prev"></div><div style="height: '+ind.DETALHES.DADOS[ano+'11'].REALIZADO+'%;" class="real"></div></div>');
			} else {
					dados = dados.concat('<div class="mes nov"><div style="height: 1%;" class="prev"></div><div style="height: 1%;" class="real"></div></div>');
			}
			if (typeof ind.DETALHES.DADOS[ano+'12'] != "undefined") {
				dados = dados.concat('<div class="mes dez"><div style="height: '+ind.DETALHES.DADOS[ano+'12'].PREVISTO+'%;" class="prev"></div><div style="height: '+ind.DETALHES.DADOS[ano+'12'].REALIZADO+'%;" class="real"></div></div>');
			} else {
					dados = dados.concat('<div class="mes dez"><div style="height: 1%;" class="prev"></div><div style="height: 1%;" class="real"></div></div>');
			}
			
		} else if (ind.IND_TIP_PERIODICIDADE == 'T') {
			var classe = 'trimestral';
			dados = dados.concat('<div class="mes mar"><div style="height: '+ind.DETALHES.DADOS[ano+'03'].PREVISTO+'%;" class="prev"></div><div style="height: '+ind.DETALHES.DADOS[ano+'03'].REALIZADO+'%;" class="real"></div></div>');
			dados = dados.concat('<div class="mes jun"><div style="height: '+ind.DETALHES.DADOS[ano+'06'].PREVISTO+'%;" class="prev"></div><div style="height: '+ind.DETALHES.DADOS[ano+'06'].REALIZADO+'%;" class="real"></div></div>');
			dados = dados.concat('<div class="mes set"><div style="height: '+ind.DETALHES.DADOS[ano+'09'].PREVISTO+'%;" class="prev"></div><div style="height: '+ind.DETALHES.DADOS[ano+'09'].REALIZADO+'%;" class="real"></div></div>');
			dados = dados.concat('<div class="mes dez"><div style="height: '+ind.DETALHES.DADOS[ano+'12'].PREVISTO+'%;" class="prev"></div><div style="height: '+ind.DETALHES.DADOS[ano+'12'].REALIZADO+'%;" class="real"></div></div>');
		}
		
		switch (nome) {
			case 'INDICE DE INFORMATIZACAO ': 						label = 'Informat.';	break;
			case '% SERVICOS DE SUPORTE EXECUTADOS NO PRAZO': 		label = 'Suporte'; 		break;
			case 'ÍNDICE DE SEGURANÇA DOS SISTEMAS DE TI': 			label = 'Segurança'; 	break;
			case '% DE SERVIÇOS DE SISTEMAS ENTREGUES NO PRAZO': 	label = 'Sistemas'; 	break;
		}
		
		$.each(ind.DETALHES.DADOS, function (i, dados) {
			if (dados.REALIZADO != '0') {
				mes = dados.MES;
				previsto = dados.PREVISTO;
				realizado = dados.REALIZADO;
				atingido = dados.ATINGIDO;
			} else {
				return;
			}
		});
		
		var info = '<h2><strong>'+nome+'</strong></h2>';
		//info = info.concat('<p><strong>Descrição:</strong> '+ind.IND_DSC_INDICADOR+'</p>');
		
		var meter = '<p><b>Previsto: </b><br />'+previsto+'%</p><p><b>Realizado: </b><br />'+realizado+'%</p><p><b>Atingido: </b><br />'+atingido+'%</p>';
		
		$(div + ' .info').append(info);
		$(div + ' .graf').addClass(classe);
		$(div + ' .graf .dados').append(dados);
		$(div + ' .meter').append('<h3>Realizado em '+mes+'</h3><div class="gauge" id="'+meterId+'"></div><div class="dados_meter">'+meter+'</div>');

		id = id + 1;
	});
	
	geraMeter();
}

function geraMeter() {
	$.each(banco, function (j, ind) {
		var atingido = '';
		var meterId = 'meter_'+j;
		
		$.each(ind.DETALHES.DADOS, function (i, dados) {
			if (dados.REALIZADO != '0') {
				atingido = dados.ATINGIDO;
			} else {
				return;
			}
		});
		
		var data = google.visualization.arrayToDataTable([
		  ['Label', 'Value'],
		  ['%', parseInt(atingido)]
		]);
		  
		// Create and draw the visualization.
		new google.visualization.Gauge(document.getElementById(meterId)).
		draw(data,options);
	});
}

function retornaMes(anomes){
	var mes = anomes.substring(4);
	switch (mes) {
		case "01":    mes = 'Janeiro';     break;
		case "02":    mes = 'Fevereiro';   break;
		case "03":    mes = 'Março';       break;
		case "04":    mes = 'Abril';       break;
		case "05":    mes = 'Maio';        break;
		case "06":    mes = 'Junho';       break;
		case "07":    mes = 'Julho';       break;
		case "08":    mes = 'Agosto';      break;
		case "09":    mes = 'Setembro';    break;
		case "10":    mes = 'Outubro';     break;
		case "11":    mes = 'Novembro';    break;
		case "12":    mes = 'Dezembro';    break;
	}
	return mes;
}

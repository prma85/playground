$("#main").hide();
var banco, data = new Date(), ano = data.getFullYear();

$.getJSON("http://" + window.location.host + "/apps/sgr/api/todos_indicadores.json", function (data) {
    banco = data;
});
/*
 $.getJSON("todos_indicadores.json", function (data) {
 banco = data;
 });
 */
function abirIndicador(id) {
    var classes = 'col-lg-12 col-sm-12', w1 = '40%', w2 = '60%';

    if ($(window).width() >= 1200) {
        classes = 'col-lg-6 col-sm-6';
        w1 = '60%';
        w2 = '40%';
    }
    var content = geraPaginaDados(id);
    //console.log(content);
    if ($("#indicadores .box-indicador").hasClass(classes) == false) {
        $("#box-conteudo").html(content);

        $("#indicadores .box-indicador").removeClass("col-lg-3 col-sm-6").addClass(classes);

        //animacao
        $("#indicadores").animate({
            width: w1
        }, 400, "linear", function () {
            $("#main").css("width", w2);
            $("#main").show(300);
        });
    } else {
        $("#main").hide(300, function () {
            $("#box-conteudo").html(content);
            $("#main").show(300);
        });

    }
    $("#sgr").css("min-width", "600px");
}

function fechar() {
    var classes = 'col-lg-12 col-sm-12';

    if ($(document).width() >= 1200) {
        classes = 'col-lg-6 col-sm-6';
    }

    //animacao
    $("#main").css("width", "0px");
    $("#main").hide(300, function () {
        $("#main .box-conteudo").html("");
    });

    $("#indicadores").animate({
        width: "100%"
    }, 400, "linear", function () {
        $("#indicadores .box-indicador").removeClass(classes).addClass("col-lg-3 col-sm-6");
    });

    $("#sgr").css("min-width", "355px");
}

function mudaAnoIndicador(id, ano) {

}

function abrePlanoAcao(id, mesano) {

}

function geraPaginaDados(id) {
    waitingDialog.show();
    var div = "";
    $.ajax({
        url: "http://" + window.location.host + "/apps/sgr/api/indicador/" + id,
        type: 'GET',
        async: false,
        cache: false,
        timeout: 30000,
        error: function (err) {
            console.log(err);
            alert("Ocorreu um erro no serivodr, tente novamente mais tarde");
        },
        success: function (data) {
            var ind = banco[id];
            //console.log(data);
            div = geraIndicadorHtml(data, ind, true);
            setTimeout(function() { waitingDialog.hide(); }, 1000);
            return div;
        }
    });

    return div;

}

function geraPaginaDadosOld(id) {
    var ind = banco[id];
    var dadosTemp = ind.DETALHES[ano].DADOS;

    //odernar dados de forma reversa
    var keys = [], dados = [], k, i, len;
    for (k in dadosTemp) {
        if (dadosTemp.hasOwnProperty(k)) {
            keys.push(k);
        }
    }
    keys.reverse();
    len = keys.length;
    for (i = 0; i < len; i++) {
        dados[i] = dadosTemp[keys[i]];
    }

    return geraIndicadorHtml(dados, ind);

}

function geraIndicadorHtml(dados, ind, a) {
    var head = '<div class="info"><h3>Informações</h3><span><b>Indicador: </b>' + ind.IND_NOM_INDICADOR + '<span></span><b>Objetivo Estratégico: </b>' + ind.OBJ_DSC_OBJETIVO + '</span><span><b>Periodicidade: </b>' + ind.IND_TIP_PERIODICIDADE + ' / <b>Competência: </b>' + ano + '</div>';

    var div = head + '<div class="info tabela"><table class="dados" width="96%" style="margin: 2%;"><thead><tr><th>Mês</th><th align="center" class="previsto">Previsto</th><th align="center" class="realizado">Realizado</th><th></tr></thead><tbody>';
    $.each(dados, function (i, d) {
        var mes = d.MES;
        if (a) {
            mes = d.ANO + ' - ' + d.MES;
        }

        //verifica se o indicador vai ser mensal, bimestral, trimestral, semestral ou anual
        if (typeof (d.PREVISTO) !== 'undefined') {
            var medida = d.MEDIDA;
            var medida2 = medida;
            if (d.PREVISTO != '0') {
                div = div.concat('<tr>');
                if (d.REALIZADO != '' && d.REALIZADO != ' ') {
                    div = div.concat('<td><a href="javascript:geraPaginaCausasMes(' + ind.IND_COD_INDICADOR + ',\'' + d.ANOMES + '\');">' + mes + '</a></td>');
                } else {
                    div = div.concat('<td>' + mes + '</td>');
                }

                if (typeof (d.STATUS) !== 'undefined') {
                    var img = d.STATUS + '.png';
                } else {
                    var img = '';
                }

                if (d.REALIZADO === ' ')
                    medida2 = '';

                if (medida == 'R$') {
                    div = div.concat('<td align="center">R$ ' + d.PREVISTO + '</td>');
                    div = div.concat('<td align="center">' + medida2 + ' ' + d.REALIZADO + '</td>');
                } else if (medida == '%') {
                    div = div.concat('<td align="center">' + fPercent(d.PREVISTO) + '</td>');
                    div = div.concat('<td align="center">' + fPercent(d.REALIZADO) + '</td>');
                } else {
                    div = div.concat('<td align="center">' + d.PREVISTO + ' ' + medida + '</td>');
                    div = div.concat('<td align="center">' + d.REALIZADO + ' ' + medida2 + '</td>');
                }

                /* if (img == 'bPreta.png') {
                 div = div.concat('<td align="center"></td>');
                 } else {
                 div = div.concat('<td align="center"><img src="img/' + img + '" /></td>');
                 }*/
                div = div.concat('<td align="center"><img src="img/menor/' + img + '" /></td>');
                div = div.concat('</tr>');
            }
        }
    });

    div = div.concat('</tbody></table></div>');


    return div;
}

function geraPaginaCausasMes(id, anomes) {
    var ano = anomes.substring(0, 4);
    var causas = banco[id].DETALHES[ano].CAUSAS[anomes];
    var plano = banco[id].DETALHES[ano].PLANO;

    if (typeof (causas) !== 'undefined') {
        //var head = '<div class="title"><h3>'+nome+' - '+detalhes[anoCausas].CAUSAS[mesCausas].MES+'/'+anoCausas+'</h3></div>';
        var div = '<div class="info">';
        div = div.concat('<b>Data da Reunião: </b>' + causas.DATAREU + '<br/><br/>');
        div = div.concat('<b>Data de Referência: </b>' + causas.DATA + '<br/><br/>');
        div = div.concat('<b>Fatos: </b>' + causas.FATOS + '<br/><br/>');
        div = div.concat('<b>Causas: </b>' + causas.CAUSAS + '<br/><br/>');
        div = div.concat('<b>Ações: </b>' + causas.ACOES + '<br/><br/>');
        div = div.concat('</div>');
        $('#myModal .modal-body').html(div);
        $('#myModal').modal('show');
    } else {
        return alert('Ainda não foram cadastrados dados no SGR para esse mês');
    }
}

function fPercent(v) {
    //console.log(typeof v);
    if (!checkEmpty(v.trim())) {
        v = parseFloat(v).toFixed(2);
        v = v + '%';
    }
    return v;
}

function checkEmpty(e) {
    if (e == null || e == 'null' || e == '' || typeof e == 'object') {
        return true;
    } else {
        return false;
    }
}


function pausecomp(millis){
  var date = new Date();
  var curDate = null;
  do { curDate = new Date(); }
  while(curDate-date < millis);
}
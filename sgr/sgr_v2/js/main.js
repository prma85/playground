var banco, id, anomes, unCagece, arrayLocalidades = [], data = new Date(), ano = data.getFullYear();
var unidades = ['UNMTN', 'UNMTS', 'UNMTO', 'UNMTL', 'UNBSI', 'UNBCL', 'UNBAJ', 'UNBBJ', 'UNBPA', 'UNBBA', 'UNBSA', 'UNBAC', 'UNBME'];
var cores = {"sVermelhaAbaixo": "vermelho", "sVermelhaAcima": "vermelho", "sVerdeAbaixo": "verde", "sVerdeAcima": "verde", "sAmarelaAbaixo": "amarelo", "sAmarelaAcima": "amarelo", "qVermelho": "vermelho", "qVerde": "verde", "qAmarelo": "amarelo", "bPreta": "disabled"};
//$.getJSON("http://" + window.location.host + "/apps/sgr/api/todos_indicadores.json", function (data) {
//$.getJSON("http://" + window.location.host + "/apps/monitoramento/sgr/todos_indicadores.json", function (data) {  
$.getJSON("http://" + window.location.host + "/sgr/webservice_sgr/todos_indicadores.json", function (data) {
    banco = data;
});
/*setInterval(function () {
 var div = $('.active')[0];
 if (div.id == 'indicadores') {
 mudaPaginaIndicador();
 }
 }, 120 * 1000);*/
var gauge = new Gauge({
    renderTo: 'estado-gauge',
    width: 380,
    height: $("#mapa_rmetropolitana").innerHeight() - 10,
    glow: true,
    units: '%',
    title: 'Reached',
    minValue: 0,
    maxValue: 120,
    majorTicks: ['0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100', '110', '120'],
    minorTicks: 2,
    strokeTicks: false,
    highlights: [
        {from: 0, to: 80, color: 'rgba(255, 30,  0, .55)'},
        {from: 80, to: 100, color: 'rgba(255, 255, 0, .55)'},
        {from: 100, to: 120, color: 'rgba(0,   255, 0, .55)'}
    ],
    animation: {
        duration: '200',
        delay: '10'
    },
    colors: {
        plate: '#fff',
        majorTicks: '#222',
        minorTicks: '#333',
        title: '#000',
        units: '#222',
        numbers: '#222',
        needle: {start: 'rgba(20, 20, 20, 1)', end: 'rgba(0, 0, 0, .9)'}
    }
});
var gaugeUnidade = new Gauge({
    renderTo: 'unidade-gauge',
    width: 574,
    height: 329,
    glow: true,
    units: '%',
    title: 'Atingido',
    minValue: 0,
    maxValue: 120,
    majorTicks: ['0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100', '110', '120'],
    minorTicks: 2,
    strokeTicks: false,
    highlights: [
        {from: 0, to: 80, color: 'rgba(255, 30,  0, .55)'},
        {from: 80, to: 100, color: 'rgba(255, 255, 0, .55)'},
        {from: 100, to: 120, color: 'rgba(0,   255, 0, .55)'}
    ],
    animation: {
        duration: '200',
        delay: '10'
    },
    colors: {
        plate: '#fff',
        majorTicks: '#222',
        minorTicks: '#333',
        title: '#000',
        units: '#222',
        numbers: '#222',
        needle: {start: 'rgba(20, 20, 20, 1)', end: 'rgba(0, 0, 0, .9)'}
    }
});

if ($(window).width() > 767) {
    $("#mapa_estado").height($(window).height() - 250);
    $("#unidade-fca").css('min-height', $(window).height() - 210);

    $("#unidade-grafico").height($(window).height() - 602);
    $("#estado-grafico").height($(window).height() - 602);
}
window.onresize = function () {
    $("#unidade-grafico").height($(window).height() - 602);
    $("#estado-grafico").height($(window).height() - 602);
};
//refazer para ser dinâmico
function voltarHome() {
    $('.active').removeClass("active").effect("drop", "slow");
    $('#indicadores').addClass("active").effect("slide", "slow");
    $('.nav').show();
}

function voltarIndicador() {
    $('.active').removeClass("active").effect("drop", "slow");
    $('#indicador').addClass("active").effect("slide", "slow");
}

function abrirIndicador(ind, ano) {
    $('.nav').hide();
    id = ind;
    anomes = 0;
    $('#indicadores').removeClass("active").effect("drop", "slow");
    var content = geraPaginaDados(id);
    if (content) {
        $('#indicador').addClass("active").effect("slide", "slow");
        gauge.updateConfig({
            width: (($("#estado-fortaleza").innerWidth() / 3) * 2) - 30,
        });
    } else {
        $('#indicadores').addClass("active").effect("slide", "slow");
    }
}

function geraPaginaDados(idIndicador) {
    id = idIndicador;
    //console.log(id);
    var grafico = {}, gPrevisto = [], gRealizado = [];
    //console.log(atual[id]);
    if (atual[id]) {
        var indicador = atual[id];
        //console.log(atual);
        anomes = indicador.ANOMES;
        $('.titulo-indicador').html(indicador.NOME_INDICADOR);
        $('#estado-dados .meta span').html(indicador.PREVISTO);
        $('#estado-dados .realizado span').html(indicador.REALIZADO);
        gauge.setValue(indicador.ATINGIDO);
        gauge.draw();

        window.onresize = function () {
            gauge.updateConfig({
                width: (($("#estado-fortaleza").innerWidth() / 3) * 2) - 30,
                height: $("#mapa_rmetropolitana").innerHeight() - 10
            });
            //$("#estado-gauge").width((($("#mapa_rmetropolitana").innerWidth() / 3) * 2) - 30);
            //$("#estado-dados").css('min-height',$("#estado-fortaleza").innerHeight());
            $("#mapa_estado").height(0);
            $("#mapa_estado").height($(window).height() - 250);
        };

        unidades.forEach(function (u) {
            var svgElement = document.getElementById('mapa' + u);
            var areaUnidade = document.getElementById('area' + u);
            areaUnidade.setAttribute("onclick", "semDados('" + u + "')");
            svgElement.setAttribute("class", "disabled");
        });
        $.each(indicador.MAPA, function (u, d) {
            var svgElement = document.getElementById('mapa' + u);
            var areaUnidade = document.getElementById('area' + u);
            if (areaUnidade) {
                if (cores[d.STATUS] && cores[d.STATUS] != 'disabled') {
                    areaUnidade.setAttribute("onclick", "carregaUnidade('" + u + "')");
                    //areaUnidade.setAttribute("onclick", "void(0)");
                    svgElement.setAttribute("class", cores[d.STATUS]);
                } else {
                    areaUnidade.setAttribute("onclick", "semDados('" + u + "')");
                    svgElement.setAttribute("class", "disabled");
                }

            }
        });

        var j = 1;
        //console.log(indicador);
        //console.log(indicador.ANO);
        //console.log(banco[id].DETALHES);
        //$.each(banco[id].DETALHES[2014].DADOS, function (i, ind) {
        //console.log(banco[id].DETALHES[indicador.ANO]);
        $.each(banco[id].DETALHES[indicador.ANO].DADOS, function (i, ind) {
            var mesArray = i.toString().substr(-2);
            mesArray = parseInt(mesArray);
            gPrevisto[j] = ind.PREVISTO;
            if (ind.REALIZADO.trim()) {
                gRealizado[j] = ind.REALIZADO;
            }
            j++;
        });

        gPrevisto.push(null);
        gRealizado.push(null);

        grafico.PREVISTO = gPrevisto;
        grafico.REALIZADO = gRealizado;

        geraGrafico(grafico, "#placeholder", indicador.PERIODICIDADE);

        return true;
    } else {
        alert('Não existem informações detalhadas desse indicador no momento');
        return false;
    }
}

function atualizaPaginaDados(mes) {
    mes = parseInt(mes);
    if (mes != 0 && mes != 13) {
        var anomes2 = anomes;
        if (mes < 10) {
            anomes = atual[id].ANO + '0' + mes;
        } else {
            anomes = atual[id].ANO + mes;
        }
        if (banco[id].DETALHES[atual[id].ANO].DADOS[anomes].ATINGIDO != ' ') {
            waitingDialog.show();
            unidades.forEach(function (u) {
                var svgElement = document.getElementById('mapa' + u);
                var areaUnidade = document.getElementById('area' + u);
                areaUnidade.setAttribute("onclick", "semDados('" + u + "')");
                svgElement.setAttribute("class", "disabled");
            });
            gauge.setValue(0);

            //AJAX para pegar a nova informação do MAPA
            $.ajax({
                //url: "http://" + window.location.host + "/apps/sgr/api/mapa/" + id + "/" + anomes,
                url: "https://cagece.com.br/apps/webservice/sgr/mapa/" + id + "/" + anomes,
                type: 'GET',
                async: false,
                cache: false,
                timeout: 30000,
                error: function (err) {
                    console.log(err);
                    alert("Ocorreu um erro no servidor, tente novamente mais tarde");
                },
                success: function (data) {
                    $.each(data, function (u, d) {
                        var svgElement = document.getElementById('mapa' + u);
                        var areaUnidade = document.getElementById('area' + u);
                        if (areaUnidade) {
                            if (cores[d.STATUS] && cores[d.STATUS] != 'disabled') {
                                areaUnidade.setAttribute("onclick", "carregaUnidade('" + u + "')");
                                svgElement.setAttribute("class", cores[d.STATUS]);
                            } else {
                                areaUnidade.setAttribute("onclick", "semDados('" + u + "')");
                                svgElement.setAttribute("class", "disabled");
                            }
                        }
                    });

                    //console.log(banco[id].DETALHES[atual[id].ANO].DADOS[anomes]);

                    gauge.setValue(banco[id].DETALHES[atual[id].ANO].DADOS[anomes].ATINGIDO.replace(',', '.'));
                    $('#estado-dados .titulo').html('All State - ' + getUSMes(banco[id].DETALHES[atual[id].ANO].DADOS[anomes].MES) + '/' + atual[id].ANO);

                    var meta = banco[id].DETALHES[atual[id].ANO].DADOS[anomes].PREVISTO;
                    var previsto = banco[id].DETALHES[atual[id].ANO].DADOS[anomes].REALIZADO;

                    if (atual[id].MEDIDA == 'R$') {
                        meta = 'R$ ' + meta;
                        previsto = 'R$ ' + previsto;
                    } else if (atual[id].MEDIDA == '%') {
                        meta = fPercent(meta);
                        previsto = fPercent(previsto);
                    }

                    $('#estado-dados .meta span').html(meta);
                    $('#estado-dados .realizado span').html(previsto);

                }
            });

            waitingDialog.hide();
        } else {
            alert('We do not have data for this month: ' + getUSMes(banco[id].DETALHES[atual[id].ANO].DADOS[anomes].MES));
            anomes = anomes2;
        }
    }
}

function carregaUnidade(unidade) {
    return false;
    /*
    $('#indicador').removeClass("active").effect("drop", "slow");
    var un = atual[id].MAPA[unidade];
    //console.log("------CARREGA UNIDADE------");
    //console.log(un);
    var idUn = un.INDICADOR;
    var anomesUn = un.ANOMES;
    var content = geraPaginaDadosUnidade(unidade, idUn, anomesUn);
    if (content) {
        $('#unidade').addClass("active").effect("slide", "slow");
        gaugeUnidade.updateConfig({
            width: $("#unidade-canvas").innerWidth() - 30,
            height: $("#unidade-dados").innerHeight() - 10
        });
    } else {
        $('#indicador').addClass("active").effect("slide", "slow");
    }
    */
}

function geraPaginaDadosUnidade(unidade, idUn, anomesUn) {
    //console.log(unidade+","+ idUn + "," +anomesUn);
    var grafico = {}, gPrevisto = [], gRealizado = [];
    $.ajax({
        url: "https://cagece.com.br/apps/webservice/sgr/unidade/" + idUn + "/" + unidade + "/" + anomesUn,
        type: 'GET',
        async: false,
        cache: false,
        timeout: 30000,
        error: function (err) {
            console.log(err);
            alert("Ocorreu um erro no servidor, tente novamente mais tarde");
        },
        success: function (data) {
            unCagece = data;
            var indicador = data.DADOS[anomesUn];
            var causas = data
            var meta = indicador.PREVISTO;
            var previsto = indicador.REALIZADO;

            if (atual[id].MEDIDA == 'R$') {
                meta = 'R$ ' + meta;
                previsto = 'R$ ' + previsto;
            } else if (atual[id].MEDIDA == '%') {
                meta = fPercent(meta);
                previsto = fPercent(previsto);
            }

            $('#unidade-dados .meta span').html(meta);
            $('#unidade-dados .realizado span').html(previsto);
            $('.titulo-unidade').html(getUnidadeEN(indicador.UNIDADE) + " - " + getUSMes(indicador.MES));

            gaugeUnidade.setValue(indicador.ATINGIDO);
            gaugeUnidade.draw();

            var j = 1;
            $.each(data.GRAFICO.PREVISTO, function (i, ind) {
                gPrevisto[j] = ind;
                if (data.GRAFICO.REALIZADO[i]) {
                    gRealizado[j] = data.GRAFICO.REALIZADO[i];
                }
                j++;
            });

            gPrevisto.push(null);
            gRealizado.push(null);

            grafico.PREVISTO = gPrevisto;
            grafico.REALIZADO = gRealizado;

            //console.log(grafico);

            geraGrafico(grafico, "#unidade-placeholder", atual[id].PERIODICIDADE);

            $('#unidade-fca').html(geraPaginaCausasMesUnidade(data.CAUSAS[anomesUn]));
        }
    });

    window.onresize = function () {
        gaugeUnidade.updateConfig({
            width: $("#unidade-canvas").innerWidth() - 30,
            height: $("#unidade-dados").innerHeight() - 10
        });
    };

    return true;
}

function atualizaPaginaDadosUnidade(mes) {
    mes = parseInt(mes);

    if (mes != 0 && mes != 13) {
        if (mes < 10) {
            var anomesUn = atual[id].ANO + '0' + mes;
        } else {
            var anomesUn = atual[id].ANO + mes;
        }

        if (unCagece.DADOS[anomesUn].REALIZADO != null) {

            var meta = unCagece.DADOS[anomesUn].PREVISTO;
            var previsto = unCagece.DADOS[anomesUn].REALIZADO;

            if (atual[id].MEDIDA == 'R$') {
                meta = 'R$ ' + meta;
                previsto = 'R$ ' + previsto;
            } else if (atual[id].MEDIDA == '%') {
                meta = fPercent(meta);
                previsto = fPercent(previsto);
            }

            $('#unidade-dados .meta span').html(meta);
            $('#unidade-dados .realizado span').html(previsto);

            $('.titulo-unidade').html(unCagece.DADOS[anomesUn].UNIDADE + " - " + unCagece.DADOS[anomesUn].MES + '/' + atual[id].ANO);

            gaugeUnidade.setValue(unCagece.DADOS[anomesUn].ATINGIDO);

            $('#unidade-fca').hide(400, function () {
                $('#unidade-fca').html(geraPaginaCausasMesUnidade(unCagece.CAUSAS[anomesUn]));
                $('#unidade-fca').show();
            });

        } else {
            alert('Ainda não existem dados medidos para o mês de ' + unCagece.DADOS[anomesUn].MES);
        }
    }

}

function geraGrafico(dados, div, periodo) {
    //console.log(dados);
    var d1 = [], d2 = [], pTicks = [];

    $.each(dados.PREVISTO, function (i, p) {
        var temp = [i, p];
        d1.push(temp);
    });

    $.each(dados.REALIZADO, function (i, r) {
        var temp = [i, r];
        d2.push(temp);
    });

    if (periodo === "A") {
        pTicks = [[1, "DEC"]];
        var multiplicador = 12;
    } else if (periodo === "S") {
        pTicks = [[1, "JUN"], [2, "DEC"]];
        var multiplicador = 6;
    } else if (periodo === "T") {
        pTicks = [[1, "MAR"], [2, "JUN"], [3, "SEP"], [4, "DEC"]];
        var multiplicador = 3;
    } else if (periodo === "B") {
        pTicks = [[1, "FEB"], [2, "APR"], [3, "JUN"], [4, "AUG"], [5, "OCT"], [6, "DEC"]];
        var multiplicador = 2;
    } else {
        pTicks = [
            [1, "JAN"], [2, "FEB"], [3, "MAR"], [4, "APR"],
            [5, "MAY"], [6, "JUN"], [7, "JUL"], [8, "AUG"],
            [9, "SEP"], [10, "OCT"], [11, "NOV"], [12, "DEC"]
        ];
        var multiplicador = 1;
    }

    var placeholder = $(div);
    $.plot(placeholder, [
        {label: "KPI Goal", data: d1},
        {label: "KPI Realized", data: d2}

    ], {
        series: {
            lines: {show: true,
                lineWidth: 8},
            points: {show: true},
        },
        legend: {position: "se",
        },
        shadowSize: 8,
        colors: ["#3576C4", "#f79537"],
        xaxis: {
            show: true,
            position: "bottom",
            ticks: pTicks
        },
        yaxis: {
            show: true,
            position: "left",
            ticks: 10,
            tickDecimals: 0
        },
        grid: {
            backgroundColor: {colors: ["#fff", "#eee"]},
            borderWidth: {
                top: 1,
                right: 1,
                bottom: 2,
                left: 2
            },
            clickable: true,
            autoHighlight: true
        }
    });

    placeholder.unbind("plotclick");

    if (div == '#placeholder') {
        placeholder.bind("plotclick", function (event, pos) {
            var anomesGrafico = pos.x * multiplicador;
            atualizaPaginaDados(anomesGrafico);
        });
    } else {
        placeholder.bind("plotclick", function (event, pos) {
            var anomesGrafico = pos.x * multiplicador;
            atualizaPaginaDadosUnidade(anomesGrafico);
        });
    }




    $(".demo-container").resizable({
        maxWidth: 900,
        maxHeight: 400,
        minWidth: 300,
        minHeight: 200
    });
}


function abreDetalhes() {
    //waitingDialog.show();
    var div = "";
    $.ajax({
        //url: "http://" + window.location.host + "/apps/sgr/api/indicador/" + id,
        url: "https://www.cagece.com.br/apps/webservice/sgr/indicador/" + id,
        //url: "http://" + window.location.host + "/sgr/webservice_sgr/indicador/" + id,
        type: 'GET',
        async: false,
        cache: false,
        timeout: 30000,
        error: function (err) {
            console.log(err);
            alert("Ocorreu um erro no servidor, tente novamente mais tarde");
            return false;
        },
        success: function (data) {
            var ind = banco[id];
            //console.log(data);
            div = geraIndicadorHtml(data, ind, true);

            $('#myModal .modal-body').html(div);
            $('#myModal .modal-title').html('12 last months KPI details');
            $('#myModal').modal('show');
        }
    });
}


function geraIndicadorHtml(dados, ind, a) {
    console.log(atual[id]);
    //var head = '<div class="info"><h3>Informações</h3><span><b>Indicador: </b>' + atual[id].NOME_INDICADOR + '<span></span><b>Objetivo Estratégico: </b>' + ind.OBJ_DSC_OBJETIVO + '</span><span><b>Periodicidade: </b>' + ind.IND_TIP_PERIODICIDADE + ' / <b>Competência: </b>' + ano + '</div>';
    var head = '<div class="info"><h3>Information</h3><span><b>Indicador: </b>' + atual[id].NOME_INDICADOR + '</span><span><b>Periodicity: </b>' + getENPeriod(ind.IND_TIP_PERIODICIDADE) + ' </span><span><b>Year: </b>' + ano + '</span></div>';

    var div = head + '<div class="info tabela"><table class="dados" width="96%" style="margin: 2%;"><thead><tr><th>Month</th><th align="center" class="previsto">KPI Goal</th><th align="center" class="realizado">KPI Realized</th><th></tr></thead><tbody>';
    $.each(dados, function (i, d) {
        var mes = d.MES;
        if (a) {
            mes = d.ANO + ' - ' + getUSMes(mes);
        }

        //verifica se o indicador vai ser mensal, bimestral, trimestral, semestral ou anual
        if (typeof (d.PREVISTO) !== 'undefined') {
            var medida = d.MEDIDA;
            var medida2 = medida;
            if (d.PREVISTO != '0') {
                div = div.concat('<tr>');
                if (d.REALIZADO != '' && d.REALIZADO != ' ') {
                    //div = div.concat('<td><a href="javascript:geraPaginaCausasMesData(' + ind.IND_COD_INDICADOR + ',\'' + d.ANOMES + '\');">' + mes + '</a></td>');
                } else {
                    //div = div.concat('<td>' + mes + '</td>');
                }
                div = div.concat('<td>' + mes + '</td>');

                if (typeof (d.STATUS) !== 'undefined') {
                    var img = d.STATUS + '.png';
                } else {
                    var img = '';
                }

                if (d.REALIZADO === ' ')
                    medida2 = '';

                if (medida == 'R$') {
                    div = div.concat('<td align="center">$ ' + d.PREVISTO + '</td>');
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

function getUSMes(m) {
    switch (m) {
        case 'Janeiro':
            m = 'January';
            break;
        case 'Fevereiro':
            m = 'February';
            break;
        case 'Março':
            m = 'March';
            break;
        case 'Abril':
            m = 'April';
            break;
        case 'Maio':
            m = 'May';
            break;
        case 'Junho':
            m = 'June';
            break;
        case 'Julho':
            m = 'July';
            break;
        case 'Agosto':
            m = 'August';
            break;
        case 'Setembro':
            m = 'September';
            break;
        case 'Outubro':
            m = 'October';
            break;
        case 'Novembro':
            m = 'November';
            break;
        case 'Dezembro':
            m = 'December';
            break;
    }
    return m;
}

function getENPeriod(m) {
//verifica se o indicador vai ser mensal, bimestral, trimestral, semestral ou anual
    switch (m) {
        case 'A':
            m = 'Yearly';
            break;
        case 'M':
            m = 'Monthly';
            break;
        case 'S':
            m = 'Semiannual';
            break;
        case 'B':
            m = 'Bimonthly';
            break;
        case 'T':
            m = 'Quarterly';
            break;
    }
    return m;
}

function geraPaginaCausasMes(flag) {
    //console.log(id);
    //console.log(anomes);
    var ano = anomes.substring(0, 4);
    if (flag) {
        var causas = banco[id].DETALHES[ano].GGOVE[anomes];
    } else {
        var causas = banco[id].DETALHES[ano].CAUSAS[anomes];
    }
    var plano = banco[id].DETALHES[ano].PLANO;

    //console.log(ano);
    //console.log(banco[id]);

    if (typeof (causas) !== 'undefined') {
        var div = '<div class="info">';
        div = div.concat('<b>Data da Reunião: </b>' + causas.DATAREU + '<br/><br/>');
        div = div.concat('<b>Data de Referência: </b>' + causas.DATA + '<br/><br/>');
        div = div.concat('<b>Fatos: </b>' + causas.FATOS + '<br/><br/>');
        div = div.concat('<b>Causas: </b>' + causas.CAUSAS + '<br/><br/>');
        div = div.concat('<b>Ações: </b>' + causas.ACOES + '<br/><br/>');
        div = div.concat('</div>');
        $('#myModal .modal-body').html(div);
        $('#myModal .modal-title').html('Results Analysis - All State');
        $('#myModal').modal('show');
    } else {
        return alert('No data found');
    }
}

function geraPaginaCausasMesData(ind, temp_anomes) {
    anomes = temp_anomes;
    id = ind;
    geraPaginaCausasMes(false);
}

function geraPaginaCausasMesUnidade(causas) {
    var div = '<div class="info"><h3>Fatos, Causas e Ações</h3><br>';
    if (typeof (causas) !== 'undefined' && causas != null && causas != 'null') {
        //console.log(typeof causas);
        div = div.concat('<b>Data da Reunião: </b>' + causas.DATAREU + '<br/><br/>');
        div = div.concat('<b>Data de Referência: </b>' + causas.DATA + '<br/><br/>');
        div = div.concat('<b>Fatos: </b>' + causas.FATOS + '<br/><br/>');
        div = div.concat('<b>Causas: </b>' + causas.CAUSAS + '<br/><br/>');
        div = div.concat('<b>Ações: </b>' + causas.ACOES + '<br/><br/>');

    } else {
        div = div.concat('<b>Ainda não foram cadastrados dados no SGR para esse mês</b>');
    }
    div = div.concat('</div>');

    return div;
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

function pausecomp(millis) {
    var date = new Date();
    var curDate = null;
    do {
        curDate = new Date();
    } while (curDate - date < millis);
}

function semDados(unidade) {
    //alert('No information for ' + unidade);
    return false;
}

function mudaPaginaIndicador() {
    var totalPaginas = $('.page_indicador').size();
    var paginaAtual = $('.show').data('id');
    $('.show').removeClass("show").effect("drop", "slow");
    if (paginaAtual >= totalPaginas) {
        $('#page_1').addClass("show").effect("slide", "slow");
        $('.navbar .nav a').html('Ver próxima página de indicador >>');
    } else {
        paginaAtual++;
        var id = '#page_' + paginaAtual;
        $(id).addClass("show").effect("slide", "slow");
        $('.navbar .nav a').html('<< Voltar para a primeira página');
    }
}
function getUnidadeEN(m){
    switch (m) {
        case 'UN-BME':
            m = 'Zone 1';
            break;
        case 'UN-BBJ':
            m = 'Zone 2';
            break;
        case 'UN-BBA':
            m = 'Zone 3';
            break;
        case 'UN-BCL':
            m = 'Zone 4';
            break;
        case 'UN-BAC':
            m = 'Zone 5';
            break;
        case 'UN-BSI':
            m = 'Zone 6';
            break;
        case 'UN-BPA':
            m = 'Zone 7';
            break;
        case 'UN-BAJ':
            m = 'Zone 8';
            break;
        case 'UN-BSA':
            m = 'Zone 9';
            break;
        case 'UN-MTN':
            m = 'District 1';
            break;
        case 'UN-MTS':
            m = 'District 4';
            break;
        case 'UN-MTO':
            m = 'District 3';
            break;
        case 'UN-MTL':
            m = 'District 2';
            break;
    }
    return m;
}


function openHistoric(){
    var div = '<div style="width: 100%;text-align:center;max-width: 700px; margin:0 auto;"><img style="width: 100%;" src="historic.png" /></div>';
    $('#myModal .modal-body').html(div);
    $('#myModal .modal-title').html('12 last months KPI details');
    $('#myModal').modal('show');
}

function openFCA(){
    var div = '<div class="info">';
        div = div.concat('<b>Meeting Date: </b> mm/dd/yyyy<br/><br/>');
        div = div.concat('<b>Facts</b>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut optime, secundum naturam affectum esse possit. Ea possunt paria non esse. Transfer idem ad modestiam vel temperantiam, quae est moderatio cupiditatum rationi oboediens. Bonum negas esse divitias, praeposìtum esse dicis? Equidem, sed audistine modo de Carneade? Non est ista, inquam, Piso, magna dissensio.<br />Nunc vides, quid faciat. Proclivi currit oratio.<br/><br/>');
        div = div.concat('<b>Causes: </b>Qui autem esse poteris, nisi te amor ipse ceperit? Sed haec omittamus; Similiter sensus, cum accessit ad naturam, tuetur illam quidem, sed etiam se tuetur; Si longus, levis. Sed ne, dum huic obsequor, vobis molestus sim. Stulti autem malorum memoria torquentur, sapientes bona praeterita grata recordatione renovata delectant. Aperiendum est igitur, quid sit voluptas;<br />Duo Reges: constructio interrete. Ergo hoc quidem apparet, nos ad agendum esse natos. Quaerimus enim finem bonorum. Quid turpius quam sapientis vitam ex insipientium sermone pendere?<br/><br/>');
        div = div.concat('<b>Actions: </b>Unum nescio, quo modo possit, si luxuriosus sit, finitas cupiditates habere. Quis suae urbis conservatorem Codrum, quis Erechthei filias non maxime laudat? Quae si potest singula consolando levare, universa quo modo sustinebit? Vitiosum est enim in dividendo partem in genere numerare. Ut in voluptate sit, qui epuletur, in dolore, qui torqueatur. Sed hoc sane concedamus. Itaque sensibus rationem adiunxit et ratione effecta sensus non reliquit. Ea, quae dialectici nunc tradunt et docent, nonne ab illis instituta sunt aut inventa sunt? Disserendi artem nullam habuit. Quod mihi quidem visus est, cum sciret, velle tamen confitentem audire Torquatum.<br/><br/>');
        div = div.concat('</div>');
    $('#myModal .modal-body').html(div);
    $('#myModal .modal-title').html('Results Analysis - Facts, Causes, and Actions');
    $('#myModal').modal('show');
}

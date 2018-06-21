var banco, id, anomes, unCagece, arrayLocalidades = [], data = new Date(), ano = data.getFullYear();
var unidades = ['UNMTN', 'UNMTS', 'UNMTO', 'UNMTL', 'UNBSI', 'UNBCL', 'UNBAJ', 'UNBBJ', 'UNBPA', 'UNBBA', 'UNBSA', 'UNBAC', 'UNBME'];
var cores = {"sVermelhaAbaixo": "vermelho", "sVermelhaAcima": "vermelho", "sVerdeAbaixo": "verde", "sVerdeAcima": "verde", "sAmarelaAbaixo": "amarelo", "sAmarelaAcima": "amarelo", "qVermelho": "vermelho", "qVerde": "verde", "qAmarelo": "amarelo", "bPreta": "disabled"};
$.getJSON("http://" + window.location.host + "/apps/sgr/api/todos_indicadores.json", function (data) {
    banco = data;
});
setInterval(function () {
    var div = $('.active')[0];
    if (div.id == 'indicadores') {
        mudaPaginaIndicador();
    }
}, 120 * 1000);
var gauge = new Gauge({
    renderTo: 'estado-gauge',
    width: 380,
    height: $("#mapa_rmetropolitana").innerHeight() - 10,
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
    var grafico = {}, gPrevisto = [], gRealizado = [];
    if (atual[id]) {
        var indicador = atual[id];
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
                    svgElement.setAttribute("class", cores[d.STATUS]);
                } else {
                    areaUnidade.setAttribute("onclick", "semDados('" + u + "')");
                    svgElement.setAttribute("class", "disabled");
                }

            }
        });

        var j = 1;
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
                url: "http://" + window.location.host + "/apps/sgr/api/mapa/" + id + "/" + anomes,
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
                    $('#estado-dados .titulo').html('Ceará - ' + banco[id].DETALHES[atual[id].ANO].DADOS[anomes].MES + '/' + atual[id].ANO);

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
            alert('Ainda não existem dados medidos para o mês de ' + banco[id].DETALHES[atual[id].ANO].DADOS[anomes].MES);
            anomes = anomes2;
        }
    }
}

function carregaUnidade(unidade) {
    $('#indicador').removeClass("active").effect("drop", "slow");
    var un = atual[id].MAPA[unidade];
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
}

function geraPaginaDadosUnidade(unidade, idUn, anomesUn) {
    var grafico = {}, gPrevisto = [], gRealizado = [];
    $.ajax({
        url: "http://" + window.location.host + "/apps/sgr/api/unidade/" + idUn + "/" + unidade + "/" + anomesUn,
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
            $('.titulo-unidade').html(indicador.UNIDADE + " - " + indicador.MES);

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
        pTicks = [[1, "DEZ"]];
        var multiplicador = 12;
    } else if (periodo === "S") {
        pTicks = [[1, "JUN"], [2, "DEZ"]];
        var multiplicador = 6;
    } else if (periodo === "T") {
        pTicks = [[1, "MAR"], [2, "JUN"], [3, "SET"], [4, "DEZ"]];
        var multiplicador = 3;
    } else if (periodo === "B") {
        pTicks = [[1, "FEV"], [2, "ABR"], [3, "JUN"], [4, "AGO"], [5, "OUT"], [6, "DEZ"]];
        var multiplicador = 2;
    } else {
        pTicks = [
            [1, "JAN"], [2, "FEV"], [3, "MAR"], [4, "ABR"],
            [5, "MAI"], [6, "JUN"], [7, "JUL"], [8, "AGO"],
            [9, "SET"], [10, "OUT"], [11, "NOV"], [12, "DEZ"]
        ];
        var multiplicador = 1;
    }

    var placeholder = $(div);
    $.plot(placeholder, [
        {label: "Previsto", data: d1},
        {label: "Realizado", data: d2}

    ], {
        series: {
            lines: {show: true,
                lineWidth: 8},
            points: {show: true},
        },
        legend: {position: "sw",
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
        url: "http://" + window.location.host + "/apps/sgr/api/indicador/" + id,
        type: 'GET',
        async: false,
        cache: false,
        timeout: 30000,
        error: function (err) {
            console.log(err);
            alert("Ocorreu um erro no servidor, tente novamente mais tarde");
        },
        success: function (data) {
            var ind = banco[id];
            //console.log(data);
            div = geraIndicadorHtml(data, ind, true);

            $('#myModal .modal-body').html(div);
            $('#myModal .modal-title').html('Detalhes dos últimos 12 meses do indicador');
            $('#myModal').modal('show');
        }
    });
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
                    div = div.concat('<td><a href="javascript:geraPaginaCausasMesData(' + ind.IND_COD_INDICADOR + ',\'' + d.ANOMES + '\');">' + mes + '</a></td>');
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
        $('#myModal .modal-title').html('Fatos, causas e ações para o Estado');
        $('#myModal').modal('show');
    } else {
        return alert('Ainda não foram cadastrados dados no SGR para esse mês');
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
    }
    while (curDate - date < millis);
}

function semDados(unidade) {
    alert('Sem informações para ' + unidade);
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


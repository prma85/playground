if ($(window).width() > 767) {

}
window.onresize = function () {

};

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

function abreDetalhes(matricula, tecnico) {
    var telaOtrs = '<iframe src="http://cliquecagece.int.cagece.com.br/otrs?matricula='+matricula+'" width="100%" height="770"></iframe>';
    $('#myModal .modal-body').html(telaOtrs);
    $('#myModal').modal('show');
    $('#myModal #myModalLabel').html("Chamados para "+tecnico+" / Matrícula "+matricula);
}


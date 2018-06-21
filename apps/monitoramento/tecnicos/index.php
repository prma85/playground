<?php
require_once 'model/lanlink.php';
$model = new lanlinkModel();
$empresa = $_GET["empresa"];
if (!$empresa){
    foreach($_GET as $k=>$g){
        $empresa = $k;
        break;;
    }
}
$informacoes = $model->getInformacoesTecnicos('html', $empresa);
$cabecalho = $model->getCabecalho();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <META HTTP-EQUIV="refresh" CONTENT="120">

        <title>Dashboard Lanlink</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/jquery-ui.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/flotchart.css">

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body id="sgr">
        <header class="navbar navbar-fixed-top">

            <?php echo $cabecalho; ?>
        </header>
        <!--[if lt IE 7]>
            <p class="browsehappy">Está está usando um navegador <strong>desatualizado</strong>. Por favor, <a href="http://browsehappy.com/">atualize o seu navegador</a> para usar o sistema de forma correta.</p>
        <![endif]-->
        <div class="container page active" id="indicadores">
            <?php echo $informacoes; ?>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Fatos, Causas e Ações</h4>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                </div>
            </div>
        </div>


    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.1.js"><\/script>')</script> -->
        <script src="js/vendor/jquery-1.11.1.js"></script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/vendor/bootstrap-waitingfor.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
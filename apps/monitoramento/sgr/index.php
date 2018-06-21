<?php
require_once 'model/sgr.php';
$model = new sgrModel();
$indicadores = $model->getIndicadoresRecentes('html');
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Dashboard SGR</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">

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
            <img alt="logo cagece" src="img/cagece.png" />
            Indicadores Estratégicos de Resultados
        </header>
        <!--[if lt IE 7]>
            <p class="browsehappy">Está está usando um navegador <strong>desatualizado</strong>. Por favor, <a href="http://browsehappy.com/">atualize o seu navegador</a> para usar o sistema de forma correta.</p>
        <![endif]-->
        <?php /*
          <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
          <div class="container">
          <div class="navbar-header">
          <!--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          </button>-->
          <a class="navbar-brand" href="#">Indicadores do Sistema de Gestão de Resultados</a>
          </div>
          <!--
          <div id="navbar" class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" role="form">
          <div class="form-group">
          <select class="form-control">
          <option>Filtro 1</option>
          </select>
          </div>
          <div class="form-group">
          <select class="form-control">
          <option>Filtro 2</option>
          </select>
          </div>
          </form>
          </div><!--/.navbar-collapse -->
          </div>
          </nav>
         */ ?>
        <?php
        /*
          <div class="container">
          <!-- Example row of columns -->
          <div class="row">
          <div class="box-indicador col-xs-12 col-lg-3 col-sm-6">
          <div class="indicador"></div>
          </div>
          <div class="box-indicador col-xs-12 col-lg-3 col-sm-6">
          <div class="indicador"></div>
          </div>
          <div class="box-indicador col-xs-12 col-lg-3 col-sm-6">
          <div class="indicador"></div>
          </div>
          <div class="box-indicador col-xs-12 col-lg-3 col-sm-6">
          <div class="indicador"></div>
          </div>
          </div>
          </div> <!-- /container -->
         */
        echo $indicadores;
        ?>
        <div class="container" id="main">
            <div class="row">
                <a class="btn-sm btn-primary" href="javascript:fechar();" style="position: absolute;z-index: 3;right: 10px;">Fechar</a>
                <div id="box-conteudo" class="col-xs-12 col-lg-12 col-sm-12">

                </div>
                <div id="box-causas" class="col-xs-12 col-lg-12 col-sm-12">

                </div>
            </div>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.1.js"><\/script>')</script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/bootstrap-waitingfor.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>

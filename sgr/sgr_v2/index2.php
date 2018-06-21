<?php
require_once 'model/sgr.php';
$model = new sgrModel();
$indicadores = $model->getIndicadoresRecentes('html', true);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>BIM System - Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/jquery-ui.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main2.css">
        <link rel="stylesheet" href="css/flotchart.css">

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

    </head>
    <body id="sgr">
        <header class="navbar navbar-fixed-top">
            <img alt="logo" src="img/logo.png" />
            <input type="search" class="inputbox form-control search-query search" name="search" id="search" placeholder="search for a KPI"/>

            <img src="img/search-icon.png" class="search-img" />
        </header>
        <div class="container-fluid" id="indicadores">
            <?php echo $indicadores; ?>
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
                      <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
                  </div>
              </div>
          </div>
      </div>

      <script src="js/vendor/jquery-1.11.1.js"></script>
      <script src="js/vendor/jquery-ui.min.js"></script>
      <script src="js/jquery.flot.js"></script>
      <script src="js/jquery.flot.categories.js"></script>
      <script src="js/jquery.flot.resize.js"></script>
      <script src="js/vendor/bootstrap.min.js"></script>
      <script src="js/vendor/bootstrap-waitingfor.js"></script>
      <script src="canv-gauge/gauge.min.js"></script>
      <script src="js/main2.js"></script>
      <script>atual = jQuery.parseJSON(atual);</script>
      <script>
        $("#search").bind("keyup search change", function() {
          var input = $("#search").val().toLowerCase().split(' ').join('-');
          var kpis = $(".box-indicador");
            kpis.show();
            if (input !== "") {
        		    console.log("pesquisando por: " + input)
        		      kpis.not("[data-alias*=" + input + "]").hide();

            }
        	return false;
        });
      </script>
  </body>
</html>

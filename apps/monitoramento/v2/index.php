<?php include_once 'header.php'; ?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr" >
    <head>
        <title>Monitoramento GETIC</title>
        <?php
        if ($stop == 'false') {
            echo '<META HTTP-EQUIV="refresh" CONTENT="'.$time.'; URL='.$uri.'?sys='.$sys.'&stop=false">';
        }
        ?>


        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <meta http-equiv="Cache-control" content="no-cache">
        <meta http-equiv="pragma" content="no-cache" />
        <meta http-equiv="expires" content = "-1" />

        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/main.js"></script>	

        <link rel="stylesheet" href="../css/system.css" type="text/css" />
        <link rel="stylesheet" href="../css/general.css" type="text/css" />
        <link rel="stylesheet" href="../css/template.css" type="text/css" />
        <link rel="stylesheet" href="main.css" type="text/css" />
    </head>

    <body onload="UR_Start()">
        <div id="content" class="monitoramento-getic">
            <div id="left">
                <iframe sandbox="allow-same-origin allow-forms allow-scripts" frameborder="0" scrolling="no" src="<?php echo $url; ?>"></iframe>
            </div>
            <div class="toolbar" id="right">
                <ul>
                    <li id="sgd">
                        <a href="<?php echo $uri; ?>?sys=sgd&stop=true" title="SGD">Monitor do SGD</a>
                    </li>
                    <li id="sgd2">
                        <a href="<?php echo $uri; ?>?sys=sgd2&stop=true" title="SGD - Executados">Monitor de Sistemas</a>
                    </li>
                    <li id="otrs">
                        <a href="<?php echo $uri; ?>?sys=otrs&stop=true" title="OTRS">Monitor de Suporte</a>
                    </li>
                    <li id="getic">
                        <a href="<?php echo $uri; ?>?sys=sgrgetic&stop=true" title="Indicadores da Gegtic">Indicadores da GETIC</a>
                    </li>
                    <li id="aniv">
                        <a href="<?php echo $uri; ?>?sys=ani&stop=true" title="Aniversariantes">Aniversari- antes</a>
                    </li>
                    <li id="news">
                        <a href="<?php echo $uri; ?>?sys=news&stop=true" title="Ultimas Noticias">Últimas Notícias</a>
                    </li>
                    <li id="sgr">
                        <a href="<?php echo $uri; ?>?sys=sgr&stop=true" title="RSS">Indicadores Estratégicos</a>
                    </li>

                </ul>
            </div>
            <div id="bottom">
                <img id="logo" src="../img/logo.png"  />
                <p>GETIC - Gerência de Tecnologia da Informação e Comunicação</p>
                <a id="play" class="<?php echo $stop; ?>" href="<?php echo $uri . "?sys=" . $sys . "&stop=false"; ?>"></a>
                <div id="datahora">
                    <span id="hora"></span>
                </div>

            </div>
        </div>
        <script>
            $('#right').height($(window).innerHeight() - 50);
            $('#left').height($(window).innerHeight() - 50);
            $('#left').width($(window).innerWidth() - 100);
            $('iframe').height($(window).innerHeight() - 50);
            $('iframe').width($(window).innerWidth() - 100);
            window.onresize = function () {
                $('#right').height($(window).innerHeight() - 50);
                $('#left').height($(window).innerHeight() - 50);
                $('#left').width($(window).innerWidth() - 100);
                $('iframe').height($(window).innerHeight() - 50);
                $('iframe').width($(window).innerWidth() - 100);
            }
        </script>
    </body>
</html>
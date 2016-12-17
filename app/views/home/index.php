<?php $controller->setCookieForStyle(); ?>
<!DOCTYPE html>
<html>
    <head>


        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="/mvc/public/css/responsive.css">
        <link type="text/css" rel="stylesheet" href="/mvc/public/css/style.css">

        <?php $controller->cookieSytle2CSS(); ?>

        <title>Gamp Php</title>
        <?php

        function spruecheArray()
        {
            $spruch[0] = 'Wer früher stirbt, ist länger tod';
            $spruch[1] = 'Das Leben ist kein Ponyhof';
            $spruch[2] = 'Träume nicht dein Leben, lebe deine Träume';

            foreach ($spruch as $value)
            {
                echo $value . "<br>";
            }
        }
        ?>


        <script>
            function getCookie(cname) {
                var name = cname + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                        return c.substring(name.length, c.length);
                    }
                }
                return "";
            }


            var d = new Date();
            d.setTime(d.getTime() + (60));
            var expires = "expires=" + d.toUTCString();
            document.cookie = "message=1;" + expires + ";path=/";


            if (getCookie('message') === '')
            {
                alert("Diese Seite speichert Cookies!");
                var d = new Date();
                d.setTime(d.getTime() + (60));
                var expires = "expires=" + d.toUTCString();
                document.cookie = "message=1;" + expires + ";path=/";
            }

        </script>


    </head>
    <body>

        <div class="header">
            <h1>PHP/Javascript Gamper</h1>
            <?php $controller->loginHeader(); ?>
        </div>

        <div class="row">
            <div class="col-3 col-m-3 menu">
                <ul>
                    <li><a href="?aufgabe=1">Aufgabe 1</a></li>
                    <li><a href="?aufgabe=2">Aufgabe 2</a></li>
                    <li><a href="?aufgabe=3">Aufgabe 3</a></li>
                    <li><a href="bildhochladen">Aufgabe6</a></li>
                    <li><a href="datenbankInhaltAnzeigen">Inhalt DB Anzeigen</a></li>
                    <?php $controller->loginNAV(); ?>
                </ul>
            </div>

            <div id="section" class="col-6 col-m-9">

                <p>
                    <?php
                    $controller->sectionInhalt();
                    ?>
                </p>


            </div>

            <div id="side" class="col-3 col-m-12">
                <div class="aside">

                </div>
            </div>

        </div>

        <div class="footer col-m-12">
            <p><?php
                $datum = date("Y");
                echo '&copy;Markus Weissenbach ' . $datum;
                ?>
            </p>
            <a href="?stil=2">
                Stil2
            </a>
            <a href="?stil=1">
                Stil
            </a>

        </div>

    </body>
</html>


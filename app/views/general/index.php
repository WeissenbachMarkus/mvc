<?php $controller->setCookieForStyle(); ?>
<!DOCTYPE html>
<html>
    <head>


        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="/mvc/public/css/responsive.css">
        <link type="text/css" rel="stylesheet" href="/mvc/public/css/style.css">

        <?php $controller->cookieSytle2CSS(); ?>

        <title>Gamp Php</title>

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
        <div class="header col-12 col-m-12">
            <h1>PHP/Javascript Gamper</h1>
            <?php $controller->loginHeader(); ?>
        </div>

        <div class="row">
            <div class="col-3 col-m-4 menu">
                <ul>
                    <div id="dropdownUser" class = "dropdown"
                         >       <li><a href="user">User</a></li>
                        <div id = "userHidden" class="hidden">
                            <li><a href ="register">hinzufuegen</a></li>
                            <li><a href ="bildhochladen">bildhochladen</a></li>
                        </div>
                    </div>
                    <div id="dropdownModel" class="dropdown">
                        <li><a href = "modul">Modul</a></li>
                        <div id="modulHidden" class="hidden">
                            <li><a href="modulAnlegen"> Modul Anlegen</a></li>
                        </div>
                    </div>
                    <li><a href = "message">Message</a></li>
                    <li><a href = "statistic">Statistic</a></li>
                </ul>
                <?php $controller->navigation(); ?>
            </div>

            <div id="section" class="col-8 col-m-8">
                <?php $controller->sectionInhalt(); ?>
                <br>
                <?php $controller->fehler(); ?>
            </div>
        </div>

        <div class="footer col-m-12">
            <p><?php
                $datum = date("Y");
                echo '&copy;Markus Weissenbach ' . $datum;
                ?>
            </p>
            <a href="?stil=2"> Stil2</a>
            <a href="?stil=1"> Stil </a>
        </div>
    </body>
</html>


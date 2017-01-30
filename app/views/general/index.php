<?php $controller-> setCookieForStyle(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="../app/views/general/css/responsive.css">
        <link type="text/css" rel="stylesheet" href="../app/views/general/css/style.css">

        <?php $controller->cookieSytle2CSS(); ?>

        <title>Gamp Php</title>

        <script src="../app/views/general/cookie.js"></script>

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
            <p><?php $controller->date(); ?> </p>
            <a href="<?=get_class($this)?>/setStyle/2"> Stil2</a>
            <a href="<?=get_class($this)?>/setStyle/1"> Stil </a>
        </div>
    </body>
</html>


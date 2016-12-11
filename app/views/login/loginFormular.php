<?php

$action = 'login.php';
if (isset($_GET['url']) && $_GET['url'] == 'register') {
    $action = 'register/registrieren';
}
echo'
<form action ="' . $action . '" method="POST">
    Nickname:<br>
    <input type = "text" name = "Nickname" placeholder = "Nickname">
    <br><br>
    Passwort:<br>
    <input type = "password" name = "Passwort" placeholder = "Passwort">
    <br><br> ';


if (isset($_GET['url']) && $_GET['url'] == 'register') {
    echo'Passwort wiederholen:<br>
        <input type = "password" name = "Passwort2" placeholder = "Passwort">
    <br><br> ';
}

echo ' <input type = "submit" value = "Verschicken">
        </form>';


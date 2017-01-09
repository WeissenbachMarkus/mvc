<form action ="login/verarbeitung" method="POST">
    <fieldset>
        <legend> Login</legend>
        <fieldset>
            <legend> Email</legend>
            <input type = "email" name = "Email" placeholder = "Email">
        </fieldset>
        
        <fieldset>
        <legend> Passwort</legend>
        <input type = "password" name = "Passwort" placeholder = "Passwort"> </fieldset>
        <br>
        <label><?php $controller->fehler();?></label>
        <input type = "submit" value = "Verschicken">
    </fieldset>
</form>
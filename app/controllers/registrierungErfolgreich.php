<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of registrierungErfolgreich
 *
 * @author markus
 */
class registrierungErfolgreich extends Controller
{

    protected function sectionInhalt()
    {

        if (!empty($_SESSION['dataRegister']))
        {
            echo '<h2>Registrierung erfolgreich!</h2>';
            foreach ($_SESSION['dataRegister'] as $key => $value)
            {
                echo htmlspecialchars($key) . ' : ' . htmlspecialchars($value) . '<br>';
            }
        } else
            echo 'somethings wrong!';
       
        unset($_SESSION['dataRegister']);
    }

}

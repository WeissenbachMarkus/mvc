<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author weiss
 */
class login extends Controller
{
    

    public function index()
    {
        $this->view($this, 'login/loginGeneral');
    }

    public function sectionInhalt()
    {
        $this->view($this, 'login/loginFormular');
    }

    public function verarbeitung()
    {
        $datenbank = $this->getModel('Alexandertechnik');
        if ($nutzerDaten=$datenbank->loginFindEmailAndPassword($_POST['Email'], $_POST['Passwort']))
        {  
            $this->startSession();
            $_SESSION['user']=$nutzerDaten[0]['u_nickname'];
            header('Location: http://localhost/mvc/public/home');
        } else
        {
           if ($email = $datenbank->loginEmailVorhanden($_POST['Email']))
                $this->getLogger()->logThis('Loginversuch fehlgeschlagen von: ' . $email[0]['u_email'], 1);
            else
                $this->getLogger()->logThis('Loginversuch fehlgeschlagen von: Unbekannt', 1);
                        
            $this->setFehler('Benutzerdaten inkorrekt!');
            header('Location: http://localhost/mvc/public/login');
        }
    }

}

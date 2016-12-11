<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of register
 *
 * @author weiss
 */
class register extends Controller
{

    public function index()
    {
        $this->setFehler('koRN');

        $this->view('home/index', 'register');
    }

    public function registrieren()
    {
        require_once '../app/models/DatenbankGamp.php';
        DatenbankGamp::register();
    }

    public function sectionInhalt()
    {
        require_once '../app/views/login/loginFormular.php';
    }

    public function stimmtNichtUeberein()
    {

        $this->setFehler('Passwort stimmt nicht überein!');
    }

    function fuck()
    {
        echo 'fu';
        $this->setFehler('dddd');
        $this->getFehler();
        $this->index();
    }

}

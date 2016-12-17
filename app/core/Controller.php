<?php

class Controller
{

    protected $fehler = '';
    protected bildhochladen


    public function index()
    {
        
        $this->view('home/index',$this);      
    }

    public function setCookieForStyle()
    {
        session_start();

        if (isset($_GET['stil']) && $_GET['stil'] == 2)
        {
            $_COOKIE['stil'] = 2;
            setcookie('stil', '2', time() + 3600);
        } else if (isset($_GET['stil']) && $_GET['stil'] == 1)
        {
            $_COOKIE['stil'] = 1;
            setcookie('stil', '1', time() + 3600);
        }
    }

    public function cookieSytle2CSS()
    {
        if (isset($_COOKIE['stil']) && $_COOKIE['stil'] == 2)
        {
            echo '<link type="text/css" rel="stylesheet" href="/mvc/public/style2.css">';
        }
    }

    public function loginHeader()
    {
        if (!isset($_SESSION['User']))
        {
            echo'<a href="login">Login</a><a href="register">Registrieren</a>';
        } else
        {
            echo'<a href="?logout=1">Logout!</a><p>Hallo ' . htmlspecialchars($_SESSION['User']) . '</p>';
        }
    }

    public function loginNAV()
    {
        if (isset($_SESSION['eingeloggt']) && $_SESSION['eingeloggt'] == 'ja' && !isset($_Get['logout']))
        {
            echo' <li><a href="?special=1">Special</a></li>';
        }
    }

    public function sectionInhalt()
    {
        echo 'Index-Seite';
    }

    protected function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view = 'home/index', $controller, $data = [])
    {
        $controller = new $controller;
        require_once '../app/views/' . $view . '.php';
    }

    function setFehler($fehler)
    {
        $this->fehler = $fehler;
    }

    function getFehler()
    {

        echo $this->fehler;
    }

}

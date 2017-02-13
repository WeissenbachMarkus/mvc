<?php

/**
 * Controller Elternklasse
 * verfügt über generelle Methoden
 */
abstract class Controller
{

    private $logger;

    public function __construct()
    {
        $this->setLogger();
    }

    protected function setFehler($message)
    {
        $this->startSession();
        $_SESSION['fehler'][] = $message;
    }

    protected function getFehlerBool()
    {
        return (!empty($_SESSION['fehler']));
    }

    protected function fehler()
    {
        $this->startSession();
        if (!empty($_SESSION['fehler']))
        {

            foreach ($_SESSION['fehler'] as $value)
                if (count($_SESSION['fehler']) > 1)
                    echo $value . '<br>';
                else
                    echo $value;

            unset($_SESSION['fehler']);
        }
    }

    protected function startSession()
    {
        if (!isset($_SESSION))
        {
            session_start();
        }
    }

    private function setLogger()
    {
        require_once '../app/core/Logger.php';
        $this->logger = new Logger('../app/logs/' . get_class($this) . '.txt');
    }

    protected function getLogger()
    {
        return $this->logger;
    }

    public function index()
    {
        $this->view($this, 'general/index');
    }

    protected function setCookieForStyle()
    {
        if (isset($_SESSION['stil']))
        {
            $this->startSession();
            $_COOKIE['stil'] = $_SESSION['stil'];
            setcookie('stil', $_SESSION['stil'], time() + 3600);
            unset($_SESSION['stil']);
        }
    }

    public function setStyle($stil)
    {
        $this->startSession();
        $_SESSION['stil'] = $stil;
        header('Location: http://localhost/mvc/public/' . get_class($this));
    }

    protected function cookieSytle2CSS()
    {
        if (isset($_COOKIE['stil']) && $_COOKIE['stil'] == 2)
        {
            echo '<link type="text/css" rel="stylesheet" href="../app/views/general/css/style2.css">';
        }
    }

    protected function loginHeader()
    {
        echo'<a href="' . get_class($this) . '/logout">Logout!</a><p>Hallo ' . htmlspecialchars($_SESSION['user']) . '</p>';
    }

    protected function navigation()
    {
        
    }

    protected function script()
    {
        echo '<script src="../app/views/general/cookie.js"></script>';
    }

    /**
     * bindet scripts ein
     * @param type $name: Name des scripts im erstellten 'script' Ordner
     */
    protected function setScript($name)
    {
        echo '<script src="../app/views/' . get_class($this) . '/script/' . $name . '.js"></script>';
    }

    /**
     * Inhalt der Section muss überschrieben werden
     */
    protected abstract function sectionInhalt();

    /**
     * Liefert Datenbankinstanz
     * @param type $model Name der Datenbank Klasse angeben
     * @return type Instanz der Datenbank
     */
    protected function getModel($model)
    {
        require_once '../app/models/' . $model . '.php';
        return $model::getDatabaseInstance($model);
    }

    /**
     * Wird verwendet um Templates zu laden
     * @param type $controllerChild muss null sein wenn kein Objekt 
     * erstellt werden soll, sonst Objektname uebergeben oder Referenz
     * @param type $view der Pfad zum Template ab dem Ordner "views"
     * @param type $data daten die übergeben werden sollen.
     */
    protected function view($controllerChild, $view = 'general/index', $data = [])
    {
        if ($controllerChild != null)
            $controller = new $controllerChild;

        require '../app/views/' . $view . '.php';
    }

    public function logout()
    {
        $this->startSession();
        unset($_SESSION['user']);
        header('Location: http://localhost/mvc/public/login');
    }

    protected function date()
    {
        $datum = date("Y");
        echo '&copy;Markus Weissenbach ' . $datum;
    }

    protected function css()
    {
        echo '<link type="text/css" rel="stylesheet" href="../app/views/general/css/responsive.css">
        <link type="text/css" rel="stylesheet" href="../app/views/general/css/style.css">';
    }

    protected function setCss($pfad = '/css/style.css')
    {
        echo '<link type="text/css" rel="stylesheet" href="../app/views/' . get_class($this) . $pfad . '">';
    }

    /**
     * Wird verwendet wenn Daten übergeben werden sollen
     * @param type $data
     */
    protected function setData($data)
    {
        $this->startSession();
        $_SESSION['data'] = $data;
    }

}

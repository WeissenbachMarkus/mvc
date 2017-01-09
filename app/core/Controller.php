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
        $this->startSession();

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

    protected function cookieSytle2CSS()
    {
        if (isset($_COOKIE['stil']) && $_COOKIE['stil'] == 2)
        {
            echo '<link type="text/css" rel="stylesheet" href="/mvc/public/style2.css">';
        }
    }

    protected function loginHeader()
    {
        echo'<a href="' . get_class($this) . '/logout">Logout!</a><p>Hallo ' . htmlspecialchars($_SESSION['user']) . '</p>';
    }

    protected function navigation()
    {
       
    }

    /**
     * Inhalt der Section muss überschrieben werden
     */
    protected abstract function sectionInhalt();

    /**
     * Lierfert Datenbankinstanz
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
     * @param type $controllerChild muss null sein wenn kein Objekt erstellt werden soll, sonst Objektname uebergeben oder Referenz
     * @param type $view der Pfad zum Template ab dem Ordner "views"
     * @param type $data daten die übergeben werden sollen.
     */
    public function view($controllerChild, $view = 'general/index', $data = [])
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

}

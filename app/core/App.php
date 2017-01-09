<?php

class App
{

    protected $controllerChild = 'login';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        session_start();

        $url = $this->parseUrl();
       
        if (isset($_SESSION['user']) || isset($url[1]) && $url[1] == 'verarbeitung')
        {

            if (file_exists('../app/controllers/' . $url[0] . '.php'))
            {
                $this->controllerChild = $url[0];
                unset($url[0]);
            } else
                header('Location: http://localhost/mvc/public/home');


            $this->setControllerChild();

            if (isset($url[1]))
            {
                if (method_exists($this->controllerChild, $url[1]))
                {
                    $this->method = $url[1];
                    unset($url[1]);
                } else
                    header('Location: http://localhost/mvc/public/home');
            }

            $this->params = $url ? array_values($url) : [];
        } elseif (!$this->urlIstLoginUrl($this->urlToString($url)))
            header('Location: http://localhost/mvc/public/login');
        else
            $this->setControllerChild();

        call_user_func_array([$this->controllerChild, $this->method], $this->params);
    }

    private function parseUrl()
    {

        if (isset($_GET['url']))
        {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }

    private function setControllerChild()
    {
        require_once '../app/controllers/' . $this->controllerChild . '.php';

        $this->controllerChild = new $this->controllerChild;
    }

    private function urlToString($url)
    {
        return implode('/', $url);
    }

    private function urlIstLoginUrl($urlString)
    {
        return preg_match('/^login$/', $urlString);
    }

}

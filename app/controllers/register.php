<?php

/**
 * Description of register
 *
 * @author weiss
 */
class register extends Controller
{

    public function sectionInhalt()
    {
        $this->view($this, 'register/registerFormular');
    }

    public function registrieren()
    {
        $this->informationProvided();
        $this->passwortIsTheSame();
        $this->passwortIsValid();

        if ($this->getFehlerBool())
        {
            header('Location: http://localhost/mvc/public/register');
            exit();
        }

        if (!isset($_POST['Admin']))
            $_POST['Admin'] = 0;

        $database = $this->getModel('Alexandertechnik');
        if ($database->registerRegistrieren($_POST['Nickname'], $_POST['Email'], $_POST['Passwort'], $_POST['Admin']))
        {
            $this->setValidData();
            header('Location: http://localhost/mvc/public/registrierungErfolgreich');
        } else
            header('Location: http://localhost/mvc/public/register');
    }

    private function informationProvided()
    {
        $error = false;
        foreach ($_POST as $key => $value)
        {
            if (empty($value))
            {
                $error = true;
                $this->setFehler('Bitte geben Sie im Bereich "' . $key . '" einen gueltigen Wert ein!');
            }
        }
    }

    private function passwortIsTheSame()
    {
        if ($_POST['Passwort'] != $_POST['Passwort2'])
            $this->setFehler('Passwort stimmt nicht überein!');
    }

    private function passwortIsValid()
    {
        if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/', $_POST['Passwort']))
            $this->setFehler('Passwort erfüllt nicht die Vorschriften!<br>Mind. 8 Zeichen aus Groß- und Kleinbuchstaben, Zahlen und Sonderzeichen!');
    }

    /**
     *  Schreibt die validierten Daten der Registration in ein Session
     * @param type $data Array
     */
    private function setValidData()
    {
        $this->startSession();
        foreach ($_POST as $key => $value)
        {
            if ($key != 'Passwort2')
            {
                if ($key == 'Admin')
                    if ($value == 1)
                        $value = 'Ja';
                    else
                        $value = 'Nein';
                $_SESSION['dataRegister'][$key] = $value;
            }
        }
    }

}

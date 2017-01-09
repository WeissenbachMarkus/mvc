<?php

/**
 * Description of Alexandertechnik
 *
 * @author markus
 */
class alexandertechnik extends Database
{

    protected function __construct()
    {
        parent::__construct();
        $this->setDatabaseconnection('127.0.0.1', 'user', 'user', 'alexandertechnik');
    }

    /**
     * Registration User
     * @param type $u_nickname
     * @param type $u_email
     * @param type $u_password
     * @return boolean true , false
     */
    public function registerRegistrieren($u_nickname, $u_email, $u_password,$admin)
    {

        $columnnames = array('u_nickname', 'u_email', 'u_password','u_admin');

        $values = array($u_nickname, $u_email, hash('sha256', $u_password),$admin);

        try
        {
            $this->generalInsertStatement('user', $columnnames, $values);
        } catch (Exception $ex)
        {
            $this->registerFehlerbehandlung($ex->getMessage());
            return false;
        }

        return true;
    }

    private function registerFehlerbehandlung($errorMessage)
    {
        if (preg_match('/Duplicate.*u_nickname_UNIQUE/', $errorMessage))
            $this->setFehler('Nickname ist bereits vorhanden!');
        if (preg_match('/Duplicate.*PRIMARY/', $errorMessage))
            $this->setFehler('Email bereits vorhanden!');
    }

    /**
     * Ueberprueft ob Email und Passwort in der Datenbank
     * vorhanden sind.
     * Setzt Fehler Message für User!
     * @return type false oder die gefundenen Daten
     */
    public function loginFindEmailAndPassword($email, $password)
    {
        return $this->generalSelectStatementWithCatchedException('user', array('u_nickname','u_email','u_password'),'where u_email=? and u_password=? and u_admin=1',array($email,hash('sha256',$password)));
    }

    /**
     * Findet eine Email in der Datenbank.
     * @param type $email
     */
    public function loginEmailVorhanden($email)
    {
        return $this->generalSelectStatementWithCatchedException('user', 'u_email', 'where u_email=?', $email);
    }
   
    public function userListAllUsers()
    {
        return $this->generalSelectStatementWithCatchedException('user', array('u_icon','u_nickname','u_email'));             
    }

}

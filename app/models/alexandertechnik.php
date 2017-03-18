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
        $this->setDatabaseconnection('127.0.0.1', 'root', '', 'alexandertechnik');
    }

    /**
     * Registration User
     * @param type $u_nickname
     * @param type $u_email
     * @param type $u_password
     * @return boolean true , false
     */
    public function registerRegistrieren($u_nickname, $u_email, $u_password, $admin)
    {

        $columnnames = array('u_nickname', 'u_email', 'u_password', 'u_admin');

        $values = array($u_nickname, $u_email, hash('sha256', $u_password), $admin);

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
        return $this->generalSelectStatementWithCatchedException('user', array('u_nickname', 'u_email', 'u_password'), 'where u_email=? and u_password=? and u_admin=1', array($email, hash('sha256', $password)));
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
        return $this->generalSelectStatementWithCatchedException('user', array('u_icon', 'u_nickname', 'u_email'));
    }

    public function statisticGetUser($nickname)
    {
        return $this->generalSelectStatementWithCatchedException('user', '*', 'where u_nickname= ?', $nickname);
    }

    public function modulAnlegenGetNames($name)
    {
        return $this->generalSelectStatementWithCatchedException('modul', 'm_name', 'where m_name=?', $name);
    }

    public function modulAnlegenSetModul($name, $icon = null, $finished = null, $showInProgess = null, $chargeable = null, $masterplan = null)
    {

        $columnnames = array('m_name', 'm_icon', 'm_finished', 'm_showInProgress', 'chargeable_c_id', 'masterplan_m_id');
        $values = array($name, $icon, $finished, $showInProgess, $chargeable, $masterplan);

        $this->killNullColumns($columnnames, $values);

        try
        {
            $this->generalInsertStatement('modul', $columnnames, $values);
        } catch (Exception $ex)
        {
            echo $ex->getMessage();
            return false;
        }

        return true;
    }

    public function modulAnlegenSetModulInhalt($position, $modulName, $text = null, $image = null, $audio = null, $video = null)
    {

        $columnnames = array('mc_position', 'Modul_m_name', 'mc_text', 'mc_image', 'mc_audio', 'mc_video');
        
        $values = array($position, $modulName, $text, $image, $audio, $video);

        $this->killNullColumns($columnnames, $values);

        try
        {
            $this->generalInsertStatement('modulcontent', $columnnames, $values);
        } catch (Exception $ex)
        {
            return $ex->getMessage();
        }

        return true;
    }

}

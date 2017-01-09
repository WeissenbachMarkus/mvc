<?php

/**
 * Aufgabe 6.2
 * macht Aufzeichnungen
 * @author markus
 */
class Logger
{


    private $dateipfad;

    public function __construct($dateipfad = '../app/core/log.txt')
    {
        $this->setDateipfad($dateipfad);
    }

    /**
     * ueberprueft das setzten des Dateipfades
     * @param type $dateipfad
     * @throws Exception
     */
    private function setDateipfad($dateipfad)
    {
        if (substr_count($dateipfad, '/') < substr_count($dateipfad, '\\'))
            $dateipfad = str_replace('\\', '/', $dateipfad);

        $directories = split('/', $dateipfad);

        $logdatei = $directories[count($directories) - 1];

        $dateipfad = substr($dateipfad, 0, -(strlen($logdatei)));


        if (is_dir($dateipfad))
        {
            $this->dateipfad = $dateipfad . $logdatei;
        } else
        {
            throw new Exception("Pfad: ".$dateipfad."existiert nicht!");
        }
    }

    /**
     * schreibt in Logdatei
     * @param type $message : Nachricht
     * @param type $loglevel : 0=Info 1=Warning 2=Error
     */
    public function logThis($message, $loglevel)
    {
        switch ($loglevel)
        {
            case 0:
                $loglevel = 'INFO';
                break;
            case 1:
                $loglevel = 'WARNING';
                break;
            case 2:
                $loglevel = 'ERROR';
                break;
        }

        if (file_exists($this->dateipfad))
            $logFile = fopen($this->getDateipfad(), 'a');
        else
            $logFile = fopen($this->getDateipfad(), 'w');

        $date = new DateTime();
        fwrite($logFile, date('Y-m-d H:i', $date->getTimestamp()) . "    " . $loglevel . "    " . $message . "\n");
        fclose($logFile);
    }

    public function getDateipfad()
    {
        return $this->dateipfad;
    }

}

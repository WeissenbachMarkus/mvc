<?php

/**
 * Aufgabe 6.2
 * macht Aufzeichnungen
 * @author markus
 */
class Logger
{

    private static $loggerInstanz;
    private $dateipfad;

    private function __construct($dateipfad = '../app/core/log.txt')
    {
        $this->setDateipfad($dateipfad);
    }

    /**
     * Singleton, wenn ein anderer Pfad angegeben wird, wird der alte überschrieben
     * @param type $dateipfad
     * @return type Logger
     */
    public static function getLogger($dateipfad = '../app/core/log.txt')
    {
        if (self::$loggerInstanz != null)
        {
            if ($dateipfad != self::$loggerInstanz->getDateipfad())
            {
                self::$loggerInstanz->setDateipfad($dateipfad);
            }
            return self::$loggerInstanz;
        } else
        {
            self::$loggerInstanz = new Logger($dateipfad);
            return self::$loggerInstanz;
        }
    }

    public function setDateipfad($dateipfad)
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
            throw new Exception("Pfad existiert nicht!");
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

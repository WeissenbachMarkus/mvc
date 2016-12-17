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
            new Logger($dateipfad);
        }
    }

    public function setDateipfad($dateipfad)
    {
        $directories = split('/', $dateipfad);

        $logdatei = $directories[count($directories) - 1];

        $dateipfad = substr($dateipfad, -(strlen($logdatei)));

        if (file_exists($dateipfad))
        {
            $this->dateipfad = $dateipfad.$logdatei;
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
                $loglevel = 'Info';
                break;
            case 1:
                $loglevel = 'Warning';
                break;
            case 2:
                $loglevel = 'Error';
                break;
        }

        $logFile = fopen($this->getDateipfad(), 'w');
        fwrite($logFile, $loglevel . ' ' . $message . '\n');
        fclose($logFile);
    }

    function getDateipfad()
    {
        return $this->dateipfad;
    }

}

<?php

/**
 * Abstracte Datenbankklasse.
 * Soll das erstellen weiterer Datenbanken
 * erleichtern und verfügt über generele Datenbank
 * Manipulationsmethoden.
 * Diese können innerhalb der Vererbungshierarchie verwendet werden
 * aber nicht darüber hinaus.
 *
 * @author markus
 */
abstract class Database
{

    protected static $databaseInstance;
    protected $databaseconnection;
    protected $logger;

    /**
     * Dient als Basis für einen Konstruktor
     * von Databaseklassen
     */
    protected function __construct()
    {
        require_once '../app/core/Logger.php';
        $this->logger = getLogger();
    }

    /**
     * Gibt Datenbankinstanz züruck
     * 
     * @param type $database  genwuenschte Datenbamk
     * @return type Datenbankinstanz
     */
    public function getDatabaseInstance($requestedDatabase)
    {
        if (!isset(self::$databaseInstance))
        {
            self::$databaseInstance = new $requestedDatabase;
        }
        return self::$databaseInstance;
    }

    /**
     *  Beim erstellen einer neuen Datenbank muss
     *  diese Methode im Konstruktor ausgeführt werden
     * 
     * @param type $host
     * @param type $user
     * @param type $password
     * @param type $database
     * @throws Exception
     */
    protected function setDatabaseconnection($host, $user, $password, $database)
    {
        $connection = new mysqli($host, $user, $password, $database);

        if ($connection->connect_error)
        {
            echo 'Connection failed: ' . $connection->connect_error;
            $this->logger->logThis('Connection failed: ' . $connection->connect_error, 2);
            throw new Exception('Connection failed: ' . $connection->connect_error);
        } else
        {
            echo 'Connection to ' . $database . ' successful!';
            $this->databaseconnection = $connection;
        }
    }

    public function getDatabaseconnection()
    {
        return $this->databaseconnection;
    }

    /**
     *  Mit diesem Logger können Fehler innerhalb der 
     *  Databaseklassen geloggt werden
     *  @return type gibt Logger-Instanz zurück
     */
    protected function getLogger()
    {
        return $this->logger;
    }

}

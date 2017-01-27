<?php

/**
 * Abstracte Datenbankklasse.
 * Soll das erstellen weiterer Datenbanken
 * erleichtern und verfügt über generele Datenbank
 * Manipulationsmethoden.
 * Diese können innerhalb der Vererbungshierarchie verwendet werden
 * aber nicht darüber hinaus.
 *
 * setLogger($pfad) und setDatabaseconnection() sollen in der Kind-Klasse
 * ausgefuehrt werden.
 * @author markus
 */
abstract class Database
{

    private static $databaseInstance;
    private $connectionData = [];
    private $logger;

    /**
     * Nachricht kann für den User gesetzt werden!
     * @param type $message
     */
    
    protected function __construct()
    {
        $this->setLogger();
    }
    protected function setFehler($message)
    {
        session_start();
        $_SESSION['fehler'][] = $message;
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
        array_push($this->connectionData, $host, $user, $password, $database);
    }

    private function setLogger()
    {
        require_once '../app/core/Logger.php';
        $this->logger = new Logger('../app/logs/'.get_class($this).'.txt');
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

    /**
     * Gibt Datenbankinstanz züruck
     * 
     * @param type $database  genwuenschte Datenbamk
     * @return type Datenbankinstanz
     */
    public static function getDatabaseInstance($requestedDatabase)
    {
        if (!isset(self::$databaseInstance))
        {
            self::$databaseInstance = new $requestedDatabase;
        }
        return self::$databaseInstance;
    }

    /**
     * Verbindet mit Datenbank.
     * Wenn dies nicht möglich ist wird Exception geworfen.
     * Fehler wird gesetzt.
     * @return \mysqli
     * @throws Exception
     */
    private function connectWithDatabaseFromArray()
    {

        $connection = new mysqli($this->connectionData[0], $this->connectionData[1], $this->connectionData[2], $this->connectionData[3]);
//todo ask about error
        if ($connection->connect_error)
        {

            $this->getLogger()->logThis('Connection failed: ' . $connection->connect_error, 2);
            $this->setFehler('Datenbankverbindung fehlgeschlagen!');
            throw new Exception('Connection failed: ' . $connection->connect_error);
        } else
        {
            //$this->getLogger()->logThis('Connenction to ' . $this->connectionData[3] . ' Successful!', 0);
            return $connection;
        }
    }

    /**
     * genereller Insert
     * wirft Exception
     * @param type $table
     * @param type $columnnames
     * @param type $values
     * @param mysqli $databaseconnection
     */
    protected function generalInsertStatement($table, $columnnames, $values)
    {

        /**
         * Gibt die benötigte Anzahl ? für das Statement zurück
         * @param type $count
         * @return type
         */
        function writeQuestionmarks($count)
        {
            for ($index = 0; $index < $count; $index++)
            {
                $string[] = '?';
            }

            return implode(',', $string);
        }

        //verbindet zur Datenbank
        $databaseconnection = $this->connectWithDatabaseFromArray();

        //generiert die erforderlichen Fragezeichen
        $questionmarks = writeQuestionmarks(count($columnnames));

        //Array Columnnames to String
        if (is_array($columnnames))
            $columnnames = implode(', ', $columnnames);


        //prepare statemant
        if (!$statement = $databaseconnection->prepare('Insert into ' . $table . ' (' . $columnnames . ') values (' . $questionmarks . ') '))
            throw new Exception('Prepare fehlgeschlagen !');

        //findet die typen zu den Werten
        $types = $this->findTypes($values);


        //stellt $types an erste Stelle
        if (!is_array($values))
            $values = array($values);

        array_unshift($values, $types);


        //call_user_func_array erwartet an erster Stelle einen String
        // und alle weiteren werte müssen referenzen sein
        for ($index = 0; $index < count($values); $index++)
        {
            if ($index != 0)
            {
                $handover[] = &$values[$index];
            } else
            {
                $handover[] = $values[$index];
            }
        }


        call_user_func_array(array($statement, 'bind_param'), $handover);

        if (!$statement->execute())
        {
            $this->getLogger()->logThis('Statement konnte nicht ausgefuehrt werden: ' . $statement->error, 2);
            throw new Exception('Statement konnte nicht ausgeführt werden: ' . $statement->error);
        }

        $statement->close();
        $databaseconnection->close();
    }

    /**
     * findet die Typen in dem übergebenen Array
     * liefert z.B: sis oder iis für integer, integer, string
     * @param type $values : Array aus Werten
     */
    private function findTypes($values)
    {
        $types = '';

        if (is_array($values))
            foreach ($values as $value)
            {
                $types.=gettype($value)[0];
            } else
            $types = gettype($values)[0];
        return $types;
    }

    /**
     * Wirft Exception!
     * Ein genereller Select.Preperad
     * Liefert ein Assoziatives Array der Ergebnisse oder false
     * @param type $table  Name der Tabelle
     * @param type $columnnames  Array aus Spaltennamen oder ein Spaltenname
     * @param type $condition zb where x=? and y=? hierbei muessen zwei $values 
     * uebergeben werden.
     * @return boolean
     */
   private function generalSelectStatement($table, $columnnames, $condition = '', $values = null)
    {
        $databaseconnection = $this->connectWithDatabaseFromArray();

        //Array Columnnames to String
        if (is_array($columnnames))
            $columnnames = implode(', ', $columnnames);

        //prepare statemant
        if (!$statement = $databaseconnection->prepare('SELECT ' . $columnnames . ' FROM ' . $table . ' ' . $condition))
        {
            $this->getLogger()->logThis('Prepare fehlgeschlagen!',2);
            throw new Exception('Prepare fehlgeschlagen!');
        }


        //Wenn Werte übergeben wurden müssen sie an die Parameter gebunden werden
        if ($values != null)
        {

            //findet die typen zu den Werten
            $types = $this->findTypes($values);

            //stellt $types an erste Stelle
            if (!is_array($values))
                $values = array($values);
            array_unshift($values, $types);

            //call_user_func_array erwartet an erster Stelle einen String
            // und alle weiteren werte müssen referenzen sein
            for ($index = 0; $index < count($values); $index++)
            {
                if ($index != 0)
                {
                    $handover[] = &$values[$index];
                } else
                {
                    $handover[] = $values[$index];
                }
            }


            call_user_func_array(array($statement, 'bind_param'), $handover);
        }

        if (!$statement->execute())
        {
            $this->getLogger()->logThis('Statement konnte nicht ausgefuehrt werden: ' . $statement->error, 2);
            throw new Exception('Statement konnte nicht ausgeführt werden: ' . $statement->error);
        }

        //$statement->bind_result($eventLogID,$ddfdf);
        // Throw an exception if the result metadata cannot be retrieved
        if (!$meta = $statement->result_metadata())
        {
            $this->getLogger()->logThis('Spalten (metadaten) konnten nicht geholt werden!', 2);
            throw new Exception('Spalten konnten nicht geholt werden: ' . $statement->error);
        }

        // The data array
        $data = array();

        // The references array
        $refs = array();

        // Iterate over the fields and set a reference
        while ($name = $meta->fetch_field())
        {
            $refs[] = &$data[$name->name];
        }

        // Free the metadata result
        $meta->free_result();

        // Throw an exception if the result cannot be bound
        if (!call_user_func_array(array($statement, 'bind_result'), $refs))
        {
            $this->getLogger()->logThis('Variablen konnten nicht an Resultate gebunden werden', 2);
            throw new Exception('Variablen konnten nicht an Resultate gebunden werden: ' . $stmt->error);
        }


        // Loop the results and fetch into an array
        $row = 0;
        $result = false;
        while ($statement->fetch())
        {

            foreach ($data as $key => $value)
            {
                $result[$row][$key] = $value;
            }
            $row++;
        }

        $statement->close();
        $databaseconnection->close();

        return $result;
    }

    /**
     * Exception gecatched!
     * Ein genereller Select.Preperad
     * Liefert ein Assoziatives Array der Ergebnisse oder false
     * @param type $table  Name der Tabelle
     * @param type $columnnames  Array aus Spaltennamen oder ein Spaltenname
     * @param type $condition z.B.: where x=? and y=? hierbei muessen zwei $values 
     * uebergeben werden.
     * @param type $values Werte fuer die Fragezeichen.
     * z.B.: 1 oder 'markus', bei Einzelwerten oder array(1,'markus') bei mehr Werten
     * @return boolean
     */
    protected function generalSelectStatementWithCatchedException($table, $columnnames, $condition = '', $values = null)
    {
        try
        {
            return $this->generalSelectStatement($table, $columnnames, $condition, $values);
        } catch (Exception $ex)
        {
            
            $this->setFehler('Fehler bei der Authentifizierung!');
            return false;
        }
    }

}

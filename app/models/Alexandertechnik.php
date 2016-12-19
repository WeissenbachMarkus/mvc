<?php

/**
 * Description of Alexandertechnik
 *
 * @author markus
 */

class Alexandertechnik extends Database
{
    private function __construct()
    {
        parent::__construct();
        $this->setDatabaseconnection('127.0.0.1', 'user', 'user', 'alexandertechnik');   
    }   
    
}




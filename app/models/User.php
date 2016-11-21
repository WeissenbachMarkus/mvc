<?php

class User{

    private $name='';
    
    function __construct()
    {
        
    }
    
    function getName()
    {
        return $this->name;
    }

    function setName($name)
    {
        $this->name = $name;
    }



}

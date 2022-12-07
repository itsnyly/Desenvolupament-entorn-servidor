<?php

class baseDades
{
    public $hostname;
    public $dbname;
    public $username;
    public $pw;

    public function __construct($hostname, $dbname, $username, $pw){
        $this -> hostname = $hostname;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->pw = $pw;
    }

   

}

?>
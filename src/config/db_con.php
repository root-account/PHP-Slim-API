<?php

class db_con
{
    // properties
    private $db_host = '';
    private $db_user = '';
    private $db_pass = '';
    private $db_name = '';

    public function connect()
    {
        $con_str = "mysql:host=$this->db_host;dbname=$this->db_name";
        $dbConnection = new PDO($con_str, $this->db_user, $this->db_pass);

        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $dbConnection;
    }

}

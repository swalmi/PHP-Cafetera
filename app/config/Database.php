<?php
class Database
{
    private $host = "127.0.0.1";
    private $db = "cafeteria_db";
    private $user = "root";
    private $pass = "root123";
    private $port = "3307";

    public function connect()
    {
        $conn = new PDO(
            "mysql:host=" .
                $this->host .
                ";port=" .
                $this->port .
                ";dbname=" .
                $this->db,
            $this->user,
            $this->pass,
        );
        return $conn;
    }
}

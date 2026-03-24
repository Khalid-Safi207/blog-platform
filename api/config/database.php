<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'blog_platform';
    private $username = 'root';
    private $password = '';

    public function connect_db(){
        try{
            $dsn = "mysql:hostname=".$this->host.";dbname=".$this->dbname;
            $db = new PDO($dsn,$this->username,$this->password);
            $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $db;
        }catch(PDOException $e){
            throw new Exception("Error In Database Connection");
        }
    }
}


?>
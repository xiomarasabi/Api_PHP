<?php
class Database{

    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'agrosoft';

    public $connect;

    public function getConnection(){
        $this->connect = null;
        try{
            $this->connect = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->user, $this->pass);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connect->exec('SET CHARACTER SET utf8');
        }catch(PDOException $e){
            die('Error de conexión: '.$e->getMessage());
        }
        return $this->connect;
    }
}
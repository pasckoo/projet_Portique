<?php

class Connexion_PDO{
    private $HOST = "mysql:host=localhost;dbname=gdcr;charset=UTF8";
    private $USER = "root";
    private $PASS = "root";
    public $CNX = null;
    
    public function __contruct(){
        try{
            $this->CNX = new PDO($this->HOST, $this->USER, $this->PASS );
            $this->CNX->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e){
        echo utf8_encode($e->getMessage());
        };
    }    
}

?>
<?php

class ConexionBD{
    
    static private $servername = "localhost";
    static private $username = "root";
    static private $dbname = "contab";

    //TODO: arreglar catch
    //TODO: por qué no hay que recargar
    public static function conectar() : PDO{

        try {
            $conn = new PDO("mysql:host=".self::$servername.";dbname=".self::$dbname, self::$username);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        return $conn;
    }
}
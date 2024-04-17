<?php

class ConexionBD{
    //TODO: una instancia
    
    static private $servername = "localhost";
    static private $username = "root";
    static private $dbname = "contab";

    //TODO: por qué no hay que recargar
    public static function connect() : PDO{
        try {
            $conn = new PDO("mysql:host=".self::$servername.";dbname=".self::$dbname, self::$username);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        return $conn;
    }

    public static function select(string $select, string $from, string $where, string $orderBy, string $orderHow){
        $connection = ConexionBD::connect();

        if ($from === '') return "Param error";
    
        if ($select === '') $select = '*';
        $query = "SELECT $select FROM $from ";
        if ($where !== '') $query .= "WHERE $where ";
        if ($orderBy !== ''){
            $query .= " ORDER BY $orderBy "; 
            $orderHow === 'desc' ? $query .= "DESC" : $query .= "ASC";
        }

        try{
            $stmt = $connection->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_NAMED);
            $data = $stmt->fetchAll();
        } catch(PDOException $e){
            die($e);
        }

        return $data;
    }
}
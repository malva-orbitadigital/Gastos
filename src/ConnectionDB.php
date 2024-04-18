<?php

class ConnectionDB{

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

    // TODO adaptar join
    public static function select(string $select, string $table, string $join, string $where, string $orderBy, string $orderHow) : array{
        $connection = ConnectionDB::connect();

        if ($table === '') return "Param error";
    
        if ($select === '') $select = '*';
        $query = "SELECT $select FROM $table ";
        if (!empty($join)) $query .= $join." ";
        if (!empty($where)) $query .= "WHERE $where ";
        if (!empty($orderBy)){
            $query .= " ORDER BY $orderBy "; 
            $orderHow === 'desc' ? $query .= "DESC" : $query .= "ASC";
        }
        
        try{
            $stmt = $connection->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_NAMED);
            $data = $stmt->fetchAll();
        } catch(PDOException $e){
            $data = ['error' => $e->getMessage()];
        }

        return $data;
    }

    static function insert(string $table, array $columns, array $values){
        $connection = ConnectionDB::connect();

        if ($table === '' || empty($values)) return "Param error";

        $query = "INSERT INTO $table ";
        if (!empty($columns)) $query .= "(".implode(',', $columns).") ";
        $query .= "VALUES ('".implode("','", $values)."')";

        try {
            $stmt = $connection->prepare($query);
            return $stmt->execute();            
        } catch (PDOException $e){
            die($e);
        }
    }

    static function update(string $table, array $set, string $where){
        $connection = ConnectionDB::connect();

        if ($table === '' || empty($set)) return "Param error";

        $query = "UPDATE $table SET ";

        $d = [];
        foreach ($set as $column => $value){
            $d[] = $column." = '".$value."' ";
        }

        $query .= implode(',', $d);

        if (!empty($where)) $query .= " WHERE ".$where;

        try {
            $stmt = $connection->prepare($query);
            return $stmt->execute();            
        } catch (PDOException $e){
            die($e);
        }
    }

    static function delete(string $table, string $where){
        if (empty($table) || empty($where)) return "Param error";

        $connection = ConnectionDB::connect();

        try {
            $stmt = $connection->prepare("DELETE FROM $table WHERE $where");
            return $stmt->execute();            
        } catch (PDOException $e){
            die($e);
        }
    }

    static function getTotalRegister(string $table){
        $datos = self::select("count(*) as total", $table, "", "", "", "");
        return $datos[0]['total'] ?? 0;
    }

}
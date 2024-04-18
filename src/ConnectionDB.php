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

    public static function select(string $select, string $from, string $where, string $orderBy, string $orderHow){
        $connection = ConnectionDB::connect();

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
        $keys = array_keys($set);
        $last_key = end($keys);
        foreach ($set as $column => $value){
            $query .= $column." = '".$value."' ";
            if ($column !== $last_key) $query.=", ";
        }
        if (!empty($where)) $query .= " WHERE ".$where;

        try {
            $stmt = $connection->prepare($query);
            return $stmt->execute();            
        } catch (PDOException $e){
            die($e);
        }
    }

    static function delete(string $table, string $where){
        $connection = ConnectionDB::connect();
        
        if (empty($table) || empty($where)) return "Param error";

        $query = "DELETE FROM $table WHERE $where";

        try {
            $stmt = $connection->prepare($query);
            return $stmt->execute();            
        } catch (PDOException $e){
            die($e);
        }
    }

}
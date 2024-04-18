<?php

class ConnectionDB{

    static private $servername = "localhost";
    static private $username = "root";
    static private $dbname = "contab";

    //TODO: por qué no hay que recargar

    /**
     * Connects to database
     * 
     * @return PDO
     */
    public static function connect() : PDO{
        try {
            $conn = new PDO("mysql:host=".self::$servername.";dbname=".self::$dbname, self::$username);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        return $conn;
    }

    /**
     * Executes a select
     * 
     * @param string $select columns to select (empty selects all columns)
     * @param string $table 
     * @param string $join join statement/s
     * @param string $where posible conditions
     * @param string $orderBy posible column to order by
     * @param string $orderHow asc/desc
     * 
     * @return array query in an associative array
     */
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

    /**
     * Inserts into table
     * 
     * @param string $table
     * @param array $columns
     * @param array $values
     * 
     * @return bool|array
     */
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
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Updates a column from a table
     * 
     * @param string $table
     * @param array $update columns with the new values
     * @param string $where condition
     * 
     * @return bool|array
     */
    static function update(string $table, array $update, string $where){
        $connection = ConnectionDB::connect();

        if ($table === '' || empty($update)) return "Param error";

        $query = "UPDATE $table SET ";

        $d = [];
        foreach ($update as $column => $value){
            $d[] = $column." = '".$value."' ";
        }

        $query .= implode(',', $d);

        if (!empty($where)) $query .= " WHERE ".$where;

        try {
            $stmt = $connection->prepare($query);
            return $stmt->execute();            
        } catch (PDOException $e){
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Deteles a column
     * 
     * @param string $table
     * @param string $where condition 
     * 
     */
    static function delete(string $table, string $where) {
        if (empty($table) || empty($where)) return "Param error";

        $connection = ConnectionDB::connect();

        try {
            return $connection->exec("DELETE FROM $table WHERE $where");
        } catch (PDOException $e){
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Executes a select count(*) of a table
     * 
     * @param string $table
     * 
     * @return int 
     */
    static function getTotalRegister(string $table) : int{
        $datos = self::select("count(*) as total", $table, "", "", "", "");
        return $datos[0]['total'] ?? 0;
    }

}
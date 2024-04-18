<?php
include_once 'ConnectionDB.php';

class Category {

    private static $table = "categorias";
    
    /**
     * Get one category
     *
     * @param int $id
     * 
     * @return array
     */
    static public function getCategory(int $id) : array{
        return ConnectionDB::select("", self::$table, "", "id = ".$id, "", "");
    }

    /**
     * @param string $select columns to select (empty selects all columns)
     * @param string $join join statement/s
     * @param string $where posible conditions
     * @param string $orderBy posible column to order by
     * @param string $orderHow asc/desc
     * 
     * @return array query in an associative array
     */
    static public function getCategories(string $select, string $join, string $where, string $orderBy, string $orderHow) : array{
        $datos = ConnectionDB::select($select, self::$table, $join, $where, $orderBy, $orderHow);
        return $datos;
    }

    /**
     * Creates a table with the categories
     * 
     * @param array $data
     * 
     * @return string code html of the table
     */
    static public function showCategories($data){
        $html = '<table class="table"><thead><tr>';

        if (empty($data)) return "No hay categorías";
        
        foreach($data[0] as $head => $value){
            $html .= $head !== 'id' ? "<th scope='col'>".ucfirst($head)."</th>" : "";
        }
        $html .= "<th scope='col'></th><th scope='col'></th>";
        $html .= '</tr></thead>';
        $html .= '<tbody>';
        foreach($data as $row){
            $html .= "<tr>";
            $keys = array_keys($row);
            $last_key = end($keys);
            foreach($row as $name => $col){
                if ($name == 'id'){
                    continue;
                }
                $html .= "<td>".ucfirst($col)."</td>";
                if ($name === $last_key){
                    $html .= "<td><a href='CRUDcategories.php?id=".$row['id']."'
                    class='btn btn-outline-secondary'>Modificar</a></td>
                    <td><a href='CRUDcategories.php?id=".$row['id']."&action=delete'
                    class='btn btn-outline-danger'>Eliminar</a></td>";
                } 
                //TODO: generalizar botones
            }
            $html .= "</tr>";
        }
        $html .= '</tbody></table>';
        return $html;
    }

    /**
     * @param string $name
     * @param string $descripcion
     * 
     * @return 
     */
    public static function addCategory(string $name, string $description) : bool{
        return ConnectionDB::insert("categorias", ["nombre", "descripcion"], 
        compact('name', 'description'));
    }

    /**
     * @param string $name
     * @param string $descripcion
     * @param string $id
     * 
     * @return 
     */
    public static function updateCategory(string $name, string $description, int $id) : bool{
        return ConnectionDB::update("categorias",
        ["nombre"=>$name, "descripcion"=>$description], "id = $id");
    }

    /**
     * @param integer $id
     * 
     * @return 
     */
    public static function deleteCategory(int $id) {
        return ConnectionDB::delete(self::$table, "id = $id");
    }

}
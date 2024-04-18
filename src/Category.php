<?php
include_once 'ConnectionDB.php';

class Category {

    private static $table = "categorias";
    
    /**
     * Get category
     *
     * @param int $id
     * 
     * @return array
     */
    static public function getCategory(int $id) : array{
        return ConnectionDB::select("", self::$table, "", "id = ".$id, "", "");
    }

    static public function getCategories(string $select, string $from, string $where, string $orderBy, string $orderHow) : array{
        $datos = ConnectionDB::select($select, $from, "", $where, $orderBy, $orderHow);
        return $datos;
    }

    static public function showCategories(){
        $html = '<table class="table"><thead><tr>';
        $data = self::getCategories("", "categorias", "", "", "");

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
                    $html .= "<td><a href='categories.php?id=".$row['id']."'
                    class='btn btn-outline-secondary'>Modificar</a></td>
                    <td><a href='categories.php?id=".$row['id']."&action=delete'
                    class='btn btn-outline-danger'>Eliminar</a></td>";
                } 
            }
            $html .= "</tr>";
        }
        $html .= '</tbody></table>';
        return $html;
    }

    public static function addCategory(string $name, string $description) : bool{
        return ConnectionDB::insert("categorias", ["nombre", "descripcion"], 
        compact('name', 'description'));
    }

    public static function updateCategory(string $name, string $description, int $id) : bool{
        return ConnectionDB::update("categorias",
        ["nombre"=>$name, "descripcion"=>$description], "id = $id");
    }

    public static function deleteCategory(int $id) {
        return ConnectionDB::delete(self::$table, "id = $id");
    }

}
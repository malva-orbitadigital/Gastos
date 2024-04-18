<?php
include_once 'ConnectionDB.php';

class Category {
    
    static public function getCategories(string $select, string $from, string $where, string $orderBy, string $orderHow) : array{
        $datos = ConnectionDB::select($select, $from, $where, $orderBy, $orderHow);
        return $datos;
    }

    static public function showCategories(){
        $html = '<table class="table"><thead><tr>';
        $data = self::getCategories("", "categorias", "", "", "");
        
        foreach($data[0] as $head => $value){
            $html .= $head !== 'id' ? "<th scope='col'>".ucfirst($head)."</th>" : "";
        }
        $html .= "<th scope='col'></th>";
        $html .= '</tr></thead>';
        $html .= '<tbody>';
        foreach($data as $row){
            $html .= "<tr>";
            $keys = array_keys($row);
            $last_key = end($keys);
            foreach($row as $name => $col){
                if ($name !== 'id'){
                    $html .= "<td>".ucfirst($col)."</td>";
                    if ($name === $last_key){
                        $html .= "<td><a href='categories.php?id=".$row['id']."'
                        class='btn btn-outline-secondary'>Modificar</a></td>";
                    } 
                }
            }
            $html .= "</tr>";
        }
        $html .= '</tbody></table>';
        return $html;
    }

    public static function addCategory(string $name, string $description) : array{
        return ConnectionDB::insert("categorias", ["nombre", "descripcion"], 
        compact('name', 'description')) ? 
        ["text" => "La categoría se ha añadido correctamente", "bgcolor" => "success"] : 
        ["text" => "No se ha podido añadir la categoría", "bgcolor" => "danger"];
    }

    public static function updateCategory(string $name, string $description, int $id) : array{
        return ConnectionDB::update("categorias",
        ["nombre"=>$name, "descripcion"=>$description], "id LIKE $id") ? 
        ["text" => "La categoría se ha modificado correctamente", "bgcolor" => "success"] : 
        ["text" => "No se ha podido modificar la categoría", "bgcolor" => "danger"];
    }

}
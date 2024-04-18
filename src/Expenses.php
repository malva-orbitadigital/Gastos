<?php
include_once 'ConnectionDB.php';

class Expenses {

    static private $table = 'gastos';

    static public function getNumExpenses() : int{
        $datos = ConnectionDB::select("count(*)", self::$table, "", "", "");
        return $datos[0]['count(*)'];
    }


    static public function getExpense($id) {
        $data = ConnectionDB::select("fecha, importe, ".self::$table.".descripcion, categorias.nombre as categoria", 
        self::$table." inner join categorias on ".self::$table.".categoria = categorias.id", self::$table.".id LIKE $id", "", "");
        return $data[0];
    }
   
        
    //TODO: paginación
    //TODO: documentacion
    static function showExpenses(string $select, string $from, string $where, string $orderBy, string $orderHow, bool $buttons) : string{
        $html = '<table class="table"><thead><tr>';
        $data = ConnectionDB::select($select, $from, $where, $orderBy, $orderHow);
        
        if (count($data) === 0){
            return "No hay resultados";
        }
        
        foreach($data[0] as $head => $value){
            $html .= $head !== 'id' ? "<th scope='col'>".ucfirst($head)."</th>" : "";
        }
        $html .= $buttons ? "<th scope='col'></th><th scope='col'></th>" : "";
        $html .= '</tr></thead>';
        $html .= '<tbody>';
        foreach($data as $row){
            $html .= "<tr>";
            foreach($row as $name => $col){
                if ($name === 'id'){
                    if ($buttons){
                        $html .= "<td><a href='modifyExpense.php?id=$col'
                        class='btn btn-outline-secondary'>Modificar</a></td>
                        <td><a href='listExpenses.php?id=$col' class='btn btn-outline-danger'>Eliminar</a></td>";
                    }
                } else if ($name === 'fecha'){
                    $html .= "<td>".self::dateFormat($col)."</td>";
                } else if($name === 'importe'){
                    $html .= "<td>".$col."€</td>";
                } else {
                    $html .= "<td>".ucfirst($col)."</td>";
                }
            }
            $html .= "</tr>";
        }
        $html .= '</tbody></table>';
        return $html;
    }

    public static function showTotal(){
        return "<div class='m-5 text-center fs-4'><strong>Total</strong>: ".
        number_format(self::getTotal(), 2). "€</div>";
    }

    public static function addExpense (string $date, float $quantity, string $description, string $category) : array{
        return ConnectionDB::insert(self::$table, ["fecha", "importe", "descripcion", "categoria"], 
        compact('date', 'quantity', 'description', 'category')) ? 
        ["text" => "La anotación se ha añadido correctamente", "bgcolor" => "success"] : 
        ["text" => "No se ha podido añadir la anotación", "bgcolor" => "danger"];
    }

    static function updateExpense(string $date, float $quantity, string $description, string $category, int $id) : array{
        return ConnectionDB::update(self::$table,
        ["fecha"=>$date, "importe"=>$quantity, "descripcion"=>$description, "categoria"=>$category], self::$table.".id LIKE $id") ? 
        ["text" => "La anotación se ha modificado correctamente", "bgcolor" => "success"] : 
        ["text" => "No se ha podido modificar la anotación", "bgcolor" => "danger"];
    }

    static function deleteExpense(int $id){
        return ConnectionDB::delete(self::$table, "id LIKE $id") ? 
        ["text" => "La anotación se ha eliminado correctamente", "bgcolor" => "success"] : 
        ["text" => "No se ha podido eliminar la anotación", "bgcolor" => "danger"];
    }

    private static function getTotal() : float{
        return ConnectionDB::select('sum(importe) as total',self::$table,'','','')[0]['total'];
    }

    static function dateFormat(string $date){
        $aux = array_reverse(explode('-', $date));
        return implode('-', $aux);
    }

}
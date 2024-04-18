<?php
include_once 'ConexionBD.php';

class Expenses {


    static public function getNumExpenses() : int{
        $datos = ConexionBD::select("count(*)", "gastos", "", "", "");
        return $datos[0]['count(*)'];
    }


    static public function getExpense($id) {
        $data = ConexionBD::select("fecha, importe, gastos.descripcion, categorias.nombre as categoria", 
        "gastos inner join categorias on gastos.categoria = categorias.id", "gastos.id LIKE $id", "", "");
        return $data[0];
    }
   
        
    //TODO: añadir total
    //TODO: paginación
    //TODO: documentacion
    //TODO: delete
    static function showExpenses(string $select, string $from, string $where, string $orderBy, string $orderHow) : string{
        $html = '<table class="table"><thead><tr>';
        $data = ConexionBD::select($select, $from, $where, $orderBy, $orderHow);
        
        if (count($data) === 0){
            return "No hay resultados";
        }
        
        foreach($data[0] as $head => $value){
            $html .= $head !== 'id' ? "<th scope='col'>".ucfirst($head)."</th>" : "";
        }
        $html .= "<th scope='col'></th>";
        $html .= '</tr></thead>';
        $html .= '<tbody>';
        foreach($data as $row){
            $html .= "<tr>";
            foreach($row as $name => $col){
                if ($name === 'id'){
                    $html .= "<td><a href='modifyExpense.php?id=$col'
                    class='btn btn-outline-secondary'>Modificar</a></td>";
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

    public static function addExpense (string $date, float $quantity, string $description, string $category) : array{
        return ConexionBD::insert("gastos", ["fecha", "importe", "descripcion", "categoria"], 
        compact('date', 'quantity', 'description', 'category')) ? 
        ["text" => "La anotación se ha añadido correctamente", "bgcolor" => "success"] : 
        ["text" => "No se ha podido añadir la anotación", "bgcolor" => "danger"];
    }

    static function updateExpense(string $date, float $quantity, string $description, string $category, int $id) : array{
        return ConexionBD::update("gastos",
        ["fecha"=>$date, "importe"=>$quantity, "descripcion"=>$description, "categoria"=>$category], "gastos.id LIKE $id") ? 
        ["text" => "La anotación se ha modificado correctamente", "bgcolor" => "success"] : 
        ["text" => "No se ha podido modificar la anotación", "bgcolor" => "danger"];
    }

    static function dateFormat(string $date){
        $aux = array_reverse(explode('-', $date));
        return implode('-', $aux);
    }

}
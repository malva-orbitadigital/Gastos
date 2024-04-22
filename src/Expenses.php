<?php
include_once 'ConnectionDB.php';

class Expenses {

    static private $table = 'gastos';

    /**
     * Get number of expenses
     *
     * @return int
     */
    static public function getNumExpenses() : int{
        return ConnectionDB::getTotalRegister(self::$table);
    }

    /**
     * Get data of expenses
     * 
     * @param string $orderBy posible column to order by
     * @param string $orderHow asc/desc
     * 
     * @return array query in an associative array
     */
    static public function get(string $where = '', string $orderBy = "fecha", string $orderHow = "desc", int $limit, int $page) : array{
        $data = self::getExpenses("fecha, gastos.descripcion, importe, categorias.nombre as categoria, gastos.id", "gastos inner join categorias on gastos.categoria = categorias.id", $where, $orderBy, $orderHow, $limit, $page);
        return $data;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    static public function getExpense(int $id) : array{
        $data = ConnectionDB::select("fecha, importe, ".self::$table.".descripcion, c.nombre as categoria", 
        self::$table, " inner join categorias AS c on ".self::$table.".categoria = c.id", self::$table.".id = $id", "", "" ,0,0);
        return $data[0] ?? []; // TODO falta algo respecto a la funcion ConnectionDB::select
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
    static public function getExpenses(string $select, string $join, string $where, string $orderBy, string $orderHow, int $limit, int $page) : array{
        $datos = ConnectionDB::select($select, self::$table, $join, $where, $orderBy, $orderHow, $limit, $page);
        return $datos;
    }
   
    /**
     * Creates a table with the expenses
     * 
     * @param array $data
     * @param boolean $actions whether to create buttons or not
     * 
     * @param string $select 
     */
    static function showExpenses(array $data, bool $actions) : string{
        // TODO en el front (fecha arriba y abajo) y back orderBy y orderWay (detectar con js el cambio: existen 3 arriba abajo y por defecto)
        if (count($data) === 0){
            return '<div class="text-center alert alert-secondary" role="alert">No hay resultados</div>';
        }
        
        $html = "<p id='error' class='d-none bg-danger text-center text-white mt-5 p-3'></p>";
        $html .= '<table class="table"><thead><tr>';
        foreach($data[0] as $head => $value){
            $html .= $head !== 'id' ? "<th scope='col'>".ucfirst($head)."</th>" : "";
        }
        $html .= $actions ? "<th scope='col'></th><th scope='col'></th>" : "";
        $html .= '</tr></thead>';
        $html .= '<tbody>';
        foreach($data as $row){
            $html .= "<tr id=".$row['id'].">";
            $buttons = "<td><a href='modifyExpense.php?id=".$row['id']."'
                class='btn btn-outline-secondary'>Modificar</a></td>
                <td><button id=".$row['id']." class='deleteBtn btn btn-outline-danger'>Eliminar</button></td>";
            foreach($row as $name => $col){
                if ($name !== 'id'){       
                    switch($name){
                        case 'fecha':
                            $html .= "<td>".self::dateFormat($col)."</td>";
                            break;
                        case 'importe':
                            $html .= "<td>".$col."€</td>";
                            break;
                        case 'descripcion':
                            $html .= "<td style='max-width:10px; overflow:overlay'>$col</td>";
                            break;
                        default:
                            $html .= "<td>".ucfirst($col)."</td>";
                    }
                }
            }
            if ($actions) $html .= $buttons;

            $html .= "</tr>";
        }
        $html .= '</tbody></table>';
        return $html;
    }

    /**
     * @return string html for total
     */
    public static function showTotal() : string{
        $total = self::getTotal();
        if ($total == 0){
            return "";
        }
        return "<div id='total' class='m-5 text-center fs-4'><strong>Total</strong>: ".
        number_format($total, 2). "€</div>";
    }

    /**
     * @param string $date
     * @param float $quantity
     * @param string $descripcion
     * @param integer $category
     * 
     * @return array
     */
    public static function addExpense (string $date, float $quantity, string $description, string $category) : array{
        return ConnectionDB::insert(self::$table, ["fecha", "importe", "descripcion", "categoria"], 
        compact('date', 'quantity', 'description', 'category')) ? 
        ["text" => "La anotación se ha añadido correctamente", "bgcolor" => "success"] : 
        ["text" => "No se ha podido añadir la anotación", "bgcolor" => "danger"];
    }

    /**
     * @param string $date
     * @param float $quantity
     * @param string $descripcion
     * @param integer $category
     * @param integer $id
     * 
     * @return array
     */
    static function updateExpense(string $date, float $quantity, string $description, string $category, int $id) : array{
        return ConnectionDB::update(self::$table,
        ["fecha"=>$date, "importe"=>$quantity, "descripcion"=>$description, "categoria"=>$category], self::$table.".id LIKE $id") ? 
        ["text" => "La anotación se ha modificado correctamente", "bgcolor" => "success"] : 
        ["text" => "No se ha podido modificar la anotación", "bgcolor" => "danger"];
    }
    
    /**
     * @param integer $id
     * 
     * @return 
     */
    static function deleteExpense(int $id){
        if(ConnectionDB::delete(self::$table, "id LIKE $id")){
            return true;
        }

        return false;
    }

    /**
     * Calculates the total of expenses
     * 
     * @return float
     */
    public static function getTotal() : float{
        return ConnectionDB::select('sum(importe) as total',self::$table, '','','','',0,0)[0]['total'] ?? 0;
    }
    
    /**
     * @param string $date in format YYYY-MM-DD
     * 
     * @return string date in format DD-MM-YYYY
     */
    static function dateFormat(string $date): string{
        $aux = array_reverse(explode('-', $date));
        return implode('-', $aux);
    }

}
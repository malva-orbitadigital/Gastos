<?php
include_once 'ConexionBD.php';

class Gastos {


    static public function getNumGastos() : int{
        $datos = ConexionBD::select("count(*)", "gastos", "", "", "");
        return $datos[0]['count(*)'];
    }


    //TODO: revisar posible error

    static function insertGasto(string $date, float $quantity, string $description, string $category){
        try {
            $connection = ConexionBD::connect();
            $sql = ("INSERT INTO gastos (fecha, importe, descripcion, categoria)
                    VALUES ('$date', '$quantity', '$description', '$category')");
            $result = $connection->exec($sql);
            // if ($result === false) throw new Exception
            return ["text" => "Anotación añadida correctamente", "bgcolor" => "success"];
        } catch (PDOException $e){
            echo $e;
            return ["text" => "No se ha podido añadir la anotación", "bgcolor" => "danger"];
        }
    }

    static function updateGasto(string $date, float $quantity, string $description, string $category, int $id){
        try {
            $connection = ConexionBD::connect();
            $sql = "UPDATE gastos 
                    SET fecha='$date', importe='$quantity', descripcion='$description', categoria='$category'
                    WHERE id='$id'";
            $connection->exec($sql);
            return ["text" => "Anotación modificada correctamente", "bgcolor" => "success"];
        } catch (PDOException $e){
            return ["text" => "No se ha podido modificar la anotación", "bgcolor" => "danger"];
        }
    }

        
    //TODO: añadir total
    //TODO: paginación
    //TODO: documentacion
    //TODO: delete
    static function mostrarLista(string $select, string $from, string $where, string $orderBy, string $orderHow) : string{
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
                if ($name !== 'id'){
                    if ($name === 'fecha'){
                        $html .= "<td>".dateFormat($col)."</td>";
                    } else if($name === 'importe'){
                        $html .= "<td>".$col."€</td>";
                    } else {
                        $html .= "<td>$col</td>";
                    }
                } else {
                    $html .= "<td><a href='modificar.php?id=$col'
                    class='btn btn-outline-secondary'>Modificar</a></td>";
                }
            }
            $html .= "</tr>";
        }
        $html .= '</tbody></table>';
        return $html;
    }
}
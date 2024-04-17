<?php
include_once 'ConexionBD.php';

class Gastos {


    //TODO: revisar posible error

    static function insertGasto(string $date, float $quantity, string $description, string $category){
        try {
            $connection = ConexionBD::conectar();
            $sql = ("INSERT INTO gastos (fecha, importe, descripcion, categoria)
                    VALUES ('$date', '$quantity', '$description', '$category')");
            $connection->exec($sql);
            return ["text" => "Anotación añadida correctamente", "bgcolor" => "success"];
        } catch (PDOException $e){
            echo $e;
            return ["text" => "No se ha podido añadir la anotación", "bgcolor" => "danger"];
        }
    }

    static function updateGasto(string $date, float $quantity, string $description, string $category, int $id){
        try {
            $connection = ConexionBD::conectar();
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
    //TODO: return
    //TODO: documentacion
    //TODO: clases
    //TODO: delete
    static function mostrarLista(string $query){
        $categories = ['fecha' => 'Fecha', 'descripcion' => 'Descripción', 'importe' => 'Importe', 'categoria' => 'Categoría'];
        echo '<table class="table">';
        echo '<thead><tr>';
        $connection = ConexionBD::conectar();
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_NAMED);
        $data = $stmt->fetchAll();
        foreach($data[0] as $category => $value){
            echo $category !== 'id' ? "<th scope='col'>".$categories[$category]."</th>" : "";
        }
        echo "<th scope='col'></th>";
        echo '</tr></thead>';
        echo '<tbody>';
        foreach($data as $row){
            echo "<tr>";
            foreach($row as $name => $col){
                echo $name !== 'id' ? 
                    $name === 'fecha' ? "<td>".dateFormat($col)."</td>" : "<td>$col</td>" 
                : "<td><a href='modificar.php?id=$col'
                class='btn btn-outline-secondary'>Modificar</a></td>";
            }
            echo "</tr>";
        }
        echo '</tbody></table>';
    }
}
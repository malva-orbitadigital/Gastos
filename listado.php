<?php
include_once 'connection.php';
include_once 'inc_cabecera.php';
include_once 'inc_pie.php';
?>

<div class="mt-5">
    <table class="table m-3">
    <thead>
        <tr>
            <th scope="col">Fecha</th>
            <th scope="col">Importe</th>
            <th scope="col">Descripción</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $conexion = conectar();
        $stmt = $conexion->prepare("SELECT fecha, importe, descripcion FROM gastos ORDER BY fecha DESC");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach($stmt->fetchAll() as $row){
            echo "<tr>";
            foreach($row as $col){
                echo "<td>$col</td>";
            }
            echo "</tr>";
        }
        ?>
    </tbody>
    </table>
</div>
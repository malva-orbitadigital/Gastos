<?php
include_once 'connection.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="menu.js"></script>
    <title>Document</title>
</head>
<body>
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
            $stmt = $conn->prepare("SELECT fecha, importe, descripcion FROM gastos ORDER BY fecha DESC");
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
        <button id="volver" class="btn btn-primary m-3">Volver al menú</button>
    </div>
</body>
</html>
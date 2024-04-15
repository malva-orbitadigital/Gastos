<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Gestor de gastos</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Gastos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link" href="buscar.php">Buscar</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="listado.php">Listado</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="nuevo.php">Nuevo</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>

<?php
function conectar() : PDO{
    $servername = "localhost";
    $username = "root";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=contab", $username);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
    return $conn;
}


function mostrarLista(string $query){
    $categories = ['fecha' => 'Fecha', 'descripcion' => 'Descripción', 'importe' => 'Importe', 'categoria' => 'Categoría'];
    echo '<table class="table">';
    echo '<thead><tr>';
    $connection = conectar();
    $stmt = $connection->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_NAMED);
    $data = $stmt->fetchAll();
    foreach($data[0] as $category => $value){
        echo "<th scope='col'>".$categories[$category]."</th>";
    }
    echo '</tr></thead>';
    echo '<tbody>';
    foreach($data as $row){
        echo "<tr>";
        foreach($row as $col){
            echo "<td>$col</td>";
        }
        echo "</tr>";
    }
    echo '</tbody></table>';
}
?>
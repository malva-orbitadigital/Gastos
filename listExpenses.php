<?php
include_once 'inc_cabecera.php';
include_once 'inc_pie.php';
?>

<div class="mt-5">
<?php
    echo Expenses::showExpenses("fecha, descripcion, importe, categorias.nombre as categoria, gastos.id", 
    "gastos inner join categorias on gastos.categoria = categorias.id",
    "", "fecha", "desc");
?>
</div>
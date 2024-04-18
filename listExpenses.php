<?php
include_once 'inc_cabecera.php';
include_once 'inc_pie.php';

function showList(){
    echo Expenses::showExpenses("fecha, gastos.descripcion, importe, categorias.nombre as categoria, gastos.id", 
    "gastos inner join categorias on gastos.categoria = categorias.id",
    "", "fecha", "desc", true);
    echo Expenses::showTotal();
}

echo '<div class="mt-5">';

    if (isset($_GET['id']) && is_numeric($_GET['id'])){
        $result = Expenses::deleteExpense($_GET['id']);

        echo isset($result) ? "
        <p class='bg-".$result['bgcolor']." text-center text-white mt-5 p-3'>".$result['text']."</p>
        " : "";
    }
    showList();
echo "</div>";
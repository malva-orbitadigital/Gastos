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

    if (isset($_GET['id'])){
        if (!is_numeric($_GET['id'])){
            $result = false;
        } else {
            $result = Expenses::deleteExpense($_GET['id']);
        }

        echo !$result ? "
        <p class='bg-danger text-center text-white mt-5 p-3'>'No se ha podido eliminar la anotación'</p>" : "";
    }
    showList();
echo "</div>";
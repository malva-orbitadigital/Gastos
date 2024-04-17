<?php
include_once 'inc_cabecera.php';
include_once 'inc_pie.php';
?>

<div class="mt-5">
<?php
    echo Gastos::mostrarLista("fecha, descripcion, importe, categoria", "gastos", "", "fecha", "desc");
?>
</div>
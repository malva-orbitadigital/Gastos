<?php
include_once 'inc_cabecera.php';
include_once 'inc_pie.php';
?>

<div class="mt-5">
<?php
mostrarLista("SELECT fecha, importe, descripcion FROM gastos ORDER BY fecha DESC");
?>
</div>
<?php
include_once 'inc_cabecera.php';
include_once 'inc_pie.php';
?>

<div class="text-center mt-5">
    <h3>Bienvenido a mi contabilidad doméstica.</h3>
    <p>Actualmente hay 
        <?php 
        $total = Gastos::getNumGastos();
        echo $total;
        ?>
        anotaciones.</p>
</div>
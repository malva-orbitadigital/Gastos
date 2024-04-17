<?php
include_once 'inc_cabecera.php';
include_once 'inc_pie.php';
?>

<div class="mt-5 ">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="input-group w-50 m-3">
            <input name="busqueda" type="text" class="form-control" placeholder="Descripción..."
            value="<?php echo isset($_POST['busqueda']) ? $_POST['busqueda'] : "" ?>">
            <button class="btn btn-outline-secondary" type="submit" id="buscar">Buscar</button>
        </div>
    </form>
    <?php
    if (isset($_POST['busqueda'])){
        $input = $_POST['busqueda'];
        echo Gastos::mostrarLista("fecha, importe, id", "gastos", "descripcion LIKE '%$input%'", "fecha", "desc");
    }
    ?>
</div>
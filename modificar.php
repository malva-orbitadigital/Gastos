<?php
include_once 'inc_cabecera.php';
include_once 'inc_pie.php';

if (!isset($_GET['id'])){
    die('<div class="alert">No se ha podido encontrar la anotación</div>');
}

if (isset($_POST['save'])){
    $date = $_POST['date'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    updateDB($date, $quantity, $description, $category, $_GET['id']);
    header('Location: listado.php');
}
?>

<div class="m-5">
    <h3 class="text-center mb-3">Modificar anotación</h3>
    <form method="post" action="" class="col-6 offset-3 ">
        <div class="mb-3">
            <label for="date" class="form-label">Fecha</label>
            <input name="date" type="date" value="<?php echo $_GET['fecha']; ?>" class="form-control" id="date" required>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Importe</label>
            <input name="quantity" type="number" step="any" min=0 value="<?php echo $_GET['importe']; ?>" class="form-control" id="quantity" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" class="form-control" rows="3" id="description"><?php echo $_GET['descripcion']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Categoría</label>
            <select id="category" name="category" class="form-select" required>
                <option value="">Selecciona una categoría...</option>
                <?php
                foreach ($categories as $category => $name){
                    echo "<option value=$category ";
                    echo $category === $_GET['categoria'] ? "selected" : "";
                    echo ">$name</option>";
                }
                ?>
            </select>
        </div>
        <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
        <button name="save" type="submit" class="btn btn-primary">Modificar</button>
    </form>
</div>
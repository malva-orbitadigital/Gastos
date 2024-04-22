<?php
include_once 'inc_cabecera.php';
include_once 'inc_pie.php';


if (isset($_POST['save'])){
    $result = Expenses::updateExpense((string)$_POST['date'], (string)$_POST['quantity'], (string)$_POST['description'], 
    (string)$_POST['category'], (int)$_GET['id']);
} else {
    unset($result);
}

$data = Expenses::getExpense($_GET['id']);
// var_dump($data);

$rand=rand();
$_SESSION['rand']=$rand;

echo isset($result) ? "
<p class='bg-".$result['bgcolor']." text-center text-white mt-5 p-3'>".$result['text']."</p>
" : "";
?>

<div class="m-5">
    <h3 class="text-center mb-3">Modificar anotación</h3>
    <form method="post" action="" class="col-6 offset-3 ">
        <div class="mb-3">
            <label for="date" class="form-label">Fecha</label>
            <input name="date" type="date" value="<?php echo $data['fecha']; ?>" class="form-control" id="date" required>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Importe</label>
            <input name="quantity" type="number" step="any" min=0 value="<?php echo $data['importe']; ?>" class="form-control" id="quantity" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" class="form-control" rows="3" id="description"><?php echo $data['descripcion']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Categoría</label>
            <select id="category" name="category" class="form-select" required>
                <option value="">Selecciona una categoría...</option>
                <?php
                foreach (Categories::getCategories("", "categorias", "", "", "") as $category){
                    echo "<option value=".$category['id'];
                    echo $category['nombre'] === $data['categoria'] ? " selected>" : ">";
                    echo ucfirst($category['nombre'])."</option>";
                }
                ?>
            </select>
        </div>
        <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
        <button name="save" type="submit" class="btn btn-primary">Modificar</button>
    </form>
</div>

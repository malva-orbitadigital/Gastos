<?php
include_once 'inc_cabecera.php';
include_once 'inc_pie.php';
session_start();

$save = true;

if (isset($_POST['save']) && $_POST['randcheck']==$_SESSION['rand']){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $saved = Category::addCategory($name, $description);
    $save = true;
} else if(isset($_POST['modify'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];    
    $saved = Category::updateCategory($name, $description, $_GET['id']);
    $data = Category::getCategories("", "categorias", "id LIKE ".$_GET['id'], "", "")[0];
    $save = false;
} else {
    unset($saved);
}

if (isset($_GET['id'])){
    $data = Category::getCategories("", "categorias", "id LIKE ".$_GET['id'], "", "")[0];
    $save = false;
} 

$rand=rand();
$_SESSION['rand']=$rand;

echo isset($saved) ? "
<p class='bg-".$saved['bgcolor']." text-center text-white mt-5 p-3'>".$saved['text']."</p>
" : "";

echo Category::showCategories();

?>

<div class="m-5">
    <h3 class="text-center mb-3"><?php echo $save ? "Añadir categoría" : "Editar categoría"?></h3>
    <form method="post" action="" class="col-6 offset-3 ">
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input name="name"value="<?php echo isset($_GET['id']) ? $data['nombre'] : ""; ?>" type="text" class="form-control" id="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" class="form-control" rows="3" id="description"><?php echo isset($_GET['id']) ? $data['descripcion'] : ""; ?></textarea>
        </div>
        <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
        <?php
            echo $save ? '<button name="save" type="submit" class="btn btn-primary">Guardar</button>'
            : '<button name="modify" type="submit" class="btn btn-primary">Actualizar</button>
            <a href="categories.php" class="mt-5 btn btn-primary mb-5">Nueva categoría</a>';
        ?>
    </form>
</div>
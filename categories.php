<?php
include_once 'inc_cabecera.php';
include_once 'inc_pie.php';
include_once 'showTable.php';
session_start();

$save = true;
$page = (int) ($_GET['page'] ?? 1);
$limit = 2; // TODO selector [10, 15, 20, 25]

if (isset($_POST['save']) && $_POST['randcheck']==$_SESSION['rand']){
    if (!Categories::addCategory($_POST['name'], $_POST['description']))
        $alert = 'No se ha podido añadir la categoría';
} else if(isset($_POST['modify'])) {
    if(!Categories::updateCategory((string)$_POST['name'], (string)$_POST['description'], (int)$_GET['id']))
        $alert = "No se ha podido modificar la categoría";
    $save = false;
}

if (isset($_GET['id'])){ // MODIFY
    $data = Categories::getCategory($_GET['id'])[0];
    $save = false;
}

$data = Categories::getCategories('','','','','',$limit,$page);

$rand=rand();
$_SESSION['rand']=$rand;


echo "<h3 class='text-center m-3'>Categorías</h3>";
    showList($page, $limit, 'Categories', $data);
// echo Categories::showCategories($categories);
echo "<hr class='m-5'/>";

if (isset($alert)){
    echo "<p class='bg-danger text-center text-white mt-5 p-3'>$alert</p>";
}
?>

<div class="m-5">
    <h3 class="text-center mb-3"><?php echo $save ? "Añadir categoría" : "Editar categoría"?></h3>
    <form method="post" action="" class="col-6 offset-3 ">
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input name="name"value="<?php echo isset($_GET['id']) && !isset($_GET['action']) ? $data['nombre'] : ""; ?>" type="text" class="form-control" id="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" class="form-control" rows="3" id="description"><?php echo isset($_GET['id']) 
            && !isset($_GET['action']) ? $data['descripcion'] : ""; ?></textarea>
        </div>
        <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
        <?php
            echo $save ? '<button name="save" type="submit" class="btn btn-primary">Guardar</button>'
            : '<button name="modify" type="submit" class="btn btn-primary">Actualizar</button>
            <a href="categories.php" class="mt-5 btn btn-primary mb-5">Nueva categoría</a>';
        ?>
    </form>
</div>

<script>
    $(function(){
        $(".deleteBtn").on("click", (e) => {
            let id = e.currentTarget.id;
            let action = 'deleteCategory'
            $.ajax({
                url: './apiService.php',
                data: {id, action},
                dataType: 'json',
                method: 'POST'
                }
            ).done(function(a) {
                console.log(a)
                if (a){
                    $(`#${id}`).remove();
                }
            })
        })    
    })
</script>
<?php
include_once 'inc_cabecera.php';
include_once 'inc_pie.php';
session_start();

$categories = ['ocio'=>'Ocio', 'trabajo'=>'Trabajo', 'telefono'=>'Teléfono', 'compra'=>'Compra',
                'alquiler'=>'Alquiler', 'otro'=>'Otro'];


function insertDB(string $date, string $quantity, string $description, string $category){
    try {
        $connection = conectar();
        $sql = ("INSERT INTO gastos 
                VALUES ('$date', '$quantity', '$description', '$category')");
        $connection->exec($sql);
        return ["text" => "Anotación añadida correctamente", "bgcolor" => "success"];
    } catch (PDOException $e){
        return ["text" => "No se ha podido añadir la anotación", "bgcolor" => "danger"];
    }
}

if (isset($_POST['save']) && $_POST['randcheck']==$_SESSION['rand']){
    $date = $_POST['date'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $saved = insertDB($date, $quantity, $description, $category);
} else {
    unset($saved);
}

    $rand=rand();
    $_SESSION['rand']=$rand;




    echo isset($saved) ? "
    <p class='bg-".$saved['bgcolor']." text-center text-white mt-5 p-3'>".$saved['text']."</p>
    " : "";
    ?>

<div class="m-5">
    <h3 class="text-center mb-3">Nueva anotación</h3>
    <form method="post" action="" class="col-6 offset-3 ">
        <div class="mb-3">
            <label for="date" class="form-label">Fecha</label>
            <input name="date" type="date" class="form-control" id="date" required>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Importe</label>
            <input name="quantity" type="text" class="form-control" id="quantity" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" class="form-control" rows="3" id="description"></textarea>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Categoría</label>
            <select id="category" name="category" class="form-select" required>
                <option value="">Selecciona una categoría...</option>
                <?php
                foreach ($categories as $category => $name){
                    echo "<option value=$category>$name</option>";
                }
                ?>
            </select>
        </div>
        <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
        <button name="save" type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
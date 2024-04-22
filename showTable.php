<?php
function showList(int $page, int $limit, string $table){
    $data = $table::get("","","",$limit, $page);

    if (isset($data['error'])) die('<div class="alert bg-danger text-white text-center">No se ha podido cargar la tabla</div>');
    
    $numPages = (int) ceil(call_user_func("$table::getNum$table")/$limit);

    echo call_user_func("$table::show$table", $data, true);

    echo method_exists($table, "showTotal") ? $table::showTotal() : "";

    echo "<a href='$table.php?page=".$page-1 ."' class='btn btn-light";
    echo $page <= 1 ? " disabled'" : "'";
    echo "'>Anterior</a>";
    echo "<a href='$table.php?page=". $page+1 ."' class='btn btn-light";
    echo $page >= $numPages ? " disabled'" : "'";
    echo "'>Siguiente</a>";

    echo "<select class='form-select w-25 mt-4'>
    <option value=''>Número de paginación</option>
    <option value='5'>5</option>
    <option value='10'>10</option>
    <option value='15'>15</option>
    <option value='20'>20</option>
    </select>";
}
?>

<script>
    $(function(){
        
    })
</script>
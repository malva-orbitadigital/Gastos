<?php
include_once 'inc_cabecera.php';
include_once 'inc_pie.php';

function showList(){
    $data = Expenses::getExpenses("fecha, gastos.descripcion, importe, categorias.nombre as categoria, gastos.id", 
    "gastos inner join categorias on gastos.categoria = categorias.id",
    "", "fecha", "desc");
    echo Expenses::showExpenses($data, true);
    echo Expenses::showTotal();
}


echo '<div class="mt-5">';
    showList($page, $limit);
echo "</div>";
?>

<script>
    $(function(){
        $(".deleteBtn").on("click", (e) => {
            let id = e.currentTarget.id;
            let action = 'deleteExpense'
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
                    updateTotal();
                } else {
                    $('#error').text('No se ha podido eliminar la anotación');
                    $('#error').removeClass('d-none');
                }
            })

            function updateTotal(){
                $.ajax({
                    url: './apiService.php',
                    data: {action: 'getTotal'},
                    dataType: 'json'
                    }
                ).done(function(a) {
                    console.log(a)
                    $('#total').html(a['html']);
                })
            }
        })    
    })
</script>
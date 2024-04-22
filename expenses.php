<?php
include_once 'inc_cabecera.php';
include_once 'inc_pie.php';
include_once 'showTable.php';
// ? Todos los TODO se haran en angular cuando se haga esto mismo en angular.

$page = (int) ($_GET['page'] ?? 1);
$limit = 2; // TODO selector [10, 15, 20, 25]
$data = Expenses::getExpenses("fecha, gastos.descripcion, importe, categorias.nombre as categoria, gastos.id", "gastos inner join categorias on gastos.categoria = categorias.id", "", "fecha", "desc", $limit, $page);

echo '<div class="mt-5">';
    showList($page, $limit, 'Expenses', $data);
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
                    $('#error').addClass('d-none');
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
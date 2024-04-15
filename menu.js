$(function(){
    $(".btn").on('click', function(){
        window.location.replace($(this).attr('id') + ".php");
    })

    $("#volver").on('click', function(){
        window.location.replace("index.php");
    })
})
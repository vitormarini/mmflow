<?php 
/**
 * Programa que verifica a conexão com o usuário, se ainda está permanente
 * Author: Vitor Hugo Marini
 * Data: 27/06/2021
 */
    //Verifica login do usuário
if(!isset($_SESSION["autoriza"])){
    session_destroy();
    $bd->Close();
?>

    <script language="javascript" type="text/javascript" charset="UTF-8">
        alert('Você não tem permissão para acessar esse arquivo.');
        window.location.href = "../mmflow/";
    </script>

<?php }
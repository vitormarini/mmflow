<?php
/**
 * Validação que o usuário está ou não Conectado, para não inativar a tela.
 * Data: 02/07/2021
 * Author: Vitor Hugo Marini
 */
session_start();
include( "./_conect.php" );

if ( !isset( $_SESSION['user_id'] ) ) {
    print json_encode([
           "status"   => "ERRO",
           "mensagem" => utf8_encode( "Já não está mais conectado" )
            ]);
}
else {
    $objOperador = $bd->Execute( "SELECT user_id FROM t_user  WHERE ( user_id = {$_SESSION['user_id']} )" );
    print json_encode([
           "status"   => "OK",
           "mensagem" => utf8_encode( "Ainda conectado, tudo normal" )
            ]);
}
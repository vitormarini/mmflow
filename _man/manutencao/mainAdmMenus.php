<?php
/* Descrição: Back-End adm_menus.php
 * Author: Vitor Hugo Marini
 * Data: 27/06/2021
 */

include_once '../../_conection/_conect.php';
include_once '../../_man/aux.php';

session_start();


$op    = $_SESSION['op'];          //Ação
$p     = $_SESSION['p'];           //Página da Busca
$r     = $_SESSION['tela_atual'];  //Tela Atual
$b     = $_SESSION['buscas'];      //Filtros de buscas
$id    = $_SESSION['id'];      //Filtros de buscas
$dados = $_POST;
$retorno = "ERRO";


#INSERT
if ( $op == "insert" ){
    $sql = "INSERT INTO t_menu ( menu_descricao, menu_url, menu_icon ) VALUES ( '{$dados['menu_descricao']}', '{$dados['menu_url']}', '{$dados['menu_icone']}' );";
}

else if ( $op == "edit" ){
   $sql = "UPDATE t_menu SET menu_descricao = '{$dados['menu_descricao']}', 
                             menu_url       = '{$dados['menu_url']}',
                             menu_icon      = '{$dados['menu_icone']}' WHERE menu_id = {$id};"; 
}


if ( $bd->Execute(replaceEmptyFields($sql)) ){
    $retorno = "OK";
    
    #Modificando o Session
    $_SESSION['op'] = $_SESSION['id'] = "";        
}

print $retorno;
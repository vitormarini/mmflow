<?php
/* Descrição: Back-End adm_submenus.php
 * Author: Vitor Hugo Marini
 * Data: 27/06/2021
 */

include_once '../../_conection/_conect.php';
include_once '../../_man/_aux.php';

session_start();


$op    = $_SESSION['op'];          //Ação
$p     = $_SESSION['p'];           //Página da Busca
$r     = $_SESSION['tela_atual'];  //Tela Atual
$b     = $_SESSION['buscas'];      //Filtros de buscas
$id    = $_SESSION['id'];          //ID da tabela
$dados = $_POST;
$retorno = "ERRO";

#INSERT
if ( $op == "insert" ){
    $sql = "INSERT INTO t_menu_sub ( menu_id                , menu_submenu_categoria                , menu_submenu_descricao                , menu_submenu_url               , menu_submenu_icon ) 
                            VALUES ( '{$dados['menu_id']}'  , '{$dados['menu_submenu_categoria']}'  , '{$dados['menu_submenu_descricao']}'  , '{$dados['menu_submenu_url']}' , '{$dados['menu_submenu_icon']}' );";
}

else if ( $op == "edit" ){
   $sql = "UPDATE t_menu_sub SET    menu_id                    = '{$dados['menu_id']}', 
                                    menu_submenu_categoria     = '{$dados['menu_submenu_categoria']}',
                                    menu_submenu_descricao     = '{$dados['menu_submenu_descricao']}',
                                    menu_submenu_url           = '{$dados['menu_submenu_url']}',
                                    menu_submenu_icon          = '{$dados['menu_submenu_icon']}'
                                             WHERE menu_sub_id =  {$id};
            UPDATE user_permission SET id_menu = '{$dados['menu_id']}' WHERE id_item = {$id};";
 
}


if ( $bd->Execute(replaceEmptyFields($sql)) ){
    $retorno = "OK";
    
    #Modificando o Session
    $_SESSION['op'] = $_SESSION['id'] = "";        
}

print $retorno;
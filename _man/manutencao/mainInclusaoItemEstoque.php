<?php
/* Descrição: Back-End adm_empresas.php
 * Author: Vitor Hugo Marini
 * Data: 26/07/2021
 */

include_once '../../_conection/_conect.php';
include_once '../../_man/aux.php';

session_start();

$op    = $_SESSION['op'];          //Ação
$p     = $_SESSION['p'];           //Página da Busca
$r     = $_SESSION['tela_atual'];  //Tela Atual
$b     = $_SESSION['buscas'];      //Filtros de buscas
$id    = $_SESSION['id'];          //Filtros de buscas
$dados = $_POST;
$retorno = "ERRO";
$_SESSION['aba'] = "";

#Validando os campos do Endereço
$tipo                   = trim($_POST['tipo']);
$item_id                = trim($_POST['item_pedido_item_id']);
$valor_unitario         = trim($_POST['item_pedido_valor_unitario']);
$quantidade             = trim($_POST['item_pedido_quantidade']);
$valor_total            = trim($_POST['item_pedido_valor_total']);
$data_registro          = trim($_POST['data_registro']);

#INSERT
if ( $_POST['type'] == "novo" ){
    $sql = "INSERT INTO public.movimentacao_item 
                    (tipo_entrada   , e_s               , valor_unitario                 , quantidade    , valor_total   , codigo_barras               
                ,   id_item_produto , data_registro     , numero_documento)
            VALUES ('$tipo'        , 'E'                , moedabanco('$valor_unitario')   , $quantidade   , $valor_total  , '{$_POST['codigo_barras']}'
                ,   $item_id        , '$data_registro'  , '{$_POST['numero_registro']}');";
}

else if ($_POST['type'] == "delete" ){

    $sql = "DELETE FROM public.movimentacao_item WHERE  id_movimentacao_item = '{$_POST['id_movim']}';";
}

if ( $bd->Execute(replaceEmptyFields($sql)) ){
    $retorno = "OK";                  
}

print $retorno;
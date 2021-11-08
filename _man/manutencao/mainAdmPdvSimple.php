<?php
/* Descrição: Back-End adm_empresas.php
 * Author: Vitor Hugo Marini
 * Data: 02/07/2021
 */

include_once '../../_conection/_conect.php';
include_once '../../_man/_aux.php';

session_start();


$op    = $_SESSION['op'];          //Ação
$p     = $_SESSION['p'];           //Página da Busca
$r     = $_SESSION['tela_atual'];  //Tela Atual
$b     = $_SESSION['buscas'];      //Filtros de buscas
$id    = $_SESSION['id'];          //Filtros de buscas
$dados = $_POST;
$retorno = "ERRO";
$_SESSION['aba'] = "";


#Validando os dados Cadastrais
$pedido_data_abertura        = $_POST['data_abertura'];
$participante_id             = str_replace(array("."," ","/","-"),"",$_POST['pedido_cliente_id']);
$pedido_situacao             = $_POST['pedido_situacao'];

#Validando os campos do Endereço
$item_pedido_tabela_preco   = trim($_POST['item_pedido_tabela_preco']);
$item_pedido_item_id        = trim($_POST['item_pedido_item_id']);
$item_pedido_valor_unitario = trim($_POST['item_pedido_valor_unitario']);
$item_pedido_quantidade     = trim($_POST['item_pedido_quantidade']);
$item_pedido_valor_desconto = trim($_POST['item_pedido_valor_desconto']);
$item_pedido_valor_total    = trim($_POST['item_pedido_valor_total']);

#INSERT
if ( $op == "insert" ){
    $sql = "INSERT INTO public.t_pedido_simples (
                            pedido_simples_data_abertura    ,  pedido_simples_situacao      , participante_id) 
                     VALUES('$pedido_data_abertura'         , '$pedido_situacao'            , '$participante_id' );";
}

else if ( $op == "edit" ){

    if ( $_POST['op'] == "item_pedido" ){

        $_SESSION['aba'] = "aba-pedido-item";

        if ( $_POST['type'] == "novo" ){

            $sql = 
            "INSERT INTO public.t_item_pedido 
                      (item_pedido_produto_id                       , item_pedido_tabela_preco                , item_pedido_valor_unitario                 , item_pedido_quantidade
                    ,  item_pedido_valor_desconto                   , item_pedido_valor_total, pedido_simples_id) 
                VALUES('$item_pedido_item_id'                       , '$item_pedido_tabela_preco'              , moedabanco('$item_pedido_valor_unitario') , '$item_pedido_quantidade'
                    ,  moedabanco('$item_pedido_valor_desconto')    , '$item_pedido_valor_total', '{$id}');
            ";

        }
        if ( $_POST['type'] == "delete" ){

            $sql = "DELETE FROM public.t_item_pedido WHERE  item_pedido_id = '{$_POST['id_movim']}';";

        }

    }else{
        #Modificando o Session
        $_SESSION['op'] = $_SESSION['id'] = "";  

        $sql = "UPDATE t_pedido_simples SET  pedido_simples_data_abertura            =  '$pedido_data_abertura'
                                            ,   pedido_simples_situacao                 =  '$pedido_situacao'
                                            ,   participante_id                         =  '$participante_id'
                                    WHERE pedido_simples_id                           =   {$id};"; 
    }
}

// print"<pre>";
// print($sql);
// exit;

if ( $bd->Execute(replaceEmptyFields($sql)) ){
    $retorno = "OK";                  
}

print $retorno;
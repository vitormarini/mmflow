<?php
/* Descrição: Back-End adm_users.php
 * Author: Vitor Hugo Marini
 * Data: 03/07/2021
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


#Validando os dados Cadastrais
$cfop_codigo    = trim($_POST['cfop_codigo']);
$cfop_descricao = trim($_POST['cfop_descricao']);
$cfop_tipo      = trim($_POST['cfop_tipo']);

#INSERT
if ( $op == "insert" ){
    $sql = "
        INSERT INTO t_cfop 
            ( cfop_codigo        ,	cfop_descricao    , cfop_tipo) 
        VALUES(  '$cfop_codigo'  ,	'$cfop_descricao' , '$cfop_tipo');";
}

else if ( $op == "edit" ){   
        $sql  = "   UPDATE  t_cfop 
                    SET cfop_codigo       =   '$cfop_codigo'
                        , cfop_descricao  =   '$cfop_descricao'
                        , cfop_tipo       =   '$cfop_tipo'
                    WHERE cfop_id         =   {$id};"; 
                   
}

else if ( $op == "delete" ){
    $sql = "
        DELETE FROM t_cfop WHERE cfop_id = {$id};";    
}

if ( $bd->Execute(replaceEmptyFields($sql)) ){
    $retorno = "OK";
    
    //Trantando essa excessão para não modificar a página
    if ( !isset($_POST["exception"]) && $_POST['exception'] !== "update_permissoes" ){    
        #Modificando o Session
        $_SESSION['op'] = $_SESSION['id'] = "";        
    }
}

print $retorno;
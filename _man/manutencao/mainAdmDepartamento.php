<?php
/* Descrição: Back-End adm_departamentos.php
 * Author: Vitor Hugo Marini
 * Data: 25/02/2022
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
$dpto_nome              = trim($_POST['dpto_nome']);
$dpto_descricao         = trim($_POST['dpto_descricao']);
$dpto_ativo             = trim($_POST['dpto_ativo']);
#INSERT
if ( $op == "insert" ){
    $sql = "INSERT INTO public.t_departamentos (
                            	dpto_nome           ,	dpto_descricao      , dpto_ativo) 
                     VALUES(    '$dpto_nome'        ,	'$dpto_descricao'   , '$dpto_ativo');";
}

else if ( $op == "edit" ){   
    
    
    if ( isset($_POST["exception"]) && $_POST['exception'] == "update_permissoes" ){
        
        #Eliminamos os itens vinculados a esse menue a esse usuário;
        $sqlDrop = "DELETE FROM user_permission WHERE id_user = '{$id}' AND id_menu = '{$_POST['id_menu']}' AND categoria = '{$_POST['categoria']}';";
        
        
        if ( $bd->Execute($sqlDrop) ){
            
            //Monta o array
            $itensInsert = explode(",",$_POST['arrId']);
            
            foreach ($itensInsert as $item){ $sql .= "INSERT INTO user_permission ( id_item, id_user, id_menu,categoria ) VALUES ('{$item}', '{$id}', '{$_POST['id_menu']}','{$_POST['categoria']}');"; }                      
            
        }
        
    }else{
          
        $sql .= " UPDATE t_departamentos SET  dpto_nome           =   '$dpto_nome'
                             ,	dpto_descricao       =   '$dpto_descricao'
                             ,	dpto_ativo       =   '$dpto_ativo'
                               WHERE dpto_id             =   {$id};"; 
    }                          
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
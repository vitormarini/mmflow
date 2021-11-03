<?php
/* Descrição: Back-End adm_users.php
 * Author: Vitor Hugo Marini
 * Data: 03/07/2021
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


#Validando os dados Cadastrais
$user_nome              = trim($_POST['user_nome']);
$user_nickname          = trim($_POST['user_nickname']);
$user_dt_nascimento     = trim($_POST['user_dt_nascimento']);
$user_tipo              = trim($_POST['user_tipo']);
$user_email             = trim($_POST['user_email']);
$user_celular           = trim($_POST['user_celular']);

#INSERT
if ( $op == "insert" ){
    $sql = "INSERT INTO public.t_user (
                            	user_nome           ,	user_nickname       ,	user_dt_nascimento 
                        ,	user_tipo           ,	user_email          ,	user_celular    ) 
                     VALUES(    '$user_nome'        ,	'$user_nickname'    ,	'$user_dt_nascimento'
                        ,	'$user_tipo'        ,	'$user_email'       ,	'$user_celular');";
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
          
        $sql .= " UPDATE t_user SET  user_nome           =   '$user_nome'
                             ,	user_nickname       =   '$user_nickname'
                             ,	user_dt_nascimento  =   '$user_dt_nascimento' 
                             ,	user_tipo           =   '$user_tipo' 
                             ,	user_email          =   '$user_email' 
                             ,	user_celular        =   '$user_celular'
                               WHERE user_id             =   {$id};"; 
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
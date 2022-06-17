<?php
/**
 * Programa responsável por efetuar o Login de cada usuário, dar início menu
 * Autor: Vitor Hugo Nunes Marini
 * Data: 25/06/2021
 */
include_once "../_conection/_conect.php";
include_once "./_aux.php";

$pass = md5($_POST['pass']);
$user = $_POST['op'] == "troca_empresa" ? retiraAcentos($_SESSION['user_nickname']) : retiraAcentos($_POST['user']);
$and  = $_POST['op'] == "troca_empresa" ? "" : "AND   user_pass = '{$pass}'";
$cnpj = retira_caracteres($_POST['cnpj']);

$data = $bd->Execute($sql = 
"SELECT user_id 
,	user_nome 
,	user_email 
,	user_tipo 
,	user_nickname 
,	1 AS login
 FROM 	t_user moda
WHERE 	( user_nickname ILIKE '{$user}' OR user_email = '{$user}' )
    --AND ( empresa_cnpj = '{$cnpj}' )
  {$and};");
  
//  print "<pre>"; print $sql; 
//  exit;

//Valida a inserção do usuário e verificando se existe ou não o valor
if ( $data->fields['login'] == 1){
    
    session_start();
    
    $_SESSION['user_id']        = $data->fields['user_id'];
    $_SESSION['user_nome']      = $data->fields['user_nome'];
    $_SESSION['user_email']     = $data->fields['user_email'];
    $_SESSION['user_tipo']      = $data->fields['user_tipo'];
    $_SESSION['user_nickname']  = $data->fields['user_nickname'];      
    $_SESSION['tela_atual']     = "VAZIO";    
    $_SESSION['menu_atual']     = "";    
    $_SESSION['submenu_atual']  = "";    
    $_SESSION['op']             = "";    
    $_SESSION['id']             = "";    
    $_SESSION['buscas']         = "";    
    $_SESSION['p']              = "1";    //Página da movimentação da Linha
    $_SESSION['autoriza']       = true;    //Página da movimentação da Linha
    $_SESSION['empresa']        = $_POST['empresas'];
    $_SESSION['empresa_desc']   = $_POST['empresas_desc'];
    
    
    $retorno = "OK";
    
}else{
    $retorno = "OK";
}
print $retorno;
  

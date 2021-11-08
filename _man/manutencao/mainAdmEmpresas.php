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


#Validando os dados Cadastrais
$empresa_tipo_pessoa        = $_POST['empresa_tipo_pessoa'];
$empresa_cnpj               = str_replace(array("."," ","/","-"),"",$_POST['empresa_cnpj']);
$empresa_situacao           = $_POST['empresa_situacao'];
$empresa_razao_socail       = trim($_POST['empresa_razao_social']);
$empresa_ie                 = trim($_POST['empresa_ie']);
$empresa_im                 = trim($_POST['empresa_im']);
$empreas_matriz_id          = trim($_POST['empreas_matriz_id']);
$empresa_nome_fantasia      = trim($_POST['empresa_nome_fantasia']);
$empresa_nire               = trim($_POST['empresa_nire']);
$empresa_tipo               = trim($_POST['empresa_tipo']);

#Validando os campos do Endereço
$empresa_cep                = str_replace(array(".","-"," "),"",$_POST['empresa_cep']);
$empresa_logradouro         = trim($_POST['empresa_logradouro']);
$empresa_numero             = trim($_POST['empresa_numero']);
$empresa_bairro             = trim($_POST['empresa_bairro']);
$empresa_uf                 = trim($_POST['empresa_uf']);
$empresa_codigo_municipio   = trim($_POST['empresa_codigo_municipio']);
$empresa_complemento        = trim($_POST['empresa_complemento']);

#Validando os campos de Contato
$empresa_telefone_principal = str_replace(array(".","-"," ","(",")"),"",$_POST['empresa_telefone_principal']);
$empresa_telefone_secundario= str_replace(array(".","-"," ","(",")"),"",$_POST['empresa_telefone_secundario']);
$empresa_email              = trim($_POST['empresa_email']);



#INSERT
if ( $op == "insert" ){
    $sql = "INSERT INTO public.t_empresas (
                            empresa_tipo                    , empresa_razao_social          , empresa_nome_fantasia     , empresa_cnpj          , empresa_uf            , 
                            empresa_ie                      , empresa_codigo_municipio      , empresa_im                , empresa_matriz        , empresa_situacao      , 
                            empresa_logradouro              , empresa_numero                , empresa_complemento       , empresa_bairro        , empresa_cep           , 
                            empresa_telefone_principal      , empresa_telefone_secundario   , empresa_email             , empresa_nire          , empresa_tipo_pessoa       ) 
                     VALUES('$empresa_tipo'                 , '$empresa_razao_socail'       , '$empresa_nome_fantasia'  , '$empresa_cnpj'       , '$empresa_uf'         , 
                            '$empresa_ie'                   , '$empresa_codigo_municipio'   , '$empresa_im'             , '$empreas_matriz_id'  , '$empresa_situacao'   , 
                            '$empresa_logradouro'           , '$empresa_numero'             , '$empresa_complemento'    , '$empresa_bairro'     , '$empresa_cep'        , 
                            '$empresa_telefone_principal'   , '$empresa_telefone_secundario', '$empresa_email'          , '$empresa_nire'       , '$empresa_tipo_pessoa');";
}

else if ( $op == "edit" ){
   $sql = "UPDATE t_empresas SET    empresa_tipo                =  '$empresa_tipo'
                                ,   empresa_razao_social        =  '$empresa_razao_socail'
                                ,   empresa_nome_fantasia       =  '$empresa_nome_fantasia'
                                ,   empresa_cnpj                =  '$empresa_cnpj'
                                ,   empresa_uf                  =  '$empresa_uf'
                                ,   empresa_ie                  =  '$empresa_ie'
                                ,   empresa_codigo_municipio    =  '$empresa_codigo_municipio'
                                ,   empresa_im                  =  '$empresa_im'
                                ,   empresa_matriz              =  '$empreas_matriz_id'
                                ,   empresa_situacao            =  '$empresa_situacao'
                                ,   empresa_logradouro          =  '$empresa_logradouro'
                                ,   empresa_numero              =  '$empresa_numero'
                                ,   empresa_complemento         =  '$empresa_complemento'
                                ,   empresa_bairro              =  '$empresa_bairro'
                                ,   empresa_cep                 =  '$empresa_cep'
                                ,   empresa_telefone_principal  =  '$empresa_telefone_principal'
                                ,   empresa_telefone_secundario =  '$empresa_telefone_secundario'
                                ,   empresa_email               =  '$empresa_email'
                                ,   empresa_nire                =  '$empresa_nire'
                                ,   empresa_tipo_pessoa         =  '$empresa_tipo_pessoa'
                              WHERE empresa_id                  =   {$id};"; 
}

// print"<pre>";
// print($sql);
// exit;

if ( $bd->Execute(replaceEmptyFields($sql)) ){
    $retorno = "OK";
    
    #Modificando o Session
    $_SESSION['op'] = $_SESSION['id'] = "";        
}

print $retorno;
<?php
/* Descrição: Back-End adm_participante.php
 * Author: Vitor Hugo Marini
 * Data: 05/07/2021
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

#Validando os dados Cadastrais
$participante_tipo              = trim($_POST['participante_tipo']);
$participante_nome              = trim($_POST['participante_nome']);
$participante_cliente           = trim($_POST['participante_cliente']);
$participante_fornecedor        = trim($_POST['participante_fornecedor']);
$participante_codigo            = str_replace(array('.','-','/'),'',trim($_POST['participante_codigo']));
$participante_ie                = str_replace(array('.','-','/'),'',trim($_POST['participante_ie']));
$participante_ie_st             = str_replace(array('.','-','/'),'',trim($_POST['participante_ie_st']));
$participante_im                = str_replace(array('.','-','/'),'',trim($_POST['participante_im']));
$participante_suframa           = str_replace(array('.','-','/'),'',trim($_POST['participante_suframa']));
$participante_nit               = str_replace(array('.','-','/'),'',trim($_POST['participante_nit']));
$participante_situacao          = trim($_POST['participante_situacao']);
$participante_codigo_pais       = trim($_POST['participante_codigo_pais']);

#INSERT
if ( $op == "insert" ){        
    
    $sql = "INSERT INTO public.t_participante (
                            participante_tipo               ,	participante_nome           ,	participante_cliente 
                        ,	participante_fornecedor         ,	participante_codigo         ,	participante_ie
                        ,	participante_ie_st              ,	participante_im             ,	participante_suframa
                        ,	participante_nit                ,	participante_situacao       ,	participante_codigo_pais ) 
                     VALUES('$participante_tipo'            ,	'$participante_nome'        ,	'$participante_cliente'
                        ,	'$participante_fornecedor'      ,	'$participante_codigo'      ,	'$participante_ie'
                        ,	'$participante_ie_st'           ,	'$participante_im'          ,	'$participante_nit'
                        ,	'$participante_nit'             ,	'$participante_situacao'    ,	'$participante_codigo_pais');";
}

else if ( $op == "edit" ){  
    
    #Movimentando as informações do endereço
    $participante_endereco_tipo          = trim($_POST['participante_endereco_tipo']);
    $participante_endereco_cep           = str_replace(array('.','-','/'),'',trim($_POST['participante_endereco_cep']));
    $participante_endereco_uf            = trim($_POST['participante_endereco_uf']);
    $participante_codigo_municipio       = trim($_POST['participante_codigo_municipio']);
    $participante_endereco_numero        = trim($_POST['participante_endereco_numero']);
    $participante_endereco_bairro        = trim($_POST['participante_endereco_bairro']);
    $participante_endereco_complemento   = trim($_POST['participante_endereco_complemento']);    
    $participante_endereco_logradouro    = trim($_POST['participante_endereco_logradouro']);    
    $participante_contato_tipo           = trim($_POST['participante_contato_tipo']);
    $participante_contato_descricao      = str_replace(array('.','-','/','(',')',' '),'',trim(($participante_contato_tipo == '3' ? $_POST['participante_contato_descricao_email'] : $_POST['participante_contato_descricao'])));
    
    if ( $_POST['op'] == "endereco" ){
        
        $_SESSION['aba'] = "aba-participante-endereco";
            
        if ( $_POST['type'] == "novo" ){
            $sql = "INSERT INTO public.t_participante_enderecos (
                               participante_endereco_tipo         
                          ,    participante_endereco_cep       
                          ,    participante_endereco_uf                  
                          ,    participante_codigo_municipio
                          ,    participante_endereco_numero       
                          ,    participante_endereco_bairro    
                          ,    participante_endereco_complemento         
                          ,    participante_id
                          ,    participante_endereco_logradouro)
                       VALUES( '$participante_endereco_tipo'      
                          ,    '$participante_endereco_cep'    
                          ,    '$participante_endereco_uf'               
                          ,    '$participante_codigo_municipio'
                          ,    '$participante_endereco_numero'    
                          ,    '$participante_endereco_bairro' 
                          ,    '$participante_endereco_complemento'      
                          ,    '$id'
                          ,    '$participante_endereco_logradouro');";        
        }
        else if ( $_POST['type'] == "editar" ){
            $sql = "UPDATE public.t_participante_enderecos SET 
                        participante_endereco_tipo          = '$participante_endereco_tipo'
                    ,   participante_endereco_cep           = '$participante_endereco_cep'
                    ,   participante_endereco_uf            = '$participante_endereco_uf'
                    ,   participante_codigo_municipio       = '$participante_codigo_municipio'
                    ,   participante_endereco_numero        = '$participante_endereco_numero'
                    ,   participante_endereco_bairro        = '$participante_endereco_bairro'
                    ,   participante_endereco_complemento   = '$participante_endereco_complemento'
                  WHERE participante_endereco_id            = '{$_POST['id_movim']}';";
        }
        else if ( $_POST['type'] == "delete" ){
            $sql = "DELETE FROM public.t_participante_enderecos WHERE participante_endereco_id = '{$_POST['id_movim']}';";
        }
    }
    else if ( $_POST['op'] == "contato" ){               
        
        $_SESSION['aba'] = "aba-participante-contato";
        
        if ( $_POST['type'] == "novo" ){
            $sql = "INSERT INTO public.t_participante_contato (
                    participante_id
                ,   participante_contato_tipo
                ,   participante_contato_descricao) 
            VALUES( '$id'
                ,   '$participante_contato_tipo'
                ,   '$participante_contato_descricao');";        
        }
        else if ( $_POST['type'] == "editar" ){
            $sql = "UPDATE public.t_participante_contato SET 
                        participante_contato_tipo           = '$participante_contato_tipo'
                    ,   participante_contato_descricao      = '$participante_contato_descricao'
                  WHERE participante_id                     = '{$_POST['id_movim']}';";
        }
        else if ( $_POST['type'] == "delete" ){
            $sql = "DELETE FROM public.t_participante_contato WHERE participante_contato_id = '{$_POST['id_movim']}';";
        }
    }
    else{
          
        $sql = " UPDATE t_participante SET      participante_tipo           = '$participante_tipo'        
                                        ,	participante_nome           = '$participante_nome' 
                                        ,	participante_cliente        = '$participante_cliente'
                                        ,	participante_fornecedor     = '$participante_fornecedor'      
                                        ,	participante_codigo         = '$participante_codigo'     
                                        ,	participante_ie             = '$participante_ie'
                                        ,   	participante_ie_st          = '$participante_ie_st'   
                                        ,	participante_im             = '$participante_im'
                                        ,	participante_suframa        = '$participante_suframa'
                                        ,	participante_nit            = '$participante_nit'   
                                        ,	participante_situacao       = '$participante_situacao'
                                        ,	participante_codigo_pais    = '$participante_codigo_pais'
                                    WHERE       participante_id             = {$id};"; 
    }                          
}
// print"<pre>";
// print($sql);
// exit;
if ( $bd->Execute(replaceEmptyFields($sql)) ){
    $retorno = "OK";
    
    //Trantando essa excessão para não modificar a página
    if ( $op == "insert" ){
        $lastID = $bd->Execute("SELECT participante_id AS last_id FROM t_participante ORDER BY 1 DESC LIMIT 1;");
        
        #Modificando o Session
        $_SESSION['op'] = 'e';
        $_SESSION['id'] = $lastID->fields['last_id'];        
    }else{
        
        if ( !isset($_POST['op']) ){
            #Modificando o Session
            $_SESSION['op'] = $_SESSION['id'] = "";      
        }
        
    }
}

print $retorno;
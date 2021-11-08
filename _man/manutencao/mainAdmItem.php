<?php
/* Descrição: Back-End adm_itens.php
 * Author: Vitor Hugo Marini
 * Data: 27/08/2021
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
$tipo                   = trim($_POST['item_tipo']);
$codigo                 = trim($_POST['item_codigo']);
$descricao              = trim($_POST['item_descricao']);
$unidade                = trim($_POST['item_und_inv']);
$aliqIcms               = empty($_POST['item_aliq_icms']) ? '0,00' : trim($_POST['item_aliq_icms']);
$exIpi                  = trim($_POST['item_ex_ipi']);
$codGen                 = str_replace(array('.','-','/'),'',trim($_POST['item_cod_gen']));
$codLst                 = str_replace(array('.','-','/'),'',trim($_POST['item_cod_lst']));
$ncm                    = str_replace(array('.','-','/'),'',trim($_POST['item_ncm_id']));
$cest                   = str_replace(array('.','-','/'),'',trim($_POST['item_cest']));

#INSERT
if ( $op == "insert" ){        
    
    $sql = "INSERT INTO public.t_item (
            item_codigo     , item_descricao          , item_codigo_barra     , item_und_inv
        ,   item_tipo       , item_ncm                , item_ex_ipi           , item_cod_gen
        ,   item_cod_lst    , item_aliq_icms          , item_cest             , item_situacao) 
     VALUES('$codigo'       , '$descricao'            , ''                    , '$unidade'
        ,   '$tipo'         , '$ncm'                  , '$exIpi'              , '$codGen'
        ,   '$codLst'       , moedabanco('$aliqIcms') , '$cest'               , '{$_POST['item_situacao']}');"; 
}

else if ( $op == "edit" ){          
    
    if ( $_POST['op'] == "endereco" ){
        
        $_SESSION['aba'] = "aba-participante-endereco";
            
        if      ( $_POST['type'] == "novo"   ){ $sql = ""; }
        else if ( $_POST['type'] == "editar" ){ $sql = ""; }
        else if ( $_POST['type'] == "delete" ){ $sql = ""; }
    }
    else if ( $_POST['op'] == "contato" ){               
        
        $_SESSION['aba'] = "aba-participante-contato";
        
        if      ( $_POST['type'] == "novo"   ){ $sql = ""; }
        else if ( $_POST['type'] == "editar" ){ $sql = ""; }
        else if ( $_POST['type'] == "delete" ){ $sql = ""; }
    }
    else{
          
        $sql = " UPDATE t_item     SET      item_codigo         = '$codigo'        
                                        ,	item_descricao      = '$descricao' 
                                        ,	item_codigo_barra   = ''
                                        ,	item_und_inv        = '$unidade'      
                                        ,	item_tipo           = '$tipo'     
                                        ,	item_ncm            = '$ncm'
                                        ,   item_ex_ipi         = '$exIpi'   
                                        ,	item_cod_gen        = '$codGen'
                                        ,	item_cod_lst        = '$codLst'
                                        ,	item_aliq_icms      = moedabanco('$aliqIcms')
                                        ,	item_cest           = '$cest'
                                        ,	item_situacao       = '{$_POST['item_situacao']}'
                                    WHERE   item_id             = {$id};"; 
    }                          
}


if ( $bd->Execute(replaceEmptyFields($sql)) ){
    $retorno = "OK";
    
    //Trantando essa excessão para não modificar a página
    if ( $op == "insert" ){
        $lastID = $bd->Execute("SELECT item_id AS last_id FROM t_item ORDER BY 1 DESC LIMIT 1;");
        
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
<?php
/* 
 * Programa genérico para Buscas no banco de dados
 * Data: 03/2022
 * Vitor Hugo Nunes Marini
 */
include_once '../../_conection/_conect.php';
include_once '../../_man/_aux.php';


//Verificando qual a TABELA do banco que iremos setar
if ( $_POST['table'] == "t_empresa" ){
    
    if ( $_POST['tipo'] == "empresa_matriz" ){
    
        $sql = 
        "SELECT     empresa_id              
                ,   empresa_cnpj || ' - ' || empresa_razao_social  
                ,   empresa_tipo_pessoa     
           FROM     public.t_empresas       
           WHERE    empresa_tipo = 'MATRIZ' 
             AND    (   empresa_razao_social ILIKE '%{$_POST['descricao']}%' 
                     OR empresa_cnpj         ILIKE '%{$_POST['descricao']}%' );";
    }    
    
}
if ( $_POST['table'] == "t_participante" ){
    
    if ( $_POST['tipo'] == "busca_cliente" ){
    
        $sql = 
        "SELECT p.participante_id 	
            ,   cpf_cnpj(p.participante_codigo,p.participante_tipo)|| ' - ' || p.participante_nome 
            ,	p.participante_tipo 
            ,	p.participante_codigo 
            ,	p.participante_nome 
            ,	cpf_cnpj(p.participante_codigo,p.participante_tipo)
            FROM t_participante AS p 
           WHERE p.participante_cliente = 'S'                    
             AND (   p.participante_nome ILIKE '%{$_POST['descricao']}%' 
                     OR p.participante_codigo         ILIKE '%{$_POST['descricao']}%' );";
    }       
}
else if ( $_POST['table'] == "t_pais" ){
    
    if ( $_POST['tipo'] == "codigo_pais" ){
    
        $sql = 
        "SELECT pais_codigo, pais_nome 
           FROM t_paises 
          WHERE pais_codigo::text ILIKE  '%{$_POST['descricao']}%' 
             OR pais_nome   ILIKE  '%{$_POST['descricao']}%'
       ORDER BY 2;";
    }
}
else if ( $_POST['table'] == "t_item" ){
    
    if ( $_POST['tipo'] == "ncm" ){
    
        $sql = 
        "SELECT REPLACE(ncm_codigo,'.','') AS codigo ,	ncm_codigo||' - '||ncm_descricao AS descricao 
           FROM t_ncm tn 
          WHERE ncm_data_fim >= current_date 
            AND ( ncm_codigo ILIKE  '%{$_POST['descricao']}%'  OR REPLACE(ncm_codigo,'.','') ILIKE  '%{$_POST['descricao']}%' OR ncm_descricao   ILIKE  '%{$_POST['descricao']}%' )
       ORDER BY 1;";
    }
    else if ( $_POST['tipo'] == "busca_item" ){
    
        $sql = 
        "SELECT 
            ti.item_id 
        ,	ti.item_codigo || ' - ' || ti.item_descricao AS descricao_item
        FROM t_item AS ti     
           WHERE (   ti.item_codigo ILIKE '%{$_POST['descricao']}%' 
                     OR ti.item_descricao         ILIKE '%{$_POST['descricao']}%' );";
    }       
}

else if( $_POST['table'] == "t_user" ){
    $sql = "SELECT user_id , user_nome FROM t_user tu WHERE user_nome ILIKE '%{$_POST['descricao']}%' ORDER BY user_nome ";
}

//Variável para retorno dos dados
$retorno["dados"] = array();     

#Executa a linha de busca no banco
$objDados = $bd->Execute($sql);

while(!$objDados->EOF){
    array_push($retorno["dados"], 
        array(
            "ret_1"  => $objDados->fields[0],
            "ret_2"  => $objDados->fields[1]                
        )
    );           
    $objDados->MoveNext();
}    

print json_encode( $retorno );
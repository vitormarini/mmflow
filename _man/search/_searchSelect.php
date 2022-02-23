<?php
/* 
 * Programa genérico para Buscas no banco de dados com retorno de SELECT
 * Data: 03/2022
 * Vitor Hugo Nunes Marini
 */
include_once '../../_conection/_conect.php';
include_once '../../_man/_aux.php';


//Variável para retorno dos dados
$retorno["dados"] = array(); 
$html = "";
$html .= '<option value="">Selecione</option>';

#Validamos qual o select que iremos retornar
if ( $_POST['busca'] == "submenu_categoria" ){
    
    $where = !empty($_POST['id']) ? "WHERE menu_id = {$_POST['id']}" : "";
    
    $sql = "SELECT menu_submenu_categoria FROM t_menu_sub $where GROUP BY 1 ORDER BY 1;";    
    
    #Executa a linha de busca no banco
    $objDados = $bd->Execute($sql);
    while(!$objDados->EOF){
        $html .= '<option value="'.$objDados->fields[0].'">'.$objDados->fields[0].'</option>';

        $valida = true;

        $objDados->MoveNext();
    }   
}

else if ( $_POST['busca'] == "t_empresas"){
    $_POST['cnpj'] = substr(retira_caracteres($_POST['cnpj']),0,8);
    $sql = "
        SELECT empresa_id            
            , empresa_razao_social
            , empresa_nome_fantasia
            , empresa_cnpj 
            , CONCAT(cpf_cnpj(empresa_cnpj,'J') ||' - '|| empresa_razao_social) AS descricao
        FROM t_empresas te 
        WHERE empresa_cnpj ILIKE '{$_POST['cnpj']}%'
        ORDER BY empresa_cnpj;";
        
    #Executa a linha de busca no banco
    $objDados = $bd->Execute($sql);
    while(!$objDados->EOF){
//        $selected = $
        
        $html .= '<option value="'.$objDados->fields[0].'">'.$objDados->fields[4].'</option>';

        $valida = true;

        $objDados->MoveNext();
    }   
}

array_push($retorno["dados"], 
    array(
        "status"  => ($valida ? "OK" : "NO_OK"),
        "html"    => $html                
    )
);  
print json_encode( $retorno );
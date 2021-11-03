<?php
/* 
 * Programa genérico para Buscas no banco de dados com retorno de SELECT
 * Data: 03/2022
 * Vitor Hugo Nunes Marini
 */
include_once '../../_conection/_conect.php';
include_once '../../_man/aux.php';


#Validamos qual o select que iremos retornar
if ( $_POST['busca'] == "submenu_categoria" ){
    
    $where = !empty($_POST['id']) ? "WHERE menu_id = {$_POST['id']}" : "";
    
    $sql = "SELECT menu_submenu_categoria FROM t_menu_sub $where GROUP BY 1 ORDER BY 1;";    
}

//Variável para retorno dos dados
$retorno["dados"] = array(); 
$html = "";

#Executa a linha de busca no banco
$objDados = $bd->Execute($sql);

$html .= '<option value="">Selecione</option>';

while(!$objDados->EOF){                       
    
    $html .= '<option value="'.$objDados->fields[0].'">'.$objDados->fields[0].'</option>';
    
    $valida = true;
    
    $objDados->MoveNext();
}    

array_push($retorno["dados"], 
        array(
            "status"  => ($valida ? "OK" : "NO_OK"),
            "html"    => $html                
        )
    );  
print json_encode( $retorno );
<?php
/* 
 * Programa genérico para Buscas no banco de dados com retorno de SELECT
 * Data: 03/2022
 * Vitor Hugo Nunes Marini
 */
include_once '../../_conection/_conect.php';
include_once '../../_man/aux.php';

//Variável para retorno dos dados
$retorno["dados"] = array(); 
$html = "";
$valida = false;

#Validamos qual o select que iremos retornar
if ( $_POST['busca'] == "submenu" ){
    
    $where = !empty($_POST['menu_id']) && !empty($_POST['categoria']) ? "WHERE menu_submenu_categoria = '{$_POST['categoria']}' AND menu_id = {$_POST['menu_id']}" : "";
    
    $sql = "SELECT  menu_sub_id ,  menu_submenu_descricao FROM t_menu_sub  $where ORDER BY 2;";    
    
    
    
    #Executa a linha de busca no banco
    $objDados = $bd->Execute($sql);


    while(!$objDados->EOF){

        $verificaItem = $bd->Execute("SELECT count(*) AS registros FROM user_permission WHERE id_user = {$_SESSION['id']} AND id_item = {$objDados->fields[0]};");

        $checked = $verificaItem->fields['registros'] > 0 ? "checked" : "";

        $html .= 
        '<tr>
            <td class="text-center"><input      
                                            type="checkbox" 
                                            name="id_'.$objDados->fields[0].'" 
                                            value="'.$objDados->fields[0].'"
                                            style="margin-left:auto; margin-right:auto; font-size: 110%;  display: inline; transform: scale(2);  padding: 10px;"
                                            '.$checked.'/></td>
            <td class="text-left"  >'.$objDados->fields[1].'</td>
         </tr>';

        $valida = true;

        $objDados->MoveNext();
    }    
    
}
else if ( $_POST['busca'] == "participante_endereco" ){
    
    $sql = "SELECT 
                CASE 
                        WHEN participante_endereco_tipo  = '1' THEN 'FATURAMENTO'
                        WHEN participante_endereco_tipo  = '2' THEN 'COMERCIAL'
                        WHEN participante_endereco_tipo  = '3' THEN 'ENTREGA'
                END AS tipo
             ,	participante_endereco_cep 
             ,	participante_endereco_uf              
             ,	participante_codigo_municipio 
             ,	participante_endereco_logradouro                          
             ,	participante_endereco_numero  
             ,	participante_endereco_bairro 
             ,	participante_endereco_complemento 
             ,	participante_endereco_id 
             FROM t_participante_enderecos WHERE participante_id = '{$_SESSION['id']}' ORDER BY 1,2,3,4;";    
            
    #Executa a linha de busca no banco
    $objDados = $bd->Execute($sql);


    while(!$objDados->EOF){       

        $html .= 
        '<tr>
            <td class="text-center"  >'.$objDados->fields[0].'</td>
            <td class="text-center"  >'.$objDados->fields[1].'</td>
            <td class="text-center"  >'.$objDados->fields[2].'</td>
            <td class="text-center"  >'.$objDados->fields[3].'</td>
            <td class="text-center"  >'.$objDados->fields[4].'</td>
            <td class="text-center"  >'.$objDados->fields[5].'</td>
            <td class="text-center"  >'.$objDados->fields[6].'</td>
            <td class="text-center"  >'.$objDados->fields[7].'</td>
            <td class="text-center"  >'.$objDados->fields[8].'</td>
            <td class="text-center"  >            </td>
         </tr>';

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
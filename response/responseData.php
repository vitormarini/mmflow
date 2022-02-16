<?php
/*
 * Author: Vitor Hugo Nunes Marini
 * Data Criação: 12/05/2020
 * Request API Banco Central
 */

include_once '../bd.php';
include_once '../funcoes.php';

#Retorno
$retorno  = array();    

#Dados para a URL
$arrDados = $_POST['dados'];
$ano      = $arrDados["ano"] != "" ? $arrDados["ano"] : $_SESSION['ano_oper'];
$ibge     = $arrDados['codigo_ibge'];
$token    = "dmhtYXJpbmlAZ21haWwuY29tJmhhc2g9MjgyMzEyOQ";

//Buscando os dados da receita federal 
$url = 'http://api.calendario.com.br/?json=true&ano='.$ano.'&ibge='.$ibge.'&token='.$token;

$data  = file_get_contents($url);

#Convertendo os dados para JSON
$dataJ  = json_decode($data, true);

foreach ( $dataJ as $dados ){
    
    $dataEvento = dataBanco($dados['date']);
    $tipo       = $dados['type'];
    $codTipo    = $dados['type_code'];
    $descricao  = $dados['description'];
    
    #VERIFICANDO SE JÁ EXISTE ESSA DATA E ATUALIZANDO
    $consultaFeriado = $bd->Execute($sql = "SELECT id_data_feriado FROM datas_feriados WHERE data_feriado = '{$dataEvento}' AND ano = '{$_SESSION['ano_oper']}';");

    if ( $consultaFeriado->RecordCount() > 0 ){
        $sqlRegistro .= 
        "UPDATE datas_feriados SET  
                data_feriado        = '{$dataEvento}'
            ,   descricao_feriado   = '{$descricao}'
            ,	codigo_tipo         = '{$codTipo}'
            ,	descricao_tipo      = '{$tipo}'
            ,   codigo_ibge         = '{$ibge}'
            ,   token               = '{$token}'
            ,   ano                 = '{$ano}'
        WHERE id_data_feriado       = '{$consultaFeriado->fields['id_data_feriado']}';";
    }else{
        $sqlRegistro .= 
        "INSERT INTO datas_feriados (data_feriado      ,   descricao_feriado ,	codigo_tipo ,	descricao_tipo  ,   codigo_ibge ,   token       ,   ano     )
                             VALUES ('{$dataEvento}'   ,   '{$descricao}'    , '{$codTipo}',   '{$tipo}'       ,   '{$ibge}'   ,   '{$token}'  ,   '{$ano}');";
    }          
}

if ( $bd->Execute($sqlRegistro) ){
    $retorno["request"] = array();
    
    array_push($retorno["request"], 
           array(
               "html"   => "",
               "status"   => "SUCESSO_API"
           )
    ); 
}

  
print json_encode( $retorno );    

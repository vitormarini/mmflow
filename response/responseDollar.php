<?php
/*
 * Author: Vitor Hugo Nunes Marini
 * Data Criação: 22/04/2020
 * Request API Banco Central
 */

include_once '../bd.php';
include_once '../funcoes.php';

#Retorno
$retorno = "OK";

#Dados para a URL
$dataInicio = "01".'/'.$_POST['mes'].'/'."{$_POST['ano']}";
$dataFim    = $_POST['mes']."/".date("t", strtotime(dataBanco($dataInicio)))."/"."{$_POST['ano']}";
$dataInicio = $_POST['mes'].'/01/'."{$_POST['ano']}";
$format     = "json"; //TXT / XML / TXT/CSV / TXT/HTML
$limit      = "100";
$select     = "cotacaoCompra,cotacaoVenda,dataHoraCotacao";

//Buscando os dados da receita federal 
$url = "https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?"
    . "@dataInicial='{$dataInicio}'"
    . "&@dataFinalCotacao='$dataFim'"
    . "&".'$top='.$limit.''
    . "&".'$format='.$format.''
    . '&$select='."{$select}";

$data  = file_get_contents($url);

#Convertendo os dados para JSON
$dataJ  = json_decode($data, true);
$arrVal = $dataJ["value"];


foreach ( $arrVal as $dados ){

    $cotacaoCompra   = $dados['cotacaoCompra'];
    $cotacaoVenda    = $dados['cotacaoVenda'];
    $dataHoraCotacao = $dados['dataHoraCotacao'];
    $diaCotacao      = substr($dados['dataHoraCotacao'],0,10);
    $urlSql          = str_replace("'", '', $url);    
    $lastUpdate      = date("d/m/Y H:i:s");
    
    $consultaCotacao = $bd->Execute("SELECT id_dollar_diario FROM dollar_diario WHERE dia_cotacao = '{$diaCotacao}';");
    
    if ( $consultaCotacao->RecordCount() > 0 ){
        
        $sql .= "UPDATE dollar_diario SET 
                        cotacao_compra    = '{$cotacaoCompra}'
                    ,   cotacao_venda     = '{$cotacaoVenda}'
                    ,   data_hora_cotacao = '{$dataHoraCotacao}'
                    ,   mes               = '{$_POST['mes']}'
                    ,   dia_cotacao       = '{$diaCotacao}'
                    ,   url_api           = '{$urlSql}'
                    ,   last_update       = '{$lastUpdate}'
                WHERE id_dollar_diario    = '{$consultaCotacao->fields['id_dollar_diario']}'; ";
        
    }else{
        
        $sql .= "INSERT INTO dollar_diario ( cotacao_compra      ,   cotacao_venda       ,  data_hora_cotacao        , mes               , dia_cotacao      , url_api     , last_update)
                                    VALUES( '{$cotacaoCompra}'  ,   '{$cotacaoVenda}'   , '{$dataHoraCotacao}'       , '{$_POST['mes']}' , '{$diaCotacao}'  , '{$urlSql}' , '{$lastUpdate}'); ";
        
    }               
}
#VALIDAÇÃO DO RETORNO
if ( !$bd->Execute($sql) ){
    $retorno = "ERRO";    
}

print $retorno;
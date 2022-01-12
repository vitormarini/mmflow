<?php
/*
 * Author: Vitor Hugo Nunes Marini
 * Data Criação: 22/04/2020
 * Request API Banco Central
 */
ini_set( "display_errors", "on" );
error_reporting( E_ALL );

include_once '../bd.php';
include_once '../funcoes.php';
require_once '../Classes/ReadPlan/PHPExcel.php';

#Retorno
$retorno = array();
$retornoArray = array();
$retornoHtml = "";
$retornoHtmlSucesso = "";
$retornoHtmlErro = "";
$sit = "OK";
$somaTotal = 0;

#Iniciamos o objeto
$objReader = new PHPExcel_Reader_Excel5();
$objReader->setReadDataOnly(true);
//$objPHPExcel = $objReader->load("../import_contabil/IMPORTACAO_CONTABIL.xls");
$objPHPExcel = $objReader->load("../import_contabil/".$_POST['arquivo']);

#Definindo as linhas e colunas
$colunas        = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
$totalColunas   = PHPExcel_Cell::columnIndexFromString($colunas);
$totalLinhas    = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

#Navegação entre linhas
for ( $linha = 2; $linha <= $totalLinhas ; $linha ++ ){
    #Navegação entre colunas
    for ( $coluna = 0; $coluna <= $totalColunas; $coluna ++ ){
        $retorno["linha_".$linha]["col_".$coluna] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna,$linha)->getValue();       
    }
}

//Criando o arquivo HTML
foreach ( $retorno as $ret ){
      
    #CRIANDO A DATA
    $n = $ret['col_0'];
    $dateTime = new DateTime("1899-12-30 + $n days");
    
    
    $buscCDebito  = $bd->Execute($sql = "SELECT id_plano_conta FROM plano_conta WHERE codigo_reduzido = '{$ret["col_1"]}' AND ano = '{$_SESSION['ano_oper']}';");
    $buscCCredito = $bd->Execute($sql = "SELECT id_plano_conta FROM plano_conta WHERE codigo_reduzido = '{$ret["col_2"]}' AND ano = '{$_SESSION['ano_oper']}';");
    
    #VERIFICANDO SE EXISTE AS CONTAS
    $verificaCDebito = $buscCDebito->RecordCount()  > 0 ? true : false;
    $verificaCCredito= $buscCCredito->RecordCount() > 0 ? true : false;
    $validaDatas     = $verificaCDebito == true && $verificaCCredito == true ? true : false;
    
    
    #TRATAMENTO DOS ERROS
    
    #1 - Validar se o ano do lançamento é igual ao ano de atuação no sistema
    if ( $_SESSION['ano_oper'] != explode("/",$dateTime->format("d/m/Y"))[2] ){
        $retornoHtmlErro .= 
        '<tr>
            <td class="text-center">'. $dateTime->format("d/m/Y")               .'</td>
            <td class="text-center">'. $ret["col_1"]                            .'</td>
            <td class="text-center">'. $ret["col_2"]                            .'</td>
            <td class="text-right" >'. number_format($ret["col_5"],2,",",".")   .'</td>
            <td class="text-left" >ANO DO LANÇAMENTO DIFERENTE DO ANO DO SISTEM <b>'. $_SESSION['ano_oper'] .'</b></td>
         </tr>';  
        $sit = "ERRO";
    }
    else if ( $validaDatas == false ){
        $descDebito  = $verificaCDebito == false ? " CONTA ".$ret["col_1"]." NÃO EXISTE PARA ESSE ANO <b>{$_SESSION['ano_oper']}</b>" : "";
        $descCredito = $verificaCCredito == false ? " CONTA ".$ret["col_2"]." NÃO EXISTE PARA ESSE ANO <b>{$_SESSION['ano_oper']}</b>" : "";
                
        $retornoHtmlErro .= 
        '<tr>
            <td class="text-center">'. $dateTime->format("d/m/Y")               .'</td>
            <td class="text-center">'. $ret["col_1"]                            .'</td>
            <td class="text-center">'. $ret["col_2"]                            .'</td>
            <td class="text-right" >'. number_format($ret["col_5"],2,",",".")   .'</td>
            <td class="text-left" >'. $descDebito .' '. $descCredito .'</b></td>
         </tr>';  
        $sit = "ERRO";
    }
    else{
        $retornoHtmlSucesso .= 
        '<tr>
            <td class="text-center">'. $dateTime->format("d/m/Y")               .'</td>
            <td class="text-center">'. $ret["col_1"]                            .'</td>
            <td class="text-center">'. $ret["col_2"]                            .'</td>
            <td class="text-center">'. $ret["col_3"]                            .'</td>
            <td class="text-left"  >'. $ret["col_4"]                            .'</td>
            <td class="text-right" >'. number_format($ret["col_5"],2,",",".")   .'</td>
         </tr>';   
    }
               
    $somaTotal += $ret["col_5"];
    
}

if ( $sit != "ERRO" ){
    $retornoHtml .= $retornoHtmlSucesso.
    '<tr>
        <td colspan="5" class="text-center"> <b>TOTAL</b> </td>
        <td             class="text-right" >'. number_format($somaTotal,2,",",".") .'</td>
     </tr>';
}else{
    $retornoHtml .= $retornoHtmlErro;
}

$retornoArray = 
    array(
        'html'          => $retornoHtml,
        'situacao'      => $sit
    );

print json_encode($retornoArray);
<?php
/**
 * Programa com os dados de inicialização dos bancos de dados.
 * Processo é iniciado pela tela de Login ou Para registro do Banco, fazendo assim uma conexão Automática
 * Autor: Vitor Hugo Marini 
 * Data: 23/06/2021
*/
include_once "_conect.php";


## SELECT -- Consultas realizadas dentro da base de dados.
/**
 * Retorna uma Consulta Simples com todos os valores
 * @global type $bd
 * @param type $xTable
 * @return type
 */
function bdSimpleSelect($xTable){
    global $bd;
    
    return $bd->Execute("SELECT * FROM $xTable");
}

/**
 * Retorna uma Consulta única, de um único ID vinculado a uma base;
 * @global type $bd
 * @param type $xTable
 * @param type $xColumns
 * @param type $xId
 * @param type $xIdValue
 * @return type
 */
function bdUnicSelect($xTable, $xColumns, $xId, $xIdValue){
    global $bd;
    
    return $bd->Execute("SELECT $xColumns FROM $xTable WHERE $xId = $xIdValue;");
}

/**
 * Retorna os valores do Select Construído
 * @global type $bd
 * @param type $xSql
 * @return type
 */
function bdSelect($xSql){
    global $bd;
    
    return $bd->Execute($sql);
}

#INSERT - Inserções feitas dentro da base de dados.

/**
 * Inserção na base através de solução única
 * @global type $bd
 * @param type $xTable
 * @param type $xColumns
 * @param type $xValues
 * @return string
 */
function bdInsert($xTable, $xColumns, $xValues){
    global $bd;
    
    $sql = "INSERT INTO $xTable ( $xColumns ) VALUES ( $xValues );";
    
    // print"<pre>";
    // print($sql);
    // exit;

    #Tratando o retorno
    if ( $bd->Execute($sql = "INSERT INTO $xTable ( $xColumns ) VALUES ( $xValues );") ){
        return "OK";
    }else{
        return "ERRO".$sql;
    }
}

/**
 * Função que faz uma busca, retornando a quantidade de registros
 * @global type $bd
 * @param type $xTable
 * @param type $xParam
 * @param type $xMethod
 * @param type $xValue
 * @return type
 */
function bdRegisters($xTable, $xParam, $xMethod, $xValue){
    global $bd;
    
    return $bd->Execute("SELECT count(*) AS qtd FROM $xTable WHERE $xParam  $xMethod $xValue");
}
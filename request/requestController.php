<?php

/* 
 * Vitor Hugo Nunes Marini
 * Data Criação: 16/05/2021
 * Descrição: programa controlador onde faz a chamada das funções buscando os anexos, armazenando no servidor para que assim alimente o banco de dados.
 */
date_default_timezone_set('America/Sao_Paulo');

include_once( '/var/linoforte/gestao/bdAuto.php' );
include_once( '/var/linoforte/gestao/funcoes.php' );
include_once( '/var/linoforte/gestao/request/readPlanilha.php' );
include_once( '/var/linoforte/gestao/request/requestEmail.php' );

function coletaDadosEspuma(){

    #Buscando arquivos que não foram lidos na pasta
    $path = "/var/linoforte/gestao/request/assets/";

    //Disparando a busca dos e-mails
    $email = requestEmail("espuma");

    if ( $email == "OK" ){
        //Disparando a interpretação dos arquivos CSV
        $csv = readCSV($path);
        $retorno = "OK";
    }
    else { 
        $csv = readCSV($path);
        $retorno = "AGUARDANDO";
    } 
    
}
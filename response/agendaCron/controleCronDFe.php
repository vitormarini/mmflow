<?php

/**
 * Consulta agendada no Cron Linux -- Vitor Hugo Marini
 * Data Criação : 01/07/2021
 * Descrição: Agendador de Execução e Gerenciamento de Empresas para Consulta de Documentos Fiscais no SEFAZ
 */

session_start();
include_once( '/var/linoforte/gestao/bdAuto.php' ); #Conexão com o Banco de dados Gestão, sem que haja a iteração de algum usuário
include_once( '/var/linoforte/gestao/funcoes.php' );

#Buscando a empresa
$diretorio = dir("/var/linoforte/gestao/certificado/");   
    

#NOVA CONEXÃO PARA LOGIN - CABRAL / VITOR 03/09/2019 -- CONEXÃO COM O SERVIDOR
$sgbd                           = "postgres";
$host                           = "192.168.50.22:5432";
$usuario                        = "sistema";
$senha                          = "@sis$28";

#VALIDA O TIPO DE LOGIN, CASO O LOGIN ESTTEJA COM UM . ( PONTO ) NA FRENTE, DITA QUE ESTOU QUERENDO LOGAR COM O BANCO LOCAL

#EFETUAMOS A CONSULTA DO ARQUIVO
//if ( date("m") == "00" || date("m") == "30" ){       
//
//    while($arquivo = $diretorio -> read()){
//
//        if ( explode(".",$arquivo)[1] == "pfx" ){
//
//            $identificador = explode(".",$arquivo)[0];
//
//            if ( $identificador == "53336244000106" ){
//                $bdAcesso = "gestao";
//                $_SESSION['empresa'] == "1";
//            }
//            else if ( $identificador == "33486476815" ) {
//                $bdAcesso = "gestao_agro";
//                $_SESSION['empresa'] == "6";
//            }
//
//            #Criando as conexões com o banco automaticamente
//            $bd      = $objBDNovo = $objBD = novaConexao( $sgbd, $host, $bdAcesso, $usuario, $senha);        
//            $objLog  = novaConexao( $sgbd, $host, "log"     , "linoforte", "@lino$28");
//            $chamado = novaConexao( $sgbd, $host, "chamados", "linoforte", "@lino$28");
//
//            include_once ( './dfeCron_consulta.php' );      //Consulta a SEFAZ                        
//        }
//    }
//}
//
//#EFETUAMOS A CIÊNCIA DA OPERAÇÃO
//else if ( date("m") == "05" || date("m") == "35" ){
//    while($arquivo = $diretorio -> read()){
//
//        if ( explode(".",$arquivo)[1] == "pfx" ){
//
//            $identificador = explode(".",$arquivo)[0];
//
//            if ( $identificador == "53336244000106" ){
//                $bdAcesso = "gestao";
//                $_SESSION['empresa'] == "1";
//            }
//            else if ( $identificador == "33486476815" ) {
//                $bdAcesso = "gestao_agro";
//                $_SESSION['empresa'] == "6";
//            }
//
//            #Criando as conexões com o banco automaticamente
//            $bd      = $objBDNovo = $objBD = novaConexao( $sgbd, $host, $bdAcesso, $usuario, $senha);        
//            $objLog  = novaConexao( $sgbd, $host, "log"     , "linoforte", "@lino$28");
//            $chamado = novaConexao( $sgbd, $host, "chamados", "linoforte", "@lino$28");
//
//            include_once( './dfeCron_cienciaOp.php' );      //Aplica a Ciência da Operação                   
//        }
//    }
//}       

#EFETUAMOS O DOWNLOAD
//else if ( date("m") == "15" || date("m") == "45" ){
    while($arquivo = $diretorio -> read()){

        if ( explode(".",$arquivo)[1] == "pfx" ){

            $identificador = explode(".",$arquivo)[0];

            if ( $identificador == "53336244000106" ){
                $bdAcesso = "gestao";
                $_SESSION['empresa'] == "1";
            }
            else if ( $identificador == "33486476815" ) {
                $bdAcesso = "gestao_agro";
                $_SESSION['empresa'] == "6";
            }
            
            

            #Criando as conexões com o banco automaticamente
            $bd      = $objBDNovo = $objBD = novaConexao( $sgbd, $host, $bdAcesso, $usuario, $senha);        
            $objLog  = novaConexao( $sgbd, $host, "log"     , "linoforte", "@lino$28");
            $chamado = novaConexao( $sgbd, $host, "chamados", "linoforte", "@lino$28");

            print("teste");
            include_once  './dfeCron_download.php' ;   //Efetua o Donwload do que estiver Liberado
        }
    }
    
//}
$diretorio->close();

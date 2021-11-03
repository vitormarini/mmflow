<?php
/**
 * Classe de Conexão com o banco de dados
 * Author: Vitor Hugo Marini
 * Data criação: 31/03/2020
 */

#Parâmetros gerais
// $con = pg_connect("host=localhost port=5432 dbname=mypay user=postgres password=mttpocos");

//Tipo de report de erros
error_reporting(E_ERROR);

if ( session_start() ){

    $_SESSION["teste"] = "teste";

    //Includes obrigatórios
    require_once "adodb/adodb-exceptions.inc.php";
    require_once "adodb/adodb.inc.php";

    //$bd = $objBDNovo = novaConexao("postgres", "localhost:5432", "neo_fitness", "neo_fitness", "mttpocos");       
    $bd = $objBDNovo = novaConexao("postgres", "179.188.16.126:5432", "neo_fitness", "neo_fitness", "mttpocos");       
    //$bd = $objBDNovo = novaConexao("neo_fitness", "179.188.16.126:5432", "neo_fitness", "neo_fitness", "mttpocos");       
    //$bd = $objBDNovo = novaConexao("neo_fitness", "179.188.16.126:5432", "neo_fitness", "neo_fitness", "mttpocos");       

   
}
 function novaConexao($banco, $host, $base, $usuario, $senha){

      $conexao               = ADONewConnection($banco); 
      $conexao->debug        = false;
      $conexao->autoRollback = true;
      $conexao->dialect      = 3;
      $conexao->Connect($host, $usuario, $senha, $base);  

      //Verifica se conexão foi estabelecida
      if(!$conexao->IsConnected())
          exit(htmlentities("[ERRO] Não foi possível conectar ao banco de dados! Por favor, contate o administrador do sistesma."));

      //Previne erros de codificação - Postgres
      $conexao->Execute("SET NAMES 'utf8'");
      $conexao->Execute("SET CLIENT_ENCODING TO utf8");

      return $conexao;
    }

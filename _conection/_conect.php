<?php
 /**
  * Efetua a conexão com o banco de dados, mantém a mesma contectada a qualquer momento que estiver logado
  * Autor: Vitor Hugo Marini
  * Data: 23/06/2021
  */
error_reporting(E_ERROR);

//Includes obrigatórios
include_once "adodb/adodb-exceptions.inc.php";
include_once "adodb/adodb.inc.php";

//Inicia sessão
session_start();

$varBd = array();
$varBd["sgbd"] = "postgres";
$varBd["host"] = "http://base_flow.postgresql.dbaas.com.br:5432";
$varBd["base"] = "base_flow";
$varBd["user"] = "base_flow";
$varBd["pass"] = "mttpocos";
//$varBd["sgbd"] = "postgres";
//$varBd["host"] = "localhost";
//$varBd["base"] = "base_sys";
//$varBd["user"] = "postgres";
//$varBd["pass"] = "mttpocos";
//    $conexao = pg_connect("localhost", "'", "mttpocos")
//pg_connect("host=localhost port=5432 dbname=gestao_work user=postgres password=mttpocos")   or
//die ("Não foi possível conectar ao servidor PostGreSQL");
//exit;
//$bd = novaConexao($varBd["sgbd"], $varBd["host"] , $varBd["base"], $varBd["user"], $varBd["pass"]);    
// $bd = $objBDNovo = novaConexao("postgres", "179.188.16.134:5432", "base_mmflow", "base_mmflow", "mttpocos"); // Locaweb
$bd = $objBDNovo = novaConexao("postgres", "ap5.cnd.hostlp.cloud:5432", "gestao_work", "postgres", "mttpocos"); // GHA
//$bd = $objBDNovo = novaConexao("postgres", "localhost", "gestao_work", "postgres", "mttpocos"); // GHA
// $bd = $objBDNovo = novaConexao("postgres", "localhost", "gestao", "gestao", "mttpocos"); // Locaweb
//$bd = $objBDNovo = novaConexao("postgres", "localhost", "gestao_teste", "postgres", "mttpocos");       



//$appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//$connStr = "host=localhost port=5432 dbname=gestao_work user=postgres password=mttpocos options='--application_name=$appName'";
//
////simple check
//$conn = pg_connect($connStr);
//$result = pg_query($conn, "select * from pg_stat_activity");
//
//var_dump(pg_fetch_all($result));

//print "<pre> 1 -- ";print $result;
//die ("Não foi possível conectar ao servidor PostGreSQL");
//exit();
/**
 * Realiza conexão persistente com o banco de dados
 * @param String $banco Sistema gerenciador utilizado. Ex: postgres
 * @param String $host Link do servidor. Porta padrão sempre utilizada. Caso necessário passar a porta junto. Ex: localhost:5432
 * @param String $base Nome da base a ser utilizada
 * @param String $usuario Nome do usuário para estabelecer a conexão
 * @param String $senha Senha para autenticação no banco de dados
 * @return ADONewConnection Objeto de conexão com o banco de dados 
 */
function novaConexao($banco, $host, $base, $usuario, $senha){       
    
    //Dados de conexão

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

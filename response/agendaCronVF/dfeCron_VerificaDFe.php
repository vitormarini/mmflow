<?php

/**
 * Consulta agendada no Cron Linux -- Vitor Hugo Marini
 * Data Criação : 14/06/2021
 * Descrição: O programa é responsável manifestar a Ciência da Operação e tentar efetuar o Download dos arquivos restantes que estão 
 *   aguardando a autorização para ser feito o Download
 */
require_once "/var/linoforte/gestao/vendor/autoload.php";
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;

include_once( '/var/linoforte/gestao/response/ControllerSefaz.php' );
include_once( '/var/linoforte/gestao/bdAutoVF.php' ); #Conexão com o Banco de dados Gestão, sem que haja a iteração de algum usuário
include_once( '/var/linoforte/gestao/funcoes.php' );


#Buscando a empresa
$dadosEmpresa       = $bd->Execute($sql = "SELECT cgc, razao_social FROM empresas  WHERE id_empresa = 6;");
$cnpjEmpresa        = $dadosEmpresa->fields['cgc'];
$dataConsulta       = date("Y-m-d");
$horaConsulta       = date("H:i:s");

$config      = requestConfig($dadosEmpresa->fields['cgc'], $dadosEmpresa->fields['razao_social']);
$configJson  = json_encode($config);
$content     = file_get_contents('/var/linoforte/gestao/certificado/'.$dadosEmpresa->fields['cgc'].'.pfx');
$password    = 'lino1748';  


$chaveAcesso = "35210713933552000102550010000001661900440803";

$retorno = sefazConsultaDFeDown($chaveAcesso, $configJson, $content, $password);


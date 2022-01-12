<?php
/**
 * Consulta agendada no Cron Linux -- Vitor Hugo Marini
 * Data Criação : 11/08/2021
 * Descrição: O programa é responsável por coletar as informações registradas na base de dados do e-mail registrado no ERP
 */

require_once "/var/linoforte/gestao/vendor/autoload.php";
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;

include_once( '/var/linoforte/gestao/request/requestEmail.php' );
include_once( '/var/linoforte/gestao/response/ControllerSefaz.php' );
include_once( '/var/linoforte/gestao/bdAuto.php' ); #Conexão com o Banco de dados Gestão, sem que haja a iteração de algum usuário
include_once( '/var/linoforte/gestao/funcoes.php' );

#Buscando a empresa
$dadosEmpresa       = $bd->Execute($sql = "SELECT cgc, razao_social FROM empresas  WHERE id_empresa = '1';");
$cnpjEmpresa        = $dadosEmpresa->fields['cgc'];
$dataConsulta       = date("Y-m-d");
$horaConsulta       = date("H:i:s");

$config      = requestConfig($dadosEmpresa->fields['cgc'], $dadosEmpresa->fields['razao_social']);
$configJson  = json_encode($config);
$content     = file_get_contents('/var/linoforte/gestao/certificado/'.$dadosEmpresa->fields['cgc'].'.pfx');
$password    = 'lino1748';  

#Verificando a última Consulta
$lastConsult = $bd->Execute($sql = "SELECT data_consulta, hora_consulta, id_t_dfe_service, lastnsu FROM t_dfe_service  ORDER BY 4 DESC,1 DESC, 2 DESC LIMIT 1;");
$lasNsu      = $bd->Execute($sql = "SELECT nsu::int AS lastnsu FROM t_dfe_service_docs WHERE nsu NOT IN ( '','OLD' ) ORDER BY id_t_dfe_service_docs DESC LIMIT 1;");

//Acessando e configurando o Certificado Digital
$tools = new Tools($configJson, Certificate::readPfx($content, $password));

//Único modelo de nota que é favorecido para esse tipo de Consulta além de rodar somente em ambiente de PRODUÇÃO
$tools->model('55');
$tools->setEnvironment(1);

//Consultando o E-mail para efetuar o download de Notas Fiscais emitidas e que estão no E-mail
requestEmail("nfe");    


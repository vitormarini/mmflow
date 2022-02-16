<?php

/**
 * Consulta agendada no Cron Linux -- Vitor Hugo Marini
 * Data Criação : 14/06/2021
 * Descrição: O programa é responsável manifestar a Ciência da Operação e tentar efetuar o Download dos arquivos restantes que estão 
 *   aguardando a autorização para ser feito o Download
 */

//require_once "../../vendor/autoload.php";
require_once "/var/www/html/gestao/vendor/autoload.php";
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;

include_once( '/var/www/html/gestao/response/ControllerSefaz.php' );
include_once( '/var/www/html/gestao/bdAuto.php' ); #Conexão com o Banco de dados Gestão, sem que haja a iteração de algum usuário
include_once( '/var/www/html/gestao/funcoes.php' );

#Buscando a empresa
$dadosEmpresa       = $bd->Execute($sql = "SELECT cgc, razao_social FROM empresas  WHERE id_empresa = 1;");
$cnpjEmpresa        = $dadosEmpresa->fields['cgc'];
$dataConsulta       = date("Y-m-d");
$horaConsulta       = date("H:i:s");

$config      = requestConfig($dadosEmpresa->fields['cgc'], $dadosEmpresa->fields['razao_social']);
$configJson  = json_encode($config);
$content     = file_get_contents('/var/www/html/gestao/certificado/'.$dadosEmpresa->fields['cgc'].'.pfx');
$password    = 'lino1748';  


$chaveAcesso = "33211133041260080338550000317181851121034343";

$retorno = sefazConsultaDFeDown($chaveAcesso, $configJson, $content, $password);

if ( $retorno == "OK" ){
    
    //Verificar os eventos das Notas Fiscais e:
    # Cancelamento -- Código : 110111 ( Bloquear o Usuário de cadastrar o documento no sistema, e apresentar modal com a Informação )
    # C. Correção  -- Código : 110110 ( Apresentar a descrição do que foi corrigido na carta de correção e no PDF tanto para o XML quanto Banco, apresentar todas as cartas de correção aplicada na NF-e )
    
}


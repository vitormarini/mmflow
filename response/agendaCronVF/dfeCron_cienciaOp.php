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
$dadosEmpresa       = $bd->Execute($sql = "SELECT cgc, razao_social FROM empresas  WHERE id_empresa = '6';");
$cnpjEmpresa        = $dadosEmpresa->fields['cgc'];
$dataConsulta       = date("Y-m-d");
$horaConsulta       = date("H:i:s");

$config      = requestConfig($dadosEmpresa->fields['cgc'], $dadosEmpresa->fields['razao_social']);
$configJson  = json_encode($config);
$content     = file_get_contents('/var/linoforte/gestao/certificado/'.$dadosEmpresa->fields['cgc'].'.pfx');
$password    = 'lino1748';  

$dataXML = $bd->Execute($sql = 
 "SELECT chnfe, substring(dhrecbto,1,4) AS ano, substring(dhrecbto, 6,2) AS mes, status 
    FROM t_dfe_service_docs 
   WHERE status     IN ( 'ABERTO' )
     AND tipo       IN ( 'resNFe' ,'procNF' )   
     AND chnfe NOT  IN ( SELECT chnfe FROM t_dfe_service_docs WHERE status IN ( 'CIENCIA_OPERACAO_DOWNLOAD', 'CANCELADA', '_ERRO_','CANCELADA_FORA_PRAZO' ) AND tipo IN ( 'procNF' ))  
GROUP BY 1,2,3,4     
ORDER BY substring(dhrecbto, 6,2) DESC;");                         

# - VALIDANDO DADOS
while ( !$dataXML->EOF ){

    //Indicamos o Status inicial, para que entre no LOOP até realmente ser apresentado a CIÊNCIA
     $status = $dataXML->fields['status'];

     while ( $status == "ABERTO" ){

         sendCienciaOp($dataXML->fields['chnfe'], '', "210210", 94, $configJson, $content, $password, "", $dadosEmpresa->fields['cgc']);

        $buscaStatus = $bd->Execute("SELECT status FROM t_dfe_service_docs WHERE chnfe = '{$dataXML->fields['chnfe']}' GROUP BY 1;");
        $status = $buscaStatus->fields['status'];
     } 

    $dataXML->MoveNext();
}


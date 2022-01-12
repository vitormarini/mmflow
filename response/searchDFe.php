<?php
/**
 * Estrutura Embasada em - https://github.com/vitormarini/send-mail
 * Author: Vitor Hugo Marini
 * Data Criação: 24/03/2021
 * Envio de E-mail ERP-Gestão.
 */
include_once( '../bd.php' );
include_once( '../funcoes.php' );

require_once "{$_SERVER['DOCUMENT_ROOT']}/gestao/vendor/autoload.php";
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;

$config = [
    "atualizacao"   => "2015-10-02 06:01:21",
    "tpAmb"         => 1,
    "razaosocial"   => "Linoforte Móveis Ltda",
    "siglaUF"       => "SP",
    "cnpj"          => "53336244000106",
    "schemes"       => "PL_009_V4",
    "versao"        => "4.00",
    "tokenIBPT"     => "",
    "CSC"           => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
    "CSCid"         => "000002",
    "aProxyConf"    => [
        "proxyIp"       => "",
        "proxyPort"     => "",
        "proxyUser"     => "",
        "proxyPass"     => ""
    ]
];

$configJson  = json_encode($config);
$content     = file_get_contents('1009613009_linoforte.pfx');
$password    = 'lino1748';    

$tools = new Tools($configJson, Certificate::readPfx($content, $password));

//só funciona para o modelo 55
$tools->model('55');
//este serviço somente opera em ambiente de produção
$tools->setEnvironment(1);

//este numero deverá vir do banco de dados nas proximas buscas para reduzir 
//a quantidade de documentos, e para não baixar várias vezes as mesmas coisas.
$ultNSU = 0;
$maxNSU = $ultNSU;
$loopLimit = 50;
$iCount = 0;

//executa a busca de DFe em loop
while ($ultNSU <= $maxNSU) {
    $iCount++;
    if ($iCount >= $loopLimit) {
        break;
    }
    try {
        //executa a busca pelos documentos
        $resp = $tools->sefazDistDFe($ultNSU);
    } catch (\Exception $e) {
        echo $e->getMessage();
        //tratar o erro
    }
 
    
    //extrair e salvar os retornos
    $dom = new \DOMDocument();
    $dom->loadXML($resp);
    $node = $dom->getElementsByTagName('retDistDFeInt')->item(0);
    $tpAmb = $node->getElementsByTagName('tpAmb')->item(0)->nodeValue;
    $verAplic = $node->getElementsByTagName('verAplic')->item(0)->nodeValue;
    $cStat = $node->getElementsByTagName('cStat')->item(0)->nodeValue;
    $xMotivo = $node->getElementsByTagName('xMotivo')->item(0)->nodeValue;
    $dhResp = $node->getElementsByTagName('dhResp')->item(0)->nodeValue;
    $ultNSU = $node->getElementsByTagName('ultNSU')->item(0)->nodeValue;
    $maxNSU = $node->getElementsByTagName('maxNSU')->item(0)->nodeValue;
    $lote = $node->getElementsByTagName('loteDistDFeInt')->item(0);
    if (empty($lote)) {
        //lote vazio
        continue;
    }
    //essas tags irão conter os documentos zipados
    $docs = $lote->getElementsByTagName('docZip');
    
    foreach ($docs as $doc) {
        $numnsu = $doc->getAttribute('NSU');
        $schema = $doc->getAttribute('schema');
        //descompacta o documento e recupera o XML original
        $content = gzdecode(base64_decode($doc->nodeValue));
        //identifica o tipo de documento
        $tipo = substr($schema, 0, 6);
        //processar o conteudo do NSU, da forma que melhor lhe interessar
        //esse processamento depende do seu aplicativo
    }
    
    
    if ($ultNSU == $maxNSU) {
       break; //CUIDADO para não deixar seu loop infinito !!
    }
    sleep(2);
}
<?php
/**
 * Consulta agendada no Cron Linux -- Vitor Hugo Marini
 * Data Criação : 14/06/2021
 * Descrição: O programa é responsável por coletar as informações registradas na base de dados da SEFAZ
 */
//include_once "../_conection/_conect.php";
include_once "../../_conection/_conect.php";
//include_once "./_aux.php";

require_once "../../vendor/autoload.php";
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;

//include_once( '../../request/requestEmail.php' );
include_once( '../ControllerSefaz.php' );
include_once('../verificaCertificadoDigital.php');
#include_once( '/var/www/html/gestao/bdAuto.php' ); #Conexão com o Banco de dados Gestão, sem que haja a iteração de algum usuário
//include_once( '../../_man/_aux.php' );


//include_once '../../response/verificaCertificadoDigital.php';

#Buscando a empresa
//$dadosEmpresa       = $bd->Execute($sql = "SELECT cgc, razao_social FROM empresas  WHERE id_empresa = '1';");
//$cnpjEmpresa        = $dadosEmpresa->fields['cgc'];
//$dataConsulta       = date("Y-m-d");
//$horaConsulta       = date("H:i:s");

$config      = requestConfig('40322434840', 'LINKSYM');
$configJson  = json_encode($config);
$content     = file_get_contents('../40322434840_000001010600220.pfx');
$password    = 'zokt@322';  

#Verificando a última Consulta
$lastConsult = $bd->Execute($sql = "SELECT data_consulta, hora_consulta, id_t_dfe_service, lastnsu FROM t_dfe_service  ORDER BY 4 DESC,1 DESC, 2 DESC LIMIT 1;");
$lasNsu      = $bd->Execute($sql = "SELECT nsu::int AS lastnsu FROM t_dfe_service_docs WHERE nsu NOT IN ( '','OLD' ) ORDER BY id_t_dfe_service_docs DESC LIMIT 1;");

//Acessando e configurando o Certificado Digital
$tools = new Tools($configJson, Certificate::readPfx($content, $password));
$dataValidade = readCert('../40322434840_000001010600220.pfx', 'zokt@322', 'VALIDADE') ;  
//print"<pre>";
//print_r($dataValidade);
//exit;

//Único modelo de nota que é favorecido para esse tipo de Consulta além de rodar somente em ambiente de PRODUÇÃO
$tools->model('55');
$tools->setEnvironment(1);

//Atualizamos esses valores de NSU para validar a quantidade de Documentos resgatados e não vir repetido as mesmas informações.
$ultNSU    = 1;
$maxNSU    = $ultNSU;
$loopLimit = 50;
$iCount    = 0; 
//Consultando o E-mail para efetuar o download de Notas Fiscais emitidas e que estão no E-mail
//requestEmail("nfe");    


//Iniciando a sequencia de Consultas dos Documentos da RFB
while ($ultNSU <= $maxNSU) {

    # Aqui validamos as consultas para não estourar o contador.
    $iCount++;
    if ($iCount >= $loopLimit) { break; }

    //Valida a chamada da Consulta e Reporta o erro, tendo que tratar.
    try {      
        
        
        
        $dataConsulta       = date("Y-m-d");   
        $horaConsulta       = date("H:i:s");
        
        //Atualizando o valor da última consulta
        $bd->Execute("INSERT INTO t_dfe_service ( data_consulta, hora_consulta, user_consulta, lastnsu ) VALUES ('{$dataConsulta}', '{$horaConsulta}', '94', '{$ultNSU}');");      
        
        exit("tamra vindilino");
        
        $resp = $tools->sefazDistDFe($ultNSU);    
        
    } catch (\Exception $e) {                
        $timeOut = true;
    }

    if ( !$timeOut ){
//print"<pre>";
//        print_r($resp);        
//        exit("tamraa");
        #Leitura do XML pelo DOM
        $dom = new \DOMDocument();
        $dom->loadXML($resp);

        $node       = $dom->getElementsByTagName('retDistDFeInt')->item(0);
        $tpAmb      = $node->getElementsByTagName('tpAmb')->item(0)->nodeValue;
        $verAplic   = $node->getElementsByTagName('verAplic')->item(0)->nodeValue;
        $cStat      = $node->getElementsByTagName('cStat')->item(0)->nodeValue;
        $xMotivo    = $node->getElementsByTagName('xMotivo')->item(0)->nodeValue;
        $dhResp     = $node->getElementsByTagName('dhResp')->item(0)->nodeValue;
        $ultNSU     = $node->getElementsByTagName('ultNSU')->item(0)->nodeValue;
        $maxNSU     = $node->getElementsByTagName('maxNSU')->item(0)->nodeValue;
        $lote       = $node->getElementsByTagName('loteDistDFeInt')->item(0);

        # Valida o Lote, caso esteja vazio, refaz a consulta
        if (empty($lote)) { continue; }

        #Variável que recebe o valor do documento ZIP
        $docs = $lote->getElementsByTagName('docZip');

        foreach ($docs as $doc) {    
            # Pegamos o número inicial e Final de Cada resgate dos documentos
            $numnsu = $doc->getAttribute('NSU');

            # Recuperamos o valor do Schema -- Válido para atualizações e versionamento de Layout
            $schema = $doc->getAttribute('schema');        

            # Recuperamos os valores do documento da forma compactada.
            $content = gzdecode(base64_decode($doc->nodeValue));

            # Identificando o Tipo de Documento
            $tipo = substr($schema, 0, 6);

            //Trazendo o XML bruto em Standerize ( array )
            $st = new Standardize();
            $std = $st->toStd($content);

            // -- Definindo o tipo resNFe
            if ( $tipo == 'resNFe'  ){

                #Organizando os dados que serão gravados na base.
                $chNFe       = $std->chNFe;
                $cnpj        = $std->CNPJ;
                $xNome       = $std->xNome;
                $ie          = $std->IE;
                $tpNF        = $std->tpNF;
                $vNF         = $std->vNF;
                $dhRecbto    = $std->dhRecbto;
                $nProt       = $std->nProt;
                $cSitNfe     = $std->cSitNFe;
                $digVal      = $std->digVal;
                $arquivo     = $chNFe."--{$tipo}.xml";      
                $xSchema     = $tipo;

                //Dados que são vazios pra essa condição
                $cUF         = "";                $cNF         = "";
                $serie       = "";                $mod         = "";
                $dhEmi       = "";                $verAplic    = "";
                $cStat       = "";                $xMotivo     = "";   
                $idEvento    = "";                $verAplic    = "";
                $tpEvento    = "";                $xEvento     = "";
                $nSeqEvento  = "";                $dhRegEvento = "";
                $dhEvento    = "";

                $imprime = false;
            }
            // -- Definindo o tipo procNF
            else if ( $tipo == "procNF" ){

                #Organizando os dados que serão gravados na base.
                $chNFe       = $std->protNFe->infProt->chNFe;
                $cnpj        = $std->NFe->infNFe->emit->CNPJ;
                $xNome       = $std->NFe->infNFe->emit->xNome;
                $ie          = $std->NFe->infNFe->emit->IE;
                $tpNF        = $std->NFe->infNFe->ide->tpNF;
                $vNF         = $std->NFe->infNFe->total->ICMSTot->vNF;
                $dhRecbto    = $std->protNFe->infProt->dhRecbto;
                $nProt       = $std->protNFe->infProt->nProt;            
                $digVal      = $std->protNFe->infProt->digVal;
                $arquivo     = $chNFe."--{$tipo}.xml";     
                $cUF         = $std->NFe->infNFe->ide->cUF;
                $cNF         = $std->NFe->infNFe->ide->cNF;
                $serie       = $std->NFe->infNFe->ide->serie;
                $mod         = $std->NFe->infNFe->ide->mod;
                $dhEmi       = $std->NFe->infNFe->ide->dhEmi;
                $verAplic    = $std->protNFe->infProt->verAplic;
                $cStat       = $std->protNFe->infProt->cStat;
                $xMotivo     = $std->protNFe->infProt->xMotivo; 
                $xSchema     = $tipo;
                $idEvento    = $std->NFe->infNFe->attributes->Id;

                //Dados que são vazios pra essa condição
                $cSitNfe     = "";                $tpEvento    = "";
                $xEvento     = "";                $nSeqEvento  = "";
                $dhRegEvento = "";                $dhEvento    = "";

                $imprime = false;
            }
            // -- Definindo o tipo procEv
            else if ( $tipo == 'procEv' ){

                #Organizando os dados que serão gravados na base.
                $chNFe       = $std->evento->infEvento->chNFe;
                $cnpj        = $std->evento->infEvento->CNPJ;                                    
                $nProt       = $std->retEvento->infEvento->nProt;            
                $arquivo     = $chNFe."--{$tipo}.xml";      
                $xSchema     = $tipo;
                $idEvento    = $std->evento->infEvento->attributes->Id;
                $xMotivo     = $std->retEvento->infEvento->xMotivo;
                $cStat       = $std->retEvento->infEvento->cStat;
                $verAplic    = $std->retEvento->infEvento->verAplic;
                $tpEvento    = $std->retEvento->infEvento->tpEvento;
                $xEvento     = $std->retEvento->infEvento->xEvento;
                $nSeqEvento  = $std->retEvento->infEvento->nSeqEvento;
                $dhRegEvento = $std->retEvento->infEvento->dhRegEvento;
                $dhEvento    = $std->retEvento->infEvento->dhEvento;

                //Dados que são vazios pra essa condição
                $xNome       = "";                $ie          = "";
                $tpNF        = "";                $vNF         = "0";
                $dhRecbto    = "";                $cSitNfe     = "";
                $digVal      = "";

                $cUF        = "";                $cNF        = "";
                $serie      = "";                $mod        = "";
                $dhEmi      = "";                $tpNF       = "";
                $verAplic   = "";

                $imprime = false;
            }
            // -- Definindo o tipo resEve
            else if ( $tipo == 'resEve' ){

                #Organizando os dados que serão gravados na base.
                $chNFe       = $std->chNFe;
                $cnpj        = $std->CNPJ;            
                $dhEvento    = $std->dhEvento;
                $tpEvento    = $std->tpEvento;
                $nSeqEvento  = $std->nSeqEvento;
                $xEvento     = $std->xEvento;
                $dhRecbto    = $std->dhRecbto;            
                $nProt       = $std->nProt;                                                                        
                $arquivo     = $chNFe."--{$tipo}.xml";      
                $xSchema     = $tipo;

                //Dados que são vazios pra essa condição
                $cUF         = "";                $cNF         = "";
                $serie       = "";                $mod         = "";
                $dhEmi       = "";                $verAplic    = "";
                $cStat       = "";                $xMotivo     = "";   
                $idEvento    = "";                $verAplic    = "";            
                $dhRegEvento = "";                $digVal      = "";
                $cSitNfe     = "";                $xNome       = "";
                $ie          = "";                $tpNF        = "";
                $vNF         = "0";

                $imprime = false;
            }
            else {
                print($tipo."</br>");
                exit;
            }

            //Validando se o evento já foi gravado
            $dadosValid = $bd->Execute($sql = "SELECT id_t_dfe_service_docs FROM t_dfe_service_docs WHERE chnfe = '{$chNFe}' AND nprot = '{$nProt}' AND tipo = '{$xSchema}';");
            print($sql."<br>");

            if ( $dadosValid->RecordCount() <= 0 ){

                //Após a leitura do Documento vamos gravar no banco de dados
                $bd->Execute($sql = 
                "INSERT INTO public.t_dfe_service_docs
                    (chnfe                                          , cnpj          , nome          , ie            , tpnf          , vnf            , dhrecbto          , nprot         , digval
                   , path                                           , cuf           , cnf           , serie         , mod           , dhemi          , veraplic          , cstat         , xmotivo
                   , tipo                                           , id_evento     , csitnfe       , tpevento      , xevento       , nseqevento     , dhregevento       , dhevento      , status
                   , id_t_dfe_service                               , nsu)
                VALUES(
                    '{$chNFe}'                                      , '{$cnpj}'     , '{$nome}'     , '{$ie}'       , '{$tpNF}'     , '{$vNF}'       , '{$dhRecbto}'     , '{$nProt}'    , '{$digVal}'
                  , '{$arquivo}'                                    , '{$cUF}'      , '{$cNF}'      , '{$serie}'    , '{$mod}'      , '{$dhEmi}'     , '{$verAplic}'     , '{$cStat}'    , '{$xMotivo}'
                  , '{$tipo}'                                       , '{$idEvento}' , '{$cSitNfe}'  , '{$tpEvento}' , '{$xEvento}'  , '{$nSeqEvento}', '{$dhRegEvento}'  , '{$dhEvento}' , 'ABERTO'
                  , {$lastConsult->fields['id_t_dfe_service']}      , '{$numnsu}');");

            }       

            //Auxiliar na impressão para validações
            if ( $imprime ){
                print"<pre>";
                print_r($std);
                exit;
            }

        }
    }else{
        $ultNSU ++;
        
        print"<pre>";
        print_r($resp);        
        exit("tamraa");
    }

    #AQUI Validamos o LOOP, tomando cuidado pra não ficar Infinito
    if ($ultNSU == $maxNSU) {
       break; //CUIDADO para não deixar seu loop infinito !!
    }
    sleep(2);
}

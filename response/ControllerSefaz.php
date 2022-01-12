<?php 
/*
* DATA CRIAÇÃO 03/02/2021
* Author: Vitor Hugo Marini
* INTEGRADOR DE COMUNICAÇÃO COM SEFAZ
* 1 - Variáveis fixas de Configuração
* 1 - Confirma a operação de Manifesto atribuído a NFE 1 Ciência da Operação 2 Manifestação de Destinatário e etc...
* 2 - Efetua o Download do documento selecionado
* @read about to documentation - https://github.com/nfephp-org/sped-nfe
*/
date_default_timezone_set('America/Sao_Paulo');

require_once "../vendor/autoload.php";
include_once( '../_man/_aux.php' );
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;

/**
 * 1 - Método de Configurações - Aqui iremos trabalhar as configurações de cada tipo de empresa.
 * @return type
 * @references - https://github.com/nfephp-org/sped-nfe/blob/master/docs/Config.md
    _________________________________________________________________________________________________________________________________________
   |Campo             |          Descricação                                     |       Uso                                                 |
    -----------------------------------------------------------------------------------------------------------------------------------------
   |atualização       | Datatime da última atualização dos dados                 | Apenas uma referência. Não tem utilidade real             |
   |tpAmb             | Tipo de Ambiente 1 - PRODUÇÃO ou 2 - HOMOLOGAÇÃO         | Estabelece o ambiente base com o qual a API irá operar    |
   |razaosocial       | Nome completo do Usuário                                 | Será usado em algumas classes ( Tools:class )             |
   |siglaUF           | Sigla da unidade da Federação do usuário                 | Direciona todas a chamadas aos webservices                |
   |cnpj              | Numero do CNPJ do usuário                                | Fundamental para várias operações e validações            |
   |schemes           | Nome da pasta onde estão os schemas                      | Fundamental p/ validações das mensagens com a versão certa|
   |versao            | Numero de versão do layout                               | Fundamental para a localização correta dos arquivos XSD   |
   |tokenIBPT         | Token de segurança fornecido pelo IBPT                   | Necessário se desejar buscar os impostos no IBPT          |
   |CSC               | Token de segurança fornecido pela SEFAZ para NFCe        | Necessário para TODAS as operações com NFCe               |
   |CSCid             | ID do Token fornecido pela SEFAZ para NFCe               | Necessário para TODAS as operações com NFCe               |
   |aProxyConf        | Array contendo os dados abaixo                           | Necessário para atravessar um PROXY (se existir)          |
   |proxyIp           | Número IP do proxy da rede interna                       | Se houver um proxy, deve ser indicado o número do seu IP  |
   |proxyPort         | Número da porta do proxy da rede interna                 | Se houver um proxy esse campo deve conter o n da porta    |
   |proxyUser         | Nome do usuário do proxy da rede interna                 | Indicar apenas se a autenticação for obrigatória          |
   |proxyPass         | Password do usuário do proxy da rede interna             | Indicar apenas se a autenticação for obrigatória          |
    -----------------------------------------------------------------------------------------------------------------------------------------
 */
function requestConfig($identificador, $razao){
    
    return $config = [
        "atualizacao"   => "2015-10-02 06:01:21",
        "tpAmb"         => 1,
        "razaosocial"   => "$razao",
        "siglaUF"       => "SP",
        "cnpj"          => "$identificador",
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
    
}

/**
 * 2 - Método de manifestação do destinatário aqui iremos efetuar a @ CIÊNCIA DA OPERAÇÃO, para a nota ser efetuada o Download.
 * @global type $bd
 * @param type $chNFe
 * @param type $idNota
 * @param type $tpEvento
 *     -> Confirmação da Operação - Codigo 210200 - Justifica ( Não obrigatória )
       -> Ciência da Emissão      - Codigo 210210 - Justifica ( Não obrigatória )
       -> Desconhecimento da Op.  - Codigo 210220 - Justifica ( Não obrigatória )
       -> Operação não Realizada  - Codigo 210240 - Justifica ( Obrigatória     )
 * @param type $id_usuario
 * @param type $configJson
 * @param type $content
 * @param type $password
 * @param string $xJus
 */
function sendCienciaOp($chNFe, $idNota, $tpEvento, $id_usuario, $configJson, $content, $password, $xJust, $xCNPJ){
       
    global $bd;

    try {
         //Chamando a construção das ferramentas ( Tools )
        $tools = new Tools($configJson, Certificate::readPfx($content, $password));

        //Somente são consultados Notas Fiscais com Modelo 55
        $tools->model('55');              

        //Dispara contra a Receita
        $response = $tools->sefazManifesta($chNFe,$tpEvento,$xJust = '',$nSeqEvento = 1);    

        //Obtem o retorno e "descompactamos
        $st  = new Standardize($response);
        $arr = $st->toArray();
       
        //Registramos a Ocorrência
        $sqlAtualiza = 
        "INSERT INTO nota_manifesto_destinatario 
                (id_nota                                                ,  chave_acesso_consultada                              ,  idlote
              ,  veraplicac                                             ,  cstat                                                ,  xmotivo
              ,  tpevento                                               ,  xevento                                              ,  seqevento
              ,  dhregevento                                            ,  id_usuario                                           ,  nprot) 
        VALUES( '{$idNota}'                                             , '{$chNFe}'                                            , '{$arr["idLote"]}'
              , '{$arr["verAplic"]}'                                    , '{$arr["retEvento"]["infEvento"]["cStat"]}'           , '{$arr["retEvento"]["infEvento"]["xMotivo"]}'
              , '{$arr["retEvento"]["infEvento"]["tpEvento"]}'          , '{$arr["retEvento"]["infEvento"]["xEvento"]}'         , '{$arr["retEvento"]["infEvento"]["nSeqEvento"]}'
              , '{$arr["retEvento"]["infEvento"]["dhRegEvento"]}'       , '{$id_usuario}'                                       , '{$arr["retEvento"]["infEvento"]["nProt"]}');";             
              
        if ( $bd->Execute(replaceEmptyFields($sqlAtualiza)) ) {             
            //Atualizando a tabela t_dfe_service_docs
            $bd->Execute($sql = "UPDATE t_dfe_service_docs SET status = 'CIENCIA_OPERACAO' WHERE chnfe = '{$chNFe}';");
        }else{
            $bd->Execute($sql = "UPDATE t_dfe_service_docs SET status = 'CIENCIA_OPERACAO_' WHERE chnfe = '{$chNFe}';");
        }
                
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
}

function comunicaNFe($chNFe, $idNota, $tpEvento, $id_usuario, $configJson, $content, $password, $xJust, $cnpj){
       
    global $bd;

    try {
        
        //Chamando a construção das ferramentas ( Tools )
        $tools = new Tools($configJson, Certificate::readPfx($content, $password));

        //Somente são consultados Notas Fiscais com Modelo 55
        $tools->model('55');

        
        //Dispara contra a Receita
        $response = $tools->sefazManifesta($chNFe,$tpEvento,$xJust,$nSeqEvento = 1);    

        //Obtem o retorno e "descompactamos
        $st  = new Standardize($response);
        $arr = $st->toArray();
       
        //Registramos a Ocorrência
        $sqlAtualiza = 
        "INSERT INTO nota_manifesto_destinatario 
                (id_nota                                                ,  chave_acesso_consultada                              ,  idlote
              ,  veraplicac                                             ,  cstat                                                ,  xmotivo
              ,  tpevento                                               ,  xevento                                              ,  seqevento
              ,  dhregevento                                            ,  id_usuario                                           ,  nprot) 
        VALUES( '{$idNota}'                                             , '{$chNFe}'                                            , '{$arr["idLote"]}'
              , '{$arr["verAplic"]}'                                    , '{$arr["retEvento"]["infEvento"]["cStat"]}'           , '{$arr["retEvento"]["infEvento"]["xMotivo"]}'
              , '{$arr["retEvento"]["infEvento"]["tpEvento"]}'          , '{$arr["retEvento"]["infEvento"]["xEvento"]}'         , '{$arr["retEvento"]["infEvento"]["nSeqEvento"]}'
              , '{$arr["retEvento"]["infEvento"]["dhRegEvento"]}'       , '{$id_usuario}'                                       , '{$arr["retEvento"]["infEvento"]["nProt"]}');";

        if ( $bd->Execute(replaceEmptyFields($sqlAtualiza)) ) {             
            
            $st = new Standardize();
            $stdXml = $st->toStd($xml); 
                        
            #EXPORTANDO O XML PARA O CAMINHO DESEJADO
            $filename = "{$_SERVER['DOCUMENT_ROOT']}/gestao/dfe_terceiros/".date("Y")."/".date("m")."/{$cnpj}/NFe{$chave}--resNfe.xml";   
            
             if ( file_put_contents($filename, $xml) ){
                //Atualizando a tabela t_dfe_service_docs
                $bd->Execute($sql = "UPDATE t_dfe_service_docs SET status = 'OPERACAO_NAO_REALIZADA' WHERE chnfe = '{$chNFe}';");            
             }
        }else{
            $bd->Execute($sql = "UPDATE t_dfe_service_docs SET status = 'OPERACAO_NAO_REALIZADA_' WHERE chnfe = '{$chNFe}';");
        }
                
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
}

/**
 * 3 - Método que efetua os Downloads dos Documentos, mapeia os que estão cancelados e validamos as informações.
 * @global type $bd
 * @param type $chave
 * @param type $configJson
 * @param type $content
 * @param type $password
 * @param type $mes
 * @param type $ano
 * @param type $cnpj
 */
function sefazDownloadDFe($chave, $configJson, $content, $password, $mes, $ano, $cnpj, $tipo){
    
    global $bd;       
    
    //Seta o certiicado.
    $tools = new Tools($configJson, Certificate::readPfx($content, $password));
    
    //Setando o modelo
    $tools->model('55');
            
    //Seta o ambiente - Somente em produção.
    $tools->setEnvironment(1);
            
    //Envio da requisição e armazenamento do retorno
    if ( $response = $tools->sefazDownload($chave) ){
        
        
        $stz = new Standardize($response);
        
        $std = $stz->toStd(); 
//        print"<pre>";
//        print($sql);
//        print_r($std);
//        exit;
        
        $dadosChave = $bd->Execute($sql = "SELECT tipo FROM t_dfe_service_docs tdsd WHERE chnfe = '{$chave}' AND tipo = 'procNF';");           
        
        
        //Verificando se o documento não está devidamente autorizado.
        if ($std->cStat != 138) {
                       
            $zip = $std->loteDistDFeInt->docZip;
            $xml = gzdecode(base64_decode($zip));   
            
            
            
            #STATUS CANCELADO
            if ( $std->cStat == "653" ){
                                
                #EXPORTANDO O XML PARA O CAMINHO DESEJADO
                $filename = "/var/linoforte/gestao/dfe_terceiros/{$ano}/{$mes}/{$cnpj}/NFe{$chave}--cancelada.xml";   
                
//                if ( file_put_contents($filename, $xml) ){            
                    $bd->Execute("UPDATE t_dfe_service_docs SET cstat = '{$std->cStat}', xmotivo = '{$std->xMotivo}', status='CANCELADA' WHERE chnfe = '{$chave}';");                                        
//                }
            }
            else if ( $std->cStat == "640" ){// Quando foi cancalado, algum documento que não era parte da empresa que está sendo executado!
                 $bd->Execute("UPDATE t_dfe_service_docs SET cstat = '{$std->cStat}', xmotivo = '{$std->xMotivo}', status='_ERRO_' WHERE chnfe = '{$chave}';");                                        
            }
            else {
                
                $consultaNF = $bd->Execute($sql = "SELECT id_nota_manifesto_destinatario FROM nota_manifesto_destinatario nmd WHERE chave_acesso_consultada = '{$chave}' AND xevento = 'Confirmacao da Operacao';");
               
                if( $consultaNF->RecordCount() <= 0 ){
                    #EXPORTANDO O XML PARA O CAMINHO DESEJADO
                    $filename = "/var/linoforte/gestao/dfe_terceiros/{$ano}/{$mes}/{$cnpj}/NFe{$chave}--_erro_.xml";      
                    
                    file_put_contents($filename, $xml) ;
//                    if ( file_put_contents($filename, $xml) ){   
                        $bd->Execute("UPDATE t_dfe_service_docs SET cstat = '{$std->cStat}', xmotivo = '{$std->xMotivo}', status='_ERRO_' WHERE chnfe = '{$chave}';");                        
//                    }
                }
            
            }
            
            
        }else{                        
            
            $zip = $std->loteDistDFeInt->docZip;
            $xml = gzdecode(base64_decode($zip));                        
                        
            
//             print"<pre>";
////        print($sql);
//        print_r($xml);
//        exit;
            
            if ( $tipo == "unica" || $dadosChave->RecordCount() <= 0){
                //Se o tipo for para consultar único
                $arrXML      = simplexml_load_string($xml);
                $xmlJson     = json_encode($arrXML);
                $xmlArr      = json_decode($xmlJson,TRUE);

                 print"<pre>";
//        print($sql);
//        print_r($arrXML);
//        exit;
                
                #Organizando os dados que serão gravados na base.
                $nome        = $xmlArr["NFe"]["infNFe"]["emit"]["xNome"];
                $chNFe       = $xmlArr["protNFe"]["infProt"]["chNFe"];
                $cnpj_       = $xmlArr["NFe"]["infNFe"]["emit"]["CNPJ"];
                $xNome       = $xmlArr["NFe"]["infNFe"]["emit"]["xNome"];
                $ie          = $xmlArr["NFe"]["infNFe"]["emit"]["IE"];
                $tpNF        = $xmlArr["NFe"]["infNFe"]["ide"]["tpNF"];
                $vNF         = $xmlArr["NFe"]["infNFe"]["total"]["ICMSTot"]["vNF"];
                $dhRecbto    = $xmlArr["protNFe"]["infProt"]["dhRecbto"];
                $nProt       = $xmlArr["protNFe"]["infProt"]["nProt"];            
                $digVal      = $xmlArr["protNFe"]["infProt"]["digVal"];
                $arquivo     = "{$chave}--procNfe.xml";
                $cUF         = $xmlArr["NFe"]["infNFe"]["ide"]["cUF"];
                $cNF         = $xmlArr["NFe"]["infNFe"]["ide"]["cNF"];
                $serie       = $xmlArr["NFe"]["infNFe"]["ide"]["serie"];
                $mod         = $xmlArr["NFe"]["infNFe"]["ide"]["mod"];
                $dhEmi       = $xmlArr["NFe"]["infNFe"]["ide"]["dhEmi"];
                $verAplic    = $xmlArr["protNFe"]["infProt"]["verAplic"];
                $cStat       = $xmlArr["protNFe"]["infProt"]["cStat"];
                $xMotivo     = $xmlArr["protNFe"]["infProt"]["xMotivo"]; 
                $tipo        = "procNF";
                $idEvento    = $xmlArr["NFe"]["infNFe"]["@attributes"]["Id"];

                //Dados que são vazios pra essa condição
                $cSitNfe     = "";                $tpEvento    = "";
                $xEvento     = "";                $nSeqEvento  = "";
                $dhRegEvento = "";                $dhEvento    = "";

                #Validando caso o Documento não tenha informação então não gravaremos
                if ( $xNome != "" && $idEvento != "" ){
                    $sql = 
                    "INSERT INTO public.t_dfe_service_docs
                        (chnfe                                          , cnpj          , nome          , ie            , tpnf          , vnf            , dhrecbto          , nprot         , digval
                       , path                                           , cuf           , cnf           , serie         , mod           , dhemi          , veraplic          , cstat         , xmotivo
                       , tipo                                           , id_evento     , csitnfe       , tpevento      , xevento       , nseqevento     , dhregevento       , dhevento      , status
                       , id_t_dfe_service                               , nsu)
                    VALUES(
                        '{$chNFe}'                                      , '{$cnpj_}'    , '{$nome}'     , '{$ie}'       , '{$tpNF}'     , '{$vNF}'       , '{$dhRecbto}'     , '{$nProt}'    , '{$digVal}'
                      , '{$arquivo}'                                    , '{$cUF}'      , '{$cNF}'      , '{$serie}'    , '{$mod}'      , '{$dhEmi}'     , '{$verAplic}'     , '{$cStat}'    , '{$xMotivo}'
                      , '{$tipo}'                                       , '{$idEvento}' , '{$cSitNfe}'  , '{$tpEvento}' , '{$xEvento}'  , '{$nSeqEvento}', '{$dhRegEvento}'  , '{$dhEvento}' , 'CIENCIA_OPERACAO_DOWNLOAD'
                      , NULL                                            , '{$numnsu}');";

                      $bd->Execute($sql);
                }
            }

                        
            #EXPORTANDO O XML PARA O CAMINHO DESEJADO
            $filename = "/var/linoforte/gestao/dfe_terceiros/{$ano}/{$mes}/{$cnpj}/NFe{$chave}--procNfe.xml";  
//            print"<pre>";
//            print($filename);
//            exit;
            
            if ( file_put_contents($filename, $xml) ){
                
                $bd->Execute("UPDATE t_dfe_service_docs SET status = 'CIENCIA_OPERACAO_DOWNLOAD' WHERE id_t_dfe_service_docs IN (SELECT id_t_dfe_service_docs FROM t_dfe_service_docs WHERE chnfe = '{$chave}' AND tipo IN ( 'resNFe','procNF' ) );");
                $bd->Execute("UPDATE t_dfe_service_docs SET status = 'CIENCIA_OPERACAO_DOWNLOAD' WHERE chnfe = '{$chave}';");
                
            }                        
                       
        }
                                
    }else{
        print "FAULT_TIME_OUE";
    }            
}

/**
 * Consulta do Documento Fiscal e Visualização Do Status
 * @global type $bd
 * @param type $chave
 * @param type $configJson
 * @param type $content
 * @param type $password
 *              Código cStat - NF-e
 *              100 - Autorizado o uso da NF-e                          ( Evendo que possibilita a utilização da NF-e              ) ***
 *              101 - Cancelamento de NF-e Homologado                   ( Retorno desativado                                       ) ***
 *              103 - Inutilização do número homologado                 ( Quando a sequência do número for inutilizada             ) ***
 *              104 - Lote processado                                   ( Quando o lote já estiver processado                      )
 *              105 - Lote em processamento                             ( Ainda não terminou de processar o arquivo                )
 *              106 - Lote não localizado                               ( Quando a consulta pelo número não for identificada       )
 *              108 - Serviço Paralisado Momentaneamente ( curto prazo )( Paralização da SEFAZ, por curto prazo                    )
 *              109 - Serviço paralisado sem Previsão                   ( Paralização sem prazo de volta ( Contingência )          )
 *              110 - Uso Denegado                                      ( Equívoco na construção do XML com os dados               )
 *              111 - Consulta cadastro com uma ocorrência              ( Consulta específica do contribuínte ao registro          )
 *              112 - Consulta cadastro com mais de uma ocorrência      ( Consulta em lote de resgistros pelo contribuínte         ) 
 *              107 - Serviço SVC em operação                           ( Quando o servidor estiver em operação                    )
 *              113 - SVC em processo de desativação                    ( Quandando o servidor vai ser desativado ou desligado     )
 *              114 - SVC desabilitada pela SEFAZ de Origem             ( Sómente em consulta de STATUS, verificando a SEFAZ       )
 *              128 - Lote de Evento Processado                         ( Aguardando o retorno dos eventos de Recebido ou Rejeição )
 *              135 - Evento registrado e vinculado a NF-e              ( Evento correto e esperado                                )
 *              136 - Evento registrado, mas não vinculado a NF-e       ( Quando o WebService da RFB não está operando normalmente )
 *              151 - Cancelamento Fora do Prazo                        ( Registro de cancelamento Fora do Prazo                   )
 *              
 */
function sefazConsultaDFeDown($chave, $configJson, $content, $password){
    
    global $bd;       
    
    //Seta o certiicado.
    $tools = new Tools($configJson, Certificate::readPfx($content, $password));
            
    //Setando o modelo
    $tools->model('55');
            
    //Seta o ambiente - Somente em produção.
    $tools->setEnvironment(1);
         
//    print"<pre>";
//        print_r($tools->sefazConsultaChave($chave));
//        exit;
    //Envio da requisição e armazenamento do retorno
    if ( $response = $tools->sefazConsultaChave($chave) ){
               
        $stz = new Standardize($response);       
        $std = $stz->toStd(); 
        
        
        
        print "<pre>"; print_r($std);
        exit;
               
        #Ajustando a NF-e Quando estiver cancelada 
        if ( $std->cStat == "101" ){
            $bd->Execute("UPDATE t_dfe_service_docs SET status = 'CANCELADA', data_hora_cancelamento = '{$std->dhRecbto}' WHERE chnfe = '{$chave}';");
        }
        else if ( $std->cStat == "151" ){
            $bd->Execute("UPDATE t_dfe_service_docs SET status = 'CANCELADA_FORA_PRAZO', data_hora_cancelamento = '{$std->dhRecbto}' WHERE chnfe = '{$chave}';");
        }
        
        #Lendo os valores dos evendos
        if ( count($std->procEventoNFe) > 0 ){
            
            $nEvt = 1;
            
            foreach ( $std->procEventoNFe as $evt ){
                
                #Tratamento da existencia desse registro
                $dadosVerifica = $bd->Execute($sql = 
                "SELECT id_nota_manifesto_destinatario 
                   FROM nota_manifesto_destinatario
                  WHERE chave_acesso_consultada = '{$chave}'
                    AND dhregevento             = '{$evt->retEvento->infEvento->dhRegEvento}'
                    AND tpevento                = '{$evt->retEvento->infEvento->tpEvento}'
                    AND nprot                   = '{$evt->retEvento->infEvento->nProt}';");
                
                #Verificamos se existe o dado, se o valor é verdadeiro, atualizamos os registros no banco
                if ( $dadosVerifica->RecordCount() > 0 ){
                    $sql = 
                    "UPDATE nota_manifesto_destinatario SET 
                            id_nota                 =(SELECT id_nota FROM nota WHERE chave_acesso = '{$chave}')
                        ,   chave_acesso_consultada ='{$chave}'
                        ,   idlote                  ='{$evt->retEvento->infEvento->attributes->Id}'
                        ,   veraplicac              ='{$evt->retEvento->infEvento->verAplic}'
                        ,   cstat                   ='{$evt->retEvento->infEvento->cStat}'
                        ,   xmotivo                 ='{$evt->retEvento->infEvento->xMotivo}'
                        ,   tpevento                ='{$evt->retEvento->infEvento->tpEvento}'
                        ,   xevento                 ='{$evt->retEvento->infEvento->xEvento}'
                        ,   seqevento               ='{$nEvt}'
                        ,   dhregevento             ='{$evt->retEvento->infEvento->dhRegEvento}'
                        ,   id_usuario              ='{$_SESSION['id_usuario']}'
                        ,   nprot                   ='{$evt->retEvento->infEvento->nProt}' 
                        ,   xcorrecao               ='{$evt->evento->infEvento->detEvento->xCorrecao}'
                        ,   xconduso                ='{$evt->evento->infEvento->detEvento->xCondUso}'
                        ,   xjust                   ='{$evt->evento->infEvento->detEvento->xJust}'
               WHERE id_nota_manifesto_destinatario = {$dadosVerifica->fields['id_nota_manifesto_destinatario']};";               
               $situacao = "UPDATE";
                }else{
                    $sql = 
                    "INSERT INTO nota_manifesto_destinatario (
                            id_nota     
                       ,    chave_acesso_consultada
                       ,    idlote
                       ,    veraplicac
                       ,    cstat
                       ,    xmotivo
                       ,    tpevento
                       ,    xevento
                       ,    seqevento
                       ,    dhregevento
                       ,    id_usuario
                       ,    nprot
                       ,    xcorrecao
                       ,    xconduso
                       ,    xjust
                       ) 
                     VALUES((SELECT id_nota FROM nota WHERE chave_acesso = '{$chave}')
                       ,    '{$chave}'
                       ,    '{$evt->retEvento->infEvento->attributes->Id}'
                       ,    '{$evt->retEvento->infEvento->verAplic}'
                       ,    '{$evt->retEvento->infEvento->cStat}'
                       ,    '{$evt->retEvento->infEvento->xMotivo}'
                       ,    '{$evt->retEvento->infEvento->tpEvento}'
                       ,    '{$evt->retEvento->infEvento->xEvento}'
                       ,     {$nEvt}
                       ,    '{$evt->retEvento->infEvento->dhRegEvento}'
                       ,    '{$_SESSION['id_usuario']}'
                       ,    '{$evt->retEvento->infEvento->nProt}'
                       ,    '{$evt->evento->infEvento->detEvento->xCorrecao}'
                       ,    '{$evt->evento->infEvento->detEvento->xCondUso}'
                       ,    '{$evt->evento->infEvento->detEvento->xJust}'
                           );";
                       $situacao = "INSERT";
                }
                $bd->Execute(replaceEmptyFields($sql));
                $nEvt++;
                
            } 
            
        }
        
        print "OK";
        
    }else{
        print "FAULT_TIME_OUE";
    }            
}

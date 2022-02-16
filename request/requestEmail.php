<?php
/**
 * Request E-Mail - Buscando e-mails de um servidor
 * Author: Vitor Hugo Nunes Marini
 * Data: 15/05/2021
 * Description: programa responsável por buscar informações retidas em e-mails, descriptografá-las e dar continuidade no processo de leitura das matérias primas utilizadas pelo Dpto de Espuma.
 */

#Configuração da Função IMAP Linux e Windows
#https://www.php.net/imap.installation
#sudo service apache2 restart -- Lembrar de reiniciar o APACHE

function requestEmail($funcao){
    global $bd;
    
    $empresa = $_SESSION['empresa'] != "" ? $_SESSION['empresa'] : "1";
    
    $dadosEmpresa       = $bd->Execute($sql = "SELECT cgc FROM empresas  WHERE id_empresa = '{$empresa}';");
    
    if      ( $funcao == "espuma" )   {         $tipoFunc = "ESPUMA";    }
    else if ( $funcao == "nfe" )      {         $tipoFunc = "DFE";       }
    
    $dadosMail = $bd->Execute($sql = 
    "SELECT 
            email_login        ,   email_senha 
    ,       email_seguranca    ,   servidor
    ,       email_porta        ,   timeout 
    FROM    t_email
    WHERE   status = 1 
    AND     funcao =  '{$tipoFunc}' 
    LIMIT   1;");    
    
    if ( $dadosMail->RecordCount() > 0 ){
    
        #Dados necessários para a busca
        #https://support.google.com/mail/answer/7126229?hl=pt-BR
        $servidor = "{$dadosMail->fields['servidor']}";
        $porta    = "{$dadosMail->fields['email_porta']}";
        $seguranca= "{$dadosMail->fields['email_seguranca']}";
        $usuario  = "{$dadosMail->fields['email_login']}";
        $senha    = "{$dadosMail->fields['email_senha']}";    

        #Inicializa o processo, abrindo a caixa de e-mail
        $inbox = imap_open("{".$servidor.":".$porta."/".$seguranca."}INBOX", $usuario, $senha) or die('Não é possivel conectar ao e-mail: ' . imap_last_error());

        /*
         * ALL    - Obtem todos os e-mails 
         * UNSEEN - Obtem somente os e-mails que ainda não foram lidos.
         * Para Atualizações e verificar outras opções - https://www.php.net/manual/pt_BR/function.imap-search.php
         * Ficar atento para o  ** $ Max_emails ** que muitas vezes pode ser limitado para IMAP
        */
        $emails = imap_search($inbox, 'UNSEEN');

        #Utilização somente se o $TIPO for definido como "ALL"
        //$max_emails = 1;
        //$cont = 1;
        //if($count++ >= $max_emails) break; Fim da repetição

        #Se qualquer e-mail for encontrado então iniciamos o processo.
        if($emails) {

            #Ordena do mais novo para o mais antigo
            rsort($emails);

            #Le todos os e-mails que não foram lidos
            foreach($emails as $email_number){

                #Pegando informações ESPECÍFICAS deste e-mail
                $overview = imap_fetch_overview($inbox,$email_number,0);        
                $from = explode(' ',$overview[0]->from);

                #Resgatando as mensagens do E-mail
                $message = imap_fetchbody($inbox,$email_number,2);

                #Resgatando a estrutura do E-mail
                $structure = imap_fetchstructure($inbox, $email_number);
                
                #Array que irá armazenar as informações contidas nos Anéxos
                $attachments = array();

                /* se é encontrado algum anexo... */
                if(isset($structure->parts) && count($structure->parts)) {

                    for($i = 0; $i < count($structure->parts); $i++){

                        $attachments[$i] = array(
                            'is_attachment' => false,
                            'filename'      => '',
                            'name'          => '',
                            'subtype'       => '',
                            'attachment'    => ''
                        );                        
                        
                        #Verificando o tipo do anexo
                        $attachments[$i]["subtype"] = $structure->parts[$i]->subtype;

                        if($structure->parts[$i]->ifdparameters){

                            foreach($structure->parts[$i]->dparameters as $object){

                                if(strtolower($object->attribute) == 'filename'){                                    
                                    $attachments[$i]['is_attachment'] = true;
                                    $attachments[$i]['filename'] = $object->value;
                                }
                            }
                        }

                        if($structure->parts[$i]->ifparameters){

                            foreach($structure->parts[$i]->parameters as $object){

                                if(strtolower($object->attribute) == 'name'){
                                    $attachments[$i]['is_attachment'] = true;
                                    $attachments[$i]['name'] = $object->value;
                                }
                            }
                        }

                        if($attachments[$i]['is_attachment']) {

                            $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);

                            /* 4 = QUOTED-PRINTABLE encoding */
                            if($structure->parts[$i]->encoding == 3){  $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']); }

                            /* 3 = BASE64 encoding */
                            else if($structure->parts[$i]->encoding == 4) { $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);}
                        }
                    }
                }

                /* percorre cada anexo e salva */
                foreach($attachments as $attachment){  
                    

                    if($attachment['is_attachment'] == 1){
                          

                        $grava = false;

                        $filename = $attachment['name'];
                                                                    

                        if(empty($filename)) $filename = $attachment['filename'];

                        if(empty($filename)) $filename = time() . ".dat";

                            

                         //Validamos se existe o caminho e caso não exista grave definitivamente o arquivo   
                        if ( $funcao == "espuma" && explode("_",$filename)[0] == "Bloco"){                                                        
                            $caminho = "/var/linoforte/gestao/request/assets/{$email_number}_" . date("d-m-Y") . "_" . $filename;                                                                                   
                            $grava = ( file_exists(str_replace(".csv","",$caminho)."_LIDO.csv")  ) ? false : true;                                                                                    
                        }
                        else if ( $funcao == "nfe" ){

                            #Verificando se é um XML                            
                            $arquivo = explode(".",strtolower($filename));                            
                           

                            if ( $arquivo[1] == "xml" || $attachment["subtype"] == "xml" || $attachment["subtype"] == "XML" ){

                               
                               #Validamos se já foi baixado ou não
                               $verificaXML = $bd->Execute($sql = "SELECT count(*) AS cont_xml FROM t_dfe_service_docs WHERE chnfe = '{$arquivo[1]}' AND status = 'CIENCIA_OPERACAO_DOWNLOAD';");
                                   
                               
                               #Novas Validações para Apresentação do E-mail
                               if (  $verificaXML->fields['cont_xml'] <= 0  && ( $attachment["subtype"] == "xml" || $attachment["subtype"] == "XML" || $arquivo[1] == "xml" ) ) { print"Entrou"; $valida = true;   } //Se a chave de acesso VEM correta no e-mail
                               else                                                                                                                          { $valida = false;  } //Caso não encontre XML                                                              
                           
                               if ( $valida ){
//                                   print("<br>ENTROU");
                                    $xml         = simplexml_load_string($attachment['attachment']);
                                    $xmlJson     = json_encode($xml);
                                    $xmlArr      = json_decode($xmlJson,TRUE);
                                   
                                   
                                    #Montando a estrutura de gravação
                                    $ch  = str_replace(array("N", "F", "E", "e", "-", "NF-e", "Nf-e", "NF-E", "NFe", " ", "n", "f", "nf", "nfe-", "nfe", "N", "n","F","f","E","e"), "",$arquivo[0]);                                         
                                    $ch  = $xmlArr["protNFe"]["infProt"]["chNFe"];                                    
//                                    $ch  = ( $ch != "" && strlen($ch) < 44 )  ? $ch : $xmlArr["protNFe"]["infProt"]["chNFe"];                                    
                                    $ano = "20".substr(substr($ch,2,4),0,2);
                                    $mes = substr(substr($ch,2,4),2,2);

                                    #Verificando a chave de acesso
                                    $cUF    = substr($ch,0,2);
                                    $AAMM   = substr($ch,2,4);
                                    $CNPJ   = substr($ch,6,14);
                                    $mod    = substr($ch,19,2);
                                    $serie  = substr($ch,21,3);
                                    $nNF    = substr($ch,24,9);
                                    $tpEmis = substr($ch,33,1);
                                    $cNF    = substr($ch,35,8);
                                    $cDV    = substr($ch,43,1);                                   

                                    #Organizando os dados que serão gravados na base.
                                    $nome        = $xmlArr["NFe"]["infNFe"]["emit"]["xNome"];
                                    $chNFe       = $xmlArr["protNFe"]["infProt"]["chNFe"];
                                    $cnpj        = $xmlArr["NFe"]["infNFe"]["emit"]["CNPJ"];
                                    $xNome       = $xmlArr["NFe"]["infNFe"]["emit"]["xNome"];
                                    $ie          = $xmlArr["NFe"]["infNFe"]["emit"]["IE"];
                                    $tpNF        = $xmlArr["NFe"]["infNFe"]["ide"]["tpNF"];
                                    $vNF         = $xmlArr["NFe"]["infNFe"]["total"]["ICMSTot"]["vNF"];
                                    $dhRecbto    = $xmlArr["protNFe"]["infProt"]["dhRecbto"];
                                    $nProt       = $xmlArr["protNFe"]["infProt"]["nProt"];            
                                    $digVal      = $xmlArr["protNFe"]["infProt"]["digVal"];
                                    $arquivo     = "{$ch}--procNfe.xml";
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

                                    $sql = 
                                    "INSERT INTO public.t_dfe_service_docs
                                        (chnfe                                          , cnpj          , nome          , ie            , tpnf          , vnf            , dhrecbto          , nprot         , digval
                                       , path                                           , cuf           , cnf           , serie         , mod           , dhemi          , veraplic          , cstat         , xmotivo
                                       , tipo                                           , id_evento     , csitnfe       , tpevento      , xevento       , nseqevento     , dhregevento       , dhevento      , status
                                       , id_t_dfe_service                               , nsu)
                                    VALUES(
                                        '{$chNFe}'                                      , '{$cnpj}'     , '{$nome}'     , '{$ie}'       , '{$tpNF}'     , '{$vNF}'       , '{$dhRecbto}'     , '{$nProt}'    , '{$digVal}'
                                      , '{$arquivo}'                                    , '{$cUF}'      , '{$cNF}'      , '{$serie}'    , '{$mod}'      , '{$dhEmi}'     , '{$verAplic}'     , '{$cStat}'    , '{$xMotivo}'
                                      , '{$tipo}'                                       , '{$idEvento}' , '{$cSitNfe}'  , '{$tpEvento}' , '{$xEvento}'  , '{$nSeqEvento}', '{$dhRegEvento}'  , '{$dhEvento}' , 'CIENCIA_OPERACAO_DOWNLOAD'
                                      , NULL                                            , '{$numnsu}');";
                                      
                                      if ( $cnpj != "" && $nProt != "" && $dhRecbto != "" ){
                                        $caminho = "/var/linoforte/gestao/dfe_terceiros/{$ano}/{$mes}/{$dadosEmpresa->fields['cgc']}/NFe{$chNFe}--procNfe.xml";    

                                        $grava = true;                                    
                                      }
                                      
                                      
                               }else{
                                   $grava = false;
                               }
                            }                        
                        }

                        //Verificamos se o e-mail já foi lido anteriormente e salvo    
                        if ( $grava ){             
                                                        
                            $fp = fopen($caminho, "w+");
                            fwrite($fp, $attachment['attachment']);
                            fclose($fp);     
            
                            #Armazenando as modificações no banco caso ainda não foram gravadas
                            if ( $funcao == "nfe" ){  
                                $validaGravacao = $bd->Execute("SELECT count(*) nfe_gravadas FROM t_dfe_service_docs WHERE chnfe = '{$chNFe}'  AND tipo = 'procNF';");

                                if ( $validaGravacao->fields['nfe_gravadas'] <= 0 ){
                                    $bd->Execute($sql);                                 
                                }else{
                                    $bd->Execute("UPDATE ,t_dfe_service_docs SET status = 'CIENCIA_OPERACAO_DOWNLOAD' WHERE chnfe = '{$chNFe}';");
                                }
                            }
                        }                        
                    }
                }
            }

            //Caso tenha validado os arquivos
            return "OK";
        }else{
            return "VAZIO";
        }
        #Encerra todas as conexões
        imap_expunge($inbox);
        imap_close($inbox);  
    }
    else {
        return "OK";
    }
          
}
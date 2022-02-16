<?php
/**
 * Estrutura Embasada em - https://github.com/vitormarini/send-mail
 * Author: Vitor Hugo Marini
 * Data Criação: 24/03/2021
 * Envio de E-mail ERP-Gestão.
 */
include_once( '../bd.php' );
include_once( '../funcoes.php' );

//require_once "192.168.50.22/gestao/vendor/autoload.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/gestao/vendor/autoload.php";
use VitorMarini\Mail\Mail;

$arr_email  = json_decode($_POST['arr_emails'],true);


$dadosMail = $bd->Execute($sql = 
"SELECT 
	email_login
,	email_senha 
,	email_seguranca 
,       servidor
,       email_porta
,	timeout 
FROM t_email WHERE status = 1 AND funcao =  'ENVIO_EMAIL' LIMIT 1;");


#Parâmetros do envio
$config = new stdClass();
$config->smtpdebug      = 0; //0-no 1-client 2-server 3-connection 4-lowlevel
$config->host           = "{$dadosMail->fields['servidor']}"; //SMPT, no google deve-se habilitar a utilização de atividades de segurança
$config->port           = "{$dadosMail->fields['email_porta']}"; //25 ou 465 ou 587
$config->smtpauth       = true;
$config->user           = "{$dadosMail->fields['email_login']}";
$config->password       = "{$dadosMail->fields['email_senha']}"; //Senha
$config->secure         = "{$dadosMail->fields['email_seguranca']}"; // Forma de segurança
$config->authtype       = !empty($_POST['assunto_email']) ? $_POST['assunto_email'] : "E-mail teste, Servidor de E-mails ERP-Gestão"; //CRAM-MD5, PLAIN, LOGIN, XOAUTH2
$config->from           = "{$dadosMail->fields['email_login']}"; //Verificar, pois não está enviado para esse e-mail
$config->fantasy        = ''; // Cabeçalho da mensagem
$config->replyTo        = '';
$config->replyName      = '';
$config->smtpoptions    = null; 
$config->timeout        = $dadosMail->fields['timeout']; //Quanto tempo aguardar a conexão para abrir, em segundos. O padrão de 5 minutos (300s) 

try {
    #Instanciação da Classe Mail
    $mail = new Mail($config);

    $corpo      = !empty($_POST['corpo_email']) ? $_POST['corpo_email'] : "Favor não responder, e-mail gerado automaticamente, somente para envio de documentos fiscais.";
    //Corpo do E-mail
    $htmlTemplate = 
    '<html>
        <h2>'. $corpo .'</h2>                        
        <h4>Att, 
            <br>Equipe de T.I. - Linoforte Móveis Ltda 
            <br>ERP - Gestão
            <br>Contato : ( 18 ) - 3528 - 9000 
            <br>Ramais  : 9017 ou 9010
        </h4>
    </html>';
    $mail->loadTemplate($htmlTemplate);

    //XML e PDF inserir o caminho ou o Path / EmailXML - true para enviar os e-mails vinculados ao XML e false para não enviar.
    $xml        = "{$_SERVER['DOCUMENT_ROOT']}/gestao/{$_POST['caminho_xml']}";
//    print"<pre>".$xml;exit;
//    $xml        = "{$_SERVER['DOCUMENT_ROOT']}/gestao/dfe_emissor/NFe_35210453336244000106550030001670351200014540_001.xml";
    $pdf        = '';
    $emailXMl   = $_POST['email_xml'] == "SIM" ? true : false;
    $mail->loadDocuments($xml, $pdf, $emailXMl);        
    
    //Atribui os emails que deverão ser entregues
    $addresses = json_decode($_POST['arr_emails'],true);
    
    //envia emails, se false apenas para os endereçospassados
    //se true para todos os endereços contidos no XML e mais os indicados adicionais
   
    if ( $mail->send($addresses,true) ){
        #Variáveis para gravação
        $idUser             = $_SESSION['id_usuario'];
        $dataHoraOcorrencia = date("d/m/Y H:i:s");
        $emailDe            = "{$dadosMail->fields['email_login']}";
        $emailPara          = implode(",",$addresses);
        $mailXml            = $emailXMl ? 'SIM' : 'NAO';
        
        $bd->Execute($sql = "INSERT INTO public.log_send_mail (id_usuario, data_hora_ocorrencia, email_de, email_para, email_xml) VALUES({$idUser}, '{$dataHoraOcorrencia}', '{$emailDe}', '{$emailPara}','{$mailXml}');");        
        
        print json_encode([
            "status"   => "OK",
            "mensagem" => "Email enviado com sucesso!"
        ]); 
    }
    
} catch (\Exception $e) {
    echo "Falha: " . $e->getMessage();
}  
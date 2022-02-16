<?php

/* 
 * Author: Vitor Hugo Nunes Marini
 * Data Criação: 23/05/2021
 * Description: Função que valida os valores do certificado digital, acessa e confere todos os dados.
 */

function readCert($local, $pass, $retorno){

    //Verificamos se o caminho especificado é existente
    if (!file_exists($local)) {
       $return = "Certificado não encontrado!! " . $local;
    }

    //Agora vamos acessar o certificado e coletar os dados que lá existem
    $pfxContent = file_get_contents($local);

    //Primeiro validamos se a senha está compatível
    if (!openssl_pkcs12_read($pfxContent, $x509certdata, $pass)) {
       $return =  "Senha errada!!!";
    } 
    else {
        #Caso seja compatível, abrimos e exportamos as informações

       $CertPriv   = array();
       $CertPriv   = openssl_x509_parse(openssl_x509_read($x509certdata['cert']));

       $PrivateKey = $x509certdata['pkey'];

       $pub_key = openssl_pkey_get_public($x509certdata['cert']);
       $keyData = openssl_pkey_get_details($pub_key);

       $PublicKey  = $keyData['key'];

       
       # Aqui vamos validar cada tipo de retorno
       switch ($retorno) {
            case "NOME":
                $return =  $CertPriv['name'];
                break;
            case "HASH":
                $return = $CertPriv['hash'];
                break;
            case "PAIS":
                $return = $CertPriv['subject']['C'];
                break;
            case "ESTADO":
                $return = $CertPriv['subject']['ST'];
                break;
            case "MUNICIPIO":
                $return = $CertPriv['subject']['L'];
                break;
            case "END_COMPLETO":
                $return = $CertPriv['subject']['L']." - ".$CertPriv['subject']['ST']." ( ".$CertPriv['subject']['C']." )";
                break;
            case "END_COMPLETO":
                $return = $CertPriv['subject']['L']." - ".$CertPriv['subject']['ST']." ( ".$CertPriv['subject']['C']." )";
                break;
            case "RAZAO_SOCIAL":
                $return =  $CertPriv['subject']['CN'];
                break;            
            case "VALIDADE":
                $return =  date('d/m/Y', $CertPriv['validTo_time_t'] );
                break;           
            case "CHAVE_PUBLICA":
                $return =  $PublicKey; //Array
                break;
            case "CHAVE_PRIVADA":
                $return =  $PrivateKey; //Array
                break;                       
        }
    }
    
    return $return;
}
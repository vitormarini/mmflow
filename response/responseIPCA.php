<?php
/*
 * Author: Vitor Hugo Nunes Marini
 * Data Criação: 29/11/2021
 * Request API Banco Central
 * https://dadosabertos.bcb.gov.br/dataset?q=ipca&sort=score+desc%2C+metadata_modified+desc
 */

include_once '../bd.php';
include_once '../funcoes.php';

#Retorno
$retorno = "OK";

//Buscando os dados da receita federal 
$url = "http://api.bcb.gov.br/dados/serie/bcdata.sgs.10844/dados?formato=json";
$url = "http://api.bcb.gov.br/dados/serie/bcdata.sgs.4448/dados?formato=json";

//$url = 'http://api.calendario.com.br/?json=true&ano=2022&ibge=3534609&token=dmhtYXJpbmlAZ21haWwuY29tJmhhc2g9MjgyMzEyOQ';
$data  = file_get_contents($url);

print"<pre>";
print_r($data);
exit;


$dataJ  = json_decode($data, true);

foreach ( $dataJ as $x ){
    echo $x;
}

exit;


$ch = curl_init($url);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
$resultado = json_decode(curl_exec($ch));

var_dump($resultado);



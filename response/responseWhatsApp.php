<?php
/*
 * Author: Vitor Hugo Nunes Marini
 * Data Criação: 22/04/2020
 * Request API Banco Central
 */

include_once '../bd.php';
include_once '../funcoes.php';

#Retorno
$texto = "*NOME* : VITOR HUGO NUNES MARINI *CPF: 403.224.348-40*";

echo "<script>window.location.replace('https://api.whatsapp.com/send?phone=+5518997192145&text={$texto}');</script>";
//print "https://api.whatsapp.com/send?phone=+5518997192145";
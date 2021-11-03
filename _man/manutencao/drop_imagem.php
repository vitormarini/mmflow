<?php
/* Descrição: Programa para Remover Imagem em Local Apropriado!
 * Author: Vitor Hugo Marini
 * Data: 04/07/2021
 */

session_start();

$name  = "user_{$_SESSION['user_id']}.jpg";                    //Definindo um novo nome para o arquivo
$dir   = "{$_SERVER["DOCUMENT_ROOT"]}/sys/dist/img/";          //Diretório para uploads     

unlink($dir.$name);

header("Location: /sys/index.php");
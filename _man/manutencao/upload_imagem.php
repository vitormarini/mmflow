<?php
/* Descrição: Programa para Gravar Imagem em Local Apropriado!
 * Author: Vitor Hugo Marini
 * Data: 04/07/2021
 */

session_start();

if(isset($_FILES['arquivo'])){
    $ext        = strtolower(substr($_FILES['arquivo']['name'],-4));    //Pegando extensão do arquivo
    $new_name   = "user_{$_SESSION['user_id']}.jpg";                    //Definindo um novo nome para o arquivo
    $dir        = "{$_SERVER["DOCUMENT_ROOT"]}/mmflow/dist/img/";                        //Diretório para uploads     
    copy($_FILES['arquivo']['tmp_name'], $dir.$new_name);
} 

header("Location: /mmflow/index.php");
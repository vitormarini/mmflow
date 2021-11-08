<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once './_aux.php';

session_start();

if ( $_SESSION['tela_atual'] !=  $_POST["xDestino"] ){
    $busca = "";
}else{
    $busca =  $_POST['xBuscas'] != "" ? $_POST['xBuscas'] : "";  
}

if ( $_POST['tipo'] == "movimentacao" ){       
    #Validando as buscas
    $buscas = explode("&",$_POST["xBuscas"]);
    
    
    $_SESSION['tela_atual']     = $_POST['xDestino'];    
    $_SESSION['op']             = $_POST['xOp'];    
    $_SESSION['id']             = $_POST['xId'];      
    $_SESSION['buscas']         = $busca;  
    
}
else if ( $_POST['tipo'] == "movim_menu" ){       
    #Validando as buscas
    $buscas = explode("&",$_SESSION["buscas"]);
    
    
    $_SESSION['tela_atual']     = $_POST['xDestino'];
    $_SESSION['menu_atual']     = $_POST['xMenu'];  
    $_SESSION['submenu_atual']  = $_POST['xSubmenu'];  
    $_SESSION['op']             = $_POST['xOp'];    
    $_SESSION['id']             = $_POST['xId'];      
    $_SESSION['buscas']         = $busca;  
    
}

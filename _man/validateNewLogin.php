<?php
/**
 * Programa responsável por fazer um novo usuário e redirecionar para a página do Index.
 * Autor: Vitor Hugo Nunes Marini
 * Data: 24/06/2021
 */
include_once "../_conection/_bd.php";
$pass = md5(trim($_POST['user_pass']));

$data = bdInsert(
        "t_user", 
        "     /*01*/ user_nome 
            , /*02*/ user_nickname 
            , /*03*/ user_email
            , /*04*/ user_pass
            , /*05*/ user_dt_nascimento 
            , /*06*/ user_tipo
            , /*07*/ user_quest_1 
            , /*08*/ user_quest_2 
            , /*09*/ user_resp_1
            , /*10*/ user_resp_2
            , /*11*/ user_celular 
            , /*12*/ terms",
        "     /*01*/ '{$_POST['user_nome']}' 
            , /*02*/ '{$_POST['user_nickname']}'      
            , /*03*/ '{$_POST['user_email']}'         
            , /*04*/ '{$pass}'          
            , /*05*/ '{$_POST['user_dt_nascimento']}' 
            , /*06*/ '{$_POST['user_tipo']}'         
            , /*07*/ '{$_POST['user_quest_1']}'       
            , /*07*/ '{$_POST['user_quest_2']}'       
            , /*08*/ '{$_POST['user_resp_1']}'       
            , /*10*/ '{$_POST['user_resp_2']}'        
            , /*11*/ '{$_POST['user_celular']}'      
            , /*12*/ '{$_POST['terms']}'"
        );

            
//Demonstra o retorno            
print $data;
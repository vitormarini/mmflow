<?php
/**
 * Programa responsável por validiar dados
 * Autor: Vitor Hugo Nunes Marini
 * Data: 24/06/2021
 */
include_once "../_conection/_bd.php";

#Validamos se o sistema já existe um outro registro com o mesmo dado
if ( $_POST['validate'] == "duplicate" ){
    
    $dados = bdRegisters("{$_POST['table']}", "{$_POST['params']}", "{$_POST['method']}", "'{$_POST['data']}'");    

    print $dados->fields['qtd'];
}


#Validação do botão de salvar
if ( $_POST['validate'] == "liberaBtnSalvar" ){
    
    #Montamos o array dos dados a serem inseridos
    $dados = explode("&",$_POST['dados']);
    
    #Quantidade de campos a ser validado
    $qtdValue = count($dados);
    
    $qtdValueExist = 0;
    
    #Varremos o array e começamos a validar cada item e seu respectivo valor
    foreach ($dados as $x){
        
        $value = explode("=",$x);
        
        if ( $value[1] != "" ){
            $qtdValueExist ++;
        }
        
    }    
    
    if ( $qtdValueExist == $qtdValue || isset($_POST['dados']) ){
        print "OK";
    }else{
        print "FALSO";
    }        
}


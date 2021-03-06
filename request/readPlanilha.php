<?php
/*
 * Author: Vitor Hugo Nunes Marini
 * Data Criação: 16/05/2021
 * Leitor de Planilha em formato CSV, onde interpretamos os valores e armazenamos no banco de dados.
 */
ini_set( "display_errors", "on" );
//error_reporting( E_ALL );

function readCSV($path){
    
    global $bd;
    
    $diretorio = dir($path);   
        
    while($arquivo = $diretorio -> read()){

        if ( !is_dir($path.$arquivo) ){           
            
            $arrArquivo = explode("_",$arquivo);
            
            $nomeArquivo = $arrArquivo[2]."_".$arrArquivo[3].".csv";
                        
            
            #Validamos se o registro já existe
            $buscaDados = $bd->Execute($sql = "SELECT id_t_producao_espuma FROM t_producao_espuma WHERE nome_arquivo = '{$nomeArquivo}';");                    
            
            if ( $buscaDados->RecordCount() > 0 ){
                $bloqueiaGravacao = true;
            }else{
                $bloqueiaGravacao = false;
            }
            
            $tipo   = explode("_",$arquivo)[2];
            $status = str_replace(".csv","",explode("_",$arquivo)[4]);                                
            
            if ( $bloqueiaGravacao ){
                $novoArquivo = str_replace(".csv",'',$arquivo)."_LIDO_SEM_REGISTRO.csv";   
                rename($path.$arquivo, $path.$novoArquivo); 
            }
            else if ( $tipo == "Bloco" && $status != "LIDO" && !$bloqueiaGravacao){

                #Resgatando informações dos arquivos
                $seq                = explode("_",$arquivo)[0];
                $dataHoraDownload   = explode("_",$arquivo)[1]." ".date('H:i:s');

                $diaProducao        = explode("-",explode("_",$arquivo)[5])[0];
                $mesProducao        = explode("-",explode("_",$arquivo)[5])[1];
                $anoProducao        = str_replace('.csv','',("20".explode("-",explode("_",$arquivo)[5])[2]));
                $dataProducao       = $anoProducao."-".$mesProducao."-".$diaProducao;               
                
                #Buscando os dados registrados na Planilha
                $dadosPlanilha = getPlanilhaCSV($path.$arquivo);             
                
                $i = 1;
                $sql = "";
                while ( $i <= count($dadosPlanilha) ){
                    
                    #Transformando os dados em Arraay
                    $arrDados = explode(",",$dadosPlanilha[$i]); 
                                                                         
                    #Recolhendo os dados do Bloco
                    $prod_1         = "POLIOL";         $sp_1   = str_replace('"','',$arrDados[3]);        $real_1 = str_replace('"','',$arrDados[4]);
                    $prod_2         = "COPOLIMERO";     $sp_2   = str_replace('"','',$arrDados[6]);        $real_2 = str_replace('"','',$arrDados[7]);
                    $prod_3         = "TDI";            $sp_3   = str_replace('"','',$arrDados[9]);        $real_3 = str_replace('"','',$arrDados[10]);
                    $prod_4         = "CLORETO";        $sp_4   = str_replace('"','',$arrDados[12]);       $real_4 = str_replace('"','',$arrDados[13]);
                    $densi          = strval(preg_replace( '/[^a-z0-9]/i', "",str_replace(array('"','                    ','                              ','                        '),'',$arrDados[14])));
                    $data           = str_replace("/","-",str_replace('"','',$arrDados[0]));
                    $horaProducao   = str_replace('"',"",$arrDados[1]);                                                             
                    
                    if ( $data != "" ) {
                        
                        #Montando estrutura SQL para inserir no banco
                        $sql .= 
                        "INSERT INTO public.t_producao_espuma
                            (   id_usuario                  ,   data_hora_download              ,   data_producao           ,   hora_producao
                            ,   mp_1                        ,   peso_formula_1                  ,   peso_real_1
                            ,   mp_2                        ,   peso_formula_2                  ,   peso_real_2
                            ,   mp_3                        ,   peso_formula_3                  ,   peso_real_3
                            ,   mp_4                        ,   peso_formula_4                  ,   peso_real_4
                            ,   densidade                   ,   nome_arquivo)
                         VALUES(94                          , '{$dataHoraDownload}'             , '{$data}'                 , '{$horaProducao}'
                            ,   '{$prod_1}'                 , '{$sp_1}'                         , '{$real_1}'
                            ,   '{$prod_2}'                 , '{$sp_2}'                         , '{$real_2}'
                            ,   '{$prod_3}'                 , '{$sp_3}'                         , '{$real_3}'
                            ,   '{$prod_4}'                 , '{$sp_4}'                         , '{$real_4}'
                            ,   '{$densi}'                  , '{$nomeArquivo}');";                    
                    }                     
                   
                    //Próximo item
                    $i++;
                }
                
                #Validando a inserção e renomeando os arquivos       
                if ( $sql != "" ){
                    if ( $bd->Execute($sql) ){ 
                        $novoArquivo = str_replace(".csv",'',$arquivo)."_LIDO.csv"; 
                        rename($path.$arquivo, $path.$novoArquivo);      
                    }
                }
            }    
        }
    }

    $diretorio -> close();      
    return "OK";
}

function getPlanilhaCSV($location){
    
    #Abrindo o arquivo
    $file = fopen($location, "r");
    $result = array();
    
    #Varrendo o arquivo e armazendo as linhas
    while (!feof($file)):
        if (substr(($result[$i] = fgets($file)), 0, 10) !== ';;;;;;;;') :
           $i++;
        endif;
    endwhile;
    
    fclose($file);
    return $result;
}
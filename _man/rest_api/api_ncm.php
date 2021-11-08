<?php
/* Descrição: API para busca de informações do CEP solicitado no cadastro do Correios
 * Data: 02/07/2021
 * Author: Vitor Hugo Marini 
 */
//Report de erros
error_reporting(E_ALL);

//Includes necessários
include_once "../../_conection/_conect.php";
include '../../_man/_aux.php';              

//Tipo de erro gerado pelo sistema
const ERRO_SISTEMA = 0;

$dataHoraConsulta = date("d/m/Y H:i:s");

try {

    //Tratamentos
    $cepBusca = str_replace(array(".","-"," "),"",$_POST["cep"]);

    $url  = "https://portalunico.siscomex.gov.br/classif/api/publico/nomenclatura/download/json";

    #Método de consumo da API não está funcionando na LocaWeb
    $arrayNCM = json_decode(file_get_contents($url), true);

    // print"<pre>";
    // print_r($arrayNCM);
    // exit;

    $dataLastUpdate = $arrayNCM["Data_Ultima_Atualizacao_NCM"];
    
    foreach ($arrayNCM["Nomenclaturas"] as $arr){
        
        #Montando as variáveis
        $codigo     = $arr["Codigo"];
        $descricao  = str_replace(array('"',"'"), '',$arr["Descricao"]);
        $dtInicio   = $arr["Data_Inicio"];
        $dtFim      = $arr["Data_Fim"];
        $tipoAto    = $arr["Tipo_Ato"];
        $numAto     = $arr["Numero_Ato"];
        $anoAto     = $arr["Ano_Ato"];
        
        
        #Consultando os valores na base
        $consulta = $bd->Execute($sql = "SELECT ncm_codigo, ncm_numero_ato FROM t_ncm WHERE ncm_codigo = '$codigo' AND ncm_numero_ato = '$numAto'");
        
        #Verificamos caso já exista faço um UPDATE caso contrário INSERT
        if ( $consulta->RecordCount() > 0 ){
            $sql = 
            "UPDATE public.t_ncm SET 
                    ncm_codigo          = '$codigo'
                ,   ncm_descricao       = '$descricao'
                ,   ncm_data_inicio     = databanco('$dtInicio')
                ,   ncm_data_fim        = databanco('$dtFim')
                ,   ncm_tipo_ato        = '$tipoAto'
                ,   ncm_numero_ato      = '$numAto'
                ,   ncm_ano_ato         = '$anoAto'
                ,   ncm_last_update     = databanco('$dataLastUpdate')
                ,   data_hora_consulta  = '$dataHoraConsulta' 
                WHERE ncm_codigo        = '$codigo';";
        }
        else{
            $sql = 
            "INSERT INTO public.t_ncm (
                    ncm_codigo              , ncm_descricao                 , ncm_data_inicio
                ,   ncm_data_fim            , ncm_tipo_ato                  , ncm_numero_ato
                ,   ncm_ano_ato             , ncm_last_update               , data_hora_consulta) 
             VALUES('$codigo'               , '$descricao'                  , databanco('$dtInicio')
                ,   databanco('$dtFim')     , '$tipoAto'                    , '$numAto'
                ,   '$anoAto'               , databanco('$dataLastUpdate')  , '$dataHoraConsulta');";
        }
        
        if (  !$bd->Execute($sql) ) throw new Exception ("Não foi possível gravar!".$sql);
    }
    
    
}

//Captura qualquer excessão que possa acontecer e as trata
catch(Exception $ex){

    //Verifica se foi um erro criado pelo sistema
    if($ex->getCode() == ERRO_SISTEMA) $origem = "ERRO_SISTEMA";
    else $origem = "ERRO";

    //Envia erro ao usuário
    print json_encode(
        array(
            "status"   => $origem,
            "mensagem" => $ex->getMessage()
        )
    );

}

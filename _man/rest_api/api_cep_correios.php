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

// echo"Vitor";

try {

    //Tratamentos
    $cepBusca = str_replace(array(".","-"," "),"",$_POST["cep"]);

    $urlHttp  = "http://viacep.com.br/ws/{$cepBusca}/json/";
    $urlHttps = "https://viacep.com.br/ws/{$cepBusca}/json/";

    #Método de consumo da API não está funcionando na LocaWeb
    // $dadosRetorno = json_decode(file_get_contents($urlHttps), true);


    /**
     * Aqui testamos a conexão HTTPS
     */
    $url = $urlHttps;
 
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $dadosRetorno = json_decode(curl_exec($ch));

    

    #TRATANDO AS CHAMADAS
    if ( count($dadosRetorno) > 0 ){
        $url = $urlHttps;
    }else{
        $url = $urlHttp;
    }        
    
    //Obtem os dados registrados nos correios para o cep utilizando a api Postmon - The Postman
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $dadosCep = json_decode(curl_exec($ch),true);     

    // print"<pre>";
    // print_r($dadosCep);
    // exit;

    //Verifica se o item a ser deletado é chave estrangeira de alguma tabela
    if(empty($dadosCep)) throw new Exception("CEP inválido. Por favor informe outro CEP!", ERRO_SISTEMA);  

    //Obtem o filtro da respectiva cidade no nosso banco.        
    if(!empty($dadosCep['ibge'])) $where = " WHERE municipio_codigo = '{$dadosCep["ibge"]}' ";
    else                          $where = " WHERE municipio_nome ILIKE '%{$dadosCep["localidade"]}%' ";

    $dadosCidadeBanco = $bd->Execute($sql = "SELECT municipio_id, municipio_codigo FROM t_municipios_br {$where}");
    $dadosPais        = $bd->Execute($sql = "SELECT paises_id FROM t_paises WHERE pais_codigo = '1058'");

    //Retorna dados a aplicação
    print json_encode(
        array(
            "status" => "SUCCESS",
            "dados"  => array(
                "idCidade"   => $dadosCidadeBanco->fields["municipio_id"],
                "cidade"     => $dadosCep["localidade"],
                "cod_cidade" => $dadosCidadeBanco->fields["municipio_codigo"],
                "cep"        => $dadosCep["cep"],
                "logradouro" => $dadosCep["logradouro"],
                "bairro"     => $dadosCep["bairro"],
                "estado"     => $dadosCep["uf"],
                "pais"       => "Brasil",
                "id_pais"    => $dadosPais->fields["pais_id"]
            )
        )
    );
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

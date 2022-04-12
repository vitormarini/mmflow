<?php
/**
 * ## Programa PHP que auxilia e colabora no desenvolvimento. 
 * Description: Aqui ficarão as funções e auxiliáres prontos para consumo, sem que haja a necessidade recriar em outros locais.
 * Autor: Vitor Hugo Marini
 */

/**
 * Retira caracteres especiais da string passada
 * @param String $texto texto que contem os caracteres especiais
 * @return String Retorna a string com os respectivos correspondentes para os caracteres especiais
 */
function retiraAcentos($texto){

    $original = array(
        "á",   "à",   "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", 
        "ô",   "õ",   "ö", "ú", "ù", "û", "ü", "ç", "ª", "º", "Á", "À", "Â", "Ã", "Ä", 
        "É",   "È",   "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù",
        "Û",   "Ü",   "Ç", "(", ")", "<", ">", ";", "?", "*", "&", "%", "#", "@", "!",
        "ï¿½", "i¿½", "$", "{", "}", "[", "]", "=", "'", "´", ","
    );

    $troca = array(
        "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o",
        "o", "o", "o", "u", "u", "u", "u", "c", "a", "o", "A", "A", "A", "A", "A",
        "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", 
        "U", "U", "C", "",  "",  "",  "",  "",  "",  "",  "",  "",  "",  "",  "",  
        "a", "a", "",  "",  "",  "",  "",  "",  "",  "",  ""
    );

    return str_replace($original, $troca, $texto);

}

/**
 * Formata o valor passado
 * @deprecated Será retirada em breve. Utilize as funções de moeda e number_format para mesmo fim.
 * @param String $valor Valor a ser formatado
 * @return string Valor formatado
 */
function formataValores($valor){        
    switch(strlen($valor)){
        case 4 : $valor = substr($valor, 0, 2) . "," . substr($valor, 2, 2); break;
        case 5 : $valor = substr($valor, 0, 3) . "," . substr($valor, 3, 2); break;
        case 6 : $valor = substr($valor, 0, 1) . "." . substr($valor, 1, 3) . "," . substr($valor, 4, 2); break;
    }        
    return $valor;        
}

/**
 * Retira possíveis espaços dos valores passados por $_POST
 */
function retiraEspacos(){
    foreach($_POST as $chave => $valor){
        $_POST[$chave] = trim($valor);
    }
}    

/**
 * Converte caracteres
 */
function converteCaracteres(){
    retiraEspacos();
    foreach($_POST as $chave => $valor ){
        $_POST[$chave] = utf8_decode(str_replace("'", "", $valor));
    }
}

/**
 * Retira palavras reservadas, evitando SQL Injection.
 * @param String $texto String a ser tratada
 * @return String Retorna string tratada
 */
function limparTexto($strTexto){

    converteCaracteres();

    $strTexto = preg_replace( "/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/i", "", $strTexto );
    $strTexto = str_replace( array( "<", ">", "\\", "/", "=", "'", "?" ), "", $strTexto );
    $strTexto = trim( $strTexto );
    $strTexto = strip_tags( $strTexto );
    $strTexto = addslashes( $strTexto );

    return $strTexto;

}

/**
 * Coloca todos os valores do $_POST em maiúsculo
 */
function colocaMaiusculo(){
    foreach($_POST as $chave => $valor){
        $_POST[$chave] = strtoupper($valor);
    }
}

    date_default_timezone_set('America/Sao_Paulo');
    
    //Constantes para a função de máscara
    const RETIRA_MASCARA = 1;
    const MASCARA_CNPJ   = 2;
    const MASCARA_CPF    = 3;
    const MASCARA_CEP    = 4;
    const MASCARA_RG     = 5;
    const MASCARA_FONE   = 6;
    
    //Constantes para a função trataQuebraLinha
    const RECUPERACAO = 1;
    const ENVIO       = 2;
    
    /**
     * Converte a data de (YYYY-mm-dd) MySql para (dd-mm-YYYY) Brasil
     * @param string $dt Data a ser convertida
     * @return string Data formatada
     */
    function data_format(&$dt){
        return date('d/m/Y', strtotime($dt));
    }
    
    /**
     * Alias para a função data_format.<br>
     * Formata uma data no formato brasileiro.
     * @param string $data Data a ser formatada
     * @return string Data em formato brasileiro
     */
    function dataBrasil(&$data){
        return data_format($data);
    }
    
    /**
     * Converte a data de (dd-mm-YYYY) MySql para (YYYY-mm-dd) 
     * @param string $dt Data a ser convertida
     * @return string Data formatada
     */
    function data_format_mysql(&$dt){
        $dt = str_replace('/', '-', $dt);
        return date('Y-m-d', strtotime($dt));
    }
    
    /**
     * Alias para a função data_format_mysql.<br>
     * Formata uma data no formato do mysql (Y-m-d).
     * @param string $data Data a ser formatada
     * @return string Data em formato mysql
     */
    function dataBanco(&$data){
        return data_format_mysql($data);
    }
    
    /**
     * Alias para a função data_format_mysql.<br>
     * Formata uma data no formato do mysql (Y-m-d).
     * @param string $data Data a ser formatada
     * @return string Data em formato mysql
     */
    function dataHoraBanco($data){
        return date("Y-m-d H:i:s", strtotime(str_replace("/", "-", $data)));
    }
    
    /**
     * Retorna a diferença em dias entre duas datas...
     * @param Date $data_inicial A data inicial a ser comparado.
     * @param Date $data_final A data final a ser comparado.
     * @param String $formato_data Formato em que as datas estão. Ex: 'd/m/Y' ou 'd-m-Y' e etc...
     * @return Interger Retorna o valor da diferença em dias em caso de sucesso, e FALSE em caso de erro.
     */
    function diasEntreDatas($data_inicial, $data_final, $formato_data = null){  //Versão Beta.

        $formato = (!is_null($formato_data)) ? $formato_data : 'd/m/Y';

        $datetime1 = DateTime::createFromFormat($formato, $data_inicial);
        $datetime2 = DateTime::createFromFormat($formato, $data_final);
        $interval = $datetime1->diff($datetime2);
        return $interval->days;

    }
    
    /**
     * Converte os valores unitários tanto para moeda americana como brasileira...
     * @param string $get_valor - Valor a ser tratado
     * @return string Valor tratado
     */
    function moeda($get_valor) {
	$source = array('.', ',');
	$replace = array('', '.');
	$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
	return $valor; //retorna o valor formatado para gravar no banco
    }
    
    /**
     * Converte os valores unitários tanto para moeda americana como brasileira...
     * @param string $get_valor - Valor a ser tratado
     * @return string Valor tratado
     */
    function moeda_brasileira($get_valor) {
	$source = array('.', ',');
	$replace = array(',', '.');
	$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
	return $valor; //retorna o valor formatado para gravar no banco
    }
          
    /**
     * Retira máscara ou formata o dado passado para CNPJ, CPF, CEP, RG e TELEFONE.
     * @param string $objeto Dado a ser aplicado ou retirado a máscara
     * @param int $tipo Operação a ser realizada com os dados. Pode ser <b>RETIRA_MASCARA</b>, <b>MASCARA_CNPJ</b>, 
     * <b>MASCARA_CPF</b>, <b>MASCARA_CEP</b>, <b>MASCARA_RG</b>, <b>MASCARA_FONE</b>
     * @return string Dado formatado
     */
    function mascaras($objeto, $tipo){
        
        //Tratamentos
        $remover = array(".", "-", "/", "(", ")", " ");       
        $dados   = retira($remover, $objeto);
        
        //Retorna string vazia caso seja um valor validado como vazio
        if(empty($objeto)) return "";        
        
        //Valida o tipo de operação
        switch($tipo){
            
            case RETIRA_MASCARA :{ return $dados; }break;
            case MASCARA_CNPJ   :{ return substr($dados, 0, 2) . "." . substr($dados, 2, 3) . "." . substr($dados, 5, 3) . "/" . substr($dados, 8, 4) . "-" . substr($dados, 12, 2); }break;
            case MASCARA_CPF    :{ return substr($dados, 0, 3) . "." . substr($dados, 3, 3) . "." . substr($dados, 6, 3) . "-" . substr($dados, 9, 2)                              ; }break;
            case MASCARA_CEP    :{ return substr($dados, 0, 2) . "." . substr($dados, 2, 3) . "-" . substr($dados, 5, 3)                                                           ; }break;
            case MASCARA_RG     :{ return substr($dados, 0, 2) . "." . substr($dados, 2, 3) . "." . substr($dados, 5, 3) . "-" . substr($dados, 8, 1)                              ; }break;            
            case MASCARA_FONE   :{ return mascaraTelefone($dados)                                                                                                                  ; }break;
            
        }
       
    }
    
    /**
     * Formata números telefônicos no formato ddd+número
     * @param string $objeto Número a ser formatado (somente digitos)
     */
    function mascaraTelefone($objeto){ 
        
        //Retira qualquer possível formatação existente
        $numero = mascaras($objeto, RETIRA_MASCARA);

        //Formata numero passado
        if(empty($numero)) return $numero;
        else if(substr($numero,0,4) == "0800") return substr($numero,0,4) .' '. substr($numero,4,3) .' '. substr($numero,7,4);
        else if(strlen($numero) <= 10) return '('.substr($numero,0,2).') '.substr($numero,2,4).'-'.substr($numero,6,4);
        else return '('.substr($numero,0,2).') '.substr($numero,2,5).'-'.substr($numero,7,4);
        
    }
    
    /**
     * Formata o número do lançamento bancário no formato 999.999.999
     * @param string $objeto Número a ser formatado (somente digitos)
     */
    function mascaraLancamentoBancario($objeto){        
        return substr($objeto,0,3).'.'.substr($objeto,3,3).'.'.substr($objeto,6,3);
    }
    
    /**
     * Retira todas as ocorrências do elemento de uma string ou array. 
     * @param mixed $remover String ou Array contendo o elemento a ser removido do objeto
     * @param mixed $objeto String ou Array de onde o elemento será retirado.
     * @return string String ou Array sem ocorrência do elemento passado
     */
    function retira($remover, $objeto){
        return str_replace($remover, "", $objeto);        
    }
    
    /**
     * Verifica se uma data proveniente do banco é nula (0000-00-00)
     * @param string $data - Data a ser verificada
     * @param boolean $dataAtual - Indica se a data atual deve ser retornado em caso de data nula proveniente do banco.
     * @param boolean $incluiHora - Indica se a hora está presente no parâmetro $data informado ou será retornado quando a data for nula proveniente do banco.
     * @return string Data formatada, vazio se parâmetro $dataAtual for falso, ou data atual caso o parâmetro $dataAtual seja verdadeiro.
     */
    function validaData($data, $dataAtual = false, $incluiHora = false){
        if(!empty(trim($data)) && trim($data) !== '0000-00-00' && !$incluiHora) return date("d/m/Y", strtotime($data));
        else if(!empty(trim($data)) && trim($data) !== '0000-00-00' && $incluiHora) return date("d/m/Y H:i:s", strtotime($data));
        else if($dataAtual && !$incluiHora) return date("d/m/Y");
        else if($dataAtual && $incluiHora) return date("d/m/Y H:i:s");
        else return "";
    }
    
    /**
     * Coloca a primeira letra de todas as palavras em maiúscula.<br>
     * Por padrão ignorando as preposições presentes no texto.
     * Para não ignorar preposições, passe false no segundo parametro.
     * @param String $texto Texto a ser capitalizado
     * @param boolean $ignorar Ignora ou não preposições - Padrao: True
     * @return String Texto capitalizado
     */
    function capitalize($texto, $ignorar = true){
        
        $capitalize = ucwords(strtolower($texto));
        
        //Verifica se deve deixar as preposições normais
        if(!$ignorar) return $capitalize;
        
        //Preposições a serem mantidas   
        $antes = array( "E", "De", "Da", "Do", "Das", "Dos");
        $depois = array( "e", "de", "da", "do", "das", "dos");
        
        return str_replace($antes, $depois, $capitalize);       
 
    }
    
    
    /**
     *  Cálcula digito verificador para número de pedido.     
     * @example calculaDigitoVerificador(2014000001); 
     * 
     * @param int $numero_pedido Número a ser cálculado o digito verificador.
     * 
     * @return int Número do pedido com o digito verificador.
     */
    function calculaDigitoVerificador($numero_pedido){
        $peso = "1212121212";        
        $soma = 0;
       
        for($i = 0; $i < 10; $i++){ 
            $valor = substr($numero_pedido,$i,1) * substr($peso,$i,1); 

            if($valor>9) $soma = $soma + substr($valor,0,1) + substr($valor,1,1);
            else $soma = $soma + $valor;

        }

        $dv = (10 - ($soma % 10));
        if(($soma % 10)==0)$dv = 0;
        return $numero_pedido.$dv;
    }

    function extenso($valor = 0, $maiusculas = false) {

        $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
        $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");

        $z = 0;
        $rt = "";
        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);

        for ($i = 0; $i < count($inteiro); $i++)
            for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
                $inteiro[$i] = "0" . $inteiro[$i];

        $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
        for ($i = 0; $i < count($inteiro); $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
                $ru) ? " e " : "") . $ru;
            $t = count($inteiro) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($valor == "000")
                $z++;
            elseif ($z > 0)
                $z--;
            if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
                $r .= (($z > 1) ? " de " : "") . $plural[$t];
            if ($r)
                $rt = $rt . ((($i > 0) && ($i <= $fim) &&
                    ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        if (!$maiusculas) {
            return($rt ? $rt : "zero");
        } else {

            if ($rt)
                $rt = ereg_replace(" E ", " e ", ucwords($rt));
            return (($rt) ? ($rt) : "Zero");
        }
    }
    
    /**
     * Aplica a máscara para o documento informado. Utiliza $pessoa para aplicar a máscara
     * correta ou calcula o tamanho do documento passado para determinar qual máscara será
     * usada. Quando utlizando o tamanho do documento a máscara será definida seguindo o 
     * seguinte princípio: 14 caracteres para CNPJ, 11 para CPF e o restante Exterior.
     * 
     * @param String $documento Número do documento onde aplicar a máscara
     * 
     * @param Char $pessoa Pessoa do documento, podendo ser: <br/> F - Pessoa Física<br/> 
     * J - Pessoa jurídica<br/> E - Exterior
     * 
     * @return String Retorna o documento com a máscara adequada aplicada ou string vazia
     * em caso de erro.
     */
    function formataCpfCnpj($documento, $pessoa = null){
        
        //Despresa valores maiores que 14, retornando erro
        if(strlen($documento) > 14) return "";       
            
        //Aplica máscara para pessoa física
        if($pessoa == "F" || strlen($documento) == 11) 
            return substr($documento, 0, 3). '.' .substr($documento, 3, 3). '.' .substr($documento, 6, 3). '-' .substr($documento, 9, 2);

        //Aplica máscara para pessoa jurídica
        else if($pessoa == "J" || strlen($documento) == 14)
            return substr($documento, 0, 2). '.' .substr($documento, 2, 3). '.' .substr($documento, 5, 3). '/' .substr($documento, 8, 4). '-' .substr($documento, 12, 2);

        //Devolve documento sem máscara. Nesse caso máscara não disponível
        else if($pessoa == "E" || strlen($documento) < 11 ) return $documento;
        
    }
    
    /**
     * Retorna a máscara do CEP
     * @param type $documento
     * @return type
     */
    function formataCep($documento){
        
        return substr($documento, 0, 2).".".substr($documento, 2, 3)."-".substr($documento, 5);
        
    }
    
    /**
     * Calcula o dígito verificador do código de barras - padrão EAN-13
     * @param string $numero Código de Barras
     * @return int Retorna o dígito verificador para o código passado
     */
    function digitoVerificadorEan13($numero){
        
        //Separa todos os digitos do código de barras
        $numeroSeparado = str_split($numero);
        
        $somaPar = $somaImpar = 0;
       
        //Soma as posições pares e ímpares
        foreach($numeroSeparado as $indice => $valor){
            
            //Verifica se o indice é par ou impar
            if(($indice % 2) == 0) $somaImpar += $valor;
            else $somaPar += $valor;
            
        }
        
        //Calcula o resto da divisão
        $resto = (($somaPar * 3) + $somaImpar) % 10;
        
        //Determina dígito verificador
        return  $dv = ($resto != 0) ? (10 - $resto) : $resto;
        
    }
    
    /**
     * Coloca null nos campos vazios nos script enviados ao banco
     */
    function replaceEmptyFields($script){
        return str_replace("''", "NULL", $script);
    }

    /**
     * Verifica se o valor passado é válido e formata o valor no padrão brasileiro.
     * Permite alterar a formatação do valor passando a quantidade de casas e os separadores de dezena e milhar.
     * @param float $valor Valor a ser validado
     * @param int $casasDecimais [Opcional] Número de casas decimais para formatar o valor passado
     * @param string $separadorDecimal [Opcional] Separador de casas decimais
     * @param string $separadorMilhar [Opcional] Separador de casas de milhar
     */
    function validaFormataValor($valor, $casasDecimais = 2, $separadorDecimal = ",", $separadorMilhar = "."){
        
        if(empty($valor)) return "0,00"; 
        else return number_format($valor, $casasDecimais, $separadorDecimal, $separadorMilhar);
        
    }
    
    /**
     * Trata a recuperação e envio do banco para campos texto quando existem quebras de linhas.
     * @param String $dado Dado a ser tratado
     * @param int $tipo Tipo de tratamento a ser realizado. Pode ser RECUPERACAO ou ENVIO
     */
    function trataQuebraLinha($dado, $tipo){
        
        if($tipo == RECUPERACAO) return str_replace("\\n", chr(13), $dado);
        else return str_replace(chr(13), "\\n", $dado);
        
    }
    
    /**
     * Retorno o número desejado sem formatações e com a quantidade corretas de casas depois da vírgula.
     * @param float $valor Valor a ser tratado. 
     * @param int $casasDecimais Quantidade de casas decimais desejada.
     * @return String Valor corrigido.
     */
    function valorIntegracao($valor, $casasDecimais = 2){        
        return number_format($valor, $casasDecimais, "", "");        
    }
    function valorIntegracao2($valor, $casasDecimais = 4){        
        return number_format($valor, $casasDecimais, "", "");        
    }
   
    
    function dataIntegracao($data){        
        return substr($data, 4, 4) . "-" . substr($data, 2, 2) . "-" . substr($data, 0, 2) . " " . 
               substr($data, 8, 2) . ":" . substr($data, 10, 2) . ":". substr($data, 12, 2);        
    }
    
    /**
     * Verifica se um valor pertence ao array passado. Usado para validação dos 
     * checkbox do cadastro de perfil.
     * @param array $dados Local onde será realizado a busca.
     * @param mixed $valor Valor procurado
     * @return string Retorna 'checked' caso encontrado ou vazio caso contrário
     */
    function verificaCheck($dados, $valor, $verificaDesabilitado = false){
        
        $retorno = "";
        
        //Verifica se o checkbox deverá ser marcado quando for módulo ou ação
        if(array_search($valor, $dados) !== false) $retorno = "checked";
                    
        //Verifica se deverá marcar como desabilitado
        if($verificaDesabilitado) $retorno .= " disabled";

        //Retorna valor processado
        return trim($retorno);
        
    }
    
    
    function dataExtenso($maiuscula = false, $cidade = '', $data = '') {
        if($data == '') {
            $dia = date('d');
            $mes = date('m');
            $ano = date('Y');
        }
        else {
            $dia = substr($data, 0, 2);
            $mes = substr($data, 3, 2);
            $ano = substr($data, 6, 4);
        }

        $cidade = $cidade != '' ? $cidade . ',' : '';

        $meses = array(
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro');

        
            $retorno = $cidade . str_pad($dia, 2, '0', STR_PAD_LEFT) . ' de ' . $meses[$mes] . ' de ' . $ano;
        
            return $retorno;
    }
        
    /**
     * Função que retira todos os caracteres especiais da variável
     */
    function retira_caracteres($var){
        //Sempre tratar a variável como maiúscula.
        $var     = strtoupper($var);        
        
        //Pontuações e Caracteres especiais.
        $var     = str_replace(array(",",".","-","_","+","=","-","/","\\","@","#","$","%","&","*","(",")","[","]","{","}","?","!",";",":"),"",$var);
        
        //Remove espaços extras
        $var     = str_replace("  "," ",$var);
        
        //Alfabeto
        //$var     = str_replace(array("a","ã","á","â","à","Ã","Á","Â","À"),"A",$var);
        //$var     = str_replace(array("c","ç"),"C",$var);
        //$var     = str_replace(array("e","é","è","ê","É","È","Ê"),"E",$var);
        //$var     = str_replace(array("i","í","ì","Í","Ì"),"I",$var);
        //$var     = str_replace(array("o","ó","ò","õ","ô","Ó","Ò","Ô","Õ"),"O",$var);        
        //$var     = str_replace(array("u","ú","ù","û","Ú","Ù","Û"),"U",$var);
                                        
        return $var;
    }
    
    function paginacao( $strTela, $intPagina, $intLimite, $intTotal, $tipoRetorno = "TELA") {
        $intProxima    = $intPagina + 1;
        $intAnterior   = $intPagina - 1;
        $intUltima     = ceil( $intTotal / $intLimite );
        $intPenultima  = $intUltima - 1;
        $intAdjacentes = 2;
        
        $strTela .= ( isset($_GET['txtNome']) ? "&txtNome={$_GET['txtNome']}" : (isset($_GET["filtro"]) ? "&filtro={$_GET['filtro']}" : "") );
        $strTela .= ( isset( $_GET['txtSituacao'] ) ? "&txtSituacao={$_GET['txtSituacao']}" : "" );

        $strPaginacao = "
                <nav>
                   <ul class='pagination'>";
        if ( $intPagina > 1 ) {
            $strPaginacao .= "<li aria-label='Anterior'><a href='?{$strTela}&p={$intAnterior}'><span aria-hidden='true'>&laquo;</span></a></li>";
        }
        
        if ( $intUltima <= 7 ) {
            for ( $intCont = 1; $intCont < ( $intUltima + 1 ); $intCont++ ) {
                $strAtiva      = ( $intCont == $intPagina ? "class='active'" : '' );
                $strPaginacao .= "    <li $strAtiva><a href='?$strTela&p={$intCont}'>{$intCont}</a></li>";
            }
        }
        
        if ( $intUltima > 7 ) {
            if ( $intPagina < ( 1 + ( 2 * $intAdjacentes ) ) ) {
                for ( $intCont = 1; $intCont < ( 2 + ( 2 * $intAdjacentes ) ); $intCont++ ) {
                    $strAtiva      = ( $intCont == $intPagina ? "class='active'" : '' );
                    $strPaginacao .= "    <li $strAtiva><a href='?$strTela&p={$intCont}'>{$intCont}</a></li>";
                }
                $strPaginacao .= "    <li><a>...</a></li>";
                $strPaginacao .= "    <li><a href='?$strTela&p={$intPenultima}'>{$intPenultima}</a></li>";
                $strPaginacao .= "    <li><a href='?$strTela&p={$intUltima}'>{$intUltima}</a></li>";
            } 
            else if ( $intPagina > ( 2 * $intAdjacentes ) && $intPagina < ( $intUltima - 3 ) ) {
                $strPaginacao .= "    <li><a href='?$strTela&p=1'>1</a></li>";
                $strPaginacao .= "    <li><a href='?$strTela&p=2'>2</a></li>";
                $strPaginacao .= "    <li><a>...</a></li>";
                for ( $intCont = ( $intPagina - $intAdjacentes ); $intCont <= ( $intPagina + $intAdjacentes ); $intCont++) {
                    $strAtiva      = ( $intCont == $intPagina ? "class='active'" : '' );
                    $strPaginacao .= "    <li $strAtiva><a href='?$strTela&p={$intCont}'>{$intCont}</a></li>";
                }
                $strPaginacao .= "    <li><a>...</a></li>";
                $strPaginacao .= "    <li><a href='?$strTela&p={$intPenultima}'>{$intPenultima}</a></li>";
                $strPaginacao .= "    <li><a href='?$strTela&p={$intUltima}'>{$intUltima}</a></li>";
            } 
//            else if ( $intUltima == 7 ) {
//                for ( $intCont = 1; $intCont <= $intUltima; $intCont++ ) {
//                    $strAtiva      = ( $intCont == $intPagina ? "class='active'" : '' );
//                    $strPaginacao .= "    <li $strAtiva><a href='?$strTela&p={$intCont}'>{$intCont}</a></li>";
//                }
//            }
            else {
                $strPaginacao .= "    <li><a href='?$strTela&p=1'>  1  </a></li>";
                $strPaginacao .= "    <li><a href='?$strTela&p=2'>  2  </a></li>";
                $strPaginacao .= "    <li><a>...</a></li>";
                for ( $intCont = ( $intUltima - ( 1 + ( 2 * $intAdjacentes ) ) ); $intCont <= $intUltima; $intCont++ ) {
                    $strAtiva      = ( $intCont == $intPagina ? "class='active'" : '' );
                    $strPaginacao .= "    <li $strAtiva><a href='?$strTela&p={$intCont}'>  {$intCont}  </a></li>";
                }
            }
        }
        
        if ( $intProxima <= $intUltima && $intUltima > 2) {
            $strPaginacao .= "<li aria-label='Pr&oacute;xima'><a href='?{$strTela}&p={$intProxima}'><span aria-hidden='true'>&raquo;</span></a></li>";
        }
        $strPaginacao .= "    
                   </ul>
               </nav>";
        
        if($tipoRetorno == "TELA") print $strPaginacao;
        else return $strPaginacao;
    }
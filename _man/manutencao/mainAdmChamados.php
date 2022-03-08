<?php
/* Descrição: Back-End adm_empresas.php
 * Author: Vitor Hugo Marini
 * Data: 16/02/2022
 */

include_once '../../_conection/_conect.php';
include_once '../../_man/_aux.php';

session_start();

$op         = $_SESSION['op'];          //Ação
$p          = $_SESSION['p'];           //Página da Busca
$r          = $_SESSION['tela_atual'];  //Tela Atual
$b          = $_SESSION['buscas'];      //Filtros de buscas
$id         = $_SESSION['id'];          //Filtros de buscas
$user_id    = $_SESSION['user_id'];     //usuário
$dados      = $_POST;
$retorno    = "ERRO";
$files_arq  = "";

if( !empty($_FILES) ){
    $_SESSION['files'] = $_FILES ;
    $retorno    = "OK";
}

#Validando os dados Cadastrais
$c_tipo         = $dados['chamado_tipo'];
$c_departamento = $dados['chamado_departamento'];
$c_responsavel  = trim($dados['c_reponsavel_id']);
$c_assunto      = trim($dados['chamado_assunto']);
$c_servico      = trim($dados['chamado_servico']);
$m_descricao    = trim($dados['chamado_descricao']);
$data_atual     = date("Y-m-d H:s:i");

#INSERT
if ( $op == "insert" && empty($_FILES) ){
    $sql = "
    INSERT INTO t_chamados (
          c_user_id             , c_data_abertura       , c_status          , c_tipo
        , c_departamento        , c_responsavel_id      , c_assunto         , c_servico   
        , c_ciente
    )VALUES(
          {$user_id}            , '{$data_atual}'       , 'ABERTO'          , '{$c_tipo}'
        , '{$c_departamento}'   , '{$c_responsavel}'    , '{$c_assunto}'    , '{$c_servico}'
        , 'N'
    );";                
        
    if ( $bd->Execute(replaceEmptyFields($sql)) ){
        $id = $bd->Insert_ID();
        
        $l_query .= $sql;
        
        $sqlMov = "
        INSERT INTO t_chamados_mov (
              m_chamados_id     , m_user_id         , m_data_hora           , m_descricao
        )VALUES(            
              {$id}             , {$user_id}        , '{$data_atual}'       , '{$m_descricao}'  
        );";
        
        $l_query .= $sqlMov;      
        $bd->Execute(replaceEmptyFields($sqlMov));
    }
    anexo($_SESSION['files']['fileUpload'],$id,$user_id);
    functionLog($id, $data_atual, "INSERT", $l_query, $user_id);
    
    $retorno = "OK";
}

if( $op == "edit" && empty($_FILES)){
    if( $_POST['op'] == "mov"){
        $sql = "
        INSERT INTO t_chamados_mov (
              m_chamados_id     , m_user_id         , m_data_hora           , m_descricao
        )VALUES(            
              {$id}             , {$user_id}        , '{$data_atual}'       , '{$_POST['adicao_conversa']}'  
        );";
              
        $l_operacao = "MOVIMENTACAO";
    }else{
        $sql = "UPDATE t_chamados SET c_status = '{$dados['chamado_status']}', c_prioridade = '{$dados['chamado_prioridade']}' WHERE chamados_id = {$id}";
    }
    
    $l_query .= $sql;      
    if($bd->Execute(replaceEmptyFields($sql))){
        $retorno = "OK";
        functionLog($id, $data_atual, $l_operacao, $l_query, $user_id);
    }        
}

if( $_POST['fileUpload'] == "op=upload_arquivo" && $op == "edit" ){
    $files_arq = $_FILES['fileUpload'];
    anexo($files_arq,$id,$user_id);
}

if( $_POST['op'] == "ciencia" ){
    if($bd->Execute("UPDATE t_chamados SET c_ciente = 'S' WHERE chamados_id = {$_POST['id']};")){
        $retorno = "OK";
    }
}

print $retorno;

function functionLog($id, $l_data_hora, $l_operacao, $l_query, $l_user_id){
    global $bd;    
    
    $l_query = str_replace("'",'"', $l_query);
    
    $bd->Execute("
    INSERT INTO t_chamados_log(
        l_chamados_id   , l_data_hora         , l_operacao       , l_query          , l_user_id
    )VALUES(
        {$id}           , '{$l_data_hora}'    , '{$l_operacao}'  , '{$l_query}'     , {$l_user_id}
    );");
}

function anexo($files_arq,$id,$user_id){
    global $bd;    
    global $data_atual;

    if(isset($files_arq)){
        
        $name = $files_arq['name'];
        $dir  = "{$_SERVER["DOCUMENT_ROOT"]}/mmflow/dist/arq_chamados/{$name}";  
        copy($files_arq['tmp_name'], $dir);
        
        if( !empty($name) ){
            $sql = "INSERT INTO t_chamados_anexos(chamados_id, a_nome, a_caminho)VALUES('{$id}', '{$name}', '{$dir}');";        
            
            if($bd->Execute(replaceEmptyFields($sql))){                
                $retorno = "OK";
                $id_anexo = $bd->Insert_ID();
                functionLog($id, $data_atual, "ANEXO_ARQUIVO-{$id_anexo}", $sql, $user_id);
            }
        }
    }
}